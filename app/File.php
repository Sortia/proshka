<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\File
 *
 * @property int $id
 * @property string $name
 * @property string $path
 * @property int $user_id
 * @property int $fileable_id
 * @property string $fileable_type
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Model|\Eloquent $fileable
 * @method static Builder|File newModelQuery()
 * @method static Builder|File newQuery()
 * @method static Builder|File query()
 * @method static Builder|File whereCreatedAt($value)
 * @method static Builder|File whereFileableId($value)
 * @method static Builder|File whereFileableType($value)
 * @method static Builder|File whereId($value)
 * @method static Builder|File whereName($value)
 * @method static Builder|File wherePath($value)
 * @method static Builder|File whereUpdatedAt($value)
 * @method static Builder|File whereUserId($value)
 * @mixin Eloquent
 */
class File extends Model
{
    protected $fillable = [
        'path',
        'fileable_id',
        'fileable_type',
        'name',
        'user_id'
    ];

    public function fileable()
    {
        return $this->morphTo();
    }
}
