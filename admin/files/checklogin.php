<?php
session_start();
if ($_SERVER["REQUEST_METHOD"] == "POST") {
	include "../../database/config.php";
	$username = $_POST["username"];
	$password = $_POST["password"];
	$sql = "SELECT * from guru where username='$username' AND password='$password' AND username = 'adm'";
	$res = mysqli_query($conn, $sql);
	if (mysqli_num_rows($res) == 1) {
		echo "success";
		//if login successful then initialize the session
		$row = mysqli_fetch_assoc($res);
		$_SESSION["user_id"] = $row["id"];
		$_SESSION["username"] = $row["username"];
		$_SESSION["nama"] = $row["nama_lengkap"];
	} else {
		echo "fail";
	}
}