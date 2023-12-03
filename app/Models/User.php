<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

use Illuminate\Database\Eloquent\Model;

class User extends Authenticatable
{
    use HasFactory;
    protected $fillable = [
        'name',
        'email',
        'email_verified_at',
        'password',
        'role',
        'deleted_at',
    ];


    public function scopeSearchUsers($query, $input = null)
    {   
        if (!empty($input)) {
            return $query->where('name', 'like', $input . '%');
        }
    }
    /**
     * ユーザーの売上に紐づくデータを取得
     */
    public function sale(): HasMany
    {
        return $this->hasMany(Sale::class, 'users_id', 'id');
    }

    public function store(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'stores_id', 'id');
    }
}
