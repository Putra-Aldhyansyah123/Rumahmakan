<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Tambah Menu</title>
    <link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
    <link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
</head>
<body>
<div class="container-fluid">
    <div class="card mb-4 mx-4 mt-3">
        <div class="card-header">
            <a href="<?php echo site_url('admin/daftar_menu/') ?>"><i class="fas fa-arrow-left"></i> <strong>Back</strong></a>
        </div>
    </div>
    
    <div class="card-body">
        <?php if($this->session->flashdata('error')): ?>
            <div class="alert alert-danger"><?php echo $this->session->flashdata('error'); ?></div>
        <?php endif; ?>
        <form action="<?php echo site_url('admin/tambah_menu_proses') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white">Nama</span>
                    </div>
                    <input type="text" id="nama_menu" name="nama_menu" class="form-control" aria-label="Nama Menu" required>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white">Harga</span>
                    </div>
                    <input type="number" name="harga" id="harga" class="form-control" aria-label="Harga Menu" required>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="input-group">
                    <select name="jenis_menu" id="jenis_menu" class="form-control" required>
                        <option value="Makanan">Makanan</option>
                        <option value="Snack">Snack</option>
                        <option value="Minuman Dingin">Minuman Dingin</option>
                        <option value="Minuman Panas">Minuman Panas</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="input-group">
                    <select name="status" id="status" class="form-control" required>
                        <option value="Tersedia">Tersedia</option>
                        <option value="Habis">Habis</option>
                        <option value="Sedang di masak">Sedang di masak</option>
                    </select>
                </div>
            </div>
            <br>
            <div class="form-group">
                <label for="gambar">Gambar</label>
                <input type="file" name="gambar" id="gambar" class="form-control-file" required>
            </div>
            <br>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>
</html>
