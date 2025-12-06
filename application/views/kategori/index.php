<script src="https://cdn.tailwindcss.com"></script>
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">

<style>
    /* Custom Scrollbar & Animation sesuai v7.html */
    .animate-fade-in { animation: fadeIn 0.4s ease-in-out; }
    @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
</style>

<div class="container mx-auto px-4 py-8 font-sans text-gray-800">

    <div class="flex justify-between items-center mb-6 animate-fade-in">
        <h2 class="text-2xl font-bold text-gray-800">Atur Kategori</h2>
        <button onclick="openCategoryModal()" class="bg-green-600 text-white px-4 py-2 rounded-lg text-sm font-semibold hover:bg-green-700 transition shadow-lg flex items-center">
            <i class="fas fa-plus mr-2"></i> Tambah
        </button>
    </div>

    <?php if($this->session->flashdata('pesan')): ?>
        <div class="animate-fade-in mb-6">
            <?= $this->session->flashdata('pesan'); ?>
        </div>
    <?php endif; ?>

    <div class="bg-white rounded-xl p-1 flex mb-6 shadow-sm border border-gray-100 animate-fade-in">
        <button onclick="switchCategoryTab('expense')" id="tab-expense" class="flex-1 py-2 text-center rounded-lg font-bold text-sm bg-red-50 text-red-500 shadow-sm transition-all">
            Pengeluaran
        </button>
        <button onclick="switchCategoryTab('income')" id="tab-income" class="flex-1 py-2 text-center rounded-lg font-medium text-sm text-gray-500 transition-all">
            Pemasukan
        </button>
    </div>

    <p class="text-xs text-gray-400 mb-4 italic animate-fade-in">*Klik kategori untuk mengedit atau menghapus</p>

    <div id="categoryGrid" class="grid grid-cols-2 md:grid-cols-4 lg:grid-cols-5 gap-4 animate-fade-in">
        <?php foreach($kategori as $k): ?>
            <div 
                class="category-item group bg-white border border-gray-100 rounded-xl p-4 flex flex-col items-center justify-center cursor-pointer hover:shadow-md transition transform hover:scale-105"
                data-type="<?= $k['type']; ?>"
                data-id="<?= $k['id']; ?>"
                data-name="<?= $k['name']; ?>"
                data-icon="<?= $k['icon']; ?>"
                data-color="<?= $k['color']; ?>"
                onclick="editCategory(this)"
            >
                <div class="w-12 h-12 rounded-full <?= $k['color']; ?> flex items-center justify-center mb-2 transition group-hover:bg-opacity-80">
                    <i class="fas <?= $k['icon']; ?> text-lg"></i>
                </div>
                <span class="text-xs font-semibold text-gray-600 group-hover:text-gray-800"><?= $k['name']; ?></span>
            </div>
        <?php endforeach; ?>
    </div>

</div>

