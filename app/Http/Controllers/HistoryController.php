<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;

class HistoryController extends Controller
{
    public function getAllHistories()
    {
        $histories = History::all();
        if (REQ::is('api/*'))
            return response()->json([
                'histories' => $histories
            ], 200);
        return view('others/history/all_histories')->with('histories', $histories);
    }

    public function getSingleHistory($historyId)
    {
        $history = History::find($historyId);
        if (!$historyId) {
            return response()->json([
                'error' => 'History not found'
            ], 404);
        }
        if (REQ::is('api/*'))

            return response()->json([
                'history' => $history
            ], 200);
        return view('others/history/history')->with('history', $history);
    }

    public function postHistory(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'section' => 'required',
            'heading' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $history = new History();
        $history->section = $request->input('section');
        $history->heading = $request->input('heading');
        $history->content = $request->input('content');

        $history->save();
        if (REQ::is('api/*'))
            return response()->json([
                'history' => $history
            ], 200);
        return back()->with('success', 'History added successfully');
    }

    public function putHistory(Request $request, $historyId)
    {
        $history = History::find($historyId);
        if (!$history) {
            return response()->json([
                'error' => 'History not found'
            ], 404);
        }
        $validator = Validator::make($request->all(), [
            'section' => 'required',
            'heading' => 'required',
            'content' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $history->update([
            'section' => $request->input('section'),
            'heading' => $request->input('heading'),
            'content' => $request->input('content')
        ]);
        $history->save();
        if (REQ::is('api/*'))
            return response()->json([
                'history' => $history
            ], 200);
        return back()->with('success', 'History edited successfully');
    }

    public function deleteHistory($historyId)
    {
        $history = History::find($historyId);
        if (!$history) {
            return response()->json([
                'error' => 'History does not exist'
            ], 404);
        }

        $history->delete();
        if (REQ::is('api/*'))

            return response()->json([
                'success' => 'History deleted successfully'
            ], 200);
        return back()->with('success', 'History deleted successfully');
    }
}
