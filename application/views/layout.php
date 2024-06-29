<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title><?php echo isset($title) ? $title : 'My Application'; ?></title>
    <link rel="stylesheet" href="<?php echo base_url('assets/css/style.css'); ?>">
</head>
<body>
    <!-- Sidebar -->
    <?php $this->load->view('sidebar', ['user' => $user]); ?>

    <!-- Main Content -->
    <div class="main-content">
        <?php 
        if (isset($main_view)) {
            $this->load->view($main_view); 
        } else {
            echo "<h1>Content Not Found</h1>";
        }
        ?>
    </div>

    <script src="<?php echo base_url('assets/js/sidebar.js'); ?>"></script>
</body>
</html>
