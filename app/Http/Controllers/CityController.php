<?php

namespace App\Http\Controllers;

use App\City;
use App\Http\Resources\CityResource;
use App\Http\Resources\CityCollection;
use App\Province;
use Illuminate\Http\Request;

class CityController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $cities = City::all();
        return new CityCollection($cities);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return CityResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|alpha|unique:cities,name,NULL,id,province_id,' . $request->input('province_id'),
            'province_id' => 'required|numeric|unique:cities,province_id,NULL,id,name,' . $request->input('name'),
        ]);

        $province = Province::findOrFail($request->input('province_id'));

        if($province){
            $city = new City;
            $city->name = $request->input('name');
            $city->province_id = $request->input('province_id');

            if($city->save()){
                return new CityResource($city);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return CityResource
     */
    public function show($id)
    {
        return new CityResource(City::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return CityResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|alpha|unique:cities,name,NULL,id,province_id,' . $request->input('province_id'),
            'province_id' => 'required|numeric|unique:cities,province_id,NULL,id,name,' . $request->input('name'),
        ]);

        $city = City::findOrFail($id);
        $province = Province::findOrFail($request->input('province_id'));

        $city->name = $request->input('name');
        $city->province_id = $request->input('province_id');

        if($city->save()){
            return new CityResource($city);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return CityResource
     */
    public function destroy($id)
    {
        $city = City::findOrFail($id);

        if($city->delete()){
            return new CityResource($city);
        }
    }
}
