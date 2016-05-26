<?php
	include_once 'conf.php';
	$db = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_DBNAME );
	
	/* function shutdown()
	{
		mysqli_close($db);
	}
	
	register_shutdown_function('shutdown'); */