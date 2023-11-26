<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class User extends Model
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


    /**
     * ユーザーの売上に紐づくデータを取得
     */
    public function getStoreData(): HasMany
    {
        return $this->hasMany(Sale::class, 'users_id', 'id');
    }
}
