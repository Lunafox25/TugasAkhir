<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
    <h1><?php echo $title; ?></h1>
    <a href="<?php echo base_url() ?>pesanan/create/" class="button">Tambah Pesanan</a>
    
    <table class="mytable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Resi</th>
                <th>Jasa Kirim</th>
                <th>Situs</th>
                <th>Jenis Pembayaran</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pesanans as $pesanan): ?>
                <tr>
                    <td><?php echo $pesanan->id_pesanan; ?></td>
                    <td><?php echo $pesanan->tanggal; ?></td>
                    <td><?php echo $pesanan->resi; ?></td>
                    <td><?php echo $pesanan->nama_jasa; ?></td>
                    <td><a href="<?php echo $pesanan->url_situs ?>"><?php echo $pesanan->nama_situs; ?></a></td>
                    <td><?php echo $pesanan->jns_pembayaran; ?></td>
                    <td>Rp<?php echo number_format($pesanan->totalharga, 0, '', '.'); ?>,00</td>
                    <td><?php echo $pesanan->status; ?></td>
                    <td class="opsi">
                    <a href="<?php echo base_url() ?>pesanan/edit/<?php echo $pesanan->id_pesanan ?>" class="button">Edit</a>
                    <a href="<?php echo base_url() ?>pesanan/detail/<?php echo $pesanan->id_pesanan ?>" class="button">Detail</a>
			        <a href="<?php echo base_url() ?>pesanan/delete/<?php echo $pesanan->id_pesanan ?>" class="btn-hps">Hapus</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
    <?php echo form_open('pesanan/print', ['class' => 'myForm']); ?>
    <div class="isi-form">
        <label for="tanggal_awal">Tanggal Awal</label>
        <input type="date" name="tanggal_awal" value="<?php echo set_value('tanggal_awal'); ?>">
        <?php echo form_error('tanggal_awal', '<div class="form-error">', '</div>'); ?>
    </div>
    <div class="isi-form">    
        <label for="tanggal_akhir">Tanggal Akhir</label>
        <input type="date" name="tanggal_akhir" value="<?php echo set_value('tanggal_akhir'); ?>">
        <?php echo form_error('tanggal_akhir', '<div class="form-error">', '</div>'); ?>
    </div>
    <div>
        <button class="button" type="submit">Cetak Laporan</button>
    </div>
    <?php echo form_close(); ?>

</body>
</html>