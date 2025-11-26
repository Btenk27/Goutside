<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Tailwind Test Page</title>
    {{-- WAJIB: ini yang memuat CSS Tailwind --}}
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-gray-100 text-gray-800 min-h-screen flex flex-col items-center justify-center">

    <div class="bg-white shadow-xl rounded-xl p-8 w-96 text-center border border-gray-200">
        <h1 class="text-3xl font-bold text-emerald-600 mb-4">
            🎉 Tailwind Berhasil!
        </h1>
        <p class="text-gray-600 mb-6">
            Jika tampilan ini sudah berwarna dan rapi, Tailwind sudah aktif.
        </p>

        <button class="bg-emerald-600 hover:bg-emerald-700 text-white font-semibold py-2 px-4 rounded-lg transition">
            Coba Tombol Ini
        </button>
    </div>

</body>
</html>
