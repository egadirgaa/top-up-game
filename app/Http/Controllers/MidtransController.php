<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\TopUpItem;
use Illuminate\Http\Request;
use App\Models\TopUpTransaction;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Validator;

class MidtransController extends Controller
{
    public function index()
    {
        $items = TopUpItem::all();

        return view('checkout', compact('items'));
    }

    public function __construct()
    {
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false; // Gunakan sandbox mode
        Config::$isSanitized = true;
        Config::$is3ds = true;
    }

    public function getSnapToken(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'transaction_id' => 'required|exists:top_up_transactions,id',
        ]);

        if ($validator->fails()) {
            return response()->json(['error' => $validator->errors()],  400);
        }

        $transaction = TopUpTransaction::with('user', 'items')  ->findOrFail($request->transaction_id);

        $items = $transaction->items->map(function ($item) {
            return [
                'id' => $item->top_up_item_id,
                'price' => $item->topUpItem->price,
                'quantity' => $item->quantity,
                'name' => $item->topUpItem->name,
            ];
        })->toArray();

        $payload = [
            'transaction_details' => [
                'order_id' => $transaction->id,
                'gross_amount' => $transaction->amount,
            ],
            'customer_details' => [
                'first_name' => $transaction->user->name,
                'email' => $transaction->user->email,
                'phone' => $transaction->user->phone,
            ],
            'item_details' => $items,
        ];

        try {
            Config::$serverKey = env('MIDTRANS_SERVER_KEY');
            Config::$isProduction = false; // Ubah ke true jika sudah production
            Config::$isSanitized = true;
            Config::$is3ds = true;

            $snapToken = Snap::getSnapToken($payload);

            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            return response()->json(['error' => $e->getMessage()],  500);
        }
    }

    public function getExistingToken($transaction_id)
    {
        $transaction = TopUpTransaction::where('transaction_id', $transaction_id)->first();
    
        if ($transaction && $transaction->snap_token) {
            return response()->json(['snap_token' => $transaction->snap_token]);
        }
    
        return response()->json(['error' => 'Transaksi tidak ditemukan atau sudah kadaluarsa.'], 404);
    }

}
