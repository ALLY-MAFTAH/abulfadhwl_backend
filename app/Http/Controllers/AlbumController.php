<?php

namespace App\Http\Controllers;

use App\Album;
use App\Song;
use App\Category;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class AlbumController extends Controller
{

    // Get all albums
    public function getAllAlbums()
    {
        $albums = Album::all();
        $categories=Category::all();

        foreach ($albums as $album) {
            $album->songs;
        }
        if(REQ::is('api/*'))
        return response()->json([
            'albums' => $albums
        ], 200);
        return view('all_albums')->with(['albums'=>$albums,'categories'=>$categories]);
    }

    // Get a single album
    public function getSingleAlbum($albumId)
    {
        $album = Album::find($albumId);
        if (!$album) {
            return response()->json([
                'error' => "Album not found"
            ], 404);
        }
        $album->songs;
        if(REQ::is('api/*'))
        return response()->json([
            'album' => $album
        ], 200);
        return view('album')->with('album',$album);
    }

    // Post an Album
    public function postAlbum(Request $request, $categoryId)
    {
        $category = Category::find($categoryId);
        if (!$category) {
            return response()->json([
                'error' => "Category not found"
            ], 404);
        }

        // Validate if the request sent contains these parameters
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',

        ]);


        // If validator fails
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $album = new Album();
        $album->name = $request->input('name');
        $album->description = $request->input('description');

        // Save the Album
        $category->albums()->save($album);
        if(REQ::is('api/*'))
        return response()->json([
            'album' => $album
        ], 202);
        return back()->with('message','Album added successfully');
    }

    public function putAlbum(Request $request, $albumId)
    {
        $album = Album::find($albumId);
        if (!$album) {
            return response()->json([
                'error' => "Album not found"
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'description' => 'required',

        ]);


        // If validator fails
        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $album->update([
            'name' => $request->input('name'),
            'description' => $request->input('description'),
        ]);

        $album->save();
            if(REQ::is('api/*'))
        return response()->json([
            'album' => $album
        ], 206);
        return back()->with('message','Album edited successfully');
    }

    // Delete album
    public function deleteAlbum($albumId)
    {
        $album = Album::find($albumId);
        if (!$album) {
            return response()->json([
                'error' => 'Album does not exists'
            ], 204);
        }

        $album->delete();
        if(REQ::is('api/*'))
        return response()->json([
            'album' => 'Album deleted successfully'
        ], 200);
        return back()->with('message', 'Album deleted successfully');
    }

}
