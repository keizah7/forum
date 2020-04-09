<?php

namespace Tests\Feature;

use App\Reply;
use App\Thread;
use App\User;
use Tests\TestCase;

class MentionUserTest extends TestCase
{
    /** @test */
    public function mentioned_users_in_a_reply_are_notified()
    {
        $this->withoutExceptionHandling();
        $john = create(User::class, ['name' => 'JohnDoe']);

        $this->signIn($john);

        $jane = create(User::class, ['name' => 'JaneDoe']);

        $thread = create(Thread::class);

        $reply = make(Reply::class, [
            'body' => 'Hey @JaneDoe check this out.'
        ]);

        $this->json('post', $thread->path() . '/replies', $reply->toArray());

        $this->assertCount(1, $jane->notifications);
    }

    /** @test */
    public function it_can_fetch_all_mentioned_users_starting_with_the_given_characters()
    {
        create(User::class, ['name' => 'johndoe']);
        create(User::class, ['name' => 'johndoe2']);
        create(User::class, ['name' => 'janedoe']);

        $results = $this->json('GET', '/api/users', ['name' => 'john']);

        $this->assertCount(2, $results->json());
    }
}
