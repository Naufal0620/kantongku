/**
 * dashboard.js
 * Menangani logika Kalender, Grafik, dan Modal Transaksi (Add/Edit)
 */

// --- STATE VARIABLES ---
// TransactionDB sekarang dinamis (bisa berubah), jadi pakai 'let' bukan 'const' (di script PHP view tetap const, tapi di sini kita override valuenya)
// Karena JS memuat file terpisah, kita buat variable lokal untuk tracking tanggal
let activeDate = new Date(); // Menyimpan tanggal yang sedang dilihat kalendernya

document.addEventListener('DOMContentLoaded', function() {
    if (typeof transactionDB === 'undefined') return;

    initComparisonChart();
    
    // Init Kalender dengan Bulan & Tahun sekarang
    updateCalendarHeader();
    renderCalendar(); 
    
    selectDate(new Date().getDate()); // Pilih hari ini di list kanan
    calculateBurnRate();
    setModalCategoryType('expense', 'add'); 
});

// --- CALENDAR LOGIC (REVISED) ---

// 1. Fungsi Navigasi Bulan
function changeMonth(offset) {
    // Update state bulan
    activeDate.setMonth(activeDate.getMonth() + offset);
    
    updateCalendarHeader(); // Update teks "Oktober 2023"
    fetchCalendarData();    // Ambil data baru via AJAX
}

// 2. Update Judul Header
function updateCalendarHeader() {
    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    const title = `${monthNames[activeDate.getMonth()]} ${activeDate.getFullYear()}`;
    document.getElementById('calendarTitle').innerText = title;
}

// 3. Fetch Data AJAX
function fetchCalendarData() {
    const month = activeDate.getMonth() + 1; // JS Month 0-11, PHP 1-12
    const year = activeDate.getFullYear();
    const grid = document.getElementById('calendarGrid');
    
    // Tampilkan Loading di Grid
    grid.innerHTML = '<div class="col-span-7 text-center py-10 text-gray-400"><i class="fas fa-spinner fa-spin text-2xl"></i></div>';

    $.ajax({
        url: BASE_URL + 'dashboard/get_calendar_json',
        type: 'GET',
        data: { month: month, year: year },
        dataType: 'json',
        success: function(response) {
            // Update variable global transactionDB dengan data baru
            // Note: transactionDB didefinisikan di view sebagai 'const', 
            // agar bisa diubah di sini, di View PHP sebaiknya ubah 'const transactionDB' jadi 'var transactionDB' atau 'window.transactionDB'
            // Tapi untuk JS modern, kita bisa assign ulang objectnya jika structure memungkinkan atau pakai variabel lokal.
            
            // Solusi aman: Kita update isi object/array transactionDB
            // Kosongkan object lama
            for (var member in transactionDB) delete transactionDB[member];
            // Isi dengan yang baru
            Object.assign(transactionDB, response);

            renderCalendar(); // Render ulang kotak-kotak tanggal
            
            // Reset detail view ke tanggal 1 (atau kosongkan)
            selectDate(1); 
        },
        error: function() {
            alert('Gagal mengambil data kalender.');
        }
    });
}

// 4. Render Grid Kotak-Kotak
function renderCalendar() {
    const grid = document.getElementById('calendarGrid'); 
    grid.innerHTML = '';
    
    const year = activeDate.getFullYear();
    const month = activeDate.getMonth(); // 0-11
    
    // Hitung jumlah hari di bulan ini (JS Magic: tanggal 0 bulan berikutnya = hari terakhir bulan ini)
    const daysInMonth = new Date(year, month + 1, 0).getDate();
    
    // Hitung hari pertama jatuh di hari apa (0=Minggu, 1=Senin, ...)
    // Opsional: Jika ingin grid dimulai sesuai hari (misal tgl 1 hari Rabu), tambahkan spacer.
    const firstDayIndex = new Date(year, month, 1).getDay(); 
    
    // Tambahkan Spacer Kosong (Agar tgl 1 pas di harinya)
    for (let x = 0; x < firstDayIndex; x++) {
        const spacer = document.createElement('div');
        grid.appendChild(spacer);
    }

    // Loop Tanggal
    for (let i = 1; i <= daysInMonth; i++) {
        const dayDiv = document.createElement('div');
        const txs = transactionDB[i] || []; // Ambil data dari Global DB
        
        let totalInc = 0, totalExp = 0;
        txs.forEach(t => { 
            if(t.type === 'income') totalInc += parseInt(t.amount); 
            else totalExp += parseInt(t.amount); 
        });
        
        let baseClass = "calendar-day day-neutral", iconHTML = "";
        
        // Logika Warna
        if (txs.length > 0) { 
            if (totalExp > totalInc) { 
                baseClass = "calendar-day day-deficit"; 
                iconHTML = `<i class="fas fa-arrow-down absolute top-1 right-1 text-[8px]"></i>`; 
            } else { 
                baseClass = "calendar-day day-surplus"; 
                iconHTML = `<i class="fas fa-arrow-up absolute top-1 right-1 text-[8px]"></i>`; 
            } 
        }
        
        // Highlight Hari Ini (Hanya jika bulan & tahun sama dengan Real Time)
        const realToday = new Date();
        if (i === realToday.getDate() && month === realToday.getMonth() && year === realToday.getFullYear()) {
            baseClass += " border-2 border-gray-800 dark:border-gray-200";
        }

        dayDiv.className = baseClass;
        dayDiv.innerHTML = `<span class="z-0">${i}</span>${iconHTML}`;
        dayDiv.onclick = function() { 
            document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('active')); 
            dayDiv.classList.add('active'); 
            selectDate(i); 
        };
        grid.appendChild(dayDiv);
    }
}

