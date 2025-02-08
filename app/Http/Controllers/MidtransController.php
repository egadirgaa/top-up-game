<?php

namespace App\Http\Controllers;

use Exception;
use Midtrans\Snap;
use Midtrans\Config;
use App\Models\TopUpItem;
use Illuminate\Http\Request;
use App\Models\TopUpTransaction;
use Illuminate\Support\Facades\Log;

class MidtransController extends Controller
{
    public function checkout()
    {
        $items = TopUpItem::all();

        return view('checkout', compact('items')); // Menampilkan halaman checkout
    }

    public function getToken(Request $request)
    {
        try {
            \Log::info('Request ke Midtrans:', $request->all()); // Debugging
        
            $transaction = [
                'transaction_details' => [
                    'order_id' => uniqid(),
                    'gross_amount' => (int) $request->amount, // Pastikan ini angka
                ],
                'customer_details' => [
                    'first_name' => $request->name,
                    'email' => $request->email,
                    'phone' => $request->phone,
                ]
            ];
        
            $snapToken = \Midtrans\Snap::getSnapToken($transaction);
            \Log::info('Token Midtrans:', ['snap_token' => $snapToken]); // Debugging
        
            return response()->json(['snap_token' => $snapToken]);
        } catch (\Exception $e) {
            \Log::error('Midtrans Error:', ['message' => $e->getMessage()]); // Tangkap error
            return response()->json(['error' => $e->getMessage()], 500);
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
