<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    /** @test */
    public function guest_cant_create_a_thread()
    {
        $this
            ->post('threads', factory(Thread::class)->raw())
            ->assertRedirect('login');
    }

    /** @test */
    public function a_authenticated_user_can_create_a_thread()
    {
        $this->signIn();

        $thread = factory(Thread::class)->make();

        $this
            ->followingRedirects()
            ->post('threads', $thread->toArray())
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
