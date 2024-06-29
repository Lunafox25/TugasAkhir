<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
    <h1><?php echo $title; ?></h1>
    
    <?php echo form_open('bahan/update/'.$bahan->id_bahan, ['class' => 'myForm']); ?>
    
    <div class="isi-form">
        <label for="id_bahan">ID Bahan</label>
        <input type="text" name="id_bahan" placeholder="cth : BN0001" value="<?php echo set_value('id_bahan', $bahan->id_bahan); ?>" readonly>
        <?php echo form_error('id_bahan', '<div class="form-error">', '</div>'); ?>
    </div>
    <div class="isi-form">    
        <label for="nama_bahan">Nama Bahan</label>
        <input type="text" name="nama_bahan" placeholder="Isi Nama Bahan" value="<?php echo set_value('nama_bahan', $bahan->nama_bahan); ?>">
        <?php echo form_error('nama_bahan', '<div class="form-error">', '</div>'); ?>
    </div>
    <div class="isi-form">    
        <label for="satuan">Satuan</label>
        <input type="text" name="satuan" placeholder="cth : cm, mm" value="<?php echo set_value('satuan', $bahan->satuan); ?>">
        <?php echo form_error('satuan', '<div class="form-error">', '</div>'); ?>
    </div>
    <div class="isi-form">
        <label for="hrg_bahan">Harga Bahan</label>
            <input type="text" name="hrg_bahan_display" id="hrg_bahan_display" placeholder="Masukkan Harga" value="<?php echo set_value('hrg_bahan_display', $bahan->hrg_bahan); ?>" pattern="[0-9]*">
        <?php echo form_error('hrg_bahan_display', '<div class="form-error">', '</div>'); ?>
    </div>
    
    <div class="isi-form">
        <button class="button" type="submit">Simpan</button>
        <a href="<?php echo base_url() ?>bahan/cancel/" class="button">Batal</a>
    </div>
    <?php echo form_close(); ?>
</body>
</html>
