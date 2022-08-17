<?php

namespace App\Http\Controllers;

use App\Models\Reply;
use App\Models\Thread;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;

class RepliesController extends Controller
{
    use AuthorizesRequests;

    public function store(Request $request, $channelId, Thread $thread): RedirectResponse
    {
        $request->validate([
            'body' => ['required']
        ]);

        $thread->addReply([
            'body' => $request->get('body'),
            'user_id' => auth()->id()
        ]);

        session()->flash('alert', 'You left a reply successfully.');

        return redirect()->to($thread->path());
    }

    public function update(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->update(['body' => $request->post('body')]);
    }

    public function destroy(Request $request, Reply $reply)
    {
        $this->authorize('update', $reply);

        $reply->delete();

        if ($request->expectsJson()) {
            return response()->json(['message' => 'Reply removed successfully.']);
        }

        session()->flash('alert', 'Reply removed successfully.');

        return redirect()->back();
    }
}
