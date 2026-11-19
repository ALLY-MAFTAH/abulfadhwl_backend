<?php

namespace App\Http\Controllers;

use App\Models\Stream;
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
        return view('others.all_streams')->with('streams', $streams);
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
        return view('others.stream')->with('stream', $stream);
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
        \App\Services\FcmV1::signalRefresh('streams');

        return back()->with('success', 'Stream Added successfully');
    }

    public function putStream(Request $request, $streamId)
    {
        $stream = Stream::find($streamId);
        if (!$stream) return back()->with('error', 'Stream not found');

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
        \App\Services\FcmV1::signalRefresh('streams');
        return back()->with('success', 'Stream edited successfully');
    }

    public function toggleStatus(Request $request, Stream $stream)
    {
        $was = (bool) $stream->status;
        $stream->update([
            'status' => $request->input('status'),
        ]);
        $stream->save();
        $now = (bool) $stream->status;

        if ($now !== $was) {
            // Going live or ending: a visible notification for everyone. It
            // also makes open apps reload the darsa status (data.refresh).
            \App\Services\FcmV1::sendToTopic(
                'all',
                $now ? 'Darsa ya moja kwa moja imeanza' : 'Darsa ya moja kwa moja imekwisha',
                $now
                    ? $stream->title . ' — bonyeza kusikiliza sasa'
                    : $stream->title . ' imekwisha. Asanteni kwa kusikiliza.',
                null,
                ['link' => 'abulfadhwl://open/stream/' . $stream->id, 'refresh' => 'streams']
            );
        } else {
            \App\Services\FcmV1::signalRefresh('streams');
        }
        return back()->with('success', 'Stream Switched Successfully');
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
        \App\Services\FcmV1::signalRefresh('streams');
        if (REQ::is('api/*'))
            return response()->json([
                'success' => 'Stream deleted successfully'
            ], 200);
        return back()->with('success', 'Stream deleted successfully');
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
