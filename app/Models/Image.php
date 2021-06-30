<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Image extends Model
{
    use HasFactory;
    protected $guarded =[];

    public function resize($dimensions){
        $img = \Intervention\Image\Facades\Image::make(Storage::get($this->path))
            ->resize($dimensions['width'], $dimensions['height']);
        $img->save(storage_path('converted_images/'.'48.jpg'));
        return $img;
    }
}
