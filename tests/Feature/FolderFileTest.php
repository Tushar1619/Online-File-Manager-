<?php

namespace Tests\Feature;

use App\Http\Controllers\FileController;
use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class FolderFileTest extends TestCase
{
    use RefreshDatabase;
    public function testCreatingFolder()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = User::factory()->create(), 'web');
        $parentFolder = File::factory()->create(['is_folder' => true]);
        $response = $this->post('/folder/create', [
            'name' => 'New Folder',
            'parent_id' => $parentFolder->id,
        ]);
        // echo $response;

        $response->assertStatus(200);

        // Assert that the folder was created in the database
        $this->assertDatabaseHas('files', [
            'name' => 'New Folder',
            'parent_id' => $parentFolder->id,
            'is_folder' => 1,
        ]);
    }

    public function testUploadingFile()
    {
        $this->withoutExceptionHandling();
        Storage::fake('public'); // Mock the storage disk

        $this->actingAs($user = User::factory()->create(), 'web');

        $parentFolder = File::factory()->create(['is_folder' => true]);
        // Create some dummy file data
        $fileData = [
            UploadedFile::fake()->create('file1.txt', 100), // Example uploaded file
            UploadedFile::fake()->create('file2.txt', 200), // Example uploaded file
        ];

        // Mock the request data
        $requestData = [
            'files' => $fileData,
            'file_tree' => [], // Assuming no file tree data for this test
            'parent_id' => $parentFolder->id, // Pass the parent file ID
        ];

        // Mock the request object
        $request = $this->post('/file', $requestData);

        $request->assertStatus(200);
        // Add more assertions based on your controller's behavior
    }

 
}
