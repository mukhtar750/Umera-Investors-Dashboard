<?php

namespace App\Jobs;

use App\Models\Campaign;
use App\Models\Contact;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Queue\Queueable;
use Illuminate\Support\Facades\Mail;

class SendMarketingEmail implements ShouldQueue
{
    use Queueable;

    public $contact;
    public $campaign;

    /**
     * Create a new job instance.
     */
    public function __construct(Contact $contact, Campaign $campaign)
    {
        $this->contact = $contact;
        $this->campaign = $campaign;
    }

    /**
     * Execute the job.
     */
    public function handle(): void
    {
        Mail::send('emails.marketing.' . $this->campaign->template, ['contact' => $this->contact, 'campaign' => $this->campaign], function ($m) {
            $m->to($this->contact->email, $this->contact->name)
              ->subject($this->campaign->subject);
        });
    }
}
