<?php

namespace App\Http\Controllers;

use App\Comment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\Request as REQ;

class CommentController extends Controller
{
    public function getAllComments()
    {
        $comments = Comment::all();
        if(REQ::is('api/*'))
        return response()->json([
            'comments' => $comments
        ], 200);
        return view('all_comments')->with('comments',$comments);
    }

    public function getSingleComment($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$commentId) {
            return response()->json([
                'error' => 'Comment not found'
            ], 404);
        }
        return response()->json([
            'comment' => $comment
        ], 200);
    }

    public function postComment(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required',
            'email' => 'required',
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
        $comment->email = $request->input('email');
        $comment->message = $request->input('message');

        $comment->save();
        return response()->json([
            'comment' => $comment
        ], 200);
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
            'email' => 'required',
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
            'email' => $request->input('email'),
            'message' => $request->input('message')
        ]);
        $comment->save();
        return response()->json([
            'comment' => $comment
        ], 200);
    }

    public function deleteComment($commentId)
    {
        $comment = Comment::find($commentId);
        if (!$comment) {
            return response()->json([
                'error' => 'Comment does not exist'
            ], 404);
        }

        $comment->delete();
        if(REQ::is('api/*'))
        return response()->json([
            'message' => 'Comment deleted successfully'
        ], 200);
        return back()->with('message','Comment deleted successfully');
    }
}
