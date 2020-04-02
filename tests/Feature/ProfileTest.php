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
        $this->signIn($user = create(User::class));
        $thread = create(Thread::class, ['user_id' => $user]);

        $this->get('profiles/' . $user->name)
            ->assertSee($thread->title)
            ->assertSee($thread->body);
    }

}
