<?php
	include "../../database/config.php";

        $id_theme = $_GET["id"];
        $nama_tema = 'test';
        $query = "SELECT nama FROM tema WHERE id = $id_theme";
        $re = mysqli_query($conn, $query);
        if (mysqli_num_rows($re) > 0) {
            while($row = mysqli_fetch_assoc($re)) {
                $nama_tema = $row["nama"];
            }
        }

        header("Content-type: application/vnd-ms-excel");
        header("Content-Disposition: attachment; filename=" . $nama_tema . ".xls");

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
            //table start
            echo '<table border="1">
            <thead>
            <tr style="text-align:center;">
                <td rowspan="2"><b>No</b></td>
                <td rowspan="2"><b>Nama Peserta</b></td>
                <td rowspan="2"><b>NIS</b></td>
                <td rowspan="2"><b>Kelas</b></td>
                <td rowspan="2"><b>Kelompok</b></td>
                <td colspan="5"><b>Penguji 1</b></td>
                <td colspan="5"><b>Penguji 2</b></td>
                <td colspan="5"><b>Penguji 3</b></td>
                <td colspan="5"><b>Keseluruhan</b></td>
            </tr>
            <tr style="text-align:center;">
                <td>Penyampaian</td>
                <td>Pemahaman</td>
                <td>Literasi</td>
                <td>Numerasi</td>
                <td>Rata-rata</td>
                <td>Penyampaian</td>
                <td>Pemahaman</td>
                <td>Literasi</td>
                <td>Numerasi</td>
                <td>Rata-rata</td>
                <td>Penyampaian</td>
                <td>Pemahaman</td>
                <td>Literasi</td>
                <td>Numerasi</td>
                <td>Rata-rata</td>
                <td>Penyampaian</td>
                <td>Pemahaman</td>
                <td>Literasi</td>
                <td>Numerasi</td>
                <td>Rata-rata</td>
            </tr>
            </thead>';

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
                        echo '<tr>
                            <td>'.$arr["no"].'</td>
                            <td>'.$arr["nama"].'</td>
                            <td>'.$arr["nis"].'</td>
                            <td>'.$arr["kelas"].'</td>
                            <td>'.$arr["kelompok"].'</td>
                            <td>'.round($arr["p1"][0], 2).'</td>
                            <td>'.round($arr["p1"][1], 2).'</td>
                            <td>'.round($arr["p1"][2], 2).'</td>
                            <td>'.round($arr["p1"][3], 2).'</td>
                            <td>'.round($arr["p1"][4], 2).'</td>
                            <td>'.round($arr["p2"][0], 2).'</td>
                            <td>'.round($arr["p2"][1], 2).'</td>
                            <td>'.round($arr["p2"][2], 2).'</td>
                            <td>'.round($arr["p2"][3], 2).'</td>
                            <td>'.round($arr["p2"][4], 2).'</td>
                            <td>'.round($arr["p3"][0], 2).'</td>
                            <td>'.round($arr["p3"][1], 2).'</td>
                            <td>'.round($arr["p3"][2], 2).'</td>
                            <td>'.round($arr["p3"][3], 2).'</td>
                            <td>'.round($arr["p3"][4], 2).'</td>
                            <td>'.round($arr["rt"][0], 2).'</td>
                            <td>'.round($arr["rt"][1], 2).'</td>
                            <td>'.round($arr["rt"][2], 2).'</td>
                            <td>'.round($arr["rt"][3], 2).'</td>
                            <td>'.round($arr["rt"][4], 2).'</td>
                            </tr>';
                    } 
                    $tmp = $row["nama"];
                    $i++;
                    $nopeng = 1;
                    $penguji = $row["teacher_id"];
                    $arr["no"] = $i;
                    $arr["kelas"] = $row["kelas"];
                    $arr["kelompok"] = $row["kelompok"];
                    $arr["nis"] = $row["nis"];
                    $arr["nama"] = $row["nama"];
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
            echo '</table>';
        }

    mysqli_close($conn);
?>