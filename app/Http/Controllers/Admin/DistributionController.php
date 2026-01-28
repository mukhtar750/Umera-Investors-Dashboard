<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Distribution;
use App\Models\Offering;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class DistributionController extends Controller
{
    public function index()
    {
        $distributions = Distribution::with('offering')->latest()->paginate(10);

        return view('admin.distributions.index', compact('distributions'));
    }

    public function create()
    {
        $offerings = Offering::where('status', '!=', 'coming_soon')->get();

        return view('admin.distributions.create', compact('offerings'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'offering_id' => 'required|exists:offerings,id',
            'title' => 'required|string|max:255',
            'amount_per_unit' => 'required|numeric|min:0',
        ]);

        Distribution::create($validated);

        return redirect()->route('admin.distributions.index')->with('success', 'Distribution created successfully.');
    }

    public function process(Distribution $distribution)
    {
        if ($distribution->status === 'processed') {
            return back()->with('error', 'This distribution has already been processed.');
        }

        DB::transaction(function () use ($distribution) {
            $allocations = Allocation::where('offering_id', $distribution->offering_id)
                ->where('status', 'active')
                ->get();

            $totalDistributed = 0;

            foreach ($allocations as $allocation) {
                $amount = $allocation->units * $distribution->amount_per_unit;

                // Credit User Wallet
                $user = $allocation->user;
                $user->wallet_balance += $amount;
                $user->save();

                // Create Transaction Record
                Transaction::create([
                    'user_id' => $user->id,
                    'type' => 'deposit', // Or 'distribution' if we add that type, stick to deposit for now or 'other'
                    'amount' => $amount,
                    'description' => "Distribution: {$distribution->title} - {$distribution->offering->name}",
                    'status' => 'completed',
                    'reference' => 'DIST-'.$distribution->id.'-'.$user->id,
                ]);

                $totalDistributed += $amount;
            }

            $distribution->update([
                'status' => 'processed',
                'total_amount' => $totalDistributed,
                'processed_at' => now(),
            ]);
        });

        return redirect()->route('admin.distributions.index')->with('success', 'Distribution processed successfully. Wallets credited.');
    }
}
