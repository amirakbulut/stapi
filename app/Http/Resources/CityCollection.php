<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CityCollection extends ResourceCollection
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
        $cities = [];

        foreach($this->collection as $city) {

            array_push($cities, [
                'id' => $city->id,
                'name' => $city->name,
                'url' => route('cities.show', $city->id)
            ]);

        }

        return $cities;
    }
}
