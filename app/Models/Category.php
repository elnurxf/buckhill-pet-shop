<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Sluggable\HasSlug;
use Spatie\Sluggable\SlugOptions;
use App\Traits\Sortable;

class Category extends Model
{
    use HasFactory, Uuids, HasSlug, Sortable;

    protected $fillable = [
        'title',
        'slug',
    ];

    public $sortables = [
        'id',
        'title',
        'slug',
        'created_at',
        'updated_at',
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
}
