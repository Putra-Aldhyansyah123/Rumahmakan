<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">
    <!-- FontAwesome CSS -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css">
</head>

<body>
    <div class="container-fluid">
        <!-- Page Heading -->
        <div class="card mb-4 mx-4 mt-3">
            <div class="card-header">
                <a href="<?php echo site_url('admin/daftar_menu/') ?>"><i class="fas fa-arrow-left"></i>
                    <strong>Back</strong></a>
            </div>
        </div>
        <div class="card-body">
            <form action="<?php echo site_url('admin/update_menu_proses/' . $menu['id_menu']); ?>" method="post" enctype="multipart/form-data">
                <input type="hidden" name="id_menu" value="<?php echo $menu['id_menu']; ?>">
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">Nama</span>
                        </div>
                        <input type="text" id="nama_menu" name="nama_menu" class="form-control" value="<?php echo $menu['nama_menu']; ?>" required>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="input-group">
                        <div class="input-group-prepend">
                            <span class="input-group-text bg-primary text-white">Harga</span>
                        </div>
                        <input type="number" name="harga" id="harga" class="form-control" value="<?php echo $menu['harga']; ?>" required>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="input-group">
                        <select name="jenis_menu" id="jenis_menu" class="form-control" required>
                            <option value="Makanan" <?php echo ($menu['jenis_menu'] == 'Makanan') ? 'selected' : ''; ?>>Makanan</option>
                            <option value="Snack" <?php echo ($menu['jenis_menu'] == 'Snack') ? 'selected' : ''; ?>>Snack</option>
                            <option value="Minuman Dingin" <?php echo ($menu['jenis_menu'] == 'Minuman Dingin') ? 'selected' : ''; ?>>Minuman Dingin</option>
                            <option value="Minuman Panas" <?php echo ($menu['jenis_menu'] == 'Minuman Panas') ? 'selected' : ''; ?>>Minuman Panas</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <div class="input-group">
                        <select name="status" id="status" class="form-control" required>
                            <option value="Tersedia" <?php echo ($menu['status'] == 'Tersedia') ? 'selected' : ''; ?>>Tersedia</option>
                            <option value="Habis" <?php echo ($menu['status'] == 'Habis') ? 'selected' : ''; ?>>Habis</option>
                            <option value="sedang di masak" <?php echo ($menu['status'] == 'sedang di masak') ? 'selected' : ''; ?>>Sedang di masak</option>
                        </select>
                    </div>
                </div>
                <br>
                <div class="form-group">
                    <label for="gambar">Gambar</label>
                    <input type="file" name="gambar" id="gambar" class="form-control-file">
                    <?php if (!empty($menu['gambar'])) { ?>
                        <br>
                        <img src="<?php echo base_url('assets_5/uploads/' . $menu['gambar']); ?>" alt="<?php echo $menu['nama_menu']; ?>" style="max-width: 150px; margin-top: 10px;">
                    <?php } ?>
                </div>
                <br>
                <div class="form-group">
                    <button type="submit" class="btn btn-danger">Simpan</button>
                </div>
            </form>
        </div>
    </div>

    <!-- jQuery -->
    <script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
    <!-- Bootstrap JS -->
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
</body>

</html>
