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
?>
<div class="bg-blue-50 dark:bg-gray-800 border border-blue-200 dark:border-gray-600 p-4 rounded-xl mb-8 flex items-start gap-4 shadow-sm transition-colors">
    <div class="bg-blue-100 dark:bg-gray-700 p-3 rounded-full text-blue-600 dark:text-blue-400">
        <i class="fas fa-brain"></i>
    </div>
    <div>
        <h4 class="font-bold text-blue-800 dark:text-blue-300 text-sm mb-1">Analisis Cerdas</h4>
        <p class="text-sm text-blue-700 dark:text-gray-300 leading-relaxed">
            Rata-rata pengeluaran <b>Rp <?= number_format($burn_rate, 0, ',', '.') ?>/hari</b>.
            <?php if ($saldo['total'] <= 0): ?>
                Saldo Anda habis atau minus!
            <?php elseif ($isDanger): ?>
                ⚠️ <b class="text-red-600">BAHAYA!</b> Saldo diprediksi habis dalam <b><?= $daysLeft ?> hari</b>!
            <?php else: ?>
                Saldo aman untuk sekitar <b><?= $daysLeft ?> hari</b> lagi.
            <?php endif; ?>
        </p>
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

<form action="<?= site_url('dashboard/simpan_transaksi') ?>" method="POST">
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

            <div class="mb-6"><label class="text-xs text-gray-400 font-bold uppercase block mb-2">Nominal</label>
                <div class="flex items-center border-b-2 border-red-500 py-2" id="add_amountContainer">
                    <span class="text-2xl font-bold mr-2 text-gray-400">Rp</span>
                    <input type="number" name="amount" id="add_amount" class="w-full text-3xl font-bold bg-transparent focus:outline-none dark:text-white" placeholder="0" required>
                </div>
            </div>

            <div class="mb-6">
                <label class="text-xs text-gray-400 font-bold uppercase block mb-2">Tanggal</label>
                <input type="date" name="date" id="add_date" class="w-full bg-gray-50 dark:bg-dark-input dark:border-gray-600 dark:text-white border border-gray-200 rounded-xl px-4 py-3 cursor-pointer" required>
            </div>

            <div class="mb-6"><label class="text-xs text-gray-400 font-bold uppercase block mb-3">Kategori</label>
                <div id="add_categoryList" class="grid grid-cols-4 gap-3"></div>
            </div>

            <div class="mb-6"><label class="text-xs text-gray-400 font-bold uppercase block mb-2">Catatan</label>
                <input type="text" name="note" id="add_note" class="w-full bg-gray-50 dark:bg-dark-input dark:border-gray-600 dark:text-white border border-gray-200 rounded-xl px-4 py-3" placeholder="Contoh: Nasi Padang">
            </div>

            <button type="submit" class="w-full bg-green-600 text-white font-bold py-4 rounded-xl hover:bg-green-700 transition">Simpan</button>
        </div>
    </div>
</form>

<form action="<?= site_url('dashboard/update_transaksi') ?>" method="POST">
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

            <div class="mb-6"><label class="text-xs text-gray-400 font-bold uppercase block mb-2">Nominal</label>
                <div class="flex items-center border-b-2 border-red-500 py-2" id="edit_amountContainer">
                    <span class="text-2xl font-bold mr-2 text-gray-400">Rp</span>
                    <input type="number" name="amount" id="edit_amount" class="w-full text-3xl font-bold bg-transparent focus:outline-none dark:text-white" placeholder="0" required>
                </div>
            </div>

            <div class="mb-6"><label class="text-xs text-gray-400 font-bold uppercase block mb-2">Tanggal</label>
                <input type="date" name="date" id="edit_date" class="w-full bg-gray-50 dark:bg-dark-input dark:border-gray-600 dark:text-white border border-gray-200 rounded-xl px-4 py-3">
            </div>

            <div class="mb-6"><label class="text-xs text-gray-400 font-bold uppercase block mb-3">Kategori</label>
                <div id="edit_categoryList" class="grid grid-cols-4 gap-3"></div>
            </div>

            <div class="mb-6"><label class="text-xs text-gray-400 font-bold uppercase block mb-2">Catatan</label>
                <input type="text" name="note" id="edit_note" class="w-full bg-gray-50 dark:bg-dark-input dark:border-gray-600 dark:text-white border border-gray-200 rounded-xl px-4 py-3">
            </div>

            <div class="flex gap-3">
                <a id="btnDeleteTx" href="#" onclick="return confirm('Yakin hapus transaksi ini?')" class="flex-none py-4 px-6 bg-red-100 text-red-500 font-bold rounded-xl hover:bg-red-200 transition text-center">
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
</script>