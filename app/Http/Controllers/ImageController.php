<?php

namespace App\Http\Controllers;

use App\Http\Resources\Image as ImageResource;
use Illuminate\Http\Request;

class ImageController extends Controller
{
    public function show(Image $image){
        return new ImageResource($image);
    }
}
