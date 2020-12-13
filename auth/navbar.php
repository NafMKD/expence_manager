<?php 

if(!isset($_SESSION['id'])){
  header("location: /?session");
}
?>

<nav class="main-header navbar navbar-expand-md navbar-light navbar-white">
    <div class="container">
      <a href="/auth/" class="navbar-brand ml-2">
        <img src="../assets/dist/img/AdminLTELogo.png" alt="AdminLTE Logo" class="brand-image img-circle elevation-3"
             style="opacity: .8">
        <span class="brand-text font-weight-light ml-2"><b>Linose</b>-<em>Stodio</em></span>
      </a>
      
      <input type="hidden" name="UserIDForInsert" value="<?php echo $_SESSION['id']; ?>">
      <div class="collapse navbar-collapse order-3" id="navbarCollapse">

        <ul class="navbar-nav">
          
        </ul>

      </div>


      <ul class="order-1 order-md-3 navbar-nav navbar-no-expand ml-auto">
        <li class="nav-item mr-1">
            <a class="nav-link text-red" href="../logout.php" role="button">
                Log out <i class="fas fa-sign-out-alt ml-1"></i>
            </a>
        </li>
      </ul>

    </div>
  </nav>
