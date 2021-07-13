<?php

namespace App\Http\Controllers;

use App\Models\Image;
use Illuminate\Http\Request;

class ImageDownloadController extends Controller
{

    public function __construct()
    {

    }

    /*
     * function for download image at specific dimensions,
     * the image here should be in full quality since it is paid
     * */
    public function resize(Request $request, Image $image)
    {
        $data = $this->validate($request, [
            'height' => ['required'],
            'width' => ['required'],
        ]);

        $height = $data['height'];
        $width = $data['width'];

        $img = $image->resize(['height' => $height, 'width' => $width]);

        $headers = [
            'Content-Type' => 'image/jpeg',
            'Content-Disposition' => 'attachment; filename=' . 're',
        ];

        return response()->streamDownload(function () use ($img) {
            echo $img;
        }, 'filename',$headers);
    }
}
