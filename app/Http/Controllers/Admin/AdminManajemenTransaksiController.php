<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\TopUpTransaction;
use Illuminate\Http\Request;
use Midtrans\Transaction;
use Midtrans\Config;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\DB;

class AdminManajemenTransaksiController extends Controller
{
    public function index(Request $request)
    {
        $status = $request->query('status');

        $transactions = TopUpTransaction::with('user')
            ->when($status, fn($query) => $query->where('status', $status))
            ->latest()
            ->paginate(10);

        return view('admin.transaksi.index', compact('transactions'));
    }

    public function show($id)
    {
        $transaction = TopUpTransaction::with(['user', 'items.topUpItem'])->findOrFail($id);
        return view('admin.transaksi.show', compact('transaction'));
    }

    public function confirmManual($id)
    {
        DB::transaction(function () use ($id) {
            $transaction = TopUpTransaction::findOrFail($id);
            $transaction->update(['status' => 'success']);
            Log::info("Transaksi #{$transaction->id} dikonfirmasi secara manual oleh admin.");
        });

        return redirect()->back()->with('success', 'Transaksi berhasil dikonfirmasi secara manual.');
    }

    public function resendNotification($id)
    {
        $transaction = TopUpTransaction::findOrFail($id);
        
        Config::$serverKey = env('MIDTRANS_SERVER_KEY');
        Config::$isProduction = env('MIDTRANS_PRODUCTION', false);
        Config::$isSanitized = true;
        Config::$is3ds = true;

        try {
            $status = Transaction::status($transaction->transaction_id);
            $transaction->update(['status' => $status->transaction_status]);
            Log::info("Notifikasi Midtrans untuk transaksi #{$transaction->id} dikirim ulang.");
            return redirect()->back()->with('success', 'Notifikasi berhasil dikirim ulang ke Midtrans.');
        } catch (\Exception $e) {
            Log::error("Gagal mengirim ulang notifikasi untuk transaksi #{$transaction->id}: " . $e->getMessage());
            return redirect()->back()->with('error', 'Gagal mengirim ulang notifikasi: ' . $e->getMessage());
        }
    }
}
