<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Http\Request;
use App\Http\Requests\TopicRequest;
use App\Handlers\ImageUploadHandler;
use Illuminate\Support\Facades\Auth;

class TopicController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth', ['except' => ['index', 'show']]);
    }
    /**
     * 首页动作
     *
     * @param Request $request
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function index(Request $request, User $user)
    {
        $topics = Topic::withOrder($request->order)->with('user', 'category')->paginate();
        $active_users = $user->getActiveUsers();
        return view('topics.index', compact('topics', 'active_users'));
    }
    /**
     * 创建帖子
     *
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function create(Topic $topic)
    {
        return view('topics.create_and_edit', compact('topic'));
    }
    /**
     * 详情
     *
     * @param Topic $topic
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function show(Topic $topic, Request $request)
    {
        if (!empty($topic->slug) && $topic->slug != $request->slug) {
            return redirect($topic->link(), 301);
        }
        return view('topics.show', compact('topic'));
    }
    /**
     * 编辑个人内容
     *
     * @param Topic $topic
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function edit(Topic $topic)
    {
        $this->authorize('update', $topic);
        return view('topics.create_and_edit', compact('topic'));
    }
    /**
     * 更新内容
     *
     * @param TopicRequest $request
     * @param Topic $topic
     * @return \Illuminate\View\View|\Illuminate\Contracts\View\Factory
     */
    public function update(TopicRequest $request, Topic $topic)
    {
        $this->authorize('update', $topic);
        $topic->update($request->all());
        return redirect()->to($topic->link())->with('success', '更新成功!');
    }
    /**
     * 保存数据
     *
     * @param TopicRequest $request
     * @param Topic $topic
     * @return \Illuminate\Http\RedirectResponse
     */
    public function store(TopicRequest $request, Topic $topic)
    {
        $topic->fill($request->all());
        $topic->user_id = Auth::id();
        $topic->save();
        return redirect()->to($topic->link())->with('success', '帖子创建成功!');
    }
    /**
     * 文件储存
     *
     * @param Request $request
     * @param ImageUploadHandler $uploader
     * @return arary
     */
    public function uploadImage(Request $request, ImageUploadHandler $uploader)
    {
        $data = [
            'success' => false,
            'msg' => '上传失败!',
            'file_path' => '',
        ];
        if ($file = $request->upload_file) {
            $result = $uploader->save($request->upload_file, 'topics', Auth::id());
            if ($result) {
                $data['file_path'] = env("APP_URL") . '/' . 'storage/' . $result['path'];
                $data['msg'] = "上传成功!";
                $data['success'] = true;
            }
        }
        return $data;
    }
    public function destroy(Topic $topic)
    {
        $this->authorize('destroy', $topic);
        $topic->delete();
        return redirect()->route('topics.index')->with('success', '成功删除!');
    }
}
