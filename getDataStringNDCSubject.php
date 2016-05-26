<?php
	if( !isset($_POST) || !isset($_POST['sem']) || !isset($_POST['sub']) || !isset($_POST['classid']) )
	{
		exit;die;
	}

	include_once 'db.php';
	
	$Sem = mysqli_real_escape_string($db, $_POST['sem']);
	$Sub = mysqli_real_escape_string($db, $_POST['sub']);
	$ClassID = mysqli_real_escape_string($db, $_POST['classid']);
	
	$Data = array(
		"O" => 0,
		"A+" => 0,
		"A" => 0,
		"B+" => 0,
		"B" => 0,
		"C" => 0,
		"F" => 0,
		"Ab" => 0
	);
	
	/* for( $i = 1; $i <= 66; $i++ )
	{
		$sql = "SELECT $Sem"."Sub$Sub"."Points FROM resultsfinalultimate WHERE RegdNo='$ClassID"."$i'";
		$res = mysqli_fetch_array(mysqli_query($db, $sql));
		$points = trim($res[$Sem.'Sub'.$Sub.'Points']);
		
		if( $points != '' && $points != NULL )
		{
			$Data[$points]++;
		}
	} */
	
	$sql = "SELECT $Sem"."Sub$Sub"."Points FROM resultsfinalultimate WHERE RegdNo LIKE '$ClassID"."%'";
	$res = mysqli_query($db, $sql);
	
	while( $DataArray = mysqli_fetch_array($res, MYSQLI_ASSOC) )
	{
		$points = trim($DataArray[$Sem.'Sub'.$Sub.'Points']);
		
		if( $points != '' && $points != NULL )
		{
			$Data[$points]++;
		}
	}
	
	mysqli_close($db);
	echo $Data['O'].','.$Data['A+'].','.$Data['A'].','.$Data['B+'].','.$Data['B'].','.$Data['C'].','.($Data['F']+$Data['Ab']);
	