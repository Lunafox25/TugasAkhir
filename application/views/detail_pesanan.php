<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Detail Pesanan</title>
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
</head>
<body>
    <div class="container">
        <div class="content">
            <div class="card-container2">
                <div class="card2 <?= strtolower($pesanan->status); ?>">
                    <div class="card-header2">
                    Detail Pesanan <?= $pesanan->id_pesanan ?>
                    </div>
                    <div class="card-content2"><?= ucfirst($pesanan->status); ?></div>
                </div>
            </div>
            <div class="flex-detail">
                <table class="mytable2">
                    <tr>
                        <th>ID Pesanan</th>
                        <td>: <?= $pesanan->id_pesanan ?></td>
                    </tr>
                    <tr>
                        <th>No. Resi</th>
                        <td>: <?= $pesanan->resi ? $pesanan->resi : 'Belum ada resi'; ?></td>
                    </tr>
                    <tr>
                        <th>Tanggal Pesanan</th>
                        <td>: <?= $pesanan->tanggal ?></td>
                    </tr>
                    <tr>
                        <th>Situs Belanja Online</th>
                        <td>: <?= $pesanan->nama_situs ?></td>
                    </tr>
                    <tr>
                        <th>Jenis Pembayaran</th>
                        <td>: <?= $pesanan->jns_pembayaran ?></td>
                    </tr>
                    <tr>
                        <th>Jasa Kirim</th>
                        <td>: <?= $pesanan->nama_jasa ?></td>
                    </tr>
                    <tr>
                        <th>Total Harga :</th>
                        <td>: Rp<?php echo number_format($pesanan->totalharga, 0, '', '.'); ?>,00</td>
                    </tr>
                </table>

                <div class="file-progress">
                    <?php if (!empty($pesanan->file)): ?>
                        <?php
                        $file_extension = pathinfo($pesanan->file, PATHINFO_EXTENSION);
                        $image_extensions = ['jpg', 'jpeg', 'png', 'gif'];
                        if (in_array(strtolower($file_extension), $image_extensions)): ?>
                            <img src="<?= base_url($pesanan->file); ?>" alt="Foto Progress" style="max-width: 100%;">
                        <?php else: ?>
                            <a href="<?= base_url($pesanan->file); ?>" target="_blank">Download File</a>
                        <?php endif; ?>
                    <?php else: ?>
                        <p>No file uploaded.</p>
                    <?php endif; ?>
                </div>

                <div class="file-progress">
                    Keterangan Pesanan : <br/>
                    <?= $pesanan->keterangan ?>
                </div>
            </div>

            <h2>Detail Barang</h2>
            <table class="mytable">
                <thead>
                    <tr>
                        <th>ID Barang</th>
                        <th>Nama Barang</th>
                        <th>Deskripsi</th>
                        <th>Qty</th>
                        <th>Ukuran</th>
                        <th>File Desain</th>
                        <th>Harga</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detail_barangs as $barang): ?>
                        <tr>
                            <td><?= $barang->id_barang ?></td>
                            <td><?= $barang->nama_barang ?></td>
                            <td><?= $barang->desc_barang ?></td>
                            <td><?= $barang->qty_barang ?></td>
                            <td><?= $barang->ukuran ?></td>
                            <td><?= $barang->file_desain ?></td>
                            <td>Rp<?= number_format($barang->harga, 0, '', '.'); ?>,00</td>
                            <td>Rp<?= number_format($barang->tot_hrgbarang, 0, '', '.'); ?>,00</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <h2>Detail Bahan</h2>
            <table class="mytable">
                <thead>
                    <tr>
                        <th>ID Bahan</th>
                        <th>Nama Bahan</th>
                        <th>Qty</th>
                        <th>Satuan</th>
                        <th>Harga</th>
                        <th>Total Harga</th>
                    </tr>
                </thead>
                <tbody>
                    <?php foreach ($detail_bahans as $bahan): ?>
                        <tr>
                            <td><?= $bahan->id_bahan ?></td>
                            <td><?= $bahan->nama_bahan ?></td>
                            <td><?= $bahan->qty_bahan ?></td>
                            <td><?= $bahan->satuan ?></td>
                            <td>Rp<?= number_format($bahan->hrg_bahan, 0, '', '.'); ?>,00</td>
                            <td>Rp<?= number_format($bahan->tot_hrgbahan, 0, '', '.'); ?>,00</td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>

            <div class="tombol-detail">
                <div>
                    <a href="<?php echo base_url() ?>pesanan/edit/<?php echo $pesanan->id_pesanan ?>" class="button">Edit Pesanan</a>
                </div>
                <div>
                    <a href="<?php echo base_url('pesanan');?>" class="button">Kembali</a>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
