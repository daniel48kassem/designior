<?php

namespace Tests\Unit;

use Illuminate\Http\UploadedFile;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;
use App\Http\Middleware\AdminMiddleware;
use App\Http\Middleware\AuthorMiddleware;
use App\Models\User;
use Database\Seeders\RolesTableSeeder;
use Illuminate\Foundation\Testing\DatabaseMigrations;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ResizeTest extends TestCase
{
    /** @test */
    public function image_should_be_resized_in_multiple_resolutions()
    {
        $resolutions = [
            ['width' => 3648, 'height' => 2736],
            ['width' => 1920, 'height' => 1440],
            ['width' => 1280, 'height' => 960],
            ['width' => 640, 'height' => 480],
        ];

        $file = Storage::disk('public')->get('j.jpg');
        $img = Image::make($file)->resize(300, 200);
        $img->save(public_path() . 'converted_images/baz.jpg');
    }

    /** @test */
    public function image_can_be_watermarked()
    {
        $file = Storage::disk('public')->get('qq.jpg');
        $water = Storage::disk('public')->get('q.jpg');

        $water = Image::make($water)->resize('250', '250')
            ->brightness(50);

        $img = Image::make($file);

        $h = $img->getHeight();
        $w = $img->getWidth();

        //this defines how many times the text will be printed vertically
        $printsPerColumn = $h / 50;
        //this defines how many times the text will be printed Horizontally
        $printsPerRow = $w / 500;

//        dd($printsPerColumn);

        $x = 0;
        for ($rowCounter = 0; $rowCounter < $printsPerRow; $rowCounter += 1) {
            $y = 0;
            for ($colCounter = 0; $colCounter < $printsPerColumn; $colCounter += 1) {
                $img->text('sell your paint site', $x, $y, function ($font) {
                    $font->file(resource_path() . '/fonts/jetbrains-mono.regular.ttf');
                    $font->size(40);
                });
                $y += 50;
            }
            $x += 500;
        }

        $img->save(public_path() . '/baz.jpg');
    }

}
