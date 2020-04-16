<?php

namespace Tests\Feature;

use App\Activity;
use App\Channel;
use App\Reply;
use App\Rules\Recaptcha;
use App\Thread;
use App\User;
use Tests\TestCase;

class CreateThreadsTest extends TestCase
{
    public function setUp(): void
    {
        parent::setUp();

        app()->singleton(Recaptcha::class, function () {
            return \Mockery::mock(Recaptcha::class, function ($m) {
                $m->shouldReceive('passes')->andReturn(true);
            });
        });
    }

    /** @test */
    public function guest_cant_create_a_thread()
    {
        $this->get('threads/create')->assertRedirect('login');
        $this->post('threads')->assertRedirect('login');
    }

    /** @test */
    public function new_users_must_first_confirm_their_email_address_before_creating_threads()
    {
        $this->publishThread([], create(User::class, ['email_verified_at' => null]))
            ->assertRedirect('email/verify');
    }

    /** @test */
    public function a_authenticated_user_can_create_a_thread()
    {
        $this
            ->followingRedirects()
            ->publishThread(['title' => 'title', 'body' => 'body'])
            ->assertSee('title')
            ->assertSee('body');
    }

    /** @test */
    public function a_thread_requires_a_title()
    {
        $this->publishThread(['title' => null])->assertSessionHasErrors('title');
    }

    /** @test */
    public function a_thread_requires_a_body()
    {
        $this->publishThread(['body' => null])->assertSessionHasErrors('body');
    }

    /** @test */
    public function a_thread_requires_recaptcha_verification()
    {
        unset(app()[Recaptcha::class]);

        $this->publishThread(['g-recaptcha-response' => 'test'])
            ->assertSessionHasErrors('g-recaptcha-response');
    }

    /** @test */
    public function a_thread_requires_a_valid_channel()
    {
        $this->publishThread(['channel_id' => create(Channel::class)->id])->assertSessionHasNoErrors();
        $this->publishThread(['channel_id' => null])->assertSessionHasErrors('channel_id');
        $this->publishThread(['channel_id' => 9])->assertSessionHasErrors('channel_id');
    }

    /** @test */
    public function a_thread_requires_a_unique_slug()
    {
        $this->signIn();

        $thread = create(Thread::class, ['title' => 'Foo Title']);

        $this->assertEquals($thread->slug, 'foo-title');

        $thread = $this->postJson(route('threads'), $thread->toArray()  + ['g-recaptcha-response' => 'token'])->json();

        $this->assertEquals("foo-title-{$thread['id']}", $thread['slug']);
    }

    /** @test */
    public function a_thread_with_a_title_that_ends_in_a_number_should_generate_the_proper_slug()
    {
        $this->signIn();

        $thread = create(Thread::class, ['title' => 'Some Title 24']);

        $thread = $this->postJson(route('threads'), $thread->toArray() + ['g-recaptcha-response' => 'token'])->json();

        $this->assertEquals("some-title-24-{$thread['id']}", $thread['slug']);
    }

    /** @test */
    public function unauthorized_users_cant_delete_threads()
    {
        $thread = create(Thread::class);
        $this
            ->delete($thread->path())
            ->assertRedirect('login');
        $this->assertDatabaseHas('threads', $thread->only('slug'));

        $this->signIn();
        $this->delete($thread->path())->assertStatus(403);
    }


    /** @test */
    public function a_thread_can_be_deleted()
    {
        $this->signIn();

        $thread = create(Thread::class, ['user_id' => auth()->id()]);
        $reply = create(Reply::class, ['thread_id' => $thread]);

        $this->delete($thread->path());

        $this->assertDatabaseMissing('threads', $thread->only('id'));
        $this->assertDatabaseMissing('replies', $reply->only('id'));
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->only('id'),
            'subject_type' => get_class($thread),
        ]);
        $this->assertDatabaseMissing('activities', [
            'subject_id' => $reply->only('id'),
            'subject_type' => get_class($reply),
        ]);
        $this->assertEquals(0, Activity::count());
    }

    private function publishThread($attributes = [], $user = null)
    {
        return $this->signIn($user)->post('threads', make(Thread::class, $attributes)->toArray()  + ['g-recaptcha-response' => 'token']);
    }
}
