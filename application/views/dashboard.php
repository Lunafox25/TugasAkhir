<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo $title; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
<div class="dashboard-container">
    <h1>Dashboard</h1>
    <div class="card-container">
        <div class="card">
            <div class="card-header pending">Pending</div>
            <div class="card-content"><?php echo str_pad($status_counts['1'], 2, '0', STR_PAD_LEFT); ?></div>
        </div>
        <div class="card">
            <div class="card-header dalamproses">Dalam Proses</div>
            <div class="card-content"><?php echo str_pad($status_counts['2'], 2, '0', STR_PAD_LEFT); ?></div>
        </div>
        <div class="card">
            <div class="card-header packing">Packing</div>
            <div class="card-content"><?php echo str_pad($status_counts['3'], 2, '0', STR_PAD_LEFT); ?></div>
        </div>
        
    </div>
    <div class="card-container">
        
        <div class="card">
            <div class="card-header dikirim">Dikirim</div>
            <div class="card-content"><?php echo str_pad($status_counts['4'], 2, '0', STR_PAD_LEFT); ?></div>
        </div>
        <div class="card">
            <div class="card-header selesai">Selesai</div>
            <div class="card-content"><?php echo str_pad($status_counts['5'], 2, '0', STR_PAD_LEFT); ?></div>
        </div>
        <div class="card">
            <div class="card-header dibatalkan">Cancelled</div>
            <div class="card-content"><?php echo str_pad($status_counts['6'], 2, '0', STR_PAD_LEFT); ?></div>
        </div>
    </div>
    <div class="total">
        Total Pesanan: <?php echo $total_pesanan; ?>
    </div>
</div>

</body>
</html>
