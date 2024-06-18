<!DOCTYPE html>
<html>
<head>
    <title>Login - Perancangan Website Rumah Makan</title>
    <link rel="stylesheet" type="text/css" href="<?php echo base_url('assets/css/bootstrap.css'); ?>">
    <script type="text/javascript" src="<?php echo base_url('assets/js/jquery.js'); ?>"></script>
    <script type="text/javascript" src="<?php echo base_url('assets/js/bootstrap.js'); ?>"></script>
    <style>
        body, html {
            height: 100%;
            margin: 0;
            display: flex;
            justify-content: center;
            align-items: center;
            background-image: url('<?php echo base_url('assets/image/background.jpg'); ?>');
            background-size: cover;
            background-repeat: no-repeat;
            background-position: center;
        }
        .login-container {
            width: 100%;
            max-width: 400px;
        }
        .login-panel {
            padding: 20px;
            background-color: rgba(255, 255, 255, 0.8); /* Semi-transparent white background */
            border-radius: 8px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
            text-align: center;
        }
        .login-panel img {
            max-width: 100%;
            height: auto;
            margin-bottom: 20px;
        }
    </style>
</head>
<body>
    <div class="login-container">
        <div class="login-panel">
            <center>
                <img src="<?php echo base_url('assets/image/logo.png'); ?>" alt="Logo Rental Mobil">
                <h3>LOGIN</h3>
            </center>
            <br />
            <?php
            if (isset($_GET['pesan'])) {
                if ($_GET['pesan'] == "gagal") {
                    echo "<div class='alert alert-danger'>Login gagal. Username dan password salah.</div>";
                } else if ($_GET['pesan'] == "logout") {
                    echo "<div class='alert alert-danger'>Anda telah logout.</div>";
                } else if ($_GET['pesan'] == "belumlogin") {
                    echo "<div class='alert alert-success'>Silahkan login dulu.</div>";
                }
            }
            ?>
            <div class="panel panel-default">
                <div class="panel-body">
                    <form method="post" action="<?php echo base_url('login/login'); ?>">
                        <div class="form-group">
                            <input type="text" name="username" placeholder="username" class="form-control">
                            <?php echo form_error('username'); ?>
                        </div>
                        <div class="form-group">
                            <input type="password" name="password" placeholder="password" class="form-control">
                            <?php echo form_error('password'); ?>
                        </div>
                        <div class="form-group">
                            <input type="submit" value="Login" class="btn btn-primary btn-block">
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
