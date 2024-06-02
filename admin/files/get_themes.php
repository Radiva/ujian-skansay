<?php
    $info;
	include "../../database/config.php";
   
        $query = "SELECT * FROM tema ";
        $result = mysqli_query($conn, $query);
                
        if (mysqli_num_rows($result) > 0) {
            // output data of each row
            while($row = mysqli_fetch_assoc($result)) {
                $info['id'] = $row['id'];
                $info['nama'] = $row['nama'];
                $info2[] = $info;
            }
            echo json_encode($info2);
        } else {
            echo "0 results";
        }

    mysqli_close($conn);
?>