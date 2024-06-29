<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
    <h1><?php echo $title; ?></h1>
    
    <?php echo form_open('karyawan/store', ['class' => 'myForm']); ?>
    
    <div class="isi-form">
        <label for="id_karyawan">ID Karyawan</label>
        <input type="text" name="id_karyawan" maxlength="6" placeholder="cth : KR0001" value="<?php echo set_value('id_karyawan'); ?>">
        <?php echo form_error('id_karyawan', '<div class="form-error">', '</div>'); ?>
    </div>

    <div class="isi-form">
        <label for="nama_karyawan">Nama Karyawan</label>
        <input type="text" name="nama_karyawan" placeholder="Nama Lengkap Karyawan" value="<?php echo set_value('nama_karyawan'); ?>">
        <?php echo form_error('nama_karyawan', '<div class="form-error">', '</div>'); ?>
    </div>

    <div class="isi-form">
        <label for="telp">No Telp</label>
        <input type="text" name="telp" placeholder="12 digit no telp" value="<?php echo set_value('telp'); ?>">
        <?php echo form_error('telp', '<div class="form-error">', '</div>'); ?>
    </div>

    <div class="isi-form">
        <label for="alamat">Alamat</label>
        <input type="text" name="alamat" placeholder="Alamat Karyawan" value="<?php echo set_value('alamat'); ?>">
        <?php echo form_error('alamat', '<div class="form-error">', '</div>'); ?>
    </div>

    <div class="isi-form">
        <label for="username">Username</label>
        <input type="text" name="username" placeholder="Username Karyawan" value="<?php echo set_value('username'); ?>">
        <?php echo form_error('username', '<div class="form-error">', '</div>'); ?>
    </div>

    <div class="isi-form">
        <label for="password">Password</label>
        <input type="password" name="password" value="<?php echo set_value('password'); ?>">
        <?php echo form_error('password', '<div class="form-error">', '</div>'); ?>
    </div>

    <div class="isi-form">
        <label for="id_jabatan">Jabatan</label>
        <select name="id_jabatan">
            <option value="">Pilih Jabatan</option>
            <?php foreach ($jabatans as $jabatan): ?>
                <option value="<?php echo $jabatan->id_jabatan; ?>" <?php echo set_select('id_jabatan', $jabatan->id_jabatan); ?>>
                    <?php echo $jabatan->nama_jabatan; ?>
                </option>
            <?php endforeach; ?>
        </select>
        <?php echo form_error('id_jabatan', '<div class="form-error">', '</div>'); ?>
    </div>

    <div class="isi-form">
        <button class="button" type="submit">Simpan</button>
        <a href="<?php echo base_url() ?>karyawan/cancel/" class="button">Batal</a>
    </div>

    <?php echo form_close(); ?>
</body>
</html>
