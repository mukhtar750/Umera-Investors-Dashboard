<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audience;
use App\Models\Contact;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class AudienceController extends Controller
{
    public function index()
    {
        $audiences = Audience::withCount('contacts')->latest()->paginate(10);
        return view('admin.audiences.index', compact('audiences'));
    }

    public function create()
    {
        return view('admin.audiences.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Audience::create($request->all());

        return redirect()->route('admin.audiences.index')->with('success', 'Audience created successfully.');
    }

    public function show(Audience $audience)
    {
        $contacts = $audience->contacts()->latest()->paginate(20);
        $otherAudiences = Audience::where('id', '!=', $audience->id)->get();
        return view('admin.audiences.show', compact('audience', 'contacts', 'otherAudiences'));
    }

    public function edit(Audience $audience)
    {
        return view('admin.audiences.edit', compact('audience'));
    }

    public function update(Request $request, Audience $audience)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $audience->update($request->all());

        return redirect()->route('admin.audiences.index')->with('success', 'Audience updated successfully.');
    }

    public function destroy(Audience $audience)
    {
        $audience->delete();
        return redirect()->route('admin.audiences.index')->with('success', 'Audience deleted successfully.');
    }

    public function import(Request $request, Audience $audience)
    {
        $request->validate([
            'file' => 'required|file|mimes:csv,txt',
        ]);

        $file = $request->file('file');
        $handle = fopen($file->getPathname(), 'r');
        
        // Skip header
        $header = fgetcsv($handle);
        
        // Map columns (simple approach: assume order or check header)
        // Let's assume order: Email, First Name, Last Name
        // Or check header for "email"
        
        $emailIndex = -1;
        $fnameIndex = -1;
        $lnameIndex = -1;

        if ($header) {
            foreach ($header as $index => $col) {
                $col = strtolower(trim($col));
                if (str_contains($col, 'email')) $emailIndex = $index;
                if (str_contains($col, 'first') || str_contains($col, 'name')) $fnameIndex = $index;
                if (str_contains($col, 'last')) $lnameIndex = $index;
            }
        }

        // Fallback if header detection fails
        if ($emailIndex === -1) $emailIndex = 0;

        $imported = 0;
        
        DB::transaction(function () use ($handle, $emailIndex, $fnameIndex, $lnameIndex, $audience, &$imported) {
            while (($row = fgetcsv($handle)) !== false) {
                if (!isset($row[$emailIndex]) || !filter_var($row[$emailIndex], FILTER_VALIDATE_EMAIL)) {
                    continue;
                }

                $email = $row[$emailIndex];
                $firstName = $fnameIndex >= 0 ? ($row[$fnameIndex] ?? null) : null;
                $lastName = $lnameIndex >= 0 ? ($row[$lnameIndex] ?? null) : null;

                $contact = Contact::firstOrCreate(
                    ['email' => $email],
                    [
                        'first_name' => $firstName,
                        'last_name' => $lastName,
                    ]
                );

                // Attach to audience if not already attached
                if (!$audience->contacts()->where('contact_id', $contact->id)->exists()) {
                    $audience->contacts()->attach($contact->id);
                    $imported++;
                }
            }
        });

        fclose($handle);

        return back()->with('success', "Imported {$imported} contacts successfully.");
    }

    public function removeContact(Audience $audience, Contact $contact)
    {
        $audience->contacts()->detach($contact->id);
        return back()->with('success', 'Contact removed from audience.');
    }

    public function moveContacts(Request $request, Audience $audience)
    {
        $request->validate([
            'target_audience_id' => 'required|exists:audiences,id',
            'action_type' => 'required|in:copy,move',
            'contact_ids' => 'required|array',
            'contact_ids.*' => 'exists:contacts,id',
        ]);

        $targetAudience = Audience::findOrFail($request->target_audience_id);
        $count = 0;

        foreach ($request->contact_ids as $contactId) {
            // Add to target audience if not exists
            if (!$targetAudience->contacts()->where('contact_id', $contactId)->exists()) {
                $targetAudience->contacts()->attach($contactId);
                $count++;
            }

            // If move, remove from current audience
            if ($request->action_type === 'move') {
                $audience->contacts()->detach($contactId);
            }
        }

        $action = $request->action_type === 'move' ? 'moved' : 'copied';
        return back()->with('success', "Successfully {$action} contacts to {$targetAudience->name}.");
    }
}
