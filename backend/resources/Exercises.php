<?php

CONST LEG = 1;
CONST CHEST = 2;
CONST SHOULDER = 3;
CONST LATERAL_SHOULDER = 4;
CONST BACK_SHOULDER = 5;
const BACK = 6;
CONST HAMSTRING = 7;
CONST QUADRICEPS = 8;
CONST CALF = 9;
CONST BICEPS = 10;
CONST TRICEPS = 11;
CONST FOREARM = 12;
CONST ABS = 13;
CONST FRONTAL_SHOULDER = 14;



return [
    ['name' => 'Squat' ,'ec' => LEG],
    ['name' => 'Bench Press' ,'ec' => CHEST],
    ['name' => 'Deadlift' ,'ec' => BACK],
    ['name' => 'Military Press' ,'ec' => SHOULDER],
    ['name' => 'Barbell Row' ,'ec' => BACK],
    ['name' => 'Shoulder Press' ,'ec' => SHOULDER],
    ['name' => 'Lateral Raise' ,'ec' => LATERAL_SHOULDER],
    ['name' => 'Front Raise' ,'ec' => FRONTAL_SHOULDER],
    ['name' => 'Barbell Curl' ,'ec' => BICEPS],
    ['name' => 'Dumbell Curl' ,'ec' => BICEPS],
    ['name' => 'Cable Pushdown' ,'ec' => TRICEPS],
    ['name' => 'Skull Crusher' ,'ec' => TRICEPS],
];
