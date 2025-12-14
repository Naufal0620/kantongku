<nav class="fixed w-full z-50 bg-white/90 dark:bg-dark-card/90 backdrop-blur-md border-b border-gray-100 dark:border-gray-700 transition-colors">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex justify-between items-center h-16">
            <a href="<?= base_url(); ?>" class="flex items-center gap-2 hover:opacity-80 transition">
                <div class="w-8 h-8 bg-green-500 rounded-lg flex items-center justify-center text-white">
                    <i class="fas fa-wallet"></i>
                </div>
                <span class="font-bold text-xl text-gray-800 dark:text-white tracking-tight">KantongKu Docs</span>
            </a>
            <div class="flex items-center gap-4">
                <a href="<?= base_url(); ?>" class="text-sm font-medium text-gray-500 hover:text-green-600 transition hidden md:block">
                    Kembali ke Home
                </a>
                <?php if($is_login): ?>
                    <a href="<?= base_url('dashboard'); ?>" class="bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100 px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-200 dark:hover:bg-green-600 transition">
                        Buka Aplikasi
                    </a>
                <?php else: ?>
                    <a href="<?= base_url('auth'); ?>" class="bg-green-100 text-green-700 dark:bg-green-700 dark:text-green-100 px-4 py-2 rounded-lg text-sm font-bold hover:bg-green-200 dark:hover:bg-green-600 transition">
                        Masuk
                    </a>
                <?php endif; ?>
            </div>
        </div>
    </div>
</nav>

