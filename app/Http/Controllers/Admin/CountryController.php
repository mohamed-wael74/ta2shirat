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
        $countries = Country::with('translations')->filter($filters)->paginate();
        return CountryResource::collection($countries);
    }

    public function show(Country $country)
    {
        return response([
            'country' => new CountryResource($country)
        ]);
    }

    public function update(CountryUpdateRequest $request, Country $country)
    {
        $request->updateCountry();

        return response([
            'message' => __('countries.update'),
            'country' => new CountryResource($country),
        ]);
    }
}
