<?php

namespace App\Http\Controllers;

use App\Models\Allocation;
use App\Models\Offering;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\RoiPaymentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class FinanceController extends Controller
{
    public function index()
    {
        // 1. Total Capital Raised (Total amount of active allocations)
        $totalCapitalRaised = Allocation::where('status', 'active')->sum('amount');

        // 2. Total ROI Paid (Total distributions processed)
        // Assuming we track paid ROI in transactions or distributions
        // For now, let's sum 'withdrawal' transactions or look at distributions table if used
        // Let's use distributions table if populated, otherwise transactions of type 'roi_payment'
        $totalRoiPaid = Transaction::where('type', 'roi_payment')->where('status', 'completed')->sum('amount');

        // 3. Pending Payouts (Allocations in closed offerings that haven't been paid?)
        // Or just pending withdrawal requests
        $pendingWithdrawals = Transaction::where('type', 'withdrawal')->where('status', 'pending')->count();
        $pendingWithdrawalAmount = Transaction::where('type', 'withdrawal')->where('status', 'pending')->sum('amount');

        // 4. Upcoming Maturities (Offerings ending soon)
        $upcomingMaturities = Offering::where('status', 'open')
            ->whereNotNull('end_date')
            ->whereDate('end_date', '>=', now())
            ->orderBy('end_date')
            ->take(5)
            ->get();

        return view('finance.dashboard', compact(
            'totalCapitalRaised',
            'totalRoiPaid',
            'pendingWithdrawals',
            'pendingWithdrawalAmount',
            'upcomingMaturities'
        ));
    }

    public function roi()
    {
        // List offerings with their ROI status
        $offerings = Offering::withCount(['allocations as investor_count' => function($query) {
                $query->where('status', 'active');
            }])
            ->withSum(['allocations as total_invested' => function($query) {
                $query->where('status', 'active');
            }], 'amount')
            ->orderBy('end_date', 'asc')
            ->paginate(10);

        return view('finance.roi.index', compact('offerings'));
    }

    public function showRoi(Offering $offering)
    {
        // Show investors for this offering and their expected ROI
        $allocations = $offering->allocations()
            ->where('status', 'active')
            ->with('user')
            ->get()
            ->map(function ($allocation) use ($offering) {
                $roiPercentage = $offering->roi_percentage ?? 0;
                $allocation->expected_roi = $allocation->amount * ($roiPercentage / 100);
                $allocation->total_payout = $allocation->amount + $allocation->expected_roi;
                return $allocation;
            });

        return view('finance.roi.show', compact('offering', 'allocations'));
    }

    public function payRoi(Request $request, Allocation $allocation)
    {
        // Calculate ROI
        $offering = $allocation->offering;
        $roiPercentage = $offering->roi_percentage ?? 0;
        $roiAmount = $allocation->amount * ($roiPercentage / 100);

        DB::transaction(function () use ($allocation, $roiAmount, $offering) {
            // Create Transaction
            $transaction = Transaction::create([
                'user_id' => $allocation->user_id,
                'allocation_id' => $allocation->id,
                'type' => 'roi_payment',
                'amount' => $roiAmount,
                'status' => 'completed',
                'reference' => 'ROI-' . $allocation->id . '-' . time(),
                'description' => 'ROI Payment for ' . $offering->name,
            ]);

            // Update User Wallet
            $allocation->user->increment('wallet_balance', $roiAmount);

            // Notify User
            $allocation->user->notify(new RoiPaymentNotification($transaction, $offering->name));
        });

        return back()->with('success', 'ROI Payment processed successfully.');
    }

    public function payAllRoi(Request $request, Offering $offering)
    {
        $count = 0;
        $allocations = $offering->allocations()->where('status', 'active')->get();

        DB::transaction(function () use ($allocations, $offering, &$count) {
            foreach ($allocations as $allocation) {
                // Calculate ROI
                $roiPercentage = $offering->roi_percentage ?? 0;
                $roiAmount = $allocation->amount * ($roiPercentage / 100);

                // Create Transaction
                $transaction = Transaction::create([
                    'user_id' => $allocation->user_id,
                    'allocation_id' => $allocation->id,
                    'type' => 'roi_payment',
                    'amount' => $roiAmount,
                    'status' => 'completed',
                    'reference' => 'ROI-' . $allocation->id . '-' . time(),
                    'description' => 'ROI Payment for ' . $offering->name,
                ]);

                // Update User Wallet
                $allocation->user->increment('wallet_balance', $roiAmount);

                // Notify User
                $allocation->user->notify(new RoiPaymentNotification($transaction, $offering->name));
                $count++;
            }
        });

        return back()->with('success', "$count ROI Payments processed successfully.");
    }

    public function transactions()
    {
        $transactions = Transaction::with(['user', 'allocation.offering'])
            ->latest()
            ->paginate(20);

        return view('finance.transactions.index', compact('transactions'));
    }

    public function receipt(Transaction $transaction)
    {
        return view('finance.transactions.receipt', compact('transaction'));
    }
}