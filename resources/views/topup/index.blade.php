@extends('layouts.app')

@section('content')
<div class="container mx-auto px-4 py-6">
    <h1 class="text-3xl font-bold text-gray-800 mb-6">Top-Up Mobile Legends</h1>

    <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
        @foreach($items as $item)
        <div class="bg-white shadow-lg rounded-lg p-5 text-center">
            <img src="https://via.placeholder.com/150" alt="{{ $item->name }}" class="mx-auto mb-4">
            <h2 class="text-xl font-semibold">{{ $item->name }}</h2>
            <p class="text-gray-600 text-lg font-bold">Rp{{ number_format($item->price, 0, ',', '.') }}</p>
            <input type="number" id="quantity-{{ $item->id }}" value="1" min="1" class="border rounded px-3 py-1 w-16">
            <button onclick="checkout({{ $item->id }})" class="mt-3 bg-blue-500 text-white px-4 py-2 rounded-lg hover:bg-blue-600">Beli</button>
        </div>
        @endforeach
    </div>
</div>

<script>
function checkout(itemId) {
    const quantity = document.getElementById(`quantity-${itemId}`).value;

    fetch("{{ route('topup.checkout') }}", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": "{{ csrf_token() }}"
        },
        body: JSON.stringify({ item_id: itemId, quantity: quantity })
    })
    .then(response => response.json())
    .then(data => {
        if (data.payment_url) {
            window.location.href = data.payment_url; 
        } else {
            alert("Terjadi kesalahan, coba lagi.");
        }
    })
    .catch(error => console.error("Error:", error));
}
</script>
@endsection
