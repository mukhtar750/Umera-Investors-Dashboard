<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Allocation;
use App\Models\Distribution;
use App\Models\Offering;
use App\Models\Transaction;
use App\Models\User;

class ReportController extends Controller
{
    public function index()
    {
        // 1. Investor Stats
        $totalInvestors = User::where('role', 'investor')->count();
        $totalWalletBalance = User::where('role', 'investor')->sum('wallet_balance');
        $newInvestorsThisMonth = User::where('role', 'investor')
            ->whereMonth('created_at', now()->month)
            ->whereYear('created_at', now()->year)
            ->count();

        // 2. Investment Stats
        $totalAllocations = Allocation::count();
        $totalInvestedAmount = Allocation::sum('amount'); // Using amount column if exists, otherwise need calculation

        // 3. Offering Stats
        $totalOfferings = Offering::count();
        $activeOfferings = Offering::where('status', 'open')->count();
        $completedOfferings = Offering::where('status', 'closed')->count();

        // 4. Financial Stats
        $totalDeposits = Transaction::where('type', 'deposit')->where('status', 'completed')->sum('amount');
        $totalWithdrawals = Transaction::where('type', 'withdrawal')->where('status', 'completed')->sum('amount');
        $totalDistributions = Distribution::where('status', 'processed')->sum('total_amount');

        // 5. Recent Activity
        $recentTransactions = Transaction::with('user')->latest()->take(10)->get();

        return view('admin.reports.index', compact(
            'totalInvestors',
            'totalWalletBalance',
            'newInvestorsThisMonth',
            'totalAllocations',
            'totalInvestedAmount',
            'totalOfferings',
            'activeOfferings',
            'completedOfferings',
            'totalDeposits',
            'totalWithdrawals',
            'totalDistributions',
            'recentTransactions'
        ));
    }

    public function export()
    {
        $headers = [
            'Content-type' => 'text/csv',
            'Content-Disposition' => 'attachment; filename=transactions-report-'.date('Y-m-d').'.csv',
            'Pragma' => 'no-cache',
            'Cache-Control' => 'must-revalidate, post-check=0, pre-check=0',
            'Expires' => '0',
        ];

        $callback = function () {
            $file = fopen('php://output', 'w');
            fputcsv($file, ['Date', 'User', 'Type', 'Amount', 'Status', 'Reference']);

            $transactions = Transaction::with('user')->latest()->cursor();

            foreach ($transactions as $transaction) {
                fputcsv($file, [
                    $transaction->created_at->format('Y-m-d H:i:s'),
                    $transaction->user ? $transaction->user->name : 'N/A',
                    $transaction->type,
                    $transaction->amount,
                    $transaction->status,
                    $transaction->reference,
                ]);
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
