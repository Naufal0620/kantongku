<nav class="fixed w-full z-50 bg-white/80 dark:bg-dark-card/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-700 transition-colors duration-300">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            
            <div class="flex items-center gap-2">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center text-white">
                    <i class="fas fa-wallet"></i>
                </div>
                <span class="font-bold text-xl text-gray-800 dark:text-white tracking-tight">KantongKu</span>
            </div>

            <div class="flex items-center gap-4">
                
                <button id="themeToggleBtn" class="p-2 rounded-full bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-yellow-400 hover:bg-gray-200 dark:hover:bg-gray-600 transition focus:outline-none">
                    <i class="fas fa-moon block dark:hidden"></i>
                    <i class="fas fa-sun hidden dark:block"></i>
                </button>

                <div class="hidden md:flex items-center space-x-6">
                    <a href="#fitur" class="text-gray-600 dark:text-gray-300 hover:text-green-600 font-medium transition">Fitur</a>
                    <a href="<?= base_url('home/panduan'); ?>" class="text-gray-600 dark:text-gray-300 hover:text-green-600 font-medium transition">Panduan</a>
                    
                    <?php if($is_login): ?>
                        <a href="<?= base_url('dashboard'); ?>" class="bg-green-600 text-white px-5 py-2 rounded-full font-bold hover:bg-green-700 transition shadow-lg shadow-green-500/30">
                            Dashboard
                        </a>
                    <?php else: ?>
                        <a href="<?= base_url('auth'); ?>" class="text-gray-800 dark:text-white font-bold hover:text-green-600 transition">Masuk</a>
                        <a href="<?= base_url('auth/registration'); ?>" class="bg-green-600 text-white px-5 py-2 rounded-full font-bold hover:bg-green-700 transition shadow-lg shadow-green-500/30">
                            Daftar Gratis
                        </a>
                    <?php endif; ?>
                </div>

                </div>
        </div>
    </div>
</nav>

<script>
    const themeToggleBtn = document.getElementById('themeToggleBtn');
    const htmlRoot = document.documentElement;

    themeToggleBtn.addEventListener('click', function() {
        if (htmlRoot.classList.contains('dark')) {
            // Switch to Light
            htmlRoot.classList.remove('dark');
            localStorage.theme = 'light';
        } else {
            // Switch to Dark
            htmlRoot.classList.add('dark');
            localStorage.theme = 'dark';
        }
    });
</script>

<section class="relative pt-32 pb-20 lg:pt-40 lg:pb-28 overflow-hidden">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 text-center relative z-10">
        <span class="inline-block py-1 px-3 rounded-full bg-green-50 dark:bg-green-900/30 text-green-600 dark:text-green-400 text-sm font-bold mb-6 animate-fade-in">
            🚀 Kelola Keuangan Tanpa Pusing
        </span>
        <h1 class="text-4xl md:text-6xl font-extrabold text-gray-900 dark:text-white mb-6 leading-tight animate-fade-in">
            Atur Uang Kosan,<br>
            <span class="text-transparent bg-clip-text bg-gradient-to-r from-green-500 to-teal-400">Wujudkan Impian.</span>
        </h1>
        <p class="text-lg text-gray-600 dark:text-gray-400 mb-10 max-w-2xl mx-auto animate-fade-in">
            Aplikasi pencatat keuangan simpel untuk mahasiswa dan anak kos. Pantau pengeluaran harian, atur budget, dan hindari makan promag di akhir bulan.
        </p>
        <div class="flex flex-col sm:flex-row justify-center gap-4 animate-fade-in">
            <a href="<?= base_url('auth/registration'); ?>" class="px-8 py-4 bg-green-600 text-white rounded-xl font-bold text-lg hover:bg-green-700 transition shadow-xl hover:-translate-y-1">
                Mulai Sekarang
            </a>
            <a href="<?= base_url('home/panduan'); ?>" class="px-8 py-4 bg-white dark:bg-dark-card text-gray-700 dark:text-white border border-gray-200 dark:border-gray-600 rounded-xl font-bold text-lg hover:bg-gray-50 dark:hover:bg-gray-700 transition flex items-center justify-center gap-2">
                <i class="fas fa-book-open"></i> Pelajari Cara Pakai
            </a>
        </div>
    </div>
    
    <div class="absolute top-0 left-0 w-72 h-72 bg-green-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob"></div>
    <div class="absolute top-0 right-0 w-72 h-72 bg-teal-300 rounded-full mix-blend-multiply filter blur-3xl opacity-20 animate-blob animation-delay-2000"></div>
