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
        $apiLinks = Link::where('status', 1)->latest()->get();
        $webLinks = Link::latest()->get();
        if (REQ::is('api/*'))
            return response()->json([
                'links' => $apiLinks
            ], 200);
        return view('others/all_links')->with('links', $webLinks);
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
        return view('others/link')->with('link', $link);
    }

    public function postLink(Request $request)
    {
        $attributes = $this->validate($request, [
            'type' => 'required',
            'title' => 'required',
            'url' => 'required',
            'icon' => ['required', 'file'],
        ]);

        $icon = $attributes['icon'];
        $attributes['icon'] = $icon->storeAs(
            'links',
            time() . '.' . $icon->getClientOriginalExtension(),
            'public'
        );
        $attributes['status'] = false;
        Link::create($attributes);

        return back()->with('message', 'Link added successfully');
    }

    public function putLink(Request $request, $linkId)
    {
        $link = Link::find($linkId);
        if (!$link) return back()->with('message', 'Stream not found');

        $attributes = $this->validate($request, [
            'icon' => 'sometimes|file',
            'url' => 'required',
            'title' => 'required',
            'type' => 'required'
        ]);

        if (isset($attributes['icon'])) {
            $icon = $attributes['icon'];
            $attributes['icon'] = $icon->storeAs(
                'links/icon',
                time() . '.' . $icon->getClientOriginalExtension(),
                'public'
            );
        }
        $link->update($attributes);
        return back()->with('message', 'Link edited successfully');
    }

    public function toggleStatus(Request $request, Link $link)
    {
        $link->update([
            'status' => $request->input('status'),
        ]);

        $link->save();
        return back()->with('message', 'Link Switched Successfully');
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

        $pathToFile = storage_path('/app/public/' . $link->icon);
        return response()->download($pathToFile);
    }
}
