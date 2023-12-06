<?php

namespace App\Http\Controllers;

use App\Models\Training;
use Illuminate\Http\Request;
use Auth;

class TrainingsController extends Controller
{

    public function index()
    {
        $user = Auth::user();
        $trainings = Training::select('name','id','created_at')->where('user_id', $user->id)->orderBy('id','asc') ->get();

        return apiResponse(200,'İşlem Başarılı','İşlem başarıyla gerçekleştirildi', $trainings)->toSuccess();
    }

    public function show($id)
    {
        $user =  Auth::user();

        $training = Training::select('id','name')->with(['days'])->where([
            ['id','=',$id],
            ['user_id','=',$user->id]
        ])->first();

        return apiResponse(200,'','',$training)->toSuccess();
    }

    public function store(Request $request)
    {
        $user = Auth::user();

        $payload = $request->validate([
            'train' =>  'required',
            'train.name' => 'required|string',
            'train.days' => 'required|array',
            'train.days.*.name' => 'required|string',
            'train.days.*.exercises' => 'required|array',
            'train.days.*.exercises.*.sets' => 'required|integer',
            'train.days.*.exercises.*.reps' => 'required|integer',
            'train.days.*.exercises.*.selected.value' => 'required|integer|exists:exercises,id',
        ]);

        $training =  Training::create([
            'user_id' => $user->id,
            'name' => $payload['train']['name']
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
