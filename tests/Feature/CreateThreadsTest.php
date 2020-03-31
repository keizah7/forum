<?php

namespace Tests\Feature;

use App\Thread;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    /** @test */
    public function guest_cant_create_a_thread()
    {
        $this
            ->post('threads')
            ->assertRedirect('login');
    }

    /** @test */
    public function a_authenticated_user_can_create_a_thread()
    {
        $this->signIn();

        $thread = make(Thread::class);

        $this
            ->followingRedirects()
            ->post('threads', $thread->toArray())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
