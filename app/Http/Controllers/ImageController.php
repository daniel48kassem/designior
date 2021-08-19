<?php

namespace App\Http\Controllers;

use App\Http\Resources\Image as ImageResource;
use App\Models\Image;
use Illuminate\Http\Request;
use App\Http\Resources\PreviewImage as PreviewImageResource;
use Illuminate\Support\Facades\Storage;

class ImageController extends Controller
{
    public function previewImage(Image $image)
    {

//        return Storage::response($image->preview_image);

        return new PreviewImageResource($image);
    }



}
