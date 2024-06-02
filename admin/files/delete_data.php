<?php
    $info;
	include "../../database/config.php";

    $table = $_POST['data_table_delete'];
    $id = $_POST['data_id_delete'];
    $query;
    $result;

    switch ($table) {
        case 'class':
            $query = "DELETE FROM class WHERE id=$id";
            $result = mysqli_query($conn, $query);
            break;
        
        case 'student':
            $query = "DELETE FROM siswa WHERE id=$id";
            $result = mysqli_query($conn, $query);
            break;

        case 'group':
            $query = "DELETE FROM group WHERE id=$id";
            $result = mysqli_query($conn, $query);
            break;

        default:
            # code...
            break;
    }
   
    
    if($result) {
        header('Location: ' . $_SERVER['HTTP_REFERER']);
    }

    mysqli_close($conn);
?>