<?php

namespace App\Http\Controllers;

use App\Models\Song;
use App\Models\Album;
use App\Models\Category;
use App\Helpers\MP3File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Http\Request;


class SongController extends Controller
{
    public function getAllSongs()
    {
        $songs = Song::all();
        $albums = Album::all();
        $categories = Category::all();
        if (REQ::is('api/*'))
            return response()->json([
                'songs' => $songs
            ], 200, [], JSON_NUMERIC_CHECK);

        return view('turaath.audios.all_songs')->with(['songs' => $songs, 'albums' => $albums, 'categories' => $categories]);
    }

    public function getSingleSong($songId)
    {
        $song = Song::find($songId);
        $albums = Album::all();
        $categories = Category::all();

        if (!$song) {
            return response()->json([
                'error' => 'Song not found'
            ], 404);
        }
        if (REQ::is('api/*'))
            return response()->json([
                'song' => $song
            ], 200);
        return view('turaath.audios.song')->with(['song' => $song, 'albums' => $albums, 'categories' => $categories]);
    }

    // Fetch Song Names For Searching in App
    public function getAllSongNames()
    {
        $songNames = [];
        $songs = Song::latest()->get();

        if (!$songs) return response()->json(['error' => 'Songs not found'], 404);

        foreach ($songs as $song) {
            $songNames[] = $song->title;
        }
        if (REQ::is('api/*')) return response()->json($songNames, 200);
    }

    public function postSong(Request $request, $albumId)
    {

        $album = Album::find($albumId);
        if (!$album) {
            return response()->json([
                'error' => 'Album not found'
            ], 404);
        }
        $category=Category::findOrFail($album->category_id);
        try {


            if ($request->hasFile('file')) {
                $songFiles = $request->file('file');
                foreach ($songFiles as $songFile) {
                    $this->song_path = $songFile->storeAs(
                        config('app.name') . '/SAUTI/' .$category->name.'/'. $album->name,
                        $songFile->getClientOriginalName() . '.' . $songFile->getClientOriginalExtension(),
                        'public'
                    );

                    $mp3file = new MP3File($songFile);
                    $originalDuration = $mp3file->getDurationEstimate(); //(faster) for CBR only
                    $duration = MP3File::formatTime($originalDuration);

                    $song = new Song();
                    $song->title = $songFile->getClientOriginalName();
                    $song->duration = $duration;
                    $song->size = round(($songFile->getSize() / 1048576), 1);
                    $song->file = $this->song_path;

                    $album->songs()->save($song);

                }
            } else return response()->json([
                'error' => 'Add an audio file'
            ], 404);
            //code...
        } catch (\Throwable $th) {
            if (REQ::is('api/*'))
                return response()->json([
                    'Error occured! Try to check may be the title of the audio already existed in database'
                ], 200);
            return back()->with('error', 'Error occured! Try to check may be the title of the audio already existed in database');
        }

        if (REQ::is('api/*'))
            return response()->json([
                'Audios Uploaded Successfully'
            ], 200);
        return back()->with('success', 'Audio Files Added Successfully');
    }

    public function putSong(Request $request, $songId)
    {
        $song = Song::find($songId);
        if (!$song) {
            return response()->json([
                'error' => 'Song not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'title' => 'required',
        ]);

        // validator fails
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $song->update([
            'title' => $request->input('title'),
        ]);

        $song->save();

        return back()->with('success', 'Audio edited successfully');
    }

    public function deleteSong($songId)
    {
        $song = Song::findOrFail($songId);

        if (!$song) {
            return response()->json([
                'error' => 'Song not found'
            ], 404);
        }

        $song->delete();
        if (REQ::is('api/*'))
            return response()->json([
                'success' => 'Song deleted successfully'
            ], 200);
        return back()->with('success', 'Audio deleted successfully');
    }


    public function viewSongFile($songId)
    {
        $song = Song::find($songId);
        if (!$song) {
            return response()->json([
                'error' => 'Song not exists'
            ], 404);
        }
        $pathToFile = storage_path('/app/public/' . $song->file);
        return response()->download($pathToFile);
    }
}
