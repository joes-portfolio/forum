<?php

namespace App\Http\Controllers;

use App\Models\Channel;
use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->only(['create', 'store']);
    }

    public function index(Channel $channel = null)
    {
        if ($channel) {
            $threads = $channel->threads()->latest()->get();
        } else {
            $threads = Thread::latest()->get();
        }

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

    public function show($channelId, Thread $thread)
    {
        return view('threads.show', [
            'thread' => $thread,
        ]);
    }

    public function edit(Thread $thread)
    {
    }

    public function update(Request $request, Thread $thread)
    {
    }

    public function destroy(Thread $thread)
    {
    }
}
