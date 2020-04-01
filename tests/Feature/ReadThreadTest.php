<?php

namespace Tests\Feature;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class ReadThreadTest extends TestCase
{
    private $thread;

    public function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $this
            ->get('threads')
            ->assertSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_a_single_thread()
    {
        $this
            ->get($this->thread->path())
            ->assertSee($this->thread->title)
            ->assertSee($this->thread->body);
    }

    /** @test */
    public function a_user_can_read_thread_replies()
    {
        $reply = create(Reply::class, ['thread_id' => $this->thread->id]);

        $this
            ->get($this->thread->path())
            ->assertSee($reply->body);
    }

    /** @test */
    public function a_user_can_filter_threads_according_to_a_tag()
    {
        $this->withoutExceptionHandling();
        $channel = create(Channel::class);
        $thread = create(Thread::class, ['channel_id' => $channel]);

        $this->get('threads/' . $channel->slug)
            ->assertSee($thread->title)
            ->assertDontSee($this->thread->title);
    }

    /** @test */
    public function a_user_can_view_threads_by_any_username()
    {
        $me = create(User::class, ['name' => 'me']);
        $myThread = create(Thread::class, ['user_id' => $me->id]);

        $this
            ->signIn($me)
            ->get('threads?by=me')
            ->assertSee($myThread->title)
            ->assertDontSee($this->thread->title);
    }

}
