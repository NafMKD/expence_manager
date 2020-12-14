<?php 
session_start();
include 'auto.php';
$obj_fetch = new fetch;

###############################################
//first step
if (isset($_POST['btnSendCode'])) {
  $email = $_POST['email'];
  $recmsgone = $obj_fetch->emailChecker($email);


  if ($recmsgone == 1) {
    $obj_fetch->sendPassEmail($email);
    header("location: forget.php?email=".$email."");
  }else{
    $msg = "There is no account in this email.";
  }
}

//second step
if (isset($_POST['btnVerify'])) {
  $email = $_POST['email'];
  $code = $_POST['otcode'];

  $recmsg = $obj_fetch->emailVerify("PASSWORD",$email, $code);
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
              <?php if($recmsg == 2):?>
                There is no account with this email address!
              <?php elseif($recmsg == 0): ?>
                The code enterd was not valid!
              <?php endif?>
              <br>
            </center>
          </div>
        <?php endif?>

        <?php if(isset($msg)): ?>
          <div class='alert alert-danger'>
            <center>
              <i class='icon fa fa-times-circle'></i>
              <?php echo $msg; ?>
              <br>
            </center>
          </div>
        <?php endif?>
        <?php if(isset($_GET['email'])) :?>
            <dl class="row">
              <dt class="col-3">Email:</dt>
              <dd class="col-9"><?php echo $_GET['email']; ?></dd>
              <input type="hidden" class="form-control" value="<?php echo $_GET['email']; ?>" name="email">
              <dd class="col-12">* Enter the 6 digit code we send to your email.</dd>
            </dl>
          <?php else:?>
            <div class="input-group mb-3">
            <input type="email" class="form-control" placeholder="Email" name="email">
            <div class="input-group-append">
              <div class="input-group-text">
                <span class="fas fa-envelope"></span>
              </div>
            </div>
            </div>
          <?php endif ?>
          <?php if(isset($_GET['email'])) :?>
            <div class="input-group mb-3">
              <input type="text" class="form-control" placeholder="Verification Code" name="otcode">
              <div class="input-group-append">
                <div class="input-group-text">
                  <span class="fas fa-lock"></span>
                </div>
              </div>
            </div>
          <?php endif ?>
        <div class="row">
          <div class="col-5">
          </div>
          <!-- /.col -->
          <div class="col-7">
            <?php if(isset($_GET['email'])) :?>
              <button type="submit" name="btnVerify" class="btn btn-primary btn-block">Verify</button>
            <?php else: ?>
              <button type="submit" name="btnSendCode" class="btn btn-primary btn-block">Send Code</button>
            <?php endif ?>
          </div>
          <!-- /.col -->
        </div>
      </form>

      <p class="mb-1">
        <a href="/">Log in</a>
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
  $('button[name="btnSendCode"]').on('click',function(){
    $('button[name="btnSendCode"]').html("Sending ..");
  });
  $('button[name="btnVerify"]').on('click',function(){
    $('button[name="btnVerify"]').html("Verifying ..");
  });
  $(function(){
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 4000
    });
  });
</script>
</body>
</html>
