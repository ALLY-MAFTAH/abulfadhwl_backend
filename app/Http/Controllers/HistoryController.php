<?php

namespace App\Http\Controllers;

use App\Models\History;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;
use App\Support\HtmlCleaner;

class HistoryController extends Controller
{
    public function getAllHistories()
    {
        $histories = History::orderBy('section')->orderBy('id')->get();
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
        $rules = ['section' => 'nullable|integer|min:1|max:9999', 'heading' => 'required|string|max:190', 'content' => 'required'];
        if (REQ::is('api/*')) {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'status' => false], 404);
            }
        } else {
            $request->validate($rules);
        }

        $content = HtmlCleaner::clean($request->input('content'));
        if ($content === '') {
            if (REQ::is('api/*')) return response()->json(['error' => 'content is empty', 'status' => false], 422);
            return back()->withInput()->withErrors(['content' => 'Maudhui hayawezi kuwa tupu.']);
        }

        $history = new History();
        $history->section = $request->filled('section') ? (int) $request->input('section') : ((int) History::max('section')) + 1;
        $history->heading = trim($request->input('heading'));
        $history->content = $content;
        $history->save();

        if (REQ::is('api/*'))
            return response()->json(['history' => $history], 200);
        return redirect()->route('histories')->with('success', 'Sehemu imeongezwa');
    }

    public function putHistory(Request $request, $historyId)
    {
        $history = History::find($historyId);
        if (!$history) {
            if (REQ::is('api/*')) return response()->json(['error' => 'History not found'], 404);
            return redirect()->route('histories')->with('error', 'Sehemu haipo');
        }
        $rules = ['section' => 'nullable|integer|min:1|max:9999', 'heading' => 'required|string|max:190', 'content' => 'required'];
        if (REQ::is('api/*')) {
            $validator = Validator::make($request->all(), $rules);
            if ($validator->fails()) {
                return response()->json(['error' => $validator->errors(), 'status' => false], 404);
            }
        } else {
            $request->validate($rules);
        }

        $content = HtmlCleaner::clean($request->input('content'));
        if ($content === '') {
            if (REQ::is('api/*')) return response()->json(['error' => 'content is empty', 'status' => false], 422);
            return back()->withInput()->withErrors(['content' => 'Maudhui hayawezi kuwa tupu.']);
        }

        $history->update([
            'section' => $request->filled('section') ? (int) $request->input('section') : $history->section,
            'heading' => trim($request->input('heading')),
            'content' => $content,
        ]);

        if (REQ::is('api/*'))
            return response()->json(['history' => $history], 200);
        return redirect()->route('histories')->with('success', 'Sehemu imehifadhiwa');
    }

    // Rich editor pages (web only)
    public function create()
    {
        return view('others/history/history_form', ['history' => null, 'nextSection' => ((int) History::max('section')) + 1]);
    }

    public function edit($historyId)
    {
        $history = History::findOrFail($historyId);
        return view('others/history/history_form', ['history' => $history, 'nextSection' => $history->section]);
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
