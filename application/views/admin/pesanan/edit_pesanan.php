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
    <?= form_open('pesanan/update/'.$pesanan->id_pesanan, ['class' => 'myForm', 'enctype' => 'multipart/form-data']); ?>

    <?php 
    $fields = [
        ['id_pesanan', 'ID Pesanan', 'text', $pesanan->id_pesanan, 'readonly'],
        ['tanggal', 'Tanggal Pesanan', 'date', $pesanan->tanggal],
        ['resi', 'No. Resi', 'text', $pesanan->resi]
    ];

    foreach ($fields as $field): ?>
        <div class="isi-form">
            <label for="<?= $field[0] ?>"><?= $field[1] ?></label>
            <input type="<?= $field[2] ?>" name="<?= $field[0] ?>" value="<?= $field[3] ?>" <?= isset($field[4]) ? $field[4] : '' ?>>
            <?= form_error($field[0], '<div class="form-error">', '</div>'); ?>
        </div>
    <?php endforeach; ?>

    <?php 
    $select_fields = [
        ['id_jasakirim', 'Jasa Pengiriman', $jasakirims, 'nama_jasa', $pesanan->id_jasakirim],
        ['id_situs', 'Situs Belanja Online', $situss, 'nama_situs', $pesanan->id_situs],
        ['id_jbayar', 'Jenis Pembayaran', $jbayars, 'jns_pembayaran', $pesanan->id_jbayar],
        ['id_status', 'Status Pesanan', $statuss, 'status', $pesanan->id_status]
    ];

    foreach ($select_fields as $field): ?>
        <div class="isi-form">
            <label for="<?= $field[0] ?>"><?= $field[1] ?></label>
            <select name="<?= $field[0] ?>">
                <option value="">--Pilih <?= $field[1] ?>--</option>
                <?php foreach ($field[2] as $option): ?>
                    <option value="<?= $option->{'id_' . explode('_', $field[0])[1]}; ?>" <?= ($option->{'id_' . explode('_', $field[0])[1]} == $field[4]) ? 'selected' : ''; ?>>
                        <?= $option->{$field[3]}; ?>
                    </option>
                <?php endforeach; ?>
            </select>
            <?= form_error($field[0], '<div class="form-error">', '</div>'); ?>
        </div>
    <?php endforeach; ?>

    <div class="isi-form">
        <label for="totalharga">Total Harga</label>
        <input type="text" name="totalharga" class="totalharga" value="<?= $pesanan->totalharga; ?>" readonly>
        <?= form_error('totalharga', '<div class="form-error">', '</div>'); ?>
    </div>

    <button type="button" class="button" id="add-detailbarang">Tambah Barang</button>
    <div id="detailbarang-container">
        <?php foreach ($detail_barangs as $detail_barang): ?>
            <div class="detailbarang-item">
                
                <select name="id_barang[]">
                    <option value="">--Pilih Barang--</option>
                    <?php foreach ($barangs as $barang): ?>
                        <option value="<?= $barang->id_barang; ?>" data-harga="<?= $barang->harga; ?>" data-ukuran="<?= $barang->ukuran; ?>" <?= ($barang->id_barang == $detail_barang->id_barang) ? 'selected' : ''; ?>>
                            <?= $barang->nama_barang; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="file_desain">File Desain</label>
                    <input type="file" name="file_desain[]" value="<?= $detail_barang->file_desain; ?>">
                <label for="qty_barang">Qty</label>
                <input type="number" min="1" name="qty_barang[]" class="qty_barang" value="<?= $detail_barang->qty_barang; ?>">
                <label for="Ukuran">Ukuran</label>
                <input type="text" name="Ukuran[]" class="Ukuran" value="<?= $detail_barang->ukuran; ?>" readonly>
                <label for="tot_hrgbarang">Total</label>
                <input type="text" name="tot_hrgbarang[]" class="tot_hrgbarang" value="<?= $detail_barang->tot_hrgbarang; ?>" readonly>
                <button type="button" class="hps_dbarang">Hapus</button>
            </div>
        <?php endforeach; ?>
    </div>

    <button type="button" class="button" id="add-detailbahan">Tambah Bahan</button>
    <div id="detailbahan-container">
        <?php foreach ($detail_bahans as $detail_bahan): ?>
            <div class="detailbahan-item">
                <label for="id_bahan">ID Bahan</label>
                <select name="id_bahan[]" class="id_bahan">
                    <option value="">--Pilih Bahan--</option>
                    <?php foreach ($bahans as $bahan): ?>
                        <option value="<?= $bahan->id_bahan; ?>" data-harga="<?= $bahan->hrg_bahan; ?>" data-satuan="<?= $bahan->satuan; ?>" <?= ($bahan->id_bahan == $detail_bahan->id_bahan) ? 'selected' : ''; ?>>
                            <?= $bahan->nama_bahan; ?>
                        </option>
                    <?php endforeach; ?>
                </select>
                <label for="qty_bahan">Qty</label>
                <input type="number" min="1" name="qty_bahan[]" class="qty_bahan" value="<?= $detail_bahan->qty_bahan; ?>">
                <label for="Satuan">Satuan</label>
                <input type="text" name="Satuan[]" class="Satuan" value="<?= $detail_bahan->satuan; ?>" readonly>
                <label for="tot_hrgbahan">Total</label>
                <input type="text" name="tot_hrgbahan[]" class="tot_hrgbahan" value="<?= $detail_bahan->tot_hrgbahan; ?>" readonly>
                <button type="button" class="hps_dbahan">Hapus</button>
            </div>
        <?php endforeach; ?>
    </div>

    <div class="isi-form">
        <button class="button" type="submit">Simpan</button>
        <a href="<?= base_url('pesanan'); ?>" class="button">Batal</a>
    </div>

    <?= form_close(); ?>

    <script>
    $(document).ready(function() {
        function fetchOptions(url, selector, dataKey, nameKey, priceKey, extraDataKey = null) {
            $.ajax({
                url: url,
                dataType: 'json',
                success: function(data) {
                    var options = '<option value="">--Pilih--</option>';
                    $.each(data, function(index, item) {
                        var extraData = extraDataKey ? ' data-' + extraDataKey + '="' + item[extraDataKey] + '"' : '';
                        options += '<option value="' + item[dataKey] + '" data-harga="' + item[priceKey] + '"' + extraData + '>' + item[nameKey] + '</option>';
                    });
                    $(selector).each(function() {
                        var selectedValue = $(this).val();
                        $(this).empty().append(options).val(selectedValue);
                    });
                },
                error: function(jqXHR, textStatus, errorThrown) {
                    console.error('Error fetching data:', textStatus, errorThrown);
                }
            });
        }

        function calculateTotal(element, qtySelector, priceSelector, totalSelector, extraSelector = null, extraDataKey = null) {
            var qty = parseFloat($(element).find(qtySelector).val()) || 0;
            var price = parseFloat($(element).find(priceSelector).find('option:selected').data('harga')) || 0;
            var total = qty * price;
            $(element).find(totalSelector).val(total.toFixed(2));
            if (extraSelector && extraDataKey) {
                var extraData = $(element).find(priceSelector).find('option:selected').data(extraDataKey) || '';
                $(element).find(extraSelector).val(extraData);
            }
            calculateOverallTotal();
        }

        function calculateOverallTotal() {
            var totalHarga = 0;
            $('.tot_hrgbahan, .tot_hrgbarang').each(function() {
                totalHarga += parseFloat($(this).val()) || 0;
            });
            $('.totalharga').val(totalHarga.toFixed(2));
        }

        function addItem(container, itemHtml, fetchFunction) {
            $(container).append(itemHtml);
            fetchFunction();
        }

        fetchOptions('<?= base_url('pesanan/fetch_barangs'); ?>', 'select[name="id_barang[]"]', 'id_barang', 'nama_barang', 'harga', 'ukuran');
        fetchOptions('<?= base_url('pesanan/fetch_bahans'); ?>', 'select[name="id_bahan[]"]', 'id_bahan', 'nama_bahan', 'hrg_bahan', 'satuan');

        $(document).on('change', 'select[name="id_barang[]"], .qty_barang', function() {
            calculateTotal($(this).closest('.detailbarang-item'), '.qty_barang', 'select[name="id_barang[]"]', '.tot_hrgbarang', '.Ukuran', 'ukuran');
        });

        $(document).on('change', 'select[name="id_bahan[]"], .qty_bahan', function() {
            calculateTotal($(this).closest('.detailbahan-item'), '.qty_bahan', 'select[name="id_bahan[]"]', '.tot_hrgbahan', '.Satuan', 'satuan');
        });

        $('#add-detailbarang').click(function() {
            addItem('#detailbarang-container', `
                <div class="detailbarang-item">
                    
                    <select name="id_barang[]">
                        <option value="">--Pilih Barang--</option>
                    </select>
                    <label for="file_desain">File Desain</label>
                    <input type="file" name="file_desain[]">
                    <label for="qty_barang">Qty</label>
                    <input type="number" name="qty_barang[]" class="qty_barang" min="1">
                    <label for="Ukuran">Ukuran</label>
                    <input type="text" name="Ukuran[]" class="Ukuran" readonly>
                    <label for="tot_hrgbarang">Total</label>
                    <input type="text" name="tot_hrgbarang[]" class="tot_hrgbarang" readonly>
                    <button type="button" class="hps_dbarang">Hapus</button>
                </div>`,
                function() { fetchOptions('<?= base_url('pesanan/fetch_barangs'); ?>', 'select[name="id_barang[]"]', 'id_barang', 'nama_barang', 'harga', 'ukuran'); });
        });

        $('#add-detailbahan').click(function() {
            addItem('#detailbahan-container', `
                <div class="detailbahan-item">
                    <label for="id_bahan">ID Bahan</label>
                    <select name="id_bahan[]" class="id_bahan">
                        <option value="">--Pilih Bahan--</option>
                    </select>
                    <label for="qty_bahan">Qty</label>
                    <input type="number" min="1" name="qty_bahan[]" class="qty_bahan">
                    <label for="Satuan">Satuan</label>
                    <input type="text" name="Satuan[]" class="Satuan" readonly>
                    <label for="tot_hrgbahan">Total</label>
                    <input type="text" name="tot_hrgbahan[]" class="tot_hrgbahan" readonly>
                    <button type="button" class="hps_dbahan">Hapus</button>
                </div>`,
                function() { fetchOptions('<?= base_url('pesanan/fetch_bahans'); ?>', 'select[name="id_bahan[]"]', 'id_bahan', 'nama_bahan', 'hrg_bahan', 'satuan'); });
        });

        $(document).on('click', '.hps_dbarang, .hps_dbahan', function() {
            $(this).closest('.detailbarang-item, .detailbahan-item').remove();
            calculateOverallTotal();
        });

        // Initial calculation on page load
        $('input[name^="qty_barang"]').each(function() {
            calculateTotal($(this).closest('.detailbarang-item'), '.qty_barang', 'select[name="id_barang[]"]', '.tot_hrgbarang', '.Ukuran', 'ukuran');
        });
        $('input[name^="qty_bahan"]').each(function() {
            calculateTotal($(this).closest('.detailbahan-item'), '.qty_bahan', 'select[name="id_bahan[]"]', '.tot_hrgbahan', '.Satuan', 'satuan');
        });
    });
</script>

</body>
</html>
