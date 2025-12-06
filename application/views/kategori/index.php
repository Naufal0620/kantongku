<div class="flex justify-between items-center mb-6 animate-fade-in">
    <div>
        <h2 class="text-2xl font-bold text-gray-800 dark:text-white">Atur Kategori</h2>
        <p class="text-sm text-gray-500 dark:text-gray-400">Kelola pos pemasukan dan pengeluaranmu.</p>
    </div>
    <button onclick="openCategoryModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition shadow-lg flex items-center">
        <i class="fas fa-plus mr-2"></i> Tambah
    </button>
</div>

<?php if($this->session->flashdata('pesan')): ?>
    <div class="animate-fade-in mb-6">
        <?= $this->session->flashdata('pesan'); ?>
    </div>
<?php endif; ?>

<div class="bg-white dark:bg-dark-card rounded-xl p-1 flex mb-6 shadow-sm border border-gray-100 dark:border-gray-700 animate-fade-in transition-colors">
    <button onclick="switchCategoryTab('expense')" id="tab-expense" class="flex-1 py-2 text-center rounded-lg font-bold text-sm bg-red-50 text-red-500 shadow-sm transition-all">
        Pengeluaran
    </button>
    <button onclick="switchCategoryTab('income')" id="tab-income" class="flex-1 py-2 text-center rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all">
        Pemasukan
    </button>
</div>

<p class="text-xs text-gray-400 mb-4 italic animate-fade-in">*Klik kartu kategori untuk mengedit atau menghapus</p>

<div id="categoryGrid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 animate-fade-in pb-20 md:pb-0">
    <?php if(empty($kategori)): ?>
        <div class="col-span-full text-center py-10 text-gray-400 italic">
            Belum ada kategori. Silakan tambah baru.
        </div>
    <?php else: ?>
        <?php foreach($kategori as $k): ?>
            <div 
                class="category-item group bg-white dark:bg-dark-card border border-gray-100 dark:border-gray-700 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer hover:shadow-md transition transform hover:scale-105"
                data-type="<?= $k['type']; ?>"
                data-id="<?= $k['id']; ?>"
                data-name="<?= $k['name']; ?>"
                data-icon="<?= $k['icon']; ?>"
                data-color="<?= $k['color']; ?>"
                onclick="editCategory(this)"
            >
                <div class="w-12 h-12 rounded-full <?= $k['color']; ?> flex items-center justify-center mb-2 transition group-hover:bg-opacity-80">
                    <i class="fas fa-<?= $k['icon']; ?> text-lg"></i>
                </div>
                <span class="text-xs font-semibold text-gray-600 dark:text-gray-300 group-hover:text-gray-800 dark:group-hover:text-white text-center">
                    <?= $k['name']; ?>
                </span>
            </div>
        <?php endforeach; ?>
    <?php endif; ?>
</div>

