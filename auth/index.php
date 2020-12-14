<?php 
session_start();
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <meta http-equiv="x-ua-compatible" content="ie=edge">

  <title>Dashboard</title>

  <!-- Font Awesome Icons -->
  <link rel="stylesheet" href="../assets/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <!-- Google Font: Source Sans Pro -->
  <link href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700" rel="stylesheet">

</head>
<body class="hold-transition layout-top-nav">
<div class="wrapper">

<?php include 'navbar.php' ?>  

  <div class="content-wrapper">

    <div class="content-header">
      <div class="container">
        <div class="row mb-2">
          <div class="col-sm-6">
            <center><h1 class="m-0 text-dark">Control Panale</h1></center>
          </div>
        </div>
      </div>
    </div>


    <div class="content">
      <div class="container">
        <div class="row">

          <div class="col-lg-6">

            <button onclick="return redirect('exp')" class="btn btn-lg btn-primary" style="width: 100%;">
              Expense Tracker
            </button>

            <button onclick="return redirect('loan')" class="btn btn-lg btn-info mt-2" style="width: 100%;">
              Loan Tracker
            </button>


          </div>

        </div>

      </div>
    </div>

  </div>



  <footer class="main-footer">

    <div class="float-right d-none d-sm-inline">
      <b>Version</b> 1.0.0
    </div>

    <strong>Copyright &copy; 2020 <a href="https://saba-studio.herkuapp.com"><b>Saba</b> - <em>Studio</em></a>.</strong> All rights reserved.
  </footer>
</div>


<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../assets/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- Custom -->
<script>
  function redirect(d){
    if (d === 'exp') {
      window.location.assign("./expense.php");
    }else if(d === 'loan'){
      window.location.assign("./loan.php");
    }
    
  }
</script>
</body>
</html>
