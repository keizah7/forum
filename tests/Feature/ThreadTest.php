<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    public function a_user_can_view_all_threads()
    {
        $thread = factory(Thread::class)->create();

        $this
            ->get('threads')
            ->assertSee($thread->title);
    }

    /** @test */
    public function a_user_can_view_a_thread()
    {
        $thread = factory(Thread::class)->create();

        $this
            ->get('threads/' . $thread->id)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
