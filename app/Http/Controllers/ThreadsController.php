<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\Request;

class ThreadsController
{
    use AuthorizesRequests;

    public function index(ThreadFilters $filters, Channel $channel = null)
    {
        $threads = Thread::query()
            ->with('channel')
            ->latest()
            ->filter($filters);

        if ($channel) {
            $threads->where('channel_id', $channel->id);
        }

        $threads = $threads->get();

        return view('threads.index', [
            'threads' => $threads,
        ]);
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'title' => ['required'],
            'body' => ['required'],
            'channel_id' => ['required', 'exists:channels,id'],
        ]);

        $thread = Thread::create([
            'user_id' => auth()->id(),
            'channel_id' => $request->get('channel_id'),
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        return redirect()->to($thread->path());
    }

    public function show($channel, Thread $thread)
    {
        return view('threads.show', [
            'thread' => $thread,
            'replies' => $thread->replies()->oldest()->paginate(),
        ]);
    }

    public function edit(Thread $thread)
    {
    }

    public function update(Request $request, Thread $thread)
    {
    }

    public function destroy($channel, Thread $thread)
    {
        $this->authorize('update', $thread);

        $thread->replies()->delete();
        $thread->delete();

        return redirect()->to('/threads');
    }
}
