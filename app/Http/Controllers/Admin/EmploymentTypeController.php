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
        $employmentTypes = EmploymentType::with('translations')->paginate();
        return EmploymentTypeResource::collection($employmentTypes);
    }

    public function show(EmploymentType $employmentType)
    {
        return response([
            'employment_type' => new EmploymentTypeResource($employmentType)
        ]);
    }

    public function store(EmploymentTypeStoreRequest $request)
    {
        $employmentType = $request->storeEmploymentType();

        return response([
            'message' => __('employment_types.store'),
            'employment_type' => new EmploymentTypeResource($employmentType),
        ]);
    }

    public function update(EmploymentTypeUpdateRequest $request, EmploymentType $employmentType)
    {
        $request->updateEmploymentType();

        return response([
            'message' => __('employment_types.update'),
            'employment_type' => new EmploymentTypeResource($employmentType),
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
