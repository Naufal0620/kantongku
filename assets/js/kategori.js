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

const availableColors = [
    { value: "bg-gray-100 text-gray-600 dark:bg-gray-600 dark:text-gray-100", label: "Abu-abu (Default)" },
    { value: "bg-orange-100 text-orange-600 dark:bg-orange-600 dark:text-orange-100", label: "Orange" },
    { value: "bg-blue-100 text-blue-600 dark:bg-blue-600 dark:text-blue-100", label: "Biru" },
    { value: "bg-indigo-100 text-indigo-600 dark:bg-indigo-600 dark:text-indigo-100", label: "Indigo" },
    { value: "bg-pink-100 text-pink-600 dark:bg-pink-600 dark:text-pink-100", label: "Pink" },
    { value: "bg-purple-100 text-purple-600 dark:bg-purple-600 dark:text-purple-100", label: "Ungu" },
    { value: "bg-yellow-100 text-yellow-600 dark:bg-yellow-600 dark:text-yellow-100", label: "Kuning" },
    { value: "bg-green-100 text-green-600 dark:bg-green-600 dark:text-green-100", label: "Hijau" },
    { value: "bg-teal-100 text-teal-600 dark:bg-teal-600 dark:text-teal-100", label: "Teal" },
    { value: "bg-red-100 text-red-600 dark:bg-red-600 dark:text-red-100", label: "Merah" }
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

// Render List Warna
function renderColorList() {
    const container = document.getElementById('colorListContainer');
    if (!container) return;
    
    container.innerHTML = '';

    availableColors.forEach(col => {
        const div = document.createElement('div');
        // Styling baris item warna
        div.className = "flex items-center gap-3 p-2 rounded-lg cursor-pointer hover:bg-green-50 dark:hover:bg-gray-600 transition border border-transparent hover:border-green-200";
        
        div.innerHTML = `
            <div class="w-6 h-6 rounded-full ${col.value} border border-black/10"></div>
            <span class="text-sm text-gray-700 dark:text-gray-300">${col.label}</span>
        `;
        
        div.onclick = function() { selectColor(col.value, col.label); };
        container.appendChild(div);
    });
}

// Toggle Dropdown Warna
function toggleColorDropdown() {
    const dropdown = document.getElementById('colorDropdownList');
    document.getElementById('iconDropdownList').classList.add('hidden');
    dropdown.classList.toggle('hidden');
}

// Pilih Warna
function selectColor(colorValue, colorLabel) {
    if(!colorLabel) {
        const found = availableColors.find(c => c.value === colorValue);
        colorLabel = found ? found.label : "Custom Color";
    }

    document.getElementById('inputColor').value = colorValue;
    
    document.getElementById('previewColorCircle').className = `w-8 h-8 rounded-full ${colorValue} flex items-center justify-center border border-gray-200 dark:border-gray-500`;
    document.getElementById('previewColorText').innerText = colorLabel;

    document.getElementById('colorDropdownList').classList.add('hidden');
}

// Switch Tabs (Pemasukan/Pengeluaran)
function switchCategoryTab(type) {
    const items = document.querySelectorAll('.category-item');
    const btnExp = document.getElementById('tab-expense');
    const btnInc = document.getElementById('tab-income');

    if (type === 'expense') {
        btnExp.className = "flex-1 py-2 text-center rounded-lg font-bold text-sm bg-red-50 text-red-500 dark:bg-red-500 dark:text-red-50 shadow-sm transition-all";
        btnInc.className = "flex-1 py-2 text-center rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all";
    } else {
        btnExp.className = "flex-1 py-2 text-center rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all";
        btnInc.className = "flex-1 py-2 text-center rounded-lg font-bold text-sm bg-green-50 text-green-500 dark:bg-green-500 dark:text-green-50 shadow-sm transition-all";
    }

    items.forEach(item => {
        if (item.getAttribute('data-type') === type) {
            item.classList.remove('hidden'); item.classList.add('flex');
        } else {
            item.classList.add('hidden'); item.classList.remove('flex');
        }
    });
}

// Buka Modal Tambah
function openCategoryModal() {
    const modal = document.getElementById('categoryModal');
    modal.classList.remove('hidden');
    
    document.getElementById('catModalTitle').innerText = "Tambah Kategori";
    document.getElementById('formCategory').action = PAGE_URLS.tambah;
    
    document.getElementById('inputId').value = "";
    document.getElementById('inputName').value = "";
    document.getElementById('btnDelete').classList.add('hidden');
    document.getElementById('radioExpense').checked = true;
    selectColor('bg-gray-100 text-gray-600');

    selectIcon('circle');
}

// Buka Modal Edit
function editCategory(element) {
    const id = element.getAttribute('data-id');
    const name = element.getAttribute('data-name');
    const type = element.getAttribute('data-type');
    const icon = element.getAttribute('data-icon').replace('fa-', '');
    const color = element.getAttribute('data-color');

    document.getElementById('categoryModal').classList.remove('hidden');
    document.getElementById('catModalTitle').innerText = "Edit Kategori";
    document.getElementById('formCategory').action = PAGE_URLS.edit + id;

    document.getElementById('inputId').value = id;
    document.getElementById('inputName').value = name;
    document.getElementById('inputColor').value = color;

    selectIcon(icon);
    selectColor(color);

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
                setTimeout(() => {
                    window.location.href = deleteUrl;
                }, 10000);
            }
        });
    };
}

// Tutup Modal
function closeModal() {
    document.getElementById('categoryModal').classList.add('hidden');
    document.getElementById('iconDropdownList').classList.add('hidden'); 
}

// --- EVENT LISTENERS ---

// Tutup modal/dropdown jika klik di luar
window.onclick = function(event) {
    const modal = document.getElementById('categoryModal');
    const iconDropdown = document.getElementById('iconDropdownList');
    const iconTrigger = document.getElementById('iconTriggerBtn');
    const colorDropdown = document.getElementById('colorDropdownList');
    const colorTrigger = document.getElementById('colorTriggerBtn');

    if (event.target == modal) {
        closeModal();
    }

    if (colorDropdown && !colorDropdown.contains(event.target) && colorTrigger && !colorTrigger.contains(event.target)) {
        colorDropdown.classList.add('hidden');
    }
    
    if (iconDropdown && !iconDropdown.contains(event.target) && iconTrigger && !iconTrigger.contains(event.target)) {
        iconDropdown.classList.add('hidden');
    }
}

// Jalankan saat load
document.addEventListener("DOMContentLoaded", function() {
    switchCategoryTab('expense');
    renderIconGrid();
    renderColorList();
});