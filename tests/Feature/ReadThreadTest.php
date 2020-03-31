<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
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

}
