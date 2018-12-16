<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use App\Province;
use App\Http\Resources\ProvinceCollection;
use App\Http\Resources\ProvinceResource;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $provinces = Province::all();
        return new ProvinceCollection($provinces);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return ProvinceResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:provinces,name,NULL,id,country_id,' . $request->input('country_id'),
            'country_id' => 'required|numeric|unique:provinces,country_id,NULL,id,name,' . $request->input('name'),
        ]);

        $country_id = Country::findOrFail($request->input('country_id'));

        if($country_id) {
            $province = new Province;
            $province->name = $request->input('name');
            $province->country_id = $request->input('country_id');

            if($province->save()){
                return new ProvinceResource($province);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return ProvinceResource
     */
    public function show($id)
    {
        return new ProvinceResource(Province::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return ProvinceResource
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|unique:provinces,name,NULL,id,country_id,' . $request->input('country_id'),
            'country_id' => 'required|numeric|unique:provinces,country_id,NULL,id,name,' . $request->input('name'),
        ]);

        $province = Province::findOrFail($id);
        $country = Country::findOrFail($request->input('country_id'));

        if($province && $country){
            $province->name = $request->input('name');
            $province->country_id = $request->input('country_id');

            if($province->save()){
                return new ProvinceResource($province);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int $id
     * @return ProvinceResource
     */
    public function destroy($id)
    {
        $province = Province::findOrFail($id);

        if($province->delete()){
            return new ProvinceResource($province);
        }
    }
}
