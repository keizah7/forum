<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Illuminate\Support\Facades\Storage;
use Tests\TestCase;

class UserTest extends TestCase
{
    /** @test */
    public function a_user_can_fetch_their_most_recent_reply()
    {
        $user = create(User::class);

        $reply = create(Reply::class, ['user_id' => $user->id]);

        $this->assertEquals($reply->id, $user->lastReply->id);
    }

    /** @test */
    public function a_user_can_determine_their_avatar_path()
    {
        $user = create(User::class);

        $this->assertEquals(asset(Storage::url('avatars/default.png')), $user->avatar_path);

        $user->avatar_path = 'avatars/me.jpg';

        $this->assertEquals(asset(Storage::url('avatars/me.jpg')), $user->avatar_path);
    }
}
