<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\CountryFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\CountryUpdateRequest;
use App\Http\Resources\Admin\CountryResource;
use App\Models\Country;

class CountryController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(Country::class, 'country');
    }

    public function index(CountryFilter $filters)
    {
        return CountryResource::collection(
            Country::filter($filters)->paginate()
        );
    }


    public function show(Country $country)
    {
        return response([
            'country' => CountryResource::make($country)
        ]);
    }

    public function update(CountryUpdateRequest $request, Country $country)
    {
        $request->updateCountry();

        return response([
            'country' => CountryResource::make($country),
            'message' => __('countries.update')
        ]);
    }
}
