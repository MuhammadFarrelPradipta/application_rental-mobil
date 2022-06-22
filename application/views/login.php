<!-- <?php
        phpinfo();
        ?> -->

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login - Rental Mobil Application </title>
    <link rel="stylesheet" href="<?php echo base_url() . 'assets/css/bootstrap.css' ?>">
    <script src="<?php echo base_url() . 'assets/js/jquery.js' ?>"></script>
    <script src="<?php echo base_url() . 'assets/js/bootstrap.js' ?>"></script>
</head>

<body>
    <div class="col-md-4 col-md-offset-4" style="margin-top:50px;">
        <center>
            <h2>Aplikasi Rental Mobil</h2>
            <h3>Login</h3>
        </center>
        <br>
        <?php
        if (isset($_GET['pesan'])) {
            if ($_GET['pesan'] == 'gagal') {
                echo "<div class='alert alert-danger'>Login gagal! username dan password salah.</div>";
            } else if ($_GET['pesan'] == 'logout') {
                echo "<div class='alert alert-danger'>Anda telah logout </div>";
            } else if ($_GET['pesan'] == 'belumlogin') {
                echo "<div class='alert alert-success'>Silahkan login dulu.</div>";
            }
        }
        ?>
        <br>
        <div class="panel panel-default">
            <div class="panel-body">
                <br>
                <br>
                <form method="post" action="<?php echo base_url() . 'welcome/login' ?>">
                    <div class="form-group">
                        <input type="text" name="username" placeholder="username" class="form-control">
                        <?php echo form_error('username'); ?>
                    </div>
                    <div class="form-group">
                        <input type="text" name="password" placeholder="password" class="form-control">
                        <?php echo form_error('password'); ?>
                    </div>
                    <div class="form-group">
                        <input type="submit" value="login" class="btn btn-primary">
                    </div>
                </form>
            </div>
        </div>
    </div>
</body>

</html>