<?php

namespace App\Http\Controllers;

use App\Models\AnsweredQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class AnsweredQuestionController extends Controller
{

    public function getAllQuestions(Request $request)
    {
        $type = $request->get('type', 'all');
        $query = AnsweredQuestion::orderBy('updated_at', 'DESC');

        if ($type == 'answered') {
            $query->where(function ($q) {
                $q->whereNotNull('textAns')->orWhereNotNull('audioAns');
            });
        } elseif ($type == 'unanswered') {
            $query->whereNull('textAns')->whereNull('audioAns');
        } else {
            $type = 'all';
        }

        return view('feeds/all_questions_and_answers')->with(['questions' => $query->get(), 'type' => $type]);
    }
    public function getAllAnsweredQuestions()
    {

        $answeredQuestions = [];
        $questions = AnsweredQuestion::orderBy('updated_at', 'DESC')->get();

        foreach ($questions as $question) {
            if ($question->textAns != null || $question->audioAns != null) {

                $answeredQuestions[] = $question;
            }
        }
        return response()->json([ 'answeredQuestions' => $answeredQuestions], 200);
    }

    public function postQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qn' => 'required|string|max:2000',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 422);
        }
        $question = new AnsweredQuestion();
        $question->qn = $request->input('qn');
        $question->status = false;

        $question->save();
        return response()->json(['question' => $question], 200);
    }

    public function putAnsweredQuestion(Request $request, $answerId)
    {
        $answer = AnsweredQuestion::find($answerId);
        if (!$answer) {

            return back()->with('error','Question not found');
        }
        $attributes = $this->validate($request, [
            'qn' => 'required',
            'textAns' => 'nullable',
            'audioAns' => 'sometimes|nullable|file|mimes:mp3,m4a,aac,wav,ogg,oga,opus,amr,flac,wma,mp4,mpga',
        ]);

        if (isset($attributes['audioAns'])) {
            $audioAns = $attributes['audioAns'];
            $attributes['audioAns'] = $audioAns->storeAs(
                'answers/audioAns',
                time() . '.' . $audioAns->getClientOriginalExtension(),
                'public'
            );
        }

        $answer->update($attributes);
        return back()->with('success', 'Question Edited Successfully');
    }

    public function deleteAnsweredQuestion($answerId)
    {
        $answer = AnsweredQuestion::find($answerId);
        if (!$answer) {
            return response()->json([
                'error' => 'Answered Question does not exist'
            ], 404);
        }

        $answer->delete();
        return back()->with('success', 'Question Deleted Successfully');
    }


    public function viewAudioAnswer($answerId)
    {
        $answer = AnsweredQuestion::find($answerId);
        if (!$answer) {
            return response()->json([
                'error' => 'Question not found'
            ], 404);
        }

        $pathToFile = storage_path('/app/public/' . $answer->audioAns);
        return response()->download($pathToFile);
    }
}
