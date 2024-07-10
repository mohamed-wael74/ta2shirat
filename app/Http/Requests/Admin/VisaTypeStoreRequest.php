<?php

namespace App\Http\Requests\Admin;

use App\Models\VisaType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class VisaTypeStoreRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        return [
            'name' => ['required', 'string', 'min:2', 'max:50', Rule::unique('visa_type_translations', 'name')],
        ];
    }

    public function storeVisaType(): VisaType
    {
        return DB::transaction(function () {
            $visa_type = VisaType::create();

            $visa_type->translations()->create([
                'locale' => config('app.fallback_locale'),
                'name' => $this->name
            ]);

            return $visa_type->refresh();
        });
    }
}
