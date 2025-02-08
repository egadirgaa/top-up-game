<!doctype html>
<html lang="id">
<head>
    <title>Top Up Mobile Legends:BANG-BANG bangko</title>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    
    {{-- bootstrap & tailwind --}}
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css" integrity="sha384-xOolHFLEh07PJGoPkLv1IbcEPTNtaed2xpHsD9ESMhqIYd0nLMwNLD69Npy4HI+N" crossorigin="anonymous">
    <script src="https://cdn.tailwindcss.com"></script>


    {{-- css --}}
    <link href="{{ asset('css/welcome.css') }}" rel="stylesheet">

    {{-- font --}}
    <link href="https://fonts.googleapis.com/css2?family=Afacad+Flux:wght@100..1000&display=swap" rel="stylesheet">
    
    {{-- Font Awesome CDN --}}
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css" integrity="sha384-M6bShsa3U8O0pjs6xpRjS0xOa9L1B0FfJEXr4zE57p8rdkAZ5v5I5Xo2B8GgK5V5" crossorigin="anonymous" referrerpolicy="no-referrer" />


    <style>
    /* Wrapper utama */
.mtd-wrapper {
    width: 100vw !important;
    height: fit-content;
    margin-left: -9px;
    width: 105% !important;
    padding-left: 0;
    white-space: nowrap;
    overflow-x: scroll;
    overflow-y: hidden;
    -webkit-overflow-scrolling: touch;
}

.mtd:first-child {
    margin-left: 15px;
}

/* Badge AI */
.ai-badge {
    box-shadow: 0 0 0 0 #d39e00;
    animation: aiglow 1.4s ease-out infinite;
    font-size: 12px !important;
}

