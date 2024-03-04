<?php

namespace Tests\Feature;

use App\Models\File;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Testing\Assert;
use Tests\TestCase;

class GetFileTest extends TestCase
{
    use RefreshDatabase;

    public function testGetFilesAtTheRootLevel()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = User::factory()->create(), 'web');

        // Create some files for the user
        $files = File::factory()->count(10)->create(['created_by' => $user->id]);

        // Call the myFiles method with a folder path
        $response = $this->get('/my-files');
        echo $files[0];
        $response->assertStatus(200);
    }

    public function testGetFilesAtThePathLevel()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($user = User::factory()->create(), 'web');

        // Create some files for the user
        $files = File::factory()->count(10)->create(['created_by' => $user->id]);

        // Call the myFiles method with a folder path
        $response = $this->get('/my-files/'.$files[0]->path);
        $response->assertStatus(200);
    }
}
