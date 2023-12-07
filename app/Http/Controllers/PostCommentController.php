<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\BlogPost;
use App\Http\Requests\StoreComment;

class PostCommentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['store']);
    }

    public function store(BlogPost $post, StoreComment $request)
    {
        // Comment::create()
        $post->comments()->create([
            'content' => $request->input('content'),
            'user_id' => $request->user()->id
        ]);


        session()->flash('status', 'Comment was created!');

        return redirect()->back();
    }
}
