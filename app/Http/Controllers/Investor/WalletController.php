<?php

namespace App\Http\Controllers\Investor;

use App\Http\Controllers\Controller;
use App\Models\AuditLog;
use App\Models\Transaction;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class WalletController extends Controller
{
    public function index()
    {
        $transactions = Auth::user()->transactions()->latest()->paginate(10);

        return view('investor.wallet.index', compact('transactions'));
    }

    public function deposit(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
        ]);

        // For demo purposes, we will auto-approve deposits.
        // In production, this would integrate with a payment gateway.

        $transaction = Auth::user()->transactions()->create([
            'amount' => $request->amount,
            'type' => 'deposit',
            'status' => 'completed',
            'reference' => 'DEP-'.strtoupper(uniqid()),
            'description' => 'Wallet Deposit',
        ]);

        $user = Auth::user();
        $user->wallet_balance += $request->amount;
        $user->save();

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'wallet_deposit',
            'subject_type' => Transaction::class,
            'subject_id' => $transaction->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => [
                'amount' => $transaction->amount,
                'reference' => $transaction->reference,
            ],
        ]);

        return redirect()->back()->with('success', 'Deposit successful! Your wallet has been credited.');
    }

    public function withdraw(Request $request)
    {
        $request->validate([
            'amount' => 'required|numeric|min:1000',
            'account_number' => 'required|string',
            'bank_name' => 'required|string',
        ]);

        if (Auth::user()->wallet_balance < $request->amount) {
            return back()->withErrors(['amount' => 'Insufficient funds.']);
        }

        $transaction = Auth::user()->transactions()->create([
            'amount' => $request->amount,
            'type' => 'withdrawal',
            'status' => 'pending',
            'reference' => 'WDR-'.strtoupper(uniqid()),
            'description' => 'Withdrawal to '.$request->bank_name.' ('.$request->account_number.')',
        ]);

        $user = Auth::user();
        $user->wallet_balance -= $request->amount;
        $user->save();

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'wallet_withdrawal_requested',
            'subject_type' => Transaction::class,
            'subject_id' => $transaction->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => [
                'amount' => $transaction->amount,
                'reference' => $transaction->reference,
                'bank_name' => $request->bank_name,
            ],
        ]);

        return redirect()->back()->with('success', 'Withdrawal request submitted.');
    }
}
