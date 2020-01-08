<?php

namespace App\Policies;

use App\Models\User;
use App\Models\Topic;
use Illuminate\Auth\Access\HandlesAuthorization;

class TopicPolicy
{
    use HandlesAuthorization;
    public function update(User $user, Topic $topic)
    {
        return $topic->user_id == $user->id;
    }
    public function destroy(User $user,Topic $topic)
    {
        return $topic->user_id==$user->id;
    }
}
