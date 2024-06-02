<?php
session_start();
if (!isset($_SESSION['teacher']))
    header("Location: ../index.php");

include '../database/config.php';
$jadwal = $_GET['jadwal'];
$nmr = 0;
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAS- Penilaian</title>
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

                                    $query = "SELECT U.id, G.id AS group_id, G.name AS group_name, UG.urut, T.nama AS tema, 
                                            S.id AS sesi_id, S.nama AS sesi, S.keterangan, 
                                            R.id AS ruangan_id, R.nama AS ruangan FROM jadwal_kelompok AS UG 
                                            JOIN jadwal AS U ON U.id = UG.ujian_id 
                                            JOIN kelompok AS G ON G.id = UG.group_id 
                                            JOIN tema AS T ON T.id = U.tema 
                                            JOIN sesi AS S ON S.id = U.sesi 
                                            JOIN ruangan AS R ON R.id = U.ruangan
                                            WHERE UG.id = '" . $jadwal . "'";

                                    $result = mysqli_query($conn, $query);
                                    if (mysqli_num_rows($result) > 0) {
                                        while ($row = mysqli_fetch_assoc($result)) {
                                    ?>

                                            <form method="POST" action="penilaian.php">
                                                <input type="hidden" name="jadwal_id" value="<?= $jadwal; ?>">
                                                <input type="hidden" name="urut" value="<?= $row['urut']; ?>">
                                                <input type="hidden" name="tema" value="<?= $row['tema']; ?>">
                                                <input type="hidden" name="sesi" value="<?= $row['sesi']; ?>">
                                                <input type="hidden" name="ruangan" value="<?= $row['ruangan']; ?>">
                                                <input type="hidden" name="id_sesi" value="<?= $row['sesi_id']; ?>">
                                                <input type="hidden" name="id_ruangan" value="<?= $row['ruangan_id']; ?>">
                                                <input type="hidden" name="group_name" value="<?= $row['group_name']; ?>">
                                                <input type="hidden" name="keterangan" value="<?= $row['keterangan']; ?>">
                                                <div class="row">
                                                    <div class="col-md-12" id="row" style="display:block;">
                                                        <div class="card" style="background: #ededed;margin:20px 10px 0px 10px;">
                                                            <div class="card-body">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <p><b>KEHADIRAN</b></p>
                                                                            <p>Urutan <?= $row['urut'] . " - Kelompok <b>" . $row['group_name'] . "</b>"; ?></p>
                                                                            <p><?= $row['tema'] ?></p>
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
                                                    WHERE GS.group_id = '" . $row['group_id'] . "'";

                                                    $result2 = mysqli_query($conn, $query2);
                                                    while ($row2 = mysqli_fetch_assoc($result2)) {
                                                    ?>
                                                        <div class="col-md-4" id="row" style="display:block;">
                                                            <div class="card" style="background: #ededed;margin:20px 10px 0px 10px;">
                                                                <div class="card-body">
                                                                    <div class="container">
                                                                        <input type="hidden" name="siswa[<?= $nmr ?>][nama]" value="<?= $row2['nama'] ?>">
                                                                        <input type="hidden" name="siswa[<?= $nmr ?>][nis]" value="<?= $row2['nis'] ?>">
                                                                        <h6><?= $row2['nama'] ?></h6>
                                                                        <p><?= $row2['nis'] ?></p>
                                                                        <select name="siswa[<?= $nmr ?>][hadir]" class="btn-round" required style="width:100%;margin-bottom:10px;">
                                                                            <option selected="true" value="<?= $row2['id']; ?>">Hadir</option>
                                                                            <option value="0">Tidak Hadir</option>
                                                                        </select>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                        </div>

                                                    <?php
                                                        $nmr++;
                                                    }
                                                    ?>
                                                </div>
                                                <div class="row">
                                                    <div class="col-md-12" id="row" style="display:block;">
                                                        <div class="card" style="background: #ededed;margin:20px 10px 0px 10px;">
                                                            <div class="card-body">
                                                                <div class="container">
                                                                    <div class="row">
                                                                        <div class="col-md-12">
                                                                            <button type="submit" class="btn btn-success" style="float:right;">Mulai Penilaian</button>
                                            </form>
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