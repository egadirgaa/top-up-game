<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MidtransNotification extends Model
{
    use HasFactory;

    protected $fillable = [
        'transaction_id', 'notification_data'
    ];

    /**
     * Relasi ke transaksi top up.
     */
    public function topUpTransaction()
    {
        return $this->belongsTo(TopUpTransaction::class);
    }
}
