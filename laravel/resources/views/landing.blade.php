<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Goutside - Sewa Perlengkapan Hiking</title>

    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <link href="https://unpkg.com/aos@2.3.1/dist/aos.css" rel="stylesheet">
</head>

<body class="bg-gradient-to-b from-slate-50 via-white to-slate-100
text-gray-900 flex flex-col min-h-screen overflow-x-hidden">

<main class="flex-grow">

@include('partial.navbar')

<!-- HERO CINEMATIC -->
<section class="relative h-[75vh] overflow-hidden">

    <!-- Atmospheric Particles -->
    <div id="particles-js" class="absolute inset-0 z-0"></div>

    <!-- Background Image -->
    <img
        id="hero-bg"
        src="https://images.unsplash.com/photo-1500530855697-b586d89ba3ee?auto=format&fit=crop&w=1920&q=80"
        class="absolute inset-0 w-full h-full object-cover scale-110 hero-motion"
        alt="Mountain"
    >

    <!-- Cinematic Color Grade -->
    <div class="absolute inset-0 bg-gradient-to-b
        from-slate-900/50 via-slate-900/40 to-slate-900/80"></div>

    <!-- Vignette -->
    <div class="absolute inset-0
        bg-[radial-gradient(circle_at_center,transparent_40%,rgba(0,0,0,0.55))]">
    </div>

    <!-- Light Leak -->
    <div class="absolute -top-24 -left-24 w-96 h-96
        bg-emerald-400/10 rounded-full blur-[120px]">
    </div>

    <!-- Content -->
    <div class="relative z-10 h-full flex items-center">
        <div class="max-w-6xl mx-auto px-6 text-white">

            <span class="inline-block mb-4 px-4 py-1 rounded-full
            bg-white/10 backdrop-blur-md text-xs tracking-widest uppercase glow-badge">
                Outdoor Rental Platform
            </span>


            <h1 class="text-3xl md:text-5xl lg:text-6xl font-bold mb-6 leading-tight">
                Persiapkan Pendakian
                <br class="hidden md:block">
                <span class="bg-gradient-to-r from-emerald-400 to-cyan-300
                bg-clip-text text-transparent text-flow">
                    Tanpa Ribet
                </span>
            </h1>

            <p class="max-w-xl text-gray-200 mb-10 leading-relaxed">
                Rasakan pengalaman menyewa perlengkapan hiking
                dengan kualitas terbaik, siap pakai, dan terawat
                untuk setiap perjalananmu.
            </p>

            <div class="flex gap-4">
                <a href="{{ route('katalog.index') }}"
                   class="btn-primary">
                    Lihat Katalog
                </a>
                <a href="{{ route('reservasi.index') ?? '#' }}"
                   class="btn-outline">
                    Buat Reservasi
                </a>
            </div>

        </div>
    </div>

</section>

<!-- KEUNGGULAN CINEMATIC -->
<section class="relative py-20
bg-gradient-to-b from-slate-50 via-white to-slate-100 overflow-hidden">

    <!-- Ambient Glow -->
    <div class="absolute -top-32 right-0 w-[500px] h-[500px]
    bg-emerald-300/15 rounded-full blur-[160px]"></div>

    <div class="absolute bottom-0 -left-32 w-[500px] h-[500px]
    bg-cyan-300/10 rounded-full blur-[160px]"></div>

    <div class="max-w-6xl mx-auto px-4 relative z-10">
        <h2 class="text-2xl font-bold text-center mb-12">
            Kenapa sewa di Goutside?
        </h2>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="glass-card bg-white/70 backdrop-blur-lg
            border border-white/40 shadow-xl">
                <h3 class="font-semibold mb-2">Peralatan Terawat</h3>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Setiap perlengkapan diperiksa dan dirawat
                    agar selalu siap menemani petualanganmu.
                </p>
            </div>

            <div class="glass-card bg-white/70 backdrop-blur-lg
            border border-white/40 shadow-xl">
                <h3 class="font-semibold mb-2">Harga Bersahabat</h3>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Solusi hemat tanpa mengorbankan kualitas
                    dan kenyamanan.
                </p>
            </div>

            <div class="glass-card bg-white/70 backdrop-blur-lg
            border border-white/40 shadow-xl">
                <h3 class="font-semibold mb-2">Booking Online</h3>
                <p class="text-sm text-gray-700 leading-relaxed">
                    Pesan kapan saja tanpa ribet,
                    langsung siap berangkat.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- WAVE DIVIDER -->
<svg viewBox="0 0 1440 90" class="w-full block">
    <path fill="rgba(248,250,252,0.75)"
    d="M0,40L60,48C120,56,240,72,360,69.3C480,67,600,45,720,34.7C840,24,960,24,1080,32C1200,40,1320,56,1380,64L1440,72L1440,0L0,0Z">
    </path>
</svg>

<!-- CTA CINEMATIC -->
<section class="relative py-20
bg-gradient-to-br from-emerald-700 via-emerald-600 to-cyan-700
text-white text-center overflow-hidden">

    <div class="absolute inset-0
    bg-[radial-gradient(circle_at_center,transparent_30%,rgba(0,0,0,0.4))]">
    </div>

    <h2 class="relative z-10 text-3xl font-bold mb-4">
        Siap Memulai Petualangan?
    </h2>

    <p class="relative z-10 mb-8 text-white/90">
        Lengkapi perjalananmu dengan perlengkapan terbaik.
    </p>

    <a href="{{ route('katalog.index') }}"
       class="relative z-10 inline-block
   border border-white/40
   bg-white/90 text-emerald-700
   px-7 py-3 rounded-full font-semibold
   btn-cinematic">
        Mulai Sewa
    </a>
</section>

</main>

<footer class="py-6 bg-gradient-to-t from-gray-900 to-slate-800">
    <div class="text-center text-gray-400 text-sm">
        &copy; {{ date('Y') }} Goutside. All rights reserved.
    </div>
</footer>

<!-- Scripts -->
<script src="https://unpkg.com/aos@2.3.1/dist/aos.js"></script>
<script>
AOS.init({ duration: 900, once: true });
</script>

<script src="https://cdn.jsdelivr.net/npm/particles.js@2.0.0/particles.min.js"></script>

<script>
    
particlesJS("particles-js", {
  particles: {
    number: { value: 22 },
    color: { value: "#ffffff" },
    opacity: { value: 0.12 },
    size: { value: 2 },
    move: { speed: 0.45 }
  }
});
</script>

<script>
window.addEventListener('scroll', () => {
  const bg = document.getElementById('hero-bg');
  if (bg) {
    bg.style.transform =
      `translateY(${window.scrollY * 0.08}px)`;
  }
});
</script>


</body>
</html>
