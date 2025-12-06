<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Tambah Kategori</h1>
        <a href="<?= base_url('kategori'); ?>" class="btn btn-sm btn-secondary shadow-sm">Kembali</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="" method="post">
                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" name="name" class="form-control" required placeholder="Contoh: Belanja">
                        </div>
                        <div class="form-group">
                            <label>Jenis</label>
                            <select name="type" class="form-control">
                                <option value="expense">Pengeluaran</option>
                                <option value="income">Pemasukan</option>
                            </select>
                        </div>
                        <div class="form-group">
                            <label>Ikon (FontAwesome)</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">fa-</span></div>
                                <input type="text" name="icon" class="form-control" value="circle" placeholder="utensils">
                            </div>
                        </div>
                        <div class="form-group">
                            <label>Warna</label>
                            <select name="color" class="form-control">
                                <option value="bg-gray-100 text-gray-600">Abu-abu</option>
                                <option value="bg-orange-100 text-orange-600">Orange</option>
                                <option value="bg-blue-100 text-blue-600">Biru</option>
                                <option value="bg-indigo-100 text-indigo-600">Indigo</option>
                                <option value="bg-pink-100 text-pink-600">Pink</option>
                                <option value="bg-purple-100 text-purple-600">Ungu</option>
                                <option value="bg-yellow-100 text-yellow-600">Kuning</option>
                                <option value="bg-green-100 text-green-600">Hijau</option>
                                <option value="bg-teal-100 text-teal-600">Teal</option>
                                <option value="bg-red-100 text-red-600">Merah</option>
                            </select>
                        </div>
                        <button type="submit" class="btn btn-primary">Simpan</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>