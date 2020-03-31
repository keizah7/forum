<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    private $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = factory(Thread::class)->create();
    }


    /** @test */
    public function has_a_path()
    {
        $this->assertEquals('threads/' . $this->thread->id, $this->thread->path());
    }

    /** @test */
    public function has_a_replies()
    {
        $reply = factory(Reply::class)->create(['thread_id' => $this->thread]);

        $this->assertInstanceOf(Collection::class, $this->thread->replies);
        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function has_a_creator()
    {
        $this->assertInstanceOf(User::class, $this->thread->creator);
    }

    /** @test */
    public function can_add_a_reply()
    {
        $this->thread->addReply(factory(Reply::class)->make()->toArray());

        $this->assertCount(1, $this->thread->replies);
    }


}
