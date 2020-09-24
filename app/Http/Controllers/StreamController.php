<?php

namespace App\Http\Controllers;

use App\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class StreamController extends Controller
{
    public function getAllStreams()
    {
        $streams = Stream::all();
        if (REQ::is('api/*'))
            return response()->json([
                'streams' => $streams
            ], 200);
        return view('all_streams')->with('streams', $streams);
    }
    public function getSingleStream($streamId)
    {
        $stream = Stream::find($streamId);
        if (!$streamId) {
            return response()->json([
                'error' => 'Stream not found'
            ], 404);
        }
        if (REQ::is('api/*'))

            return response()->json([
                'stream' => $stream
            ], 200);
        return view('stream')->with('stream', $stream);
    }

    public function postStream(Request $request)
    {
        $this->path = null;

        $validator = Validator::make($request->all(), [
            'timetable' => 'required',
            'url' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        if ($request->hasFile('timetable')) {
            $this->timetable_path = $request->file('timetable')->store('streams');
        } else return response()->json([
            'message' => 'Add a timetable file'
        ], 404);


        $stream = new Stream();
        $stream->url = $request->input('url');
        $stream->title = $request->input('title');
        $stream->description = $request->input('description');
        $stream->timetable = $this->timetable_path;

        $stream->save();
        if (REQ::is('api/*'))

            return response()->json([
                'stream' => $stream
            ], 200);
        return back()->with('message', 'Stream Added successfully');
    }

    public function putStream(Request $request, $streamId)
    {
        $stream = Stream::find($streamId);
        if (!$stream) {
            return response()->json([
                'error' => 'Stream not found'
            ], 404);
        }

        $stream->update([
            'url' => $request->input('url'),
            'title' => $request->input('title'),
            'description' => $request->input('description')
        ]);
        $stream->save();
        if (REQ::is('api/*'))

            return response()->json([
                'stream' => $stream
            ], 200);
        return back()->with('message', 'Stream edited successfully');
    }

    public function deleteStream($streamId)
    {
        $stream = Stream::find($streamId);
        if (!$stream) {
            return response()->json([
                'error' => 'Stream does not exist'
            ], 404);
        }

        $stream->delete();
        if (REQ::is('api/*'))
            return response()->json([
                'message' => 'Stream deleted successfully'
            ], 200);
        return back()->with('message', 'Stream deleted successfully');
    }

    public function viewTimetableFile($streamId)
    {
        $stream = Stream::find($streamId);
        if (!$stream) {
            return response()->json([
                'error' => 'Stream not found'
            ], 404);
        }

        $pathToFile = storage_path('/app/' . $stream->timetable);
        return response()->download($pathToFile);
    }
}
