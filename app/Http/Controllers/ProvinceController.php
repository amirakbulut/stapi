<?php

namespace App\Http\Controllers;

use App\Country;
use Illuminate\Http\Request;
use App\Province;
use App\Http\Resources\Provinces;

class ProvinceController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $provinces = Province::all();
        return Provinces::collection($provinces);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $this->validate($request, [
            'name' => 'required|string|alpha|unique:provinces|max:100|min:5',
            'country_id' => 'required|numeric|unique:provinces,country_id',
        ]);

        $country_id = Country::findOrFail($request->input('country_id'));

        if($country_id) {
            $province = new Province;
            $province->name = $request->input('name');
            $province->country_id = $request->input('country_id');

            if($province->save()){
                return new Provinces($province);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return new Provinces(Province::findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required|string|alpha|unique:provinces|max:100|min:5',
        ]);

        $province = Province::findOrFail($id);
        $province->name = $request->input('name');

        if($province->save()){
            return new Provinces($province);
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
        $province = Province::findOrFail($id);

        if($province->delete()){
            return new Provinces($province);
        }
    }
}
