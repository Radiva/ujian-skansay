<?php
session_start();
if (!isset($_SESSION['teacher']))
    header("Location: ../index.php");

include '../database/config.php';

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
                                    <form method="POST" action="kirim_nilai.php">
                                        <input type="hidden" name="kirim_nilai" value="<?= $_POST['jadwal_id']; ?>">
                                        <input type="hidden" name="guru_id" value="<?= $_SESSION['teacher']['id']; ?>">
                                        <input type="hidden" name="group_id" value="<?= $_POST['group_id']; ?>">
                                        <input type="hidden" name="sesi" value="<?= $_POST['id_sesi']; ?>">
                                        <input type="hidden" name="ruangan" value="<?= $_POST['id_ruangan']; ?>">
                                        <div class="row">
                                            <div class="col-md-12" id="row" style="display:block;">
                                                <div class="card" style="background: #ededed;margin:20px 10px 0px 10px;">
                                                    <div class="card-body">
                                                        <div class="container">
                                                            <div class="row">
                                                                <div class="col-md-12">
                                                                    <p><b>PENILAIAN</b></p>
                                                                    <p>Urutan <?= $_POST['urut'] . " - Kelompok <b>" . $_POST['group_name'] . "</b>"; ?></p>
                                                                    <p><?= $_POST['tema']; ?></p>
                                                                    <p><?= $_POST['sesi'] . " (" . $_POST['keterangan'] . ")"; ?></p>
                                                                    <p><?= $_POST['ruangan']; ?></p>
                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="row">
                                            <?php
                                            foreach ($_POST['siswa'] as $key => $value) {
                                                if ($value['hadir']) {
                                            ?>
                                                    <div class="col-md-4" id="row" style="display:block;">
                                                        <div class="card" style="background: #ededed;margin:20px 10px 0px 10px;">
                                                            <div class="card-body">
                                                                <div class="container">
                                                                    <input type="hidden" name="siswa_id[<?= $nmr; ?>]" value="<?= $value['hadir']; ?>">
                                                                    <h6><?= $value['nama'] ?></h6>
                                                                    <p><?= $value['nis'] ?></p>
                                                                    <hr>

                                                                    <?php
                                                                    $query3 = "SELECT * FROM pertanyaan";
                                                                    $result3 = mysqli_query($conn, $query3);
                                                                    while ($row3 = mysqli_fetch_assoc($result3)) {
                                                                        echo "<p><b>" . $row3['pertanyaan'] . "</b></p>";
                                                                        echo '<input type="hidden" name="pertanyaan_id[' . $nmr . '][]" value="' . $row3['id'] . '">';
                                                                        echo '<input type="number" name="jawaban[' . $nmr . '][]" min=0 max=100 required style="width:100%;margin-bottom:10px;border-style: solid;border-width:3px;">';
                                                                    }
                                                                    ?>

                                                                </div>
                                                            </div>
                                                        </div>
                                                    </div>

                                            <?php
                                                    $nmr++;
                                                }
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
                                                                    <button type="submit" class="btn btn-success" style="float:right;">Kirim Nilai</button>
                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>
        </div>
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