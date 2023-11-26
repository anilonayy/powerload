<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TrainingsController extends Controller
{
    public function store(Request $request) {

        $response = [];

        $trainings = $request->validate([
            'train' => 'required|array'
        ]);

        foreach ($trainings as $key => $train) {
            $response[] = $train['trainName'];
        }

        return apiResponse(200,'Başarılı', 'İşlem Başarılı!',$response)->toSuccess();
    }
}
