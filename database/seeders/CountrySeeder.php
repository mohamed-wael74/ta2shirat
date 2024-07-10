<?php

namespace Database\Seeders;

use App\Models\Country;
//use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class CountrySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $file = file_get_contents(base_path('seedFiles/countries.json'));
        $data = json_decode($file);
        $countries = collect($data);

        foreach ($countries as $countryData) {
            $phone_code = explode('+', $countryData->phone_code);

            $country = Country::create([
                'code' =>  !empty($phone_code[0]) ? '00' . $phone_code[0] : '00' . $phone_code[1],
                'flag' => $countryData->emoji
            ]);

            $country->translations()->create([
                'locale' => 'en',
                'name' => $countryData->name,
            ]);

            $translations = collect($countryData->translations);

            foreach ($translations as $locale => $translation) {
                if (in_array($locale, array_keys(config('localization.supportedLocales', true)))) {
                    $country->translations()->create([
                        'locale' => $locale,
                        'name' => $translation,
                    ]);
                }
            }
        }
    }
}
