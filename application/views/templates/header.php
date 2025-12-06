<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= $title; ?></title>
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
            }
        }
    </script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css">
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

        /* PERBAIKAN: Toggle Switch Animation */
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
    </style>
</head>
<body class="text-gray-800 bg-gray-50 dark:bg-dark-bg dark:text-dark-text transition-colors duration-300">
<div id="appLayout" class="min-h-screen">