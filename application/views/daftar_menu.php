<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Data Menu</title>
    <!-- Bootstrap 3 CSS -->
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/css/bootstrap.min.css">
    <!-- Font Awesome CSS for icons -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
</head>
<body>

<div class="container-fluid">
    <!-- Page Heading -->
    <div class="panel panel-default mb-4 mx-4 mt-3">
        <div class="panel-heading">
            <a href="<?php echo site_url('Admin/tambah_menu')?>" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> <strong>Tambah daftar menu</strong>
            </a>
        </div>
        <div class="panel-body">
            <div class="table-responsive">
                <table class="table table-hover table-light" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th><strong>Nama Menu</strong></th>
                            <th><strong>Gambar</strong></th>
                            <th><strong>Harga</strong></th>
                            <th><strong>Jenis Menu</strong></th>
                            <th><strong>Status</strong></th>
                            <th><strong>Aksi</strong></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($menu)): ?>
                            <?php foreach ($menu as $m): ?>
                                <tr>
                                    <td><?php echo $m['nama_menu']; ?></td>
                                    <td><img src='<?php echo base_url('assets_2/uploads/'. $m['gambar']);?>' width="50" height="50"></td>
                                    <td><?php echo number_format($m['harga'], 2, ',', '.'); ?></td>
                                    <td><?php echo $m['jenis_menu']; ?></td>
                                    <td><?php echo $m['status']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/edit_menu/'. $m['id_menu']); ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i> Edit
                                        </a><br><br>
                                        <button type="button" class="btn btn-danger btn-sm" data-toggle="modal" data-target="#deleteModal<?= $m['id_menu']; ?>">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal<?= $m['id_menu']; ?>" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog" role="document">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h4 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h4>
                                                        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                                                            <span aria-hidden="true">&times;</span>
                                                        </button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus menu ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-dismiss="modal">Batal</button>
                                                        <a href="<?php echo site_url('Tugas_uts/delete_menu/'. $m['id_menu']); ?>" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-trash"></i> Hapus
                                                        </a><br>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </td>
                                </tr>
                            <?php endforeach; ?>
                        <?php else: ?>
                            <tr>
                                <td colspan="6">No data available</td>
                            </tr>
                        <?php endif; ?>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

<!-- jQuery -->
<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
<!-- Bootstrap 3 JS -->
<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.4.1/js/bootstrap.min.js"></script>

<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>

</body>
</html>
