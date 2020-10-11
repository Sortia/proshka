<?php

namespace App;

use Eloquent;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Carbon;

/**
 * App\Direction
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read Collection|\App\Course[] $courses
 * @property-read int|null $courses_count
 * @method static Builder|Direction newModelQuery()
 * @method static Builder|Direction newQuery()
 * @method static Builder|Direction query()
 * @method static Builder|Direction whereCreatedAt($value)
 * @method static Builder|Direction whereDescription($value)
 * @method static Builder|Direction whereId($value)
 * @method static Builder|Direction whereName($value)
 * @method static Builder|Direction whereUpdatedAt($value)
 * @mixin Eloquent
 */
class Direction extends Model
{
    protected $fillable = [
        'id',
        'name',
        'description',
        'order'
    ];

    public function courses()
    {
        return $this->hasMany(Course::class);
    }
}
