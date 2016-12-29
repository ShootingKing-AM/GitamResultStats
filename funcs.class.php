<?php

	// Highest Normal Distribution Students CGPA
	function getClassRankBasedOnHNDSCG($ClassIDf, $CurrSem, $db)
	{
		$ClassID = floor($ClassIDf/10);
		$sql = "SELECT ClassID FROM resultsclasstats WHERE ClassID LIKE '".$ClassID."%' AND SemNo LIKE '$CurrSem' ORDER BY MaxStudentsCGPA";
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['ClassID'] != $ClassIDf );
		return $i;		
	}
	
	// Highest Normal Distribution Students GPA
	function getClassRankBasedOnHNDSG($ClassIDf, $CurrSem, $db)
	{
		$ClassID = floor($ClassIDf/10);
		$sql = "SELECT ClassID FROM resultsclasstats WHERE ClassID LIKE '".$ClassID."%' AND SemNo LIKE '$CurrSem' ORDER BY MaxStudentsGPA";
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['ClassID'] != $ClassIDf );
		return $i;		
	}
	
	// Higest Normal Distribution Students' Range CGPA
	function getClassRankBasedOnHNDSRCG($ClassIDf, $CurrSem, $db)
	{
		$ClassID = floor($ClassIDf/10);
		$sql = "SELECT ClassID FROM resultsclasstats WHERE ClassID LIKE '".$ClassID."%' AND SemNo LIKE '$CurrSem' ORDER BY MaxIndexCGPA DESC, MaxStudentsCGPA DESC";
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['ClassID'] != $ClassIDf );
		return $i;		
	}
	
	// Higest Normal Distribution Students' Range GPA
	function getClassRankBasedOnHNDSRG($ClassIDf, $CurrSem, $db)
	{
		$ClassID = floor($ClassIDf/10);
		$sql = "SELECT ClassID FROM resultsclasstats WHERE ClassID LIKE '".$ClassID."%' AND SemNo LIKE '$CurrSem' ORDER BY MaxIndexGPA DESC, MaxStudentsGPA DESC";
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['ClassID'] != $ClassIDf );
		return $i;		
	}
	
	// Higest Average CGPA
	function getClassRankBasedOnHAVGCG($ClassIDf, $CurrSem, $db)
	{
		$ClassID = floor($ClassIDf/10);
		$sql = "SELECT ClassID FROM resultsclasstats WHERE ClassID LIKE '".$ClassID."%' AND SemNo LIKE '$CurrSem' ORDER BY AvgCGPA DESC";
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['ClassID'] != $ClassIDf );
		return $i;
	}
	
	// Highest Average GPA
	function getClassRankBasedOnHAVGG($ClassIDf, $CurrSem, $db)
	{
		$ClassID = floor($ClassIDf/10);
		$sql = "SELECT ClassID FROM resultsclasstats WHERE ClassID LIKE '".$ClassID."%' AND SemNo LIKE '$CurrSem' ORDER BY AvgGPA DESC";
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['ClassID'] != $ClassIDf );
		return $i;
	}
	
	// Highest No Of Passouts based on CGPA
	function getClassRankBasedOnNPCG($ClassIDf, $CurrSem, $db)
	{
		$ClassID = floor($ClassIDf/10);
		$sql = "SELECT ClassID FROM resultsclasstats WHERE ClassID LIKE '".$ClassID."%' AND SemNo LIKE '$CurrSem' ORDER BY NoOfPassCGPA DESC";
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['ClassID'] != $ClassIDf );
		return $i;
	}
	
	// Highest No Of Passouts based on GPA
	function getClassRankBasedOnNPG($ClassIDf, $CurrSem, $db)
	{
		$ClassID = floor($ClassIDf/10);
		$sql = "SELECT ClassID FROM resultsclasstats WHERE ClassID LIKE '".$ClassID."%' AND SemNo LIKE '$CurrSem' ORDER BY NoOfPassGPA DESC";
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['ClassID'] != $ClassIDf );
		return $i;
	}
	