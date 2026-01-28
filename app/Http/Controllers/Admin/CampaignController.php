<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Audience;
use App\Models\Campaign;
use App\Jobs\SendMarketingEmail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class CampaignController extends Controller
{
    public function index()
    {
        $campaigns = Campaign::latest()->paginate(10);
        return view('admin.campaigns.index', compact('campaigns'));
    }

    public function create()
    {
        $audiences = Audience::all();
        $templates = ['simple', 'modern', 'corporate', 'promotional', 'newsletter'];
        return view('admin.campaigns.create', compact('audiences', 'templates'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'audience_ids' => 'required|array',
            'audience_ids.*' => 'exists:audiences,id',
            'template' => 'required|string',
            'content' => 'required|string',
        ]);

        $campaign = Campaign::create([
            'subject' => $request->subject,
            'template' => $request->template,
            'content' => $request->content,
            'status' => 'draft',
        ]);

        $campaign->audiences()->attach($request->audience_ids);

        if ($request->action === 'send') {
            return $this->send($campaign);
        }

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign saved as draft.');
    }

    public function show(Campaign $campaign)
    {
        return view('admin.campaigns.show', compact('campaign'));
    }

    public function edit(Campaign $campaign)
    {
        $audiences = Audience::all();
        $templates = ['simple', 'modern', 'corporate', 'promotional', 'newsletter'];
        return view('admin.campaigns.edit', compact('campaign', 'audiences', 'templates'));
    }

    public function update(Request $request, Campaign $campaign)
    {
        $request->validate([
            'subject' => 'required|string|max:255',
            'audience_ids' => 'required|array',
            'audience_ids.*' => 'exists:audiences,id',
            'template' => 'required|string',
            'content' => 'required|string',
        ]);

        $campaign->update([
            'subject' => $request->subject,
            'template' => $request->template,
            'content' => $request->content,
        ]);

        $campaign->audiences()->sync($request->audience_ids);

        if ($request->action === 'send') {
            return $this->send($campaign);
        }

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign updated.');
    }

    public function destroy(Campaign $campaign)
    {
        $campaign->delete();
        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign deleted.');
    }

    public function send(Campaign $campaign)
    {
        if ($campaign->status === 'sent') {
            return back()->with('error', 'Campaign already sent.');
        }

        $campaign->update(['status' => 'scheduled', 'sent_at' => now()]);
        
        // Dispatch jobs
        $audiences = $campaign->audiences()->with('contacts')->get();
        $uniqueContacts = collect();

        foreach ($audiences as $audience) {
            foreach ($audience->contacts as $contact) {
                if (!$uniqueContacts->contains('id', $contact->id)) {
                    $uniqueContacts->push($contact);
                }
            }
        }

        foreach ($uniqueContacts as $contact) {
            SendMarketingEmail::dispatch($contact, $campaign);
        }

        $campaign->update(['status' => 'sent']);

        return redirect()->route('admin.campaigns.index')->with('success', 'Campaign sent to ' . $uniqueContacts->count() . ' recipients.');
    }

    public function preview(Request $request)
    {
        $request->validate([
            'template' => 'required|string',
            'content' => 'required|string',
            'subject' => 'nullable|string',
        ]);

        // Create dummy contact for preview
        $contact = new \App\Models\Contact([
            'email' => auth()->user()->email,
            'first_name' => auth()->user()->name,
            'last_name' => '',
            'uuid' => 'preview-uuid'
        ]);

        // Create temporary campaign object
        $campaign = new Campaign([
            'subject' => $request->subject ?? 'Preview Subject',
            'template' => $request->template,
            'content' => $request->content,
        ]);

        return view('emails.marketing.' . $request->template, compact('contact', 'campaign'));
    }

    public function test(Request $request, Campaign $campaign)
    {
        $adminEmail = auth()->user()->email;
        
        // Create a dummy contact for the admin
        $contact = new \App\Models\Contact([
            'email' => $adminEmail,
            'first_name' => auth()->user()->name,
            'last_name' => '',
            'uuid' => 'test-uuid'
        ]);

        // Send immediately (no queue) for test
        try {
            Mail::send('emails.marketing.' . $campaign->template, ['contact' => $contact, 'campaign' => $campaign], function ($m) use ($contact, $campaign) {
                $m->to($contact->email, $contact->name)->subject('[TEST] ' . $campaign->subject);
            });
            return back()->with('success', 'Test email sent to ' . $adminEmail);
        } catch (\Exception $e) {
            return back()->with('error', 'Failed to send test email: ' . $e->getMessage());
        }
    }
}
