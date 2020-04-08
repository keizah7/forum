<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
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
}
