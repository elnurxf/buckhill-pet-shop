<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Promotion extends Model
{
    use HasFactory, Uuids;

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
}
