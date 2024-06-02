<?php
	include "../../database/config.php";

        $query = "SELECT siswa.*, class.nama AS nama_class FROM siswa JOIN class ON class.id = siswa.class_id where siswa.class_id = '".$_POST['class_name']."' ";
        $result = mysqli_query($conn, $query);
        $arr = array();
        $arr1 = array();
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            $i = 1;
            while($row = mysqli_fetch_assoc($result)) {
                $arr["id"] = $row["id"];
                $arr["no"] = $i;
                $arr["nama"] = $row["nama"];
                $arr["jk"] = ($row["jk"]==1) ? "Laki-laki" : "Perempuan";
                $arr["nis"] = $row["nis"];
                $arr["kelas"] = $row["nama_class"];
                $arr1[] = $arr;
                $i++;
            }
            
            echo json_encode($arr1);
        } else {
            echo "0 results";
        }

    mysqli_close($conn);
?>