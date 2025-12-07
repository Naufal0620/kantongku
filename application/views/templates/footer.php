</main> </div> <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

<?php if (isset($js) && !empty($js)): ?>
    <?php foreach ($js as $script): ?>
        <script src="<?= base_url($script) . "?v=" . time(); ?>"></script>
    <?php endforeach; ?>
<?php endif; ?>

<div id="globalLoader" class="fixed inset-0 bg-black bg-opacity-50 z-[9999] hidden flex items-center justify-center backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white dark:bg-dark-card p-6 rounded-2xl shadow-2xl flex flex-col items-center transform scale-100 animate-fade-in">
        <svg class="animate-spin h-10 w-10 text-green-600 mb-3" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
            <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
            <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
        </svg>
        <span class="text-gray-700 dark:text-gray-200 font-semibold text-sm">Memproses...</span>
    </div>
</div>

<script>
    // Fungsi Global untuk Memunculkan Loading
    function showLoading() {
        const loader = document.getElementById('globalLoader');
        loader.classList.remove('hidden');
    }

    // Fungsi Global untuk Menyembunyikan Loading (Opsional, jika validasi JS gagal)
    function hideLoading() {
        const loader = document.getElementById('globalLoader');
        loader.classList.add('hidden');
    }

    // LISTENER GLOBAL UNTUK FORM
    // Setiap kali ada form yang disubmit, loading akan muncul otomatis
    document.addEventListener('submit', function(e) {
        // Cek apakah form tersebut valid (jika pakai required html5)
        if (e.target.checkValidity()) {
            showLoading();
        }
    });

    // Script Hapus Global (dari langkah sebelumnya) - UPDATE tambah showLoading()
    $(document).on('click', '.btn-hapus', function(e) {
        e.preventDefault(); 
        const href = $(this).attr('href'); 

        Swal.fire({
            title: 'Yakin hapus data ini?',
            text: "Data transaksi akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading(); // <--- TAMBAHKAN INI
                document.location.href = href; 
            }
        });
    });
</script>

</body>
</html>