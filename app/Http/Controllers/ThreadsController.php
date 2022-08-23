<?php

namespace App\Http\Controllers;

use App\Filters\ThreadFilters;
use App\Http\Requests\StoreThreadRequest;
use App\Http\Resources\ThreadResource;
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

        $threads = $threads->paginate();

        return view('threads.index', [
            'threads' => $threads,
        ]);
    }

    public function create()
    {
        return view('threads.create');
    }

    public function store(StoreThreadRequest $request)
    {
        $thread = Thread::create($request->validated());

        session()->flash('alert', 'Thread published successfully!');

        return redirect()->to($thread->path());
    }

    public function show($channel, Thread $thread)
    {
        $thread->append('is_subscribed_to');

        if (auth()->check()) {
            auth()->user()->read($thread);
        }

        return view('threads.show', [
            'thread' => ThreadResource::make($thread),
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

        $thread->delete();

        return redirect()->to('/threads');
    }
}
