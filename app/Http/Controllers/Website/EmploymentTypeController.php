<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Resources\Website\EmploymentTypeResource;
use App\Models\EmploymentType;

class EmploymentTypeController extends Controller
{
    public function index()
    {
        return EmploymentTypeResource::collection(EmploymentType::with('translations')->paginate());
    }

    public function show(EmploymentType $employmentType)
    {
        return response([
            'employment_type' => new EmploymentTypeResource($employmentType)
        ]);
    }
}
