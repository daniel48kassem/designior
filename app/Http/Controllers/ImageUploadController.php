<?php

namespace App\Http\Controllers;

use App\Http\Resources\Image as ImageResource;
use App\Jobs\ImageDisposale;
use App\Jobs\ImageResizer;
use App\Jobs\PreviewImageMaker;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function __construct()
    {
//        $this->middleware('auth:api');
    }

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

        $user = auth()->user();

        //we create the image
        $img = $user->images()->create([
            'path' => 'uploads/user_' . $user->id . '/original/' . $image_name
        ]);

        //store the original image,we need it later for applying transformations on it.
        $tmp = $image->storeAs('uploads/user_' . auth('api')->user()->id . '/original/', $image_name);

        //dispatch the previewImage maker job to make a preview image version
        $this->dispatch(new PreviewImageMaker($img));

        //return the original image resource to the designer
        return response(new ImageResource($img), 201);
    }

}
