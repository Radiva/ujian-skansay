<?php
    include "../database/config.php";

    echo '<pre>';
    var_dump($_POST);
    echo '</pre>';

    if (isset($_POST['kirim_nilai'])) {
        $sesi = $_POST['sesi'];
        $ruang = $_POST['ruangan'];
        $id_guru = $_POST['guru_id'];
        $id_jadwal = $_POST['kirim_nilai'];
        $siswa = $_POST['siswa_id'];
        $pertanyaan = $_POST['pertanyaan_id'];
        $jawaban = $_POST['jawaban'];
        
        foreach ($siswa as $key1 => $id_siswa) {
            echo 'siswa '.$key1.' - '.$id_siswa.'<br />';
            foreach ($pertanyaan[$key1] as $key2 => $value) {
                echo 'pertanyaan'.$key2.' - '.$value.'<br />';
                echo 'jawaban'.$jawaban[$key1][$key2].'<br />';
                $nilai = $jawaban[$key1][$key2];
                $sql = "INSERT INTO siswa_nilai(siswa_id, jadwal_kelompok_id, teacher_id, question_id, nilai) VALUES($id_siswa, $id_jadwal, $id_guru, $value, $nilai)";
                $result = mysqli_query($conn, $sql);
            }
        }

        if ($result) {
            header("Location:team_list.php?sesi=".$sesi."&ruang=".$ruang);
        }
    }

    mysqli_close($conn);
?>