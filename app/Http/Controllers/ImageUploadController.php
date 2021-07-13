<?php

namespace App\Http\Controllers;

use App\Http\Resources\Image as ImageResource;
use App\Jobs\ImageDisposale;
use App\Jobs\ImageResizer;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    /*
     * the designer upload an image to the server
     * */
    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => ['required', 'mimes:jpeg,png', 'max:2048']
        ]);

        $image = $request->file('image');
        $image_path = $image->getPathname();
        $image_name = time() . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        $user = auth('api')->user();

        //we create the image
        $img = $user->images()->create([
            'path' => 'uploads/user_' . $user->id . '/original/' . $image_name
        ]);

        //store the original image
        $tmp = $image->storeAs('uploads/user_' . auth('api')->user()->id . '/original/', $image_name);

        //dispatch the thumbnail maker job

        return response(new ImageResource($img), 201);
    }

}
