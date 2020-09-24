<?php

namespace App\Http\Controllers;

use App\Link;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Request as REQ;
use Illuminate\Support\Facades\Validator;

class LinkController extends Controller
{

    public function getAllLinks()
    {
        $links = Link::all();
        if (REQ::is('api/*'))
            return response()->json([
                'links' => $links
            ], 200);
        return view('all_links')->with('links', $links);
    }
    public function getSingleLink($linkId)
    {
        $link = Link::find($linkId);
        if (!$linkId) {
            return response()->json([
                'error' => 'Link not found'
            ], 404);
        }
        if (REQ::is('api/*'))

            return response()->json([
                'link' => $link
            ], 200);
        return view('link')->with('link', $link);
    }

    public function postLink(Request $request)
    {
        $this->path = null;

        $validator = Validator::make($request->all(), [
            'title' => 'required',
            'url' => 'required',
            'icon' => 'required'

        ]);

        if ($validator->fails()) {

            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        if ($request->hasFile('icon')) {
            $this->icon_path = $request->file('icon')->store('links');
        } else return response()->json([
            'message' => 'Add a icon file'
        ], 404);

        $link = new Link();
        $link->title = $request->input('title');
        $link->url = $request->input('url');
        $link->icon = $this->icon_path;


        $link->save();
        if (REQ::is('api/*'))

            return response()->json([
                'link' => $link
            ], 200);
        return back()->with('message', 'Link added successfully');
    }

    public function putLink(Request $request, $linkId)
    {
        $link = Link::find($linkId);
        if (!$link) {
            return response()->json([
                'error' => 'Link not found'
            ], 404);
        }
        $link->update([
            'title' => $request->input('title'),
            'url' => $request->input('url'),
        ]);
        $link->save();
        if (REQ::is('api/*'))

        return response()->json([
            'link' => $link
        ], 200);
        return back()->with('message', 'Link edited successfully');

    }

    public function deleteLink($linkId)
    {
        $link = Link::find($linkId);
        if (!$link) {
            return response()->json([
                'error' => 'Link does not exist'
            ], 404);
        }

        $link->delete();
        if (REQ::is('api/*'))

        return response()->json([
            'message' => 'Link deleted successfully'
        ], 200);
        return back()->with('message', 'Link deleted successfully');

    }

    public function viewIconFile($linkId)
    {
        $link = Link::find($linkId);
        if (!$link) {
            return response()->json([
                'error' => 'Link not found'
            ], 404);
        }

        $pathToFile = storage_path('/app/' . $link->icon);
        return response()->download($pathToFile);
    }
}
