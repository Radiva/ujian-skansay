<?php
session_start();
if (!isset($_SESSION['teacher']))
    header("Location: ../index.php");

include '../database/config.php';

?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAS- Kelompok</title>
    <link rel="icon" type="image/png" href="../admin/assets/img/favicon.png">
    <link rel="stylesheet" type="text/css" href="../vendor/bootstrap/css/bootstrap.min.css">
    <link rel="stylesheet" type="text/css" href="../css/header.css">
    <link rel="stylesheet" type="text/css" href="../css/util.css">
    <link rel="stylesheet" type="text/css" href="../css/main.css">
    <script src="../vendor/jquery/jquery-3.2.1.min.js"></script>
    <script src="../vendor/bootstrap/js/bootstrap.min.js"></script>
    <script src="../vendor/tilt/tilt.jquery.min.js"></script>
    <script src="https://cdn.jsdelivr.net/npm/js-cookie@beta/dist/js.cookie.min.js"></script>

</head>

<body>
    <!-- Header -->
    <header class="header1">
        <!-- Header desktop -->
        <div class="container-menu-header">
            <div class="wrap_header">
                <!-- Logo -->
                <a href="../index.php" class="logo">
                    <img src="../images/icons/logo.png" alt="IMG-LOGO">
                </a>

                <!-- Header Icon -->
                <div class="header-icons">
                    <b><?= $_SESSION['teacher']['nama_lengkap'] ?> </b>
                    <a href="end_session.php" class="header-wrapicon1 dis-block">
                        <img src="../images/icons/logout.png" class="header-icon1" alt="ICON">
                    </a>
                </div>
            </div>
        </div>

        <!-- Header Mobile -->
        <div class="wrap_header_mobile">
            <!-- Logo moblie -->
            <a href="../index.php" class="logo-mobile">
                <img src="../images/icons/logo.png" alt="IMG-LOGO">
            </a>

            <!-- Button show menu -->
            <div class="btn-show-menu">
                <!-- Header Icon mobile -->
                <div class="header-icons-mobile">
                    <b><?= $_SESSION['teacher']['nama_lengkap'] ?> </b>
                    <a href="end_session.php" class="header-wrapicon1 dis-block">
                        <img src="../images/icons/logout.png" class="header-icon1" alt="ICON">
                    </a>
                </div>
            </div>
        </div>
        </div>
    </header>
    <section>
        <div class="limiter">
            <div class="container-login100" style="display:block;">
                <div class="container">
                    <div class="row">
                        <div class="col">
                            <div class="card" style="padding-bottom: 20px;">
                                <div class="container">
                                    <?php
                                    $sesi = $_GET['sesi'];
                                    $ruangan = $_GET['ruang'];
                                    $query = "SELECT JK.*, K.name FROM `jadwal_kelompok` AS JK 
                                        JOIN kelompok AS K ON K.id = JK.group_id 
                                        JOIN jadwal AS J ON J.id = JK.ujian_id
                                        WHERE J.sesi = '$sesi' AND J.ruangan = '$ruangan'
                                        ORDER BY JK.urut ASC";

                                    $result = mysqli_query($conn, $query);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>
                                            <div class="row">
                                                <div class="col-md-12" id="row" style="display:block;">
                                                    <div class="card" style="background: #ededed;margin:20px 10px 0px 10px;">
                                                        <div class="card-body">
                                                            <div class="container">
                                                                <div class="row">
                                                                    <div class="col-md-8">
                                                                        <p><b><?= $row['name']; ?></b></p>
                                                                        <?php
                                                                        $query2 = "SELECT S.* FROM kelompok_siswa AS KS 
                                                                            JOIN siswa AS S ON S.id = KS.siswa_id 
                                                                            WHERE KS.group_id = '" . $row['group_id'] . "'";

                                                                        $result2 = mysqli_query($conn, $query2);
                                                                        if (mysqli_num_rows($result2) > 0) {
                                                                            while ($row2 = mysqli_fetch_assoc($result2)) {
                                                                                echo "<p>&#x25cf " . $row2['nama'] . " (" . $row2['nis'] . ")</p>";
                                                                            }
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                    <div class="col-md-4">
                                                                        <?php
                                                                        $query3 = "SELECT * FROM siswa_nilai 
                                                                        WHERE jadwal_kelompok_id = '" . $row['id'] . "' AND teacher_id = '" . $_SESSION['teacher']['id'] . "'";

                                                                        $result3 = mysqli_query($conn, $query3);
                                                                        if (mysqli_num_rows($result3) > 0) {
                                                                        ?>
                                                                            <a href="rekap.php?jadwal=<?= $row['id']; ?>"><button type="button" class="btn btn-info" style="float:right;">Rekap Nilai</button></a>
                                                                        <?php
                                                                        } else {
                                                                        ?>
                                                                            <a href="cek_hadir.php?jadwal=<?= $row['id']; ?>"><button type="button" class="btn btn-success" style="float:right;">Penilaian</button></a>
                                                                        <?php
                                                                        }
                                                                        ?>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                    <?php
                                        }
                                    } else {
                                        echo "Data Not Found";
                                    }
                                    ?>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <script>
        function isEmpty(str) {
            return (!str || 0 === str.length);
        }

        // $(document).ready(function () {
        //     $.ajax({
        //         type: 'POST',
        //         url: 'get_dashboard_contents.php',
        //         success: function (response) {
        //             console.log('hi');
        //             console.log(response);
        //             console.log(response.length);
        //             if(response.length > 0) {
        //                 console.log('not');
        //                 var temp = document.getElementById('row');
        //                 temp.style.display = 'block';
        //                 $('#test_name').text(response);
        //             }
        //         }
        //     });
        // });

        function logout() {
            $.ajax({
                type: 'POST',
                url: 'end_session.php',
                // data: {
                //     'message': '1',
                // },
                success: function(msg) {
                    alert(msg);
                    // Cookies.remove('last_question_was_answered');
                    // Cookies.remove('last_question');
                    // Cookies.set('test_submitted_status', msg.toString());
                    // window.location.replace("test_finished.php");
                    window.location.replace("../index.php");
                }
            });
        }



        <?php
        session_start();

        if (!isset($_SESSION['teacher'])) {
            echo "You are not logged in";
            header("Location: ../index.php");
        }

        function createCard(array $row)
        { ?>

        <?php } ?>
    </script>
</body>

</html>