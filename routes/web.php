<?php

use App\Http\Controllers\Admin\AllocationController;
use App\Http\Controllers\Admin\AnnouncementController;
use App\Http\Controllers\Admin\DistributionController;
use App\Http\Controllers\Admin\DocumentController;
use App\Http\Controllers\Admin\ImportSessionController;
use App\Http\Controllers\Admin\InvestorImportController;
use App\Http\Controllers\Admin\OfferingController;
use App\Http\Controllers\Admin\ReportController;
use App\Http\Controllers\Admin\SettingController;
use App\Http\Controllers\Admin\TransactionController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\ChatController;
use App\Http\Controllers\Investor\WalletController;
use App\Http\Controllers\InvestorController;
use App\Http\Controllers\LegalController;
use App\Http\Controllers\NotificationController;
use App\Http\Controllers\ProfileController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

Route::get('/dashboard', function () {
    if (auth()->user()->role === 'admin') {
        return redirect()->route('admin.dashboard');
    }

    if (auth()->user()->role === 'legal') {
        return redirect()->route('legal.dashboard');
    }

    if (auth()->user()->role === 'finance') {
        return redirect()->route('finance.dashboard');
    }

    return redirect()->route('investor.dashboard');
})->middleware(['auth', 'verified'])->name('dashboard');

Route::middleware(['auth', 'verified', 'role:admin'])->prefix('admin')->name('admin.')->group(function () {
    Route::get('/dashboard', [AdminController::class, 'index'])->name('dashboard');
    Route::resource('offerings', OfferingController::class);
    Route::resource('users', UserController::class);

    // Import Investors
    Route::get('/investors/import', [InvestorImportController::class, 'create'])->name('investors.import');
    Route::post('/investors/import', [InvestorImportController::class, 'store'])->name('investors.import.store');
    Route::post('/investors/import/preview', [InvestorImportController::class, 'preview'])->name('investors.import.preview');
    Route::get('/imports', [ImportSessionController::class, 'index'])->name('imports.index');
    Route::get('/imports/{importSession}', [ImportSessionController::class, 'show'])->name('imports.show');
    Route::get('/imports/{importSession}/error-report', [ImportSessionController::class, 'downloadErrorReport'])->name('imports.error-report');
    Route::get('/imports/{importSession}/progress', function (\App\Models\ImportSession $importSession) {
        return response()->json([
            'processed_rows' => $importSession->processed_rows,
            'total_rows' => $importSession->total_rows,
            'successful_rows' => $importSession->successful_rows,
            'failed_rows' => $importSession->failed_rows,
            'status' => $importSession->status,
        ]);
    })->name('imports.progress');

    Route::post('/allocations/bulk-update', [AllocationController::class, 'bulkUpdate'])->name('allocations.bulk-update');
    Route::resource('allocations', AllocationController::class)->only(['index', 'create', 'store', 'update']);
    Route::resource('documents', DocumentController::class)->only(['index', 'create', 'store', 'destroy']);
    Route::get('/documents/{document}/download', [DocumentController::class, 'download'])->name('documents.download');
    Route::post('/transactions/{transaction}/approve', [TransactionController::class, 'approve'])->name('transactions.approve');
    Route::post('/transactions/{transaction}/reject', [TransactionController::class, 'reject'])->name('transactions.reject');
    Route::resource('transactions', TransactionController::class)->only(['index', 'create', 'store', 'update']);
    Route::resource('announcements', AnnouncementController::class);
    Route::resource('distributions', DistributionController::class)->only(['index', 'create', 'store']);
    Route::post('/distributions/{distribution}/process', [DistributionController::class, 'process'])->name('distributions.process');
    Route::get('/reports/export', [ReportController::class, 'export'])->name('reports.export');
    Route::get('/reports', [ReportController::class, 'index'])->name('reports.index');
    Route::get('/settings', [SettingController::class, 'index'])->name('settings.index');
    Route::post('/settings', [SettingController::class, 'update'])->name('settings.update');

    // Marketing / Mini Mailchimp
    Route::resource('audiences', \App\Http\Controllers\Admin\AudienceController::class);
    Route::post('audiences/{audience}/import', [\App\Http\Controllers\Admin\AudienceController::class, 'import'])->name('audiences.import');
    Route::delete('audiences/{audience}/contacts/{contact}', [\App\Http\Controllers\Admin\AudienceController::class, 'removeContact'])->name('audiences.remove-contact');
    Route::post('audiences/{audience}/contacts/move', [\App\Http\Controllers\Admin\AudienceController::class, 'moveContacts'])->name('audiences.move-contacts');
    Route::post('campaigns/preview', [\App\Http\Controllers\Admin\CampaignController::class, 'preview'])->name('campaigns.preview');
    Route::resource('campaigns', \App\Http\Controllers\Admin\CampaignController::class);
    Route::post('campaigns/{campaign}/send', [\App\Http\Controllers\Admin\CampaignController::class, 'send'])->name('campaigns.send');
    Route::post('campaigns/{campaign}/test', [\App\Http\Controllers\Admin\CampaignController::class, 'test'])->name('campaigns.test');
});

