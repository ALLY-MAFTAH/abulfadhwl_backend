<?php

namespace App\Http\Controllers;

use App\Answer;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class AnswerController extends Controller
{
    public function getAllAnswers()
    {
        $answers = Answer::all();

        if (REQ::is('api/*'))
            return response()->json([
                'answers' => $answers
            ], 200);
        return view('all_questions_and_answers')->with('answers', $answers);
    }

    public function getSingleAnswer($answerId)
    {
        $answer = Answer::find($answerId);
        if (!$answerId) {
            return response()->json([
                'error' => 'Answer not found'
            ], 404);
        }
        return response()->json([
            'answer' => $answer
        ], 200);
    }

    public function postAnswer(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'qn' => 'required',
            'ans' => 'required'

        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $answer = new Answer();
        $answer->qn = $request->input('qn');
        $answer->ans = $request->input('ans');

        $answer->save();
        return back()->with('message', 'Umefanikiwa kuweka jibu la swali hili');
    }

    public function putAnswer(Request $request, $answerId)
    {
        $answer = Answer::find($answerId);
        if (!$answer) {
            return response()->json([
                'error' => 'Answer not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'qn' => 'required',
            'ans' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $answer->update([
            'qn' => $request->input('qn'),
            'ans' => $request->input('ans'),

        ]);
        $answer->save();
        return back()->with('message', 'Umefanikiwa kurekebisha jibu la swali hili');

    }

    public function deleteAnswer($answerId)
    {
        $answer = Answer::find($answerId);
        if (!$answer) {
            return response()->json([
                'error' => 'Answer does not exist'
            ], 404);
        }

        $answer->delete();
        return back()->with('message', 'Umefanikiwa kufuta jibu la swali hili');

    }
}
