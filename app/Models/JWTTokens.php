<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class JWTTokens extends Model
{
    protected $table = 'jwt_tokens';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'user_id',
        'unique_id',
        'token_title',
        'restrictions',
        'permissions',
        'created_at',
        'updated_at',
        'expires_at',
        'last_used_at',
        'refreshed_at',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'unique_id',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'created_at'   => 'datetime',
        'updated_at'   => 'datetime',
        'expires_at'   => 'datetime',
        'last_used_at' => 'datetime',
        'refreshed_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }
}
