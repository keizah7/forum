<?php

namespace Tests\Unit;

use App\Channel;
use App\Thread;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ChannelTest extends TestCase
{

    /** @test */
    public function has_threads()
    {
        $channel = create(Channel::class);
        $thread = create(Thread::class, ['channel_id' => $channel->id]);

        $this->assertInstanceOf(Collection::class, $channel->threads);
        $this->assertTrue($channel->threads->contains($thread));
    }

}
