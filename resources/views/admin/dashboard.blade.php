@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

    {{-- Ringkasan Transaksi --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg reveal">
            <h2 class="text-xl font-semibold">Total Top-Up</h2>
            <p class="text-3xl font-bold mt-2">{{ $transactionSummary['totalTopUp'] }}</p>
        </div>
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg reveal">
            <h2 class="text-xl font-semibold">Transaksi Berhasil</h2>
            <p class="text-3xl font-bold mt-2">{{ $transactionSummary['totalSuccess'] }}</p>
        </div>
        <div class="bg-red-500 text-white p-6 rounded-lg shadow-lg reveal">
            <h2 class="text-xl font-semibold">Transaksi Gagal</h2>
            <p class="text-3xl font-bold mt-2">{{ $transactionSummary['totalFailed'] }}</p>
        </div>
    </div>

    {{-- Grafik Transaksi --}}
    <div class="bg-white p-6 mt-8 rounded-lg shadow-lg reveal">
        <h2 class="text-2xl font-semibold mb-4">Grafik Transaksi (7 Hari Terakhir)</h2>
        <canvas id="transactionsChart"></canvas>
    </div>

    <div class="bg-white p-6 mt-8 rounded-lg shadow-lg reveal">
        <h2 class="text-2xl font-semibold mb-4">Grafik Transaksi (6 Bulan Terakhir)</h2>
        <canvas id="monthlyChart"></canvas>
    </div>

    {{-- Notifikasi Terbaru --}}
    <div class="bg-white p-6 mt-8 rounded-lg shadow-lg reveal">
        <h2 class="text-2xl font-semibold mb-4">Notifikasi Pembayaran Terbaru</h2>
        <ul>
            @forelse($latestNotifications as $notification)
                <li class="border-b py-2">
                    <span class="font-semibold">Transaksi #{{ $notification->transaction_id }}</span>
                    <p class="text-sm text-gray-600">{{ json_decode($notification->notification_data)->transaction_status ?? 'Unknown' }}</p>
                    <p class="text-xs text-gray-500">{{ $notification->created_at->format('d M Y H:i') }}</p>
                </li>
            @empty
                <li class="text-gray-500">Tidak ada notifikasi terbaru.</li>
            @endforelse
        </ul>
    </div>
</div>

{{-- ScrollReveal & Chart.js --}}
@section('scripts')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/scrollreveal"></script>
<script>
    // Animasi ScrollReveal
    ScrollReveal().reveal('.reveal', { delay: 200, distance: '50px', origin: 'bottom', easing: 'ease-in-out' });

    // Data untuk grafik transaksi harian
    const dailyData = {
        labels: @json($transactionsPerDay->pluck('date')),
        datasets: [{
            label: 'Transaksi Per Hari',
            data: @json($transactionsPerDay->pluck('count')),
            backgroundColor: 'rgba(54, 162, 235, 0.5)',
            borderColor: 'rgba(54, 162, 235, 1)',
            borderWidth: 2
        }]
    };

    // Data untuk grafik transaksi bulanan
    const monthlyData = {
        labels: @json($transactionsPerMonth->map(fn($t) => $t->month . '-' . $t->year)),
        datasets: [{
            label: 'Transaksi Per Bulan',
            data: @json($transactionsPerMonth->pluck('count')),
            backgroundColor: 'rgba(75, 192, 192, 0.5)',
            borderColor: 'rgba(75, 192, 192, 1)',
            borderWidth: 2
        }]
    };

    // Render grafik harian
    new Chart(document.getElementById('transactionsChart'), {
        type: 'bar',
        data: dailyData,
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });

    // Render grafik bulanan
    new Chart(document.getElementById('monthlyChart'), {
        type: 'line',
        data: monthlyData,
        options: { responsive: true, scales: { y: { beginAtZero: true } } }
    });
</script>
@endsection

@endsection
