<?php

namespace Tests\Feature;

use App\Models\Allocation;
use App\Models\Document;
use App\Models\Offering;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class InvestorDocumentTest extends TestCase
{
    use RefreshDatabase;

    public function test_investor_can_view_documents_list()
    {
        $investor = User::factory()->create(['role' => 'investor']);

        $response = $this->actingAs($investor)->get(route('investor.documents.index'));

        $response->assertStatus(200);
        $response->assertViewIs('investor.documents.index');
    }

    public function test_investor_can_see_own_documents()
    {
        $investor = User::factory()->create(['role' => 'investor']);
        $document = Document::create([
            'title' => 'My Document',
            'type' => 'contract',
            'file_path' => 'documents/test.pdf',
            'user_id' => $investor->id,
        ]);

        $response = $this->actingAs($investor)->get(route('investor.documents.index'));

        $response->assertSee('My Document');
    }

    public function test_investor_can_see_offering_documents_for_investments()
    {
        $investor = User::factory()->create(['role' => 'investor']);
        $offering = Offering::create([
            'name' => 'Test Offering',
            'type' => 'Land Banking',
            'price' => 100000,
            'status' => 'active',
        ]);

        Allocation::create([
            'user_id' => $investor->id,
            'offering_id' => $offering->id,
            'amount' => 500000,
            'units' => 5,
            'allocation_date' => now(),
        ]);

        $document = Document::create([
            'title' => 'Offering Document',
            'type' => 'general',
            'file_path' => 'documents/offering.pdf',
            'offering_id' => $offering->id,
        ]);

        $response = $this->actingAs($investor)->get(route('investor.documents.index'));

        $response->assertSee('Offering Document');
    }

    public function test_investor_cannot_see_unrelated_documents()
    {
        $investor = User::factory()->create(['role' => 'investor']);
        $otherUser = User::factory()->create(['role' => 'investor']);

        $document = Document::create([
            'title' => 'Other User Document',
            'type' => 'contract',
            'file_path' => 'documents/other.pdf',
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($investor)->get(route('investor.documents.index'));

        $response->assertDontSee('Other User Document');
    }

    public function test_investor_can_download_allowed_document()
    {
        Storage::fake('public');
        $investor = User::factory()->create(['role' => 'investor']);
        $file = UploadedFile::fake()->create('contract.pdf', 100);
        $path = $file->store('documents', 'public');

        $document = Document::create([
            'title' => 'My Document',
            'type' => 'contract',
            'file_path' => $path,
            'user_id' => $investor->id,
        ]);

        $response = $this->actingAs($investor)->get(route('investor.documents.download', $document));

        $response->assertStatus(200);
        $response->assertDownload('My Document.pdf');
    }

    public function test_investor_cannot_download_restricted_document()
    {
        Storage::fake('public');
        $investor = User::factory()->create(['role' => 'investor']);
        $otherUser = User::factory()->create(['role' => 'investor']);
        $file = UploadedFile::fake()->create('secret.pdf', 100);
        $path = $file->store('documents', 'public');

        $document = Document::create([
            'title' => 'Secret Document',
            'type' => 'contract',
            'file_path' => $path,
            'user_id' => $otherUser->id,
        ]);

        $response = $this->actingAs($investor)->get(route('investor.documents.download', $document));

        $response->assertStatus(403);
    }
}
