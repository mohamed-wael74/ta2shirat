<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\VisaTypeFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\VisaTypeStoreRequest;
use App\Http\Requests\Admin\VisaTypeUpdateRequest;
use App\Http\Resources\Admin\VisaTypeResource;
use App\Models\VisaType;

class VisaTypeController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(VisaType::class, 'visa_type');
    }

    public function index(VisaTypeFilter $filters)
    {
        return VisaTypeResource::collection(
            VisaType::filter($filters)->paginate()
        );
    }

    public function store(VisaTypeStoreRequest $request)
    {
        $visa_type = $request->storeVisaType();

        return response([
            'visa_type' => VisaTypeResource::make($visa_type),
            'message' => __('visa_types.store')
        ]);
    }

    public function show(VisaType $visa_type)
    {
        return response([
            'visa_type' => VisaTypeResource::make($visa_type)
        ]);
    }

    public function update(VisaTypeUpdateRequest $request, VisaType $visa_type)
    {
        $request->updateVisaType();

        return response([
            'visa_type' => VisaTypeResource::make($visa_type),
            'message' => __('visa_types.update')
        ]);
    }

    public function destroy(VisaType $visa_type)
    {
        if (! $visa_type->remove()) {
            return response([
                'message' => __('visa_types.cant_destroy')
            ]);
        }

        return response([
            'message' => __('visa_types.destroy')
        ]);
    }
}
