@extends('layouts.admin')

@section('content')
<div class="container mx-auto p-6">
    <h1 class="text-3xl font-bold mb-6">Dashboard Admin</h1>

    {{-- Ringkasan Transaksi --}}
    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        <div class="bg-blue-500 text-white p-6 rounded-lg shadow-lg reveal">
            <h2 class="text-xl font-semibold">Total Top-Up</h2>
            <p class="text-3xl font-bold mt-2">{{ number_format($transactionSummary['totalTopUp'], 0, ',', '.')  ?? 0}}</p>
            @if ($transactionSummary['totalTopUp'] == 0)
                <p class="text-sm">Belum ada transaksi top-up.</p>
            @endif
        </div>
        <div class="bg-green-500 text-white p-6 rounded-lg shadow-lg reveal">
            <h2 class="text-xl font-semibold">Transaksi Berhasil</h2>
            <p class="text-3xl font-bold mt-2">{{ $transactionSummary['totalSuccess'] }}</p>
            @if ($transactionSummary['totalSuccess'] == 0)
                <p class="text-sm">Belum ada transaksi sukses.</p>
            @endif
        </div>
        <div class="bg-red-500 text-white p-6 rounded-lg shadow-lg reveal">
            <h2 class="text-xl font-semibold">Transaksi Gagal</h2>
            <p class="text-3xl font-bold mt-2">{{ $transactionSummary['totalFailed'] }}</p>
            @if ($transactionSummary['totalFailed'] == 0)
                <p class="text-sm">Tidak ada transaksi yang gagal.</p>
            @endif
        </div>
    </div>

    {{-- Grafik Transaksi (7 Hari Terakhir) --}}
    <div class="bg-white p-6 mt-8 rounded-lg shadow-lg reveal">
        <h2 class="text-2xl font-semibold mb-4">Grafik Transaksi (7 Hari Terakhir)</h2>
        @if($transactionsPerDay->isNotEmpty())
            <canvas id="transactionsChart"></canvas>
        @else
            <p class="text-gray-500">Tidak ada data transaksi dalam 7 hari terakhir.</p>
        @endif
    </div>

    {{-- Grafik Transaksi (6 Bulan Terakhir) --}}
    <div class="bg-white p-6 mt-8 rounded-lg shadow-lg reveal">
        <h2 class="text-2xl font-semibold mb-4">Grafik Transaksi (6 Bulan Terakhir)</h2>
        @if($transactionsPerMonth->isNotEmpty())
            <canvas id="monthlyChart"></canvas>
        @else
            <p class="text-gray-500">Tidak ada data transaksi dalam 6 bulan terakhir.</p>
        @endif
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
@push('script')
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script src="https://unpkg.com/scrollreveal"></script>
<script>
    ScrollReveal().reveal('.reveal', { delay: 200, distance: '50px', origin: 'bottom', easing: 'ease-in-out' });

    const dailyLabels = @json($transactionsPerDay->pluck('date'));
    const dailyData = @json($transactionsPerDay->pluck('count'));

    if (dailyLabels.length > 0) {
        new Chart(document.getElementById('transactionsChart'), {
            type: 'bar',
            data: {
                labels: dailyLabels,
                datasets: [{ label: 'Transaksi Per Hari', data: dailyData, backgroundColor: 'rgba(54, 162, 235, 0.5)', borderColor: 'rgba(54, 162, 235, 1)', borderWidth: 2 }]
            },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    }

    const monthlyLabels = @json($transactionsPerMonth->map(fn($t) => $t['month'] . '-' . $t['year']));
    const monthlyData = @json($transactionsPerMonth->pluck('count'));

    if (monthlyLabels.length > 0) {
        new Chart(document.getElementById('monthlyChart'), {
            type: 'line',
            data: { labels: monthlyLabels, datasets: [{ label: 'Transaksi Per Bulan', data: monthlyData, backgroundColor: 'rgba(75, 192, 192, 0.5)', borderColor: 'rgba(75, 192, 192, 1)', borderWidth: 2 }] },
            options: { responsive: true, scales: { y: { beginAtZero: true } } }
        });
    }
</script>
@endpush
@endsection