// --- GLOBAL VARIABLES (Diambil dari View PHP) ---
// transactionDB, chartData..., categories, dll

// --- CHART & CALENDAR LOGIC ---

function initComparisonChart() {
    const ctx = document.getElementById('comparisonChart').getContext('2d');
    new Chart(ctx, {
        type: 'line',
        data: {
            labels: chartLabels,
            datasets: [
                { label: 'Masuk', data: chartDataIncome, borderColor: '#10B981', backgroundColor: 'rgba(16, 185, 129, 0.1)', fill: true, tension: 0.4 },
                { label: 'Keluar', data: chartDataExpense, borderColor: '#EF4444', backgroundColor: 'rgba(239, 68, 68, 0.1)', fill: true, tension: 0.4 }
            ]
        },
        options: { responsive: true, maintainAspectRatio: false, plugins: { legend: { display: false } }, scales: { x: { grid: { display: false, color: '#374151' }, ticks: { color: '#9CA3AF' } }, y: { display: false } } }
    });
}

// function renderCalendar() {
//     const grid = document.getElementById('calendarGrid'); 
//     grid.innerHTML = '';
//     const today = new Date().getDate();
    
//     for (let i = 1; i <= 31; i++) {
//         const dayDiv = document.createElement('div');
//         const txs = transactionDB[i] || []; 
//         let totalInc = 0, totalExp = 0;
        
//         txs.forEach(t => { 
//             if(t.type === 'income') totalInc += parseInt(t.amount); 
//             else totalExp += parseInt(t.amount); 
//         });
        
//         let baseClass = "calendar-day day-neutral", iconHTML = "";
//         if (txs.length > 0) { 
//             if (totalExp > totalInc) { 
//                 baseClass = "calendar-day day-deficit"; 
//                 iconHTML = `<i class="fas fa-arrow-down absolute top-1 right-1 text-[8px]"></i>`; 
//             } else { 
//                 baseClass = "calendar-day day-surplus"; 
//                 iconHTML = `<i class="fas fa-arrow-up absolute top-1 right-1 text-[8px]"></i>`; 
//             } 
//         }
        
//         if (i === today) baseClass += " border-2 border-gray-800 dark:border-gray-200";

//         dayDiv.className = baseClass;
//         dayDiv.innerHTML = `<span class="z-0">${i}</span>${iconHTML}`;
//         dayDiv.onclick = function() { 
//             document.querySelectorAll('.calendar-day').forEach(d => d.classList.remove('active')); 
//             dayDiv.classList.add('active'); 
//             selectDate(i); 
//         };
//         grid.appendChild(dayDiv);
//     }
// }