<div id="categoryModal" class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex items-center justify-center backdrop-blur-sm px-4 transition-opacity duration-300">
    <div class="bg-white w-full max-w-sm rounded-2xl p-6 shadow-2xl transform scale-100 transition-transform duration-300">
        
        <h3 class="font-bold text-lg mb-4 text-gray-800" id="catModalTitle">Tambah Kategori</h3>
        
        <form action="<?= base_url('kategori/simpan'); ?>" method="post" id="formCategory">
            
            <input type="hidden" name="id" id="inputId"> <div class="mb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-2">Jenis</label>
                <div class="flex gap-2">
                    <label class="flex items-center gap-2 border border-gray-200 px-3 py-2 rounded-lg cursor-pointer hover:bg-red-50 has-[:checked]:border-red-500 has-[:checked]:bg-red-50 transition">
                        <input type="radio" name="type" id="radioExpense" value="expense" checked class="accent-red-500">
                        <span class="text-sm font-medium text-gray-600">Pengeluaran</span>
                    </label>
                    <label class="flex items-center gap-2 border border-gray-200 px-3 py-2 rounded-lg cursor-pointer hover:bg-green-50 has-[:checked]:border-green-500 has-[:checked]:bg-green-50 transition">
                        <input type="radio" name="type" id="radioIncome" value="income" class="accent-green-500">
                        <span class="text-sm font-medium text-gray-600">Pemasukan</span>
                    </label>
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Nama Kategori</label>
                <input type="text" name="name" id="inputName" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 transition" placeholder="Contoh: Belanja" required>
            </div>

            <div class="mb-4">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Ikon (FontAwesome)</label>
                <div class="flex items-center border border-gray-300 rounded-lg overflow-hidden focus-within:ring-2 focus-within:ring-green-500">
                    <span class="bg-gray-100 px-3 py-2 text-gray-500 text-sm">fa-</span>
                    <input type="text" name="icon" id="inputIcon" class="w-full px-3 py-2 focus:outline-none" placeholder="utensils" value="circle">
                </div>
            </div>

            <div class="mb-6">
                <label class="block text-xs font-bold text-gray-500 uppercase mb-1">Warna Tema</label>
                <select name="color" id="inputColor" class="w-full border border-gray-300 rounded-lg px-3 py-2 focus:outline-none focus:ring-2 focus:ring-green-500 bg-white">
                    <option value="bg-gray-100 text-gray-600">Abu-abu</option>
                    <option value="bg-orange-100 text-orange-600">Orange (Makan)</option>
                    <option value="bg-blue-100 text-blue-600">Biru (Transport)</option>
                    <option value="bg-indigo-100 text-indigo-600">Indigo (Laundry)</option>
                    <option value="bg-pink-100 text-pink-600">Pink (Kos)</option>
                    <option value="bg-purple-100 text-purple-600">Ungu (Data)</option>
                    <option value="bg-yellow-100 text-yellow-600">Kuning (Jajan)</option>
                    <option value="bg-green-100 text-green-600">Hijau (Uang Masuk)</option>
                    <option value="bg-teal-100 text-teal-600">Teal (Gaji)</option>
                    <option value="bg-red-100 text-red-600">Merah (Penting)</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="button" onclick="closeModal()" class="flex-1 py-2 bg-gray-100 text-gray-600 font-medium rounded-lg hover:bg-gray-200 transition">Batal</button>
                
                <a id="btnDelete" href="#" onclick="return confirm('Yakin hapus kategori ini?')" class="hidden py-2 px-4 bg-red-100 text-red-500 rounded-lg hover:bg-red-200 transition flex items-center justify-center">
                    <i class="fas fa-trash"></i>
                </a>

                <button type="submit" class="flex-1 py-2 bg-green-600 text-white font-bold rounded-lg hover:bg-green-700 transition shadow-md">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script>
    // 1. Logic Switch Tabs (Filter Tampilan)
    function switchCategoryTab(type) {
        const items = document.querySelectorAll('.category-item');
        const btnExp = document.getElementById('tab-expense');
        const btnInc = document.getElementById('tab-income');

        // Update Button Style
        if (type === 'expense') {
            btnExp.className = "flex-1 py-2 text-center rounded-lg font-bold text-sm bg-red-50 text-red-500 shadow-sm transition-all";
            btnInc.className = "flex-1 py-2 text-center rounded-lg font-medium text-sm text-gray-500 transition-all";
        } else {
            btnExp.className = "flex-1 py-2 text-center rounded-lg font-medium text-sm text-gray-500 transition-all";
            btnInc.className = "flex-1 py-2 text-center rounded-lg font-bold text-sm bg-green-50 text-green-500 shadow-sm transition-all";
        }

        // Show/Hide Items
        items.forEach(item => {
            if (item.getAttribute('data-type') === type) {
                item.classList.remove('hidden');
                item.classList.add('flex'); // Pastikan display flex agar layout rapi
            } else {
                item.classList.add('hidden');
                item.classList.remove('flex');
            }
        });
    }

    // 2. Logic Modal Tambah/Edit
    function openCategoryModal() {
        // Reset Form untuk "Tambah Baru"
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('catModalTitle').innerText = "Tambah Kategori";
        document.getElementById('formCategory').action = "<?= base_url('kategori/tambah'); ?>";
        
        document.getElementById('inputId').value = "";
        document.getElementById('inputName').value = "";
        document.getElementById('inputIcon').value = "circle";
        document.getElementById('btnDelete').classList.add('hidden');
        
        // Default select expense
        document.getElementById('radioExpense').checked = true;
    }

    function editCategory(element) {
        // Ambil data dari atribut data-* elemen yang diklik
        const id = element.getAttribute('data-id');
        const name = element.getAttribute('data-name');
        const type = element.getAttribute('data-type');
        const icon = element.getAttribute('data-icon').replace('fa-', ''); // Hapus 'fa-' jika ada dobel
        const color = element.getAttribute('data-color');

        // Isi ke dalam Modal
        document.getElementById('categoryModal').classList.remove('hidden');
        document.getElementById('catModalTitle').innerText = "Edit Kategori";
        document.getElementById('formCategory').action = "<?= base_url('kategori/edit/'); ?>" + id; // Action update

        document.getElementById('inputId').value = id;
        document.getElementById('inputName').value = name;
        document.getElementById('inputIcon').value = icon;
        document.getElementById('inputColor').value = color;

        // Set Radio Button
        if(type === 'expense') {
            document.getElementById('radioExpense').checked = true;
        } else {
            document.getElementById('radioIncome').checked = true;
        }

        // Tampilkan tombol hapus dan set Link Hapus
        const btnDelete = document.getElementById('btnDelete');
        btnDelete.classList.remove('hidden');
        btnDelete.href = "<?= base_url('kategori/hapus/'); ?>" + id;
    }

    function closeModal() {
        document.getElementById('categoryModal').classList.add('hidden');
    }

    // Jalankan filter default saat halaman dimuat
    document.addEventListener("DOMContentLoaded", function() {
        switchCategoryTab('expense');
    });
</script>