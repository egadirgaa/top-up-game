<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\TopUpItem;
use App\Models\TopUpTransaction;
use App\Models\TopUpTransactionItem;
use Midtrans\Snap;
use Midtrans\Config;
use Illuminate\Support\Facades\Auth;

class TopUpController extends Controller
{
    public function index()
    {
        $items = TopUpItem::all();
        return view('topup.index', compact('items'));
    }

    public function checkout(Request $request)
    {
        $request->validate([
            'item_id' => 'required|exists:top_up_items,id',
            'quantity' => 'required|integer|min:1'
        ]);
    
        $user = auth()->user();
        $item = TopUpItem::findOrFail($request->item_id);
        $totalPrice = $item->price * $request->quantity;
    
        // Buat transaksi di database
        $transaction = TopUpTransaction::create([
            'user_id' => $user->id,
            'amount' => $totalPrice,
            'status' => 'pending'
        ]);
    
        // Konfigurasi Midtrans
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = false;
        Config::$isSanitized = true;
        Config::$is3ds = true;
    
        // Data pembayaran Midtrans
        $params = [
            'transaction_details' => [
                'order_id' => "TOPUP-" . $transaction->id,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $user->name,
                'email' => $user->email,
                'phone' => $user->phone,
            ]
        ];
    
        // Generate Snap Token
        $snapToken = Snap::createTransaction($params);
    
        // Simpan Payment URL di transaksi
        $transaction->update(['payment_url' => $snapToken->redirect_url]);
    
        return response()->json(['payment_url' => $snapToken->redirect_url]);
    }
}