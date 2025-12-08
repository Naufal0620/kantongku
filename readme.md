# 💰 KantongKu - Smart Finance for Students

**KantongKu** adalah aplikasi manajemen keuangan berbasis web yang dirancang khusus untuk mahasiswa dan anak kos. Aplikasi ini membantu pengguna mencatat pemasukan dan pengeluaran harian, memantau arus kas melalui grafik interaktif, serta memberikan analisis cerdas mengenai kesehatan finansial pengguna.

Dibangun menggunakan **CodeIgniter 3** dan **Tailwind CSS**, aplikasi ini ringan, cepat, dan responsif di berbagai perangkat (Desktop & Mobile).

---

## ✨ Fitur Unggulan

### 📊 Dashboard Interaktif
* **Ringkasan Saldo:** Pantau total pemasukan, pengeluaran, dan sisa saldo secara *real-time*.
* **Grafik Analisis Mingguan:** Visualisasi data pengeluaran vs pemasukan per minggu menggunakan *Chart.js*.
* **Kalender Keuangan:** Penanda warna pada tanggal (Hijau = Hemat, Merah = Boros).
* **Analisis Cerdas:** Prediksi "Burn Rate" untuk mengetahui berapa lama sisa saldo akan bertahan.

### 💸 Manajemen Transaksi
* **Pencatatan Mudah:** Input transaksi dengan validasi nominal (Maks Rp 100 Juta) dan tanggal via *Flatpickr*.
* **Keamanan Input:** Dilengkapi fitur *XSS Filtering* dan *Output Escaping* untuk mencegah script injection.
* **Loading State:** Indikator visual saat menyimpan data untuk mencegah duplikasi input.

### 🏷️ Manajemen Kategori
* **Kustomisasi Penuh:** Tambah kategori baru dengan pilihan ikon (*FontAwesome*) dan warna tema sendiri.
* **Pemisahan Tipe:** Kategori terpisah antara Pemasukan dan Pengeluaran.

### 👤 Profil & Keamanan
* **Avatar Unik:** Integrasi dengan API *DiceBear* untuk generate avatar kartun secara acak.
* **Keamanan Akun:** Enkripsi password menggunakan `password_hash` (Bcrypt).
* **Mode Gelap (Dark Mode):** Mendukung tampilan gelap mengikuti preferensi sistem (via Tailwind).

---

## 🛠️ Teknologi yang Digunakan

* **Backend:** CodeIgniter 3 (PHP Framework)
* **Frontend:** Tailwind CSS (via CDN), HTML5
* **Database:** MySQL
* **Libraries & Tools:**
    * [Chart.js](https://www.chartjs.org/) - Untuk grafik statistik.
    * [SweetAlert2](https://sweetalert2.github.io/) - Untuk notifikasi dan konfirmasi yang cantik.
    * [Flatpickr](https://flatpickr.js.org/) - Untuk input tanggal yang modern.
    * [FontAwesome 6](https://fontawesome.com/) - Untuk ikon antarmuka.
    * [DiceBear API](https://www.dicebear.com/) - Untuk avatar pengguna.

---

Dibuat dengan ❤️ oleh PSIK 25 A Kelompok 6 Kalkulus Diferensial