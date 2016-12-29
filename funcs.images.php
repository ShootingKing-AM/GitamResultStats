<?php

	include_once 'db.php';
	header('Content-Type: image/jpeg');
	$src = mysqli_real_escape_string($db, $_GET['i']);
	$sql = "SELECT Image FROM resultsimages WHERE RegdNo='$src'";
	$arr = mysqli_fetch_array(mysqli_query($db, $sql), MYSQLI_ASSOC);
	// echo $sql;
	echo $arr['Image'];