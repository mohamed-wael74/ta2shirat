<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\EmploymentTypeStoreRequest;
use App\Http\Requests\Admin\EmploymentTypeUpdateRequest;
use App\Http\Resources\Admin\EmploymentTypeResource;
use App\Models\EmploymentType;
use App\Models\User;

class EmploymentTypeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(EmploymentType::class, 'employment_type');
    }

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

    public function store(EmploymentTypeStoreRequest $request)
    {
        return response([
            'employment_type' => new EmploymentTypeResource($request->storeEmploymentType()),
            'message' => __('employment_types.store')
        ]);
    }

    public function update(EmploymentTypeUpdateRequest $request, EmploymentType $employmentType)
    {
        $request->updateEmploymentType();
        return response([
            'employment_type' => new EmploymentTypeResource($employmentType),
            'message' => __('employment_types.update')
        ]);
    }

    public function destroy(EmploymentType $employmentType)
    {
        $employmentType->remove();
        return response([
            'message' => __('employment_types.destroy')
        ]);
    }
}
