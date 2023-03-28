<?php

namespace App\Models;

use App\Traits\Sortable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Builder;

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
