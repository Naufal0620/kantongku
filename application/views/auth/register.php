<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
    <style>@import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap'); body { font-family: 'Inter', sans-serif; }</style>
    
    <script>const BASE_URL = "<?= base_url(); ?>";</script>
</head>
<body class="bg-gray-50 flex items-center justify-center h-screen">

    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-md">
        <div class="text-center mb-6">
            <i class="fas fa-user-plus text-4xl text-green-500 mb-2"></i>
            <h1 class="text-2xl font-bold text-gray-800">Daftar Akun</h1>
            <p class="text-gray-500 text-sm">Bergabunglah dengan KantongKu.</p>
        </div>

        <form id="formRegister">
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Nama Lengkap</label>
                <input type="text" name="name" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="Anak Kos Sejati" required>
            </div>
            <div class="mb-4">
                <label class="block text-gray-700 text-sm font-bold mb-2">Email</label>
                <input type="email" name="email" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="user@kantongku.com" required>
            </div>
            <div class="mb-6">
                <label class="block text-gray-700 text-sm font-bold mb-2">Password</label>
                <input type="password" name="password" class="w-full px-4 py-2 border rounded-lg focus:outline-none focus:ring-2 focus:ring-green-400" placeholder="********" required>
            </div>
            
            <button type="submit" id="btnRegister" class="w-full bg-green-500 text-white font-bold py-3 rounded-lg hover:bg-green-600 transition shadow-lg flex justify-center items-center gap-2">
                Daftar Sekarang
            </button>
        </form>

        <div class="text-center mt-4">
            <a href="<?= base_url('auth'); ?>" class="text-sm text-green-600 hover:underline">Sudah punya akun? Login</a>
        </div>
    </div>

    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    
    <?php if (isset($js) && !empty($js)): ?>
        <?php foreach ($js as $script): ?>
            <script src="<?= base_url($script); ?>"></script>
        <?php endforeach; ?>
    <?php endif; ?>
</body>
</html>