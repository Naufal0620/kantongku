<aside class="desktop-sidebar hidden md:flex fixed w-64 h-full bg-white dark:bg-dark-card shadow-lg z-10 flex-col transition-colors duration-300">
    <div class="p-6 flex items-center gap-3 border-b dark:border-gray-700">
        <i class="fas fa-wallet text-2xl text-green-500"></i>
        <h1 class="text-xl font-bold dark:text-white">KantongKu</h1>
    </div>
    <nav class="flex-1 p-4 space-y-2">
        <?php $isActive = ($this->uri->segment(1) == 'dashboard'); ?>
        <a href="<?= site_url('dashboard') ?>" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition <?= $isActive ? 'bg-green-50 text-green-600 dark:bg-gray-700 font-bold' : 'text-gray-600 dark:text-gray-400 hover:bg-green-50 dark:hover:bg-gray-700 font-medium' ?>">
            <i class="fas fa-home w-6"></i> Dashboard
        </a>
        <?php $isActive = ($this->uri->segment(1) == 'kategori'); ?>
        <a href="<?= site_url('kategori') ?>" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition <?= $isActive ? 'bg-green-50 text-green-600 dark:bg-gray-700 font-bold' : 'text-gray-600 dark:text-gray-400 hover:bg-green-50 dark:hover:bg-gray-700 font-medium' ?>">
            <i class="fas fa-tags w-6"></i> Kategori
        </a>
        <?php $isActive = ($this->uri->segment(1) == 'profile'); ?>
        <a href="<?= site_url('profile') ?>" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition <?= $isActive ? 'bg-green-50 text-green-600 dark:bg-gray-700 font-bold' : 'text-gray-600 dark:text-gray-400 hover:bg-green-50 dark:hover:bg-gray-700 font-medium' ?>">
            <i class="fas fa-user w-6"></i> Profil
        </a>
        <?php $isActive = ($this->uri->segment(1) == 'pengaturan'); ?>
        <a href="<?= site_url('pengaturan') ?>" class="w-full text-left px-4 py-3 rounded-lg flex items-center gap-3 transition <?= $isActive ? 'bg-green-50 text-green-600 dark:bg-gray-700 font-bold' : 'text-gray-600 dark:text-gray-400 hover:bg-green-50 dark:hover:bg-gray-700 font-medium' ?>">
            <i class="fas fa-cog w-6"></i> Pengaturan
        </a>
        <a href="<?= base_url('home/panduan'); ?>" class="w-full text-left px-4 py-3 rounded-lg hover:bg-green-50 dark:hover:bg-gray-700 text-gray-600 dark:text-gray-400 hover:text-green-600 dark:hover:text-green-400 font-medium flex items-center gap-3 transition">
            <i class="fas fa-book-open w-6"></i> Panduan
        </a>
    </nav>
</aside>

<nav class="md:hidden fixed bottom-0 left-0 w-full bg-white dark:bg-dark-card border-t dark:border-gray-700 py-2 px-0 z-40 grid grid-cols-4 transition-colors">
    <?php $isActive = ($this->uri->segment(1) == 'dashboard'); ?>
    <a href="<?= site_url('dashboard') ?>" class="flex flex-col items-center justify-center w-full <?= $isActive ? 'text-green-600' : 'text-gray-400' ?>"><i class="fas fa-home text-xl mb-1"></i><span class="text-[10px]">Home</span></a>
    <?php $isActive = ($this->uri->segment(1) == 'kategori'); ?>
    <a href="<?= site_url('kategori') ?>" class="flex flex-col items-center justify-center w-full <?= $isActive ? 'text-green-600' : 'text-gray-400' ?>"><i class="fas fa-tags text-xl mb-1"></i><span class="text-[10px]">Kategori</span></a>
    <?php $isActive = ($this->uri->segment(1) == 'profile'); ?>
    <a href="<?= site_url('profile') ?>" class="flex flex-col items-center justify-center w-full <?= $isActive ? 'text-green-600' : 'text-gray-400' ?>"><i class="fas fa-user text-xl mb-1"></i><span class="text-[10px]">Profil</span></a>    
    <?php $isActive = ($this->uri->segment(1) == 'pengaturan'); ?>
    <a href="<?= site_url('pengaturan') ?>" class="flex flex-col items-center justify-center w-full <?= $isActive ? 'text-green-600' : 'text-gray-400' ?>"><i class="fas fa-cog text-xl mb-1"></i><span class="text-[10px]">Pengaturan</span></a>    
</nav>

<main class="main-content md:ml-64 p-4 md:p-8 mb-20 md:mb-0">