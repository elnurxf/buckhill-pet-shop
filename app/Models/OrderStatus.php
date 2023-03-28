<?php

namespace App\Models;

use App\Traits\Sortable;
use App\Traits\Uuids;
use Illuminate\Database\Eloquent\Model;

class OrderStatus extends Model
{
    use Uuids, Sortable;

    protected $fillable = [
        'title',
    ];

    public $sortables = [
        'id',
        'title',
        'created_at',
        'updated_at',
    ];
}
