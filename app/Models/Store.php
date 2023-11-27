<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\HasMany;

use Illuminate\Database\Eloquent\Model;

class Store extends Model
{
    use HasFactory;
    protected $fillable = [
        'store_name',
        'role',
        'deleted_at',
    ];

    /**
     * 売上データを取得
     */
    public function getStoreData(): HasMany
    {
        return $this->hasMany(Sale::class);
    }
}
