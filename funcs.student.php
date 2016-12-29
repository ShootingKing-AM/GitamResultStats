<?php
	function GetCurrentSem($Details)
	{
		for( $i = 8; $i > 0; $i-- )
		{
			if( $Details['GPA'.$i] != '' && $Details['GPA'.$i] != NULL )
			{
				return $i;
			}
		}
	}
	
	function GetCurrentSemOfClass($db, $ClassID)
	{
		$Details = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM resultsfinalultimate WHERE RegdNo='".$ClassID."01'"));
		for( $i = 8; $i > 0; $i-- )
		{
			if( $Details['GPA'.$i] != '' && $Details['GPA'.$i] != NULL )
			{
				return $i;
			}
		}
	}
	
	function IsOnGoing($Details)
	{
		if( $Details['CGPA8'] != '' && $Details['CGPA8'] != NULL )
			return false;
		else
			return true;
	}
	
	function BranchOf($RegdNoInt)
	{
		//1210813131
		$RegdNo = $RegdNoInt.'';
		// echo intval($RegdNo[4]);
		switch (intval($RegdNo[4]))
		{
			case 1: return 'Biotechonology, GIT';
			case 2: return 'Civil Engineering, GIT';
			case 3: return 'Computer Science & Engineering, GIT';
			case 4: return 'Electronics & Communication Engineering, GIT';
			case 5: return 'Electrical & Electronics Engineering, GIT';
			case 6: return 'Electronics & Instrumentation Engineering, GIT';
			case 7: return 'Information Technology, GIT';
			case 8: return 'Mechanical Engineering, GIT';
		}
	}
	
	$PetNames = array(
		'Biotechonology, GIT' => 'bio',
		'Civil Engineering, GIT' => 'civil',
		'Computer Science & Engineering, GIT' => 'cse',
		'Electronics & Communication Engineering, GIT' => 'ece',
		'Electrical & Electronics Engineering, GIT' => 'eee',
		'Electronics & Instrumentation Engineering, GIT' => 'eie',
		'Information Technology, GIT' => 'it',
		'Mechanical Engineering, GIT' => 'mech'
	);
	
	function BatchNo($RegdNoInt)
	{
		$RegdNo = $RegdNoInt.'';
		$start = (intval($RegdNo[5].$RegdNo[6]));
		$end = $start+4;
		if( $start < 10 )
			$start = '0'.$start;
		
		return "20$start - 20$end";
	}

	function SectionOf($RegdNoInt)
	{
		$RegdNo = $RegdNoInt.'';
		$initial = '';
		
		switch (intval($RegdNo[4]))
		{
			case 1: $initial = 'F';break;
			case 2: $initial = 'G';break;
			case 3: $initial = 'B';break;
			case 4: $initial = 'A';break;
			case 5: $initial = 'D';break;
			case 6: $initial = 'E';break;
			case 7: $initial = 'C';break;
			case 8: $initial = 'H';break;
		}
		
		return $initial.' - '.(($RegdNo[7]!=0)?($RegdNo[7]):10);
	}
	
	function GetPositionInClassCGPA($db, $Details)
	{
		$RegdNo = $Details['RegdNo'];
		$ClassHeader = floor(intval($RegdNo)/100);
		$sql = "SELECT RegdNo FROM resultsfinalultimate WHERE RegdNo LIKE '$ClassHeader%' ORDER BY CGPA".GetCurrentSem($Details)." DESC";
		// echo $sql;
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
			// echo $array['RegdNo'].'<br/>';
		}
		while( $array['RegdNo'] != $RegdNo );
		return $i;
	}
	
	function GetPositionInClassGPA($db, $Details)
	{
		$RegdNo = $Details['RegdNo'];
		$ClassHeader = floor(intval($RegdNo)/100);
		$sql = "SELECT RegdNo FROM resultsfinalultimate WHERE RegdNo LIKE '$ClassHeader%' ORDER BY GPA".GetCurrentSem($Details)." DESC";
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['RegdNo'] != $RegdNo );
		return $i;
	}
	
	function GetPositionInBatchCGPA($db, $Details)
	{
		$RegdNo = $Details['RegdNo'];
		$BatchHeader = floor(intval($RegdNo)/1000);
		$sql = "SELECT RegdNo FROM resultsfinalultimate WHERE RegdNo LIKE '$BatchHeader%' ORDER BY CGPA".GetCurrentSem($Details)." DESC";
				// echo $sql;
		$res = mysqli_query($db, $sql);
		
		$i = 0;
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['RegdNo'] != $RegdNo );
		return $i;
	}
	
	function GetPositionInBatchGPA($db, $Details)
	{
		$RegdNo = $Details['RegdNo'];
		$BatchHeader = floor(intval($RegdNo)/1000);
		$sql = "SELECT RegdNo FROM resultsfinalultimate WHERE RegdNo LIKE '$BatchHeader%' ORDER BY GPA".GetCurrentSem($Details)." DESC";
		$res = mysqli_query($db, $sql);
		$i = 0;
		
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['RegdNo'] != $RegdNo );
		return $i;
	}
	
	function GetPositionInBranchCGPA($db, $Details)
	{
		$RegdNo = $Details['RegdNo'];
		$Header = floor(intval($RegdNo)/100000);
		$sql = "SELECT RegdNo FROM resultsfinalultimate WHERE RegdNo LIKE '$Header%' ORDER BY CGPA".GetCurrentSem($Details)." DESC";
		// echo $sql;
		$res = mysqli_query($db, $sql);
		$i = 0;
		
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['RegdNo'] != $RegdNo );
		return $i;
	}
	
	function GetPositionInBranchGPA($db, $Details)
	{
		$RegdNo = $Details['RegdNo'];
		$Header = floor(intval($RegdNo)/100000);
		$sql = "SELECT RegdNo FROM resultsfinalultimate WHERE RegdNo LIKE '$Header%' ORDER BY GPA".GetCurrentSem($Details)." DESC";
		$res = mysqli_query($db, $sql);
		$i = 0;
		
		do{
			$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
			$i++;
		}
		while( $array['RegdNo'] != $RegdNo );
		return $i;
	}
?>