<?php

namespace Tests\Unit;

use App\Reply;
use App\User;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    /** @test */
    public function has_an_owner()
    {
        $reply = create(Reply::class);

        $this->assertInstanceOf(User::class, $reply->owner);
    }

}
