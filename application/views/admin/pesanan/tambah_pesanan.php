<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?= $title; ?></title>
    <link rel="stylesheet" href="<?= base_url('assets/css/main.css'); ?>">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
</head>
<body>
    <h1><?= $title; ?></h1>
    <?= form_open_multipart('pesanan/store', ['class' => 'myForm']); ?>
    <div class="myForm">
    <?php 
    $fields = [
        ['id_pesanan', 'ID Pesanan', 'text', 'cth : PS0001', 6],
        ['tanggal', 'Tanggal Pesanan', 'date'],
        ['resi', 'No. Resi', 'text', 'Masukkan No. Resi']
    ];

    foreach ($fields as $field): ?>
        <div class="isi-form">
            <label for="<?= $field[0] ?>"><?= $field[1] ?></label>
            <input type="<?= $field[2] ?>" name="<?= $field[0] ?>" <?= isset($field[3]) ? 'placeholder="' . $field[3] . '"' : '' ?> <?= isset($field[4]) ? 'maxlength="' . $field[4] . '"' : '' ?> value="<?= set_value($field[0]); ?>">
            <?= form_error($field[0], '<div class="form-error">', '</div>'); ?>
        </div>
    <?php endforeach; ?>

    <?php 
    $select_fields = [
        ['id_jasakirim', 'Jasa Pengiriman', $jasakirims, 'nama_jasa'],
        ['id_situs', 'Situs Belanja Online', $situss, 'nama_situs'],
        ['id_jbayar', 'Jenis Pembayaran', $jbayars, 'jns_pembayaran'],
        ['id_status', 'Status Pesanan', $statuss, 'status']
    ];

    foreach ($select_fields as $field): ?>
        <div class="isi-form">
            <label for="<?= $field[0] ?>"><?= $field[1] ?></label>
            <select name="<?= $field[0] ?>">
                <option value="">--Pilih <?= $field[1] ?>--</option>
                <?php foreach ($field[2] as $option): ?>
                    <option value="<?= $option->{'id_' . explode('_', $field[0])[1]}; ?>" <?= set_select($field[0], $option->{'id_' . explode('_', $field[0])[1]}); ?>>
                        <?= $option->{$field[3]}; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?= form_error($field[0], '<div class="form-error">', '</div>'); ?>
        </div>
    <?php endforeach; ?>

    <div class="isi-form">
        <label for="totalharga">Total Harga</label>
        <input type="text" name="totalharga" class="totalharga" value="00" readonly>
        <?= form_error('totalharga', '<div class="form-error">', '</div>'); ?>
    </div>
                </div>                 
    <button type="button" class="button" id="add-detailbarang">Tambah Barang</button>
    <div id="detailbarang-container">
        <div class="detailbarang-item">
            <select name="id_barang[]">
                <option value="">--Pilih Barang--</option>
                <?php foreach ($barangs as $barang): ?>
                    <option value="<?= $barang->id_barang; ?>" data-harga="<?= $barang->harga; ?>" data-ukuran="<?= $barang->ukuran; ?>"><?= $barang->nama_barang; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="Ukuran">Ukuran</label>
            <input type="text" name="Ukuran[]" class="Ukuran" readonly>
            <label for="file_desain">File Desain</label>
            <input type="file" name="file_desain[]" multiple>
            <label for="qty_barang">Qty</label>
            <input type="number" min="1" name="qty_barang[]" class="qty_barang" value="">
            <label for="tot_hrgbarang">Total</label>
            <input type="text" name="tot_hrgbarang[]" class="tot_hrgbarang" readonly>
            <button type="button" class="hps_dbarang">Hapus</button>
        </div>
    </div>

    <button type="button" class="button" id="add-detailbahan">Tambah Bahan</button>
    <div id="detailbahan-container">
        <div class="detailbahan-item">
            <select name="id_bahan[]" class="id_bahan">
                <option value="">--Pilih Bahan--</option>
                <?php foreach ($bahans as $bahan): ?>
                    <option value="<?= $bahan->id_bahan; ?>" data-harga="<?= $bahan->hrg_bahan; ?>" data-satuan="<?= $bahan->satuan; ?>"><?= $bahan->nama_bahan; ?></option>
                <?php endforeach; ?>
            </select>
            <label for="Satuan">Satuan</label>
            <input type="text" name="Satuan[]" class="Satuan" readonly>
            <label for="qty_bahan">Qty</label>
            <input type="number" min="1" name="qty_bahan[]" class="qty_bahan">
            <label for="tot_hrgbahan">Total</label>
            <input type="text" name="tot_hrgbahan[]" class="tot_hrgbahan" readonly>
            <button type="button" class="hps_dbahan">Hapus</button>
        </div>
    </div>

    <div class="isi-form">
        <button class="button" type="submit">Simpan</button>
        <a href="<?= base_url('pesanan/cancel'); ?>" class="button">Batal</a>
    </div>

    <?= form_close(); ?>

    <script>
        $(document).ready(function() {
            // Cache for options to prevent repeated AJAX calls
            var bahanOptionsCache = '';
            var barangOptionsCache = '';

            // Function to fetch bahan data and populate options
            function fetchBahanOptions(callback) {
                if (bahanOptionsCache) {
                    callback(bahanOptionsCache);
                    return;
                }
                $.ajax({
                    url: '<?= base_url('pesanan/fetch_bahans'); ?>',
                    dataType: 'json',
                    success: function(data) {
                        var bahanOptions = '<option value="">--Pilih Bahan--</option>';
                        $.each(data, function(index, bahan) {
                            bahanOptions += '<option value="' + bahan.id_bahan + '" data-harga="' + bahan.hrg_bahan + '" data-satuan="' + bahan.satuan + '">' + bahan.nama_bahan + '</option>';
                        });
                        bahanOptionsCache = bahanOptions;
                        callback(bahanOptions);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching bahan data:', textStatus, errorThrown);
                    }
                });
            }

            // Function to fetch barang data and populate options
            function fetchBarangOptions(callback) {
                if (barangOptionsCache) {
                    callback(barangOptionsCache);
                    return;
                }
                $.ajax({
                    url: '<?= base_url('pesanan/fetch_barangs'); ?>',
                    dataType: 'json',
                    success: function(data) {
                        var barangOptions = '<option value="">--Pilih Barang--</option>';
                        $.each(data, function(index, barang) {
                            barangOptions += '<option value="' + barang.id_barang + '" data-harga="' + barang.harga + '" data-ukuran="' + barang.ukuran + '">' + barang.nama_barang + '</option>';
                        });
                        barangOptionsCache = barangOptions;
                        callback(barangOptions);
                    },
                    error: function(jqXHR, textStatus, errorThrown) {
                        console.error('Error fetching barang data:', textStatus, errorThrown);
                    }
                });
            }

            // Initial call to fetch options
            fetchBahanOptions(function(bahanOptions) {
                $('.id_bahan').each(function() {
                    var selectedValue = $(this).val();
                    $(this).empty().append(bahanOptions);
                    $(this).val(selectedValue);
                });
            });
            fetchBarangOptions(function(barangOptions) {
                $('select[name="id_barang[]"]').each(function() {
                    var selectedValue = $(this).val();
                    $(this).empty().append(barangOptions);
                    $(this).val(selectedValue);
                });
            });

            // Function to calculate Total
            function calculateTotalHargaBahan(element) {
                var qty = parseFloat($(element).val()) || 0;
                var harga = parseFloat($(element).closest('.detailbahan-item').find('select.id_bahan option:selected').data('harga')) || 0;
                var total = qty * harga;
                $(element).closest('.detailbahan-item').find('.tot_hrgbahan').val(total.toFixed(2));
                calculateTotalHarga();
            }

            // Function to calculate Total
            function calculateTotalHargaBarang(element) {
                var qty = parseFloat($(element).val()) || 0;
                var harga = parseFloat($(element).closest('.detailbarang-item').find('select[name="id_barang[]"] option:selected').data('harga')) || 0;
                var total = qty * harga;
                $(element).closest('.detailbarang-item').find('input[name="tot_hrgbarang[]"]').val(total.toFixed(2));
                calculateTotalHarga();
            }

            // Function to calculate the overall total harga
            function calculateTotalHarga() {
                var totalHargaBahan = 0;
                $('.tot_hrgbahan').each(function() {
                    totalHargaBahan += parseFloat($(this).val()) || 0;
                });

                var totalHargaBarang = 0;
                $('.tot_hrgbarang').each(function() {
                    totalHargaBarang += parseFloat($(this).val()) || 0;
                });

                var totalHarga = totalHargaBahan + totalHargaBarang;
                $('.totalharga').val(totalHarga.toFixed(2));
            }

            // Event delegation for dynamically added elements
            $(document).on('change', '.id_bahan, .qty_bahan', function() {
                var $item = $(this).closest('.detailbahan-item');
                var selectedOption = $item.find('.id_bahan option:selected');
                var satuan = selectedOption.data('satuan');
                $item.find('.Satuan').val(satuan);
                calculateTotalHargaBahan($item.find('.qty_bahan'));
            });

            $(document).on('change', 'select[name="id_barang[]"], input[name="qty_barang[]"]', function() {
                var $item = $(this).closest('.detailbarang-item');
                var selectedOption = $item.find('select[name="id_barang[]"] option:selected');
                var ukuran = selectedOption.data('ukuran');
                $item.find('.Ukuran').val(ukuran);
                calculateTotalHargaBarang($item.find('input[name="qty_barang[]"]'));
            });

            // Click event handler for adding new detailbarang item
            $('#add-detailbarang').click(function() {
                var newItem = `
                    <div class="detailbarang-item">
                        
                        <select name="id_barang[]">
                            <option value="">--Pilih Barang--</option>
                        </select>
                        <label for="Ukuran">Ukuran</label>
                        <input type="text" name="Ukuran[]" class="Ukuran" readonly>
                        <label for="file_desain">File Desain</label>
                        <input type="file" name="file_desain[]" multiple>
                        <label for="qty_barang">Qty</label>
                        <input type="number" name="qty_barang[]" class="qty_barang" value="" min="1">
                        <label for="tot_hrgbarang">Total</label>
                        <input type="text" name="tot_hrgbarang[]" class="tot_hrgbarang" readonly>
                        <button type="button" class="hps_dbarang">Hapus</button>
                    </div>`;
                $('#detailbarang-container').append(newItem);
                fetchBarangOptions(function(barangOptions) {
                    $('#detailbarang-container').find('select[name="id_barang[]"]').last().append(barangOptions);
                });
            });

            // Click event handler for adding new detailbahan item
            $('#add-detailbahan').click(function() {
                var newItem = `
                    <div class="detailbahan-item">
                        <label for="id_bahan">ID Bahan</label>
                        <select name="id_bahan[]" class="id_bahan">
                            <option value="">--Pilih Bahan--</option>
                        </select>
                        <label for="Satuan">Satuan</label>
                        <input type="text" name="Satuan[]" class="Satuan" readonly>
                        <label for="qty_bahan">Qty</label>
                        <input type="number" min="1" name="qty_bahan[]" class="qty_bahan">
                        <label for="tot_hrgbahan">Total</label>
                        <input type="text" name="tot_hrgbahan[]" class="tot_hrgbahan" readonly>
                        <button type="button" class="hps_dbahan">Hapus</button>
                    </div>`;
                $('#detailbahan-container').append(newItem);
                fetchBahanOptions(function(bahanOptions) {
                    $('#detailbahan-container').find('.id_bahan').last().append(bahanOptions);
                });
            });

            // Event handler to remove detailbarang item
            $(document).on('click', '.hps_dbarang', function() {
                $(this).closest('.detailbarang-item').remove();
                calculateTotalHarga();
            });

            // Event handler to remove detailbahan item
            $(document).on('click', '.hps_dbahan', function() {
                $(this).closest('.detailbahan-item').remove();
                calculateTotalHarga();
            });
        });
    </script>
</body>
</html>
