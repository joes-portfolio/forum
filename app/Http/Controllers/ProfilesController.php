<?php

namespace App\Http\Controllers;

use App\Models\User;

class ProfilesController extends Controller
{
    public function show(User $profileUser)
    {
        return view('profiles.show', [
            'profileUser' => $profileUser,
            'threads' => $profileUser->threads()->paginate(20)
        ]);
    }
}
