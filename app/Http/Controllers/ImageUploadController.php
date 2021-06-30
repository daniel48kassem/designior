<?php

namespace App\Http\Controllers;

use App\Jobs\ImageResizer;
use App\Models\Image;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Response;

class ImageUploadController extends Controller
{


    /**
     * Show the form for creating a new resource.
     *
     */
    public function create()
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

        $img=Image::create([
            'path'=>'uploads/original/'.$image_name
        ]);
        Log::debug($img->path);

        $tmp = $image->storeAs('uploads/original', $image_name);
        return view('images.download')->with('image', $img);
    }

    public function resize(Request $request,Image $image)
    {
        $data = $this->validate($request, [
            'height' => ['required'],
            'width' => ['required'],
        ]);

        $height= $data['height'];
        $width = $data['width'];
        $img = $image->resize(['height'=>$height,'width'=>$width]);

//        $file= public_path(). "/download/info.pdf";

        $headers = array(
            'Content-Type: image/png',
        );

//        header('Content-Type: image/png');
//        return $img->response();
        $headers = [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename='. 're',
        ];
        return response()->stream(function() use ($img) {
            echo $img;
        }, 200, $headers);

//        return Response::download($img, 'filename.jpg', $headers);
//        $this->dispatch(new ImageResizer($image,$dimensions));

    }

}
