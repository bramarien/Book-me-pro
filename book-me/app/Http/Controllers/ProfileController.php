<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\User;
use App\Http\Requests\ProfileUpdateRequest;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Storage;
use Illuminate\View\View;

class ProfileController extends Controller
{

    public function index() {

        return $this->show(request()->user());
    }

    public function show(User $profile) {

        $posts = $profile->userAndRecipientPosts($profile)->latest()->paginate(7);
        return view('profile.show', [
            'posts' => $posts,
            'user' => $profile,
        ]);
    }


    /**
     * Display the user's profile form.
     */
    public function edit(Request $request): View
    {
        return view('profile.edit', [
            'user' => $request->user(),
        ]);
    }

    /**
     * Update the user's profile information.
     */
    public function update(ProfileUpdateRequest $request): RedirectResponse
    {
        $oldImgProfile = $request->user()->image_profile;
        $oldImgBg = $request->user()->image_bg;

        $request->user()->fill($request->validated());
        if ($request->user()->isDirty('email')) {
            $request->user()->email_verified_at = null;
        }

        if ($request->has('image_profile')) {
            $img_profile = $request->file('image_profile')->store('profile', 'public');
            Storage::disk('public')->delete($oldImgProfile ?? '');

            $request->user()->image_profile = $img_profile;
        }
        if ($request->has('image_bg')) {
            $img_bg = $request->file('image_bg')->store('profile', 'public');
            Storage::disk('public')->delete($oldImgBg ?? '');
            $request->user()->image_bg = $img_bg;
        }

        $request->user()->save();

        return Redirect::route('profile.index')->with('status', 'profile-updated');
    }

    /**
     * Delete the user's account.
     */
    public function destroy(Request $request): RedirectResponse
    {
        $request->validateWithBag('userDeletion', [
            'password' => ['required', 'current_password'],
        ]);

        $user = $request->user();

        Auth::logout();

        $user->delete();

        $request->session()->invalidate();
        $request->session()->regenerateToken();

        return Redirect::to('/');
    }
}
