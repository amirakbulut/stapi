<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class CountryCollection extends ResourceCollection
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
        $countries = [];

        foreach($this->collection as $country) {

            array_push($countries, [
                'id' => $country->id,
                'name' => $country->name,
                'url' => route('countries.show', $country->id)
            ]);

        }

        return $countries;
    }
}
