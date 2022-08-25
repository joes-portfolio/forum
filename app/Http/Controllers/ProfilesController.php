<?php

namespace App\Http\Controllers;

use App\Models\Activity;
use App\Models\User;
use App\Policies\UserPolicy;

class ProfilesController extends Controller
{
    public function show(User $profileUser)
    {
        $data = array_merge([
            'can' => [
                UserPolicy::UPDATE => auth()->user()?->can(UserPolicy::UPDATE, $profileUser)
            ],
        ], $profileUser->only(['name', 'created_at_formatted', 'avatar_path']));

        return view('profiles.show', [
            'profileUser' => $data,
            'activities' => Activity::feed($profileUser),
        ]);
    }
}