</section>

<section id="fitur" class="py-20 bg-gray-50 dark:bg-dark-bg/50 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="text-center mb-16">
            <h2 class="text-3xl font-bold text-gray-800 dark:text-white mb-4">Fitur Unggulan</h2>
            <p class="text-gray-500 dark:text-gray-400">Semua yang kamu butuhkan untuk jadi lebih hemat.</p>
        </div>
        
        <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
            <div class="bg-white dark:bg-dark-card p-8 rounded-2xl shadow-sm hover:shadow-xl transition border border-gray-100 dark:border-gray-700 group">
                <div class="w-14 h-14 bg-green-100 dark:bg-green-900/30 rounded-xl flex items-center justify-center text-green-600 dark:text-green-400 text-2xl mb-6 group-hover:scale-110 transition">
                    <i class="fas fa-receipt"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-3">Catat Transaksi</h3>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                    Input pemasukan dan pengeluaran dalam hitungan detik. Kategori bisa disesuaikan sesuka hati.
                </p>
            </div>

            <div class="bg-white dark:bg-dark-card p-8 rounded-2xl shadow-sm hover:shadow-xl transition border border-gray-100 dark:border-gray-700 group">
                <div class="w-14 h-14 bg-blue-100 dark:bg-blue-900/30 rounded-xl flex items-center justify-center text-blue-600 dark:text-blue-400 text-2xl mb-6 group-hover:scale-110 transition">
                    <i class="fas fa-chart-pie"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-3">Analisis Visual</h3>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                    Lihat kemana uangmu pergi lewat grafik yang mudah dipahami. Pantau boros atau hematnya kamu.
                </p>
            </div>

            <div class="bg-white dark:bg-dark-card p-8 rounded-2xl shadow-sm hover:shadow-xl transition border border-gray-100 dark:border-gray-700 group">
                <div class="w-14 h-14 bg-purple-100 dark:bg-purple-900/30 rounded-xl flex items-center justify-center text-purple-600 dark:text-purple-400 text-2xl mb-6 group-hover:scale-110 transition">
                    <i class="fas fa-bullseye"></i>
                </div>
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-3">Prediksi Saldo</h3>
                <p class="text-gray-500 dark:text-gray-400 leading-relaxed">
                    Fitur pintar yang menghitung berapa lama uangmu akan bertahan berdasarkan kebiasaan jajanmu.
                </p>
            </div>
        </div>
    </div>
</section>

<footer class="bg-white dark:bg-dark-card py-10 border-t border-gray-100 dark:border-gray-700">
    <div class="max-w-7xl mx-auto px-4 text-center">
        <p class="text-gray-500 dark:text-gray-400">
            &copy; <?= date('Y'); ?> <span class="font-bold text-green-600">KantongKu</span>. Dibuat dengan ❤️ untuk anak kos.
        </p>
    </div>
</footer>

<style>
    /* Custom Animation for Blobs */
    @keyframes blob {
        0% { transform: translate(0px, 0px) scale(1); }
        33% { transform: translate(30px, -50px) scale(1.1); }
        66% { transform: translate(-20px, 20px) scale(0.9); }
        100% { transform: translate(0px, 0px) scale(1); }
    }
    .animate-blob { animation: blob 7s infinite; }
    .animation-delay-2000 { animation-delay: 2s; }
</style>