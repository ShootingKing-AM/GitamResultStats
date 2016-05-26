<?php
	include_once 'db.php';
	if(!isset($_POST) || !isset($_POST['arg']))
	{
		exit; die;
	}
	
	function pc_permute($items, $perms = array( )) 
	{
		$back = array();
		if (empty($items))
		{ 
			$back[] = join(' ', $perms);
		} 
		else 
		{
			for ($i = count($items) - 1; $i >= 0; --$i)
			{
				$newitems = $items;
				$newperms = $perms;
				list($foo) = array_splice($newitems, $i, 1);
				array_unshift($newperms, $foo);
				$back = array_merge($back, pc_permute($newitems, $newperms));
			}
		}
		return $back;
	}
	
	// $arg = htmlspecialchars(trim($_GET['arg']));
	$arg = htmlspecialchars(trim($_POST['arg']));
	
	if( is_numeric($arg) && (strpos($arg, '.') == false) )
	{
		$sql = "SELECT Name,RegdNo FROM resultsfinalultimate WHERE RegdNo LIKE '$arg%' LIMIT 15";
		
	}
	else
	{
		// var_dump($arg.'<br/>');
		$explosion = explode(" ", $arg);
		$permutes = pc_permute($explosion);
		
		$sql = "SELECT Name,RegdNo FROM resultsfinalultimate WHERE ";
		foreach ($permutes as $keyword)
		{
			// var_dump($keyword);
			$sql .= "Name LIKE '%".str_replace(' ', '%', $keyword)."%' OR ";
			// var_dump($sql);
		}
		$sql .= "Name LIKE '%$arg%' LIMIT 15";
		// echo $sql;
		$arg = mysqli_real_escape_string($db, $arg);
	}
	// echo $sql.'<br/>';
	$EchoData = '';
	
	$res = mysqli_query($db, $sql);
	if( mysqli_num_rows($res) > 0 )
	{
		$EchoData = '<ul>';
		while( $array = mysqli_fetch_array($res, MYSQL_ASSOC) )
		{
			$EchoData .= '<li><a href="'.SITE_ROOT.'s/'.$array['RegdNo'].'">'.$array['Name'].'</a>('.$array['RegdNo'].')</li>';
		}
	}
	mysqli_close($db);
	echo $EchoData;