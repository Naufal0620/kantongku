/**
 * dashboard.js
 * Menangani logika Kalender, Grafik Perbandingan Mingguan, dan Modal Transaksi
 */

// --- STATE VARIABLES ---
let activeDate = new Date(); // Menyimpan tanggal yang sedang dilihat kalendernya
let comparisonChart = null;  // Variabel Global untuk Chart Instance

document.addEventListener('DOMContentLoaded', function() {
    if (typeof transactionDB === 'undefined') return;

    initComparisonChart(); // Inisialisasi Chart Kosong
    
    // Init Kalender & Data Chart
    updateCalendarHeader();
    renderCalendar(); // Ini akan memanggil loadChartData juga
    
    selectDate(new Date().getDate()); 
    calculateBurnRate();
    setModalCategoryType('expense', 'add'); 
});

// --- CHART LOGIC (BARU: Perbandingan Mingguan) ---

// 1. Inisialisasi Chart (Format Baru)
function initComparisonChart() {
    const ctx = document.getElementById('comparisonChart').getContext('2d');
    
    comparisonChart = new Chart(ctx, {
        type: 'line',
        data: {
            labels: ['Minggu 1', 'Minggu 2', 'Minggu 3', 'Minggu 4', 'Minggu 5'],
            datasets: [
                {
                    label: 'Pemasukan',
                    data: [0, 0, 0, 0, 0], // Data awal kosong
                    borderColor: '#10B981', // Green-500
                    backgroundColor: 'rgba(16, 185, 129, 0.1)',
                    fill: true,
                    tension: 0.4
                },
                {
                    label: 'Pengeluaran',
                    data: [0, 0, 0, 0, 0], // Data awal kosong
                    borderColor: '#EF4444', // Red-500
                    backgroundColor: 'rgba(239, 68, 68, 0.1)',
                    fill: true,
                    tension: 0.4
                }
            ]
        },
        options: {
            responsive: true,
            maintainAspectRatio: false,
            plugins: {
                legend: { position: 'top' },
                tooltip: {
                    callbacks: {
                        label: function(context) {
                            let label = context.dataset.label || '';
                            if (label) label += ': ';
                            label += new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR' }).format(context.raw);
                            return label;
                        }
                    }
                }
            },
            scales: {
                x: { grid: { display: false } },
                y: {
                    // [BARU] Format Nominal di Sumbu Y
                    ticks: {
                        callback: function(value) {
                            return new Intl.NumberFormat('id-ID', { 
                                style: 'currency', currency: 'IDR', notation: "compact", maximumFractionDigits: 1
                            }).format(value);
                        },
                        color: '#9CA3AF'
                    },
                    grid: { borderDash: [2, 2], color: '#E5E7EB' }
                }
            }
        }
    });
}

// 2. Load Data Chart via AJAX
function loadChartData(month, year) {
    // Pastikan URL 'DASHBOARD_URLS' sudah didefinisikan di View
    if (typeof DASHBOARD_URLS === 'undefined') return;

    $.ajax({
        url: DASHBOARD_URLS.chart_data,
        type: 'POST',
        data: { month: month, year: year },
        dataType: 'json',
        success: function(response) {
            // Update Data Chart
            comparisonChart.data.datasets[0].data = response.income;
            comparisonChart.data.datasets[1].data = response.expense;
            comparisonChart.update();
        },
        error: function(err) {
            console.error("Gagal memuat data grafik:", err);
        }
    });
}


// --- CALENDAR LOGIC (EXISTING & INTEGRATED) ---

// 1. Fungsi Navigasi Bulan
function changeMonth(offset) {
    activeDate.setMonth(activeDate.getMonth() + offset);
    updateCalendarHeader(); 
    fetchCalendarData();    
}

// 2. Update Judul Header
function updateCalendarHeader() {
    const monthNames = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];
    const title = `${monthNames[activeDate.getMonth()]} ${activeDate.getFullYear()}`;
    document.getElementById('calendarTitle').innerText = title;
}

// 3. Fetch Data AJAX
function fetchCalendarData() {
    const month = activeDate.getMonth() + 1; 
    const year = activeDate.getFullYear();
    const grid = document.getElementById('calendarGrid');
    
    grid.innerHTML = '<div class="col-span-7 text-center py-10 text-gray-400"><i class="fas fa-spinner fa-spin text-2xl"></i></div>';

    $.ajax({
        url: BASE_URL + 'dashboard/get_calendar_json', // URL lama kamu
        type: 'GET',
        data: { month: month, year: year },
        dataType: 'json',
        success: function(response) {
            for (var member in transactionDB) delete transactionDB[member];
            Object.assign(transactionDB, response);

            renderCalendar(); 
            selectDate(1); 
        },
        error: function() {
            alert('Gagal mengambil data kalender.');
        }
    });
}

