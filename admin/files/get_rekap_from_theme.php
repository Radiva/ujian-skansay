<?php
	include "../../database/config.php";
    $id_theme = $_POST["theme_name"];

    // SElECT S.id, S.nama, S.nis, C.nama AS kelas, G.name AS kelompok, SJ.id FROM siswa AS S LEFT JOIN siswa_jawaban AS SJ ON SJ.siswa_id = S.id JOIN class AS C ON C.id = S.class_id JOIN grup_siswa AS GS ON GS.siswa_id = S.id JOIN `group` AS G ON G.id = GS.group_id
    // SELECT S.nama, S.nis, C.nama AS kelas, G.name AS kelompok, SJ.siswa_id, SJ.teacher_id, SUM(PP.bobot), P.id_category FROM `siswa_jawaban` AS SJ JOIN siswa AS S ON S.id = SJ.siswa_id JOIN pertanyaan_pilihan AS PP ON PP.ID = SJ.answer_id JOIN pertanyaan AS P ON P.id = PP.pertanyaan_id JOIN ujian AS U ON U.id = SJ.ujian_id JOIN class AS C ON C.id = S.class_id JOIN `group` AS G ON G.id = SJ.group_id WHERE U.tema = 1 GROUP BY P.id_category, SJ.siswa_id ORDER BY SJ.siswa_id, P.id_category

        // $query = "SELECT S.nama, S.nis, C.nama AS kelas, G.name AS kelompok, SJ.siswa_id, SJ.teacher_id, SUM(PP.bobot), P.id_category 
        //     FROM `siswa_jawaban` AS SJ 
        //     JOIN siswa AS S ON S.id = SJ.siswa_id 
        //     JOIN pertanyaan_pilihan AS PP ON PP.ID = SJ.answer_id 
        //     JOIN pertanyaan AS P ON P.id = PP.pertanyaan_id 
        //     JOIN ujian AS U ON U.id = SJ.ujian_id 
        //     JOIN class AS C ON C.id = S.class_id 
        //     JOIN `group` AS G ON G.id = SJ.group_id 
        //     WHERE U.tema = $id_theme GROUP BY P.id_category, SJ.siswa_id 
        //     ORDER BY SJ.siswa_id, P.id_category";

        $query = "SELECT S.id, S.nama, S.nis, C.nama AS kelas, G.name AS kelompok, N.* 
            FROM siswa AS S 
            JOIN class AS C ON C.id = S.class_id 
            JOIN grup_siswa AS GS ON GS.siswa_id = S.id 
            JOIN `group` AS G ON G.id = GS.group_id 
            LEFT JOIN (SELECT SJ.siswa_id, SJ.teacher_id, SUM(PP.bobot) AS bobot, COUNT(*) AS hitung, P.id_category 
                FROM `siswa_jawaban` AS SJ 
                JOIN pertanyaan_pilihan AS PP ON PP.ID = SJ.answer_id 
                JOIN pertanyaan AS P ON P.id = PP.pertanyaan_id 
                JOIN ujian AS U ON U.id = SJ.ujian_id 
                WHERE U.tema = $id_theme 
                GROUP BY P.id_category, SJ.teacher_id, SJ.siswa_id 
                ORDER BY SJ.siswa_id, SJ.teacher_id, P.id_category) N ON N.siswa_id = S.id";

        $re = mysqli_query($conn, $query);
        $arr = array();
        $arr1 = array();
        if (mysqli_num_rows($re) > 0) {
            // output data of each row
            $i = 0;
            $tmp = "cek";
            while($row = mysqli_fetch_assoc($re)) {
                if ($tmp != $row["nama"]) {
                    if($i != 0) {
                        if($arr["p1"][0] != 0) {
                            $arr["rt"][0] = ($arr["p1"][0] + $arr["p2"][0] + $arr["p3"][0]) / $nopeng;
                            $arr["rt"][1] = ($arr["p1"][1] + $arr["p2"][1] + $arr["p3"][1]) / $nopeng;
                            $arr["rt"][2] = ($arr["p1"][2] + $arr["p2"][2] + $arr["p3"][2]) / $nopeng;
                            $arr["rt"][3] = ($arr["p1"][3] + $arr["p2"][3] + $arr["p3"][3]) / $nopeng;
                            $arr["rt"][4] = ($arr["p1"][4] + $arr["p2"][4] + $arr["p3"][4]) / $nopeng;
                        }
                        $arr1[] = $arr;
                    } 
                    $tmp = $row["nama"];
                    $i++;
                    $nopeng = 1;
                    $penguji = $row["teacher_id"];
                    $arr["no"] = $i;
                    $arr["kelas"] = $row["kelas"];
                    $arr["kelompok"] = $row["kelompok"];
                    $arr["nama"] = $row["nama"] . " (" . $row["nis"] . ")";
                    $arr["p1"] = array(0, 0, 0, 0, 0);
                    $arr["p2"] = array(0, 0, 0, 0, 0);
                    $arr["p3"] = array(0, 0, 0, 0, 0);
                    $arr["rt"] = array(0, 0, 0, 0, 0);
                    
                    if (empty($penguji)) {
                        continue;
                    }

                    switch ($row["id_category"]) {
                        case '1':
                            $arr["p1"][0] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                            $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                            break;
                        
                        case '2':
                            $arr["p1"][1] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                            $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                            break;

                        case '3':
                            $arr["p1"][2] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                            $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                            break;

                        case '4':
                            $arr["p1"][3] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                            $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;

                            break;
                    }                    
                } else {
                    if ($row["teacher_id"] != $penguji) {
                        $penguji = $row["teacher_id"];
                        $nopeng++;
                    }

                    if ($nopeng == 1) {
                        switch ($row["id_category"]) {
                            case '1':
                                $arr["p1"][0] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                                break;
                            
                            case '2':
                                $arr["p1"][1] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                                break;

                            case '3':
                                $arr["p1"][2] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                                break;

                            case '4':
                                $arr["p1"][3] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                                break;
                        }
                    } else if ($nopeng == 2) {
                        switch ($row["id_category"]) {
                            case '1':
                                $arr["p2"][0] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p2"][4] = ($arr["p2"][0] + $arr["p2"][1] + $arr["p2"][2] + $arr["p2"][3]) / 4;
                                break;
                            
                            case '2':
                                $arr["p2"][1] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p2"][4] = ($arr["p2"][0] + $arr["p2"][1] + $arr["p2"][2] + $arr["p2"][3]) / 4;
                                break;

                            case '3':
                                $arr["p2"][2] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p2"][4] = ($arr["p2"][0] + $arr["p2"][1] + $arr["p2"][2] + $arr["p2"][3]) / 4;
                                break;

                            case '4':
                                $arr["p2"][3] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p2"][4] = ($arr["p2"][0] + $arr["p2"][1] + $arr["p2"][2] + $arr["p2"][3]) / 4;

                                break;
                        }
                    } else if ($nopeng == 3) {
                        switch ($row["id_category"]) {
                            case '1':
                                $arr["p3"][0] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p3"][4] = ($arr["p3"][0] + $arr["p3"][1] + $arr["p3"][2] + $arr["p3"][3]) / 4;
                                break;
                            
                            case '2':
                                $arr["p3"][1] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p3"][4] = ($arr["p3"][0] + $arr["p3"][1] + $arr["p3"][2] + $arr["p3"][3]) / 4;
                                break;

                            case '3':
                                $arr["p3"][2] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p3"][4] = ($arr["p3"][0] + $arr["p3"][1] + $arr["p3"][2] + $arr["p3"][3]) / 4;
                                break;

                            case '4':
                                $arr["p3"][3] = ($row["bobot"] / ($row["hitung"] * 4)) * 100;
                                $arr["p3"][4] = ($arr["p3"][0] + $arr["p3"][1] + $arr["p3"][2] + $arr["p3"][3]) / 4;
                                break;
                        }
                    }
                }            
            }
            
            echo json_encode($arr1);
        } else {
            echo "0 results";
        }

    mysqli_close($conn);
?>