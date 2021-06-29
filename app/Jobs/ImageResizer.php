<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Storage;
use Intervention\Image\Facades\Image;

class ImageResizer implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    protected $dimensions;
    protected $image;
    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image,$dimensions)
    {
        $this->image=$image;
        $this->dimensions=$dimensions;
    }

    /**
     * Execute the job.
     *
     * @return void
     */
    public function handle()
    {
        $img = Image::make($this->image)->resize($this->dimensions['width'], $this->dimensions['height']);
        $img->save(public_path() . 'converted_images/'.md5('myImage'.time()).'jpg');
    }
}
