<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class EmploymentTypeUpdateRequest extends FormRequest
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
        $supportedLocales = implode(',', array_keys(config('localization.supportedLocales')));

        return [
            'locale' => 'required|string|in:' . $supportedLocales,
            'name' => 'sometimes|string|max:30|min:5',
        ];
    }

    public function updateEmploymentType()
    {
        $this->employment_type->translations()->updateOrCreate(
            ['locale' => $this->validated('locale')],
            ['name' => $this->exists('name') ? $this->name : $this->employment_type->name]
        );
        return $this->employment_type->refresh();
    }
}
