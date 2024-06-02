<?php
session_start();
if (!isset($_SESSION['teacher']))
    header("Location: ../index.php");

include '../database/config.php';
$jadwal = $_GET['jadwal'];
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAS- Rekap</title>
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
                    <b><?= $_SESSION['teacher']['nama_lengkap']?> </b>
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
                    <b><?= $_SESSION['teacher']['nama_lengkap']?> </b>
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
                                    $query = "SELECT G.id AS kelompok_id, G.name AS group_name, JK.urut, T.nama AS tema, 
                                        S.nama AS sesi, S.keterangan, R.nama AS ruangan FROM siswa_nilai AS SJ 
                                        JOIN jadwal_kelompok AS JK ON JK.id = SJ.jadwal_kelompok_id
                                        JOIN jadwal AS U ON U.id = JK.ujian_id 
                                        JOIN kelompok AS G ON G.id = JK.group_id 
                                        JOIN tema AS T ON T.id = U.tema 
                                        JOIN sesi AS S ON S.id = U.sesi 
                                        JOIN ruangan AS R ON R.id = U.ruangan
                                        WHERE SJ.jadwal_kelompok_id = '$jadwal'  
                                        LIMIT 1";

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
                                                                    <div class="col-md-12">
                                                                        <p><b>REKAP PENILAIAN</b></p>
                                                                        <p>Urutan <?= $row['urut'] . " - Kelompok <b>" . $row['group_name'] . "</b>"; ?></p>
                                                                        <p><?= $row['tema']; ?></p>
                                                                        <p><?= $row['sesi'] . " (" . $row['keterangan'] . ")"; ?></p>
                                                                        <p><?= $row['ruangan']; ?></p>
                                                                    </div>
                                                                </div>

                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>

                                            <div class="row">
                                                <?php
                                                    $query2 = "SELECT S.* FROM kelompok_siswa AS GS 
                                                        JOIN siswa AS S ON S.id = GS.siswa_id 
                                                        WHERE GS.group_id = " . $row['kelompok_id'];
                                                    $result2 = mysqli_query($conn, $query2);
                                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                                        $id_siswa = $row2['id'];
                                                ?>
                                                        <div class="col-md-4" id="row" style="display:block;">
                                                            <div class="card" style="background: #ededed;margin:20px 10px 0px 10px;">
                                                                <div class="card-body">
                                                                    <div class="container">
                                                                        <h6><?= $row2['nama'] ?></h6>
                                                                        <p><?= $row2['nis'] ?></p>
                                                                        <hr>
                                                                        <?php
                                                                        $n = [0, 0, 0, 0, 0, 0, 0];
                                                                        $i = 0;
                                                                        $query3 = "SELECT SJ.*, P.pertanyaan FROM siswa_nilai AS SJ 
                                                                                    JOIN pertanyaan AS P ON P.id = SJ.question_id 
                                                                                    WHERE SJ.siswa_id = $id_siswa AND jadwal_kelompok_id = $jadwal AND teacher_id = " . $_SESSION['teacher']['id'] .
                                                                                    " ORDER BY P.id ASC";
                                                                        $result3 = mysqli_query($conn, $query3);
                                                                        if (mysqli_num_rows($result3) > 0) {
                                                                            while ($row3 = mysqli_fetch_assoc($result3)) {
                                                                                echo "<p>" . $row3['pertanyaan'] . " : <b>" . $row3['nilai'] . "</b></p>";
                                                                                $n[$i] = $row3['nilai'];
                                                                                $i++;
                                                                            }
                                                                            echo "<br/>";
                                                                            echo "<p><b>PENAMPILAN: " . number_format(($n[0] + $n[1] + $n[2]) / 3, 2) . "</b></p>";
                                                                            echo "<p><b>PEMAHAMAN: " . number_format(($n[3] + $n[4]) / 2, 2) . "</b></p>";
                                                                            echo "<p><b>LITERASI: " . number_format($n[5], 2) . "</b></p>";
                                                                            echo "<p><b>NUMERASI: " . number_format($n[6], 2) . "</b></p>";
                                                                            $na = ((($n[0] + $n[1] + $n[2]) / 3) + (($n[3] + $n[4]) / 2) + $n[5] + $n[6]) / 4;
                                                                            echo "<p><b>NILAI AKHIR: " . number_format($na, 2) . "</b></p>";
                                                                        } else {
                                                                            echo "TIDAK HADIR";
                                                                        }                                                                        
                                                                        ?>

                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                        ?>
                                                        
                                            </div>
                                            <?php
                                            }

                                        } else {
                                            echo 'Data not found';
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