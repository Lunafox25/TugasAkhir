<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Daftar Pesanan</title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/main.css'); ?>">
</head>
<body>
    <h1>Daftar Pesanan</h1>
    
    <table class="mytable">
        <thead>
            <tr>
                <th>ID</th>
                <th>Tanggal</th>
                <th>Resi</th>
                <th>Jasa Kirim</th>
                <th>Situs</th>
                <th>Jenis Pembayaran</th>
                <th>Total Harga</th>
                <th>Status</th>
                <th>Opsi</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($pesanans as $pesanan): ?>
                <tr>
                    <td><?php echo $pesanan->id_pesanan; ?></td>
                    <td><?php echo $pesanan->tanggal; ?></td>
                    <td><?php echo $pesanan->resi; ?></td>
                    <td><?php echo $pesanan->nama_jasa; ?></td>
                    <td><a href="<?php echo $pesanan->url_situs ?>"><?php echo $pesanan->nama_situs; ?></a></td>
                    <td><?php echo $pesanan->jns_pembayaran; ?></td>
                    <td>Rp<?php echo $pesanan->totalharga; ?>,00</td>
                    <td><?php echo $pesanan->status; ?></td>
                    <td class="opsi">
                        <a href="<?php echo base_url() ?>pesanan/detail/<?php echo $pesanan->id_pesanan ?>" class="button">Detail</a>
                        <?php
                            $status_labels = [
                                1 => 'Proses',
                                2 => 'Kemas',
                                3 => 'Kirim',
                                4 => 'Selesai',
                                5 => 'Batalkan',
                                6 => 'Cancelled',
                            ];
                            $current_status_label = isset($status_labels[$pesanan->id_status]) ? $status_labels[$pesanan->id_status] : '';
                        ?>
                        <a href="javascript:void(0)" class="button process-button" data-id="<?php echo $pesanan->id_pesanan; ?>">
                            <?php echo $current_status_label; ?>
                        </a>
                        <a href="<?php echo base_url() ?>pesanan/undo_status/<?php echo $pesanan->id_pesanan ?>" class="btn-batal">Undo</a>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>

    <!-- Modal for processing -->
<div id="processModal" class="modal" style="display:none;">
    <div class="modal-content">
        <h2>Keterangan</h2>
        <?php echo form_open('pesanan/update_status', ['class' => 'keterangan', 'enctype' => 'multipart/form-data']); ?>
            <input type="hidden" name="id_pesanan">
            <label for="file_keterangan">File Keterangan:</label>
            <input type="file" name="file_keterangan" id="file_keterangan" class="input-field">
            <label for="keterangan">Keterangan:</label>
            <textarea name="keterangan" id="keterangan" class="input-field"></textarea>
            <button type="submit" class="submit-btn">Submit</button>
        <?php echo form_close(); ?>
        <button id="processModalClose" class="close-btn">Close</button>
    </div>
</div>

<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script>
    $(document).ready(function() {
        // Ensure the modal is hidden when the page loads
        $('#processModal').hide();

        $('.process-button').on('click', function() {
            var id_pesanan = $(this).data('id');
            $('#processModal').find('input[name="id_pesanan"]').val(id_pesanan);
            $('#processModal').show();
        });

        $('#processModalClose').on('click', function() {
            $('#processModal').hide();
        });
    });
</script>

</body>
</html>
