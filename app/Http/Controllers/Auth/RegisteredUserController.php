<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Auth\Events\Registered;
use Illuminate\Http\Request;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Models\CHFavorite;
use Illuminate\Validation\Rules;

class RegisteredUserController extends Controller
{
    /**
     * Handle an incoming registration request.
     *
     * @throws \Illuminate\Validation\ValidationException
     */
    public function store(Request $request): Response
    {
        $request->validate([
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'string', 'email', 'max:255', 'unique:'.User::class],
            'password' => ['required', 'confirmed', Rules\Password::defaults()],
            'avatar' => ['nullable', 'image', 'max:2048'],
        ]);

        if ($request->avatar) {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
                ''
            ]);

            $imageName = Str::random() . '.' . $request->avatar->getClientOriginalExtension();

            // Save the image locally
            Storage::disk('public')->putFileAs('users-avatar', $request->avatar, $imageName);

            $user->avatar = $imageName;

            $user->save();

            event(new Registered($user));
            CHFavorite::create([
                'user_id' => $user->id,
                'favorite_id' => 1,
            ]);

            Auth::login($user);

            return response()->noContent();
        } else {
            $user = User::create([
                'name' => $request->name,
                'email' => $request->email,
                'password' => Hash::make($request->password),
            ]);

            event(new Registered($user));

            CHFavorite::create([
                'user_id' => $user->id,
                'favorite_id' => 1,
            ]);

            Auth::login($user);



            return response()->noContent();
        }
    }
}
