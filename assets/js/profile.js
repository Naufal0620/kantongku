/**
 * Script Khusus Halaman Profil (Updated)
 */

// 1. Trigger Input File saat tombol "Upload Foto" diklik
function triggerFileUpload() {
    document.getElementById('fileInput').click();
}

// 2. Preview File Upload (Lokal)
function previewUploadedFile(event) {
    const file = event.target.files[0];
    if(file){
        // Buat URL objek sementara untuk preview
        const objectUrl = URL.createObjectURL(file);
        document.getElementById('avatarPreview').src = objectUrl;
        
        // Set Mode ke 'file' agar controller tahu kita mau upload
        document.getElementById('avatarMode').value = 'file';
    }
}

// 3. Fungsi Acak Avatar (DiceBear API)
function randomizeAvatar() {
    // Reset input file (jika user sebelumnya memilih file, kita batalkan)
    document.getElementById('fileInput').value = "";

    // Generate seed baru
    const randomSeed = Math.random().toString(36).substring(7);
    
    // Update tampilan gambar
    const imgElement = document.getElementById('avatarPreview');
    imgElement.src = `https://api.dicebear.com/7.x/avataaars/svg?seed=${randomSeed}`;
    
    // Update nilai input hidden seed
    document.getElementById('inputAvatarSeed').value = randomSeed;
    
    // Set Mode ke 'seed' agar controller tahu kita mau pakai avatar kartun
    document.getElementById('avatarMode').value = 'seed';
}

// 4. Fungsi Konfirmasi Logout (Tetap Sama)
function confirmLogout() {
    if (typeof Swal !== 'undefined') {
        Swal.fire({
            title: 'Yakin ingin keluar?',
            text: "Sesi Anda akan diakhiri.",
            icon: 'warning',
            showCancelButton: true,
            confirmButtonColor: '#EF4444', 
            cancelButtonColor: '#6B7280', 
            confirmButtonText: 'Ya, Keluar!',
            cancelButtonText: 'Batal'
        }).then((result) => {
            if (result.isConfirmed) {
                showLoading(); 
                window.location.href = PROFILE_URLS.logout;
            }
        });
    } else {
        if (confirm("Yakin ingin keluar aplikasi?")) {
            showLoading(); 
            window.location.href = PROFILE_URLS.logout;
        }
    }
}