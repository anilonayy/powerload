<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Auth;

class TrainingsController extends Controller
{
    public function store(Request $request) {

        $user = Auth::user();

        $payload = $request->validate([
            'train' =>  'required',
            'train.trainName' => 'required|string',
            'train.days' => 'required|array',
            'train.days.*.name' => 'required|string',
            'train.days.*.exercises' => 'required|array',
            'train.days.*.exercises.*.sets' => 'required|integer',
            'train.days.*.exercises.*.reps' => 'required|integer',
            'train.days.*.exercises.*.selected.value' => 'required|integer|exists:exercises,id',
        ]);

        $training =  Training::create([
            'user_id' => $user->id,
            'name' => $payload['train']['trainName']
        ]);

        foreach($payload['train']['days'] as $day) {
            $trainingDay = $training->days()->create([
                'name' => $day['name']
            ]);

            foreach($day['exercises'] as $exercise) {
                $trainingDay->exercises()->create([
                    'exercise_id' => $exercise['selected']['value'],
                    'sets' => $exercise['sets'],
                    'reps' => $exercise['reps'],
                ]);
            }
        }

        return apiResponse(200,'Başarılı', 'İşlem Başarılı!',[
            'payload' => $payload
        ])->toSuccess();
    }
}
