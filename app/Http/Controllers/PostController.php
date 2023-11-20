<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Illuminate\Http\Request;

class PostController extends Controller {
    /**
     * Display a listing of the resource.
     */
    public function index() {
        return view('posts.index', ['posts' => BlogPost::orderBy('created_at', 'desc')->take(5)->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePost $request) {

        $validated = $request->validated();

        $post = BlogPost::create($validated);

        $request->session()->flash('status', 'The blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        // abort_if(!array_key_exists($id, BlogPost::all()->keyBy('id')->keys()->toArray()), 404);

        return view('posts.show', [
            'post' => BlogPost::findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id) {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        //
    }
}
