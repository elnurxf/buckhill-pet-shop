<?php

namespace App\Models;

use App\Traits\Sortable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

/**
 * App\Models\Promotion
 *
 * @property int $id
 * @property string $uuid
 * @property string $title
 * @property string $content
 * @property array $metadata
 * @property \Illuminate\Support\Carbon|null $created_at
 * @property \Illuminate\Support\Carbon|null $updated_at
 * @property-read \App\Models\File|null $image
 * @method static \Database\Factories\PromotionFactory factory($count = null, $state = [])
 * @method static Builder|Promotion newModelQuery()
 * @method static Builder|Promotion newQuery()
 * @method static Builder|Promotion query()
 * @method static Builder|Promotion sortable(\Illuminate\Http\Request $request)
 * @method static Builder|Promotion valid()
 * @method static Builder|Promotion whereContent($value)
 * @method static Builder|Promotion whereCreatedAt($value)
 * @method static Builder|Promotion whereId($value)
 * @method static Builder|Promotion whereMetadata($value)
 * @method static Builder|Promotion whereTitle($value)
 * @method static Builder|Promotion whereUpdatedAt($value)
 * @method static Builder|Promotion whereUuid($value)
 * @mixin \Eloquent
 */
class Promotion extends Model
{
    use HasFactory, Uuids, Sortable;

    protected $fillable = [
        'title',
        'content',
        'metadata',
    ];

    protected $casts = [
        'metadata' => 'json',
    ];

    public function image()
    {
        return $this->belongsTo(File::class, 'metadata->image');
    }

    public function scopeValid(Builder $query)
    {
        return $query->whereRaw('CURDATE() BETWEEN metadata ->> "$.valid_from" AND metadata ->> "$.valid_to"');
    }
}
