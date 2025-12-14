<div class="md:hidden flex justify-between items-center mb-7">
    <div class="flex items-center gap-3 dark:border-gray-700">
        <i class="fas fa-wallet text-2xl text-green-500"></i>
        <h1 class="text-xl font-bold dark:text-white">KantongKu</h1>
    </div>

    <div class="flex items-center gap-3">
        <a href="<?= base_url('home/panduan'); ?>" class="w-10 h-10 rounded-full bg-white dark:bg-dark-card border border-gray-200 dark:border-gray-600 text-green-600 flex items-center justify-center shadow-sm hover:bg-green-50 transition" title="Panduan Aplikasi">
            <i class="fas fa-question-circle text-lg"></i>
        </a>
    </div>
</div>

<div class="grid grid-cols-1 md:grid-cols-3 gap-4 mb-6">
    <div class="bg-gradient-to-r from-green-400 to-green-600 p-6 rounded-2xl shadow-lg text-white">
        <p class="text-sm opacity-80">Sisa Saldo</p>
        <h2 class="text-3xl font-bold mt-1">Rp <?= number_format($saldo['total'], 0, ',', '.') ?></h2>
    </div>
    <div class="bg-white dark:bg-dark-card p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
        <div class="flex items-center gap-2 mb-1 text-green-500 font-bold text-sm"><i class="fas fa-arrow-down"></i> Pemasukan</div>
        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Rp <?= number_format($saldo['income'], 0, ',', '.') ?></h3>
    </div>
    <div class="bg-white dark:bg-dark-card p-6 rounded-2xl shadow-sm border border-gray-100 dark:border-gray-700 transition-colors">
        <div class="flex items-center gap-2 mb-1 text-red-500 font-bold text-sm"><i class="fas fa-arrow-up"></i> Pengeluaran</div>
        <h3 class="text-xl font-bold text-gray-800 dark:text-white">Rp <?= number_format($saldo['expense'], 0, ',', '.') ?></h3>
    </div>
</div>

<?php 
    $daysLeft = ($saldo['total'] > 0 && $burn_rate > 0) ? floor($saldo['total'] / $burn_rate) : 0;
    $isDanger = ($daysLeft < 10 && $daysLeft > 0);
    $isEmpty = ($saldo['total'] <= 0);

    // Menentukan warna background berdasarkan kondisi keuangan
    if ($isEmpty || $isDanger) {
        // Warna Merah/Orange jika bahaya
        $bgClass = "bg-gradient-to-r from-red-600 to-orange-500 shadow-red-200 dark:shadow-none";
        $iconBg = "bg-white text-red-600";
        $statusTitle = "PERINGATAN KEUANGAN";
    } else {
        // Warna Biru/Indigo jika aman
        $bgClass = "bg-gradient-to-r from-blue-600 to-indigo-600 shadow-blue-200 dark:shadow-none";
        $iconBg = "bg-white text-blue-600";
        $statusTitle = "Analisis Cerdas";
    }
?>

