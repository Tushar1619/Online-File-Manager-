<?php

namespace Tests\Feature;

use App\Http\Controllers\FileController;
use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use Tests\TestCase;

class CheckTrashTest extends TestCase
{
    // use RefreshDatabase;
    /**
     * A basic feature test example.
     */
    public function testTrash()
    {
        $this->withoutExceptionHandling();
        // Create a user
        $user = User::factory()->create();

        // Authenticate as the user
        $this->actingAs($user);

        // Create some trashed files for the user
        $trashedFiles = File::factory()->count(15)->trashed()->create(['created_by' => $user->id]);

        // Mock the request
        $request = Request::create('/trash', 'GET');

        // Create an instance of FileController
        $fileController = new FileController();

        // Call the trash() method
        $response = $fileController->trash($request);
        $this->assertNotNull($response);
    }
}
