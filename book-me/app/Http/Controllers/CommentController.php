<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Post;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function store(Request $request, Post $post) {


        $validated = $request->validateWithBag('comment'.$post->id, [
            'content' => 'required|string|max:512',
        ]);
        $validated['user_id'] = $request->user()->id;
        $validated['post_id'] = $post->id;

        $post->comments()->create($validated);

        return redirect(route('posts.show', compact('post')))->with('success', 'Post created successfully!');
    }

    public function edit(Request $request, Comment $comment) {

        $this->authorize('update', $comment);
        $editComment = true;
        $idComment = $comment->id;
        $post = $comment->post;

        return view('posts.show', compact('post', 'editComment', 'idComment'));
    }

    public function update(Request $request, Comment $comment): RedirectResponse {

        $this->authorize('update', $comment);

        $validated = $request->validate([
            'content' => 'required|string|max:255',
        ]);

        $comment->update($validated);
        $post = $comment->post;

        return redirect(route('posts.show', compact('post')));
    }

    public function destroy(Comment $comment): RedirectResponse
    {
        $this->authorize('delete', $comment);
        $post = $comment->post;

        $comment->delete();

        return redirect(route('posts.show', compact('post')));
    }
}
