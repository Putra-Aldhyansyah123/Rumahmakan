<div class="container-fluid">
    <!-- Page Heading -->
    <div class="card mb-4 mx-4 mt-3">
        <div class="card-header">
            <a href="<?php echo site_url('./admin/daftar_menu/') ?>"><i class="fas fa-arrow-left"></i>
                <strong>Back</strong></a>
        </div>
    </div>
    <div class="card-body">
        <form action="<?php echo site_url('Admin/tambah_menu_proses') ?>" method="post" enctype="multipart/form-data">
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white">Nama</span>
                    </div>
                    <input type="text" id="nama_menu" name="nama_menu" class="form-control" aria-label="Amount (to the nearest dollar)">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="input-group">
                    <div class="input-group-prepend">
                        <span class="input-group-text bg-primary text-white">Harga</span>
                    </div>
                    <input type="number" name="harga" id="harga" class="form-control" aria-label="Amount (to the nearest dollar)">
                </div>
            </div>
            <br>
            <div class="form-group">
                <div class="input-group">
                    <select name="jenis_menu" id="jenis_menu" class="form-control">
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
                    <select name="status" id="status" class="form-control">
                        <option value="Tersedia">Tersedia</option>
                        <option value="Habis">Habis</option>
                        <option value="sedang di masak">sedang di masak</option>
                    </select>
                </div>
            </div>

            <div class="form-group">
                <button type="submit" class="btn btn-primary">Simpan</button>
            </div>
        </form>
    </div>
</div>