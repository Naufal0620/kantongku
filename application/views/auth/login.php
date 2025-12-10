<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url("assets/img/favicon.png") ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
    
    <script>
        tailwind.config = {
            darkMode: 'class', // Wajib agar class="dark" di html terbaca
            theme: {
                extend: {
                    colors: {
                        dark: { 
                            bg: '#111827',     
                            card: '#1F2937',   
                            text: '#F3F4F6',   
                            muted: '#9CA3AF',  
                            input: '#374151'   
                        }
                    }
                }
            }
        }
    </script>

    <style>
        /* =========================================
        CUSTOM DARK MODE UNTUK SWEETALERT 2
        ========================================= */

        .dark .swal2-popup {
            background-color: #1f2937 !important; /* dark:bg-gray-800 */
            color: #f3f4f6 !important; /* dark:text-gray-100 */
            border: 1px solid #374151; /* dark:border-gray-700 */
        }
        
        .dark .swal2-title {
            color: #f3f4f6 !important;
        }
        
        .dark .swal2-html-container {
            color: #d1d5db !important; /* dark:text-gray-300 */
        }
        
        /* Ubah warna tombol Cancel agar tidak terlalu terang di dark mode */
        .dark .swal2-cancel {
            background-color: #374151 !important; /* dark:bg-gray-700 */
            color: #d1d5db !important;
        }
    </style>

    <script>
        const BASE_URL = "<?= base_url(); ?>";
        // Cek Dark Mode saat load (agar tidak flash putih)
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
<body class="bg-gray-50 dark:bg-dark-bg flex items-center px-4 justify-center h-screen transition-colors duration-300">

    <a href="<?= base_url(); ?>" class="absolute top-6 left-6 text-gray-500 hover:text-green-600 dark:text-gray-400 dark:hover:text-green-400 transition flex items-center gap-2 font-medium text-sm">
        <i class="fas fa-arrow-left"></i>
        <span>Kembali ke Home</span>
    </a>

    <div class="bg-white dark:bg-dark-card p-8 rounded-2xl shadow-xl w-full max-w-md transition-colors duration-300 border border-transparent dark:border-gray-700">
        <div class="text-center mb-6">
            <i class="fas fa-wallet text-4xl text-green-500 mb-2"></i>
            <h1 class="text-2xl font-bold text-gray-800 dark:text-white">KantongKu</h1>
            <p class="text-gray-500 dark:text-gray-400 text-sm">Login dulu biar hemat.</p>
        </div>

        <form id="formLogin">
            <div class="mb-4">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 dark:bg-dark-input dark:border-gray-600 dark:text-white" placeholder="user@kantongku.com" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 dark:text-gray-300 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400 dark:bg-dark-input dark:border-gray-600 dark:text-white" placeholder="********" required>
            </div>
            
            <button type="submit" id="btnLogin" class="w-full bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition shadow-lg flex justify-center items-center gap-2">
                Masuk
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="<?= base_url('auth/registration'); ?>" class="text-sm text-green-600 hover:underline">Belum punya akun? Daftar</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>

    <?php if (isset($js) && !empty($js)): ?>
        <?php foreach ($js as $script): ?>
            <script src="<?= base_url($script) . "?v=" . time(); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>