<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class CommentController extends Controller
{
    public function getAllComments()
    {
        $comments = Comment::latest()->get();
        if (REQ::is('api/*'))
            return response()->json([
                'comments' => $comments
            ], 200);
        return view('feeds/all_comments')->with('comments', $comments);
    }

    public function getSingleComment($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$commentId) {
            return response()->json([
                'error' => 'Comment not found'
            ], 404);
        }
        return response()->json(['comment' => $comment], 200);
    }

    public function postComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'phone' => 'required',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $comment = new Comment();
        $comment->full_name = $request->input('full_name');
        $comment->phone = $request->input('phone');
        $comment->message = $request->input('message');

        $comment->save();
        return response()->json(['comment' => $comment], 200);
    }

    public function putComment(Request $request, $commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment) {
            return response()->json([
                'error' => 'Comment not found'
            ], 404);
        }

        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'phone' => 'required',
            'message' => 'required'
        ]);

        if ($validator->fails()) {
            return response()->json([
                'error' => $validator->errors(),
                'status' => false
            ], 404);
        }

        $comment->update([
            'full_name' => $request->input('full_name'),
            'phone' => ltrim($request->input('phone'), '+'),
            'message' => $request->input('message')
        ]);
        $comment->save();
        return response()->json(['comment' => $comment], 200);
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment) {
            return response()->json(['error' => 'Comment does not exist'], 404);
        }

        $comment->delete();
        if (REQ::is('api/*'))
            return response()->json([
                'success' => 'Comment deleted successfully'
            ], 200);
        return back()->with('success', 'Comment deleted successfully');
    }
}