<div class="<?= $bgClass ?> p-6 rounded-2xl shadow-xl mb-8 relative overflow-hidden text-white">
    
    <div class="absolute -right-6 -bottom-8 text-9xl text-white opacity-10 rotate-12 pointer-events-none">
        <i class="fas fa-brain"></i>
    </div>

    <div class="relative z-10 flex flex-col sm:flex-row items-start gap-5">
        <div class="<?= $iconBg ?> w-14 h-14 rounded-2xl flex items-center justify-center shadow-lg flex-shrink-0">
            <i class="fas fa-brain text-2xl animate-pulse"></i>
        </div>

        <div class="flex-1">
            <div class="flex justify-between items-start">
                <div>
                    <h4 class="font-bold text-xs uppercase tracking-widest opacity-80 mb-1"><?= $statusTitle ?></h4>
                    
                    <div class="text-3xl font-extrabold mb-2">
                        <?php if ($isEmpty): ?>
                            Saldo Habis!
                        <?php elseif ($isDanger): ?>
                            Sisa <?= $daysLeft ?> Hari Lagi
                        <?php else: ?>
                            Aman untuk <?= $daysLeft ?> Hari
                        <?php endif; ?>
                    </div>
                </div>
            </div>

            <p class="text-sm font-medium opacity-90 leading-relaxed border-t border-white border-opacity-20 pt-3 mt-1">
                Rata-rata pengeluaranmu <b>Rp <?= number_format($burn_rate, 0, ',', '.') ?>/hari</b>.
                
                <?php if ($isEmpty): ?>
                    Saat ini saldo Anda kosong atau minus. <span class="underline font-bold">Segera atur keuangan!</span>
                <?php elseif ($isDanger): ?>
                    Keuangan menipis! <span class="font-bold bg-white bg-opacity-20 px-1 rounded">Mohon berhemat</span> agar bertahan sampai akhir bulan.
                <?php else: ?>
                    Kondisi keuanganmu <span class="font-bold">sehat</span>. Pertahankan pola pengeluaran ini.
                <?php endif; ?>
            </p>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-3 gap-6 mb-8">
    <div class="bg-white dark:bg-dark-card p-6 rounded-2xl shadow-sm col-span-1 lg:col-span-2 transition-colors">
        
        <div class="flex justify-between items-center mb-6">
            <h3 class="font-bold text-lg text-gray-800 dark:text-white">Kalender Keuangan</h3>
            <div class="flex items-center gap-2 text-xs">
                <span class="flex items-center gap-1 text-gray-500 dark:text-gray-400"><div class="w-2 h-2 rounded-full bg-green-500"></div> Hemat</span>
                <span class="flex items-center gap-1 text-gray-500 dark:text-gray-400"><div class="w-2 h-2 rounded-full bg-red-500"></div> Boros</span>
            </div>
        </div>

        <div class="flex justify-between items-center bg-gray-50 dark:bg-gray-700 p-3 rounded-xl mb-4">
            <button onclick="changeMonth(-1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 transition shadow-sm">
                <i class="fas fa-chevron-left"></i>
            </button>
            
            <span id="calendarTitle" class="font-bold text-gray-700 dark:text-gray-200 text-sm">
                Loading...
            </span>
            
            <button onclick="changeMonth(1)" class="w-8 h-8 flex items-center justify-center rounded-full hover:bg-white dark:hover:bg-gray-600 text-gray-600 dark:text-gray-300 transition shadow-sm">
                <i class="fas fa-chevron-right"></i>
            </button>
        </div>
        
        <div class="grid grid-cols-7 text-center mb-2">
            <div class="calendar-head">Min</div><div class="calendar-head">Sen</div><div class="calendar-head">Sel</div>
            <div class="calendar-head">Rab</div><div class="calendar-head">Kam</div><div class="calendar-head">Jum</div><div class="calendar-head">Sab</div>
        </div>
        
        <div id="calendarGrid" class="calendar-grid"></div>
    </div>

    <div class="bg-white dark:bg-dark-card p-6 rounded-2xl shadow-sm col-span-1 border-t-4 border-gray-800 dark:border-gray-500 flex flex-col h-[500px] transition-colors">
        <div class="text-center mb-4 flex-shrink-0">
            <p class="text-gray-400 text-xs font-bold uppercase tracking-wider">Rincian Tanggal</p>
            <h2 class="text-4xl font-bold text-gray-800 dark:text-white mt-1" id="selectedDateDisplay"><?= date('j') ?></h2>
            <p class="text-sm text-green-600 font-medium"><?= date('F Y') ?></p>
        </div>
        
        <div class="flex gap-2 mb-4 flex-shrink-0">
            <div class="flex-1 bg-green-50 dark:bg-gray-700 p-2 rounded-lg text-center">
                <p class="text-[10px] text-gray-500 dark:text-gray-400">Masuk</p>
                <p class="text-sm font-bold text-green-600 dark:text-green-400" id="detailIncome">Rp 0</p>
            </div>
            <div class="flex-1 bg-red-50 dark:bg-gray-700 p-2 rounded-lg text-center">
                <p class="text-[10px] text-gray-500 dark:text-gray-400">Keluar</p>
                <p class="text-sm font-bold text-red-500 dark:text-red-400" id="detailExpense">Rp 0</p>
            </div>
        </div>

        <div class="flex-1 overflow-y-auto pr-1">
            <p class="text-xs font-bold text-gray-400 mb-2 uppercase">Riwayat Transaksi</p>
            <div id="transactionList" class="space-y-3"></div>
        </div>
    </div>
