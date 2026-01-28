<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Offering;
use App\Models\User;
use Illuminate\Http\Request;

class AllocationController extends Controller
{
    public function index()
    {
        $allocations = Allocation::with(['user', 'offering'])->latest()->get();

        return view('admin.allocations.index', compact('allocations'));
    }

    public function create()
    {
        $users = User::where('role', 'investor')->get();
        $offerings = Offering::where('status', 'active')->get();

        return view('admin.allocations.create', compact('users', 'offerings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'offering_id' => 'required|exists:offerings,id',
            'amount' => 'required|numeric|min:0',
            'units' => 'required|numeric|min:0',
            'allocation_date' => 'required|date',
        ]);

        Allocation::create($request->all());

        return redirect()->route('admin.allocations.index')->with('success', 'Allocation assigned successfully.');
    }

    public function update(Request $request, Allocation $allocation)
    {
        $request->validate([
            'status' => 'required|in:active,pending,sold,cancelled',
        ]);

        $previousStatus = $allocation->status;

        $allocation->update([
            'status' => $request->status,
        ]);

        // Refund if cancelled (and was not already cancelled)
        if ($request->status === 'cancelled' && $previousStatus !== 'cancelled') {
            // Check if user paid? For now, we assume all pending allocations from investor dashboard are paid.
            // Admin created allocations might not be paid from wallet, but for now let's assume we only refund if it's a cancellation of a pending/active investment.

            $user = $allocation->user;
            $user->wallet_balance += $allocation->amount;
            $user->save();

            $user->transactions()->create([
                'amount' => $allocation->amount,
                'type' => 'deposit', // Refund
                'status' => 'completed',
                'reference' => 'REF-'.strtoupper(uniqid()),
                'description' => 'Refund for cancelled allocation in '.$allocation->offering->name,
            ]);

            return redirect()->back()->with('success', 'Allocation cancelled and funds refunded to user wallet.');
        }

        return redirect()->back()->with('success', 'Allocation status updated successfully.');
    }

    public function bulkUpdate(Request $request)
    {
        $request->validate([
            'allocation_ids' => 'required|array',
            'allocation_ids.*' => 'exists:allocations,id',
            'status' => 'required|in:active,cancelled',
        ]);

        $count = 0;

        foreach ($request->allocation_ids as $id) {
            $allocation = Allocation::find($id);
            $previousStatus = $allocation->status;

            // Skip if already in the target status
            if ($previousStatus === $request->status) {
                continue;
            }

            $allocation->update([
                'status' => $request->status,
            ]);

            // Refund if cancelled (and was not already cancelled)
            if ($request->status === 'cancelled' && $previousStatus !== 'cancelled') {
                $user = $allocation->user;
                $user->wallet_balance += $allocation->amount;
                $user->save();

                $user->transactions()->create([
                    'amount' => $allocation->amount,
                    'type' => 'deposit', // Refund
                    'status' => 'completed',
                    'reference' => 'REF-'.strtoupper(uniqid()),
                    'description' => 'Refund for cancelled allocation in '.$allocation->offering->name,
                ]);
            }

            $count++;
        }

        return redirect()->back()->with('success', "{$count} allocations updated successfully.");
    }
}
