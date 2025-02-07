<?php

namespace App\Http\Controllers\Admin;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\TopUpTransaction;
use App\Http\Controllers\Controller;
use App\Models\MidtransNotification;

class DashboardAdminController extends Controller
{
    public function index()
    {
        // Retrieve transaction summary
        $transactionSummary = [
            'totalTopUp' => TopUpTransaction::count(),
            'totalSuccess' => TopUpTransaction::where('status', 'success')->count(),
            'totalFailed' => TopUpTransaction::where('status', 'failed')->count()
        ];

        // Fetch daily transactions for the last 7 days
        $transactionsPerDay = TopUpTransaction::where('created_at', '>=', Carbon::now()->subDays(7))
            ->selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get();

        // Fetch monthly transactions for the last 6 months
        $transactionsPerMonth = TopUpTransaction::where('created_at', '>=', Carbon::now()->subMonths(6))
            ->selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, COUNT(*) as count')
            ->groupBy('year', 'month')
            ->orderBy('year')
            ->orderBy('month')
            ->get();

        // Retrieve the latest payment notifications
        $latestNotifications = MidtransNotification::latest()->take(5)->get();

        return view('admin.dashboard', [
            'transactionSummary' => $transactionSummary,
            'transactionsPerDay' => $transactionsPerDay,
            'transactionsPerMonth' => $transactionsPerMonth,
            'latestNotifications' => $latestNotifications
        ]);
    }
}
