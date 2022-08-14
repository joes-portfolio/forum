<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    public function store(Request $request, Thread $thread): RedirectResponse
    {
        $thread->addReply([
            'body' => $request->get('body'),
            'user_id' => auth()->id()
        ]);

        return redirect()->to($thread->path());
    }

    public function update(Request $request, Reply $reply)
    {
    }
}
