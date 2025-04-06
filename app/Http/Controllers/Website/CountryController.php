<?php

namespace App\Http\Controllers\Website;

use App\Filters\Website\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Website\CountryResource;
use App\Models\Country;

class CountryController extends Controller
{
    public function index(CountryFilter $filters)
    {
        $countries = Country::available()->filter($filters)->get();

        return response([
            'countries' => CountryResource::collection($countries)
        ]);
    }


    public function show(Country $country)
    {
        return response([
            'country' => CountryResource::make($country)
        ]);
    }
}
