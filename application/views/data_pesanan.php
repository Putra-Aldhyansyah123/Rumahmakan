<div class="container-fluid">
    <!-- Page Heading -->
    <div class="card mb-4 mx-4 mt-3">
        <div class="card-header">
            <a href="<?php echo site_url('Tugas_uts/tambah_karyawan') ?>" class="btn btn-success btn-sm">
                <i class="fas fa-plus"></i> <strong>Tambah daftar menu</strong>
            </a>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-hover table-light" id="dataTable" width="100%" cellspacing="0">
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>Nama</th>
                            <th>Alamat</th>
                            <th>Jenis Kelamin</th>
                            <th>No HP</th>
                            <th>No KTP</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php if (!empty($customers)): ?>
                            <?php foreach ($customers as $customer): ?>
                                <tr>
                                    <td><?= $customer['customer_id']; ?></td>
                                    <td><?= $customer['customer_nama']; ?></td>
                                    <td><?= $customer['customer_alamat']; ?></td>
                                    <td><?= $customer['customer_jk']; ?></td>
                                    <td><?= $customer['customer_hp']; ?></td>
                                    <td><?= $customer['customer_ktp']; ?></td>
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
