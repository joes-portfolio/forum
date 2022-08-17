<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;

class ProfilesController extends Controller
{
    public function show(User $profileUser)
    {
        return view('profiles.show', [
            'profileUser' => $profileUser,
            'activities' => Activity::feed($profileUser),
        ]);
    }
}
