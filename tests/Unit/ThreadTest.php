<?php

namespace Tests\Unit;

use App\Reply;
use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function has_a_path()
    {
        $thread = factory(Thread::class)->create();

        $this->assertEquals('threads/' . $thread->id, $thread->path());
    }

    /** @test */
    public function has_a_replies()
    {
        $thread = factory(Thread::class)->create();
        $reply = factory(Reply::class)->create(['thread_id' => $thread]);

        $this->assertInstanceOf(Collection::class, $thread->replies);
        $this->assertCount(1, $thread->replies);
    }

}
