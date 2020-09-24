<?php

namespace App\Http\Controllers;

use App\Question;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class QuestionController extends Controller
{
    public function getAllQuestions()
    {
        $questions = Question::all();
        if (REQ::is('api/*'))
            return response()->json(['answeredQuestions' => $questions]);

        return view('questions')->with('questions', $questions);
    }

    // public function getAllAnsweredQuestions()
    // {
    //     $questions = Question::all();
    //     $newQuestions = $questions->where('ans', !'Empty');
    //     $answeredQuestions = $newQuestions->reject(function ($question, $key) {
    //         return $question->ans != "Empty";
    //     })->values();
    //     // }
    //     return response()->json(['answeredQuestions' => $answeredQuestions]);
    // }

    public function getSingleQuestion($questionId)
    {
        $question = Question::find($questionId);
        if (!$questionId) {
            return response()->json([
                'error' => 'Question not found'
            ], 404);
        }
        return response()->json([
            'question' => $question
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

        $question = new Question();
        $question->qn = $request->input('qn');

        $question->save();
        return response()->json([
            'question' => $question
        ], 200);
    }

    public function putQuestion(Request $request, $questionId)
    {
        $question = Question::find($questionId);
        if (!$question) {
            return response()->json([
                'error' => 'Question not found'
            ], 404);
        }

        $question->update([
            'qn' => $request->input('qn'),

        ]);
        $question->save();

        return back()->with('message', 'Jibu limefanikiwa kuwekwa');
    }

    public function deleteQuestion($questionId)
    {
        $question = Question::find($questionId);
        if (!$question) {
            return response()->json([
                'error' => 'Question does not exist'
            ], 404);
        }

        $question->delete();
        return back()->with('message', 'Swali limefanikiwa kufutwa');
    }
}
