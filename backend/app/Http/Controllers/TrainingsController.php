<?php

namespace App\Http\Controllers;

use App\Enums\ResponseMessageEnums;
use App\Http\Requests\Training\CreateTrainingRequest;
use App\Http\Requests\Training\UpdateTrainingRequest;
use App\Models\Training;
use App\Models\TrainingDay;
use App\Models\TrainingLogs;
use App\Traits\ResponseMessage;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingsController extends Controller
{
    use ResponseMessage;

    public function index(): JsonResponse
    {
        $trainings = Training::select('name','id','created_at')->where('user_id', auth()->user()->id)
            ->orderBy('id','asc') ->get();

        return response()->json($this->getSuccessMessage($trainings));
    }

    public function history(): JsonResponse
    {
        $logs = TrainingLogs::with('training:id,name','training_day:id,name','exercises')
            ->where([
                ['user_id', auth()->user()->id],
                ['is_completed', 1],
            ])->orderBy('id','desc')->get();

        return response()->json($this->getSuccessMessage($logs));
    }

    public function allWithDetails(): JsonResponse
    {
        $trainings = Training::with('days')->where('user_id', auth()->user()->id)->orderBy('id','asc') ->get();

        return response()->json($this->getSuccessMessage($trainings));
    }

    public function show(Training $training): JsonResponse
    {
        $this->checkTrainingOwner($training);
        $training =  $training->select('id','name')->with(['days'])->first();

        return response()->json($this->getSuccessMessage($training));
    }

    public function showExercises(TrainingDay $trainingDay): JsonResponse
    {
        $this->checkTrainingDayOwner($trainingDay);
        return response()->json($this->getSuccessMessage($trainingDay->exercises));
    }

    public function store(CreateTrainingRequest $request): JsonResponse
    {
        $payload = $request->validated();

        $training =  Training::create([
            'user_id' => auth()->user()->id,
            'name' => $payload['train']['name']
        ]);

        $this->addTrainingDaysByPayload($training, $payload);

        return response()->json($this->getSuccessMessage($training));
    }

    public function update(Training $training, UpdateTrainingRequest $request): JsonResponse
    {
        $this->checkTrainingOwner($training);
        $payload = $request->validated();

        $training->days()->delete();
        $this->addTrainingDaysByPayload($training,$payload);

        return response()->json($this->getSuccessMessage($training->days()));
    }

    public function destroy(Training $training): JsonResponse
    {
        $this->checkTrainingOwner($training);
        $training->delete();

        return response()->json($this->getSuccessMessage());
    }

    public function addTrainingDaysByPayload(Training $training, array $payload): void
    {
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
    }

    private function checkTrainingOwner (Training $training): void
    {
        if ($training->user_id !== auth()->user()->id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }

    private function checkTrainingDayOwner (TrainingDay $trainingDay): void
    {
        if ($trainingDay->training->user_id !== auth()->user()->id) {
            throw new NotFoundHttpException(ResponseMessageEnums::FORBIDDEN, code: Response::HTTP_FORBIDDEN);
        }
    }
}