// 4. Render Grid Kotak-Kotak (DITAMBAHKAN loadChartData)
function renderCalendar() {
    const grid = document.getElementById('calendarGrid'); 
    grid.innerHTML = '';
    
    const year = activeDate.getFullYear();
    const month = activeDate.getMonth(); 
    
    // [BARU] Panggil update chart setiap kali kalender dirender (ganti bulan)
    loadChartData(month + 1, year);

    const daysInMonth = new Date(year, month + 1, 0).getDate();
    const firstDayIndex = new Date(year, month, 1).getDay(); 
    
    for (let x = 0; x < firstDayIndex; x++) {
        const spacer = document.createElement('div');
        grid.appendChild(spacer);
    }

    for (let i = 1; i <= daysInMonth; i++) {
        const dayDiv = document.createElement('div');
        const txs = transactionDB[i] || []; 
        
        let totalInc = 0, totalExp = 0;
        txs.forEach(t => { 
            if(t.type === 'income') totalInc += parseInt(t.amount); 
            else totalExp += parseInt(t.amount); 
        });
        
        let baseClass = "calendar-day day-neutral", iconHTML = "";
        
        if (txs.length > 0) { 
            if (totalExp > totalInc) { 
                baseClass = "calendar-day day-deficit"; 
                iconHTML = `<i class="fas fa-arrow-down absolute top-1 right-1 text-[8px]"></i>`; 
            } else { 
                baseClass = "calendar-day day-surplus"; 
                iconHTML = `<i class="fas fa-arrow-up absolute top-1 right-1 text-[8px]"></i>`; 
            } 
        }
        
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


// --- TRANSACTION LIST & MODAL LOGIC (TIDAK BERUBAH) ---

function selectDate(day) {
    document.getElementById('selectedDateDisplay').innerText = day;
    const txs = transactionDB[day] || [];
    let totalInc = 0, totalExp = 0;
    const listContainer = document.getElementById('transactionList');
    const todayTable = document.getElementById('todayTransactionTable');
    
    listContainer.innerHTML = '';
    
    if(day === new Date().getDate() && todayTable) todayTable.innerHTML = '';

    if (txs.length === 0) {
        listContainer.innerHTML = `<div class="text-center text-gray-300 text-xs mt-10 italic">Tidak ada transaksi</div>`;
        if(day === new Date().getDate() && todayTable) {
            todayTable.innerHTML = `<tr><td colspan="2" class="text-center py-4 text-gray-400 italic">Belum ada transaksi hari ini</td></tr>`;
        }
    } else {
        txs.forEach(t => {
            const amt = parseInt(t.amount);
            if(t.type === 'income') totalInc += amt; else totalExp += amt;
            const amountClass = t.type === 'income' ? 'text-green-600 dark:text-green-400' : 'text-red-500 dark:text-red-400';
            const sign = t.type === 'income' ? '+' : '-';
            
            const txString = JSON.stringify(t).replace(/'/g, "&#39;");
            let rawNoteList = t.note ? t.note : t.cat_name;

            const itemHTML = `
                <div onclick='openEditModal(${txString})' class="cursor-pointer group flex items-center justify-between p-3 border border-gray-100 dark:border-gray-700 rounded-xl bg-gray-50 dark:bg-gray-700 hover:bg-white dark:hover:bg-gray-600 hover:border-green-400 transition shadow-sm hover:shadow-md">
                    <div class="flex items-center gap-3 flex-1 min-w-0">
                        <div class="w-8 h-8 rounded-full ${t.color} flex-shrink-0 flex items-center justify-center text-xs">
                            <i class="fas fa-${t.icon}"></i>
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
            
            if(day === new Date().getDate() && todayTable) {
                 let rawNote = t.note ? t.note : t.cat_name;
                 todayTable.innerHTML += `
                    <tr class="border-b dark:border-gray-700 last:border-0">
                        <td class="py-3 w-[60%]">
                            <div class="flex items-center gap-3">
                                <div class="w-8 h-8 rounded-full ${t.color} flex-shrink-0 flex items-center justify-center">
                                    <i class="fas fa-${t.icon} text-xs"></i>
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
    const el = document.getElementById('predictionText');
    if (!el) return; 

    let totalExp = 0; 
    Object.values(transactionDB).forEach(txs => { 
        txs.forEach(t => { if(t.type === 'expense') totalExp += parseInt(t.amount); }); 
    });
    
    const avgDaily = totalExp / 25; 
    const daysLeft = Math.floor(currentBalance / avgDaily); 
    
    if (daysLeft < 10) el.innerHTML = `⚠️ <b class="text-red-600 dark:text-red-400">BAHAYA!</b> Rata-rata <b>Rp ${Math.round(avgDaily).toLocaleString('id-ID')}/hari</b>. Habis dalam <b>${daysLeft} hari</b>!`; 
    else el.innerHTML = `Rata-rata <b>Rp ${Math.round(avgDaily).toLocaleString('id-ID')}/hari</b>. Aman untuk <b>${daysLeft} hari</b>.`;
}

// Helper untuk menutup modal
function closeModal(id) { document.getElementById(id).classList.add('hidden'); }

// 1. ADD TRANSACTION
function openAddModal() {
    document.getElementById('addTransactionModal').classList.remove('hidden');
    document.getElementById('add_amount').value = '';
    document.getElementById('add_note').value = '';
    const today = new Date().toLocaleDateString('en-CA', { timeZone: 'Asia/Jakarta' });
    document.getElementById('add_date').value = today;
    setModalCategoryType('expense', 'add'); 
}

// 2. EDIT TRANSACTION 
function openEditModal(tx) {
    document.getElementById('editTransactionModal').classList.remove('hidden');
    
    document.getElementById('edit_id').value = tx.id;
    document.getElementById('edit_amount').value = tx.amount;
    document.getElementById('edit_note').value = tx.note;
    document.getElementById('edit_date').value = tx.date; 
    
    const deleteBtn = document.getElementById('btnDeleteTx');
    deleteBtn.href = BASE_URL + 'dashboard/hapus_transaksi/' + tx.id;

    deleteBtn.onclick = function(event) {
        event.preventDefault(); 
        Swal.fire({
            title: 'Yakin hapus data ini?',
            text: "Data transaksi akan hilang permanen!",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444',
            cancelButtonColor: '#6B7280',
            confirmButtonText: 'Ya, Hapus!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading();
                window.location.href = deleteBtn.href;
            }
        });
    };
    setModalCategoryType(tx.type, 'edit', tx.category_id);
}

// LOGIKA PILIH KATEGORI (REUSABLE)
function setModalCategoryType(type, mode, selectedCatId = null) {
    const prefix = mode === 'add' ? 'add' : 'edit';
    const listContainer = document.getElementById(`${prefix}_categoryList`);
    const amtContainer = document.getElementById(`${prefix}_amountContainer`);
    const btnExp = document.getElementById(`btn-${prefix}-expense`);
    const btnInc = document.getElementById(`btn-${prefix}-income`);

    if (type === 'expense') {
        btnExp.className = "flex-1 py-3 rounded-lg font-bold text-sm bg-white dark:bg-dark-card text-red-500 shadow-sm transition-all";
        btnInc.className = "flex-1 py-3 rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all";
        amtContainer.className = "flex items-center border-b-2 border-red-500 py-2";
    } else {
        btnExp.className = "flex-1 py-3 rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all";
        btnInc.className = "flex-1 py-3 rounded-lg font-bold text-sm bg-white dark:bg-dark-card text-green-600 shadow-sm transition-all";
        amtContainer.className = "flex items-center border-b-2 border-green-500 py-2";
    }

    listContainer.innerHTML = '';
    
    if(categories[type]) {
        categories[type].forEach(cat => {
            const div = document.createElement('div');
            div.className = "flex flex-col items-center cursor-pointer transition-all p-2 rounded-xl border";
            
            if (selectedCatId && cat.id == selectedCatId) {
                div.classList.add('border-green-500', 'bg-green-50', 'dark:bg-gray-700', 'scale-110', 'shadow-sm');
                document.getElementById(`${prefix}_categoryId`).value = cat.id;
            } else {
                div.classList.add('border-transparent', 'opacity-70', 'hover:opacity-100');
            }

            div.innerHTML = `
                <div class="w-12 h-12 rounded-2xl ${cat.color} bg-opacity-20 flex items-center justify-center mb-1">
                    <i class="fas fa-${cat.icon}"></i>
                </div>
                <span class="text-[10px] text-gray-600 dark:text-gray-400 truncate w-full text-center">${cat.name}</span>
            `;
            
            div.onclick = function() { 
                Array.from(listContainer.children).forEach(c => {
                    c.classList.remove('border-green-500', 'bg-green-50', 'dark:bg-gray-700', 'scale-110', 'shadow-sm', 'opacity-100');
                    c.classList.add('border-transparent', 'opacity-70');
                });
                
                this.classList.remove('border-transparent', 'opacity-70');
                this.classList.add('border-green-500', 'bg-green-50', 'dark:bg-gray-700', 'scale-110', 'shadow-sm', 'opacity-100');
                document.getElementById(`${prefix}_categoryId`).value = cat.id;
            };
            listContainer.appendChild(div);
        });
    }
}