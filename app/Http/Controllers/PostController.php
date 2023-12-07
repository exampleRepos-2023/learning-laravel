<?php

namespace App\Http\Controllers;

use App\Http\Requests\StorePost;
use App\Models\BlogPost;
use App\Models\User;
use Gate;
use Illuminate\Support\Facades\Cache;

class PostController extends Controller {


    /**
     * Construct a new instance of the class.
     *
     * This method is called when a new object of the class is created.
     * It sets up the necessary middleware for the routes.
     * The middleware is applied only to the specified actions:
     * create, store, edit, update, and destroy.
     * The 'auth' middleware ensures that the user is authenticated before accessing these actions.
     */
    public function __construct() {
        $this->middleware('auth')
            ->only(['create', 'store', 'edit', 'update', 'destroy']);
    }
    /**
     * Display a listing of the resource.
     */
    public function index() {

        return view('posts.index', [
            'posts' => BlogPost::latestWithRelations()->get(),
        ]);
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

        $validatedData = $request->validated();
        $validatedData['user_id'] = $request->user()->id;

        $post = BlogPost::create($validatedData);

        $request->session()->flash('status', 'The blog post was created!');

        return redirect()->route('posts.show', ['post' => $post->id]);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id) {
        $blogPost = Cache::tags(['blog-post'])
            ->remember("blog-post-{$id}", 60, function () use ($id) {
                return BlogPost::with('comments', 'tags', 'user', 'comments.user')
                    ->findOrFail($id);
            });

        $sessionId = session()->getId();
        $counterKey = "blog-post-{$id}-counter";
        $usersKey = "blog-post-{$id}-users";

        $users = Cache::tags(['blog-post'])->get($usersKey, []);
        $usersUpdate = [];
        $diffrence = 0;
        $now = now();

        foreach ($users as $session => $lastVisit) {
            if ($now->diffInMinutes($lastVisit) >= 1) {
                $diffrence--;
            } else {
                $usersUpdate[$session] = $lastVisit;
            }
        }

        if (
            !array_key_exists($sessionId, $users)
            || $now->diffInMinutes($users[$sessionId]) >= 1
        ) {
            $diffrence++;
        }

        $usersUpdate[$sessionId] = $now;
        Cache::tags(['blog-post'])->forever($usersKey, $usersUpdate);

        if (!Cache::has($counterKey)) {
            Cache::tags(['blog-post'])->forever($counterKey, 1);
        } else {
            Cache::tags(['blog-post'])->increment($counterKey, $diffrence);
        }

        $counter = Cache::tags(['blog-post'])->get($counterKey);

        return view('posts.show', ['post' => $blogPost, 'counter' => $counter]);
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
