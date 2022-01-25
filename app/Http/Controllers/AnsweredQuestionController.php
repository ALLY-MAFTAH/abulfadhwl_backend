<?php

namespace App\Http\Controllers;

use App\AnsweredQuestion;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class AnsweredQuestionController extends Controller
{

    public function getAllQuestions(Request $request)
    {
        $type = 'all';
        $questions = null;
        $allQuestions = AnsweredQuestion::all();

        $type = $request->get('type', $type);

        if ($type == "answered") {
            foreach ($allQuestions as $question) {
                if ($question->textAns != null || $question->audioAns != null) {

                    $answeredQuestions[] = $question;
                }
                $questions = $answeredQuestions;
            }
        } elseif ($type == "unanswered") {
            foreach ($allQuestions as $question) {
                $questions = $question->where(['textAns' => null, 'audioAns' => null])->get();
            }
        } else {

            $questions = $allQuestions;
        }
        // dd($type);

        return view('feeds/all_questions_and_answers')->with(['questions' => $questions, 'type' => $type]);
    }
    public function getAllAnsweredQuestions()
    {

        $answeredQuestions = [];
        $questions = AnsweredQuestion::all();

        foreach ($questions as $question) {
            if ($question->textAns != null || $question->audioAns != null) {

                $answeredQuestions[] = $question;
            }
        }
        return response()->json([
            'answeredQuestions' => $answeredQuestions
        ], 200);
    }

    public function postQuestion(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qn' => 'required',
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }
        $question = new AnsweredQuestion();
        $question->qn = $request->input('qn');
        $question->status = false;

        $question->save();
        return response()->json([
            'question' => $question
        ], 200);
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
            'audioAns' => 'sometimes|file|nullable',
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
        return back()->with('message', 'Umefanikiwa kujibu swali hili');
    }

    public function deleteAnsweredQuestion($answerId)
    {
        $answer = AnsweredQuestion::find($answerId);
        if (!$answer) {
            return response()->json([
                'error' => 'AnsweredQuestion does not exist'
            ], 404);
        }

        $answer->delete();
        return back()->with('message', 'Umefanikiwa kufuta swali hili');
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
