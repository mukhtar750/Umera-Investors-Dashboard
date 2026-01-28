<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Document;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\AgreementSentNotification;
use Illuminate\Http\Request;

class LegalController extends Controller
{
    public function index()
    {
        $pendingDocuments = Document::where('status', Document::STATUS_PENDING_SIGNATURE)->count();
        $verifiedInvestors = User::where('role', 'investor')->whereNotNull('email_verified_at')->count();
        $recentDocuments = Document::with('user')->latest()->take(5)->get();

        $pendingBankTransfersCount = Transaction::where('type', 'investment_payment')
            ->where('payment_method', 'bank_transfer')
            ->where('status', 'pending')
            ->count();

        $pendingBankTransfersTotal = Transaction::where('type', 'investment_payment')
            ->where('payment_method', 'bank_transfer')
            ->where('status', 'pending')
            ->sum('amount');

        $recentBankTransfers = Transaction::with(['user', 'allocation.offering'])
            ->where('type', 'investment_payment')
            ->where('payment_method', 'bank_transfer')
            ->latest()
            ->take(5)
            ->get();

        return view('legal.dashboard', compact(
            'pendingDocuments',
            'verifiedInvestors',
            'recentDocuments',
            'pendingBankTransfersCount',
            'pendingBankTransfersTotal',
            'recentBankTransfers'
        ));
    }

    public function documents()
    {
        $documents = Document::with('user')->latest()->paginate(10);
        $investors = User::where('role', 'investor')->orderBy('name')->get();

        return view('legal.documents', compact('documents', 'investors'));
    }

    public function investors()
    {
        $investors = User::where('role', 'investor')->latest()->paginate(10);

        return view('legal.investors', compact('investors'));
    }

    public function auditLogs(Request $request)
    {
        $query = AuditLog::with('user')->latest();

        if ($request->filled('action')) {
            $query->where('action', $request->input('action'));
        }

        if ($request->filled('user_id')) {
            $query->where('user_id', $request->input('user_id'));
        }

        if ($request->filled('date_from')) {
            $query->whereDate('created_at', '>=', $request->input('date_from'));
        }

        if ($request->filled('date_to')) {
            $query->whereDate('created_at', '<=', $request->input('date_to'));
        }

        $logs = $query->paginate(25)->appends($request->query());

        $actions = AuditLog::select('action')->distinct()->orderBy('action')->pluck('action');

        $users = User::whereIn('id', AuditLog::select('user_id')->whereNotNull('user_id'))->orderBy('name')->get();

        $filters = $request->only(['action', 'user_id', 'date_from', 'date_to']);

        return view('legal.audit-logs', compact('logs', 'actions', 'users', 'filters'));
    }

    public function storeDocument(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB
            'user_id' => 'required|exists:users,id',
            'type' => 'required|string',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        $document = Document::create([
            'title' => $request->title,
            'file_path' => $path,
            'user_id' => $request->user_id,
            'type' => $request->type,
            'status' => $request->type === 'agreement' ? Document::STATUS_PENDING_SIGNATURE : Document::STATUS_ACTIVE,
        ]);

        if ($request->type === 'agreement') {
            $user = User::find($request->user_id);
            $user->notify(new AgreementSentNotification($document));
        }

        AuditLog::create([
            'user_id' => $request->user()->id,
            'action' => 'document_uploaded',
            'subject_type' => Document::class,
            'subject_id' => $document->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => [
                'title' => $document->title,
                'type' => $document->type,
                'target_user_id' => $document->user_id,
            ],
        ]);

        return back()->with('success', 'Document uploaded successfully.');
    }
}
