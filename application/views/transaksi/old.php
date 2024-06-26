
<!-- old -->
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Transaksi</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/bootstrap.min.css'); ?>">
</head>

<body>
    <div class="container-fluid">
        <div class="card mb-4 mx-4 mt-3">
            <div class="card-header">
                <h2>Menu</h2>
            </div>
        </div>
        <div class="card-body">
            <div class="row">
                <?php foreach ($menu as $item) : ?>
                    <div class="col-md-3">
                        <div class="card mb-4">
                            <table>
                                <tr>
                                    <td><img src='<?php echo base_url('./assets_2/uploads/' . $item['gambar']); ?>' width="200" height="200"></td>
                                <td> 
                                <div class="card-body">
                                    <h5 class="card-title"><?php echo $item['nama_menu']; ?></h5>
                                    <p class="card-text">Harga: <?php echo $item['harga']; ?></p>
                                    <a href="<?php echo site_url('admin/add_to_cart/' . $item['id_menu']); ?>" class="btn btn-primary">Tambah ke Keranjang</a>
                                </div></td></tr>
                            </table>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
    <div class="container-fluid">
        <div class="card mb-4 mx-4 mt-3">
            <div class="card-header">
                <h2>Keranjang</h2>
            </div>
        </div>
        <div class="card-body">
            <?php if ($cart = $this->cart->contents()) : ?>
                <form action="<?php echo site_url('admin/checkout'); ?>" method="post">
                    <div class="form-group">
                        <label for="nama_pelanggan">Nama Pelanggan:</label>
                        <input type="text" name="nama_pelanggan" class="form-control" required>
                    </div>
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>Nama</th>
                                <th>Harga</th>
                                <th>Jumlah</th>
                                <th>Subtotal</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php $total = 0; ?>
                            <?php foreach ($cart as $item) : ?>
                                <tr>
                                    <td><?php echo $item['name']; ?></td>
                                    <td><?php echo $item['price']; ?></td>
                                    <td>
                                        <input type="number" name="cart[<?php echo $item['rowid']; ?>][qty]" value="<?php echo $item['qty']; ?>" class="form-control" onchange="updateSubtotal(this)" readonly>

                                        <input type="hidden" name="cart[<?php echo $item['rowid']; ?>][rowid]" value="<?php echo $item['rowid']; ?>">
                                    </td>
                                    <td class="subtotal"><?php echo $item['subtotal']; ?></td>
                                    <td>
                                        <a href="<?php echo site_url('admin/remove_from_cart/' . $item['rowid']); ?>" class="btn btn-danger">Hapus</a>
                                    </td>
                                </tr>
                                <?php $total += $item['subtotal']; ?>
                            <?php endforeach; ?>
                            <tr>
                                <td colspan="3" class="text-right"><strong>Total:</strong></td>
                                <td id="total"><?php echo $total; ?></td>
                                <td>
                                    <button type="button" onclick="calculateTotal()" class="btn btn-info">Jumlah Total</button>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <button type="submit" class="btn btn-primary">Update Keranjang</button>
                    <button type="submit" class="btn btn-success">Checkout</button>
                </form>
            <?php else : ?>
                <p>Keranjang kosong</p>
            <?php endif; ?>
        </div>
    </div>
    <script src="<?php echo base_url('assets/js/bootstrap.min.js'); ?>"></script>
    <script>
        function updateSubtotal(element) {
            var row = element.closest('tr');
            var price = parseFloat(row.querySelector('td:nth-child(2)').textContent);
            var qty = parseInt(element.value);
            var subtotal = price * qty;
            row.querySelector('.subtotal').textContent = subtotal;
            calculateTotal();
        }

        function calculateTotal() {
            var total = 0;
            var subtotals = document.querySelectorAll('.subtotal');
            subtotals.forEach(function(subtotal) {
                total += parseFloat(subtotal.textContent);
            });
            document.getElementById('total').textContent = total;
        }
    </script>
</body>

</html>
old