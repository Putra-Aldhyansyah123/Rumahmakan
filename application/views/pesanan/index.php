<!-- Bootstrap CSS -->
<link href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css" rel="stylesheet">
<!-- DataTables CSS -->
<link href="https://cdn.datatables.net/1.10.21/css/dataTables.bootstrap4.min.css" rel="stylesheet">
<!-- FontAwesome -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.1/css/all.min.css" rel="stylesheet">
<div class="page-wrapper mdc-toolbar-fixed-adjust">
    <div class="container">
    <h1 class="page-header">Dashboard Pesanan</h1>
        <table id="pesananTable" class="table table-striped">
            <thead>
                <tr>
                    <th>No Faktur Jual</th>
                    <th>Nama Pelanggan</th>
                    <th>Tanggal</th>
                    <th>Total Harga</th>
                    <th>Aksi</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($pesanan as $p): ?>
                <tr>
                    <td><?php echo $p->no_faktur_jual; ?></td>
                    <td><?php echo $p->nama_pelanggan; ?></td>
                    <td><?php echo $p->tanggal; ?></td>
                    <td><?php echo $p->total; ?></td>
                    <td><a href="<?php echo site_url('admin/detail/'.$p->no_faktur_jual); ?>" class="btn btn-primary btn-sm">Detail</a></td>
                </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <br>
                <tr>
                <a href="<?php echo site_url('admin/index_list'); ?>" class="btn btn-primary">Detail</a>
                </tr>
            </tfoot>
        </table>
    </div>
    <script src="<?php echo base_url('assets/js/jquery.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script src="<?php echo base_url('assets/js/datatables.min.js'); ?>"></script>
    <script>
        $(document).ready(function() {
            $('#pesananTable').DataTable();
        });
    </script>

