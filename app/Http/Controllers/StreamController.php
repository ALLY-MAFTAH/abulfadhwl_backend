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
        return view('others/all_streams')->with('streams', $streams);
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
        return view('others/stream')->with('stream', $stream);
    }

    public function postStream(Request $request)
    {
        $attributes = $this->validate($request, [
            'timetable' => ['required', 'file'],
            'url' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        $timetable = $attributes['timetable'];
        $attributes['timetable'] = $timetable->storeAs(
            'streams',
            time() . '.' . $timetable->getClientOriginalExtension(),
            'public'
        );
        $attributes['status'] = true;
        Stream::create($attributes);

        return back()->with('message', 'Stream Added successfully');
    }

    public function putStream(Request $request, $streamId)
    {
        $stream = Stream::find($streamId);
        if (!$stream) return back()->with('message', 'Stream not found');

        $attributes = $this->validate($request, [
            'timetable' => 'sometimes|file',
            'url' => 'required',
            'title' => 'required',
            'description' => 'required'
        ]);

        if (isset($attributes['timetable'])) {
            $timetable = $attributes['timetable'];
            $attributes['timetable'] = $timetable->storeAs(
                'streams/timetable',
                time() . '.' . $timetable->getClientOriginalExtension(),
                'public'
            );
        }
        $stream->update($attributes);
        return back()->with('message', 'Stream edited successfully');
    }

    public function toggleStatus(Request $request, Stream $stream)
    {
        $stream->update([
            'status' => $request->input('status'),
        ]);
        $stream->save();
        return back()->with('message', 'Stream Switched Successfully');
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

        $pathToFile = storage_path('/app/public/' . $stream->timetable);
        return response()->download($pathToFile);
    }
}
