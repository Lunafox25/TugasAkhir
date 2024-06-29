<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
    <h1><?php echo $title; ?></h1>
    <a href="<?php echo base_url() ?>jabatan/create/" class="button">Tambah Jabatan</a>
    
    <table class="mytable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Jabatan</th>
                <th>Role ID</th>
                <th>Menu</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($jabatans as $jabatan): ?>
                <tr>
                    <td><?php echo $jabatan->id_jabatan; ?></td>
                    <td><?php echo $jabatan->nama_jabatan; ?></td>
                    <td><?php echo $jabatan->id_role; ?></td>
                    <td><a href="<?php echo base_url() ?>jabatan/edit/<?php echo $jabatan->id_jabatan ?>" class="button">Edit</a>
			        <a href="<?php echo base_url() ?>jabatan/delete/<?php echo $jabatan->id_jabatan ?>" class="btn-hps">Hapus</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>