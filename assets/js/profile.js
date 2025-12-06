/**
 * Script Khusus Halaman Profil
 */

// 1. Fungsi Acak Avatar (DiceBear API)
function randomizeAvatar() {
    // Buat string random 5 karakter
    const randomSeed = Math.random().toString(36).substring(7);
    
    // Update tampilan gambar
    const imgElement = document.getElementById('avatarPreview');
    imgElement.src = `https://api.dicebear.com/7.x/avataaars/svg?seed=${randomSeed}`;
    
    // Update nilai input hidden agar tersimpan ke database
    document.getElementById('inputAvatar').value = randomSeed;
}

// 2. Fungsi Konfirmasi Logout (Menggunakan SweetAlert2 jika ada, atau confirm biasa)
function confirmLogout() {
    // Cek apakah SweetAlert2 tersedia (dari footer)
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: "Sesi Anda akan diakhiri.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444', // Red
            cancelButtonColor: '#6B7280', // Gray
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                window.location.href = PROFILE_URLS.logout;
            }
        });
    } else {
        // Fallback jika SweetAlert tidak diload
        if (confirm("Yakin ingin keluar aplikasi?")) {
            window.location.href = PROFILE_URLS.logout;
        }
    }
}