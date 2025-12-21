<!DOCTYPE html>
<html lang="id">
  <head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Pembayaran - Goutside</title>
    <meta name="csrf-token" content="{{ csrf_token() }}" />

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Midtrans Snap -->
    <script
      src="https://app.sandbox.midtrans.com/snap/snap.js"
      data-client-key="{{ config('services.midtrans.client_key') }}"
    ></script>

    <style>
      body {
        background: linear-gradient(to bottom, #f0fdfa, #d1fae5);
        font-family: 'Inter', sans-serif;
      }

      .payment-container {
        min-height: 100vh;
        display: flex;
        justify-content: center;
        align-items: center;
        flex-direction: column;
        padding: 2rem;
        text-align: center;
      }

      .status-box {
        background: white;
        padding: 3rem 2rem;
        border-radius: 2rem;
        box-shadow: 0 20px 50px rgba(0, 0, 0, 0.1);
        max-width: 400px;
        width: 100%;
      }

      .status-box h1 {
        font-size: 1.75rem;
        font-weight: bold;
        margin-bottom: 1rem;
      }

      .status-box p {
        color: #4b5563;
        margin-bottom: 2rem;
      }

      /* loading dots animation */
      .loading-dots span {
        display: inline-block;
        width: 10px;
        height: 10px;
        margin: 0 3px;
        background-color: #10b981;
        border-radius: 50%;
        animation: bounce 1.4s infinite ease-in-out both;
      }

      .loading-dots span:nth-child(1) {
        animation-delay: 0s;
      }
      .loading-dots span:nth-child(2) {
        animation-delay: 0.2s;
      }
      .loading-dots span:nth-child(3) {
        animation-delay: 0.4s;
      }

      @keyframes bounce {
        0%,
        80%,
        100% {
          transform: scale(0);
        }
        40% {
          transform: scale(1);
        }
      }

      .btn {
        display: inline-block;
        padding: 0.75rem 1.5rem;
        background-color: #10b981;
        color: white;
        border-radius: 9999px;
        font-weight: 600;
        transition: all 0.3s;
        text-decoration: none;
      }

      .btn:hover {
        background-color: #059669;
      }
    </style>
  </head>

  <body>
    <div class="payment-container">
      <div class="status-box">
        <h1>Pembayaran Sedang Diproses</h1>
        <p>Silakan tunggu beberapa saat, jangan menutup halaman ini hingga proses selesai.</p>

        <div class="loading-dots mb-6">
          <span></span>
          <span></span>
          <span></span>
        </div>

        <a href="{{ route('katalog.index') }}" class="btn mb-2 block">Kembali ke Katalog</a>
        <a href="{{ route('reservasi.index') }}" class="btn block">Lihat Dashboard</a>
      </div>
    </div>

    <script>
      // Trigger Snap payment
      snap.pay('{{ $snapToken }}', {
        onSuccess: function (result) {
          alert('Pembayaran berhasil!');
          window.location.href = '{{ route('reservasi.index') }}';
        },
        onPending: function (result) {
          alert('Pembayaran pending, silakan cek status di dashboard.');
          window.location.href = '{{ route('reservasi.index') }}';
        },
        onError: function (result) {
          alert('Pembayaran gagal, silakan coba lagi.');
          window.location.href = '{{ route('reservasi.index') }}';
        },
      });
    </script>
  </body>
</html>
