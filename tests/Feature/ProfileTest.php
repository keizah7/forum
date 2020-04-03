<?php

namespace Tests\Feature;

use App\Thread;
use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class ProfileTest extends TestCase
{

    /** @test */
    public function a_user_has_a_profile()
    {
        $user = create(User::class);

        $this->get('profiles/' . $user->name)
            ->assertSee($user->name);
    }


    /** @test */
    public function profile_display_user_threads()
    {
        $this->signIn();
        $thread = create(Thread::class, ['user_id' => auth()->id()]);

        $this->get('profiles/' . auth()->user()->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
