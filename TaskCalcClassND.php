<?php
	include_once 'funcs.student.php';
	include_once 'db.php';
	set_time_limit(0);
	
	CalcClassNDforClassID(121, $db);
	function CalcClassNDforClassID($ClassIDf, $db)
	{
		$ClassIDSet = floor($ClassIDf/10);
		$sql = "SELECT RegdNo FROM resultsfinalultimate WHERE RegdNo LIKE '121%%%%%01'";	
		$ClassIDArrayRes = mysqli_query($db, $sql);
		$ClassCount = 0;
		while( $ClassIDArray = mysqli_fetch_array($ClassIDArrayRes, MYSQL_ASSOC) )
		{
			$ClassCount++;
			$ClassID = floor(intval($ClassIDArray['RegdNo'])/100);
			// echo $ClassID;
			$CurrSemLast = GetCurrentSemOfClass($db, $ClassID);
			for( $CurrSem = 1; $CurrSem <= $CurrSemLast; $CurrSem++ )
			{
				$DataCGPA = array(
					"0-1" => 0,
					"1-2" => 0,
					"2-3" => 0,
					"3-4" => 0,
					"4-5" => 0,
					"5-6" => 0,
					"6-7" => 0,
					"7-8" => 0,
					"8-9" => 0,
					"9-10" => 0
				);

				$DataGPA = array(
					"0-1" => 0,
					"1-2" => 0,
					"2-3" => 0,
					"3-4" => 0,
					"4-5" => 0,
					"5-6" => 0,
					"6-7" => 0,
					"7-8" => 0,
					"8-9" => 0,
					"9-10" => 0
				);
				
				$sql = "SELECT CGPA".$CurrSem.",GPA".$CurrSem." FROM resultsfinalultimate WHERE RegdNo LIKE '$ClassID"."%'";
				$res = mysqli_query($db, $sql);

				while( $DatArray = mysqli_fetch_array($res) )
				{
					$DataCGPA[floor($DatArray['CGPA'.$CurrSem])."-".(floor($DatArray['CGPA'.$CurrSem])+1)]++;
					$DataGPA[floor($DatArray['GPA'.$CurrSem])."-".(floor($DatArray['GPA'.$CurrSem])+1)]++;
				}
					
				// echo '['.$DataCGPA['0-1'].', '.$DataCGPA['1-2'].', '.$DataCGPA['2-3'].', '.$DataCGPA['3-4'].', '.$DataCGPA['4-5'].', '.$DataCGPA['5-6'].', '.$DataCGPA['6-7'].', '.$DataCGPA['7-8'].', '.$DataCGPA['8-9'].', '.$DataCGPA['9-10'].']';
				// $DataLineGPA = '['.$DataGPA['0-1'].', '.$DataGPA['1-2'].', '.$DataGPA['2-3'].', '.$DataGPA['3-4'].', '.$DataGPA['4-5'].', '.$DataGPA['5-6'].', '.$DataGPA['6-7'].', '.$DataGPA['7-8'].', '.$DataGPA['8-9'].', '.$DataGPA['9-10'].']';

				$MaxIndexCGPA = "5-6"; $MaxStudentsCGPA = $DataCGPA["5-6"];
				$MaxIndexGPA = "5-6"; $MaxStudentsGPA = $DataGPA["5-6"];
				
				for( $i = 0 ; $i <= 4; $i++ )
				{
					unset($DataCGPA[$i.'-'.($i+1)]);
					unset($DataGPA[$i.'-'.($i+1)]);
				}
				
				for( $i = 5; $i < 10; $i++ )
				{
					if( $DataCGPA[$i.'-'.($i+1)] > $MaxStudentsCGPA )
					{
						$MaxStudentsCGPA = $DataCGPA[$i.'-'.($i+1)];
						$MaxIndexCGPA = $i.'-'.($i+1);
					}
				}
				
				for( $i = 5; $i < 10; $i++ )
				{
					if( $DataGPA[$i.'-'.($i+1)] > $MaxStudentsGPA )
					{
						$MaxStudentsGPA = $DataGPA[$i.'-'.($i+1)];
						$MaxIndexGPA = $i.'-'.($i+1);
					}
				}
				
				$sql = "SELECT SUM(CGPA".$CurrSem.") AS Total FROM resultsfinalultimate WHERE RegdNo LIKE '".$ClassID."%'";
				$TotalCGPA = mysqli_fetch_array(mysqli_query($db, $sql), MYSQL_ASSOC);
				$AvgCGPA = intval($TotalCGPA['Total'])/66;
				
				$sql = "SELECT SUM(GPA".$CurrSem.") AS Total FROM resultsfinalultimate WHERE RegdNo LIKE '".$ClassID."%'";
				$TotalGPA = mysqli_fetch_array(mysqli_query($db, $sql), MYSQL_ASSOC);
				$AvgGPA = intval($TotalGPA['Total'])/66;
				
				$sql = "SELECT COUNT(*) FROM resultsfinalultimate WHERE RegdNo LIKE '".$ClassID."%' AND CGPA$CurrSem > 0";
				$NoOfPassCGPA = mysqli_fetch_array(mysqli_query($db, $sql), MYSQL_ASSOC);
				
				$sql = "SELECT COUNT(*) FROM resultsfinalultimate WHERE RegdNo LIKE '".$ClassID."%' AND GPA$CurrSem > 0";
				$NoOfPassGPA = mysqli_fetch_array(mysqli_query($db, $sql), MYSQL_ASSOC);
							
				$sql = "CREATE TABLE IF NOT EXISTS resultsclasstats ( ID INT NOT NULL AUTO_INCREMENT, SemNo TEXT, ClassID TEXT, MaxStudentsCGPA TEXT, MaxIndexCGPA TEXT, MaxStudentsGPA TEXT, MaxIndexGPA TEXT, AvgCGPA TEXT, AvgGPA TEXT, NoOfPassCGPA TEXT, NoOfPassGPA TEXT, PRIMARY KEY (ID) )";
				mysqli_query( $db, $sql );
				
				$sql = "SELECT ID FROM resultsclasstats WHERE ClassID LIKE '$ClassID' AND SemNo LIKE '$CurrSem'";
				if( mysqli_num_rows(mysqli_query($db, $sql)) > 0 )
				{
					$sql = "UPDATE resultsclasstats SET MaxStudentsCGPA='$MaxStudentsCGPA', MaxStudentsGPA='$MaxStudentsGPA', MaxIndexCGPA='$MaxIndexCGPA', MaxIndexGPA='$MaxIndexGPA', AvgCGPA='$AvgCGPA', AvgGPA='$AvgGPA', SemNo='$CurrSem', NoOfPassCGPA='".$NoOfPassCGPA['COUNT(*)']."', NoOfPassGPA='".$NoOfPassGPA['COUNT(*)']."' WHERE ClassID LIKE '$ClassID'";
				}
				else
				{
					$sql = "INSERT INTO resultsclasstats (ClassID, MaxStudentsCGPA, MaxStudentsGPA, MaxIndexCGPA, MaxIndexGPA, AvgCGPA, AvgGPA, SemNo, NoOfPassCGPA, NoOfPassGPA) VALUES ('$ClassID','$MaxStudentsCGPA', '$MaxStudentsGPA', '$MaxIndexCGPA', '$MaxIndexGPA', '$AvgCGPA', '$AvgGPA', '$CurrSem', '".$NoOfPassCGPA['COUNT(*)']."', '".$NoOfPassGPA['COUNT(*)']."')";
				}
				mysqli_query( $db, $sql );
				echo "$ClassID($ClassCount) [$CurrSem] Done !\n";
			}
		}
	}