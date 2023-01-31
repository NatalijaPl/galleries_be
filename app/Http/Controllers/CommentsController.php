<?php

namespace App\Http\Controllers;

use App\Http\Requests\CommentRequest;
use App\Models\Comment;


class CommentsController extends Controller
{
    public function index()
    {
        return Comment::all();
    }
    public function store(CommentRequest $request, $galleryId)
    {
        $newComment = new Comment();
        $newComment->body = $request->body;
        $newComment->user_id = auth()->user()->id;
        $newComment->gallery_id = $galleryId;
        $newComment->save();

        $comment = Comment::with('user')->find($newComment->id);
        return $comment;
    }

    public function destroy($id)
    {
        $comment = Comment::find($id);
        $comment->delete();

        return response()->json([
            'message' => 'deleted'
        ]);
    }
}
