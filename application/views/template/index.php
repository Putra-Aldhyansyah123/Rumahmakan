<div class="page-wrapper mdc-toolbar-fixed-adjust">
    <main class="content-wrapper">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <!-- Recent Transactions Table -->
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6">
                    <div class="mdc-card">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="glyphicon glyphicon-sort"></i> Data Pesanan</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama</th>
                                        <th>Tanggal Pesanan</th>
                                        <th>Jumlah</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($pesanan as $t): ?>
                                    <tr>
                                        <td><?= $t->nama_pelanggan ?></td>
                                        <td><?= date('d/m/Y', strtotime($t->tanggal)) ?></td>
                                        <td>Rp. <?= number_format($t->total) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="text-right">
                                <a href="<?= base_url().'admin/pesanan' ?>">Lihat Semua pesanan <i class="glyphicon glyphicon-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Nama Menu Section -->
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6">
                    <div class="mdc-card">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> Daftar Menu</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Nama Menu</th>
                                        <th>Harga</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($menu as $m): ?>
                                    <tr>
                                        <td><?= $m['nama_menu'] ?></td>
                                        <td>Rp. <?= number_format($m['harga']) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                            <div class="text-right">
                                <a href="<?= base_url().'admin/daftar_menu' ?>">Lihat Semua daftar menu <i class="glyphicon glyphicon-arrow-right"></i></a>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other sections omitted for brevity -->
            </div>
        </div>
    </main>
</div>
