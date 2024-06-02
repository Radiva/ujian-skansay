<?php
session_start();
if(!isset($_SESSION["user_id"]))
  header("Location:../index.php");

include '../../database/config.php';
if(isset($_POST['new_class'])) {
  $name = $_POST['name'];

  //creating new class
  $sql = "INSERT INTO class(nama) VALUES('$name')";
  $result = mysqli_query($conn,$sql);
  if($result) {
    header("Location:classes_view.php");
  }
}

if(isset($_POST['update_class'])) {
  $name = $_POST['name'];
  $id = $_POST['id'];

  //creating new class
  $sql = "UPDATE class SET nama = '$name' WHERE id = $id";
  $result = mysqli_query($conn,$sql);
  if($result) {
    header("Location:classes_view.php");
  }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="robots" content="noindex">
  <meta http-equiv="pragma" content="no-cache" />
  <meta http-equiv="expires" content="-1" />
  <title>
    <?=ucfirst(basename($_SERVER['PHP_SELF'], ".php"));?>
  </title>
  <meta content='width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=0, shrink-to-fit=no' name='viewport' />
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Montserrat:400,700,200" rel="stylesheet" />
  <!-- <link href="https://use.fontawesome.com/releases/v5.0.6/css/all.css" rel="stylesheet"> -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <!-- CSS Files -->
  <link href="../assets/css/bootstrap.min.css" rel="stylesheet" />
  <link href="../assets/css/now-ui-dashboard.css?v=1.1.0" rel="stylesheet" />
  <!-- <link type="text/css" rel="stylesheet" href="http://jqueryte.com/css/jquery-te.css" charset="utf-8"> -->
  <link href="../assets/css/main.css" rel="stylesheet" />
</head>

<body class="">
  <div class="wrapper ">
    <!-- sidebar -->
    <?php
      include "sidebar.php";
    ?>
    <div class="main-panel">
      <!-- Navbar -->
      <nav class="navbar navbar-expand-lg navbar-transparent  navbar-absolute bg-primary fixed-top">
        <div class="container-fluid">
          <div class="navbar-wrapper">
            <div class="navbar-toggle">
              <button type="button" class="navbar-toggler">
                <span class="navbar-toggler-bar bar1"></span>
                <span class="navbar-toggler-bar bar2"></span>
                <span class="navbar-toggler-bar bar3"></span>
              </button>
            </div>
            <a class="navbar-brand" href="#pablo">Classes</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <?php include "navitem.php"; ?>
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>

      <div class="content" style="min-height: auto;">
        <div class="row">
          <div class="col-md-2"></div>  
          <div class="col-md-8">
            <div class="card">
              <div class="card-header">
                <h5 class="title">Create New Class</h5>
              </div>
              <div class="card-body">
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]);?>">
                  <?php
                  if(isset($_POST['data_id_edit'])) {
                    $id = $_POST['data_id_edit'];
                    $data = "SELECT nama FROM class WHERE id=$id";
                    $result = mysqli_query($conn, $data);
                    while($row = mysqli_fetch_assoc($result)) {
                      
                    ?>
                    
                    <input type="hidden" name="update_class">
                    <input type="hidden" name="id" value="<?= $id;?>">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Class Name</label>
                            <input type="text" class="form-control" value="<?= $row['nama'];?>" disabled/>
                        </div>
                      </div>
                    </div>
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Edit Class Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Edit class name" required/>
                        </div>
                      </div>
                    </div>
                    <div class="row center-element">
                      <div class="col-md-8">
                        <div class="form-group">
                          <button class="btn btn-primary btn-block btn-round">UPDATE CLASS</button>
                        </div>
                      </div>
                    </div>

                    <?php
                    
                    }
                  } else {
                    ?>
                    
                    <input type="hidden" name="new_class">
                    <div class="row">
                      <div class="col-md-12">
                        <div class="form-group">
                          <label>Class Name</label>
                            <input type="text" class="form-control" name="name" placeholder="Class name" required/>
                        </div>
                      </div>
                    </div>
                    <div class="row center-element">
                      <div class="col-md-8">
                        <div class="form-group">
                          <button class="btn btn-primary btn-block btn-round">CREATE CLASS</button>
                        </div>
                      </div>
                    </div>
                    
                    <?php
                  }
                  ?>
                  
                </form>
              </div>
            </div>
          </div>
          <div class="col-md-2"></div>
        </div>
      </div>
      <!-- footer -->
      <?php
        include "footer.php";
      ?>
    </div>
  </div>
  <!--   Core JS Files   -->
  <script src="../assets/js/core/jquery.min.js"></script>
  <script src="../assets/js/core/bootstrap.min.js"></script>
  <script src="../assets/js/plugins/perfect-scrollbar.jquery.min.js"></script>
  <!--  Notifications Plugin    -->
  <script src="../assets/js/plugins/bootstrap-notify.js"></script>
  <!-- Control Center for Now Ui Dashboard: parallax effects, scripts for the example pages etc -->
  <script src="../assets/js/now-ui-dashboard.min.js?v=1.1.0" type="text/javascript"></script>
  <!-- <script src="http://jqueryte.com/js/jquery-te-1.4.0.min.js"></script> -->
</body>
</html>