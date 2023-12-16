<?php

namespace App\Http\Controllers;

use App\Models\TrainingLogs;
use App\Models\TrainingExerciseLogs;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class TrainingLogsController extends Controller
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
    public function store(Request $request)
    {
        $user = Auth::user();

        $trainingLog = TrainingLogs::create([
            'user_id' => $user->id
        ]);

        return apiResponse(200, 'Başarılı', 'Log Başarıyla güncellendi', [
            'id' => $trainingLog->id
        ])->toSuccess();
    }

    public function update(TrainingLogs $trainingLogs, Request $request)
    {
        $attributes = $request->validate([
            'training_day_id' => 'sometimes|exists:training_days,id',
            'training_id' => 'sometimes|exists:trainings,id',
            'isCompleted' => 'sometimes|boolean'
        ]);

        $trainingLogs->update($attributes);

        return apiResponse(201, 'Başarılı', 'Log Başarıyla güncellendi', $trainingLogs)->toSuccess();
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
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }

    public function complete(Request $request)
    {
        $user = Auth::user();

        $trainingLog = TrainingLogs::where([
            ['id', $request->training_log_id],
            ['user_id', $user->id],
            ['is_completed', false]
        ])->latest()->first();

        if (!$trainingLog) {
            return apiResponse(404, 'Hata', 'Log bulunamadı')->toFail();
        }

        $trainingLog->update([
            'is_completed' => true
        ]);

        return apiResponse(200, 'Başarılı', 'Log Başarıyla güncellendi', $trainingLog)->toSuccess();
    }

    public function last(TrainingLogs $trainingLogs)
    {
        $user = Auth::user();

        $lastTrainingLog = $trainingLogs->where([
            ['user_id', $user->id],
            ['is_completed', false]
        ])->latest()->first();

        if (!$lastTrainingLog) {
            return apiResponse(404, 'Hata', 'Log bulunamadı')->toFail();
        }

        return apiResponse(200, 'Başarılı', 'Log bulundu', [
            'id' => $lastTrainingLog->id,
            'training_id' => $lastTrainingLog->training_id,
            'training_day_id' => $lastTrainingLog->training_day_id,
            'exercises' => TrainingExerciseLogs::where('training_log_id', $lastTrainingLog->id)->get()
        ])->toSuccess();
    }
}
