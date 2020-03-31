<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use Tests\TestCase;

class ParticipateInForumTest extends TestCase
{
    /** @test */
    public function guest_cant_add_reply()
    {
        $this
            ->post(create(Thread::class)->path() . '/replies')
            ->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_may_participate_in_forum_threads()
    {
        $this->signIn();
        $thread = create(Thread::class);
        $reply = make(Reply::class);

        $this
            ->followingRedirects()
            ->post($thread->path() . '/replies', $reply->toArray())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_reply_requires_a_body()
    {
        $this->publishReply(['body' => null])->assertSessionHasErrors('body');
    }

    private function publishReply($attributes = null)
    {
        return $this->signIn()->post(create(Thread::class)->path().'/replies', make(Reply::class, $attributes)->toArray());
    }
}
