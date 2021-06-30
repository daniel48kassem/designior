<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class ImageUploadController extends Controller
{
    public function upload(Request $request){

        //
        //upload to original folder
        //and every time the image requested at specific resolution the jobs dispatched

        $this->validate($request,[
            'image'=>['required','mime:jpeg,png','max:2048']
        ]);

        $image=$request->file('image');
        $image_path=$image->getPathname();
        $image_name=time().preg_replace('/\s+/','_',strtolower($image->getClientOriginalName()));

        $tmp=$image->storeAs('uploads/original',$image_name);

    }
}
