<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use Illuminate\Support\Facades\Request;
use Tests\TestCase;

class DownloadTest extends TestCase
{
    // use RefreshDatabase;

    public function testDownloadError()
    {
        $this->withoutExceptionHandling();

        $this->actingAs($user = User::factory()->create());

        $requestData = [];

        $request = $this->getJson('/file/download', $requestData);

        $request->assertStatus(200);
        $request->assertJsonStructure([
            'message',
        ]);
    }

    public function testDownload()
    {
        // $this->withoutExceptionHandling();
        $user = User::factory()->create();
        $this->actingAs($user);
        // Create a parent folder
        $parent = File::factory()->create([
            'is_folder' => true,
            'created_by' => $user->id,
            'updated_by' => $user->id,
        ]);

        // Set up data for the request
        $requestData = [
            'all' => true,
            'ids' => [],
            'parent' => $parent,
        ];

        $request = new Request($requestData);

        // Inject the request into the container
        $this->instance(Request::class, $request);

        // Call the download method
        $response = $this->json('GET', '/file/download');

        // Assertions
        $response->assertStatus(200);
        $response->assertJson([
            'url',
            'filename',
        ]);
    }
}
