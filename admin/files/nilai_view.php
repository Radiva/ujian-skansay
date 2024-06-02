<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <link rel="apple-touch-icon" sizes="76x76" href="../assets/img/apple-icon.png">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.css">
  <link rel="icon" type="image/png" href="../assets/img/favicon.png">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1" />
  <meta name="robots" content="noindex">
  <meta http-equiv="pragma" content="no-cache" />
  <meta http-equiv="expires" content="-1" />
  <title>
    <?= ucfirst(basename($_SERVER['PHP_SELF'], ".php")); ?>
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
            <a class="navbar-brand" href="#pablo">View Rekap Data</a>
          </div>
          <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navigation" aria-controls="navigation-index" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
            <span class="navbar-toggler-bar navbar-kebab"></span>
          </button>
          <!-- <?php include "navitem.php"; ?> -->
        </div>
      </nav>
      <!-- End Navbar -->
      <div class="panel-header panel-header-sm">
      </div>
      <div class="content" style="min-height: auto;">
        <div class="row">
          <div class="col-md-12">
            <div class="card" style="min-height:400px;">
              <div class="card-header">
                <div class="row">
                  <div class="col-md-8">
                    <h5 class="title">All Rekap Data</h5>
                  </div>
                  <div class="col-md-2">
                    <select id="options" name="options" class="btn-round" required style="width:100%;">
                      <option id="" selected="true" value="" disabled="disabled">Select theme</option>

                    </select>
                  </div>
                  <div class="col-md-2">
                    <button onclick='populateTable()' class="btn btn-primary btn-block btn-round" style="margin-top:0px;margin-right:10px;width:100px !important;float:right !important;">FIND</button>
                    <button onclick='dataDownload()' class="btn btn-primary btn-block btn-round" style="margin-top:0px;margin-right:10px;width:120px !important;float:right !important;">DOWNLOAD</button>
                  </div>
                </div>
              </div>
              <div class="card-body">
                <!-- <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>"> -->
                <input type="hidden" name="general_settings" />
                <!-- table contact_table table-striped table-bordered -->
                <table id="schedule_table">
                  <thead>
                    <tr>
                      <th data-field="no">No</th>
                      <th data-field="kelas">Kelas</th>
                      <th data-field="kelompok">Kelompok</th>
                      <th data-field="nama">Nama</th>
                      <th data-field="p1" data-formatter="format_nilai">Penguji 1</th>
                      <th data-field="p2" data-formatter="format_nilai">Penguji 2</th>
                      <th data-field="p3" data-formatter="format_nilai">Penguji 3</th>
                      <th data-field="rt" data-formatter="format_nilai">Rata-rata</th>
                    </tr>
                  </thead>
                </table>
                <!-- </form> -->
              </div>
            </div>
          </div>
        </div>
      </div>
      <form method="POST" action="delete_data.php" id="delete_data">
        <input type="hidden" id="data_id_delete" name="data_id_delete">
        <input type="hidden" name="data_table_delete" value="student">
      </form>

      <form method="POST" action="student_new.php" id="edit_data">
        <input type="hidden" id="data_id_edit" name="data_id_edit">
        <input type="hidden" id="data_nama_edit" name="data_nama_edit">
      </form>
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-table/1.10.1/bootstrap-table.min.js"></script>
</body>
<script>
  var total_count;
  $(document).ready(function() {
    $.ajax({
      type: 'POST',
      url: 'get_themes.php',
      success: function(response) {
        var opts = $.parseJSON(response);
        $.each(opts, function(i, d) {
          $('#options').append('<option value="' + d['id'] + '">' + d['nama'] + '</option>');
        });
      }
    });
  });

  function populateTable() {
    $.ajax({
      type: 'POST',
      url: 'get_rekap_from_theme.php',
      data: {
        'theme_name': $('#options option:selected').val(),
      },
      datatype: 'json',
      success: function(response) {
        $('#schedule_table').bootstrapTable('destroy');
        var jsondata = JSON.parse(response);
        $('#schedule_table').bootstrapTable({
          data: jsondata,
        });
      }
    });
  }

  function dataDownload() {
    $id = $('#options option:selected').val();
    window.open("nilai_download.php?id=" + $id);
  }

  function format_nilai(value, row) {
    return Number(value[4]).toFixed(2);
  }

  function TableActions(value, row, index) {
    curID = row["id"];
    return [

    ].join('');
  }
</script>

</html>