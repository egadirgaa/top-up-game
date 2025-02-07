@extends('layouts.app')

@section('content')
<div class="container mx-auto p-4">
    <h1 class="text-2xl font-bold mb-4">Top Up Mobile Legends</h1>

    <!-- Daftar Item Top Up -->
    <div class="grid grid-cols-2 md:grid-cols-4 gap-4">
        @foreach($items as $item)
            <div class="border p-4 rounded-lg shadow-md">
                <h2 class="text-lg font-semibold">{{ $item->name }}</h2>
                <p class="text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                <button onclick="processPayment({{ $item->id }}, {{ $item->price }})" class="mt-2 bg-blue-500 text-white px-4 py-2 rounded">Beli</button>
            </div>
        @endforeach
    </div>
</div>

<script>
    function processPayment(itemId, amount) {
        fetch("{{ route('api.createTransaction') }}", {
            method: "POST",
            headers: {
                "Content-Type": "application/json",
                "X-CSRF-TOKEN": "{{ csrf_token() }}"
            },
            body: JSON.stringify({
                user_id: {{ auth()->user()->id }},
                amount: amount
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                window.location.href = data.payment_url;
            } else {
                alert("Transaksi gagal: " + data.message);
            }
        })
        .catch(error => console.error("Error:", error));
    }
</script>
@endsection
