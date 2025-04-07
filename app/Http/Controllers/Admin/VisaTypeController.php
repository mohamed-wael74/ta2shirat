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
        $visaTypes = VisaType::filter($filters)->paginate();
        return VisaTypeResource::collection($visaTypes);
    }

    public function store(VisaTypeStoreRequest $request)
    {
        $visaType = $request->storeVisaType();

        return response([
            'message' => __('visa_types.store'),
            'visa_type' => new VisaTypeResource($visaType),
        ]);
    }

    public function show(VisaType $visaType)
    {
        return response([
            'visa_type' => new VisaTypeResource($visaType)
        ]);
    }

    public function update(VisaTypeUpdateRequest $request, VisaType $visaType)
    {
        $request->updateVisaType();

        return response([
            'message' => __('visa_types.update'),
            'visa_type' => new VisaTypeResource($visaType),
        ]);
    }

    public function destroy(VisaType $visaType)
    {
        if (!$visaType->remove()) {
            return response([
                'message' => __('visa_types.cant_destroy')
            ]);
        }

        return response([
            'message' => __('visa_types.destroy')
        ]);
    }
}
