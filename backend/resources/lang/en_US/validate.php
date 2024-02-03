<?php

return [
    'required' => ':field field is required.',
    'min' => [
        'string' => ':field must be least :min characters.',
        'numeric' => ':field must be least :min.'
    ],
    'max' => [
        'string' => ':field must be less than :max characters.',
        'numeric' => ':field must be less than :max.'
    ],
    'unique' => ':field is already in use. Please enter a different :field.',
    'letters' => ':field must contain at least one letter.',
    'numbers' => ':field must contain at least one number.',
    'symbols' => ':field must contain at least one symbol.',
    'validate' => 'Please enter a valid :field.',
    'exists' => 'We can not find a resource with :field  field.'
];
