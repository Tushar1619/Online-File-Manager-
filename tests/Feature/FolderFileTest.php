<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
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
            File::factory()->create(['name'=>'file1.txt','is_folder'=>false,'parent_id'=>$parentFolder->id]), // Example uploaded file
            File::factory()->create(['name'=>'file2.txt','is_folder'=>false,'parent_id'=>$parentFolder->id]), // Example uploaded file
        ];

        // Mock the request data
        $requestData = [
            'files' => $fileData,
            'file_tree' => [], // Assuming no file tree data for this test
            'parent' => $parentFolder->id, // Pass the parent file ID
        ];

        // Mock the request object
        $request = $this->post('/file', $requestData);

        // Assert that the controller responds with a redirect or any other expected behavior
        $request->assertRedirect(); // Example assertion
        // Add more assertions based on your controller's behavior
    }
}
