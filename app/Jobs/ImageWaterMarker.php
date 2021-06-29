<?php

namespace App\Jobs;

use Illuminate\Bus\Queueable;
use Illuminate\Contracts\Queue\ShouldBeUnique;
use Illuminate\Contracts\Queue\ShouldQueue;
use Illuminate\Foundation\Bus\Dispatchable;
use Illuminate\Queue\InteractsWithQueue;
use Illuminate\Queue\SerializesModels;

class ImageWaterMarker implements ShouldQueue
{
    use Dispatchable, InteractsWithQueue, Queueable, SerializesModels;

    const TEXT_WIDTH=300;
    const TEXT_HEIGHT=50;
    const FONT_SIZE=40;
    const WATER_MARK_TEXT='Designer Land Site';

    protected $image;
//    protected

    /**
     * Create a new job instance.
     *
     * @return void
     */
    public function __construct($image)
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
        $imageHeight = $this->image->getHeight();
        $imageWidth = $this->image->getWidth();


        //this defines how many times the text will be printed vertically
        $printsPerColumn = $imageHeight / self::TEXT_HEIGHT;
        //this defines how many times the text will be printed Horizontally
        $printsPerRow = $imageWidth / self::TEXT_WIDTH;

        $x = 0;
        for ($rowCounter = 0; $rowCounter < $printsPerRow; $rowCounter += 1) {
            $y = 0;
            for ($colCounter = 0; $colCounter < $printsPerColumn; $colCounter += 1) {
                $this->image->text(self::WATER_MARK_TEXT, $x, $y, function ($font) {
                    $font->file(resource_path() . '/fonts/jetbrains-mono.regular.ttf');
                    $font->size(self::FONT_SIZE);
                });
                $y += 50;
            }
            $x += 500;
        }

    }
}
