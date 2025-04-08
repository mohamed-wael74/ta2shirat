<?php

namespace App\Http\Requests\Website;

use App\Models\StatusType;
use Illuminate\Foundation\Http\FormRequest;

class SellingVisaUpdateRequest extends FormRequest
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
            //
        ];
    }

    public function updateSellingVisa()
    {
        $this->selling_visa->update([
            'is_done' => true,
        ]);

        $canceledStatusType = StatusType::where('type', 'canceled')->first();
        $this->selling_visa->activateStatus($canceledStatusType->id);

        $this->selling_visa->refresh();
    }
}
