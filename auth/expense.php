<?php 
session_start();
include 'auto.php';
$obj_fetch = new fetch;
$obj_register = new register;
$obj_calendar = new calendar;
$obj_update = new update;

$allgroups = $obj_fetch->fethExpenceGroup("BYUSER", $_SESSION['id']);


##########################################################

if(isset($_POST['btnAddExpGrp'])){
  $title = $_POST['expgrpName'];
  $disc = $_POST['expgrpDisc'];
  $date = $obj_calendar->toGrig($_POST['expgrpdate']);
  $userid = $_POST['UserIDForInsert'];

  $recmsg = $obj_register->registerExpenceGroup($userid, $title, $disc, $date);

  if (isset($_GET['netBalance'])) {
    header("location: expense.php?netBalance=".$_GET['netBalance']."&addGroup=".$recmsg."");
  }else{
    header("location: expense.php?addGroup=".$recmsg."");
  }
}


if(isset($_POST['btnAddExpInd'])){
  $title = $_POST['inpExpTitle'];
  $disc = $_POST['inpExpDisc'];
  $date = $obj_calendar->toGrig($_POST['inoExpDate']);
  $amount = $_POST['inpExpAmount'];
  $groupid = $_POST['selectExpGrp'];

  $recmsg = $obj_register->registerExpence($groupid, $title, $disc, $amount, $date);

  if (isset($_GET['netBalance'])) {
    header("location: expense.php?netBalance=".$_GET['netBalance']."&addExpenceInd=".$recmsg."");
  }else{
    header("location: expense.php?addExpenceInd=".$recmsg."");
  }
}


if (isset($_POST['btnCalExpGrp'])) {
  $id = $_POST['selectCalExpGrp'];

  header("location: expense.php?netBalance=".$id."");
}

if (isset($_POST['btnDeleteGrp'])) {
  $id = $_POST['inpDeleteGrp'];

  $obj_update->deleteExpenceGroup("INDIVIDUAL",$id);

  if (isset($_GET['netBalance'])) {
    header("location: expense.php?netBalance=".$_GET['netBalance']."&deleteGrup=".$id."");
  }else{
    header("location: expense.php?deleteGrup=".$id."");
  }
  
}

