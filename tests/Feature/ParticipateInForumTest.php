<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    /** @test */
    public function guest_cant_add_reply()
    {
        $thread = factory(Thread::class)->create();

        $this
            ->post($thread->path() . '/replies')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();
        $thread = factory(Thread::class)->create();

        $reply = factory(Reply::class)->raw();
        $this
            ->followingRedirects()
            ->post($thread->path() . '/replies', $reply)
            ->assertSee($reply['body']);
    }

}
