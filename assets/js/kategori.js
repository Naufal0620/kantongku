/**
 * Script Khusus Halaman Kategori
 * Menangani Tabs, Modal, dan Pilihan Ikon FontAwesome
 */

// --- KONFIGURASI IKON (FontAwesome 6 Free) ---
const availableIcons = [
    // Makanan & Minuman
    'utensils', 'burger', 'pizza-slice', 'mug-hot', 'bowl-food',
    // Transportasi
    'car', 'motorcycle', 'bus', 'train', 'gas-pump',
    // Rumah & Tagihan
    'house', 'bed', 'bolt', 'faucet', 'wifi', 'phone',
    // Belanja
    'cart-shopping', 'bag-shopping', 'shirt', 'basket-shopping',
    // Pendidikan & Kantor
    'graduation-cap', 'book', 'briefcase', 'school',
    // Hiburan & Hobi
    'gamepad', 'film', 'music', 'plane',
    // Kesehatan
    'notes-medical', 'pills', 'heart-pulse',
    // Keuangan (Pemasukan)
    'wallet', 'money-bill-wave', 'piggy-bank', 'sack-dollar',
    // Lainnya
    'gift', 'envelope', 'circle', 'star'
];

// --- FUNGSI UTAMA ---

// 1. Render Grid Ikon
function renderIconGrid() {
    const container = document.getElementById('iconGridContainer');
    if (!container) return; // Guard clause jika elemen tidak ada
    
    container.innerHTML = ''; 

    availableIcons.forEach(icon => {
        const div = document.createElement('div');
        div.className = "flex items-center justify-center p-2 rounded-lg cursor-pointer hover:bg-green-50 dark:hover:bg-gray-600 hover:text-green-600 dark:hover:text-green-400 transition border border-transparent hover:border-green-200 aspect-square";
        div.onclick = function() { selectIcon(icon); };
        div.innerHTML = `<i class="fas fa-${icon} text-lg"></i>`;
        container.appendChild(div);
    });
}

// 2. Toggle Dropdown
function toggleIconDropdown() {
    const dropdown = document.getElementById('iconDropdownList');
    dropdown.classList.toggle('hidden');
}

// 3. Pilih Ikon
function selectIcon(iconName) {
    document.getElementById('inputIcon').value = iconName;
    document.getElementById('previewIcon').className = `fas fa-${iconName}`;
    
    // Format teks (misal: "money-bill-wave" -> "Money Bill Wave")
    let displayText = iconName.replace(/-/g, ' ').replace(/\b\w/g, l => l.toUpperCase());
    document.getElementById('previewText').innerText = displayText;

    document.getElementById('iconDropdownList').classList.add('hidden');
}

// 4. Switch Tabs (Pemasukan/Pengeluaran)
function switchCategoryTab(type) {
    const items = document.querySelectorAll('.category-item');
    const btnExp = document.getElementById('tab-expense');
    const btnInc = document.getElementById('tab-income');

    if (type === 'expense') {
        btnExp.className = "flex-1 py-2 text-center rounded-lg font-bold text-sm bg-red-50 text-red-500 shadow-sm transition-all";
        btnInc.className = "flex-1 py-2 text-center rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all";
    } else {
        btnExp.className = "flex-1 py-2 text-center rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all";
        btnInc.className = "flex-1 py-2 text-center rounded-lg font-bold text-sm bg-green-50 text-green-500 shadow-sm transition-all";
    }

    items.forEach(item => {
        if (item.getAttribute('data-type') === type) {
            item.classList.remove('hidden'); item.classList.add('flex');
        } else {
            item.classList.add('hidden'); item.classList.remove('flex');
        }
    });
}

// 5. Buka Modal Tambah
function openCategoryModal() {
    const modal = document.getElementById('categoryModal');
    modal.classList.remove('hidden');
    
    document.getElementById('catModalTitle').innerText = "Tambah Kategori";
    // Menggunakan variabel global PAGE_URLS yang didefinisikan di View
    document.getElementById('formCategory').action = PAGE_URLS.tambah;
    
    // Reset Form
    document.getElementById('inputId').value = "";
    document.getElementById('inputName').value = "";
    document.getElementById('btnDelete').classList.add('hidden');
    document.getElementById('radioExpense').checked = true;

    selectIcon('circle');
}

// 6. Buka Modal Edit
function editCategory(element) {
    const id = element.getAttribute('data-id');
    const name = element.getAttribute('data-name');
    const type = element.getAttribute('data-type');
    const icon = element.getAttribute('data-icon').replace('fa-', '');
    const color = element.getAttribute('data-color');

    document.getElementById('categoryModal').classList.remove('hidden');
    document.getElementById('catModalTitle').innerText = "Edit Kategori";
    // Menggunakan variabel global PAGE_URLS
    document.getElementById('formCategory').action = PAGE_URLS.edit + id;

    document.getElementById('inputId').value = id;
    document.getElementById('inputName').value = name;
    document.getElementById('inputColor').value = color;

    selectIcon(icon);

    if(type === 'expense') document.getElementById('radioExpense').checked = true;
    else document.getElementById('radioIncome').checked = true;

    // Set Link Hapus & Logic SweetAlert
    const btnDelete = document.getElementById('btnDelete');
    btnDelete.classList.remove('hidden');
    const deleteUrl = PAGE_URLS.hapus + id; // Menggunakan variable global dari View
    btnDelete.href = deleteUrl;

    btnDelete.onclick = function(event) {
        event.preventDefault(); 
        
        Swal.fire({
            title: 'Hapus Kategori?',
            text: "Data ini tidak bisa dikembalikan!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444', 
            cancelButtonColor: '#6B7280',  
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                window.location.href = deleteUrl; 
            }
        });
    };
}

// 7. Tutup Modal
function closeModal() {
    document.getElementById('categoryModal').classList.add('hidden');
    document.getElementById('iconDropdownList').classList.add('hidden'); 
}

// --- EVENT LISTENERS ---

// Tutup modal/dropdown jika klik di luar
window.onclick = function(event) {
    const modal = document.getElementById('categoryModal');
    const dropdown = document.getElementById('iconDropdownList');
    const trigger = document.getElementById('iconTriggerBtn');

    if (event.target == modal) {
        closeModal();
    }
    
    if (dropdown && !dropdown.contains(event.target) && trigger && !trigger.contains(event.target)) {
        dropdown.classList.add('hidden');
    }
}

// Jalankan saat load
document.addEventListener("DOMContentLoaded", function() {
    switchCategoryTab('expense');
    renderIconGrid();
});