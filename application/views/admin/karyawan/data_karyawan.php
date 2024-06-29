<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
    <h1><?php echo $title; ?></h1>
    <a href="<?php echo base_url() ?>karyawan/create/" class="button">Tambah Karyawan</a>
    
    <table class="mytable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Nama Karyawan</th>
                <th>No. Telp</th>
                <th>Alamat</th>
                <th>Username</th>
                <th>Jabatan</th>
                <th>Menu</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($karyawans as $karyawan): ?>
                <tr>
                    <td><?php echo $karyawan->id_karyawan; ?></td>
                    <td><?php echo $karyawan->nama_karyawan; ?></td>
                    <td><?php echo $karyawan->telp; ?></td>
                    <td><?php echo $karyawan->alamat; ?></td>
                    <td><?php echo $karyawan->username; ?></td>
                    <td><?php echo $karyawan->nama_jabatan; ?></td>
                    <td><a href="<?php echo base_url() ?>karyawan/edit/<?php echo $karyawan->id_karyawan ?>" class="button">Edit</a>
			        <a href="<?php echo base_url() ?>karyawan/delete/<?php echo $karyawan->id_karyawan ?>" class="btn-hps">Hapus</a></td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>