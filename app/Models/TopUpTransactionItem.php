<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUpTransactionItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'top_up_item_id', 'quantity'
    ];

    /**
     * Relasi ke transaksi top up.
     */
    public function topUpTransaction()
    {
        return $this->belongsTo(TopUpTransaction::class);
    }

    /**
     * Relasi ke item top up.
     */
    public function topUpItem()
    {
        return $this->belongsTo(TopUpItem::class);
    }
}
