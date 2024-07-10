<?php

namespace App\Traits;

use App\Models\Phone;
use Illuminate\Database\Eloquent\Relations\MorphMany;
use Illuminate\Database\Eloquent\Relations\MorphOne;

trait Phonable
{
    public function phones(): MorphMany
    {
        return $this->morphMany(Phone::class, 'phonable');
    }

    public function phone(): MorphOne
    {
        return $this->morphOne(Phone::class, 'phonable');
    }

    public function storePhones(array $phones): void
    {
        foreach ($phones as $phoneData) {
            $this->addPhone($phoneData);
        }
    }

    public function addPhone(array $phone)
    {
        return $this->phone()->create([
            'country_code' => $phone['country_code'],
            'phone' => $phone['phone'],
            'extension' => isset($phone['extension']) ? $phone['extension'] : null,
            'holder_name' => isset($phone['holder_name']) ? $phone['holder_name'] : null,
            'type' => isset($phone['type']) ? $phone['type'] : 'mobile',
        ]);
    }



    public function updatePhone(Phone $phone, array $phoneData)
    {
        return $phone->update([
            'country_code' => isset($phoneData['country_code']) ? $phoneData['country_code'] : $phone->country_code,
            'phone' => isset($phoneData['phone']) ? $phoneData['phone'] : $phone->phone,
            'extension' => isset($phoneData['extension']) ? $phoneData['extension'] : $phone->extension,
            'holder_name' => isset($phoneData['holder_name']) ? $phoneData['holder_name'] : $phone->holder_name,
            'type' => isset($phoneData['type']) ? $phoneData['type'] : $phone->type,
        ]);
    }


    public function deletePhones(array $phoneIds)
    {
        $this->phones()->whereIn('id', $phoneIds)->delete();
    }
}
