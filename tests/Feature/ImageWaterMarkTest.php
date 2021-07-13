<?php

namespace Tests\Feature;

use Database\Seeders\PermissionSeeder;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class ImageWaterMarkTest extends TestCase
{

    protected function setUp(): void
    {
        parent::setUp();
        $this->seed(PermissionSeeder::class);
        $this->designer= \App\Models\User::factory()->create()->assignRole('designer');
        $this->customer = User::factory()->create()->assignRole('customer');
    }

    /**
     * @test
     */
    public function customer_can_preview_low_resolution_of_un_paid_image()
    {
        $this->withoutExceptionHandling();
        $this->actingAs($this->designer, 'api');
    }

    /**
     * @test
     */
    public function customer_can_download_watermarked_image_of_un_paid_image()
    {

    }

    /**
     * @test
     */
    public function customer_can_not_download_un_paid_image()
    {

    }
}
