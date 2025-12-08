$(document).ready(function() {
    // --- LOGIKA LOGIN ---
    $('#formLogin').on('submit', function(e) {
        e.preventDefault();
        const btn = $('#btnLogin');
        const originalText = btn.html();
        
        btn.html('<i class="fas fa-spinner fa-spin"></i> Loading...').prop('disabled', true);

        $.ajax({
            url: BASE_URL + 'auth/process_login',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Login Berhasil!',
                        text: response.message,
                        timer: 1500,
                        showConfirmButton: false
                    }).then(() => {
                        window.location.href = response.redirect_url;
                    });
                } else {
                    Swal.fire({ icon: 'error', title: 'Gagal', html: response.message });
                    btn.html(originalText).prop('disabled', false);
                }
            },
            error: function() {
                Swal.fire({ icon: 'error', title: 'Error', text: 'Terjadi kesalahan server.' });
                btn.html(originalText).prop('disabled', false);
            }
        });
    });

    // --- LOGIKA REGISTER ---
    $('#formRegister').on('submit', function(e) {
        e.preventDefault(); // Mencegah reload halaman

        const btn = $('#btnRegister');
        const originalText = btn.html();

        // Ubah tombol jadi loading
        btn.html('<i class="fas fa-spinner fa-spin"></i> Memproses...').prop('disabled', true);

        $.ajax({
            url: BASE_URL + 'auth/process_register',
            type: 'POST',
            data: $(this).serialize(),
            dataType: 'json',
            success: function(response) {
                if (response.status === 'success') {
                    Swal.fire({
                        icon: 'success',
                        title: 'Registrasi Berhasil!',
                        text: response.message,
                        confirmButtonText: 'Login Sekarang'
                    }).then((result) => {
                        if (result.isConfirmed || result.isDismissed) {
                            window.location.href = response.redirect_url;
                        }
                    });
                } else {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Periksa Data',
                        html: response.message
                    });
                    btn.html(originalText).prop('disabled', false);
                }
            },
            error: function(xhr, status, error) {
                Swal.fire({
                    icon: 'error',
                    title: 'Server Error',
                    text: 'Gagal menghubungi server.'
                });
                btn.html(originalText).prop('disabled', false);
            }
        });
    });

});