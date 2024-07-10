<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class VisaTypeUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $supportedLocales = implode(',', array_keys(config('localization.supportedLocales')));

        return [
            'locale' => ['required', 'string', 'in:' . $supportedLocales],
            'name' => ['required', 'string', 'min:2', 'max:50', Rule::unique('visa_type_translations', 'name')->ignore($this->visa_type->id, 'visa_type_id')],
        ];
    }

    public function updateVisaType()
    {
        $this->visa_type->translations()->updateOrCreate(
            ['locale' => $this->input('locale')],
            ['name' => $this->name]
        );
    }
}
