<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class PreviewImageMaker implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $image;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct(\App\Models\Image $image)
    {
        $this->image=$image;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        //get the original image
        $originalImage=Storage::disk('local')->get($this->image->path);
        $path='images/preview_images/'.$this->image->user_id.'/'.$this->image->id;

        //create the folder if not exists
        if(!file_exists('images/preview_images/'.$this->image->user_id)){
            Storage::makeDirectory('images/preview_images/'.$this->image->user_id);
        }

        $imageName='images/preview_images/'.$this->image->id.'.jpg';

        //create the preview image ,which the image with blur transform applied
        $convertedImage = Image::make($originalImage)->blur(20)->save(public_path().'487.jpg');
        Storage::disk('public')->put($imageName, $convertedImage);
        $this->image->preview_image=$imageName;
        $this->image->save();
    }
}
