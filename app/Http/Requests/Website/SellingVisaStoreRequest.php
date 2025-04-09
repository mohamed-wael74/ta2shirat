<?php

namespace App\Http\Requests\Website;

use App\Models\SellingVisa;
use App\Models\StatusType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class SellingVisaStoreRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'nationality' => 'required|integer|exists:countries,id',
            'destination' => 'required|integer|exists:countries,id',
            'visa_type' => 'required|integer|exists:visa_types,id',
            'employment_type' => 'required|integer|exists:employment_types,id',
            'provider_name' => 'required|string|min:3|max:50',
            'contact_email' => 'required|string|email|max:60',
            'required_qualifications' => 'sometimes|string|min:3|max:255',
            'message' => 'nullable|string|min:3|max:255',
        ];
    }

    public function storeSellingVisa(): SellingVisa
    {
        return DB::transaction(function () {
            $sellingVisa = SellingVisa::create([
                'user_id' => auth()->id(),
                'nationality_id' => $this->nationality,
                'destination_id' => $this->destination,
                'visa_type_id' => $this->visa_type,
                'employment_type_id' => $this->employment_type,
                'provider_name' => $this->provider_name,
                'contact_email' => $this->contact_email,
                'required_qualifications' => $this->required_qualifications,
                'message' => $this->message,
                'is_done' => false,
            ]);

            $sellingVisa->createStatuses();
            $pendingStatusType = StatusType::where('type', 'pending')->first();
            $sellingVisa->activateStatus($pendingStatusType->id);

            return $sellingVisa->refresh();
        });
    }

    public function attributes(): array
    {
        return [
            'nationality' => __('selling_visas.attributes.nationality'),
            'destination' => __('selling_visas.attributes.destination'),
            'visa_type' => __('selling_visas.attributes.visa_type'),
            'employment_type' => __('selling_visas.attributes.employment_type'),
            'provider_name' => __('selling_visas.attributes.provider_name'),
            'contact_email' => __('selling_visas.attributes.contact_email'),
            'required_qualifications' => __('selling_visas.attributes.required_qualifications'),
            'message' => __('selling_visas.attributes.message'),
        ];
    }
}