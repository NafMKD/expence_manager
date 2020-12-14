<?php 
session_start();
include 'auto.php';
$obj_login = new login;

if(isset($_POST['btnLogin'])){
  $email = $_POST['email'];
  $pass = $_POST['password'];

  $msg = $obj_login->signin($email, $pass);
}


?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Dashboard</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="assets/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="assets/dist/css/adminlte.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="assets/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition login-page">
<div class="login-box">
  <div class="login-logo">
    <a href="#"><b>Linose</b>-Studio</a>
  </div>
  <!-- /.login-logo -->
  <div class="card">
    <div class="card-body login-card-body">
      <p class="login-box-msg">Sign in to start your session</p>

      <form method="post">
        <?php if(isset($msg)): ?>
          <div class='alert alert-danger'>
            <center>
              <i class='icon fa fa-times-circle'></i>
              <?php echo $msg; ?>
              <br>
            </center>
          </div>
        <?php endif?>
        <div class="input-group mb-3">
          <input type="email" class="form-control" placeholder="Email" name="email">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-envelope"></span>
            </div>
          </div>
        </div>
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="Password" name="password">
          <div class="input-group-append">
            <div class="input-group-text">
              <span class="fas fa-lock"></span>
            </div>
          </div>
        </div>
        <div class="row">
          <div class="col-5">
          </div>
          <!-- /.col -->
          <div class="col-7">
            <button type="submit" name="btnLogin" class="btn btn-primary btn-block">Sign In</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="forget.php">I forgot my password</a>
      </p>
      <p class="mb-0">
        <a href="newuser.php" class="text-center">Register a new membership</a>
      </p>
    </div>
    <!-- /.login-card-body -->
  </div>
</div>
<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="assets/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="assets/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="assets/sweetalert2/sweetalert2.min.js"></script>
<!-- Page Script -->
<script>
  $('button[name="btnLogin"]').on('click',function(){
    $('button[name="btnLogin"]').html("Signing you in ..");
  });
  $(function(){
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 4000
    });

    <?php if (isset($_GET['session'])): ?>
      Toast.fire({
        icon: 'error',
        title: 'The Page your tring to access is only for autherized users.'
      })
    <?php endif?>

    <?php if (isset($_GET['token'])): ?>
      Toast.fire({
        icon: 'error',
        title: 'The token you are using is not valid.'
      })
    <?php endif?>

  });
</script>
</body>
</html>
