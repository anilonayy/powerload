<?php

namespace App\Http\Controllers;

use App\Enums\ResponseMessageEnums;
use App\Models\Training;
use App\Models\TrainingLogs;
use App\Traits\ResponseMessage;
use Illuminate\Http\Request;
use Auth;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;

class TrainingsController extends Controller
{
    use ResponseMessage;

    public function index()
    {
        $user = Auth::user();
        $trainings = Training::select('name','id','created_at')
            ->where('user_id', $user->id)->orderBy('id','asc') ->get();

        return response()->json($this->getSuccessMessage($trainings));
    }

    public function history()
    {
        $user = Auth::user();

        $logs = TrainingLogs::with('training','training_day','exercises')->where([
            ['user_id', $user->id],
            ['is_completed', 1],
        ])->orderBy('id','desc')->get();

        return response()->json($this->getSuccessMessage($logs));
    }

    public function indexDetail()
    {
        $user = Auth::user();
        $trainings = Training::with('days')->where('user_id', $user->id)->orderBy('id','asc') ->get();

        return response()->json($this->getSuccessMessage($trainings));
    }

    public function show($id)
    {
        $user =  Auth::user();

        $training = Training::select('id','name')->with(['days'])->where([
            ['id','=',$id],
            ['user_id','=',$user->id]
        ])->first();

        return response()->json($this->getSuccessMessage($training));
    }

    public function showDays(string $trainingId)
    {
        $user =  Auth::user();

        $days = Training::select('id','name')->with(['days'])->where([
            ['id','=', $trainingId],
            ['user_id','=', $user->id]
        ])->first()->days;

        return response()->json($this->getSuccessMessage($days));
    }

    public function showExercises(string $trainingId, string $dayId)
    {
        $user =  Auth::user();

        $exercises = Training::select('id','name')->with(['days'])->where([
            ['id','=', $trainingId],
            ['user_id','=', $user->id]
        ])->first()->days->find($dayId)->exercises;

        return response()->json($this->getSuccessMessage($exercises));
    }

    public function store(Request $request)
    {
        $user = Auth::user();
        $payload = $this->validatePayload($request);

        $training =  Training::create([
            'user_id' => $user->id,
            'name' => $payload['train']['name']
        ]);

        $this->addTrainingDaysByPayload($training, $payload);

        return response()->json($this->getSuccessMessage($training));
    }

    public function destroy(Training $training)
    {
        Training::where([
            ['user_id', Auth::user()->id],
            ['id' , $training->id]
        ])->delete();

        return response()->json($this->getSuccessMessage());
    }

    public function update(Training $training,Request $request)
    {
        $payload = $this->validatePayload($request);
        $training->days()->delete();

        $this->addTrainingDaysByPayload($training,$payload);

        return response()->json($this->getSuccessMessage($training->days()));
    }

    public function validatePayload(Request $request)
    {
        return $request->validate([
            'train' =>  'required',
            'train.name' => 'required|string',
            'train.days' => 'required|array',
            'train.days.*.name' => 'required|string',
            'train.days.*.exercises' => 'required|array',
            'train.days.*.exercises.*.sets' => 'required|integer',
            'train.days.*.exercises.*.reps' => 'required|integer',
            'train.days.*.exercises.*.selected.value' => 'required|integer|exists:exercises,id',
        ]);
    }

    public function addTrainingDaysByPayload(Training $training,array $payload):void
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
}
