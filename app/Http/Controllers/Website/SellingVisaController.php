<?php

namespace App\Http\Controllers\Website;

use App\Http\Controllers\Controller;
use App\Http\Requests\Website\SellingVisaStoreRequest;
use App\Http\Requests\Website\SellingVisaUpdateRequest;
use App\Http\Resources\Website\SellingVisaResource;
use App\Http\Resources\Website\SellingVisaSimpleResource;
use App\Models\SellingVisa;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class SellingVisaController extends Controller
{
    public function index()
    {
        $sellingVisas = auth()->user()->sellingVisas()
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

    public function store(SellingVisaStoreRequest $request)
    {
        $sellingVisa = $request->storeSellingVisa();

        return response([
            'message' => __('selling_visas.store'),
            'selling_visa' => new SellingVisaResource($sellingVisa)
        ]);
    }

    public function show(SellingVisa $sellingVisa)
    {
        if ($sellingVisa->user_id != auth()->user()->id)
            throw new NotFoundHttpException();

        return response([
            'selling_visa' => new SellingVisaResource($sellingVisa)
        ]);
    }

    public function update(SellingVisaUpdateRequest $request, SellingVisa $sellingVisa)
    {
        if ($sellingVisa->is_done || $sellingVisa->user_id != auth()->user()->id)
            throw new NotFoundHttpException();

        $request->updateSellingVisa();

        return response([
            'message' => __('selling_visas.update'),
            'selling_visa' => new SellingVisaResource($sellingVisa)
        ]);
    }
}
