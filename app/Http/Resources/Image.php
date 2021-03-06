<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Image extends JsonResource
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
                    'url'=>url($this->path),
                ],
            ]
        ];
    }
}
