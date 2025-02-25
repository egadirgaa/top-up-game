@extends('layouts.app')

@section('content')
<div class="container mx-auto p-6">
    <h2 class="text-2xl font-bold mb-4">Checkout Top Up</h2>

    <div class="grid grid-cols-2 md:grid-cols-3 gap-4">
        @foreach ($items as $item)
            <div class="border p-4 rounded-lg cursor-pointer hover:bg-gray-200"
                onclick="selectItem({{ $item->id }}, '{{ $item->name }}', {{ $item->price }})">
                <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                <p class="text-gray-600">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
            </div>
        @endforeach
    </div>

    <form id="checkout-form" class="mt-6">
        <input type="hidden" id="item_id" name="item_id">
        <input type="hidden" id="item_price" name="amount">
        
        <div class="mb-4">
            <label class="block text-gray-700">Item:</label>
            <input type="text" id="selected_item" class="border p-2 w-full" readonly>
        </div>

        <button type="button" onclick="checkout()" class="bg-blue-500 text-white px-4 py-2 rounded">Bayar</button>
    </form>

    <div id="snap-container"></div>
</div>

<script src="https://app.sandbox.midtrans.com/snap/snap.js" data-client-key="{{ env('MIDTRANS_CLIENT_KEY') }}"></script>
<script>
    function selectItem(id, name, price) {
        document.getElementById('item_id').value = id;
        document.getElementById('item_price').value = price;
        document.getElementById('selected_item').value = name;
    }

    function checkout() {
        let itemId = document.getElementById('item_id').value;
        let amount = document.getElementById('item_price').value;

        if (!itemId) {
            alert("Pilih item terlebih dahulu!");
            return;
        }

        fetch('/get-snap-token', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/json',
                'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]').content
            },
            body: JSON.stringify({
                transaction_id: itemId
            })
        })
        .then(response => response.json())
        .then(data => {
            if (data.snap_token) {
                window.snap.pay(data.snap_token);
            } else {
                alert("Gagal mendapatkan token pembayaran.");
            }
        })
        .catch(error => console.error('Error:', error));
    }
</script>
@endsection
