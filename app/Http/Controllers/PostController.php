<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use Gate;
use Illuminate\Support\Facades\DB;

class PostController extends Controller {


    public function __construct() {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }

    /**
     * Display a listing of the resource.
     */
    public function index() {
        return view('posts.index', ['posts' => BlogPost::withCount('comments')->get()]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create() {
        // $this->authorize('posts.create');
        return view('posts.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StorePost $request) {

        $validatedData = $request->validated();

        $post = BlogPost::create($validatedData);

        $request->session()->flash('status', 'The blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        return view('posts.show', [
            'post' => BlogPost::with('comments')->findOrFail($id),
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id) {
        $post = BlogPost::findOrFail($id);

        $this->authorize('update', $post);

        // if (Gate::denies('update-post', $post)) {
        //     abort(403, 'You cant update this blog post!');
        // }

        return view('posts.edit', ['post' => $post,]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(StorePost $request, string $id) {
        $post = BlogPost::findOrFail($id);

        if (Gate::denies('update', $post)) {
            abort(403, 'You cant update this blog post!');
        }

        $validatedData = $request->validated();

        $post->fill($validatedData);
        $post->save();

        $request->session()->flash('status', 'The blog post was updated!');
        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id) {
        $post = BlogPost::findOrFail($id);

        // if (Gate::denies('delete-post', $post)) {
        //     abort(403, 'You cant delete this blog post!');
        // }

        $this->authorize('delete', $post);


        $post->delete();
        session()->flash('status', 'The blog post was deleted!');
        return redirect()->route('posts.index');
    }
}
