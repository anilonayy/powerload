<?php

return [
    'required' => ':field zorunlu bir alandır.',
    'min' => [
        'string' => ':field en az :min karakter olmalıdır.',
        'numeric' => ':field en az :min olmalıdır.',
    ],
    'max' => [
        'string' => ':field en fazla :max karakter olmalıdır.',
        'numeric' => ':field en fazla :max olmalıdır.',
    ],
    'unique' => ':field alanı zaten kullanılmaktadır. Lütfen farklı bir :field giriniz.',
    'letters' => ':field en az bir harf içermelidir.',
    'numbers' => ':field en az bir sayı içermelidir.',
    'symbols' => ':field en az bir sembol içermelidir.',
    'validate' => 'Lütfen geçerli bir :field giriniz.',
    'exists' => 'Bu :field ile ilgili bir kayıt bulunamadı.',
];
