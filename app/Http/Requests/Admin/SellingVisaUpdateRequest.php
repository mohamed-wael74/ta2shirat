<?php

namespace App\Http\Requests\Admin;

use App\Models\StatusType;
use Illuminate\Foundation\Http\FormRequest;

class SellingVisaUpdateRequest extends FormRequest
{
    private StatusType $statusType;
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
            'status_type' => [
                'required',
                'integer',
                'exists:status_types,id',
                function ($attribute, $value, $fail) {
                    $this->statusType = StatusType::find($value);
                    if (!$this->selling_visa->canUpdateStatus($this->statusType->type)) {
                        return $fail(__('selling_visas.errors.invalid_status'));
                    }
                }
            ]
        ];
    }

    public function updateSellingVisa()
    {
        if (in_array($this->statusType->type, ['rejected', 'sold'])) {
            $this->selling_visa->update([
                'is_done' => true
            ]);
        }

        $this->selling_visa->activateStatus($this->status_type);

        $this->selling_visa->refresh();
    }

    public function attributes()
    {
        return [
            'status_type' => __('selling_visas.status_type'),
        ];
    }
}
