<?php

namespace App\Http\Controllers;

use App\Models\Reply;

class FavoritesController extends Controller
{
    public function store(Reply $reply)
    {
        $reply->favorite(auth()->id());

        return redirect()->back();
    }
}
