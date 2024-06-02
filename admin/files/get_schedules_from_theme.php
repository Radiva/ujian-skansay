<?php
	include "../../database/config.php";

        // $query = "SELECT ujian.id, ujian.tanggal, ruangan.nama AS nama_ruangan, sesi.nama AS nama_sesi, sesi.mulai, sesi.selesai, GROUP_CONCAT(G.name SEPARATOR '<br /> ') AS peserta, GROUP_CONCAT(guru.nama SEPARATOR '<br /> ') AS penguji  FROM `ujian` 
        //     JOIN ujian_group AS UG ON UG.ujian_id = ujian.id 
        //     JOIN `group` AS G ON G.id = UG.group_id 
        //     JOIN ujian_pengawas AS UP ON UP.ujian_id = ujian.id 
        //     JOIN guru ON guru.id = UP.guru_id 
        //     JOIN ruangan ON ruangan.id = ujian.ruangan 
        //     JOIN sesi ON sesi.id = ujian.sesi 
        //     WHERE ujian.tema = 1 GROUP BY ujian.id";

        // $subquery = "SELECT ujian_group.id, ujian_id, GROUP_CONCAT(G.name SEPARATOR '<br /> ') AS peserta FROM `ujian_group` 
        //     JOIN `group` AS G on G.id = ujian_group.group_id GROUP BY ujian_group.ujian_id";
        
        // $subquery2 = "SELECT ujian_pengawas.id, ujian_id, GROUP_CONCAT(G.nama SEPARATOR '<br /> ') FROM ujian_pengawas 
        //     JOIN guru AS G ON G.id = ujian_pengawas.guru_id GROUP BY ujian_pengawas.ujian_id";
        
        $query = "SELECT ujian.id, ujian.tanggal, sesi.nama AS nama_sesi, ruangan.nama AS nama_ruangan, s1.peserta, s2.penguji FROM ujian 
            JOIN sesi ON sesi.id = ujian.sesi 
            JOIN ruangan ON ruangan.id = ujian.ruangan 
            LEFT JOIN (SELECT ujian_group.id, ujian_id, GROUP_CONCAT(G.name SEPARATOR '<br /> ') AS peserta FROM `ujian_group` JOIN `group` AS G on G.id = ujian_group.group_id GROUP BY ujian_group.ujian_id) s1 ON s1.ujian_id = ujian.id 
            LEFT JOIN (SELECT ujian_pengawas.id, ujian_id, GROUP_CONCAT(G.nama SEPARATOR '<br /> ') AS penguji FROM ujian_pengawas JOIN guru AS G ON G.id = ujian_pengawas.guru_id GROUP BY ujian_pengawas.ujian_id) s2 ON s2.ujian_id = ujian.id 
            WHERE ujian.tema = '".$_POST["theme_name"]."'";
        $re = mysqli_query($conn, $query);
        $arr = array();
        $arr1 = array();
        if (mysqli_num_rows($re) > 0) {
            // output data of each row
            $i = 1;
            while($row = mysqli_fetch_assoc($re)) {
                $arr["id"] = $row["id"];
                $arr["no"] = $i;
                $arr["tanggal"] = $row["tanggal"];
                $arr["ruangan"] = $row["nama_ruangan"];
                $arr["sesi"] = $row["nama_sesi"];
                $arr["mulai"] = $row["mulai"];
                $arr["selesai"] = $row["selesai"];
                $arr["penguji"] = $row["penguji"];
                $arr["peserta"] = $row["peserta"];
                $arr1[] = $arr;
                $i++;
            }
            
            echo json_encode($arr1);
        } else {
            echo "0 results";
        }

    mysqli_close($conn);
?>