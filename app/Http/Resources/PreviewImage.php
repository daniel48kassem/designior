<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class PreviewImage extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'data'=>[
                'id'=>$this->id,
                'type'=>'images',
                'attributes'=>[
                    'url'=>url(Storage::url($this->preview_image)),
                ],
            ]
        ];
    }
}
