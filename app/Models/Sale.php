<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

use Illuminate\Database\Eloquent\Model;

class sale extends Model
{
    use HasFactory;

    use HasFactory;
    protected $fillable = [
        'users_id',
        'stores_id',
        'customer_payment',
        'deleted_at',
    ];
    public function getUserData(): BelongsTo
    {
        return $this->belongsTo(User::class, 'users_id', 'id');
    }
    public function getStoreData(): BelongsTo
    {
        return $this->belongsTo(Store::class, 'stores_id', 'id');
    }

}
