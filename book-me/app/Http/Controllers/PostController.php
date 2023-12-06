<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class PostController extends Controller
{
    public function index() {

        $user = auth()->user();

        $posts = $user->userAndFollowingPosts($user)->latest()->paginate(7);

        return view('posts.index', [
            'posts' => $posts,
        ]);
    }

    public function store(Request $request, User $user): RedirectResponse {


        $validated = $request->validate([
            'content' => 'required|string|max:512',
        ]);
        $validated['user_id'] = auth()->id();
        $validated['recipient_id'] = $user->id;

        $request->user()->posts()->create($validated);

        return redirect()->back()->with('success', 'Post created successfully!');
    }

    public function show(Post $post) {

        return view('posts.show', compact('post'));
    }

    public function edit(Post $post) {

        $this->authorize('update', $post);
        $editing = true;

        return view('posts.show', compact('post', 'editing'));
    }

    public function update(Request $request, Post $post): RedirectResponse {

        $this->authorize('update', $post);

        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $post->update($validated);

        return redirect(route('posts.show', compact('post')));
    }

    public function destroy(Post $post): RedirectResponse
    {
        $this->authorize('delete', $post);

        $post->delete();

        return redirect(route('posts.index'));
    }
}
