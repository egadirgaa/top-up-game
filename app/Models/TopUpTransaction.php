<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class TopUpTransaction extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id', 'amount', 'status', 'payment_type', 'transaction_id', 'payment_url'
    ];

    /**
     * Relasi ke pengguna.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    /**
     * Relasi ke items dalam transaksi top up.
     */
    public function topUpItems()
    {
        return $this->belongsToMany(TopUpItem::class, 'top_up_transaction_items')
                    ->withPivot('quantity');
    }

    /**
     * Relasi ke notifikasi Midtrans.
     */
    public function midtransNotification()
    {
        return $this->hasOne(MidtransNotification::class);
    }
}
