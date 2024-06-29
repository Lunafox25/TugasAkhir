<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/laporan.css'); ?>">
    <link rel="stylesheet" href="<?= base_url('assets/css/print.css'); ?>" media="print">
</head>
<body>

<div class="report-container">
    <div class="title-container">
        <h1><?= $title; ?></h1>
        <p><?= date('F j, Y'); ?></p>
    </div>

    <?php if (!empty($pesanans)) : ?>
        <?php foreach ($pesanans as $pesanan) : ?>
            <div class="section">
                <h3>Pesanan ID: <?= $pesanan->id_pesanan; ?></h3>
                <table>
                    <thead>
                        <tr>
                            <th colspan="7" class="section-title">Informasi Pesanan</th>
                        </tr>
                        <tr>
                            <th>Tanggal</th>
                            <th>Resi</th>
                            <th>Jasa Pengiriman</th>
                            <th>Situs Belanja</th>
                            <th>Jenis Pembayaran</th>
                            <th>Status</th>
                            <th>Total Harga</th>
                        </tr>
                    </thead>
                    <tbody>
                        <tr>
                            <td><?= $pesanan->tanggal; ?></td>
                            <td><?= $pesanan->resi; ?></td>
                            <td><?= $pesanan->id_jasakirim; ?></td>
                            <td><?= $pesanan->id_situs; ?></td>
                            <td><?= $pesanan->id_jbayar; ?></td>
                            <td><?= $pesanan->id_status; ?></td>
                            <td>Rp<?= number_format($pesanan->totalharga, 0, '', '.'); ?></td>
                        </tr>
                    </tbody>
                </table>

                <div class="details-container">
                    <div class="details-table">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="7" class="section-title">Detail Barang</th>
                                </tr>
                                <tr>
                                    <th>Nama Barang</th>
                                    <th>Deskripsi</th>
                                    <th>Ukuran</th>
                                    <th>Harga</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                    <th>File Desain</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pesanan->detail_barangs)) : ?>
                                    <?php foreach ($pesanan->detail_barangs as $barang) : ?>
                                        <tr>
                                            <td><?= $barang->nama_barang; ?></td>
                                            <td><?= $barang->desc_barang; ?></td>
                                            <td><?= $barang->ukuran; ?></td>
                                            <td>Rp<?= number_format($barang->harga, 0, '', '.'); ?></td>
                                            <td><?= $barang->qty_barang; ?></td>
                                            <td>Rp<?= number_format($barang->tot_hrgbarang, 0, '', '.'); ?></td>
                                            <td><?= $barang->file_desain; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="7" class="no-data">Tidak ada detail barang untuk pesanan ini.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>

                    <div class="details-table">
                        <table>
                            <thead>
                                <tr>
                                    <th colspan="5" class="section-title">Detail Bahan</th>
                                </tr>
                                <tr>
                                    <th>Nama Bahan</th>
                                    <th>Harga Bahan</th>
                                    <th>Satuan</th>
                                    <th>Jumlah</th>
                                    <th>Total Harga</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php if (!empty($pesanan->detail_bahans)) : ?>
                                    <?php foreach ($pesanan->detail_bahans as $bahan) : ?>
                                        <tr>
                                            <td><?= $bahan->nama_bahan; ?></td>
                                            <td>Rp<?= number_format($bahan->hrg_bahan, 0, '', '.'); ?></td>
                                            <td><?= $bahan->satuan; ?></td>
                                            <td><?= $bahan->qty_bahan; ?></td>
                                            <td>Rp<?= number_format($bahan->tot_hrgbahan, 0, '', '.'); ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                <?php else : ?>
                                    <tr>
                                        <td colspan="5" class="no-data">Tidak ada detail bahan untuk pesanan ini.</td>
                                    </tr>
                                <?php endif; ?>
                            </tbody>
                        </table>
                    </div>
                </div>

            </div>
        <?php endforeach; ?>
    <?php else : ?>
        <p class="no-data">Tidak ada pesanan yang ditemukan untuk tanggal yang dipilih.</p>
    <?php endif; ?>
</div>

<script>
    window.onload = function() {
        window.print();
    }
</script>
</body>
</html>
