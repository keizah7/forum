<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

/**
 * App\Favorite
 *
 * @property int $id
 * @property int $user_id
 * @property string $favorable_type
 * @property int $favorable_id
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \Illuminate\Database\Eloquent\Collection|\App\Activity[] $activity
 * @property-read int|null $activity_count
 * @property-read \Illuminate\Database\Eloquent\Model|\Eloquent $favorable
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite query()
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereFavorableId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereFavorableType($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder|\App\Favorite whereUserId($value)
 * @mixin \Eloquent
 */
class Favorite extends Model
{
    use RecordsActivity;

    protected $guarded = [];

    public function favorable() {
        return $this->morphTo();
    }
}
