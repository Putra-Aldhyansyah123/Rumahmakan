<div class="row">
    <div class="col-lg-6 grid-margin">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pelanggan</h4>
                <p class="card-description">
                    Meja yang memiliki pesanan belum dihidangkan.
                </p>
                <div class="table-responsive">
                    <table class="table">
                        <thead>
                            <tr>
                                <th>Meja</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Ubah</th>
                            </tr>
                        </thead>
                        <tbody id="tabelAntrian">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
    <div class="col-lg-6 grid-margin stretch-card">
        <div class="card">
            <div class="card-body">
                <h4 class="card-title">Data Pelanggan Selesai</h4>
                <p class="card-description">
                    Pesanan pelanggan yang sudah dihidangkan hari ini.
                </p>
                <div class="table-responsive">
                    <table class="table table-hover">
                        <thead>
                            <tr>
                                <th>Meja</th>
                                <th>Nama</th>
                                <th>Status</th>
                                <th>Rincian</th>
                            </tr>
                        </thead>
                        <tbody id="tabelAntrianSelesai">
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
<!-- Modal -->
<div class="modal fade" id="modalRincian" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title" id="exampleModalLabel">Data Pesanan</h5>
            </div>
            <div class="modal-body p-0">
                <div class="row">
                    <div class="col-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning text-white">Nama</span>
                                </div>
                                <input type="text" id="nama_pelanggan" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                    </div>
                    <div class="col-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning text-white">No Meja</span>
                                </div>
                                <input type="number" id="no_Meja" class="form-control" disabled aria-label="Amount (to the nearest dollar)">
                            </div>
                        </div>
                    </div>
                </div>

                <table class="table text-center bg-white" id="dataTable">
                    <thead>
                        <tr>
                            <th>Nama</th>
                            <th>Jml</th>
                            <th>Harga</th>
                            <th>Total</th>
                        </tr>
                    </thead>
                    <tbody id="tabelRincian">
                        <td colspan="5">Memuat data....</td>
                    </tbody>
                </table>
                <div class="row">
                    <div class="col-3"></div>
                    <div class="col-6">
                        <div class="form-group">
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <span class="input-group-text bg-warning text-white">Rp.</span>
                                </div>
                                <input type="number" id="jumlah" class="form-control" disabled aria-label="Amount (to the nearest dollar)" disabled>
                            </div>
                        </div>
                    </div>
                    <div class="col-3"></div>
                </div>
            </div>
            <div class="modal-footer">
                <input type="hidden" id="idTransaksi">
                <input type="hidden" id="statusTransaksi">
                <button type="button" class="btn btn-secondary" onclick="tutupModalRincian()">Tutup</button>
                <button type="button" class="btn btn-warning" onclick="proses()" id="proses">Bayar</button>
            </div>
        </div>
    </div>
</div>
<script>
    // Fungsi untuk memuat data antrian
    function loadAntrian() {
        $.ajax({
            url: '<?php echo base_url("admin/dataAntrian"); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var tableContent = '';
                data.forEach(function(row) {
                    tableContent += '<tr>';
                    tableContent += '<td>' + row.noMeja + '</td>';
                    tableContent += '<td>' + row.nama + '</td>';
                    tableContent += '<td>' + (row.status == 1 ? 'Diproses' : 'Belum Diproses') + '</td>';
                    tableContent += '<td><button class="btn btn-warning" onclick="proses(' + row.id + ', ' + row.status + ')">Ubah</button></td>';
                    tableContent += '</tr>';
                });
                $('#tabelAntrian').html(tableContent);
            }
        });
    }

    // Fungsi untuk memuat data antrian yang sudah selesai
    function loadAntrianSelesai() {
        $.ajax({
            url: '<?php echo base_url("admin/dataAntrianSelesai"); ?>',
            method: 'GET',
            dataType: 'json',
            success: function(data) {
                var tableContent = '';
                data.forEach(function(row) {
                    tableContent += '<tr>';
                    tableContent += '<td>' + row.noMeja + '</td>';
                    tableContent += '<td>' + row.nama + '</td>';
                    tableContent += '<td>' + 'Selesai' + '</td>';
                    tableContent += '<td><button class="btn btn-info" onclick="rincianPesanan(' + row.id + ')">Rincian</button></td>';
                    tableContent += '</tr>';
                });
                $('#tabelAntrianSelesai').html(tableContent);
            }
        });
    }

    // Fungsi untuk memproses perubahan status
    function proses(id, status) {
        $.ajax({
            url: '<?php echo base_url("admin/proses"); ?>',
            method: 'POST',
            data: { idTransaksi: id, statusTransaksi: status },
            dataType: 'json',
            success: function() {
                loadAntrian();
                loadAntrianSelesai();
            }
        });
    }

    // Fungsi untuk memuat rincian pesanan
    function rincianPesanan(idAntrian) {
        $.ajax({
            url: '<?php echo base_url("admin/rincianPesanan"); ?>',
            method: 'POST',
            data: { idAntrian: idAntrian },
            dataType: 'json',
            success: function(data) {
                var tableContent = '';
                var total = 0;
                data.forEach(function(row) {
                    tableContent += '<tr>';
                    tableContent += '<td>' + row.nama + '</td>';
                    tableContent += '<td>' + row.jml + '</td>';
                    tableContent += '<td>' + row.harga + '</td>';
                    tableContent += '<td>' + (row.jml * row.harga) + '</td>';
                    tableContent += '</tr>';
                    total += row.jml * row.harga;
                });
                $('#tabelRincian').html(tableContent);
                $('#jumlah').val(total);
                $('#modalRincian').modal('show');
            }
        });
    }

    $(document).ready(function() {
        loadAntrian();
        loadAntrianSelesai();
    });
</script>

