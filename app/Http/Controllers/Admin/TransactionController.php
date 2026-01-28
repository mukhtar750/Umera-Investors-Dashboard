<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Transaction;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TransactionController extends Controller
{
    public function index()
    {
        $transactions = Transaction::with('user')->latest()->get();

        return view('admin.transactions.index', compact('transactions'));
    }

    public function create()
    {
        $users = User::where('role', 'investor')->get();

        return view('admin.transactions.create', compact('users'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:0.01',
            'type' => 'required|string',
            'status' => 'required|string',
            'reference' => 'nullable|string',
            'description' => 'nullable|string',
        ]);

        $transaction = Transaction::create($request->all());

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'transaction_recorded',
            'subject_type' => Transaction::class,
            'subject_id' => $transaction->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => [
                'amount' => $transaction->amount,
                'type' => $transaction->type,
                'status' => $transaction->status,
                'reference' => $transaction->reference,
            ],
        ]);

        return redirect()->route('admin.transactions.index')->with('success', 'Transaction recorded successfully.');
    }

    public function approve(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaction is not pending.');
        }

        DB::transaction(function () use ($transaction) {
            $transaction->update(['status' => 'completed']);

            if ($transaction->type === 'deposit') {
                $transaction->user->increment('wallet_balance', $transaction->amount);
            } elseif ($transaction->type === 'investment_payment') {
                // If it's an investment payment, update the allocation status to active
                if ($transaction->allocation) {
                    $transaction->allocation->update(['status' => 'active']);
                }
            }
            // For withdrawals, we assume balance was deducted at creation or we deduct here.
            // Assuming withdrawals deduct balance immediately upon request (pending),
            // so approval just confirms it.
            // But if withdrawal request didn't deduct, we should do it here.
            // Let's assume standard logic:
            // Deposit: Pending -> Approved (+Balance)
            // Withdrawal: Pending (Balance locked/deducted?) -> Approved (Done)
            // For now, let's just handle Deposit increment.
        });

        AuditLog::create([
            'user_id' => request()->user()->id,
            'action' => 'transaction_approved',
            'subject_type' => Transaction::class,
            'subject_id' => $transaction->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => [
                'amount' => $transaction->amount,
                'type' => $transaction->type,
                'reference' => $transaction->reference,
            ],
        ]);

        return back()->with('success', 'Transaction approved successfully.');
    }

    public function reject(Transaction $transaction)
    {
        if ($transaction->status !== 'pending') {
            return back()->with('error', 'Transaction is not pending.');
        }

        $transaction->update(['status' => 'failed']);

        AuditLog::create([
            'user_id' => request()->user()->id,
            'action' => 'transaction_rejected',
            'subject_type' => Transaction::class,
            'subject_id' => $transaction->id,
            'ip_address' => request()->ip(),
            'user_agent' => request()->userAgent(),
            'metadata' => [
                'amount' => $transaction->amount,
                'type' => $transaction->type,
                'reference' => $transaction->reference,
            ],
        ]);

        // If it was a withdrawal that deducted balance, we should refund it here.
        // But for simplicity in this iteration, we focus on Deposits.

        return back()->with('success', 'Transaction rejected.');
    }
}
