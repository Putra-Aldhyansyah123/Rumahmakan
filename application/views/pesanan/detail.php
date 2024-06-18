<!DOCTYPE html>
<html>
<head>
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
</head>
<body>
    <div class="container">
        <h1 class="page-header">Detail Pesanan</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>Nama Menu</th>
                    <th>Harga</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($detail as $d): ?>
                <tr>
                    <td><?php echo $d->nama_menu; ?></td>
                    <td><?php echo $d->harga; ?></td>
                    <td><?php echo $d->jumlah; ?></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <br>
        <a href="<?php echo site_url('admin/index'); ?>" class="btn btn-default">Kembali</a>
    </div>
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
</body>
</html>
