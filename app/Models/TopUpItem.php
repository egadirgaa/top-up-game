<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUpItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'name', 'price'
    ];

    /**
     * Relasi ke transaksi top up.
     */
    public function topUpTransactions()
    {
        return $this->belongsToMany(TopUpTransaction::class, 'top_up_transaction_items')
                    ->withPivot('quantity');
    }
}
