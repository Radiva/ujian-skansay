<?php
session_start();
if (!isset($_SESSION['teacher']))
    header("Location: ../index.php");

include '../database/config.php';

$id = $_SESSION['teacher']['id'];
?>
<html>

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>PSAJ - Dashboard</title>
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
                            <div class="card">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12" id="row" style="display:block; margin:20px 10px 20px 10px;">
                                            <p><b><?= $_SESSION['teacher']['nama_lengkap'] . " (" . $_SESSION['teacher']['username'] . ")"; ?></b></p>
                                            <p>NIP. <?= $_SESSION['teacher']['nip'] ?></p>
                                            <p><?= $_SESSION['teacher']['ttl']; ?></p>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="row" style="margin-top: 20px;">
                        <div class="col">
                            <div class="card">
                                <div class="container">
                                    <div class="row">
                                        <div class="col-md-12" id="row" style="display:block; margin:20px 10px 20px 10px;">
                                            <center>
                                                <a href="ruangan_list.php"><button type="button" class="btn btn-success">Mulai Menguji</button></a><br />
                                                <!-- <a href="rekap_list.php"><button type="button" class="btn btn-info" style="margin-top: 20px;">Rekap Menguji</button></a><br /> -->
                                                <a href="end_session.php"><button type="button" class="btn btn-danger" style="margin-top: 20px;">Keluar</button></a>
                                            </center>
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