</div>

<div class="bg-white dark:bg-dark-card p-6 rounded-2xl shadow-sm mb-8 transition-colors">
    <h3 class="font-bold text-gray-800 dark:text-white mb-4">Perbandingan Mingguan</h3>
    <div class="h-64"><canvas id="comparisonChart"></canvas></div>
</div>

<div class="bg-white dark:bg-dark-card p-6 rounded-2xl shadow-sm transition-colors">
    <div class="flex justify-between items-center mb-4">
        <h3 class="font-bold text-gray-800 dark:text-white">Transaksi Hari Ini</h3>
        <span class="text-xs bg-gray-100 dark:bg-gray-700 text-gray-500 dark:text-gray-300 px-2 py-1 rounded"><?= date('d M Y') ?></span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-left text-sm table-fixed">
            <tbody class="divide-y dark:divide-gray-700" id="todayTransactionTable">
                </tbody>
        </table>
    </div>
</div>

<button onclick="openAddModal()" class="fixed bottom-24 right-4 md:bottom-8 md:right-8 bg-green-600 hover:bg-green-700 text-white w-14 h-14 rounded-full shadow-2xl flex items-center justify-center text-2xl transition transform hover:scale-105 z-50">
    <i class="fas fa-plus"></i>
</button>

<form action="<?= site_url('dashboard/simpan_transaksi') ?>" method="POST" onsubmit="showLoading()">
    <div id="addTransactionModal" onclick="if(event.target === this) closeModal('addTransactionModal')" class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex items-end md:items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-dark-card w-full md:w-[400px] rounded-t-3xl md:rounded-3xl p-6 h-[85vh] md:h-auto overflow-y-auto animate-fade-in transition-colors" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg dark:text-white">Tambah Transaksi</h3>
                <button type="button" onclick="closeModal('addTransactionModal')" class="bg-gray-100 dark:bg-gray-700 p-2 rounded-full"><i class="fas fa-times dark:text-white"></i></button>
            </div>
            
            <div class="flex bg-gray-100 dark:bg-gray-700 rounded-xl p-1 mb-6">
                <button type="button" id="btn-add-expense" onclick="setModalCategoryType('expense', 'add')" class="flex-1 py-3 rounded-lg font-bold text-sm shadow-sm bg-white dark:bg-dark-card text-red-500 transition-all">Pengeluaran</button>
                <button type="button" id="btn-add-income" onclick="setModalCategoryType('income', 'add')" class="flex-1 py-3 rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all">Pemasukan</button>
            </div>

            <input type="hidden" name="category_id" id="add_categoryId" required>

            <div class="mb-6">
                <label class="text-xs text-gray-400 font-bold uppercase block mb-2">Nominal</label>
                
                <div id="add_amountContainer" class="flex items-center bg-gray-50 dark:bg-dark-input border border-gray-200 dark:border-gray-600 rounded-xl px-2 py-1 transition-colors focus-within:ring-2 focus-within:border-transparent">
                    
                    <button type="button" onclick="adjustNominal('add_amount', -1000)" 
                        class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-700 text-gray-500 dark:text-gray-300 rounded-lg shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-red-500 transition active:scale-95">
                        <i class="fas fa-minus text-xs"></i>
                    </button>

                    <div class="flex-1 flex items-center justify-center text-center px-2">
                        <span class="text-lg font-bold text-gray-400 mr-1">Rp</span>
                        <input type="number" name="amount" id="add_amount" 
                            class="w-full text-2xl font-bold bg-transparent focus:outline-none text-gray-800 dark:text-white text-center" 
                            placeholder="0"
                            required
                            min="1" 
                            max="100000000"
                            oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null; if(this.value > 100000000) this.value = 100000000;">
                    </div>

                    <button type="button" onclick="adjustNominal('add_amount', 1000)" 
                        class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-700 text-gray-500 dark:text-gray-300 rounded-lg shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-green-500 transition active:scale-95">
                        <i class="fas fa-plus text-xs"></i>
                    </button>

                </div>
            </div>

            <div class="mb-4">
                <label class="text-xs text-gray-400 font-bold uppercase block mb-2">Tanggal</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="text" name="date" id="add_date" 
                        class="datepicker-input w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-dark-input dark:text-white transition cursor-pointer" 
                        placeholder="Pilih Tanggal" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="text-xs text-gray-400 font-bold uppercase block mb-3">Kategori</label>
                
                <div id="add_categoryList" class="grid grid-cols-4 gap-3 max-h-48 overflow-y-auto p-1 custom-scrollbar">
                </div>
                
            </div>

            <div class="mb-6"><label class="text-xs text-gray-400 font-bold uppercase block mb-2">Catatan</label>
                <input type="text" name="note" id="add_note" class="w-full bg-gray-50 dark:bg-dark-input dark:border-gray-600 dark:text-white border border-gray-200 rounded-xl px-4 py-3" maxlength="255" placeholder="Contoh: Nasi Padang">
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl hover:bg-green-700 transition">Simpan</button>
        </div>
    </div>
