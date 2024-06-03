<?php
	include "../../database/config.php";

        $query = "SELECT kelompok_siswa.id AS id, kelompok.`name` AS nama_grup, GROUP_CONCAT(siswa.nama SEPARATOR '<br /> ') AS anggota 
            FROM kelompok_siswa JOIN kelompok ON kelompok.id = kelompok_siswa.group_id 
            JOIN siswa on siswa.id = kelompok_siswa.siswa_id 
            WHERE kelompok.`class_id` = '".$_POST['class_name']."' GROUP BY kelompok.id";
        $result = mysqli_query($conn, $query);
        $arr = array();
        $arr1 = array();
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $i = 1;
            while($row = mysqli_fetch_assoc($result)) {
                $arr["id"] = $row["id"];
                $arr["no"] = $i;
                $arr["kelompok"] = $row["nama_grup"];
                $arr["anggota"] = $row["anggota"];
                $arr1[] = $arr;
                $i++;
            }
            
            echo json_encode($arr1);
        } else {
            echo "0 results";
        }

    mysqli_close($conn);
?>