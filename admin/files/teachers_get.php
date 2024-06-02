<?php
	include "../../database/config.php";

        $query = "SELECT id, kode, nama, nip FROM guru";
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
                $arr["kode"] = $row["kode"];
                $arr["nip"] = $row["nip"];
                $arr1[] = $arr;
                $i++;
            }
            
            echo json_encode($arr1);
        } else {
            echo "0 results";
        }

    mysqli_close($conn);
?>