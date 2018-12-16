<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\City;
use App\School;
use App\Http\Resources\SchoolCollection;
use App\Http\Resources\SchoolResource;

class SchoolController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $schools = School::all();
        return new SchoolCollection($schools);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return SchoolResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:schools,name,NULL,id,city_id,' . $request->input('city_id'),
            'city_id' => 'required|numeric|unique:schools,city_id,NULL,id,name,' . $request->input('name'),
        ]);

        $city_id = City::findOrFail($request->input('city_id'));

        if($city_id) {
            $school = new School;
            $school->name = $request->input('name');
            $school->city_id = $request->input('city_id');

            if($school->save()){
                return new SchoolResource($school);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return SchoolResource
     */
    public function show($id)
    {
        return new SchoolResource(School::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return SchoolResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:schools,name,NULL,id,city_id,' . $request->input('city_id'),
            'city_id' => 'required|numeric|unique:schools,city_id,NULL,id,name,' . $request->input('name'),
        ]);

        $school = School::findOrFail($id);
        $city = City::findOrFail($request->input('city_id'));

        if($school && $city){
            $school->name = $request->input('name');
            $school->city_id = $request->input('city_id');

            if($school->save()){
                return new SchoolResource($school);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return SchoolResource
     */
    public function destroy($id)
    {
        $school = School::findOrFail($id);

        if($school->delete()){
            return new SchoolResource($school);
        }
    }
}
