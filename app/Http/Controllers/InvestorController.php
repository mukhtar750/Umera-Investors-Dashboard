<?php

namespace App\Http\Controllers;

use App\Models\AuditLog;
use App\Models\Announcement;
use App\Models\Document;
use App\Models\Offering;
use App\Models\Transaction;
use App\Models\User;
use App\Notifications\AgreementSignedNotification;
use App\Notifications\NewInvestmentNotification;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Notification;
use Illuminate\Support\Facades\Storage;

class InvestorController extends Controller
{
    public function index()
    {
        $offerings = Offering::where('status', 'open')
            ->orWhere('status', 'coming_soon')
            ->latest()
            ->get();

        $user = Auth::user();
        $my_allocations = $user->allocations()->with('offering')->latest()->get();

        $announcements = Announcement::where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->take(5)
            ->get();

        // Calculate ROI (Weighted Average)
        $total_invested = $my_allocations->sum('amount');
        $roi_rate = 0;
        if ($total_invested > 0) {
            $weighted_roi = 0;
            foreach ($my_allocations as $allocation) {
                $offering_roi = $allocation->offering->roi_percentage ?? 0;
                $weighted_roi += $allocation->amount * $offering_roi;
            }
            $roi_rate = $weighted_roi / $total_invested;
        }

        // Last Payment Date
        $last_payment = $user->transactions()
            ->whereIn('type', ['payment', 'investment_payment'])
            ->where(function ($query) {
                $query->where('status', 'completed')
                    ->orWhere('status', 'approved');
            })
            ->latest()
            ->first();
        $last_payment_date = $last_payment ? $last_payment->created_at : null;

        return view('investor.dashboard', compact('offerings', 'my_allocations', 'announcements', 'roi_rate', 'last_payment_date'));
    }

    public function investments()
    {
        $allocations = Auth::user()->allocations()->with('offering')->latest()->get();

        return view('investor.investments.index', compact('allocations'));
    }

    public function transactions()
    {
        $allocations = Auth::user()->allocations()->with(['offering', 'transactions' => function ($q) {
            $q->latest();
        }])->get();

        return view('investor.transactions.index', compact('allocations'));
    }

    public function show(Offering $offering)
    {
        // Ensure the offering is visible to investors
        if ($offering->status === 'closed') {
            abort(404);
        }

        // $offering->load('documents'); // Assuming relationship exists

        return view('investor.offerings.show', compact('offering'));
    }

    public function invest(Request $request, Offering $offering)
    {
        $validated = $request->validate([
            'units' => 'required|numeric|min:1',
            'payment_method' => 'required|in:wallet,bank_transfer',
            'proof_of_payment' => 'required_if:payment_method,bank_transfer|file|mimes:jpeg,png,jpg,pdf|max:5120',
        ]);

        $units = $validated['units'];
        $amount = $units * $offering->price;
        $user = Auth::user();
        $paymentMethod = $validated['payment_method'];

        if ($amount < $offering->min_investment) {
            return back()->withErrors(['units' => 'Investment amount (₦'.number_format($amount).') must be at least ₦'.number_format($offering->min_investment)]);
        }

        // Check wallet balance if paying via wallet
        if ($paymentMethod === 'wallet' && $user->wallet_balance < $amount) {
            return back()->withErrors(['units' => 'Insufficient wallet balance. Please deposit funds first.']);
        }

        $allocation = $offering->allocations()->create([
            'user_id' => $user->id,
            'units' => $units,
            'amount' => $amount,
            'status' => 'pending',
            'allocation_date' => now(),
        ]);

        $transactionStatus = 'completed'; // Default for wallet
        $proofPath = null;

        if ($paymentMethod === 'wallet') {
            // Deduct from wallet
            $user->wallet_balance -= $amount;
            $user->save();
        } else {
            // Bank Transfer Logic
            $transactionStatus = 'pending';
            if ($request->hasFile('proof_of_payment')) {
                $proofPath = $request->file('proof_of_payment')->store('proofs', 'public');
            }
        }

        $transaction = $user->transactions()->create([
            'allocation_id' => $allocation->id,
            'amount' => $amount,
            'type' => 'investment_payment',
            'status' => $transactionStatus,
            'reference' => 'INV-'.strtoupper(uniqid()),
            'description' => 'Investment in '.$offering->name.' ('.$units.' units)',
            'payment_method' => $paymentMethod,
            'proof_of_payment' => $proofPath,
        ]);

        // Notify Legal Team and Admins
        $recipients = User::whereIn('role', ['legal', 'admin'])->get();
        Notification::send($recipients, new NewInvestmentNotification($allocation, $user));

        AuditLog::create([
            'user_id' => $user->id,
            'action' => 'investment_created',
            'subject_type' => Transaction::class,
            'subject_id' => $transaction->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => [
                'offering_id' => $offering->id,
                'allocation_id' => $allocation->id,
                'amount' => $amount,
                'units' => $units,
                'payment_method' => $paymentMethod,
                'status' => $transactionStatus,
            ],
        ]);

        if ($paymentMethod === 'wallet') {
            return redirect()->route('investor.dashboard')->with('success', 'Investment request submitted successfully! Funds have been deducted from your wallet.');
        } else {
            return redirect()->route('investor.dashboard')->with('success', 'Investment request submitted successfully! Your payment is under review.');
        }
    }

