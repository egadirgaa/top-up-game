@extends('layouts.app')

@section('content')
<div class="bg-gray-100 py-10">
    <div class="max-w-2xl mx-auto bg-white p-6 shadow-md rounded-lg">
        <h2 class="text-xl font-bold mb-4 text-center">Pilih Paket Top Up</h2>
        
        <div class="grid grid-cols-2 gap-4 mb-6">
            @foreach($items as $item)
                <div class="card p-4 border rounded-lg cursor-pointer hover:bg-blue-500 hover:text-white hover:-rotate-2 hover:shadow-md  hover:scale-105 transition"
                    data-id="{{ $item->id }}" 
                    data-name="{{ $item->name }}" 
                    data-price="{{ $item->price }}">
                    <h3 class="text-lg font-semibold">{{ $item->name }}</h3>
                    <p class="text-gray-700">Rp {{ number_format($item->price, 0, ',', '.') }}</p>
                </div>
            @endforeach
        </div>
        
        <input type="text" id="name" placeholder="Nama" class="w-full p-2 border rounded mb-2">
        <input type="email" id="email" placeholder="Email" class="w-full p-2 border rounded mb-2">
        <input type="text" id="phone" placeholder="Nomor HP" class="w-full p-2 border rounded mb-4">
        <input type="hidden" id="quantity-{{ $item->id }}" value="1" min="1" class="border rounded px-3 py-1 w-16">
        <div class="text-center mb-4">
            <p class="text-lg font-semibold">Total: <span id="totalPrice">Rp 0</span></p>
        </div>
        
        <button id="payButton" class="w-full bg-blue-600 text-white py-2 rounded-lg disabled:opacity-50" disabled>Bayar Sekarang</button>
    </div>
</div>
<script>
    document.addEventListener('DOMContentLoaded', function() {
        let selectedItem = null;
        
        document.querySelectorAll('.card').forEach(card => {
            card.addEventListener('click', function() {
                document.querySelectorAll('.card').forEach(c => c.classList.remove('bg-blue-500', 'text-white',  'text-white', '-rotate-2', 'scale-105'));
                this.classList.add('bg-blue-500', 'text-white', '-rotate-2' ,'scale-105');
                selectedItem = {
                    id: this.getAttribute('data-id'),
                    name: this.getAttribute('data-name'),
                    price: this.getAttribute('data-price')
                };
                document.getElementById('totalPrice').textContent = 'Rp ' + new Intl.NumberFormat('id-ID').format(selectedItem.price);
                document.getElementById('payButton').disabled = false;
            });
        });

        document.getElementById('payButton').addEventListener('click', function() {
            if (!selectedItem) return alert('Pilih item terlebih dahulu');

            let name = document.getElementById('name').value.trim();
            let email = document.getElementById('email').value.trim();
            let phone = document.getElementById('phone').value.trim();

            this.textContent = "Memproses...";
            this.disabled = true;

            fetch("{{ route('midtrans.token') }}", {
                method: "POST",
                headers: {
                    "Content-Type": "application/json",
                    "X-CSRF-TOKEN": "{{ csrf_token() }}"
                    
                },
                body: JSON.stringify({
                    name: name,
                    email: email,
                    phone: phone,
                    amount: selectedItem.price
                })
            })
            .then(response => response.json())
            .then(data => {
                console.log("Response Midtrans:", data); // Debugging untuk melihat response dari server
                if (data.snap_token) {
                    snap.pay(data.snap_token);
                } else {
                    alert('Gagal mendapatkan token pembayaran');
                }
            })
            .catch(error => {
                console.error("Error Midtrans:", error); // Debugging untuk menangkap error
                alert('Terjadi kesalahan, silakan coba lagi.');
            })
            .finally(() => {
                this.textContent = "Bayar Sekarang";
                this.disabled = false;
            });
            
        });
    });
</script>
@endsection