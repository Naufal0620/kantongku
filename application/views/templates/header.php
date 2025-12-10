<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
    <link rel="icon" type="image/png" href="<?= base_url("assets/img/favicon.png") ?>">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            darkMode: 'class',
            theme: {
                extend: {
                    colors: {
                        dark: { bg: '#111827', card: '#1F2937', text: '#F3F4F6', muted: '#9CA3AF', input: '#374151' }
                    }
                }
            },
            safelist: [
                'bg-gray-100', 'text-gray-600', 'dark:bg-gray-600', 'dark:text-gray-100',
                'bg-orange-100', 'text-orange-600', 'dark:bg-orange-600', 'dark:text-orange-100',
                'bg-blue-100', 'text-blue-600', 'dark:bg-blue-600', 'dark:text-blue-100',
                'bg-indigo-100', 'text-indigo-600', 'dark:bg-indigo-600', 'dark:text-indigo-100',
                'bg-pink-100', 'text-pink-600', 'dark:bg-pink-600', 'dark:text-pink-100',
                'bg-purple-100', 'text-purple-600', 'dark:bg-purple-600', 'dark:text-purple-100',
                'bg-yellow-100', 'text-yellow-600', 'dark:bg-yellow-600', 'dark:text-yellow-100',
                'bg-green-100', 'text-green-600', 'dark:bg-green-600', 'dark:text-green-100',
                'bg-teal-100', 'text-teal-600', 'dark:bg-teal-600', 'dark:text-teal-100',
                'bg-red-100', 'text-red-600', 'dark:bg-red-600', 'dark:text-red-100'
            ]
        }
    </script>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/flatpickr/dist/flatpickr.min.css">

    <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
    <style>
        /* Masukkan semua CSS Custom di sini (Scrollbar, Calendar, Toggle, dll) */
        @import url('https://fonts.googleapis.com/css2?family=Inter:wght@300;400;600;700&display=swap');
        body { font-family: 'Inter', sans-serif; }

        /* Custom Scrollbar */
        ::-webkit-scrollbar { width: 6px; }
        ::-webkit-scrollbar-track { background: transparent; }
        ::-webkit-scrollbar-thumb { background: #cbd5e1; border-radius: 4px; }

        /* Animation */
        .animate-fade-in { animation: fadeIn 0.4s ease-in-out; }
        @keyframes fadeIn { from { opacity: 0; transform: translateY(10px); } to { opacity: 1; transform: translateY(0); } }
        
        /* Calendar Styles */
        .calendar-grid { display: grid; grid-template-columns: repeat(7, 1fr); gap: 6px; }
        .calendar-day { 
            aspect-ratio: 1; display: flex; flex-direction: column; align-items: center; justify-content: center; 
            border-radius: 10px; cursor: pointer; font-size: 14px; position: relative; 
            transition: all 0.2s; border: 1px solid transparent;
        }
        .calendar-day:hover { transform: scale(1.05); z-index: 10; box-shadow: 0 4px 6px -1px rgba(0,0,0,0.1); }
        .calendar-day.active { border-color: #374151; transform: scale(1.05); }
        .dark .calendar-day.active { border-color: #F3F4F6; }
        .day-surplus { background-color: #DEF7EC; color: #047857; } 
        .day-deficit { background-color: #FDE8E8; color: #C81E1E; } 
        .day-neutral { background-color: #F9FAFB; color: #6B7280; }
        .dark .day-neutral { background-color: #374151; color: #D1D5DB; }
        .calendar-head { font-size: 12px; font-weight: bold; text-align: center; color: #9CA3AF; margin-bottom: 8px; }

        /* --- STYLE KALENDER (DARK MODE - BARU) --- */
        
        /* 1. Surplus (Hemat/Hijau) */
        .dark .day-surplus {
            background-color: rgba(5, 150, 105, 0.2) !important; /* Hijau gelap transparan */
            color: #34D399 !important; /* Hijau terang (Emerald-400) */
            border: 1px solid rgba(5, 150, 105, 0.3); /* Border tipis agar tegas */
        }

        /* 2. Deficit (Boros/Merah) */
        .dark .day-deficit {
            background-color: rgba(220, 38, 38, 0.2) !important; /* Merah gelap transparan */
            color: #F87171 !important; /* Merah terang (Red-400) */
            border: 1px solid rgba(220, 38, 38, 0.3);
        }

        /* 3. Neutral (Hari kosong/Belum ada transaksi) */
        .dark .day-neutral {
            background-color: #1f2937 !important; /* Abu-abu gelap (Gray-800) */
            color: #9CA3AF !important; /* Teks abu-abu terang */
            border: 1px solid #374151; /* Border abu-abu */
        }

        /* 4. Hover Effect di Dark Mode */
        .dark .calendar-day:hover {
            background-color: #374151 !important; /* Highlight saat di-hover */
            border-color: #6B7280;
        }
        
        /* 5. Hari Ini (Active Border) */
        .dark .calendar-day.active {
            border-color: #F3F4F6 !important; /* Border putih terang */
        }

        /* Toggle Switch Animation */
        .toggle-checkbox {
            right: auto;
            left: 0;
            transition: all 0.3s ease-in-out; /* Animasi smooth */
        }
        .toggle-checkbox:checked {
            left: 1.5rem; /* Geser ke kanan sejauh 50% dari container w-12 (3rem) */
            border-color: #10B981;
        }
        .toggle-checkbox:checked + .toggle-label {
            background-color: #10B981;
        }

        /* HIDE DEFAULT NUMBER ARROWS */
        /* Chrome, Safari, Edge, Opera */
        input::-webkit-outer-spin-button,
        input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        /* Firefox */
        input[type=number] {
            -moz-appearance: textfield;
        }
    </style>

    <style>
        /* =========================================
        CUSTOM FLATPICKR STYLING (FIXED)
        ========================================= */

        /* 1. Wrapper agar Full Width */
        .flatpickr-wrapper {
            width: 100% !important;
            display: block !important;
        }

        /* 2. Style Kalender Dasar */
        .flatpickr-calendar {
            width: 100% !important;
            max-width: none !important;
            margin-top: 2px !important;
            box-shadow: 0 4px 6px -1px rgba(0, 0, 0, 0.1), 0 2px 4px -1px rgba(0, 0, 0, 0.06) !important;
            border: none !important;
            border-radius: 0.75rem !important;
            font-family: 'Inter', sans-serif !important;
        }

        /* --- FIX 1: TANGGAL BERADA DI TENGAH --- */
        .flatpickr-day {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            height: 38px !important; /* Tinggi konsisten */
            line-height: normal !important; /* Reset line-height agar flexbox bekerja */
            max-width: none !important; /* Hapus batas lebar default */
        }

        .flatpickr-innerContainer {
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        
        .dayContainer {
            width: 100% !important;
            min-width: 100% !important;
            max-width: 100% !important;
            justify-content: space-around !important;
        }

        /* Header Hijau (Light Mode) */
        .flatpickr-months {
            /* background: #10B981 !important; */
            color: white !important;
            border-top-left-radius: 0.75rem !important;
            border-top-right-radius: 0.75rem !important;
            padding: 10px 0 !important; /* Padding atas bawah seimbang */
            margin-bottom: 0;
            position: relative; /* Penting untuk alignment panah */
        }

        /* --- FIX 3: ALIGNMENT PANAH BULAN (KIRI/KANAN) --- */
        .flatpickr-months .flatpickr-prev-month, 
        .flatpickr-months .flatpickr-next-month {
            color: white !important;
            /* fill: white !important; */
            top: 10% !important;
            height: 30px !important;
            width: 30px !important;
            padding: 0 !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
            position: absolute !important;
        }

        /* Atur Jarak Panah Kiri */
        .flatpickr-months .flatpickr-prev-month {
            left: 15px !important; /* Ubah angka ini untuk mengatur jarak dari kiri */
        }
        
        /* Atur Jarak Panah Kanan */
        .flatpickr-months .flatpickr-next-month {
            right: 15px !important; /* Ubah angka ini untuk mengatur jarak dari kanan */
        }

        /* Teks Bulan & Tahun */
        .flatpickr-current-month {
            padding-top: 0 !important; /* Reset padding agar pas di tengah */
            height: auto !important;
            display: flex !important;
            align-items: center !important;
            justify-content: center !important;
        }
        .flatpickr-current-month .flatpickr-monthDropdown-months {
            background: transparent !important;
            font-weight: bold !important;
            color: inherit !important;
        }
        .flatpickr-current-month input.cur-year {
            font-weight: bold !important;
            color: inherit !important;
        }

        /* Nama Hari */
        span.flatpickr-weekday {
            color: #16a34a !important;
            font-weight: 600 !important;
        }

        /* Selected Day */
        .flatpickr-day.selected, .flatpickr-day.startRange, .flatpickr-day.endRange {
            background: #16a34a !important;
            border-color: #16a34a !important;
        }
        .flatpickr-day.selected:hover {
            background: #059669 !important;
            border-color: #059669 !important;
        }

        input[readonly].flatpickr-input {
            background-color: white !important;
        }

        /* =========================================
        DARK MODE OVERRIDES
        ========================================= */
        
        /* Background Gelap Utama */
        .dark .flatpickr-calendar {
            background: #1f2937 !important;
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.5) !important;
            border: 1px solid #374151 !important;
        }

        /* Header Gelap */
        .dark .flatpickr-months {
            background: #1f2937 !important; 
            color: #f3f4f6 !important;
        }

        /* [FIX 1] Dropdown Bulan Support Dark Mode */
        .dark .flatpickr-current-month .flatpickr-monthDropdown-months {
            background-color: #1f2937 !important; /* Background dropdown gelap */
            color: #f3f4f6 !important; /* Teks putih */
        }

        /* Target option di dalam select juga untuk browser tertentu */
        .dark .flatpickr-current-month .flatpickr-monthDropdown-months option {
            background-color: #1f2937;
            color: #f3f4f6;
        }
        
        /* Warna Text Bulan & Tahun di Dark Mode */
        .dark .flatpickr-current-month .flatpickr-monthDropdown-months,
        .dark .flatpickr-current-month input.cur-year {
            color: #f3f4f6 !important;
        }

        /* Panah Bulan di Dark Mode */
        .dark .flatpickr-months .flatpickr-prev-month, 
        .dark .flatpickr-months .flatpickr-next-month {
            color: #f3f4f6 !important;
            fill: #f3f4f6 !important;
        }
        .dark .flatpickr-months .flatpickr-prev-month:hover svg, 
        .dark .flatpickr-months .flatpickr-next-month:hover svg {
            fill: #10B981 !important;
        }

        /* --- FIX 2: PANAH TAHUN (UP/DOWN) BERWARNA PUTIH --- */
        .dark .flatpickr-current-month .numInputWrapper span.arrowUp:after {
            border-bottom-color: #f3f4f6 !important; /* Segitiga atas putih */
        }
        .dark .flatpickr-current-month .numInputWrapper span.arrowDown:after {
            border-top-color: #f3f4f6 !important; /* Segitiga bawah putih */
        }
        /* Hover effect panah tahun */
        .dark .flatpickr-current-month .numInputWrapper span.arrowUp:hover:after {
            border-bottom-color: #16a34a !important; 
        }
        .dark .flatpickr-current-month .numInputWrapper span.arrowDown:hover:after {
            border-top-color: #16a34a !important;
        }

        /* Nama Hari Gelap */
        .dark span.flatpickr-weekday {
            background: #1f2937 !important;
            color: #9ca3af !important;
        }

        /* Angka Tanggal */
        .dark .flatpickr-day {
            color: #e5e7eb !important;
        }

        .dark .flatpickr-day.prevMonthDay, 
        .dark .flatpickr-day.nextMonthDay {
            color: #6b7280 !important; /* Gray-600 (Lebih gelap) */
            opacity: 0.5 !important; /* Transparansi agar terlihat 'mati' */
        }
        
        /* Hover Tanggal Gelap */
        .dark .flatpickr-day:hover, 
        .dark .flatpickr-day:focus {
            background: #374151 !important;
            border-color: #374151 !important;
        }

        /* Selected Day Tetap Hijau */
        .dark .flatpickr-day.selected {
            background: #16a34a !important; 
            border-color: #16a34a !important;
            color: white !important;
        }

        /* Input Readonly Gelap */
        .dark input[readonly].flatpickr-input {
            background-color: #374151 !important;
            color: white !important;
        }
    </style>

    <style>
        /* =========================================
        CUSTOM DARK MODE UNTUK LIBRARY PIHAK 3
        ========================================= */

        .dark .swal2-popup {
            background-color: #1f2937 !important; /* dark:bg-gray-800 */
            color: #f3f4f6 !important; /* dark:text-gray-100 */
            border: 1px solid #374151; /* dark:border-gray-700 */
        }
        
        .dark .swal2-title {
            color: #f3f4f6 !important;
        }
        
        .dark .swal2-html-container {
            color: #d1d5db !important; /* dark:text-gray-300 */
        }
        
        /* Ubah warna tombol Cancel agar tidak terlalu terang di dark mode */
        .dark .swal2-cancel {
            background-color: #374151 !important; /* dark:bg-gray-700 */
            color: #d1d5db !important;
        }
    </style>

    <script>
        // Cek LocalStorage atau Preferensi Sistem saat halaman dimuat
        if (localStorage.theme === 'dark' || (!('theme' in localStorage) && window.matchMedia('(prefers-color-scheme: dark)').matches)) {
            document.documentElement.classList.add('dark');
        } else {
            document.documentElement.classList.remove('dark');
        }
    </script>
</head>
</head>
<body class="text-gray-800 bg-gray-50 dark:bg-dark-bg dark:text-dark-text transition-colors duration-300">
<div id="appLayout" class="min-h-screen">