<?php

namespace App\Http\Controllers;

use App\Http\Resources\ImageResource;
use App\Jobs\ImageDisposale;
use App\Jobs\ImageResizer;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class ImageUploadController extends Controller
{
    public function index()
    {
        return view('images.upload');
    }


    public function upload(Request $request)
    {
        $this->validate($request, [
            'image' => ['required', 'mimes:jpeg,png', 'max:2048']
        ]);

        $image = $request->file('image');
        $image_path = $image->getPathname();
        $image_name = time() . preg_replace('/\s+/', '_', strtolower($image->getClientOriginalName()));

        $img = Image::create([
            'path' => 'uploads/original/' . $image_name
        ]);

        $tmp = $image->storeAs('uploads/original', $image_name);
        //run job which responsible for delete image after 10 minutes from the server
        // to free space
//        ImageDisposale::dispatch($img)->delay(now()->addMinutes(10));

//        return response(new ImageResource($img) ,201);
        return view('images.download')
            ->with(['image'=>$img,'resolutions'=>Image::RESOLUTIONS]);
    }

    public function resize(Request $request, Image $image)
    {
        $data = $this->validate($request, [
            'height' => ['required'],
            'width' => ['required'],
        ]);

        $height = $data['height'];
        $width = $data['width'];

        $img = $image->resize(['height' => $height, 'width' => $width]);
//        $this->dispatch($img);

        $headers = [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename=' . 're',
        ];

//        $headers = [
//            'Content-Type'        => 'application/jpeg',
//            'Content-Disposition' => 'attachment; filename="'. $attachment->name .'"',
//        ];

//        return response()->download($img, 's.jpg', $headers);

//        return response()->stream(function () use ($img) {
//            echo $img;
//        }, 200, $headers);

        return response()->streamDownload(function () use ($img) {
            echo $img;
        }, 'filename',$headers);
    }

}
