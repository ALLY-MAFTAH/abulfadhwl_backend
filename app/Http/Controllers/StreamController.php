<?php

namespace App\Http\Controllers;

use App\Rules\PlainText;
use App\Models\Stream;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class StreamController extends Controller
{
    public function getAllStreams()
    {
        $streams = Stream::timetableOrder();
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
            'timetable' => ['nullable', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif'],
            'url' => ['required', 'url', 'max:500', 'starts_with:http://,https://'],
            'title' => ['required', 'string', 'max:160', new PlainText()],
            'description' => ['nullable', 'string', 'max:300', new PlainText()],
            'time_label' => ['nullable', 'string', 'max:120', new PlainText()],
            'book' => ['nullable', 'string', 'max:160', new PlainText()],
            'day' => ['nullable', 'in:' . implode(',', array_keys(Stream::DAYS))],
            'teacher' => ['nullable', 'string', 'max:120', new PlainText()],
        ]);
        $attributes['description'] = $attributes['description'] ?? '';
        $attributes['position'] = (int) Stream::max('position') + 1;
        $attributes['translations'] = \App\Support\Translations::collect($request, ['title', 'description', 'book', 'time_label', 'teacher']);

        if ($request->hasFile('timetable')) {
            $timetable = $request->file('timetable');
            $attributes['timetable'] = $timetable->storeAs(
                'streams',
                time() . '.' . $timetable->getClientOriginalExtension(),
                'public'
            );
        } else {
            // every lesson shares the weekly timetable picture
            $attributes['timetable'] = (string) Stream::where('timetable', '!=', '')->latest()->value('timetable');
        }
        $attributes['status'] = false;
        Stream::create($attributes);
        \App\Services\FcmV1::signalRefresh('streams');

        return back()->with('success', 'Darsa imeongezwa');
    }

    /** One weekly timetable picture for every lesson. */
    public function setTimetable(Request $request)
    {
        $request->validate(['timetable' => ['required', 'file', 'image', 'mimes:jpg,jpeg,png,webp,gif']]);
        $file = $request->file('timetable');
        $path = $file->storeAs('streams', 'ratiba-' . time() . '.' . $file->getClientOriginalExtension(), 'public');
        Stream::query()->update(['timetable' => $path]);
        \App\Services\FcmV1::signalRefresh('streams');
        return back()->with('success', 'Ratiba ya wiki imesasishwa');
    }

    public function putStream(Request $request, $streamId)
    {
        $stream = Stream::find($streamId);
        if (!$stream) return back()->with('error', 'Stream not found');

        $attributes = $this->validate($request, [
            'timetable' => 'sometimes|nullable|file|image|mimes:jpg,jpeg,png,webp,gif',
            'url' => ['required', 'url', 'max:500', 'starts_with:http://,https://'],
            'title' => ['required', 'string', 'max:160', new PlainText()],
            'description' => ['nullable', 'string', 'max:300', new PlainText()],
            'time_label' => ['nullable', 'string', 'max:120', new PlainText()],
            'book' => ['nullable', 'string', 'max:160', new PlainText()],
            'day' => ['nullable', 'in:' . implode(',', array_keys(Stream::DAYS))],
            'teacher' => ['nullable', 'string', 'max:120', new PlainText()],
        ]);

        $attributes['description'] = $attributes['description'] ?? '';
        $attributes['translations'] = \App\Support\Translations::collect($request, ['title', 'description', 'book', 'time_label', 'teacher']);

        if ($request->hasFile('timetable')) {
            $timetable = $attributes['timetable'];
            $attributes['timetable'] = $timetable->storeAs(
                'streams/timetable',
                time() . '.' . $timetable->getClientOriginalExtension(),
                'public'
            );
        }
        if (!$request->hasFile('timetable')) unset($attributes['timetable']);
        $stream->update($attributes);
        \App\Services\FcmV1::signalRefresh('streams');
        return back()->with('success', 'Darsa imehaririwa');
    }

    /**
     * Dashboard switch. OFF: end whichever lesson is live. ON: go live with
     * the lesson scheduled for today (by its timetable day).
     */
    public function toggleLive(Request $request)
    {
        $want = filter_var($request->input('status'), FILTER_VALIDATE_BOOLEAN);

        if (!$want) {
            $response = back();
            foreach (Stream::where('status', 1)->get() as $live) {
                $response = $this->toggleStatus($request, $live);
            }
            return $response;
        }

        $today = Stream::forToday();
        if (!$today) {
            $msg = 'Hakuna darsa iliyopangwa leo (' . (Stream::DAYS[Stream::todayKey()] ?? '') . '). Weka siku kwenye darsa kwanza.';
            if ($request->expectsJson()) return response()->json(['ok' => false, 'error' => $msg], 422);
            return back()->with('error', $msg);
        }
        return $this->toggleStatus($request, $today);
    }

    public function toggleStatus(Request $request, Stream $stream)
    {
        $want = filter_var($request->input('status'), FILTER_VALIDATE_BOOLEAN);
        $was = (bool) $stream->status;

        if ($want) {
            // only one lesson can be live: switch the others off quietly
            Stream::where('id', '!=', $stream->id)->where('status', 1)->update(['status' => 0]);
        }
        $stream->update(['status' => $want]);
        $now = (bool) $stream->status;

        if ($now !== $was) {
            // Going live or ending: a visible notification for everyone. It
            // also makes open apps reload the darsa status (data.refresh).
            $t = fn (string $lang) => \App\Support\Translations::pick($stream, 'title', $lang);
            $link = ['link' => 'abulfadhwl://open/stream/' . $stream->id, 'refresh' => 'streams'];
            \App\Services\FcmV1::sendLocalized($now ? [
                'sw' => ['Darsa ya moja kwa moja imeanza', $t('sw') . ' — bonyeza kusikiliza sasa'],
                'en' => ['The live lesson has started', $t('en') . ' — tap to listen now'],
                'ar' => ['بدأ الدرس المباشر', $t('ar') . ' — اضغط للاستماع الآن'],
            ] : [
                'sw' => ['Darsa ya moja kwa moja imekwisha', $t('sw') . ' imekwisha. Asanteni kwa kusikiliza.'],
                'en' => ['The live lesson has ended', $t('en') . ' has ended. Thank you for listening.'],
                'ar' => ['انتهى الدرس المباشر', 'انتهى ' . $t('ar') . '. شكراً لاستماعكم.'],
            ], null, $link);
        } else {
            \App\Services\FcmV1::signalRefresh('streams');
        }

        if ($request->expectsJson()) {
            return response()->json(['ok' => true, 'live_id' => $now ? $stream->id : null]);
        }
        return back()->with('success', $now ? 'Darsa iko LIVE sasa' : 'Darsa imezimwa');
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

        if (!$stream->timetable) {
            return response()->json(['error' => 'Timetable not found'], 404);
        }
        $pathToFile = storage_path('/app/public/' . $stream->timetable);
        return response()->download($pathToFile);
    }
}
