<?php

namespace Tests\Unit;

use App\Favorite;
use App\Reply;
use App\User;
use Carbon\Carbon;
use Illuminate\Database\Eloquent\Collection;
use Tests\TestCase;

class ReplyTest extends TestCase
{
    /** @test */
    public function has_an_owner()
    {
        $this->assertInstanceOf(User::class, create(Reply::class)->owner);
    }

    /** @test */
    public function has_a_favorites()
    {
        $reply = create(Reply::class);
        $favorite = create(Favorite::class, ['favorable_id' => $reply->id]);

        $this->assertTrue($reply->favorites->contains($favorite));
    }

    /** @test */
    public function it_knows_if_it_was_just_published()
    {
        $reply = create(Reply::class);

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }

    /** @test */
    public function it_can_detect_all_mentioned_users_in_the_body()
    {
        $reply = new Reply([
            'body' => '@JaneDoe wants to talk to @JohnDoe'
        ]);

        $this->assertEquals(['JaneDoe', 'JohnDoe'], $reply->mentionedUsers());
    }

    /** @test */
    public function it_wraps_mentioned_usernames_in_the_body_within_anchor_tags()
    {
        $reply = new Reply([
            'body' => 'Hello @Jane-Doe.'
        ]);

        $this->assertEquals(
            'Hello <a href="/profiles/Jane-Doe">@Jane-Doe</a>.',
            $reply->body
        );
    }

    /** @test */
    public function it_knows_if_it_is_the_best_reply()
    {
        $reply = create(Reply::class);

        $this->assertFalse($reply->isBest());

        $reply->thread->update(['best_reply_id' => $reply->id]);

        $this->assertTrue($reply->fresh()->isBest());
    }

    /** @test */
    public function it_sanitizes_body_automatically()
    {
        $reply = make(Reply::class, [
            'body' => '<script>alert("bad")</script><p>This is okay.</p>'
        ]);

        $this->assertEquals('<p>This is okay.</p>', $reply->body);
    }
}
