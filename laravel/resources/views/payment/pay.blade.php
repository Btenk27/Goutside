<!DOCTYPE html>
<html>

<head>
    <title>Pembayaran</title>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <script src="https://app.sandbox.midtrans.com/snap/snap.js"
        data-client-key="{{ config('services.midtrans.client_key') }}"></script>

</head>

<body>

    <script>
        snap.pay('{{ $snapToken }}', {
            onSuccess: function() {
                window.location.href = "{{ route('reservasi.index') }}";
            },
            onPending: function() {
                window.location.href = "{{ route('reservasi.index') }}";
            },
            onError: function() {
                alert('Pembayaran gagal');
                window.location.href = "{{ route('reservasi.index') }}";
            }
        });
    </script>

</body>

</html>