Route::middleware(['auth', 'verified', 'role:investor'])->prefix('investor')->name('investor.')->group(function () {
    Route::get('/dashboard', [InvestorController::class, 'index'])->name('dashboard');
    Route::get('/investments', [InvestorController::class, 'investments'])->name('investments.index');
    Route::get('/transactions', [InvestorController::class, 'transactions'])->name('transactions.index');
    Route::get('/offerings/{offering}', [InvestorController::class, 'show'])->name('offerings.show');
    Route::post('/offerings/{offering}/invest', [InvestorController::class, 'invest'])->name('offerings.invest');
    Route::get('/documents', [InvestorController::class, 'documents'])->name('documents.index');
    Route::get('/documents/{document}/download', [InvestorController::class, 'downloadDocument'])->name('documents.download');
    Route::post('/documents/{document}/upload-signed', [InvestorController::class, 'uploadSignedAgreement'])->name('documents.upload-signed');

    // Wallet & Transactions
    Route::get('/wallet', [WalletController::class, 'index'])->name('wallet.index');
    Route::post('/wallet/deposit', [WalletController::class, 'deposit'])->name('wallet.deposit');
    Route::post('/wallet/withdraw', [WalletController::class, 'withdraw'])->name('wallet.withdraw');

    Route::get('/transactions/{transaction}/receipt', [InvestorController::class, 'receipt'])->name('transactions.receipt');
    
    Route::get('/announcements', [InvestorController::class, 'announcements'])->name('announcements.index');

    // Profile Management
    Route::get('/profile', [\App\Http\Controllers\Investor\ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [\App\Http\Controllers\Investor\ProfileController::class, 'update'])->name('profile.update');
});

Route::middleware(['auth', 'verified', 'role:legal'])->prefix('legal')->name('legal.')->group(function () {
    Route::get('/dashboard', [LegalController::class, 'index'])->name('dashboard');
    Route::get('/documents', [LegalController::class, 'documents'])->name('documents.index');
    Route::post('/documents', [LegalController::class, 'storeDocument'])->name('documents.store');
    Route::get('/investors', [LegalController::class, 'investors'])->name('investors.index');
    Route::get('/audit-logs', [LegalController::class, 'auditLogs'])->name('audit-logs.index');
});

Route::middleware(['auth', 'verified', 'role:finance'])->prefix('finance')->name('finance.')->group(function () {
    Route::get('/dashboard', [\App\Http\Controllers\FinanceController::class, 'index'])->name('dashboard');
    Route::get('/roi', [\App\Http\Controllers\FinanceController::class, 'roi'])->name('roi.index');
    Route::get('/roi/{offering}', [\App\Http\Controllers\FinanceController::class, 'showRoi'])->name('roi.show');
    Route::post('/roi/{allocation}/pay', [\App\Http\Controllers\FinanceController::class, 'payRoi'])->name('roi.pay');
    Route::post('/roi/{offering}/pay-all', [\App\Http\Controllers\FinanceController::class, 'payAllRoi'])->name('roi.pay-all');
    Route::get('/transactions', [\App\Http\Controllers\FinanceController::class, 'transactions'])->name('transactions.index');
    Route::get('/transactions/{transaction}/receipt', [\App\Http\Controllers\FinanceController::class, 'receipt'])->name('transactions.receipt');
});

Route::middleware('auth')->group(function () {
    Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');

    Route::post('/notifications/{id}/read', [NotificationController::class, 'markAsRead'])->name('notifications.read');
    Route::post('/notifications/read-all', [NotificationController::class, 'markAllAsRead'])->name('notifications.read-all');

    // Chat Routes
    Route::get('/chat', [ChatController::class, 'index'])->name('chat.index');
    Route::get('/chat/{receiver}', [ChatController::class, 'show'])->name('chat.show');
    Route::post('/chat/{receiver}', [ChatController::class, 'store'])->name('chat.store');
});

require __DIR__.'/auth.php';
