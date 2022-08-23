<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;

class UserMentionsController extends Controller
{
    public function __invoke(Request $request)
    {
        $search = $request->query('s');

        return User::query()
            ->where('name', 'like', "$search%")
            ->limit(5)
            ->get()
            ->map(fn ($user) => ['key' => $user->name, 'value' => $user->name]);
    }
}
