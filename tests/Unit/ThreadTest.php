<?php

namespace Tests\Unit;

use App\Thread;
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

}
