<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class ProvinceCollection extends ResourceCollection
{
    /**
     * Transform the resource collection into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        // final array to be return.
        $provinces = [];

        foreach($this->collection as $province) {

            array_push($provinces, [
                'id' => $province->id,
                'name' => $province->name,
                'url' => route('provinces.show', $province->id)
            ]);

        }

        return $provinces;
    }
}
