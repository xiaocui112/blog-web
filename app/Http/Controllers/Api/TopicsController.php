<?php

namespace App\Http\Controllers\Api;

use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Resources\TopicResource;
use App\Http\Requests\Api\TopicRequest;

class TopicsController extends Controller
{

    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = $request->user()->id;
        $topic->save();

        return new TopicResource($topic);
    }
    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return new TopicResource($topic);
    }
    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);

        $topic->delete();

        return response(null, 204);
    }
    public function index(Request $request, Topic $topic)
    {
        $query = $topic->query();

        if ($categoryId = $request->category_id) {
            $query->where('category_id', $categoryId);
        }

        $topics = $query->with('user', 'category')->withOrder($request->order)->paginate();

        return TopicResource::collection($topics);
    }
    public function show(Topic $topic)
    {
        return new TopicResource($topic);
    }
    public function userIndex($user, Topic $topic)
    {
        $topics = $topic->with('user', 'category')->where('user_id', $user)->paginate();
        return TopicResource::collection($topics);
    }
}
