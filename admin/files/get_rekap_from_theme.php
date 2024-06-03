<?php
	include "../../database/config.php";
    $id_theme = $_POST["theme_name"];

    $query = "SELECT S.id, S.nama, S.nis, C.nama AS kelas, G.name AS kelompok, N.teacher_id, N.hitung, N.id_category , N.nilai
            FROM siswa AS S 
            JOIN kelas AS C ON C.id = S.class_id 
            LEFT JOIN kelompok_siswa AS GS ON GS.siswa_id = S.id 
            LEFT JOIN kelompok AS G ON G.id = GS.group_id 
            LEFT JOIN (SELECT SJ.siswa_id, SJ.teacher_id, COUNT(*) AS hitung, P.id_category, SUM(SJ.nilai) AS nilai 
                FROM siswa_nilai AS SJ 
                JOIN pertanyaan AS P ON P.id = SJ.question_id
                JOIN jadwal_kelompok AS JK ON JK.id = SJ.jadwal_kelompok_id
                JOIN jadwal AS U ON U.id = JK.ujian_id 
                WHERE U.tema = $id_theme
                GROUP BY P.id_category, SJ.teacher_id, SJ.siswa_id 
                ORDER BY SJ.siswa_id, SJ.teacher_id, P.id_category) N ON N.siswa_id = S.id
                UNION ALL
                SELECT 0 id, 'dummy' nama, '0000000' nis, null kelas, null kelompok, null teacher_id, null hitung, null id_category, 0 nilai;";
        //$id_theme
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
                            $arr["p1"][0] = ($row["nilai"] / ($row["hitung"]));
                            $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                            break;
                        
                        case '2':
                            $arr["p1"][1] = ($row["nilai"] / ($row["hitung"]));
                            $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                            break;

                        case '3':
                            $arr["p1"][2] = ($row["nilai"] / ($row["hitung"]));
                            $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                            break;

                        case '4':
                            $arr["p1"][3] = ($row["nilai"] / ($row["hitung"]));
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
                                $arr["p1"][0] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                                break;
                            
                            case '2':
                                $arr["p1"][1] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                                break;

                            case '3':
                                $arr["p1"][2] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                                break;

                            case '4':
                                $arr["p1"][3] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p1"][4] = ($arr["p1"][0] + $arr["p1"][1] + $arr["p1"][2] + $arr["p1"][3]) / 4;
                                break;
                        }
                    } else if ($nopeng == 2) {
                        switch ($row["id_category"]) {
                            case '1':
                                $arr["p2"][0] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p2"][4] = ($arr["p2"][0] + $arr["p2"][1] + $arr["p2"][2] + $arr["p2"][3]) / 4;
                                break;
                            
                            case '2':
                                $arr["p2"][1] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p2"][4] = ($arr["p2"][0] + $arr["p2"][1] + $arr["p2"][2] + $arr["p2"][3]) / 4;
                                break;

                            case '3':
                                $arr["p2"][2] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p2"][4] = ($arr["p2"][0] + $arr["p2"][1] + $arr["p2"][2] + $arr["p2"][3]) / 4;
                                break;

                            case '4':
                                $arr["p2"][3] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p2"][4] = ($arr["p2"][0] + $arr["p2"][1] + $arr["p2"][2] + $arr["p2"][3]) / 4;

                                break;
                        }
                    } else if ($nopeng == 3) {
                        switch ($row["id_category"]) {
                            case '1':
                                $arr["p3"][0] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p3"][4] = ($arr["p3"][0] + $arr["p3"][1] + $arr["p3"][2] + $arr["p3"][3]) / 4;
                                break;
                            
                            case '2':
                                $arr["p3"][1] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p3"][4] = ($arr["p3"][0] + $arr["p3"][1] + $arr["p3"][2] + $arr["p3"][3]) / 4;
                                break;

                            case '3':
                                $arr["p3"][2] = ($row["nilai"] / ($row["hitung"]));
                                $arr["p3"][4] = ($arr["p3"][0] + $arr["p3"][1] + $arr["p3"][2] + $arr["p3"][3]) / 4;
                                break;

                            case '4':
                                $arr["p3"][3] = ($row["nilai"] / ($row["hitung"]));
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