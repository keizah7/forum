<?php

namespace Tests\Feature;

use App\Thread;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Redis;
use Tests\TestCase;

class TrendingThreadsTest extends TestCase
{
    protected function setUp(): void
    {
        parent::setUp();

        Redis::del('trending_threads');
    }

    /** @test */
    public function it_increments_a_threads_score_each_time_it_is_read()
    {
        $this->assertEmpty(Redis::zrevrange('trending_threads', 0, -1));

        $thread = create(Thread::class);

        $this->call('GET', $thread->path());

        $this->assertCount(1, $trending = Redis::zrevrange('trending_threads', 0, -1));

        $this->assertEquals($thread->title, json_decode($trending[0])->title);
    }

}