    public function documents()
    {
        $user = Auth::user();

        // Get documents where user_id is the user
        $userDocuments = Document::where('user_id', $user->id)->get();

        // Get documents for offerings the user has invested in
        $offeringIds = $user->allocations()->pluck('offering_id');
        $offeringDocuments = Document::whereIn('offering_id', $offeringIds)->get();

        // Get general documents
        $generalDocuments = Document::whereNull('user_id')->whereNull('offering_id')->get();

        $documents = $userDocuments->merge($offeringDocuments)->merge($generalDocuments)->sortByDesc('created_at');

        return view('investor.documents.index', compact('documents'));
    }

    public function downloadDocument(Document $document)
    {
        // Authorization check
        $user = Auth::user();

        $canDownload = false;

        if ($document->user_id == $user->id) {
            $canDownload = true;
        } elseif ($document->offering_id) {
            // Check if user has invested in this offering
            if ($user->allocations()->where('offering_id', $document->offering_id)->exists()) {
                $canDownload = true;
            }
        } elseif ($document->user_id === null && $document->offering_id === null) {
            // General document
            $canDownload = true;
        }

        if (! $canDownload) {
            abort(403);
        }

        return Storage::download($document->file_path, $document->name);
    }

    public function receipt(Transaction $transaction)
    {
        // Authorization: Ensure the transaction belongs to the logged-in investor
        if ($transaction->user_id !== Auth::id()) {
            abort(403);
        }

        return view('finance.transactions.receipt', compact('transaction'));
    }
}
            $canDownload = true;
        } elseif ($document->offering_id && $user->allocations()->where('offering_id', $document->offering_id)->exists()) {
            $canDownload = true;
        } elseif (is_null($document->user_id) && is_null($document->offering_id)) {
            $canDownload = true;
        }

        if (! $canDownload) {
            abort(403);
        }

        if (! Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($document->file_path, $document->title.'.'.pathinfo($document->file_path, PATHINFO_EXTENSION));
    }

    public function announcements()
    {
        $announcements = Announcement::where('is_published', true)
            ->whereNotNull('published_at')
            ->latest('published_at')
            ->get();

        return view('investor.announcements.index', compact('announcements'));
    }

    public function uploadSignedAgreement(Request $request, Document $document)
    {
        $request->validate([
            'file' => 'required|file|mimes:pdf,doc,docx|max:10240', // 10MB
        ]);

        if ($document->user_id !== Auth::id()) {
            abort(403);
        }

        $path = $request->file('file')->store('documents/signed', 'public');

        $document->update([
            'signed_file_path' => $path,
            'status' => Document::STATUS_SIGNED,
        ]);

        $recipients = User::whereIn('role', ['legal', 'admin'])->get();
        Notification::send($recipients, new AgreementSignedNotification($document, Auth::user()));

        AuditLog::create([
            'user_id' => Auth::id(),
            'action' => 'agreement_signed',
            'subject_type' => Document::class,
            'subject_id' => $document->id,
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'metadata' => [
                'document_title' => $document->title,
            ],
        ]);

        return back()->with('success', 'Signed agreement uploaded successfully.');
    }
}
