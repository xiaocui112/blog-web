<?php

namespace App\Http\Controllers\Api;

use App\Models\User;
use Illuminate\Http\Request;
use App\Handlers\ImageUploadHandler;
use App\Http\Controllers\Controller;
use App\Http\Requests\Api\UserEditRequest;
use App\Http\Resources\UserResource;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Cache;
use App\Http\Requests\Api\UserRequest;
use Illuminate\Auth\AuthenticationException;

class UsersController extends Controller
{
    public function store(UserRequest $request)
    {
        $verifyData = Cache::get($request->verification_key);
        if (!$verifyData) {
            abort(403, '验证码已失效');
        }
        if (!hash_equals((string) $verifyData['code'], (string) $request->verification_code)) {
            throw new AuthenticationException('验证码错误');
        }
        $user = User::create([
            'name' => $request->name,
            'phone' => $verifyData['phone'],
            'password' => encrypt($request->password),
        ]);
        Cache::forget($request->verification_key);
        return (new UserResource($user))->showSensitiveFields();
    }
    public function show(User $user, Request $request)
    {
        return new UserResource($user);
    }
    public function me(Request $request)
    {
        return (new UserResource($request->user()))->showSensitiveFields();
    }
    public function update(UserEditRequest $request, ImageUploadHandler $uploder)
    {
        $user = $request->user();
        $data = $request->only(['name', 'email', 'introduction']);
        if ($request->avatar) {
            $result = $uploder->save($request->avatar, 'avatars', Auth::id());
            if ($result) {
                $data['avatar'] = $result['path'];
            }
        }
        $user->update($data);
        return (new UserResource($user))->showSensitiveFields();
    }
    public function activedIndex(User $user)
    {
        UserResource::wrap('data');
        return UserResource::collection($user->getActiveUsers());
    }
}
