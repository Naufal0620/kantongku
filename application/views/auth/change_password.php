<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ubah Password - KantongKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: { extend: { colors: { dark: { bg: '#111827', card: '#1F2937', text: '#F3F4F6', input: '#374151' } } } }
        }
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-dark-bg flex items-center px-4 justify-center h-screen transition-colors duration-300">

    <div class="bg-white dark:bg-dark-card p-8 rounded-2xl shadow-xl w-full max-w-md transition-colors duration-300 border border-transparent dark:border-gray-700">
        <div class="text-center mb-6">
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Reset Password</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Buat password baru untuk akun: <br><b><?= $this->session->userdata('reset_email'); ?></b></p>
        </div>

        <?= $this->session->flashdata('message'); ?>

        <form action="<?= base_url('auth/changepassword'); ?>" method="post">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password Baru</label>
                <input type="password" name="password1" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 dark:bg-dark-input dark:border-gray-600 dark:text-white" placeholder="********" required>
                <?= form_error('password1', '<small class="text-red-500 pl-1">', '</small>'); ?>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Ulangi Password</label>
                <input type="password" name="password2" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 dark:bg-dark-input dark:border-gray-600 dark:text-white" placeholder="********" required>
            </div>
            
            <button type="submit" class="w-full bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition shadow-lg">
                Ubah Password
            </button>
        </form>
    </div>
</body>
</html>