/**
 * Script Khusus Halaman Pengaturan (Dark Mode)
 */

document.addEventListener('DOMContentLoaded', function() {
    
    const toggleBtn = document.getElementById('darkModeToggle');
    const htmlTag = document.documentElement;

    // 1. Set Posisi Awal Tombol (Sync dengan kondisi saat ini)
    if (htmlTag.classList.contains('dark')) {
        toggleBtn.checked = true;
    } else {
        toggleBtn.checked = false;
    }

    // 2. Event Listener saat tombol diklik
    toggleBtn.addEventListener('change', function() {
        if (this.checked) {
            // Aktifkan Dark Mode
            htmlTag.classList.add('dark');
            localStorage.theme = 'dark';
            console.log('Mode Gelap: Aktif');
        } else {
            // Matikan Dark Mode
            htmlTag.classList.remove('dark');
            localStorage.theme = 'light';
            console.log('Mode Gelap: Nonaktif');
        }
    });

});