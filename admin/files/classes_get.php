<?php
    $info;
	include "../../database/config.php";
   
        $classes = "SELECT * FROM class ";
        $result = mysqli_query($conn, $classes);
                
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $info['id'] = $row['id'];
                $info['nama'] = $row['nama'];
                $info1[] = $info;
            }
            echo json_encode($info1);
        } else {
            echo "0 results";
        }

    mysqli_close($conn);
?>