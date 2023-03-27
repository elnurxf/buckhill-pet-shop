<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;

class Post extends Model
{
    use HasFactory, Uuids, HasSlug;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'metadata'
    ];

    protected $casts = [
        'metadata' => 'json',
    ];

    /**
     * Get the options for generating the slug.
     */
    public function getSlugOptions(): SlugOptions
    {
        return SlugOptions::create()
            ->generateSlugsFrom('title')
            ->saveSlugsTo('slug');
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'metadata->image');
    }
}
