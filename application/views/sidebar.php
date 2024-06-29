<?php
$current_url = current_url();
?>

<div class="sidebar">
    <a href="<?php echo site_url('ubahprofil'); ?>" class="user-info-link">
    <div class="user-info">
        <p style="font-size: 20px; color: #ecf0f1;"><?php echo isset($user['nama_karyawan']) ? $user['nama_karyawan'] : 'Guest'; ?></p>
        <p style="font-size: 16px; color: #ecf0f1;"><?php echo isset($user['nama_jabatan']) ? $user['nama_jabatan'] : 'Guest'; ?></p>
    </div>
    </a>
    <ul class="nav">
        <?php if (isset($user['id_role']) && $user['id_role'] == 1): // Sidebar for admin ?>
            <li><a href="<?php echo site_url('dashboard'); ?>" class="<?php echo $current_url == site_url('dashboard') ? 'active' : ''; ?>">Dashboard</a></li>
            <li class="accordion">
                <a href="#" class="accordion-header"><span>Karyawan</span></a>
                <div class="accordion-content">
                    <ul>
                        <li><a href="<?php echo site_url('karyawan'); ?>" class="<?php echo $current_url == site_url('karyawan') ? 'active' : ''; ?>">Data Karyawan</a></li>
                        <li><a href="<?php echo site_url('jabatan'); ?>" class="<?php echo $current_url == site_url('jabatan') ? 'active' : ''; ?>">Data Jabatan</a></li>
                    </ul>
                </div>
            </li>
            <li class="accordion">
                <a href="#" class="accordion-header"><span>Pesanan</span></a>
                <div class="accordion-content">
                    <ul>
                        <li><a href="<?php echo site_url('pesanan'); ?>" class="<?php echo $current_url == site_url('pesanan') ? 'active' : ''; ?>">Data Pesanan</a></li>
                        <li><a href="<?php echo site_url('barang'); ?>" class="<?php echo $current_url == site_url('barang') ? 'active' : ''; ?>">Data Barang</a></li>
                        <li><a href="<?php echo site_url('bahan'); ?>" class="<?php echo $current_url == site_url('bahan') ? 'active' : ''; ?>">Data Bahan</a></li>
                    </ul>
                </div>
            </li>
        <?php elseif (isset($user['id_role']) && $user['id_role'] == 2): // Sidebar for employee ?>
            <li><a href="<?php echo site_url('pesanan'); ?>" class="<?php echo $current_url == site_url('pesanan/daftar') ? 'active' : ''; ?>">Daftar Pesanan</a></li>
            <li><a href="<?php echo site_url('barang'); ?>" class="<?php echo $current_url == site_url('barang') ? 'active' : ''; ?>">Data Barang</a></li>
            <li><a href="<?php echo site_url('bahan'); ?>" class="<?php echo $current_url == site_url('bahan') ? 'active' : ''; ?>">Data Bahan</a></li>
        <?php endif; ?>
    </ul>
    <form method="post" action="<?php echo site_url('login/logout'); ?>" class="logout-form">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>">
        <button type="submit" class="logout-button">Logout</button>
    </form>
</div>
