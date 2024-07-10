<?php

namespace App\Http\Requests\Admin;

use App\Models\EmploymentType;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\DB;

class EmploymentTypeStoreRequest extends FormRequest
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
            'name' => 'required|string|max:30|min:5'
        ];
    }

    public function storeEmploymentType()
    {
        return DB::transaction(function () {
            $employmentType = EmploymentType::create();
            $employmentType->translations()->create([
                'name' => $this->name,
                'locale' => config('app.fallback_locale')
            ]);
            return $employmentType->refresh();
        });
    }
}
