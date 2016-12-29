<?php 
	$Page = 'Branches';
	include 'header.php';
	include_once 'db.php';
	
	include_once 'funcs.student.php';	
?>
		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">

					<header class="major">
						<h2> Branches </h2>
					</header>
				</div>
			<?php for( $i = 1; $i <= 8; $i++ )
			{ ?>
				<div class="branchBox" id="<?php echo $PetNames[BranchOf('121'.(($i<10)?('0'.$i):$i))];?>">
					<h3><u><?php echo BranchOf('121'.(($i<10)?('0'.$i):$i));?></u></h3>
					<h4> Batches: </h4>
					
					<ul>
					<?php
						$sql = "SELECT RegdNo FROM resultsfinalultimate WHERE RegdNo LIKE '121".(($i<10)?('0'.$i):$i)."%101'";
						$res = mysqli_query( $db, $sql );
						
						while( $array = mysqli_fetch_array($res) )
						{
							echo '<li><a href="'.SITE_ROOT.'b/'.floor(intval($array['RegdNo'])/1000).'">'.BatchNo($array['RegdNo']).'</a></li>'; //target="_blank"
						}
					?>
					</ul>
				</div>
			<?php } ?>
			</section>
<?php include 'footer.php'; ?>