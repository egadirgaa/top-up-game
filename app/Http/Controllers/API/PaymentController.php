<?php

namespace App\Http\Controllers\API;

use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Http\Request;
use App\Models\TopUpTransaction;
use App\Http\Controllers\Controller;

class PaymentController extends Controller
{
    public function createTransaction(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'amount' => 'required|numeric|min:1000', 
        ]);

        $transaction = TopUpTransaction::create([
            'user_id' => $request->user_id,
            'amount' => $request->amount,
            'status' => 'pending'
        ]);

        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        $payload = [
            'transaction_details' => [
                'order_id' => 'TOPUP-' . $transaction->id,
                'gross_amount' => $transaction->amount,
            ],
            'customer_details' => [
                'email' => $request->user()->email ?? 'tidak ada detail',
            ]
        ];

        try {
            $snapToken = Snap::getSnapToken($payload);
            $transaction->payment_url = "https://app.sandbox.midtrans.com/snap/v2/vtweb/" . $snapToken;
            $transaction->save();

            return response()->json([
                'success' => true,
                'message' => 'Transaksi berhasil dibuat',
                'payment_url' => $transaction->payment_url
            ], 200);
        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => 'Gagal membuat transaksi',
                'error' => $e->getMessage()
            ], 500);
        }
    }
}
