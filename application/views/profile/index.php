<div class="max-w-lg mx-auto bg-white dark:bg-dark-card rounded-2xl shadow-sm p-8 transition-colors animate-fade-in mt-10 md:mt-0">
    
    <h2 class="text-xl font-bold mb-6 text-center text-gray-800 dark:text-white">Profil Saya</h2>

    <?php if($this->session->flashdata('pesan')): ?>
        <?= $this->session->flashdata('pesan'); ?>
    <?php endif; ?>

    <form action="<?= base_url('profile/update'); ?>" method="post" class="space-y-4">
        
        <div class="flex flex-col items-center mb-8">
            <img id="avatarPreview" src="https://api.dicebear.com/7.x/avataaars/svg?seed=<?= $user['avatar']; ?>" class="w-24 h-24 mb-3 rounded-full border-4 border-green-50 shadow-md transition transform hover:scale-105">
            
            <button type="button" onclick="randomizeAvatar()" class="text-sm text-green-600 font-semibold cursor-pointer hover:text-green-700 focus:outline-none">
                <i class="fas fa-sync-alt mr-1"></i> Ganti Foto (Acak)
            </button>

            <input type="hidden" name="avatar" id="inputAvatar" value="<?= $user['avatar']; ?>">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="<?= $user['name']; ?>" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-gray-50 dark:bg-dark-input dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 transition" required>
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Password Baru</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-gray-50 dark:bg-dark-input dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 transition">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
            <input type="text" value="<?= $user['email']; ?>" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-gray-200 dark:bg-gray-800 text-gray-500 cursor-not-allowed" readonly>
        </div>

        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-md transition transform hover:scale-[1.02]">
            Simpan Perubahan
        </button>
    </form>

    <div class="border-t border-gray-100 dark:border-gray-700 my-6"></div>

    <button onclick="confirmLogout()" class="w-full bg-red-50 hover:bg-red-100 text-red-500 dark:bg-gray-700 dark:hover:bg-gray-600 dark:text-red-400 font-bold py-3 rounded-xl flex items-center justify-center gap-2 transition">
        <i class="fas fa-sign-out-alt"></i> Keluar Aplikasi
    </button>
</div>

<script>
    const PROFILE_URLS = {
        logout: "<?= base_url('profile/logout'); ?>"
    };
</script>