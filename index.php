<?php 
	$Page = 'GIT Stats';
	include 'header.php';
	include_once 'db.php';
	include_once 'funcs.student.php';
	
	function getCurrentBatch($Branch)
	{ 
		$Year = date('y');
		return '121'.(($Branch<10)?('0'.$Branch):$Branch).($Year-4);
	}
	
	$CurrSem = GetCurrentSemOfClass($db, getCurrentBatch(1).'1');
	$IconArray = array(
	
		'Biotechonology, GIT'=>'fa-envira',
		'Civil Engineering, GIT'=>'fa-building-o',
		'Computer Science & Engineering, GIT'=>'fa-laptop',
		'Electronics & Communication Engineering, GIT'=>'fa-sitemap',
		'Electrical & Electronics Engineering, GIT'=>'fa-plug',
		'Electronics & Instrumentation Engineering, GIT'=>'fa-code-fork',
		'Information Technology, GIT'=>'fa-server',
		'Mechanical Engineering, GIT'=>'fa-wrench'
	);
	
?>
		<!-- Banner -->
			<section id="banner">
				<h2>Git Statistics</h2>
				<p>Gitam Institute of Technology - Academic Statistics powerd by AwwStats.</p>
				<ul class="actions">
					<li>
						<a href="#" class="button big">Learn More</a>
					</li>
				</ul>
			</section>
<script>
	$(function()
	{
		function changeBg()
		{
			$('#header').css('background-color', 'rgb('+Math.floor((Math.random() * 255))+','+Math.floor((Math.random() * 255))+','+Math.floor((Math.random() * 255))+')');
			$('#header').css('background-image', 'linear-gradient(rgba(255, 255, 255, 0.5), white 5% )');
		}
		var inter = null;
		
		var waypoint = new Waypoint({
			element: document.getElementById('one'),
			handler: function(direction) {
				if( direction == 'down' )
				{
					$('#header').css('transition','.5s all');
					$('#header').css('color','black');
					$('#header').css('background-color', 'white');
					$('#sitename').css('color', 'black' );
					$('#sitename').css('font-weight', 'bolder' );
					// $('#header').css('height', $('#header').height()*0.75);
					
					inter = setInterval( function() { changeBg() }, 1000 );
				}
				else
				{
					if( inter != null ) 
					{
						clearInterval(inter);
						inter = null;
					}
					$('#header').css('transition','.5s all');
					$('#header').css('color','white');
					$('#header').css('background-image', 'none');
					$('#header').css('background-color', 'rgba(0,0,0,0)');
					$('#sitename').css('color', 'white' );
					$('#sitename').css('font-weight', 'normal' );
					// $('#header').css('height', $('#header').height()/0.75);
				}				
			}
		});
	});
</script>
<style>
	.rankings > ol > li > a
	{
		color: white;
	}
	.rankings > ol > li
	{
		text-align:left;
	}
	.rankings > h3
	{
		color: white;
		font-weight:bold;
	}
</style>
		<!-- One -->
			<section id="one" class="wrapper style1 align-center">
				<div class="container">
					<header>
						<h2>Gitam Institute Of Technology</h2>
						<p>Branches</p>
					</header>
					<div class="row 200%">
						<?php for( $i = 1; $i <= 8; $i++ ) 
						{ 
							$BatchID = getCurrentBatch($i);
						?>
						<section class="4u 12u$(small) rankings" style="width: 50%">
							<i class="icon big rounded <?php echo $IconArray[BranchOf($BatchID)];?>"></i>
							<h3><?php echo BranchOf($BatchID);?></h3>
							<ol class="rankings">
							<?php
								$sql = "SELECT Name,RegdNo,CGPA$CurrSem FROM resultsfinalultimate WHERE RegdNo LIKE '$BatchID%' ORDER BY CGPA$CurrSem DESC LIMIT 3";
								// echo $sql;
								$res = mysqli_query($db, $sql);
								while( $Data = mysqli_fetch_array($res) )
								{
									echo '<li><a href="'.SITE_ROOT.'s/'.$Data['RegdNo'].'">'.$Data['Name'].'</a>('.$Data["CGPA$CurrSem"].')</li>'; //target="_blank" 
								}
							?>		
							<ol>
						</section>
						<?php 
							if( $i%2 == 0 )
							{
								echo '</div><div class="row 200%">';
							}
						} ?>
					</div>
				</div>
			</section>

		<!-- Two -->
