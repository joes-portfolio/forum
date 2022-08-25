<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class UserAvatarController extends Controller
{
    public function __invoke(Request $request)
    {
        $request->validate([
            'avatar' => ['required', 'image'],
        ]);

        auth()->user()->update([
            'avatar_path' => $request->file('avatar')->store('avatars', 'public')
        ]);

        return response()->json([], Response::HTTP_NO_CONTENT);
    }
}
