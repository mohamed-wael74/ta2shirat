<?php

namespace App\Http\Requests\Admin;

use Illuminate\Foundation\Http\FormRequest;

class CountryUpdateRequest extends FormRequest
{
    public function authorize()
    {
        return true;
    }

    public function rules()
    {
        $supportedLocales = implode(',', array_keys(config('localization.supportedLocales')));

        return [
            'locale' => 'required|string|in:' . $supportedLocales,
            'name' => 'sometimes|string|max:50',
            'available' => 'sometimes|boolean',
        ];
    }

    public function updateCountry()
    {
        $this->country->update([
            'is_available' => $this->exists('available') ? $this->available : $this->country->is_available,
        ]);

        $this->country->translations()->updateOrCreate(
            [
                'locale' => $this->input('locale')
            ],
            [
                'name' => $this->exists('name') ? $this->name : $this->country->name
            ]
        );

        return $this->country->refresh();
    }
}
