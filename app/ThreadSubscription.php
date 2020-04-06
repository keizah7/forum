<?php

namespace App;

use App\Notifications\ThreadWasUpdated;
use Illuminate\Database\Eloquent\Model;

/**
 * App\ThreadSubscription
 *
 * @property int $id
 * @property int $user_id
 * @property int $thread_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Thread $thread
 * @property-read \App\User $user
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription whereThreadId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\ThreadSubscription whereUserId($value)
 * @mixin \Eloquent
 */
class ThreadSubscription extends Model
{
    protected $guarded = [];

    /**
     * Get the user associated with the subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Get the thread associated with the subscription.
     *
     * @return \Illuminate\Database\Eloquent\Relations\BelongsTo
     */
    public function thread()
    {
        return $this->belongsTo(Thread::class);
    }

    /**
     * Notify the related user that the thread was updated.
     *
     * @param \App\Reply $reply
     */
    public function notify($reply)
    {
        $this->user->notify(new ThreadWasUpdated($this->thread, $reply));
    }
}
