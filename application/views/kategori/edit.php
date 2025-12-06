<div class="container-fluid">

    <div class="d-sm-flex align-items-center justify-content-between mb-4">
        <h1 class="h3 mb-0 text-gray-800">Edit Kategori</h1>
        <a href="<?= base_url('kategori'); ?>" class="btn btn-sm btn-secondary shadow-sm">Kembali</a>
    </div>

    <div class="row">
        <div class="col-lg-8">
            <div class="card shadow mb-4">
                <div class="card-body">
                    <form action="" method="post">

                        <div class="form-group">
                            <label>Nama Kategori</label>
                            <input type="text" name="name" class="form-control" value="<?= $kategori['name']; ?>" required>
                        </div>

                        <div class="form-group">
                            <label>Jenis</label>
                            <select name="type" class="form-control">
                                <option value="expense" <?= ($kategori['type'] == 'expense') ? 'selected' : '' ?>>Pengeluaran</option>
                                <option value="income" <?= ($kategori['type'] == 'income') ? 'selected' : '' ?>>Pemasukan</option>
                            </select>
                        </div>

                        <div class="form-group">
                            <label>Ikon</label>
                            <div class="input-group">
                                <div class="input-group-prepend"><span class="input-group-text">fa-</span></div>
                                <input type="text" name="icon" class="form-control" value="<?= $kategori['icon']; ?>">
                            </div>
                        </div>

                        <div class="form-group">
                            <label>Warna</label>
                            <select name="color" class="form-control">
                                <?php 
                                $colors = [
                                    "bg-gray-100 text-gray-600" => "Abu-abu",
                                    "bg-orange-100 text-orange-600" => "Orange",
                                    "bg-blue-100 text-blue-600" => "Biru",
                                    "bg-indigo-100 text-indigo-600" => "Indigo",
                                    "bg-pink-100 text-pink-600" => "Pink",
                                    "bg-purple-100 text-purple-600" => "Ungu",
                                    "bg-yellow-100 text-yellow-600" => "Kuning",
                                    "bg-green-100 text-green-600" => "Hijau",
                                    "bg-teal-100 text-teal-600" => "Teal",
                                    "bg-red-100 text-red-600" => "Merah"
                                ];
                                foreach($colors as $val => $label): ?>
                                    <option value="<?= $val ?>" <?= ($kategori['color'] == $val) ? 'selected' : '' ?>><?= $label ?></option>
                                <?php endforeach; ?>
                            </select>
                        </div>

                        <button type="submit" class="btn btn-success">Update Data</button>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>