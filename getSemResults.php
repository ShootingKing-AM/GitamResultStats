<?php
	if( !isset($_POST) || !isset($_POST['sem']) || !isset($_POST['regdno']) )
	{
		exit;die;
	}

	include_once 'db.php';
	include_once 'funcs.student.php';
	
	$RegdNo = htmlspecialchars($_POST['regdno']);
	$SemNo = htmlspecialchars($_POST['sem']);
	
	$Details = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM resultsfinalultimate WHERE RegdNo LIKE '$RegdNo'"), MYSQLI_ASSOC);
	for( $i = 1; $i < 10; $i++ )
	{
		echo '<tr><td>'.$Details[$SemNo.'Sub'.$i.'Code'].'</td>'.
			'<td>'.$Details[$SemNo.'Sub'.$i].'</td>'.
			'<td>'.$Details[$SemNo.'Sub'.$i.'Credits'].'</td>'.
			'<td>'.$Details[$SemNo.'Sub'.$i.'Points'].'</td></tr>';
	}
	?>
	<tr> <td/><td/>
		<td> <b>GPA</b> </td>
		<td> <b><?php echo $Details['GPA'.$SemNo]; ?></b> </td>
	</tr>
	<tr> <td/><td/>
		<td> <b>CGPA</b> </td>
		<td> <b><?php echo $Details['CGPA'.$SemNo]; ?></b> </td>
	</tr>