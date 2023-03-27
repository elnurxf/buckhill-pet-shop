<?php

namespace App\Models;

use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Product extends Model
{
    use HasFactory, Uuids, SoftDeletes;

    protected $fillable = [
        'category_uuid',
        'title',
        'price',
        'description',
        'metadata',
    ];

    protected $casts = [
        'price'    => 'float',
        'metadata' => 'json',
    ];

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_uuid');
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'metadata->brand');
    }

    public function image()
    {
        return $this->belongsTo(File::class, 'metadata->image');
    }

}
