<?php

namespace App\Http\Controllers\Website;

use App\Filters\Website\VisaTypeFilter;
use App\Http\Controllers\Controller;
use App\Http\Resources\Website\VisaTypeResource;
use App\Models\VisaType;

class VisaTypeController extends Controller
{
    public function index(VisaTypeFilter $filters)
    {
        return VisaTypeResource::collection(
            VisaType::filter($filters)->paginate()
        );
    }

    public function show(VisaType $visaType)
    {
        return response([
            'visa_type' => VisaTypeResource::make($visaType)
        ]);
    }
}
