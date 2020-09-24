<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Video
 *
 * @property int $id
 * @property string $path
 * @property string $type
 * @property int $videoable_id
 * @property string $videoable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|\Eloquent $videoable
 * @method static Builder|Video newModelQuery()
 * @method static Builder|Video newQuery()
 * @method static Builder|Video query()
 * @method static Builder|Video whereCreatedAt($value)
 * @method static Builder|Video whereId($value)
 * @method static Builder|Video wherePath($value)
 * @method static Builder|Video whereType($value)
 * @method static Builder|Video whereUpdatedAt($value)
 * @method static Builder|Video whereVideoableId($value)
 * @method static Builder|Video whereVideoableType($value)
 * @mixin Eloquent
 */
class Video extends Model
{

    public function videoable()
    {
        return $this->morphTo();
    }
}
