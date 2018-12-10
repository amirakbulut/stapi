<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Country;
use App\Http\Resources\Countries;

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
        return Countries::collection($countries);
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
            'name' => 'required|string|alpha|unique:countries|max:100|min:5',
        ]);

        $country = new Country;
        $country->name = $request->input('name');

        if($country->save()){
            return new Countries($country);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int $id
     * @return Countries
     */
    public function show($id)
    {
        return new Countries(Country::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @param  int $id
     * @return Countries
     * @throws \Illuminate\Validation\ValidationException
     */
    public function update(Request $request, $id)
    {

        $this->validate($request, [
            'name' => 'required|string|alpha|unique:countries|max:100|min:5',
        ]);

        $country = Country::findOrFail($id);
        $country->name = $request->input('name');

        if($country->save()){
            return new Countries($country);
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
            return new Countries($country);
        }

    }
}
