<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use App\Models\Reply;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\ReplyResource;
use App\Http\Requests\Api\ReplyRequest;

class RepliesController extends Controller
{
    public function store(ReplyRequest $request, Topic $topic, Reply $reply)
    {
        $reply->content = $request->content;
        $reply->topic()->associate($topic);
        $reply->user()->associate($request->user());
        $reply->save();
        return new ReplyResource($reply);
    }
    public function destroy(Topic $topic, Reply $reply)
    {
        if ($reply->topic_id != $topic->id) {
            abort(404);
        }
        $this->authorize('destroy', $reply);
        $reply->delete();
        return response(null, 204);
    }
    public function index(Topic $topic)
    {
        $replies = $topic->replies()->paginate();

        return ReplyResource::collection($replies);
    }
    public function userIndex(User $user)
    {
        $replies = $user->replies()->paginate();
        return ReplyResource::collection($replies);
    }
}
