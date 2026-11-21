<?php

namespace App\Http\Controllers;

use App\Rules\SafeName;
use App\Models\Song;
use App\Models\Album;
use App\Models\Category;
use App\Helpers\MP3File;
use App\Helpers\UpdateMetadata;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Storage;

class SongController extends Controller
{
    public function getAllSongs()
    {
        $songs = Song::with('album')->orderBy('title')->get();
        $albums = Album::all();
        $categories = Category::all();

        foreach ($songs as $song) {
            $song->album;
        }
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

        $request->validate(['file.*' => 'file|mimes:mp3,m4a,aac,wav,ogg,oga,opus,amr,flac,wma,mp4,mpga']);

        $album = Album::find($albumId);
        if (!$album) {
            return response()->json([
                'error' => 'Album not found'
            ], 404);
        }
        $category = Category::findOrFail($album->category_id);
        try {
            if ($request->hasFile('file')) {
                $songFiles = $request->file('file');
                foreach ($songFiles as $songFile) {
                    $this->song_path = $songFile->storeAs(
                        config('app.storage_dir') . '/SAUTI/' . $category->name . '/' . $album->name,
                        $songFile->getClientOriginalName(),
                        'public'
                    );

                    $mp3File = new MP3File($songFile);
                    $originalDuration = $mp3File->getDurationEstimate(); //(faster) for CBR only
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
            return back()->with('error', $th);
            // return back()->with('error', 'Error occured! Try to check may be the title of the audio already existed in database');
        }

        if (REQ::is('api/*'))
            return response()->json([
                'Audios Uploaded Successfully'
            ], 200);
        return back()->with('success', 'Audio Files Added Successfully');
    }

    public function putSong(Request $request, $songId)
    {

        $request->validate([
            'file' => 'sometimes|nullable|file|mimes:mp3,m4a,aac,wav,ogg,oga,opus,amr,flac,wma,mp4,mpga',
            'title' => ['nullable', 'string', 'max:190', new SafeName()],
        ]);

        $song = Song::find($songId);
        if (!$song) {
            return back()->with(['error' => 'Song not found']);
        }
        $songToDelete = $song->file;
        $category = Category::findOrFail($song->album->category_id);
        try {
            if ($request->hasFile('file')) {

                $songFile = $request->file('file');
                $this->song_path = $songFile->storeAs(
                    config('app.storage_dir') . '/SAUTI/' . $category->name . '/' . $song->album->name,
                    $songFile->getClientOriginalName(),
                    'public'
                );

                $mp3File = new MP3File($songFile);
                $originalDuration = $mp3File->getDurationEstimate(); //(faster) for CBR only
                $duration = MP3File::formatTime($originalDuration);

                $song->update([
                    'title' => $songFile->getClientOriginalName(),
                    'duration' => $duration,
                    'size' => round(($songFile->getSize() / 1048576), 1),
                    'file' => $this->song_path,
                ]);


                $song->save();
                Storage::disk('public')->delete($songToDelete);
            } else {
                $newPath = config('app.storage_dir') . '/SAUTI/' . $category->name . '/' . $song->album->name . '/' . $request->title;
                Storage::disk('public')->move($song->file, $newPath);

                $song->update([
                    'title' => $request->input('title'),
                    'file' => $newPath,

                ]);
                $song->save();
            }
        } catch (\Throwable $th) {
            // dd($th);
            if (REQ::is('api/*'))
                return response()->json([
                    'Error occured! Try to check may be the title of the audio already existed in database'
                ], 200);
            return back()->with('error', 'Error occured! Try to check may be the title of the audio already existed in database');
        }

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
        Storage::disk('public')->delete($song->file);

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

    // ---------------------------------------------------------------
    // JSON endpoints for the new bulk uploader / ordering UI
    // ---------------------------------------------------------------

    private function albumDir(Album $album): string
    {
        $category = Category::findOrFail($album->category_id);
        return config('app.storage_dir') . '/SAUTI/' . $category->name . '/' . $album->name;
    }

    /** One file per request, so the browser can show real progress for each. */
    public function uploadOne(Request $request, $albumId)
    {
        $album = Album::find($albumId);
        if (!$album) {
            return response()->json(['ok' => false, 'error' => 'Albamu haipo'], 404);
        }

        $v = Validator::make($request->all(), [
            'file' => 'required|file|mimes:mp3,m4a,aac,wav,ogg,oga,opus,amr,flac,wma,mp4,mpga',
            'title' => ['required', 'string', 'max:190', new SafeName()],
        ]);
        if ($v->fails()) {
            return response()->json(['ok' => false, 'error' => $v->errors()->first()], 422);
        }

        $title = trim($request->input('title'));
        if (Song::where('title', $title)->exists()) {
            return response()->json(['ok' => false, 'error' => 'Jina hili tayari lipo. Litumie jina lingine.'], 422);
        }

        try {
            $file = $request->file('file');
            $ext = strtolower($file->getClientOriginalExtension() ?: 'mp3');
            $base = trim(preg_replace('~[\\\\/:*?"<>|]+~', '-', $title)) ?: 'audio';
            $name = $base . '.' . $ext;
            $dir = $this->albumDir($album);
            if (Storage::disk('public')->exists($dir . '/' . $name)) {
                $name = $base . '-' . time() . '.' . $ext;
            }
            $size = round($file->getSize() / 1048576, 1);

            $seconds = (int) round((float) $request->input('duration_sec', 0));
            if ($seconds <= 0 && $ext === 'mp3') {
                try {
                    $seconds = (int) (new MP3File($file))->getDurationEstimate();
                } catch (\Throwable $e) {
                    $seconds = 0;
                }
            }

            $path = $file->storeAs($dir, $name, 'public');

            $position = $request->filled('position')
                ? (int) $request->input('position')
                : ((int) Song::where('album_id', $album->id)->max('position')) + 1;

            $song = Song::create([
                'album_id' => $album->id,
                'title' => $title,
                'file' => $path,
                'duration' => MP3File::formatTime($seconds),
                'size' => $size,
                'position' => $position,
                'active' => $request->boolean('active', true),
            ]);
        } catch (\Throwable $th) {
            return response()->json(['ok' => false, 'error' => 'Imeshindikana kupakia: ' . $th->getMessage()], 500);
        }

        return response()->json(['ok' => true, 'id' => $song->id]);
    }

    public function setActive(Request $request, $songId)
    {
        $song = Song::find($songId);
        if (!$song) return response()->json(['ok' => false, 'error' => 'Sauti haipo'], 404);
        $song->update(['active' => $request->boolean('active')]);
        return response()->json(['ok' => true, 'active' => (bool) $song->active]);
    }

    public function renameJson(Request $request, $songId)
    {
        $song = Song::find($songId);
        if (!$song) return response()->json(['ok' => false, 'error' => 'Sauti haipo'], 404);
        $title = trim((string) $request->input('title'));
        if ($title === '') return response()->json(['ok' => false, 'error' => 'Jina haliwezi kuwa tupu'], 422);
        if (Song::where('title', $title)->where('id', '!=', $song->id)->exists()) {
            return response()->json(['ok' => false, 'error' => 'Jina hili tayari lipo'], 422);
        }
        $song->update(['title' => $title]);
        return response()->json(['ok' => true, 'title' => $song->title]);
    }

    public function reorder(Request $request, $albumId)
    {
        $ids = array_values(array_filter((array) $request->input('ids', []), 'is_numeric'));
        foreach ($ids as $i => $id) {
            Song::where('album_id', $albumId)->where('id', $id)->update(['position' => $i + 1]);
        }
        return response()->json(['ok' => true]);
    }

    public function destroyJson($songId)
    {
        $song = Song::find($songId);
        if (!$song) return response()->json(['ok' => false, 'error' => 'Sauti haipo'], 404);
        try {
            Storage::disk('public')->delete($song->file);
        } catch (\Throwable $e) {
        }
        $song->delete();
        return response()->json(['ok' => true]);
    }
}
