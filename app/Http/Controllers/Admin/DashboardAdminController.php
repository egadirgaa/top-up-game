<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use App\Models\TopUpTransaction;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Models\MidtransNotification;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Ambil total transaksi
        $totalTopUp = TopUpTransaction::sum('amount') ?? 0;
        $totalSuccess = TopUpTransaction::where('status', 'success')->count() ?? 0;
        $totalFailed = TopUpTransaction::where('status', 'failed')->count() ?? 0;

        $transactionSummary = [
            'totalTopUp' => $totalTopUp,
            'totalSuccess' => $totalSuccess,
            'totalFailed' => $totalFailed,
        ];

        // Transaksi per hari (7 hari terakhir)
        $transactionsPerDay = TopUpTransaction::select(
                DB::raw('DATE(created_at) as date'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subDays(7))
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Transaksi per bulan (6 bulan terakhir)
        $transactionsPerMonth = TopUpTransaction::select(
                DB::raw('MONTH(created_at) as month'),
                DB::raw('YEAR(created_at) as year'),
                DB::raw('COUNT(*) as count')
            )
            ->where('created_at', '>=', Carbon::now()->subMonths(6))
            ->groupBy('month', 'year')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Ambil 5 notifikasi terbaru
        $latestNotifications = MidtransNotification::orderBy('created_at', 'desc')->limit(5)->get() ?? collect([]);

        return view('admin.dashboard', compact(
            'transactionSummary',
            'transactionsPerDay',
            'transactionsPerMonth',
            'latestNotifications'
        ));
    }
}
