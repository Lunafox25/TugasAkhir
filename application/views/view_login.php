<!DOCTYPE html>
<html>
<head>
    <title>Login</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/login.css'); ?>">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
</head>
<body>
    <div class="overlay">
        <form method="post" action="<?php echo site_url('login/validate'); ?>">
        <input type="hidden" name="<?php echo $this->security->get_csrf_token_name();?>" value="<?php echo $this->security->get_csrf_hash();?>">
            <div class="con">
                <header class="head-form">
                    <h2>Log In</h2>
                    <p>Masukkan username dan password anda</p>
                    <?php if ($this->session->flashdata('login_error')) : ?>
                        <p style="color: red;"><?php echo $this->session->flashdata('login_error'); ?></p>
                    <?php endif; ?>
                </header>
                <br>
                <div class="field-set">
                    <span class="input-item">
                        <i class="fa fa-user-circle"></i>
                    </span>
                    <input class="form-input" id="txt-input" type="text" placeholder="@Username" name="username" required>
                    <br>
                    <span class="input-item">
                        <i class="fa fa-key"></i>
                    </span>
                    <input class="form-input" id="pwd" type="password" placeholder="Password" name="password" required>
                    <span>
                    <i class="fa fa-eye" aria-hidden="true" type="button" id="eye"></i>
                    </span>
                    <br>
                    <button class="log-in" type="submit"> Login </button>
                </div>
            </div>
        </form>
    </div>
    <script src="<?php echo base_url('assets/js/login.js'); ?>"></script>
</body>
</html>
