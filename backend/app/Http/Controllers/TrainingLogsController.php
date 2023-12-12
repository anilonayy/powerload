<?php

namespace App\Http\Controllers;

use App\Models\TrainingLogs;
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

        return apiResponse(201, 'Başarılı', 'Log Başarıyla oluşturuldu', [
            'id' => $trainingLog->id
        ])->toSuccess();
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
            'id' => $lastTrainingLog->id
        ])->toSuccess();
    }
}
