<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Document;
use App\Models\Offering;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class DocumentController extends Controller
{
    public function index()
    {
        $documents = Document::with(['user', 'offering'])->latest()->paginate(10);

        return view('admin.documents.index', compact('documents'));
    }

    public function create()
    {
        $users = User::where('role', 'investor')->get();
        $offerings = Offering::all();

        return view('admin.documents.create', compact('users', 'offerings'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => 'required|string|max:255',
            'file' => 'required|file|max:10240', // 10MB max
            'type' => 'required|string',
            'user_id' => 'nullable|exists:users,id',
            'offering_id' => 'nullable|exists:offerings,id',
        ]);

        $path = $request->file('file')->store('documents', 'public');

        Document::create([
            'title' => $request->title,
            'file_path' => $path,
            'type' => $request->type,
            'user_id' => $request->user_id,
            'offering_id' => $request->offering_id,
        ]);

        return redirect()->route('admin.documents.index')->with('success', 'Document uploaded successfully.');
    }

    public function download(Document $document)
    {
        if (! Storage::disk('public')->exists($document->file_path)) {
            abort(404);
        }

        return Storage::disk('public')->download($document->file_path, $document->title.'.'.pathinfo($document->file_path, PATHINFO_EXTENSION));
    }

    public function destroy(Document $document)
    {
        if (Storage::disk('public')->exists($document->file_path)) {
            Storage::disk('public')->delete($document->file_path);
        }

        $document->delete();

        return redirect()->route('admin.documents.index')->with('success', 'Document deleted successfully.');
    }
}
