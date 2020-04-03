<?php

namespace Tests\Feature;

use App\Reply;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class FavoriteTest extends TestCase
{

    /** @test */
    public function guest_cant_favorite_any_reply()
    {
        $this->post('replies/' . create(Reply::class)->id . '/favorites')->assertRedirect('login');
    }

    /** @test */
    public function an_authenticated_user_can_favorite_any_reply()
    {
        $reply = create(Reply::class);

        $this->signIn()->post('replies/' . $reply->id . '/favorites');

        $this->assertCount(1, $reply->favorites);
    }


    /** @test */
    public function an_authenticated_user_can_favorite_reply_only_once()
    {
        $this->signIn();
        $reply = create(Reply::class);

        $reply->favorite();
        $reply->favorite();

        $this->assertCount(1, $reply->favorites);
    }

    /** @test */
    public function an_authenticated_user_can_unfavorite_a_reply()
    {
        $this->signIn();

        $reply = create(Reply::class);

        $reply->favorite();

        $this->delete('replies/' . $reply->id . '/favorites');

        $this->assertCount(0, $reply->favorites);
    }
}
