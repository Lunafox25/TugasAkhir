<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
    <h1><?php echo $title; ?></h1>
    
    <?php echo form_open('barang/update/'.$barang->id_barang, ['class' => 'myForm']); ?>
    <div class="myForm">
    <div class="isi-form">
        <label for="id_barang">ID Barang</label>
        <input type="text" name="id_barang" placeholder="cth : BR0001" value="<?php echo set_value('id_barang', $barang->id_barang); ?>" readonly>
        <?php echo form_error('id_barang', '<div class="form-error">', '</div>'); ?>
    </div>
    <div class="isi-form">    
        <label for="nama_barang">Nama Barang</label>
        <input type="text" name="nama_barang" placeholder="Isi Nama Barang" value="<?php echo set_value('nama_barang', $barang->nama_barang); ?>">
        <?php echo form_error('nama_barang', '<div class="form-error">', '</div>'); ?>
    </div>
    <div class="isi-form">    
        <label for="desc_barang">Deskripsi</label>
        <input type="text" name="desc_barang" placeholder="Tuliskan Deskripsi Barang disini" value="<?php echo set_value('desc_barang', $barang->desc_barang); ?>">
        <?php echo form_error('desc_barang', '<div class="form-error">', '</div>'); ?>
    </div>
    <div class="isi-form">    
        <label for="ukuran">Ukuran</label>
        <input type="text" name="ukuran" placeholder="Isi Ukuran" value="<?php echo set_value('ukuran', $barang->ukuran); ?>">
        <?php echo form_error('ukuran', '<div class="form-error">', '</div>'); ?>
    </div>
    <div class="isi-form">
        <label for="harga">Harga Barang</label>
            <input type="text" name="harga_display" id="harga_display" placeholder="Masukkan Harga" value="<?php echo set_value('harga_display', $barang->harga); ?>" pattern="[0-9]*">
        <?php echo form_error('harga_display', '<div class="form-error">', '</div>'); ?>
    </div>
    
    <div class="isi-form">
        <button class="button" type="submit">Simpan</button>
        <a href="<?php echo base_url() ?>barang/cancel/" class="button">Batal</a>
    </div>
    </div>
    <?php echo form_close(); ?>
</body>
</html>
