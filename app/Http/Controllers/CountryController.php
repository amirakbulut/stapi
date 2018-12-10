<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Http\Resources\Country as CountryResource;

class CountryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function index()
    {
        $countries = Country::all();
        return CountryResource::collection($countries);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|unique:countries|max:100|min:5',
        ]);

        $country = new Country;
        $country->name = $request->input('name');

        if($country->save()){
            return new CountryResource($country);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return CountryResource
     */
    public function show($id)
    {
        return new CountryResource(Country::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return CountryResource
     */
    public function update(Request $request, $id)
    {
        $country = Country::findOrFail($id);
        $country->name = $request->input('country_name');

        if($country->save()){
            return new CountryResource($country);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $country = Country::findOrFail($id);

        if($country->delete()){
            return new CountryResource($country);
        }

    }
}