if (isset($_POST['btnDeleteExpen'])) {
  $id = $_POST['inpDeleteExpn'];

  $obj_update->deleteExpence("INDIVIDUAL",$id);

  if (isset($_GET['netBalance'])) {
    header("location: expense.php?netBalance=".$_GET['netBalance']."&deleteExpence=".$id."");
  }else{
    header("location: expense.php?deleteExpence=".$id."");
  }
  
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
  <link rel="stylesheet" href="../assets/fontawesome-free/css/all.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="../assets/dist/css/adminlte.min.css">
  <!-- Style style -->
  <link rel="stylesheet" href="../assets/style.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="../assets/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
  <!-- Select 2-->
  <link rel="stylesheet" href="../assets/select2/css/select2.min.css">
  <link rel="stylesheet" href="../assets/select2-bootstrap4-theme/select2-bootstrap4.min.css">
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
          <div class="col-sm-12">
            <center><h1 class="m-0 text-dark">Expense Tracker</h1></center>
          </div>
        </div>
      </div>
    </div>


    <div class="content mt-1">
      <div class="container">
        <div class="row">

          <div class="col-lg-12">
            <h4>Calculate Net Balance</h4>
            <form method="post">
            <select class="form-control select2" name="selectCalExpGrp">
              <option>-- Select Group --</option>
              <?php foreach($allgroups as $key): ?>
                <option value="<?php echo $key['id'];?>"> <?php echo $key['title'];?> </option>
              <?php endforeach ?>
            </select>
            <input type="submit"  class="btn btn-primary mt-3 mb-3"  name="btnCalExpGrp" value="Calculate">
            </form>

            <?php if(isset($_GET['netBalance'])): 
                $arrayNet = $obj_fetch->claculateNetBalace("EXPENCE",$_GET['netBalance']);
              ?>
            <h4>Net Balance</h4>
            <h1><?php echo number_format($arrayNet[2], 2); ?> <em>Br.</em></h1>

            <div class="row bg-light">
              <div class="col-sm-6 col-6">
                <div class="description-block border-right">
                  <h5 class="description-header text-green"><?php echo number_format($arrayNet[0], 2); ?> <em>Br.</em></h5>
                  <span class="description-text">INCOME</span>
                </div>
              </div>

              <div class="col-sm-6 col-6">
                <div class="description-block">
                  <h5 class="description-header text-red"><?php echo number_format(abs($arrayNet[1]), 2); ?> <em>Br.</em></h5>
                  <span class="description-text">EXPENSE </span>
                </div>
              </div>   
            </div>

            <?php endif?>
            <div class="row mt-2">

              <div class="col-lg-12">
                <h5 class="mb-0"><i class="fas fa-history text-sm"></i> History</h5> 
                <hr class="mt-0">
              </div>

              <div class="col-lg-12">

                    <div id="accordion">
                      <?php if(count($allgroups) > 0):?>
                      <?php 
                        foreach ($allgroups as $key):
                          $allExpGr = $obj_fetch->fethExpence("INDIVIDUAL", $key['id']);
                      ?>
                      <div class="card ">
                        <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $key['id']; ?>">
                          <div class="card-header bg-secondary">
                            <h4 class="card-title">
                              <b><?php echo $key['title']; ?></b> <!-- 17 Chars only-->
                            </h4>
                            <small class="float-right"><?php echo $obj_calendar->toEthStr($key['date']); ?></small>
                          </div>
                        </a>
                        <div id="collapse<?php echo $key['id']; ?>" class="panel-collapse collapse">
                          <div class="card-body p-1">

                            <?php if(count($allExpGr) > 0):?>
                            <?php foreach ($allExpGr as $keySec): 
                                if($keySec['amount'] < 0){
                                  $classNameDiv = "bg-danger";
                                }else{
                                  $classNameDiv = "bg-success";
                                }
                              ?>
                            <div id="accordion">
                              <div class="card ">
                                <a data-toggle="collapse" data-parent="#accordion" href="#collapse<?php echo $keySec['id']; ?>Two">
                                  <div class="card-header <?php echo $classNameDiv; ?>">
                                    <h4 class="card-title">
                                      <b><?php echo $keySec['title']; ?></b><!-- 15 Chars only-->
                                    </h4>
                                    <small class="float-right"><?php echo $keySec['amount']; ?> <em>Br.</em></small>
                                  </div>
                                </a>
                                <div id="collapse<?php echo $keySec['id']; ?>Two" class="panel-collapse collapse">
                                  <div class="card-body">
                                    <dl class="row">
                                      <dt class="col-sm-4">Description:</dt>
                                      <dd class="col-sm-8"><?php echo $keySec['discription']; ?></dd>
                                      <dt class="col-sm-4">Date:</dt>
                                      <dd class="col-sm-8"><?php echo $obj_calendar->toEthStr($keySec['date']); ?></dd>
                                    </dl>
                                    <hr>
                                    <div class="float-right">
                                      <form method="post">
                                        <input type="hidden" name="inpDeleteExpn" value="<?php echo $keySec['id'] ?>">
                                      <button type="submit" onclick="return confirm('Are You Sure Want to delet this data? (This data cannot be recoverd once you deleted!)')" name="btnDeleteExpen" class="btn btn-sm btn-danger"><i class="fas fa-trash mr-1"></i> Delete</button>
                                      </form>
                                    </div>
                                  </div>
                                </div>
                              </div>
                            </div>
                            <?php endforeach ?>
                            <?php else: ?>
                              <center class="text-red">No data available!</center>
                            <?php endif ?>
                            <hr>
                            <center>Group Description</center>
                            <dl class="row">
                              <dt class="col-sm-4">Description:</dt>
                              <dd class="col-sm-8"><?php echo $key['discription']; ?></dd>
                              <dt class="col-sm-4">Date:</dt>
                              <dd class="col-sm-8"><?php echo $obj_calendar->toEthStr($key['date']); ?></dd>
                            </dl>

                            <div class="float-right">
                              <form method="post">
                                <input type="hidden" name="inpDeleteGrp" value="<?php echo $key['id'] ?>">
                              <button type="submit" onclick="return confirm('Are You Sure Want to delet this data? Also sub groups will be deleted! (This data cannot be recoverd once you deleted!)')" name="btnDeleteGrp" class="btn btn-sm btn-danger"><i class="fas fa-trash mr-1"></i> Delete</button>
                              </form>
                            </div>

                            <hr>

                          </div>
                        </div>
                      </div>

                    <?php endforeach ?>
                      <?php else:?>
                        <center class="text-red">No data available!</center>
                      <?php endif?>

                    </div>
              </div>

            </div>

            <div class="row mt-2">
              
              <div class="col-lg-12">
                <h5 class="mb-0"><i class="fas fa-plus text-sm"></i> Add Information</h5> 
                <hr class="mt-0">
              </div>

              <div class="col-lg-12">

                <button onclick="return modalShow('addG')" class="btn btn-primary" style="width: 100%;">Add Group</button>
                <button onclick="return modalShow('addTG')" class="btn btn-primary mt-2" style="width: 100%;">Add Info. To Group</button>

              </div>

            </div>

          </div>

        </div>

      </div>
    </div>

  </div>


<div class="modal fade" id="modal-addGroup">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add Group:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
        <div class="modal-body">
          <input type="hidden" name="UserIDForInsert" value="<?php echo $_SESSION['id']; ?>">
          <div class="form-group">
            <label>Group Name: <small>max. 17 chars</small></label>
            <input type="text" class="form-control" name="expgrpName" placeholder="Group Name">
          </div>
          <div class="form-group">
            <label>Discription:</label>
            <textarea class="form-control" name="expgrpDisc"></textarea>
          </div>
          <div class="form-group">
            <label>Date:</label>
            <input type="text" class="form-control" name="expgrpdate" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="btnAddExpGrp" class="btn btn-primary float-right"><i class="fas fa-plus mr-2"></i> Add</button>
        </div>
      </form>
    </div>>
  </div>
</div>

<div class="modal fade" id="modal-addToGroup">
  <div class="modal-dialog">
    <div class="modal-content">
      <div class="modal-header">
        <h4 class="modal-title">Add To Group:</h4>
        <button type="button" class="close" data-dismiss="modal" aria-label="Close">
          <span aria-hidden="true">&times;</span>
        </button>
      </div>
      <form method="post">
        <div class="modal-body">
          <div class="form-group">
            <label>Selct Group: </label>
            <select class="form-control select2" name="selectExpGrp">
              <?php foreach($allgroups as $key): ?>
                <option value="<?php echo $key['id'];?>"> <?php echo $key['title'];?> </option>
              <?php endforeach ?>
            </select>
          </div>
          <div class="form-group">
            <label>Titel: <small>max. 15 chars</small></label>
            <input type="text" class="form-control" placeholder="Titel" name="inpExpTitle">
          </div>
          <div class="form-group">
            <label>Amount:</label>
            <input type="text" class="form-control" placeholder="Amount" name="inpExpAmount">
          </div>
          <div class="form-group">
            <label>Discription:</label>
            <textarea class="form-control" name="inpExpDisc"></textarea>
          </div>
          <div class="form-group">
            <label>Date:</label>
            <input type="text" class="form-control" name="inoExpDate" data-inputmask-alias="datetime" data-inputmask-inputformat="dd/mm/yyyy" data-mask>
          </div>
        </div>

        <div class="modal-footer">
          <button type="submit" name="btnAddExpInd" class="btn btn-primary float-right"><i class="fas fa-plus mr-2"></i> Add</button>
        </div>
      </form>
    </div>>
  </div>
</div>


  <footer class="main-footer">

    <div class="float-right d-none d-sm-inline">
      <b>Version</b> 1.0.0
    </div>

    <strong>Copyright &copy; 2020 <a href="https://saba-studio.herkuapp.com" target="_blank"><b>Saba</b>-<em>Studio</em></a>.</strong> All rights reserved.
  </footer>
</div>


<!-- REQUIRED SCRIPTS -->

<!-- jQuery -->
<script src="../assets/jquery/jquery.min.js"></script>
<!-- Bootstrap 4 -->
<script src="../assets/bootstrap/js/bootstrap.bundle.min.js"></script>
<!-- AdminLTE App -->
<script src="../assets/dist/js/adminlte.min.js"></script>
<!-- SweetAlert2 -->
<script src="../assets/sweetalert2/sweetalert2.min.js"></script>
<!-- Select 2 -->
<script src="../assets/select2/js/select2.full.min.js"></script>
<!-- Input mask-->
<script src="../assets/inputmask/min/jquery.inputmask.bundle.min.js"></script>
<!-- Custom -->
<script>
  $(function() {
    $('.select2').select2({
      theme: 'bootstrap4'
    });
    $('[data-mask]').inputmask();
  });
    const Toast = Swal.mixin({
      toast: true,
      position: 'top-end',
      showConfirmButton: false,
      timer: 3000
    });

    function modalShow(d){
      if (d === 'addG') {
        $('#modal-addGroup').modal('show');
        
      }else if(d === 'addTG'){
        $('#modal-addToGroup').modal('show');
        
      }
      
    }

    <?php if(isset($_GET['addGroup'])): ?>
      if(<?php echo $_GET['addGroup']; ?> == 1){
        Toast.fire({
              icon: 'success',
              title: 'Group Successfuly Added.'
            })
      }else if(<?php echo $_GET['addGroup']; ?> == 0){
        Toast.fire({
              icon: 'error',
              title: 'Something Went Wrong, Please Try Again.'
            })
      }
    <?php endif ?>

    <?php if(isset($_GET['addExpenceInd'])): ?>
      if(<?php echo $_GET['addExpenceInd']; ?> == 1){
        Toast.fire({
              icon: 'success',
              title: 'Expence Successfuly Added.'
            })
      }else if(<?php echo $_GET['addExpenceInd']; ?> == 0){
        Toast.fire({
              icon: 'error',
              title: 'Something Went Wrong, Please Try Again.'
            })
      }
    <?php endif ?>

    <?php if(isset($_GET['deleteGrup'])): ?>
        Toast.fire({
              icon: 'success',
              title: 'Group Successfuly Deleted.'
            })
      
    <?php endif ?>

    <?php if(isset($_GET['deleteExpence'])): ?>
        Toast.fire({
              icon: 'success',
              title: 'Expence Successfuly Deleted.'
            })
      
    <?php endif ?>

</script>
</body>
</html>