function selectDate(day) {
    document.getElementById('selectedDateDisplay').innerText = day;
    const txs = transactionDB[day] || [];
    let totalInc = 0, totalExp = 0;
    const listContainer = document.getElementById('transactionList');
    const todayTable = document.getElementById('todayTransactionTable');
    
    listContainer.innerHTML = '';
    
    // Reset tabel hari ini jika tanggal yang dipilih adalah hari ini
    if(day === new Date().getDate() && todayTable) todayTable.innerHTML = '';

    if (txs.length === 0) {
        listContainer.innerHTML = `<div class="text-center text-gray-300 text-xs mt-10 italic">Tidak ada transaksi</div>`;
        
        // UBAH DISINI: colspan jadi 2 (karena kolom berkurang)
        if(day === new Date().getDate() && todayTable) {
            todayTable.innerHTML = `<tr><td colspan="2" class="text-center py-4 text-gray-400 italic">Belum ada transaksi hari ini</td></tr>`;
        }
    } else {
        txs.forEach(t => {
            const amt = parseInt(t.amount);
            if(t.type === 'income') totalInc += amt; else totalExp += amt;
            const amountClass = t.type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400';
            const sign = t.type === 'income' ? '+' : '-';
            
            // HTML Item List (Kanan Kalender)
            const txString = JSON.stringify(t).replace(/'/g, "&#39;");
            
            let rawNoteList = t.note ? t.note : t.cat_name;

            const itemHTML = `
                <div onclick='openEditModal(${txString})' class="cursor-pointer group flex items-center justify-between p-3 border border-gray-100 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-white dark:hover:bg-gray-600 hover:border-green-400 transition shadow-sm hover:shadow-md">
                    
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        
                        <div class="w-8 h-8 rounded-full ${t.color} flex-shrink-0 flex items-center justify-center text-xs">
                            <i class="fas ${t.icon}"></i>
                        </div>
                        
                        <div class="min-w-0">
                            <span class="text-sm font-medium text-gray-700 dark:text-gray-300 block group-hover:text-green-600 transition truncate" title="${rawNoteList}">
                                ${rawNoteList}
                            </span>
                            <span class="text-[10px] text-gray-400 block truncate">
                                ${t.cat_name}
                            </span>
                        </div>
                    </div>

                    <div class="text-right flex-shrink-0 ml-2">
                         <span class="text-sm font-bold ${amountClass} block">
                            ${sign} Rp ${amt.toLocaleString('id-ID')}
                         </span>
                    </div>
                </div>`;
            
            listContainer.innerHTML += itemHTML;
            
            // Render Tabel Hari Ini (Read Only)
            if(day === new Date().getDate() && todayTable) {
                 
                 // Kita TIDAK PERLU memotong string pakai JS lagi.
                 // Biarkan CSS yang mengatur visualnya.
                 let rawNote = t.note ? t.note : t.cat_name;

                 todayTable.innerHTML += `
                    <tr class="border-b dark:border-gray-700 last:border-0">
                        
                        <td class="py-3 w-[60%]">
                            <div class="flex items-center gap-3">
                                
                                <div class="w-8 h-8 rounded-full ${t.color} flex-shrink-0 flex items-center justify-center">
                                    <i class="fas ${t.icon} text-xs"></i>
                                </div>
                                
                                <div class="flex-1 min-w-0"> 
                                    <span class="block font-semibold truncate" title="${rawNote}">
                                        ${rawNote}
                                    </span>
                                    <span class="text-[10px] text-gray-400 font-normal block truncate">
                                        ${t.cat_name}
                                    </span>
                                </div>
                            </div>
                        </td>

                        <td class="py-3 text-right ${amountClass} font-bold whitespace-nowrap w-[40%]">
                            ${sign} Rp ${amt.toLocaleString('id-ID')}
                        </td>
                    </tr>`;
            }
        });
    }
    document.getElementById('detailIncome').innerText = "Rp " + totalInc.toLocaleString('id-ID');
    document.getElementById('detailExpense').innerText = "Rp " + totalExp.toLocaleString('id-ID');
}

function calculateBurnRate() {
    // Cek apakah elemen ada?
    const el = document.getElementById('predictionText');
    if (!el) return; // <--- INI SOLUSINYA (Jika elemen tidak ada, stop fungsi)

    let totalExp = 0; 
    Object.values(transactionDB).forEach(txs => { 
        txs.forEach(t => { if(t.type === 'expense') totalExp += parseInt(t.amount); }); 
    });
    
    const avgDaily = totalExp / 25; 
    const daysLeft = Math.floor(currentBalance / avgDaily); 
    
    // Karena el sudah dicek diatas, kode di bawah aman
    if (daysLeft < 10) el.innerHTML = `⚠️ <b class="text-red-600 dark:text-red-400">BAHAYA!</b> Rata-rata <b>Rp ${Math.round(avgDaily).toLocaleString('id-ID')}/hari</b>. Habis dalam <b>${daysLeft} hari</b>!`; 
    else el.innerHTML = `Rata-rata <b>Rp ${Math.round(avgDaily).toLocaleString('id-ID')}/hari</b>. Aman untuk <b>${daysLeft} hari</b>.`;
}

// --- MODAL LOGIC (ADD & EDIT) ---

// Helper untuk menutup modal
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

// 1. ADD TRANSACTION
function openAddModal() {
    document.getElementById('addTransactionModal').classList.remove('hidden');
    // Reset Form
    document.getElementById('add_amount').value = '';
    document.getElementById('add_note').value = '';
    const today = new Date().toISOString().split('T')[0];
    document.getElementById('add_date').value = today;
    
    setModalCategoryType('expense', 'add'); // Default expense
}

// 2. EDIT TRANSACTION (Dipanggil saat klik item di list)
function openEditModal(tx) {
    document.getElementById('editTransactionModal').classList.remove('hidden');
    
    // Isi data form dengan data transaksi yang diklik
    document.getElementById('edit_id').value = tx.id;
    document.getElementById('edit_amount').value = tx.amount;
    document.getElementById('edit_note').value = tx.note;
    document.getElementById('edit_date').value = tx.date; // Format YYYY-MM-DD sudah sesuai dari MySQL
    
    // Set Delete Link
    const deleteBtn = document.getElementById('btnDeleteTx');
    // Asumsi URL controller: base_url + dashboard/hapus_transaksi/ID
    deleteBtn.href = BASE_URL + 'dashboard/hapus_transaksi/' + tx.id; 

    // Set Kategori terpilih
    // Kita perlu tahu tx.category_id ada di type income atau expense
    // Cek type dari object tx (yg dikirim dari PHP model join)
    setModalCategoryType(tx.type, 'edit', tx.category_id);
}

// --- LOGIKA PILIH KATEGORI (REUSABLE UNTUK ADD & EDIT) ---
// mode = 'add' atau 'edit' (untuk membedakan ID elemen HTML)
function setModalCategoryType(type, mode, selectedCatId = null) {
    const prefix = mode === 'add' ? 'add' : 'edit'; // Prefix ID elemen HTML
    const listContainer = document.getElementById(`${prefix}_categoryList`);
    const amtContainer = document.getElementById(`${prefix}_amountContainer`);
    const btnExp = document.getElementById(`btn-${prefix}-expense`);
    const btnInc = document.getElementById(`btn-${prefix}-income`);

    // Ubah UI Tombol & Garis Input
    if (type === 'expense') {
        btnExp.className = "flex-1 py-3 rounded-lg font-bold text-sm bg-white dark:bg-dark-card text-red-500 shadow-sm transition-all";
        btnInc.className = "flex-1 py-3 rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all";
        amtContainer.className = "flex items-center border-b-2 border-red-500 py-2";
    } else {
        btnExp.className = "flex-1 py-3 rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all";
        btnInc.className = "flex-1 py-3 rounded-lg font-bold text-sm bg-white dark:bg-dark-card text-green-600 shadow-sm transition-all";
        amtContainer.className = "flex items-center border-b-2 border-green-500 py-2";
    }

    // Render List Kategori
    listContainer.innerHTML = '';
    
    // Looping Kategori dari Global Variable 'categories'
    if(categories[type]) {
        categories[type].forEach(cat => {
            const div = document.createElement('div');
            div.className = "flex flex-col items-center cursor-pointer transition-all p-2 rounded-xl border";
            
            // Cek jika ini kategori yang sedang diedit/dipilih
            if (selectedCatId && cat.id == selectedCatId) {
                div.classList.add('border-green-500', 'bg-green-50', 'dark:bg-gray-700', 'scale-110', 'shadow-sm');
                // Set hidden input category_id
                document.getElementById(`${prefix}_categoryId`).value = cat.id;
            } else {
                div.classList.add('border-transparent', 'opacity-70', 'hover:opacity-100');
            }

            div.innerHTML = `
                <div class="w-12 h-12 rounded-2xl ${cat.color} bg-opacity-20 flex items-center justify-center mb-1">
                    <i class="fas ${cat.icon}"></i>
                </div>
                <span class="text-[10px] text-gray-600 dark:text-gray-400 truncate w-full text-center">${cat.name}</span>
            `;
            
            // Event Klik Kategori
            div.onclick = function() { 
                // Reset semua styling di list ini
                Array.from(listContainer.children).forEach(c => {
                    c.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-gray-700', 'scale-110', 'shadow-sm', 'opacity-100');
                    c.classList.add('border-transparent', 'opacity-70');
                });
                
                // Highlight yang diklik
                this.classList.remove('border-transparent', 'opacity-70');
                this.classList.add('border-green-500', 'bg-green-50', 'dark:bg-gray-700', 'scale-110', 'shadow-sm', 'opacity-100');
                
                // Set value hidden input
                document.getElementById(`${prefix}_categoryId`).value = cat.id;
            };
            listContainer.appendChild(div);
        });
    }
}