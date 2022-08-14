<?php

namespace App\Http\Controllers;

use App\Models\Thread;
use Illuminate\Http\Request;

class ThreadsController extends Controller
{
    public function index()
    {
        return view('threads.index', [
            'threads' => Thread::latest()->get(),
        ]);
    }

    public function create()
    {
    }

    public function store(Request $request)
    {
        $thread = Thread::create([
            'user_id' => auth()->id(),
            'title' => $request->get('title'),
            'body' => $request->get('body'),
        ]);

        return redirect()->to($thread->path());
    }

    public function show(Thread $thread)
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