<script>
	var transform_styles = ['-webkit-transform', '-ms-transform', 'transform'];
	
	function setRotation( id, deg )
	{
		for(i in transform_styles) {
			$('.fill, .circle .mask.full').css(transform_styles[i], 'rotate(' + deg + 'deg)');
			$('.fill.fix').css(transform_styles[i], 'rotate(' + deg*2 + 'deg)');
		}
	}
	
	var iStudents = 9573;
	var iBranches = 8;
	var iVisits = 476;
	var iBatches = 8;
	
	var iCountStudents = 0;
	var iCountBranches = 0;
	var iCountVisits = 0;
	var iCountBatches = 0;
	
	var time = 2000;
	
	var iStudentsStepSize = 5*Math.ceil(iStudents/time);
	var iBranchesStepSize = 2*Math.ceil(iBranches/time);
	var iVisitsStepSize = 2*Math.ceil(iVisits/time);
	var iBatchesStepSize = 2*Math.ceil(iBatches/time);
	
	var studentInter = null;
	var branchesInter = null;
	var VisitsInter = null;
	var BatchesInter = null;
	
	var Circle = null;
	var setpSizeOfCircle = 4*180/2000;
	var currentRot = 0;
	
	function countToNumBranches()
	{
		BranchesInter = setInterval(function() {
			if( iCountBranches < iBranches )
			{
				iCountBranches += iBranchesStepSize;
				$('#branchesp .inset .percentage').text(iCountBranches);
			}
			else
			{
				$('#branchesp .inset .percentage').text(iBranches);
				clearInterval(BranchesInter);
			}
		}
		, iBatchesStepSize);
	}
	
	function countToNumBatches()
	{
		BatchesInter = setInterval(function() {
			if( iCountBatches < iBatches )
			{
				iCountBatches += iBatchesStepSize;
				$('#batchesp .inset .percentage').text(iCountBatches);		
			}
			else
			{
				$('#batchesp .inset .percentage').text(iBatches);		
				clearInterval(BatchesInter);
			}
		}
		, iBatchesStepSize);
	}
	
	function countToNumVisits()
	{
		VisitsInter = setInterval(function() {
			if( iCountVisits < iVisits )
			{
				iCountVisits += iVisitsStepSize;			
				currentRotVisits = (iCountVisits/iVisits)*180;
				$('#visitsp .inset .percentage').text(iCountVisits);
			}
			else
			{
				$('#visitsp .inset .percentage').text(iVisits);
				clearInterval(VisitsInter);
			}		
		}
		, iVisitsStepSize);
	}
	
	function countToNumStuds()
	{
		studentInter = setInterval(function() {
			if( iCountStudents < iStudents )
			{
				iCountStudents += iStudentsStepSize;		
				$('#studsp .inset .percentage').text(iCountStudents);
			}
			else
			{
				$('#studsp .inset .percentage').text(iStudents);
				clearInterval(studentInter);
			}
		}
		, iStudentsStepSize);
		
	}
	
	function animateCircles()
	{
		Circle = setInterval(function() {
			if( currentRot+setpSizeOfCircle <= 180 )
			{
				currentRot += setpSizeOfCircle
				setRotation('.circle', currentRot);
			}
			else
			{
				setRotation('.circle', 180);
				clearInterval(Circle);
			}			
		}, 2);
	}
		
	notDone = true;
		
	$(function() {
		var waypointCircles = new Waypoint({
			element: document.getElementById('two'),
			handler: function(direction) {
				if( notDone == true )
				{
					animateCircles();
					countToNumStuds();
					countToNumBatches();
					countToNumBranches();
					countToNumVisits();
					notDone = false;
				}
			}
		});
	});
</script>
			<section id="two" class="wrapper style2 align-center">
				<div class="container">
					<div class="row">
						<section class="feature 4u 12u$(small)" style="width:25%">
							<h3 class="title">Students</h3>
							<div id="studsp" class="radial-progress">
								<div class="circle">
									<div class="mask full">
									  <div class="fill"></div>
									</div>
									<div class="mask half">
									  <div class="fill"></div>
										<div class="fill fix"></div>
									</div>
									<div class="shadow"></div>
								</div>			
								<div class="inset">
									<div class="percentage"></div>
								</div>
							</div>
						</section>
						<section class="feature 4u 12u$(small)" style="width:25%">
							<h3 class="title">Branches</h3>
							<div id="branchesp" class="radial-progress">
								<div class="circle">
									<div class="mask full">
									  <div class="fill"></div>
									</div>
									<div class="mask half">
									  <div class="fill"></div>
										<div class="fill fix"></div>
									</div>
									<div class="shadow"></div>
								</div>			
								<div class="inset">
									<div class="percentage"></div>
								</div>
							</div>				
						</section>
						<section class="feature 4u 12u$(small)" style="width:25%">
							<h3 class="title">Batches</h3>
							<div id="batchesp" class="radial-progress">
								<div class="circle">
									<div class="mask full">
									  <div class="fill"></div>
									</div>
									<div class="mask half">
									  <div class="fill"></div>
										<div class="fill fix"></div>
									</div>
									<div class="shadow"></div>
								</div>			
								<div class="inset">
									<div class="percentage"></div>
								</div>
							</div>				
						</section>
						<section class="feature 4u 12u$(small)" style="width:25%">
							<h3 class="title">Visits</h3>
							<div id="visitsp" class="radial-progress">
								<div class="circle">
									<div class="mask full">
									  <div class="fill"></div>
									</div>
									<div class="mask half">
									  <div class="fill"></div>
										<div class="fill fix"></div>
									</div>
									<div class="shadow"></div>
								</div>			
								<div class="inset">
									<div class="percentage"></div>
								</div>
							</div>					
						</section>
					</div>
				</div>
			</section>

<?php include 'footer.php'; ?>