@keyframes aiglow {
    0% { box-shadow: 0 0 0 0 #d39e00; }
    50% { box-shadow: 0 0 10px 0 #d39e00; }
}

/* Link AI Wrapper */
.ai-wrapper div a {
    display: inline-block;
    background: rgba(0, 0, 0, 0.05);
    max-width: max-content;
    margin: 6px 0;
    padding: 3px 8px;
    border-radius: 5px;
    font-size: 12px;
}

/* Style untuk mtd */
.mtd {
    width: max-content;
    border-radius: 20px;
    padding: 5px 18px;
    display: inline-block;
    border: 1px solid #ebebeb;
    margin-right: 5px;
    cursor: pointer;
    background: white;
}

.mtd:last-child {
    margin-right: 18px !important;
}

.mtd.active {
    border: 1px solid #6bbaec;
    background: #6bbaec;
    color: white;
}

/* Animasi Rotasi */
@keyframes rotating {
    from { transform: rotate(360deg); }
    to { transform: rotate(0deg); }
}

.rotating {
    animation: rotating 10s linear infinite;
}

/* Animasi Gambar Bergerak ke Atas dan ke Bawah */
@keyframes mover {
    0% { transform: translateY(0); }
    100% { transform: translateY(-10px); }
}

img.up-down {
    animation: mover 1s infinite alternate;
}

/* Styling tambahan */
.category.mtd {
    background: white;
}

.img-bg-top {
    position: absolute;
    top: -250px;
    filter: blur(5px);
    opacity: 0;
    left: 0;
    width: 100%;
    transition: 0.4s ease;
}

.img-bg-top.showed {
    top: 66px;
    filter: blur(0);
    opacity: 1;
}

.top-wrapper {
    padding-top: 100px !important;
    background-image: none !important;
}
    </style>




</head>
  <body>


      <header class="navbar justify-content-between navbar-light bd-navbar align-items-baseline">
        <a class="navbar-brand mr-0 mr-md-2 pos-relative" href="/" aria-label="EVOS Toupup">
            {{-- logo disini --}}
        </a>
        <a class="btn btn-login mb-0 btn-icon" href="{{ route('showLogin') }}" style="letter-spacing: .5px; padding-left: 22px;">
            Login <img src="{{ asset('img/login.gif') }}" style="width: 20px; right: 18px;opacity: 90%!important; filter: none!important">
        </a>
      </header>

  <div class="main-wrapper mt-3">
    @yield('content')
  </div>

  {{-- navbar --}}
  <nav>
    <ul>
      <li class="navigation no-select link" data-uri="home">
        <img src="https://evosfiles.blob.core.windows.net/main-img/ic-home.png"> <span>Home</span>
      </li>
      <li class="navigation no-select link" data-uri="transaction"><img src="https://evosfiles.blob.core.windows.net/main-img/ic-transaction.png"> <span>Transaksi</span></li>
      <li class="navigation no-select link" data-uri="blog"><img src="https://evosfiles.blob.core.windows.net/main-img/ic-write.png"> <span>Blog</span></li>
      <li class="navigation no-select link" data-uri="voucher"><img src="https://evosfiles.blob.core.windows.net/main-img/ic-promo.png"> <span>Voucher</span></li>     
        <li class="no-select mr-1" onclick="if (!window.__cfRLUnblockHandlers) return false; location.href='https://wa.me/6281510475205'" data-cf-modified-8b1ca0bbdc7e2ba214221639-=""><img src="https://evosfiles.blob.core.windows.net/main-img/ic-chat.png"> <span>Chat</span></li>
    </ul>
  </nav>

  {{-- footer --}}
  <footer class="index-1">
    <div class="row">
      <div class="col-md-4 col-12">
        <div class="">
          <p class="tagline">Ditempat Kami Dijamin Aman Dan Terpercaya!</p>
          <img src="{{ asset('img/pngegg.png') }}" width="500">
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="link-wrapper mt-md-0 mt-3">
          <p class="link-title">Pembayaran Aman</p>
          <div class="payment-content">
            <img class="mb-3" src="https://evosfiles.blob.core.windows.net/main-img/go-pay.png">
            <img class="mb-3" src="https://evosfiles.blob.core.windows.net/main-img/qris.png">
            <img class="mb-3" src="https://evosfiles.blob.core.windows.net/main-img/dana-removebg-preview.png">
            <img class="mb-3" src="https://evosfiles.blob.core.windows.net/main-img/mandiri.png">
            <img class="mb-3" src="https://evosfiles.blob.core.windows.net/main-img/bni-removebg-preview.png">
            <img class="mb-3" src="https://evosfiles.blob.core.windows.net/main-img/bsi.png">
            <img class="mb-3" src="https://evosfiles.blob.core.windows.net/main-img/bri.png">
            <!-- <span>10+ Lainnya</span> -->
          </div>
        </div>
        <div class="link-wrapper mt-3">
          <p class="link-title">Link Lainnya</p>
          <div class="link-content">
            <a href="javascript:;" class="link" data-uri="syarat-dan-ketentuan">Syarat dan Ketentuan</a>
            <a href="javascript:;" class="link" data-uri="kebijakan-privasi">Kebijakan Privasi</a>
            <a href="javascript:;" class="link" data-uri="blog">Blog</a>
          </div>
        </div>
      </div>
      <div class="col-md-4 col-12">
        <div class="link-wrapper mt-md-0 mt-3">
          <p class="link-title">Layanan Pengaduan Konsumen</p>
          <div class="link-content">
            <a href="#"><i class="fas fa-phone-volume mr-2"> +62 895 0382 8151</a>
            <a href="#" style="text-transform: lowercase;"><i class="fas fa-envelope mr-2"></i>[email&#160;protected]</a>
            <p class="mt-3">Direktorat Jenderal Perlindungan Konsumen dan Tertib Niaga Kementerian Perdagangan Republik Indonesia </p>
            <a href="#"> +62 895 0382 8151</a>
          </div>
        </div>
      </div>
    </div>
  </footer>
</body>
</html>
