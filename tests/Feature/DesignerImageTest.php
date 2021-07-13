<?php

namespace Tests\Feature;

use App\Models\Image;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class DesignerImageTest extends TestCase
{
    use RefreshDatabase;
    use DatabaseMigrations;

    protected $designer;

    protected function setUp(): void
    {
        parent::setUp();
        $this->designer= \App\Models\User::factory()->create();
    }

    /**
     * @test
     */
    public function designer_can_upload_image()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->designer, 'api');

        Storage::fake();
        $file=UploadedFile::fake()->image('pic.png', 600, 600);

        $this->post('/api/upload', [
            'name' => 'Laravel',
            'image'=>$file,
        ])->assertStatus(201);

        $response = $this->get('api/designer/'.$this->designer->id.'/images')
            ->assertStatus(200);

        $image = Image::first();

        Storage::assertExists($image->path);

        $response->assertJson([
            'data' => [
                [
                    'data' => [
                        'type' => 'images',
                        'id' => $image->id,
                        'attributes' => [
                            'path' => $image->path,
                        ]
                    ]
                ]
            ]
        ]);

    }
}
