<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    protected $guarded =[];
    const RESOLUTIONS=[
            ['width' => 3648, 'height' => 2736],
            ['width' => 1920, 'height' => 1440],
            ['width' => 1280, 'height' => 960],
            ['width' => 640, 'height' => 480],
        ];

    public function resize($dimensions){
        $img = \Intervention\Image\Facades\Image::make(Storage::get($this->path))
            ->fit($dimensions['width'], $dimensions['height'],function ($constraint){
                $constraint->aspectRatio();
            });

        $img->save(storage_path('converted_images/'.'48.jpg'));
        return $img;
    }




}
