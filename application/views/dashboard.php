<div class="page-wrapper mdc-toolbar-fixed-adjust">
    <main class="content-wrapper">
        <div class="mdc-layout-grid">
            <div class="mdc-layout-grid__inner">
                <!-- Welcome Message -->
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                    <div class="mdc-card">
                        <div class="card-inner">
                            <h5 class="card-title">Selamat Datang, <?= $nama_pelanggan ?></h5>
                            <p class="tx-12 text-muted">Berikut adalah ringkasan aktivitas Anda.</p>
                        </div>
                    </div>
                </div>

                <!-- Pesanan Terbaru Section -->
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6">
                    <div class="mdc-card">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="glyphicon glyphicon-sort"></i> Pesanan Terbaru</h3>
                        </div>
                        <div class="panel-body">
                            <table class="table table-bordered table-hover table-striped">
                                <thead>
                                    <tr>
                                        <th>Tanggal Pesanan</th>
                                        <th>Jumlah</th>
                                        <th>Status</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php foreach($pesanan_terbaru as $p): ?>
                                    <tr>
                                        <td><?= date('d/m/Y', strtotime($p->tanggal)) ?></td>
                                        <td>Rp. <?= number_format($p->total) ?></td>
                                        <td><?= $p->status ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Rekomendasi Menu Section -->
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-6">
                    <div class="mdc-card">
                        <div class="panel-heading">
                            <h3 class="panel-title"><i class="glyphicon glyphicon-list"></i> Rekomendasi Menu</h3>
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
                                    <?php foreach($rekomendasi_menu as $r): ?>
                                    <tr>
                                        <td><?= $r['nama_menu'] ?></td>
                                        <td>Rp. <?= number_format($r['harga']) ?></td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <!-- Statistik Pelanggan Section -->
                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-12">
                    <div class="mdc-card">
                        <div class="card-inner">
                            <h5 class="card-title">Statistik Pelanggan</h5>
                            <div class="mdc-layout-grid__inner">
                                <!-- Example of Statistic Cards -->
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3">
                                    <div class="mdc-card info-card info-card--success">
                                        <div class="card-inner">
                                            <h5 class="card-title">Total Pesanan</h5>
                                            <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?= $total_pesanan ?></h5>
                                            <div class="card-icon-wrapper">
                                                <i class="material-icons">shopping_cart</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3">
                                    <div class="mdc-card info-card info-card--danger">
                                        <div class="card-inner">
                                            <h5 class="card-title">Total Pengeluaran</h5>
                                            <h5 class="font-weight-light pb-2 mb-1 border-bottom">Rp. <?= number_format($total_pengeluaran) ?></h5>
                                            <div class="card-icon-wrapper">
                                                <i class="material-icons">attach_money</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3">
                                    <div class="mdc-card info-card info-card--primary">
                                        <div class="card-inner">
                                            <h5 class="card-title">Menu Favorit</h5>
                                            <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?= $menu_favorit ?></h5>
                                            <div class="card-icon-wrapper">
                                                <i class="material-icons">favorite</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div class="mdc-layout-grid__cell stretch-card mdc-layout-grid__cell--span-3">
                                    <div class="mdc-card info-card info-card--info">
                                        <div class="card-inner">
                                            <h5 class="card-title">Poin</h5>
                                            <h5 class="font-weight-light pb-2 mb-1 border-bottom"><?= $poin ?></h5>
                                            <div class="card-icon-wrapper">
                                                <i class="material-icons">star</i>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Other sections omitted for brevity -->
            </div>
        </div>
    </main>
</div>
