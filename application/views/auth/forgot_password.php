<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lupa Password - KantongKu</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: { bg: '#111827', card: '#1F2937', text: '#F3F4F6', input: '#374151' }
                    }
                }
            }
        }
    </script>
    <script>
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-dark-bg flex items-center px-4 justify-center h-screen transition-colors duration-300">

    <a href="<?= base_url('auth'); ?>" class="absolute top-6 left-6 text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400 transition flex items-center gap-2 font-medium text-sm">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Login</span>
    </a>

    <div class="bg-white dark:bg-dark-card p-8 rounded-2xl shadow-xl w-full max-w-md transition-colors duration-300 border border-transparent dark:border-gray-700">
        <div class="text-center mb-6">
            <i class="fas fa-lock text-4xl text-green-500 mb-2"></i>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">Lupa Password?</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Masukkan email Anda untuk mereset password.</p>
        </div>

        <?= $this->session->flashdata('message'); ?>

        <form action="<?= base_url('auth/forgotpassword'); ?>" method="post">
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email Terdaftar</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 dark:bg-dark-input dark:border-gray-600 dark:text-white" placeholder="user@kantongku.com" required>
                <?= form_error('email', '<small class="text-red-500 pl-1">', '</small>'); ?>
            </div>
            
            <button type="submit" class="w-full bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition shadow-lg">
                Kirim Link Reset
            </button>
        </form>
    </div>
</body>
</html>