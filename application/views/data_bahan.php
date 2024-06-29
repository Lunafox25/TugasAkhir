<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
    <h1><?php echo $title; ?></h1>
    <a href="<?php echo base_url() ?>bahan/create/" class="button">Tambah Bahan</a>
    
    <table class="mytable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Bahan</th>
                <th>Satuan</th>
                <th>Harga Bahan</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($bahans as $bahan): ?>
                <tr>
                    <td><?php echo $bahan->id_bahan; ?></td>
                    <td><?php echo $bahan->nama_bahan; ?></td>
                    <td><?php echo $bahan->satuan; ?></td>
                    <td>Rp<?php echo $bahan->hrg_bahan; ?>,00</td>
                    <td><a href="<?php echo base_url() ?>bahan/edit/<?php echo $bahan->id_bahan ?>" class="button">Edit</a>
			        <a href="<?php echo base_url() ?>bahan/delete/<?php echo $bahan->id_bahan ?>" class="btn-hps">Hapus</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>