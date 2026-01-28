<?php

namespace Tests\Feature;

use App\Models\Document;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DocumentManagementTest extends TestCase
{
    use RefreshDatabase;

    public function test_admin_can_view_documents_list()
    {
        $admin = User::factory()->create(['role' => 'admin']);

        $response = $this->actingAs($admin)->get(route('admin.documents.index'));

        $response->assertStatus(200);
        $response->assertViewIs('admin.documents.index');
    }

    public function test_admin_can_upload_document()
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);
        $file = UploadedFile::fake()->create('contract.pdf', 100);

        $response = $this->actingAs($admin)->post(route('admin.documents.store'), [
            'title' => 'Test Contract',
            'type' => 'contract',
            'file' => $file,
        ]);

        $response->assertRedirect(route('admin.documents.index'));

        // Assert file was stored
        // Note: The controller stores in 'documents', which maps to storage/app/documents on 'local' disk usually
        // But store() method uses the default disk. If default is 'local', it stores in 'storage/app'.
        // Let's check if the file exists in the storage.
        // Actually, we should check Database first to get the path.

        $this->assertDatabaseHas('documents', [
            'title' => 'Test Contract',
            'type' => 'contract',
        ]);

        $document = Document::first();
        Storage::disk('public')->assertExists($document->file_path);
    }

    public function test_admin_can_download_document()
    {
        Storage::fake('public');
        $admin = User::factory()->create(['role' => 'admin']);
        $file = UploadedFile::fake()->create('contract.pdf', 100);

        // Manually store file to simulate existing document
        $path = $file->store('documents', 'public');

        $document = Document::create([
            'title' => 'Test Contract',
            'type' => 'contract',
            'file_path' => $path,
        ]);

        $response = $this->actingAs($admin)->get(route('admin.documents.download', $document));

        $response->assertStatus(200);
        $response->assertDownload('Test Contract.pdf');
    }

    public function test_investor_cannot_manage_documents()
    {
        $investor = User::factory()->create(['role' => 'investor']);

        $response = $this->actingAs($investor)->get(route('admin.documents.index'));

        $response->assertStatus(403);
    }
}
