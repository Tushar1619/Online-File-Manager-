<?php

namespace Tests\Feature;

use App\Http\Controllers\FileController;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ShowFilesTest extends TestCase
{
    public function testShow()
    {
        // Mock the Storage facade
        Storage::fake('public');

        // Set up test data
        $filename = 'comment-icon.svg';
        $filepath = 'C:\Users\tanya\OneDrive\Desktop\svgs\comment-icon.svg';
        $destPath = 'public/' . $filename;
        $expectedUrl = asset(Storage::url($destPath));

        // Create a mock request with the required data
        $request = new Request([
            'filepath' => $filepath,
        ]);

        // Call the show method
        $response = (new FileController())->show($request);

        // Assert that the Storage copy method was called with the correct arguments
        Storage::assertExists($destPath);

        // Assert that the response contains the expected URL
        $this->assertArrayHasKey('path', $response);
        $this->assertEquals($expectedUrl, $response['path']);
    }
}
