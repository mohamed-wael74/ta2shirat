<?php

return [

    /*
    |--------------------------------------------------------------------------
    | Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | The following language lines contain the default error messages used by
    | the validator class. Some of these rules have multiple versions such
    | as the size rules. Feel free to tweak each of these messages here.
    |
    */
    'accepted' => 'يجب قبول :attribute',
    'accepted_if' => ':attribute يجب قبوله عندما يكون :other بقيمة :value.',
    'active_url' => ':attribute يجب ان يكون عنوان URL صحيح.',
    'after' => ':attribute يجب ان يكون بعد تاريخ :date.',
    'after_or_equal' => ':attribute يجب ان يكون تاريخ بعد او مطابق لتاريخ :date.',
    'alpha' => ':attribute يجب ان يحتوي على احرف فقط.',
    'alpha_dash' => ':attribute يجب ان يحتوي فقط على احرف وارقام وشرطات وشرطات سفلية.',
    'alpha_num' => ':attribute يجب ان يحتوي على حروف وارقام فقط.',
    'array' => 'يجب أن يكون :attribute ًمصفوفة',
    'ascii' => ':attribute يجب أن يحتوي فقط على أحرف أبجدية رقمية ورموز أحادية البايت.',
    'before' => ':attribute يجب ان يكون تاريخ قبل :date.',
    'before_or_equal' => ':attribute يجب ان يكون تاريخ قبل او مطابق لتاريخ :date.',
    'between' => [
        'array' => 'يجب أن يحتوي :attribute على عدد من العناصر بين :min و :max',
        'file' => 'يجب أن يكون حجم الملف :attribute بين :min و :max كيلوبايت.',
        'numeric' => ':attribute يجب ان تكون قيمته بين :min و :max.',
        'string' => 'يجب أن يحتوي :attribute علي عدد احرف بين :min و :max.'
    ],
    'boolean' => 'يجب أن تكون قيمة :attribute إما صحيحة أو خاطئة.',
    'can' => 'يحتوي :attribute على قيمة غير مسموح بها.',
    'confirmed' => 'التأكيد غير مُطابق لل:attribute',
    'current_password' => 'كلمة المرور غير صحيحة.',
    'date' => ':attribute يجب ان يكون تاريخ صالح.',
    'date_equals' => ':attribute يجب ان يكون تاريخ يطابق :date.',
    'date_format' => ':attribute يجب ان يتطابق مع الصيغة :format.',
    'decimal' => ':attribute يجب ان يحتوي علي :decimal رقم عشري.',
    'declined' => 'يجب رفض :attribute.',
    'declined_if' => 'يجب رفض :attribute في حال ما إذا كان :other يساوي :value.',
    'different' => 'يجب أن يكون ن :attribute و :other مُختلفان.',
    'digits' => 'يجب أن يحتوي :attribute على :digits رقمًا/أرقام.',
    'digits_between' => 'يجب أن يحتوي :attribute بين :min و :max رقمًا/أرقام.',
    'dimensions' => 'الـ :attribute يحتوي على أبعاد صورة غير صالحة.',
    'distinct' => 'يحتوي :attribute علي قيمة مُكرّرة.',
    'doesnt_end_with' => ':attribute يجب ألا ينتهي بواحدة من القيم التالية: :values.',
    'doesnt_start_with' => ':attribute يجب ألا يبدأ بواحدة من القيم التالية: :values.',
    'email' => 'يجب أن يكون :attribute عنوان بريد إلكتروني صحيح.',
    'ends_with' => 'الـ :attribute يجب ان ينتهي بأحد القيم التالية :value.',
    'enum' => 'المحدد :attribute غير صالح.',
    'exists' => 'المحدد :attribute غير صالح.',
    'file' => 'الـ :attribute يجب ان يكون ملف.',
    'filled' => ':attribute يجب ان يحتوي علي قيمة.',
    'gt' => [
        'array' => 'الـ :attribute يجب ان يحتوي علي اكثر من :value عناصر/عنصر.',
        'file' => 'الـ :attribute يجب ان يكون اكبر من :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اكبر من :value.',
        'string' => 'الـ :attribute يجب ان يكون اكبر من :value حروفٍ/حرفًا.',
    ],
    'gte' => [
        'array' => 'الـ :attribute يجب ان يحتوي علي :value عناصر/عنصر او اكثر.',
        'file' => 'الـ :attribute يجب ان يكون اكبر من او يساوي :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اكبر من او يساوي :value.',
        'string' => 'الـ :attribute يجب ان يكون اكبر من او يساوي :value حروفٍ/حرفًا.',
    ],
    'image' => 'يجب أن يكون :attribute صورةً.',
    'in' => 'المحدد :attribute غير صالح.',
    'in_array' => ':attribute غير موجود في :other.',
    'integer' => 'يجب أن يكون :attribute عددًا صحيحًا',
    'ip' => 'يجب أن يكون :attribute عنوان IP صحيح.',
    'ipv4' => 'يجب أن يكون :attribute عنوان IPv4 صحيح.',
    'ipv6' => 'يجب أن يكون :attribute عنوان IPv6 صحيح.',
    'json' => 'يجب أن يكون :attribute نص JSON صالح.',
    'lowercase' => ':attribute يجب ان يكون حروف صغيرة',
    'lt' => [
        'array' => 'الـ :attribute يجب ان يحتوي علي اقل من :value عناصر/عنصر.',
        'file' => 'الـ :attribute يجب ان يكون اقل من :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اقل من :value.',
        'string' => 'الـ :attribute يجب ان يكون اقل من :value حروفٍ/حرفًا.',
    ],
    'lte' => [
        'array' => 'الـ :attribute يجب ان يحتوي علي اكثر من :value عناصر/عنصر.',
        'file' => 'الـ :attribute يجب ان يكون اقل من او يساوي :value كيلو بايت.',
        'numeric' => 'الـ :attribute يجب ان يكون اقل من او يساوي :value.',
        'string' => 'الـ :attribute يجب ان يكون اقل من او يساوي :value حروفٍ/حرفًا.',
    ],
    'mac_address' => 'يجب أن يكون :attribute عنوان MAC صحيح.',
    'max' => [
        'array' => 'يجب أن لا يحتوي :attribute على أكثر من :max عناصر/عنصر.',
        'file' => 'حجم الملف :attribute لا يجب ان يتجاوز :max كيلوبايت.',
        'numeric' => 'لا يجب ان تكون قيمة :attribute اكبر من :max.',
        'string' => 'لا يجب ان يكون طول :attribute اكبر من :max حروفٍ/حرفًا.',
    ],
    'max_digits' => ':attribute يجب ألا يحتوي أكثر من :max أرقام.',
    'mimes' => ':attribute يجب ان يكون ملف من نوع: :values.',
    'mimetypes' => ':attribute يجب ان يكون ملف من نوع: :values.',
    'min' => [
        'array' => 'يجب أن يحتوي :attribute على الأقل على :min عُنصرًا/عناصر',
        'file' => 'يجب أن يكون حجم الملف :attribute على الأقل :min كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة  :attribute مساوية أو أكبر لـ :min.',
        'string' => 'يجب أن يكون طول نص :attribute على الأقل :min حروفٍ/حرفًا',
    ],
    'min_digits' => ':attribute يجب أن يحتوي :min أرقام على الأقل.',
    'missing' => ':attribute يجب تركه.',
    'missing_if' => ':attribute يجب تركه عندما تكون قيمة :other تساوي :value.',
    'missing_unless' => ':attribute يجب تركه الا عندما تكون قيمة :other تساوي :value.',
    'missing_with' => ':attribute يجب تركه عند وجود القيمة :values.',
    'missing_with_all' => ':attribute يجب تركه عند وجود القيم :values.',
    'multiple_of' => ':attribute يجب أن يكون من مضاعفات :value.',
    'not_in' => ' المحدد:attribute غير صالح',
    'not_regex' => 'صيغة :attribute غير صالحة.',
    'numeric' => ':attribute يجب ان يكون رقم.',
    'password' => [
        'letters' => 'يجب ان يشمل :attribute على حرف واحد على الاقل.',
        'mixed' => 'يجب ان يشمل :attribute على حرف واحد بصيغة كبيرة على الاقل وحرف اخر بصيغة صغيرة.',
        'numbers' => 'يجب ان يشمل :attribute على رقم واحد على الاقل.',
        'symbols' => 'يجب ان يشمل :attribute على رمز واحد على الاقل.',
        'uncompromised' => ':attribute تبدو غير آمنة. الرجاء اختيار قيمة اخرى.',
    ],
    'present' => 'يجب تقديم :attribute',
    'prohibited' => ':attribute محظور',
    'prohibited_if' => ':attribute محظور في حال ما إذا كان :other يساوي :value.',
    'prohibited_unless' => ':attribute محظور في حال ما لم يكون :other يساوي :value.',
    'prohibits' => ':attribute يحظر :other من اي يكون موجود',
    'regex' => 'صيغة :attribute غير صالحة.',
    'required' => ':attribute مطلوب.',
    'required_array_keys' => ':attribute يجب ان يحتوي علي مدخلات للقيم التالية :values.',
    'required_if' => ':attribute مطلوب في حال ما إذا كان :other يساوي :value.',
    'required_if_accepted' => ':attribute مطلوب عندما يكون :other مقبول.',
    'required_unless' => ':attribute مطلوب في حال ما لم يكن :other يساوي :values.',
    'required_with' => ':attribute مطلوب إذا توفّر :values.',
    'required_with_all' => ':attribute مطلوب إذا توفّر :values.',
    'required_without' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'required_without_all' => ':attribute مطلوب إذا لم يتوفّر :values.',
    'same' => 'يجب أن يتطابق :attribute مع :other',
    'size' => [
        'array' => 'يجب أن يحتوي :attribute على :size عنصرٍ/عناصر بالظبط',
        'file' => 'يجب أن يكون حجم الملف :attribute :size كيلوبايت',
        'numeric' => 'يجب أن تكون قيمة :attribute مساوية لـ :size',
        'string' => 'يجب أن يحتوي النص :attribute على :size حروفٍ/حرفًا بالظبط',
    ],
    'starts_with' => ':attribute يجب ان يبدأ بأحد القيم التالية: :values.',
    'string' => 'يجب أن يكون :attribute نصآ.',
    'timezone' => 'يجب أن يكون :attribute نطاقًا زمنيًا صحيحًا.',
    'unique' => 'قيمة :attribute مُستخدمة من قبل',
    'uploaded' => 'فشل في تحميل الـ :attribute.',
    'uppercase' => ':attribute يجب ان يكون باحرف كبيرة.',
    'url' => 'صيغة الرابط :attribute غير صحيحة',
    'ulid' => ':attribute يجب ان يكون ULID صالح.',
    'uuid' => ':attribute يجب ان يكون UUID صالح.',

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Language Lines
    |--------------------------------------------------------------------------
    |
    | Here you may specify custom validation messages for attributes using the
    | convention "attribute.rule" to name the lines. This makes it quick to
    | specify a specific custom language line for a given attribute rule.
    |
    */

    'custom' => [
        'attribute-name' => [
            'rule-name' => 'custom-message',
        ],
    ],

    /*
    |--------------------------------------------------------------------------
    | Custom Validation Attributes
    |--------------------------------------------------------------------------
    |
    | The following language lines are used to swap our attribute placeholder
    | with something more reader friendly such as "E-Mail Address" instead
    | of "email". This simply helps us make our message more expressive.
    |
    */

    'attributes' => [],

];
