<?php 
session_start();
include 'auto.php';
$obj_fetch = new fetch;
$obj_update = new update;
if (!isset($_GET['email']) || !isset($_GET['token'])) {
  header("location: /?session");
}

if (!isset($_GET['email']) && !isset($_GET['token'])) {
  header("location: /?session");
}

$arrUser = $obj_fetch->fethUserDeail("EMAIL", $_GET['email'])[0];

if ($_GET['token'] != md5($arrUser['password'])) {
  header("location: /?token");
}

echo $arrUser['id'];

if (isset($_POST['btnChange'])) {
  $pass = $_POST['password'];

  $recmsg = $obj_update->changePassword($arrUser['id'],$pass);
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
      <p class="login-box-msg">Reset Password</p>

      <form method="post">
        <?php if(isset($recmsg)): ?>
          <div class='alert alert-danger'>
            <center>
              <i class='icon fa fa-times-circle'></i>
              <?php if($recmsg == 0): ?>
                Something went wrong, Please start again!
              <?php endif?>
              <br>
            </center>
          </div>
        <?php endif?>
        
          <?php if(isset($_GET['email'])) :?>
            <dl class="row">
              <dt class="col-3">Email:</dt>
              <dd class="col-9"><?php echo $_GET['email']; ?></dd>
              <input type="hidden" class="form-control" value="<?php echo $_GET['email']; ?>" name="emailID">
            </dl>
          <?php endif ?>
        
        <div class="input-group mb-3">
          <input type="password" class="form-control" placeholder="New Password" name="password">
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
            <button type="submit" name="btnChange" class="btn btn-primary btn-block">Change</button>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-0">
        <a href="/" class="text-center">Log in</a>
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
  $('button[name="btnChange"]').on('click',function(){
    $('button[name="btnChange"]').html("Changing ..");
  });
  const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

  <?php if(isset($_GET['errAccount'])): ?>
    Toast.fire({
      icon: 'error',
      title: 'This account is not active. Verify your email!'
    })
      
    <?php endif ?>
</script>
</body>
</html>
