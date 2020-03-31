<?php

namespace Tests\Feature;

use App\Channel;
use App\Thread;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    /** @test */
    public function guest_cant_create_a_thread()
    {
        $this->get('threads/create')->assertRedirect('login');
        $this->post('threads')->assertRedirect('login');
    }

    /** @test */
    public function a_authenticated_user_can_create_a_thread()
    {
        $this
            ->signIn()
            ->followingRedirects()
            ->post('threads', $thread = make(Thread::class)->toArray())
            ->assertSee($thread['title'])
            ->assertSee($thread['body']);
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishTread(['title' => null])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishTread(['body' => null])->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $this->publishTread(['channel_id' => create(Channel::class)->id])->assertSessionHasNoErrors();
        $this->publishTread(['channel_id' => null])->assertSessionHasErrors('channel_id');
        $this->publishTread(['channel_id' => 9])->assertSessionHasErrors('channel_id');
    }

    private function publishTread($attributes = null)
    {
        return $this->signIn()->post('threads', make(Thread::class, $attributes)->toArray());
    }
}
