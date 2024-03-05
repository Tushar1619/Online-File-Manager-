<?php

namespace Tests\Feature;

use App\Http\Controllers\FileController;
use App\Http\Requests\FilesActionRequest;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class DownloadTest extends TestCase
{
    use RefreshDatabase;

    public function testDownload()
    {
        $this->withoutExceptionHandling();
        // Create a user
        $user = User::factory()->create();

        // Authenticate as the user
        $this->actingAs($user);
        // Create a parent folder
        $parentFolder = File::factory()->create([
            'is_folder' => true,
            'created_by' => $user->id,
        ]);

        // Mock the request data
        $requestData = [
            'all' => true,
            'parent' => $parentFolder,
        ];

        // Create an instance of FilesActionRequest with the appropriate data
        $request = FilesActionRequest::create('/download', 'GET', $requestData);

        // Create an instance of your controller
        $fileController = new FileController();

        // Call the download() method
        $response = $fileController->download($request);

        // Assert that the response contains the expected data
        $this->assertArrayHasKey('url', $response);
        $this->assertArrayHasKey('filename', $response);
        $this->assertNotEmpty($response['url']);
        $this->assertNotEmpty($response['filename']);
    }
}
