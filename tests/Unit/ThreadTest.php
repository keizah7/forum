<?php

namespace Tests\Unit;

use App\Channel;
use App\Reply;
use App\Thread;
use App\User;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ThreadTest extends TestCase
{
    private $thread;

    protected function setUp(): void
    {
        parent::setUp();

        $this->thread = create(Thread::class);
    }

    /** @test */
    public function has_a_path()
    {
        $this->assertEquals( "/threads/{$this->thread->channel->slug}/{$this->thread->id}", $this->thread->path());
    }


    /** @test */
    public function has_a_replies()
    {
        $reply = create(Reply::class, ['thread_id' => $this->thread]);

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
        $this->thread->addReply([
            'user_id' => 1,
            'body' => 'reply',
        ]);

        $this->assertCount(1, $this->thread->replies);
    }

    /** @test */
    public function belongs_to_a_channel()
    {
        $thread = create(Thread::class);

        $this->assertInstanceOf(Channel::class, $thread->channel);
    }


    /** @test */
    public function a_thread_can_be_subscribed()
    {
        $this->signIn();
        $this->thread->subscribe();

        $this->assertEquals(1, $this->thread->subscriptions()->where('user_id', auth()->id())->count());
    }


    /** @test */
    public function a_thread_can_be_unsubscribed()
    {
        $this->signIn();
        $this->thread->subscribe();
        $this->thread->unsubscribe();

        $this->assertEquals(0, $this->thread->subscriptions()->where('user_id', auth()->id())->count());
    }

    /** @test */
    function it_knows_if_the_authenticated_user_is_subscribed_to_it()
    {
        $this->signIn();

        $this->assertFalse($this->thread->isSubscribedTo);

        $this->thread->subscribe();

        $this->assertTrue($this->thread->isSubscribedTo);
    }
}
