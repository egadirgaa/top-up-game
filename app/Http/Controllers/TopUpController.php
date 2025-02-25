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
            'name' => 'required|string|max:255',
            'email' => 'required|email',
            'phone' => 'required|string|max:15',
            'item_id' => 'required|exists:top_up_items,id'
        ]);
    
        $user = auth()->user()->id; // Jika user sudah login
        $item = TopUpItem::findOrFail($request->item_id);
        $totalPrice = $item->price;
    
        // Simpan transaksi ke database
        $transaction = TopUpTransaction::create([
            'user_id' => $user ? $user->id : null,
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
                'order_id' => $transaction->id,
                'gross_amount' => $totalPrice,
            ],
            'customer_details' => [
                'first_name' => $request->name,
                'email' => $request->email,
                'phone' => $request->phone,
            ]
        ];
    
        // Generate Snap Token
        $snapToken = Snap::createTransaction($params);
    
        // Simpan Payment URL di transaksi
        $transaction->update(['payment_url' => $snapToken->redirect_url]);
    
        return response()->json(['snap_token' => $snapToken->token]);
    }

}