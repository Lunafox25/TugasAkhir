$(document).ready(function() {
    // Create JavaScript variables to hold the options for barang and bahan
    var barangOptions = `<?php foreach ($barangs as $barang): ?>
        <option value="<?= $barang->id_barang; ?>"><?= $barang->nama_barang; ?></option>
    <?php endforeach; ?>`;

    var bahanOptions = `<?php foreach ($bahans as $bahan): ?>
        <option value="<?= $bahan->id_bahan; ?>" data-harga="<?= $bahan->hrg_bahan; ?>"><?= $bahan->nama_bahan; ?></option>
    <?php endforeach; ?>`;

    // Add new detailbarang item
    $('#add-detailbarang').click(function() {
        var newDetailbarang = `
            <div class="detailbarang-item">
                <label for="id_barang">ID Barang</label>
                <select name="id_barang[]">
                    <option value="">--Pilih Barang--</option>
                    ${barangOptions}
                </select>
                <label for="file_desain">File Desain</label>
                <input type="file" name="file_desain[]">
                <label for="qty_barang">Qty Barang</label>
                <input type="number" name="qty_barang[]" value="">
                <label for="tot_hrgbarang">Total Harga Barang</label>
                <input type="text" name="tot_hrgbarang[]" readonly>
                <button type="button" class="hapus-detailbarang">Hapus</button>
            </div>
        `;
        $('#detailbarang-container').append(newDetailbarang);
    });

    // Add new detailbahan item
    $('#add-detailbahan').click(function() {
        var newDetailbahan = `
            <div class="detailbahan-item">
                <label for="id_bahan">ID Bahan</label>
                <select name="id_bahan[]" class="id_bahan" onchange="updateHargaBahan(this)">
                    <option value="">--Pilih Bahan--</option>
                    ${bahanOptions}
                </select>
                <input type="hidden" name="hrg_bahan[]" class="hrg_bahan">
                <label for="qty_bahan">Qty Bahan</label>
                <input type="number" name="qty_bahan[]" class="qty_bahan" onchange="calculateTotalHargaBahan(this)">
                <label for="tot_hrgbahan">Total Harga Bahan</label>
                <input type="text" name="tot_hrgbahan[]" class="tot_hrgbahan" readonly>
                <button type="button" class="hapus-detailbahan">Hapus</button>
            </div>
        `;
        $('#detailbahan-container').append(newDetailbahan);
    });

    // Function to update harga bahan
    window.updateHargaBahan = function(element) {
        var hargaBahan = $(element).find('option:selected').data('harga');
        $(element).closest('.detailbahan-item').find('.hrg_bahan').val(hargaBahan);
        calculateTotalHargaBahan($(element).closest('.detailbahan-item').find('.qty_bahan'));
    };

    // Function to calculate total harga bahan
    window.calculateTotalHargaBahan = function(element) {
        var item = $(element).closest('.detailbahan-item');
        var hargaBahan = item.find('.hrg_bahan').val();
        var qtyBahan = item.find('.qty_bahan').val();
        var totalHargaBahan = parseFloat(hargaBahan) * parseInt(qtyBahan);
        if (!isNaN(totalHargaBahan)) {
            item.find('.tot_hrgbahan').val(totalHargaBahan.toFixed(2));
        }
    };

    // Remove detailbarang item
    $(document).on('click', '.hapus-detailbarang', function() {
        $(this).closest('.detailbarang-item').remove();
    });

    // Remove detailbahan item
    $(document).on('click', '.hapus-detailbahan', function() {
        $(this).closest('.detailbahan-item').remove();
    });
});
