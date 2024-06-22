<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- FontAwesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
<div class="page-wrapper mdc-toolbar-fixed-adjust">
    <!-- Page Heading -->
    <div class="card mb-4 mx-4 mt-3">
        <div class="card-header">
            <a href="<?php echo site_url('Admin/tambah_menu') ?>" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> <strong>Tambah daftar menu</strong>
            </a>
        </div>
        <div class="card-body">
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
                                    <td>
                                        <img src="<?php echo base_url('assets_5/uploads/' . $m['gambar']); ?>" width="50" height="50" onerror="this.onerror=null;this.src='<?php echo base_url('assets_5/uploads/default_image.png'); ?>';">
                                    </td>
                                    <td><?php echo number_format($m['harga'], 2, ',', '.'); ?></td>
                                    <td><?php echo $m['jenis_menu']; ?></td>
                                    <td><?php echo $m['status']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/edit_menu/' . $m['id_menu']); ?>" class="btn btn-warning btn-sm">
                                            <i class="fas fa-edit"></i>Edit
                                        </a>
                                        <button type="button" class="btn btn-danger btn-sm" data-bs-toggle="modal" data-bs-target="#deleteModal<?= $m['id_menu']; ?>">
                                            <i class="fas fa-trash"></i> Hapus
                                        </button>
                                        <!-- Modal -->
                                        <div class="modal fade" id="deleteModal<?= $m['id_menu']; ?>" tabindex="-1" aria-labelledby="exampleModalLabel" aria-hidden="true">
                                            <div class="modal-dialog">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title" id="exampleModalLabel">Konfirmasi Hapus</h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        Apakah Anda yakin ingin menghapus menu ini?
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                                                        <a href="<?php echo site_url('Tugas_uts/delete_menu/' . $m['id_menu']); ?>" class="btn btn-danger btn-sm">
                                                            <i class="fas fa-hapus"></i>Hapus
                                                        </a>
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
<script src="https://code.jquery.com/jquery-3.5.1.min.js"></script>
<!-- DataTables JS -->
<script src="https://cdn.datatables.net/1.10.21/js/jquery.dataTables.min.js"></script>
<script src="https://cdn.datatables.net/1.10.21/js/dataTables.bootstrap4.min.js"></script>
<!-- Bootstrap JS -->
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/js/bootstrap.min.js"></script>
<script>
    $(document).ready(function() {
        $('#dataTable').DataTable();
    });
</script>
