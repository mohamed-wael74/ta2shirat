<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\EmploymentTypeResource;
use App\Models\EmploymentType;

class EmploymentTypeController extends Controller
{
    public function index()
    {
        $employmentTypes = EmploymentType::with('translations')->get();
        return EmploymentTypeResource::collection($employmentTypes);
    }

    public function show(EmploymentType $employmentType)
    {
        return response([
            'employment_type' => new EmploymentTypeResource($employmentType)
        ]);
    }
}
