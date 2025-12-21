<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Register - Goutside</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <style>
        /* entrance */
        .fade-scale {
            opacity: 0;
            transform: scale(.96) translateY(16px);
            transition: all .6s ease;
        }
        .fade-scale.show {
            opacity: 1;
            transform: scale(1) translateY(0);
        }

        /* moving gradient text */
        .animated-gradient {
            background: linear-gradient(
                90deg,
                #10b981,
                #22d3ee,
                #10b981
            );
            background-size: 200% auto;
            -webkit-background-clip: text;
            -webkit-text-fill-color: transparent;
            animation: gradientMove 6s linear infinite;
        }

        @keyframes gradientMove {
            0% { background-position: 0% center; }
            100% { background-position: 200% center; }
        }

        /* soft glow hover */
        .soft-glow:hover {
            box-shadow:
                0 0 0 1px rgba(16,185,129,.2),
                0 18px 45px rgba(16,185,129,.25);
        }
    </style>
</head>

<body class="bg-white text-gray-900 antialiased">

@include('partial.navbar')

<main class="min-h-[calc(100vh-4rem)] flex items-center justify-center px-4">

    <div class="fade-scale max-w-md w-full
        bg-white border border-gray-200
        rounded-3xl shadow-xl
        p-8 soft-glow transition">

        {{-- HEADER --}}
        <div class="text-center mb-8">
            <span class="inline-block mb-3 px-4 py-1 rounded-full
                bg-emerald-50 text-emerald-700
                text-xs tracking-widest uppercase animated-gradient">
                Goutside
            </span>

            <h1 class="text-3xl font-bold mb-2 animated-gradient">
                Buat Akun Baru
            </h1>

            <p class="text-sm text-gray-500">
                Daftar sekarang untuk mulai menyewa perlengkapan hiking
            </p>
        </div>

        {{-- ERROR --}}
        @if ($errors->any())
            <div class="bg-red-100 text-red-700
                px-4 py-2 rounded-xl mb-5 text-sm">
                <ul class="list-disc list-inside">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        {{-- FORM --}}
        <form action="{{ route('register.post') }}" method="POST" class="space-y-5">
            @csrf

            {{-- NAMA --}}
            <div>
                <label class="block text-xs text-gray-600 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}"
                    required
                    class="w-full rounded-xl px-4 py-3 border border-gray-300
                    focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
            </div>

            {{-- EMAIL --}}
            <div>
                <label class="block text-xs text-gray-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}"
                    required
                    class="w-full rounded-xl px-4 py-3 border border-gray-300
                    focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
            </div>

            {{-- PASSWORD --}}
            <div class="relative">
                <label class="block text-xs text-gray-600 mb-1">Password</label>
                <input type="password" name="password" id="password"
                    required
                    class="w-full rounded-xl px-4 py-3 pr-12 border border-gray-300
                    focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                <button type="button" id="togglePassword"
                    class="absolute right-4 top-[38px] text-gray-400 hover:text-gray-700 transition text-sm">
                    show
                </button>
            </div>

            {{-- KONFIRMASI PASSWORD --}}
            <div class="relative">
                <label class="block text-xs text-gray-600 mb-1">Konfirmasi Password</label>
                <input type="password" name="password_confirmation" id="password_confirmation"
                    required
                    class="w-full rounded-xl px-4 py-3 pr-12 border border-gray-300
                    focus:outline-none focus:ring-2 focus:ring-emerald-500 transition">
                <button type="button" id="toggleConfirmPassword"
                    class="absolute right-4 top-[38px] text-gray-400 hover:text-gray-700 transition text-sm">
                    show
                </button>
            </div>

            {{-- BUTTON --}}
            <button type="submit"
                class="w-full py-3 rounded-full
                bg-emerald-600 text-white
                font-semibold
                hover:bg-emerald-700 transition">
                Daftar
            </button>
        </form>

        {{-- FOOTER --}}
        <p class="mt-6 text-center text-sm text-gray-600">
            Sudah punya akun?
            <a href="{{ route('login') }}"
               class="text-emerald-600 hover:underline">
                Masuk
            </a>
        </p>
    </div>
</main>

<script>
document.addEventListener('DOMContentLoaded', () => {
    setTimeout(() => {
        document.querySelector('.fade-scale')?.classList.add('show');
    }, 120);

    const togglePassword = document.getElementById('togglePassword');
    const passwordInput = document.getElementById('password');

    togglePassword.addEventListener('click', () => {
        passwordInput.type = passwordInput.type === 'password' ? 'text' : 'password';
        togglePassword.textContent = passwordInput.type === 'password' ? 'show' : 'hide';
    });

    const toggleConfirmPassword = document.getElementById('toggleConfirmPassword');
    const confirmInput = document.getElementById('password_confirmation');

    toggleConfirmPassword.addEventListener('click', () => {
        confirmInput.type = confirmInput.type === 'password' ? 'text' : 'password';
        toggleConfirmPassword.textContent = confirmInput.type === 'password' ? 'show' : 'hide';
    });
});
</script>

</body>
</html>
