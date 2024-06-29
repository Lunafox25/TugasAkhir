
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
    <h1><?php echo $title; ?></h1>
    
    <?php echo form_open('jabatan/store', ['class' => 'myForm']); ?>
    
    <div class="isi-form">
        <label for="id_jabatan">ID Jabatan</label>
        <input type="text" name="id_jabatan" maxlength="6" placeholder="cth : JN0001" value="<?php echo set_value('id_jabatan'); ?>">
        <?php echo form_error('id_jabatan', '<div class="form-error">', '</div>'); ?>
    </div>
    <div class="isi-form">    
        <label for="nama_jabatan">Nama Jabatan</label>
        <input type="text" name="nama_jabatan" placeholder="Isi Nama Jabatan" value="<?php echo set_value('nama_jabatan'); ?>">
        <?php echo form_error('nama_jabatan', '<div class="form-error">', '</div>'); ?>
    </div>
    <div class="isi-form">    
        <label for="id_role">ID Role</label>
        <input type="radio" name="id_role" value="1" <?php echo set_radio('id_role', '1'); ?>> 1
        <input type="radio" name="id_role" value="2" <?php echo set_radio('id_role', '2'); ?>> 2
        <?php echo form_error('id_role', '<div class="form-error">', '</div>'); ?>
    </div>
    
    <div>
        <button class="button" type="submit">Simpan</button>
        <a href="<?php echo base_url() ?>jabatan/cancel/" class="button">Batal</a>
    </div>
    
    <?php echo form_close(); ?>
</body>
</html>
