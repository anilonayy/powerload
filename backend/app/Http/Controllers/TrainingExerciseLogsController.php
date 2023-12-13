<?php

namespace App\Http\Controllers;

use App\Models\TrainingExerciseLogs;
use App\Models\TrainingLogs;
use Illuminate\Http\Request;
use Auth;

class TrainingExerciseLogsController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(TrainingLogs $trainingLogs, Request $request)
    {
        $trainingLogs->user_id === Auth::user()->id || abort(403, 'Yetkiniz yok');

        $responseLogs = [];

        $attributes = $request->validate([
            'sets' => 'required',
            'sets.*.id' => 'required|numeric',
            'sets.*.weight' => 'required|numeric',
            'sets.*.reps' => 'required|numeric',
            'exercise_id' => 'required|exists:exercises,id'
        ]);

        TrainingExerciseLogs::where([['training_log_id', $trainingLogs->id],['exercise_id', $attributes['exercise_id']]])->delete();

        foreach($attributes['sets'] as $set) {
            $set['training_log_id'] = $trainingLogs->id;
            $set['exercise_id'] = $attributes['exercise_id'];

            if($set['id'] != null) {
                TrainingExerciseLogs::where([
                    ['id', $set['id']],
                    ['training_log_id', $trainingLogs->id]
                ])->update([
                    'weight' => $set['weight'],
                    'reps' => $set['reps']
                ]);

                continue;
            }

            $responseLogs[] = TrainingExerciseLogs::create([
                'training_log_id' => $trainingLogs->id,
                'exercise_id' => $attributes['exercise_id'],
                'weight' => $set['weight'],
                'reps' => $set['reps']
            ]);
        }

        return apiResponse(200, 'Başarılı', 'Log Başarıyla oluşturuldu',$responseLogs)->toSuccess();
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
