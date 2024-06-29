<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
    <h1><?php echo $title; ?></h1>
    <a href="<?php echo base_url() ?>barang/create/" class="button">Tambah Barang</a>
    
    <table class="mytable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Barang</th>
                <th>Deskripsi</th>
                <th>Ukuran</th>
                <th>Harga Barang</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($barangs as $barang): ?>
                <tr>
                    <td><?php echo $barang->id_barang; ?></td>
                    <td><?php echo $barang->nama_barang; ?></td>
                    <td><?php echo $barang->desc_barang; ?></td>
                    <td><?php echo $barang->ukuran; ?></td>
                    <td>Rp<?php echo $barang->harga; ?>,00</td>
                    <td><a href="<?php echo base_url() ?>barang/edit/<?php echo $barang->id_barang ?>" class="button">Edit</a>
			        <a href="<?php echo base_url() ?>barang/delete/<?php echo $barang->id_barang ?>" class="btn-hps">Hapus</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>