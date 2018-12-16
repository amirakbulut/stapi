<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\ResourceCollection;

class SchoolCollection extends ResourceCollection
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
        $schools = [];

        foreach($this->collection as $school) {

            array_push($schools, [
                'id' => $school->id,
                'name' => $school->name,
                'url' => route('schools.show', $school->id)
            ]);

        }

        return $schools;
    }
}
