<?php

namespace App\Models;

use Cviebrock\EloquentSluggable\Sluggable;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Support\Carbon;
use Override;

/**
 * @property int $id
 * @property int $is_public
 * @property string $name
 * @property string $description
 * @property string $slug
 * @property int $number_of_days
 * @property Carbon|null $created_at
 * @property Carbon|null $updated_at
 * @property-read mixed $number_of_nights
 * @property-read Collection<int, Tours> $tours
 * @property-read int|null $tours_count
 *
 * @method static \Database\Factories\TravelFactory factory($count = null, $state = [])
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel findSimilarSlugs(string $attribute, array $config, string $slug)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel newModelQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel newQuery()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel query()
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel whereCreatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel whereDescription($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel whereId($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel whereIsPublic($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel whereName($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel whereNumberOfDays($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel whereSlug($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel whereUpdatedAt($value)
 * @method static \Illuminate\Database\Eloquent\Builder<static>|Travel withUniqueSlugConstraints(\Illuminate\Database\Eloquent\Model $model, string $attribute, array $config, string $slug)
 *
 * @mixin \Eloquent
 */
class Travel extends Model
{
    use HasFactory, Sluggable;

    //
    protected $table = 'travels';

    protected $fillable = [
        'is_public',
        'slug',
        'name',
        'description',
        'number_of_days',
    ];

    public function sluggable(): array
    {
        return [
            'slug' => [
                'source' => 'name',
            ],
        ];
    }

    public function numberOfNights(): Attribute
    {
        return Attribute::make(
            get: fn ($value, $attributes) => ($attributes['number_of_days'] > 0 ? $attributes['number_of_days'] - 1 : 0)
        );
    }

    public function tours(): HasMany
    {
        return $this->hasMany(Tours::class, 'travels_id');
    }

    #[Override]
    public function getRouteKeyName()
    {
        return 'slug';
    }
}
