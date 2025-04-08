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
            'nationality_id' => 'required|integer|exists:countries,id',
            'destination_id' => 'required|integer|exists:countries,id',
            'visa_type_id' => 'required|integer|exists:visa_types,id',
            'employment_type_id' => 'required|integer|exists:employment_types,id',
            'provider_name' => 'required|string|max:255',
            'contact_email' => 'required|email|max:255',
            'required_qualifications' => 'sometimes|string',
            'message' => 'nullable|string',
        ];
    }

    public function storeSellingVisa(): SellingVisa
    {
        return DB::transaction(function () {
            $sellingVisa = SellingVisa::create([
                'user_id' => auth()->id(),
                'nationality_id' => $this->nationality_id,
                'destination_id' => $this->destination_id,
                'visa_type_id' => $this->visa_type_id,
                'employment_type_id' => $this->employment_type_id,
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
}