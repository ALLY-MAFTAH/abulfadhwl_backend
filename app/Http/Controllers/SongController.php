<?php

namespace App\Http\Controllers;

use App\Song;
use App\Album;
use App\Category;
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

        return view('turaath/audios/all_songs')->with(['songs' => $songs, 'albums' => $albums, 'categories' => $categories]);
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
        return view('turaath/audios/song')->with(['song' => $song, 'albums' => $albums, 'categories' => $categories]);
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

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'description' => 'required',
            'file' => 'required',

        ]);

        // validator fails
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }
        if ($request->hasFile('file')) {
            $this->song_path = $request->file('file')->storeAs(config('app.name').'/SAUTI/'.$album->name ,
            $request->title . '.' . $request->file('file')->getClientOriginalExtension(),
            'public');
        } else return response()->json([
            'message' => 'Add an audio file'
        ], 404);

        $song = new Song();
        $song->title = $request->input('title');
        $song->description = $request->input('description');
        $song->file = $this->song_path;

        $album->songs()->save($song);
        if (REQ::is('api/*'))
            return response()->json([
                'song' => $song
            ], 200);
        return back()->with('message', 'Audio added successfully');
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
            'description' => 'required',

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
            'description' => $request->input('description'),
        ]);

        $song->save();

        return back()->with('message', 'Audio edited successfully');
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
                'message' => 'Song deleted successfully'
            ], 200);
        return back()->with('message', 'Audio deleted successfully');
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
