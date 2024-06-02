<?php
		include '../database/config.php';
    session_start();
		
	$teacher_code = $_POST['code'];
    $teacher_password = $_POST['password'];

    $sql1 = "select * from guru where username = '".$teacher_code."' AND password = '". $teacher_password."'";
    $result1 = mysqli_query($conn,$sql1);
		
	if (mysqli_num_rows($result1) > 0){

		$row1 = mysqli_fetch_assoc($result1);
		$_SESSION['teacher']['id'] = $row1["id"];
		$_SESSION['teacher']['username'] = $row1["username"];
		$_SESSION['teacher']['nama_lengkap'] = $row1["nama_lengkap"];
		$_SESSION['teacher']['nip'] = $row1["nip"];
		$_SESSION['teacher']['ttl'] = $row1["ttl"]; 
		
		echo 'CREDS_OK';
	}else{
		echo json_encode("RECORD_NOT_FOUND");
	}

	mysqli_close($conn);
?>

