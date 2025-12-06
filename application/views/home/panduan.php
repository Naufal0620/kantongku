<nav class="fixed w-full z-50 bg-white/80 dark:bg-dark-card/80 backdrop-blur-md border-b border-gray-100 dark:border-gray-700 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="<?= base_url(); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center text-white">
                    <i class="fas fa-wallet"></i>
                </div>
                <span class="font-bold text-xl text-gray-800 dark:text-white tracking-tight">KantongKu</span>
            </a>
            <a href="<?= base_url(); ?>" class="text-sm font-bold text-gray-500 hover:text-green-600 transition">
                <i class="fas fa-arrow-left mr-1"></i> Kembali ke Home
            </a>
        </div>
    </div>
</nav>

<div class="min-h-screen pt-24 pb-20 bg-gray-50 dark:bg-dark-bg transition-colors">
    <div class="max-w-4xl mx-auto px-4 sm:px-6">
        
        <div class="text-center mb-16 animate-fade-in">
            <h1 class="text-3xl md:text-4xl font-bold text-gray-900 dark:text-white mb-4">Panduan Penggunaan</h1>
            <p class="text-gray-500 dark:text-gray-400 text-lg">Ikuti langkah mudah ini untuk mulai mengelola keuanganmu.</p>
        </div>

        <div class="relative border-l-4 border-green-200 dark:border-gray-700 ml-4 md:ml-10 space-y-12">
            
            <div class="relative pl-8 md:pl-12 group animate-fade-in">
                <div class="absolute -left-[14px] top-0 w-6 h-6 bg-green-500 rounded-full border-4 border-white dark:border-dark-bg shadow-md group-hover:scale-125 transition"></div>
                
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">1. Pendaftaran Akun</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                    Sebelum mulai, kamu perlu mendaftar terlebih dahulu. Klik tombol <b>Daftar Gratis</b> di halaman depan, isi Nama, Email, dan Password. Tenang, data kamu aman!
                </p>
                <div class="bg-white dark:bg-dark-card p-4 rounded-xl border border-gray-200 dark:border-gray-700 shadow-sm inline-block">
                    <span class="text-xs font-mono text-gray-500 dark:text-gray-400 block mb-2">Tips:</span>
                    <div class="flex items-center gap-2 text-sm text-green-600 dark:text-green-400 font-medium">
                        <i class="fas fa-check-circle"></i> Gunakan email yang aktif.
                    </div>
                </div>
            </div>

            <div class="relative pl-8 md:pl-12 group animate-fade-in" style="animation-delay: 0.1s">
                <div class="absolute -left-[14px] top-0 w-6 h-6 bg-white dark:bg-dark-card border-4 border-green-500 rounded-full shadow-md group-hover:bg-green-500 transition"></div>
                
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">2. Mengatur Kategori</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                    Masuk ke menu <b>Kategori</b>. Di sini kamu bisa membuat pos-pos keuangan. 
                    Pisahkan antara <i>Pemasukan</i> (Gaji, Kiriman Ortu) dan <i>Pengeluaran</i> (Makan, Transport, Laundry).
                </p>
                <div class="grid grid-cols-2 gap-3 max-w-sm">
                    <div class="flex items-center gap-2 p-2 bg-red-50 text-red-600 rounded-lg text-xs font-bold border border-red-100">
                        <i class="fas fa-utensils"></i> Makan
                    </div>
                    <div class="flex items-center gap-2 p-2 bg-blue-50 text-blue-600 rounded-lg text-xs font-bold border border-blue-100">
                        <i class="fas fa-bus"></i> Transport
                    </div>
                </div>
            </div>

            <div class="relative pl-8 md:pl-12 group animate-fade-in" style="animation-delay: 0.2s">
                <div class="absolute -left-[14px] top-0 w-6 h-6 bg-white dark:bg-dark-card border-4 border-green-500 rounded-full shadow-md group-hover:bg-green-500 transition"></div>
                
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">3. Mencatat Transaksi</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                    Setiap kali kamu mengeluarkan uang, klik tombol <b>(+)</b> besar di Dashboard. 
                    Pilih kategori, masukkan nominal, dan simpan. Jangan menunda mencatat agar laporanmu akurat!
                </p>
            </div>

            <div class="relative pl-8 md:pl-12 group animate-fade-in" style="animation-delay: 0.3s">
                <div class="absolute -left-[14px] top-0 w-6 h-6 bg-white dark:bg-dark-card border-4 border-green-500 rounded-full shadow-md group-hover:bg-green-500 transition"></div>
                
                <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">4. Pantau & Analisis</h3>
                <p class="text-gray-600 dark:text-gray-400 mb-4 leading-relaxed">
                    Di halaman <b>Dashboard</b>, kamu bisa melihat grafik perbandingan pemasukan vs pengeluaran.
                    Cek juga fitur <i>Analisis Cerdas</i> untuk mengetahui berapa lama sisa saldomu akan bertahan.
                </p>
                <div class="p-4 bg-blue-50 dark:bg-blue-900/20 rounded-xl border border-blue-100 dark:border-blue-800">
                    <p class="text-sm text-blue-800 dark:text-blue-300">
                        <i class="fas fa-info-circle mr-1"></i> <b>Fitur Unik:</b> Jika indikator berubah merah, artinya pengeluaranmu lebih besar dari pendapatanmu!
                    </p>
                </div>
            </div>

        </div>

        <div class="mt-20 text-center animate-fade-in">
            <h2 class="text-2xl font-bold text-gray-800 dark:text-white mb-4">Siap menjadi lebih hemat?</h2>
            <a href="<?= base_url('auth/registration'); ?>" class="inline-block px-8 py-4 bg-green-600 text-white rounded-xl font-bold text-lg hover:bg-green-700 transition shadow-xl hover:-translate-y-1">
                Buat Akun Sekarang
            </a>
        </div>

    </div>
</div>