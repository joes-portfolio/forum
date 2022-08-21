<?php

namespace App\Http\Controllers;

use App\Http\Resources\ReplyResource;
use App\Models\Reply;
use App\Models\Thread;
use App\Services\Spam\Spam;
use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RepliesController extends Controller
{
    use AuthorizesRequests;

    public function index($channel, Thread $thread)
    {
        $replies = $thread->replies()->paginate(20);

        return ReplyResource::collection($replies);
    }

    public function store(Request $request, $channelId, Thread $thread, Spam $spam): JsonResponse|RedirectResponse
    {
        $attributes = $request->validate([
            'body' => ['required']
        ]);

        try {
            $spam->detect($attributes['body']);
        } catch (\Exception $exception) {
            return response()->json(
                $exception->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $reply = $thread->addReply(array_merge($attributes, [
            'user_id' => auth()->id()
        ]));

        if ($request->expectsJson()) {
            $reply->load('owner');
            return response()->json(ReplyResource::make($reply));
        }

        session()->flash('alert', 'You left a reply successfully.');

        return redirect()->to($thread->path());
    }

    public function update(Request $request, Reply $reply, Spam $spam)
    {
        $this->authorize('update', $reply);

        $attributes = $request->validate([
            'body' => ['required']
        ]);

        try {
            $spam->detect($attributes['body']);
        } catch (\Exception $exception) {
            return response()->json(
                $exception->getMessage(),
                Response::HTTP_UNPROCESSABLE_ENTITY
            );
        }

        $reply->update($attributes);
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
