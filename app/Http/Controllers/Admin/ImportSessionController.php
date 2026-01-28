<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ImportSession;

class ImportSessionController extends Controller
{
    public function index()
    {
        $sessions = ImportSession::latest()->paginate(20);

        return view('admin.investors.import_history', compact('sessions'));
    }

    public function show(ImportSession $importSession)
    {
        return view('admin.investors.import_show', ['session' => $importSession]);
    }

    public function downloadErrorReport(ImportSession $importSession)
    {
        if (! $importSession->error_report_path) {
            abort(404);
        }

        $fullPath = storage_path('app/'.str_replace(['\\', '/'], DIRECTORY_SEPARATOR, $importSession->error_report_path));

        if (! file_exists($fullPath)) {
            abort(404);
        }

        $fileName = 'import_errors_session_'.$importSession->id.'.csv';

        return response()->download($fullPath, $fileName);
    }
}
