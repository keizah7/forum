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


    /** @test */
    public function unauthorized_users_cannot_delete_replies()
    {
        $reply = create(Reply::class);

        $this->delete("replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()->delete("replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    public function authorized_users_can_delete_replies()
    {
        $this->signIn();
        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $this->delete("replies/{$reply->id}");

        $this->assertDatabaseMissing('replies', $reply->only('id'));
    }

    function unauthorized_users_cannot_update_replies()
    {
        $reply = create(Reply::class);

        $this->patch("/replies/{$reply->id}")
            ->assertRedirect('login');

        $this->signIn()
            ->patch("/replies/{$reply->id}")
            ->assertStatus(403);
    }

    /** @test */
    function authorized_users_can_update_replies()
    {
        $this->signIn();

        $reply = create(Reply::class, ['user_id' => auth()->id()]);

        $updatedReply = 'changed';
        $this->patch("/replies/{$reply->id}", ['body' => $updatedReply]);

        $this->assertDatabaseHas('replies', ['id' => $reply->id, 'body' => $updatedReply]);
    }
}
