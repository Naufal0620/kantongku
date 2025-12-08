<div class="max-w-lg mx-auto bg-white dark:bg-dark-card rounded-2xl shadow-sm p-8 transition-colors animate-fade-in mt-10 md:mt-0">
    
    <h2 class="text-xl font-bold mb-6 text-center text-gray-800 dark:text-white">Profil Saya</h2>

    <?php if($this->session->flashdata('pesan')): ?>
        <?= $this->session->flashdata('pesan'); ?>
    <?php endif; ?>

    <?= form_open_multipart('profile/update', ['class' => 'space-y-4', 'onsubmit' => 'showLoading()']); ?>
        
        <div class="flex flex-col items-center mb-8">
            <div class="relative group">
                <img id="avatarPreview" src="<?= $avatar_url; ?>" class="w-28 h-28 mb-3 rounded-full border-4 border-green-50 shadow-md object-cover transition transform hover:scale-105">
                
                <div onclick="triggerFileUpload()" class="absolute inset-0 w-28 h-28 rounded-full bg-black bg-opacity-30 opacity-0 group-hover:opacity-100 flex items-center justify-center cursor-pointer transition text-white font-bold text-xs mb-3">
                    <i class="fas fa-camera mr-1"></i> Ubah
                </div>
            </div>
            
            <div class="flex gap-4 text-sm mt-2">
                <button type="button" onclick="triggerFileUpload()" class="text-blue-600 hover:text-blue-700 font-semibold focus:outline-none">
                    <i class="fas fa-upload mr-1"></i> Upload Foto
                </button>
                
                <span class="text-gray-300">|</span>

                <button type="button" onclick="randomizeAvatar()" class="text-green-600 hover:text-green-700 font-semibold focus:outline-none">
                    <i class="fas fa-dice mr-1"></i> Acak Kartun
                </button>
            </div>

            <input type="file" name="image" id="fileInput" class="hidden" accept="image/*" onchange="previewUploadedFile(event)">
            
            <input type="hidden" name="avatar_seed" id="inputAvatarSeed" value="<?= $is_custom ? 'Felix' : $user['avatar']; ?>">
            
            <input type="hidden" name="avatar_mode" id="avatarMode" value="keep">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Lengkap</label>
            <input type="text" name="name" value="<?= html_escape($user['name']); ?>" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-gray-50 dark:bg-dark-input dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 transition" required maxlength="100">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Password Baru</label>
            <input type="password" name="password" placeholder="Kosongkan jika tidak ingin mengubah" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-gray-50 dark:bg-dark-input dark:text-white focus:outline-none focus:ring-2 focus:ring-green-500 transition" maxlength="255">
        </div>

        <div>
            <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Email</label>
            <input type="text" value="<?= html_escape($user['email']); ?>" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 bg-gray-200 dark:bg-gray-800 text-gray-500 cursor-not-allowed" readonly>
        </div>

        <button type="submit" class="w-full bg-green-500 hover:bg-green-600 text-white font-bold py-3 rounded-xl shadow-md transition transform hover:scale-[1.02]">
            Simpan Perubahan
        </button>
    <?= form_close(); ?>

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