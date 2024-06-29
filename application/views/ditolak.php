<?php defined('BASEPATH') OR exit('No direct script access allowed'); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
    <title>Akses Ditolak</title>
</head>
<body>
    <?php log_message('debug', 'Ditolak.php view is being displayed.'); ?>
    
        <h1>Akses Ditolak</h1>
        <div style="text-align:center">
        <p >Anda tidak memiliki akses ke halaman ini.
        <br/>Klik tombol dibawah ini untuk kembali ke halaman login.</p>
        <br/>
        <a href="<?php echo base_url() ?>login" class="button">Kembali</a>
        </div>
</body>
</html>