<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex items-center justify-center backdrop-blur-sm px-4 transition-opacity duration-300">
    <div class="bg-white dark:bg-dark-card w-full max-w-sm rounded-2xl p-6 shadow-2xl transform scale-100 transition-transform duration-300" onclick="event.stopPropagation()">
        
        <h3 class="font-bold text-lg mb-4 text-gray-800 dark:text-white" id="catModalTitle">Tambah Kategori</h3>
        
        <form action="<?= base_url('kategori/tambah'); ?>" method="post" id="formCategory">
            <input type="hidden" name="id" id="inputId">

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jenis Transaksi</label>
                <div class="flex gap-2">
                    <label class="flex-1 flex items-center justify-center gap-2 border dark:border-gray-600 px-3 py-2 rounded-lg cursor-pointer hover:bg-red-50 dark:hover:bg-gray-700 has-[:checked]:border-red-500 has-[:checked]:bg-red-50 dark:has-[:checked]:bg-gray-700 transition">
                        <input type="radio" name="type" id="radioExpense" value="expense" checked class="hidden">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300"><i class="fas fa-arrow-up text-red-500 mr-1"></i> Pengeluaran</span>
                    </label>
                    <label class="flex-1 flex items-center justify-center gap-2 border dark:border-gray-600 px-3 py-2 rounded-lg cursor-pointer hover:bg-green-50 dark:hover:bg-gray-700 has-[:checked]:border-green-500 has-[:checked]:bg-green-50 dark:has-[:checked]:bg-gray-700 transition">
                        <input type="radio" name="type" id="radioIncome" value="income" class="hidden">
                        <span class="text-sm font-medium text-gray-600 dark:text-gray-300"><i class="fas fa-arrow-down text-green-500 mr-1"></i> Pemasukan</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Kategori</label>
                <input type="text" name="name" id="inputName" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 dark:bg-dark-input dark:text-white transition" placeholder="Contoh: Belanja Bulanan" required>
            </div>

            <div class="mb-4 relative">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Pilih Ikon</label>
                
                <input type="hidden" name="icon" id="inputIcon" value="circle">

                <button type="button" onclick="toggleIconDropdown()" id="iconTriggerBtn" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 flex items-center justify-between bg-white dark:bg-dark-input dark:text-white hover:bg-gray-50 dark:hover:bg-gray-700 transition">
                    <div class="flex items-center gap-3">
                        <div class="w-8 h-8 rounded-full bg-gray-100 dark:bg-gray-600 flex items-center justify-center text-gray-600 dark:text-white">
                            <i id="previewIcon" class="fas fa-circle"></i>
                        </div>
                        <span id="previewText" class="text-sm">Default (Circle)</span>
                    </div>
                    <i class="fas fa-chevron-down text-gray-400 text-xs"></i>
                </button>

                <div id="iconDropdownList" class="hidden absolute z-20 mt-1 w-full bg-white dark:bg-dark-card border border-gray-200 dark:border-gray-600 rounded-xl shadow-xl p-3 animate-fade-in max-h-48 overflow-y-auto">
                    <p class="text-[10px] text-gray-400 mb-2 uppercase font-bold tracking-wider">Ikon Tersedia</p>
                    <div class="grid grid-cols-5 gap-2" id="iconGridContainer">
                        </div>
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Warna Tema</label>
                <select name="color" id="inputColor" class="w-full border border-gray-300 dark:border-gray-600 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-dark-input dark:text-white">
                    <option value="bg-gray-100 text-gray-600">Abu-abu (Default)</option>
                    <option value="bg-orange-100 text-orange-600">Orange</option>
                    <option value="bg-blue-100 text-blue-600">Biru</option>
                    <option value="bg-indigo-100 text-indigo-600">Indigo</option>
                    <option value="bg-pink-100 text-pink-600">Pink</option>
                    <option value="bg-purple-100 text-purple-600">Ungu</option>
                    <option value="bg-yellow-100 text-yellow-600">Kuning</option>
                    <option value="bg-green-100 text-green-600">Hijau</option>
                    <option value="bg-teal-100 text-teal-600">Teal</option>
                    <option value="bg-red-100 text-red-600">Merah</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 py-2 bg-gray-100 dark:bg-gray-700 text-gray-600 dark:text-gray-300 font-medium rounded-lg hover:bg-gray-200 dark:hover:bg-gray-600 transition">Batal</button>
                <a id="btnDelete" href="#" class="hidden py-2 px-4 bg-red-100 text-red-500 rounded-lg hover:bg-red-200 transition flex items-center justify-center">
                    <i class="fas fa-trash"></i>
                </a>
                <button type="submit" class="flex-1 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition shadow-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    const PAGE_URLS = {
        tambah: "<?= base_url('kategori/tambah'); ?>",
        edit: "<?= base_url('kategori/edit/'); ?>",
        hapus: "<?= base_url('kategori/hapus/'); ?>"
    };
</script>