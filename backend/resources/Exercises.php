<?php

const LEG = 1;
const CHEST = 2;
const SHOULDER = 3;
const LATERAL_SHOULDER = 4;
const BACK_SHOULDER = 5;
const BACK = 6;
const HAMSTRING = 7;
const QUADRICEPS = 8;
const CALF = 9;
const BICEPS = 10;
const TRICEPS = 11;
const FOREARM = 12;
const ABS = 13;
const FRONTAL_SHOULDER = 14;

return [
    ['name' => 'Squat', 'ec' => LEG],
    ['name' => 'Front Squat', 'ec' => LEG],
    ['name' => 'Dumbell Squat', 'ec' => LEG],
    ['name' => 'Leg Press', 'ec' => LEG],
    ['name' => 'Leg Extension', 'ec' => LEG],
    ['name' => 'Single Leg Lunge', 'ec' => LEG],

    ['name' => 'Bench Press', 'ec' => CHEST],
    ['name' => 'Incline Bench Press', 'ec' => CHEST],
    ['name' => 'Dumbell Press', 'ec' => CHEST],
    ['name' => 'Incline Dumbell Press', 'ec' => CHEST],
    ['name' => 'Dumbell Fly', 'ec' => CHEST],
    ['name' => 'Cable Fly', 'ec' => CHEST],
    ['name' => 'Dumbell Pullover', 'ec' => CHEST],

    ['name' => 'Lat Pulldown', 'ec' => BACK],
    ['name' => 'Barbell Row', 'ec' => BACK],
    ['name' => 'Deadlift', 'ec' => BACK],
    ['name' => 'Dumbell Row', 'ec' => BACK],
    ['name' => 'Rope Pulldown', 'ec' => BACK],
    ['name' => 'Z Bar Pull Down', 'ec' => BACK],
    ['name' => 'Pull Up', 'ec' => BACK],

    ['name' => 'Military Press', 'ec' => SHOULDER],
    ['name' => 'Shoulder Press', 'ec' => SHOULDER],
    ['name' => 'Arnold Press', 'ec' => SHOULDER],

    ['name' => 'Lateral Raise', 'ec' => LATERAL_SHOULDER],
    ['name' => 'Front Raise', 'ec' => FRONTAL_SHOULDER],

    ['name' => 'Barbell Curl', 'ec' => BICEPS],
    ['name' => 'Dumbell Curl', 'ec' => BICEPS],
    ['name' => 'Hammer Curl', 'ec' => BICEPS],
    ['name' => 'Spider Curl', 'ec' => BICEPS],

    ['name' => 'Triceps Pushdown', 'ec' => TRICEPS],
    ['name' => 'Cable Pushdown', 'ec' => TRICEPS],
    ['name' => 'Skull Crusher', 'ec' => TRICEPS],
];
