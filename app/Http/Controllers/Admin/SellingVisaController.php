<?php

namespace App\Http\Controllers\Admin;

use App\Filters\Admin\SellingVisaFilter;
use App\Http\Controllers\Controller;
use App\Http\Requests\Admin\SellingVisaUpdateRequest;
use App\Http\Resources\Admin\SellingVisaResource;
use App\Http\Resources\Admin\SellingVisaSimpleResource;
use App\Models\SellingVisa;

class SellingVisaController extends Controller
{
    public function __construct()
    {
        $this->authorizeResource(SellingVisa::class, 'selling_visa');
    }

    public function index(SellingVisaFilter $filters)
    {
        $sellingVisas = SellingVisa::filter($filters)
            ->with([
                'nationality',
                'destination',
                'visaType',
                'employmentType',
                'statuses'
            ])
            ->paginate();

        return SellingVisaSimpleResource::collection($sellingVisas);
    }

    public function show(SellingVisa $sellingVisa)
    {
        return response([
            'selling_visa' => new SellingVisaResource($sellingVisa)
        ]);
    }

    public function update(SellingVisaUpdateRequest $request, SellingVisa $sellingVisa)
    {
        $request->updateSellingVisa();

        return response([
            'message' => __('selling_visas.update'),
            'selling_visa' => new SellingVisaResource($sellingVisa)
        ]);
    }
}