</form>

<form action="<?= site_url('dashboard/update_transaksi') ?>" method="POST" onsubmit="showLoading()">
    <div id="editTransactionModal" onclick="if(event.target === this) closeModal('editTransactionModal')" class="fixed inset-0 bg-black bg-opacity-60 hidden z-50 flex items-end md:items-center justify-center backdrop-blur-sm">
        <div class="bg-white dark:bg-dark-card w-full md:w-[400px] rounded-t-3xl md:rounded-3xl p-6 h-[85vh] md:h-auto overflow-y-auto animate-fade-in transition-colors" onclick="event.stopPropagation()">
            <div class="flex justify-between items-center mb-6">
                <h3 class="font-bold text-lg dark:text-white">Edit Transaksi</h3>
                <button type="button" onclick="closeModal('editTransactionModal')" class="bg-gray-100 dark:bg-gray-700 p-2 rounded-full"><i class="fas fa-times dark:text-white"></i></button>
            </div>

            <input type="hidden" name="id" id="edit_id">

            <div class="flex bg-gray-100 dark:bg-gray-700 rounded-xl p-1 mb-6">
                <button type="button" id="btn-edit-expense" onclick="setModalCategoryType('expense', 'edit')" class="flex-1 py-3 rounded-lg font-bold text-sm shadow-sm bg-white dark:bg-dark-card text-red-500 transition-all">Pengeluaran</button>
                <button type="button" id="btn-edit-income" onclick="setModalCategoryType('income', 'edit')" class="flex-1 py-3 rounded-lg font-medium text-sm text-gray-500 dark:text-gray-400 transition-all">Pemasukan</button>
            </div>

            <input type="hidden" name="category_id" id="edit_categoryId" required>

            <div class="mb-6">
                <label class="text-xs text-gray-400 font-bold uppercase block mb-2">Nominal</label>
                
                <div id="edit_amountContainer" class="flex items-center bg-gray-50 dark:bg-dark-input border border-gray-200 dark:border-gray-600 rounded-xl px-2 py-1 transition-colors focus-within:ring-2 focus-within:border-transparent">
                    
                    <button type="button" onclick="adjustNominal('edit_amount', -1000)" 
                        class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-700 text-gray-500 dark:text-gray-300 rounded-lg shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-red-500 transition active:scale-95">
                        <i class="fas fa-minus text-xs"></i>
                    </button>

                    <div class="flex-1 flex items-center justify-center text-center px-2">
                        <span class="text-lg font-bold text-gray-400 mr-1">Rp</span>
                        <input type="number" name="amount" id="edit_amount" 
                            class="w-full text-2xl font-bold bg-transparent focus:outline-none text-gray-800 dark:text-white text-center" 
                            placeholder="0" 
                            required
                            min="1" 
                            max="100000000"
                            oninput="this.value = !!this.value && Math.abs(this.value) >= 0 ? Math.abs(this.value) : null; if(this.value > 100000000) this.value = 100000000;">
                    </div>

                    <button type="button" onclick="adjustNominal('edit_amount', 1000)" 
                        class="w-10 h-10 flex items-center justify-center bg-white dark:bg-gray-700 text-gray-500 dark:text-gray-300 rounded-lg shadow-sm hover:bg-gray-100 dark:hover:bg-gray-600 hover:text-green-500 transition active:scale-95">
                        <i class="fas fa-plus text-xs"></i>
                    </button>

                </div>
            </div>

            <div class="mb-4">
                <label class="text-xs text-gray-400 font-bold uppercase block mb-2">Tanggal</label>
                <div class="relative">
                    <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none z-10">
                        <i class="fas fa-calendar-alt text-gray-400"></i>
                    </div>
                    <input type="text" name="date" id="edit_date" 
                        class="datepicker-input w-full pl-10 pr-4 py-2 border border-gray-300 dark:border-gray-600 rounded-lg focus:outline-none focus:ring-2 focus:ring-green-500 bg-white dark:bg-dark-input dark:text-white transition cursor-pointer" 
                        placeholder="Pilih Tanggal" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="text-xs text-gray-400 font-bold uppercase block mb-3">Kategori</label>
                
                <div id="edit_categoryList" class="grid grid-cols-4 gap-3 max-h-48 overflow-y-auto p-1 custom-scrollbar">
                    </div>
                
            </div>

            <div class="mb-6"><label class="text-xs text-gray-400 font-bold uppercase block mb-2">Catatan</label>
                <input type="text" name="note" id="edit_note" class="w-full bg-gray-50 dark:bg-dark-input dark:border-gray-600 dark:text-white border border-gray-200 rounded-xl px-4 py-3" maxlength="255">
            </div>

            <div class="flex gap-3">
                <a id="btnDeleteTx" href="#" class="flex-none py-4 px-6 bg-red-100 text-red-500 dark:bg-red-500 dark:text-red-100 font-bold rounded-xl hover:bg-red-200 transition text-center">
                    <i class="fas fa-trash"></i>
                </a>
                <button type="submit" class="flex-1 bg-green-600 text-white font-bold py-4 rounded-xl hover:bg-green-700 transition">Update</button>
            </div>
        </div>
    </div>
</form>

<script>
    const BASE_URL = "<?= base_url(); ?>";
    let transactionDB = <?= json_encode($calendar_data); ?>;
    const currentBalance = <?= $saldo['total']; ?>;
    const chartDataIncome = <?= json_encode($chart_data['income']); ?>;
    const chartDataExpense = <?= json_encode($chart_data['expense']); ?>;
    const chartLabels = <?= json_encode($chart_data['labels']); ?>;
    const categories = <?= json_encode($categories); ?>;

    const DASHBOARD_URLS = {
        chart_data: "<?= base_url('dashboard/get_chart_data'); ?>"
    };
</script>