<div class="min-h-screen pt-16 bg-gray-50 dark:bg-dark-bg transition-colors flex flex-col md:flex-row max-w-7xl mx-auto">
    
    <aside class="w-full md:w-64 bg-white dark:bg-dark-card border-b md:border-b-0 md:border-r border-gray-200 dark:border-gray-700 md:h-[calc(100vh-4rem)] md:sticky md:top-16 overflow-y-auto z-40">
        <div class="p-6">
            <h3 class="text-xs font-bold text-gray-400 uppercase tracking-wider mb-4">Daftar Isi</h3>
            <nav class="space-y-1">
                <button onclick="switchGuide('mulai')" id="nav-mulai" class="nav-item w-full text-left px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition bg-green-50 text-green-700 dark:bg-gray-700 dark:text-green-400">
                    <i class="fas fa-flag w-5"></i> Mulai Menggunakan
                </button>
                <button onclick="switchGuide('dashboard')" id="nav-dashboard" class="nav-item w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2 transition">
                    <i class="fas fa-chart-line w-5"></i> Memahami Dashboard
                </button>
                <button onclick="switchGuide('kategori')" id="nav-kategori" class="nav-item w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2 transition">
                    <i class="fas fa-tags w-5"></i> Manajemen Kategori
                </button>
                <button onclick="switchGuide('akun')" id="nav-akun" class="nav-item w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2 transition">
                    <i class="fas fa-user-shield w-5"></i> Akun & Keamanan
                </button>
            </nav>
        </div>
    </aside>

    <main class="flex-1 p-6 md:p-12 overflow-y-auto">
        
        <div id="content-mulai" class="guide-section animate-fade-in">
            <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Mulai Menggunakan</h1>
                <p class="text-gray-600 dark:text-gray-400 text-lg">Langkah awal perjalanan hematmu bersama KantongKu.</p>
            </div>

            <div class="mb-10">
                <div class="bg-black rounded-2xl overflow-hidden shadow-lg border-4 border-white dark:border-gray-600 relative aspect-video w-full max-w-3xl mx-auto">
                    <iframe 
                        class="w-full h-full absolute inset-0" 
                        src="https://www.youtube.com/embed/aDjbZ5uEiG0" 
                        title="Panduan KantongKu" 
                        frameborder="0" 
                        allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture; web-share" 
                        allowfullscreen>
                    </iframe>
                </div>
                <p class="text-center text-sm text-gray-500 dark:text-gray-400 mt-3 italic">
                    <i class="fas fa-video text-red-500 mr-1"></i> Tonton video singkat pengenalan aplikasi di atas.
                </p>
            </div>

            <div class="prose dark:prose-invert max-w-none space-y-8">
                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-green-100 dark:bg-green-900/50 rounded-full flex items-center justify-center text-green-600 dark:text-green-400 font-bold">1</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Pendaftaran Akun Baru</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed mb-4">
                            Untuk menjaga privasi data keuanganmu, kamu wajib memiliki akun.
                            Klik tombol <b>Daftar Gratis</b> di halaman depan, lalu isi Nama Lengkap, Email, dan Password yang kuat.
                        </p>
                        <div class="bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400 p-4 rounded-r-lg">
                            <p class="text-sm text-yellow-700 dark:text-yellow-400">
                                <b>Penting:</b> Pastikan email kamu aktif agar jika lupa password, kamu bisa memulihkannya (Fitur mendatang).
                            </p>
                        </div>
                    </div>
                </div>

                <div class="flex gap-4">
                    <div class="flex-shrink-0 w-10 h-10 bg-blue-100 dark:bg-blue-900/50 rounded-full flex items-center justify-center text-blue-600 dark:text-blue-400 font-bold">2</div>
                    <div>
                        <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-2">Masuk ke Aplikasi</h3>
                        <p class="text-gray-600 dark:text-gray-400 leading-relaxed">
                            Setelah mendaftar, gunakan email dan password yang telah didaftarkan untuk masuk. 
                            Jika berhasil, kamu akan langsung diarahkan ke halaman <b>Dashboard</b>.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div id="content-dashboard" class="guide-section hidden animate-fade-in">
            <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Memahami Dashboard</h1>
                <p class="text-gray-600 dark:text-gray-400 text-lg">Pusat kendali keuanganmu ada di sini.</p>
            </div>

            <div class="space-y-10">
                <div class="grid grid-cols-1 md:grid-cols-2 gap-6">
                    <div class="bg-white dark:bg-dark-card p-5 rounded-xl border border-gray-200 dark:border-gray-700">
                        <i class="fas fa-wallet text-2xl text-green-500 mb-3"></i>
                        <h4 class="font-bold text-gray-800 dark:text-white mb-2">Ringkasan Saldo</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Menampilkan sisa uangmu saat ini (Pemasukan - Pengeluaran).</p>
                    </div>
                    <div class="bg-white dark:bg-dark-card p-5 rounded-xl border border-gray-200 dark:border-gray-700">
                        <i class="fas fa-brain text-2xl text-blue-500 mb-3"></i>
                        <h4 class="font-bold text-gray-800 dark:text-white mb-2">Analisis Cerdas</h4>
                        <p class="text-sm text-gray-500 dark:text-gray-400">Kalkulasi sederhana yang menghitung "Burn Rate" atau berapa lama uangmu akan bertahan.</p>
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-calendar-alt text-gray-400"></i> Kalender Keuangan
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-4">
                        Kalender ini unik. Tanggal akan berwarna <b class="text-green-600">Hijau</b> jika pemasukan > pengeluaran, dan <b class="text-red-500">Merah</b> jika kamu boros di hari itu.
                        Klik tanggal manapun untuk melihat rincian transaksi di hari tersebut.
                    </p>
                    <div class="bg-gray-100 dark:bg-gray-800 p-4 rounded-lg text-sm text-gray-600 dark:text-gray-400 italic border-l-4 border-gray-400">
                        "Grafik di bawah kalender akan menyesuaikan dengan bulan yang kamu pilih di kalender."
                    </div>
                </div>

                <div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-plus-circle text-green-500"></i> Mencatat Transaksi
                    </h3>
                    <ul class="list-disc list-inside space-y-2 text-gray-600 dark:text-gray-400">
                        <li>Klik tombol <b>(+)</b> melayang di pojok kanan bawah.</li>
                        <li>Pilih jenis: <b>Pemasukan</b> atau <b>Pengeluaran</b>.</li>
                        <li>Isi nominal (Maksimal Rp 100 Juta per transaksi).</li>
                        <li>Pilih kategori yang sesuai.</li>
                        <li>Tambahkan catatan opsional agar tidak lupa.</li>
                    </ul>
                </div>

                <div>
                    <h3 class="text-xl font-bold text-gray-800 dark:text-white mb-4 flex items-center gap-2">
                        <i class="fas fa-edit text-blue-500"></i> Mengedit & Menghapus Transaksi
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 mb-3">
                        Salah input nominal atau ingin membatalkan transaksi? Tenang, bisa diedit kok.
                    </p>
                    <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 p-5">
                        <ul class="space-y-4 text-gray-600 dark:text-gray-400">
                            <li class="flex items-start gap-3">
                                <i class="fas fa-mouse-pointer mt-1 text-green-500"></i>
                                <span><b>Pilih Transaksi:</b> Klik pada item transaksi yang salah di daftar riwayat (di bawah kalender atau daftar "Transaksi Hari Ini").</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-pen mt-1 text-blue-500"></i>
                                <span><b>Edit Data:</b> Jendela popup akan muncul. Ubah nominal, tanggal, atau catatan sesuai keinginan, lalu tekan tombol <b>Update</b>.</span>
                            </li>
                            <li class="flex items-start gap-3">
                                <i class="fas fa-trash mt-1 text-red-500"></i>
                                <span><b>Hapus Permanen:</b> Jika ingin menghapus, tekan tombol <b>Ikon Sampah Merah</b> yang ada di pojok kiri bawah jendela popup tersebut.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </div>

        <div id="content-kategori" class="guide-section hidden animate-fade-in">
            <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Manajemen Kategori</h1>
                <p class="text-gray-600 dark:text-gray-400 text-lg">Kelompokkan uangmu agar rapi dan terstruktur.</p>
            </div>

            <div class="space-y-8">
                <p class="text-gray-600 dark:text-gray-400">
                    Bawaan aplikasi sudah menyediakan kategori standar seperti Makan, Transport, dan Gaji. 
                    Namun, kamu bisa mengubahnya sesuka hati di menu <b>Kategori</b>.
                </p>

                <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-800 dark:text-white mb-2">Cara Menambah Kategori Baru</h4>
                        <ol class="list-decimal list-inside space-y-2 text-gray-600 dark:text-gray-400">
                            <li>Buka menu <b>Kategori</b> di sidebar.</li>
                            <li>Klik tombol <b>Tambah</b> di pojok kanan atas.</li>
                            <li>Pilih jenis (Pemasukan/Pengeluaran).</li>
                            <li>Beri nama (Contoh: "Skin Care" atau "Topup Game").</li>
                            <li>Pilih <b>Ikon</b> yang lucu dan <b>Warna</b> yang sesuai.</li>
                            <li>Simpan!</li>
                        </ol>
                    </div>
                    <div class="p-6 bg-gray-50 dark:bg-gray-800/50">
                        <h4 class="font-bold text-gray-800 dark:text-white mb-2">Tips Pro:</h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400">
                            Gunakan warna <span class="text-red-500 font-bold">Merah</span> untuk kategori pengeluaran yang harus diwaspadai (seperti Jajan), 
                            dan warna <span class="text-blue-500 font-bold">Biru</span> untuk kebutuhan pokok.
                        </p>
                    </div>
                </div>

                <div class="bg-white dark:bg-dark-card rounded-xl shadow-sm border border-gray-200 dark:border-gray-700 overflow-hidden">
                    <div class="p-6 border-b border-gray-100 dark:border-gray-700">
                        <h4 class="font-bold text-gray-800 dark:text-white mb-2 flex items-center gap-2">
                            <i class="fas fa-cog text-gray-400"></i> Mengedit & Menghapus Kategori
                        </h4>
                        <p class="text-sm text-gray-600 dark:text-gray-400 mb-4">
                            Kamu bisa mengubah nama, ikon, atau warna kategori kapan saja.
                        </p>
                        <ol class="list-decimal list-inside space-y-3 text-gray-600 dark:text-gray-400">
                            <li>Klik langsung pada <b>Kartu Kategori</b> yang ingin diubah.</li>
                            <li>Jendela edit akan terbuka (sama seperti saat menambah baru).</li>
                            <li>Lakukan perubahan yang diperlukan, lalu klik <b>Simpan</b>.</li>
                            <li>Untuk <b>Menghapus</b>, klik tombol <span class="text-red-500 font-bold bg-red-50 dark:bg-red-900/30 px-2 py-0.5 rounded text-xs"><i class="fas fa-trash"></i> Sampah Merah</span> di sebelah tombol Batal.</li>
                        </ol>
                    </div>
                    <div class="p-4 bg-yellow-50 dark:bg-yellow-900/20 border-l-4 border-yellow-400">
                        <p class="text-xs text-yellow-800 dark:text-yellow-200 font-bold">
                            <i class="fas fa-exclamation-triangle mr-1"></i> Catatan Penting:
                        </p>
                        <p class="text-xs text-yellow-700 dark:text-yellow-300 mt-1">
                            Menghapus kategori tidak akan menghapus transaksi yang sudah ada, namun transaksi tersebut mungkin akan kehilangan label kategorinya. Hapuslah dengan bijak.
                        </p>
                    </div>
                </div>
            </div>
        </div>

        <div id="content-akun" class="guide-section hidden animate-fade-in">
            <div class="mb-6 pb-6 border-b border-gray-200 dark:border-gray-700">
                <h1 class="text-3xl font-bold text-gray-900 dark:text-white mb-2">Akun & Keamanan</h1>
                <p class="text-gray-600 dark:text-gray-400 text-lg">Kelola privasi dan kenyamanan penggunaan aplikasi.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-3">
                        <i class="fas fa-user-circle text-gray-400 mr-2"></i> Foto Profil Unik
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-4">
                        KantongKu menggunakan avatar kartun yang unik. Kamu bisa mengganti avatarmu dengan menekan tombol 
                        <b>"Ganti Foto (Acak)"</b> di halaman profil. Terus klik sampai nemu yang mirip kamu!
                    </p>
                </div>

                <div>
                    <h3 class="text-lg font-bold text-gray-800 dark:text-white mb-3">
                        <i class="fas fa-key text-gray-400 mr-2"></i> Ganti Password
                    </h3>
                    <p class="text-gray-600 dark:text-gray-400 text-sm leading-relaxed mb-4">
                        Merasa passwordmu diketahui teman kos? Segera ganti di halaman Profil. 
                        Pastikan menggunakan kombinasi huruf dan angka agar aman.
                    </p>
                </div>

                <div class="md:col-span-2 bg-gray-900 border border-gray-200 dark:border-gray-700 text-white p-6 rounded-xl relative overflow-hidden">
                    <div class="relative z-10">
                        <h3 class="text-lg font-bold mb-2"><i class="fas fa-moon text-yellow-400 mr-2"></i> Mode Gelap (Dark Mode)</h3>
                        <p class="text-gray-300 text-sm">
                            Suka begadang ngurus keuangan? KantongKu otomatis mengikuti pengaturan tema di HP/Laptop kamu. 
                            Atau kamu bisa mengaktifkannya manual lewat menu Pengaturan.
                        </p>
                    </div>
                    <div class="absolute right-0 bottom-0 opacity-10 transform translate-x-10 translate-y-10">
                        <i class="fas fa-moon text-9xl"></i>
                    </div>
                </div>
            </div>
        </div>

    </main>
</div>

<script>
    function switchGuide(id) {
        // 1. Sembunyikan semua konten
        document.querySelectorAll('.guide-section').forEach(el => {
            el.classList.add('hidden');
        });

        // 2. Reset semua style tombol nav (Inactive State)
        document.querySelectorAll('.nav-item').forEach(btn => {
            btn.className = "nav-item w-full text-left px-3 py-2 rounded-lg text-sm font-medium text-gray-600 dark:text-gray-400 hover:bg-gray-50 dark:hover:bg-gray-700 flex items-center gap-2 transition";
        });

        // 3. Tampilkan konten yang dipilih
        document.getElementById('content-' + id).classList.remove('hidden');

        // 4. Highlight tombol nav yang aktif (Active State)
        const activeBtn = document.getElementById('nav-' + id);
        activeBtn.className = "nav-item w-full text-left px-3 py-2 rounded-lg text-sm font-medium flex items-center gap-2 transition bg-green-50 text-green-700 dark:bg-gray-700 dark:text-green-400 font-bold shadow-sm";
        
        // Scroll to top mobile
        if(window.innerWidth < 768) {
            window.scrollTo({ top: 0, behavior: 'smooth' });
        }
    }
</script>