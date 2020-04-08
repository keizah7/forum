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
    function it_knows_if_it_was_just_published()
    {
        $reply = create(Reply::class);

        $this->assertTrue($reply->wasJustPublished());

        $reply->created_at = Carbon::now()->subMonth();

        $this->assertFalse($reply->wasJustPublished());
    }
}
