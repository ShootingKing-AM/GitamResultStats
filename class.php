<?php 
	$Page = 'Class';
	include_once 'header.php';
	include_once 'db.php';	
	include_once 'funcs.student.php';
	// include_once 'CalcClassND.php';
	include_once 'funcs.class.php';
	
	$ClassID = htmlspecialchars($_GET['i']);//12108131;
	
	$CurrSem = GetCurrentSemOfClass($db, $ClassID);
	// CalcClassNDforClassID($ClassID, $db);
?>
		<!-- Main -->
		<style>
		.datarow:hover
		{
			background-color: pink;
			transition: 0.5s all;
			color: black;
			cursor: pointer;
		}
		.datarow:click
		{
			transition: 0.1s all;
			backgroud: black;
			cursor: pointer;
		}			
		</style>
		<script>
			$(function(){
				$('.datarow').click(function() {
					var Data = $(this).children().first().text();
					Data = Data.trim();
					
					// var path = window.location.href.substring(0, (window.location.href.lastIndexOf("/")+1));					
					window.open( '<?php echo SITE_ROOT;?>s/'+Data, '_self');
				});
			});
		</script>
			<section id="main" class="wrapper">
				<div class="container">
					<header class="major">
						<h2>Class - <?php echo SectionOf($ClassID);?></h2>
						<p><?php echo BatchNo($ClassID);?> Batch.</p>
					</header>
					<div class="studentbox">
						<h3> Normal Distribution Chart (CGPA) : </h3>
						
						<canvas id="ndchartCGPA"></canvas>
						<script>
						$(function() {
							var ctx = $('#ndchartCGPA');
							var ctx1 = document.getElementById("ndchartCGPA").getContext("2d");
							ctx1.canvas.width = 250;
							ctx1.canvas.height = 150;
							
							var data = {
								labels: ["0-1.0", "1.0-2.0", "2.0-3.0", "3.0-4.0", "4.0-5.0", "5.0-6.0", "6.0-7.0", "7.0-8.0", "8.0-9.0", "9.0-10.0"],
								datasets: [
									{
										label: "No Of Students",
										fill: true,
										lineTension: 0.5,
										backgroundColor: "rgba(75,192,192,0.4)",
										borderColor: "rgba(75,192,192,1)",
										borderCapStyle: 'butt',
										borderDash: [],
										borderDashOffset: 0.0,
										borderJoinStyle: 'miter',
										pointBorderColor: "rgba(75,192,192,1)",
										pointBackgroundColor: "#fff",
										pointBorderWidth: 1,
										pointHoverRadius: 7,
										pointHoverBackgroundColor: "rgba(75,192,192,1)",
										pointHoverBorderColor: "rgba(220,220,220,1)",
										pointHoverBorderWidth: 2,
										pointRadius: 5,
										pointHitRadius: 10,
										data: //[65, 59, 80, 81, 56, 55, 40
										<?php
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
											
											// var_dump($DataGPA);
											echo '['.$DataCGPA['0-1'].', '.$DataCGPA['1-2'].', '.$DataCGPA['2-3'].', '.$DataCGPA['3-4'].', '.$DataCGPA['4-5'].', '.$DataCGPA['5-6'].', '.$DataCGPA['6-7'].', '.$DataCGPA['7-8'].', '.$DataCGPA['8-9'].', '.$DataCGPA['9-10'].']';
											$DataLineGPA = '['.$DataGPA['0-1'].', '.$DataGPA['1-2'].', '.$DataGPA['2-3'].', '.$DataGPA['3-4'].', '.$DataGPA['4-5'].', '.$DataGPA['5-6'].', '.$DataGPA['6-7'].', '.$DataGPA['7-8'].', '.$DataGPA['8-9'].', '.$DataGPA['9-10'].']';
										?>,
									}
								]
							};
							var myLineChart = new Chart(ctx, {
								type: 'line',
								data: data,
								options:{
									scales: {
										yAxes: [{
											display: true,
											scaleLabel: {
												display: true,
												labelString: "No of Students"
											}
										}],										
										xAxes: [{
											display: true,
											scaleLabel: {
												display: true,
												labelString: "CGPA Range"
											}
										}]
									}
								}
							});
						});
						</script>						
					</div>					
					<div class="studentbox">
						<h3> Normal Distribution Chart (GPA) : </h3>
						
						<canvas id="ndchartGPA"></canvas>
						<script>
						$(function() {
							var ctxgpa = $('#ndchartGPA');
							var ctx1gpa = document.getElementById("ndchartGPA").getContext("2d");
							ctx1gpa.canvas.width = 250;
							ctx1gpa.canvas.height = 150;
							
							var data2 = {
								labels: ["0-1.0", "1.0-2.0", "2.0-3.0", "3.0-4.0", "4.0-5.0", "5.0-6.0", "6.0-7.0", "7.0-8.0", "8.0-9.0", "9.0-10.0"],
								datasets: [
									{
										label: "No Of Students",
										fill: true,
										lineTension: 0.5,
										backgroundColor: "rgba(192, 75, 75,0.4)",
										borderColor: "rgba(192, 75, 75,1)",
										borderCapStyle: 'butt',
										borderDash: [],
										borderDashOffset: 0.0,
										borderJoinStyle: 'miter',
										pointBorderColor: "rgba(192, 75, 75,1)",
										pointBackgroundColor: "#fff",
										pointBorderWidth: 1,
										pointHoverRadius: 7,
										pointHoverBackgroundColor: "rgba(192, 75, 75,1)",
										pointHoverBorderColor: "rgba(220,220,220,1)",
										pointHoverBorderWidth: 2,
										pointRadius: 5,
										pointHitRadius: 10,
										data: <?php echo $DataLineGPA;?>,
									}
								]
							};
							var myGPAChart = new Chart(ctxgpa, {
								type: 'line',
								data: data2,
								options: {
									scales: {
										yAxes: [{
											display: true,
											scaleLabel: {
												display: true,
												labelString: "No of Students"
											}
										}],										
										xAxes: [{
											display: true,
											scaleLabel: {
												display: true,
												labelString: "GPA Range"
											}
										}]
									}
								}
							});
						});
						</script>						
					</div>
					<div class="studentbox">
						<h3> Subject Normal Distribution Chart : </h3>
						<select id="SubSelector">
							<?php
								$sql = "SELECT ";
								
								for( $Sem = 1; $Sem <= 8; $Sem ++ )
								{
									for( $Sub = 1; $Sub <= 9; $Sub++ )
									{
										$sql .= $Sem.'Sub'.$Sub.','.$Sem.'Sub'.$Sub.'Code';
										if( $Sem != 8 || $Sub != 9 )
										{
											$sql .= ',';
										}
									}
								}
								$sql .= " FROM resultsfinalultimate WHERE RegdNo like '$ClassID"."01'";
								$res = mysqli_fetch_array(mysqli_query($db, $sql));
								// echo $sql;
								for( $Sem = 1; $Sem <= 8; $Sem ++ )
								{
									for( $Sub = 1; $Sub <= 9; $Sub++ )
									{
										echo "<option sem='$Sem' sub='$Sub'>".$res[$Sem.'Sub'.$Sub.'Code'].' - '.$res[$Sem.'Sub'.$Sub].'</option>';
										if( $res[$Sem.'Sub'.$Sub] == NULL || $res[$Sem.'Sub'.$Sub] == '' )
											break;
									}
								}
							?>
						</select>
						<canvas id="Subndchart"></canvas>
						<script>
						$(function() {
							var ctxsnd = $('#Subndchart');
							var ctx1snd = document.getElementById("Subndchart").getContext("2d");
							ctx1snd.canvas.width = 250;
							ctx1snd.canvas.height = 150;
							
							var datactxsnd = {
								labels: ["O", "A+", "A", "B+", "B", "C", "F" ],
								datasets: [
									{
										label: "No Of Students",
										fill: true,
										lineTension: 0.5,
										backgroundColor: "rgba(87, 192, 75,0.4)",
										borderColor: "rgba(87, 192, 75,1)",
										borderCapStyle: 'butt',
										borderDash: [],
										borderDashOffset: 0.0,
										borderJoinStyle: 'miter',
										pointBorderColor: "rgba(87, 192, 75,1)",
										pointBackgroundColor: "#fff",
										pointBorderWidth: 1,
										pointHoverRadius: 7,
										pointHoverBackgroundColor: "rgba(87, 192, 75,1)",
										pointHoverBorderColor: "rgba(220,220,220,1)",
										pointHoverBorderWidth: 2,
										pointRadius: 5,
										pointHitRadius: 10,
										data: 
										<?php
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
											
											$Sem = $CurrSem;
											$Sub = 1;
											
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
											echo '['.$Data['O'].', '.$Data['A+'].', '.$Data['A'].', '.$Data['B+'].', '.$Data['B'].', '.$Data['C'].', '.($Data['F']+$Data['Ab']).']';
										?>
									}
								]
							};
							var SubNDChart = new Chart(ctxsnd, {
								type: 'line',
								data: datactxsnd,
								options: {
									scales: {
										yAxes: [{
											display: true,
											scaleLabel: {
												display: true,
												labelString: "No of Students"
											}
										}],										
										xAxes: [{
											display: true,
											scaleLabel: {
												display: true,
												labelString: "Grades"
											}
										}]
									}
								}
							});								
							$('#SubSelector').change(function() {
								$('#SubSelector').prop('disabled', 'disabled');
								$.post( "../getDataStringNDCSubject.php", { classid: '<?php echo $ClassID;?>', sem: $('option:selected', this).attr('sem'), sub: $('option:selected', this).attr('sub') })
									.done(function( data ) {
										console.log( "Data Loaded: " + data );
										res = data.split(",")
										for( var i = 0; i < 7; i++ )
										{
											SubNDChart.data.datasets[0].data[i] = res[i];
										}
										SubNDChart.update(1000); 
										$('#SubSelector').prop('disabled', false);
								});
							});
						});
						</script>						
					</div>
				
					<div class="studentbox">
						<style>
							td
							{
								vertical-align: middle;
							}
						</style>
						<h3> Students : </h3>
						<script>
							$(function(){
								$('#ClassStudents').DataTable({
									dom: 'Bfrtip',
									buttons: [
										'copy', 'csv', 'excel', 'pdf', 'print'
									]
								} );
							});
						</script>
						<table id="ClassStudents" data-order='[[ 4, "dsc" ]]' data-page-length='25'>
							<thead>
								<tr>
									<th> Roll Number </th>
									<th> Image </th>
									<th> Name </th>
									<th> GPA </th>
									<th> CGPA </th>
								</tr>
							</thead>
							<tbody>
								<?php
									if( $CurrSem > 1 )
									{
										$sql = "SELECT RegdNo,Name,CGPA".$CurrSem.",GPA".$CurrSem.",GPA".($CurrSem-1)." FROM resultsfinalultimate WHERE RegdNo LIKE '$ClassID%' ORDER BY RegdNo ASC";
										$res = mysqli_query($db, $sql);
										
										while( $DataSet = mysqli_fetch_array($res, MYSQLI_ASSOC) )
										{
											echo '<tr class="datarow" ><td>'.$DataSet['RegdNo'].'</td>'.
													'<td><img src="'.SITE_ROOT.'funcs.images.php?i='.$DataSet['RegdNo'].'" class="iconImg" /></td>'.
													'<td>'.$DataSet['Name'].'<span class="arrow-'.(($DataSet['GPA'.$CurrSem]>$DataSet['GPA'.($CurrSem-1)])?'up':'down').'"></span></td>'.
													'<td>'.$DataSet['GPA'.$CurrSem].'</td>'.
													'<td>'.$DataSet['CGPA'.$CurrSem].'</td></tr>';
										}
									}
									else
									{
										$sql = "SELECT RegdNo,Name,CGPA".$CurrSem.",GPA".$CurrSem." FROM resultsfinalultimate WHERE RegdNo LIKE '$ClassID%' ORDER BY RegdNo ASC";
										$res = mysqli_query($db, $sql);
										
										while( $DataSet = mysqli_fetch_array($res, MYSQLI_ASSOC) )
										{											
											echo '<tr><td>'.$DataSet['RegdNo'].'</td>'.
													'<td><img src="'.SITE_ROOT.'funcs.images.php?i='.$DataSet['RegdNo'].'" class="iconImg" /></td>'.													
													'<td>'.$DataSet['Name'].'</td>'.
													'<td>'.$DataSet['GPA'.$CurrSem].'</td>'.
													'<td>'.$DataSet['CGPA'.$CurrSem].'</td></tr>';
										}
									}										
								?>
							</tbody>
						</table>
					</div>
					
					<div class="studentbox">
					<style>
						.rank
						{
						    font-weight: bold;
							font-size: 1.5em;
						}
					</style>
						<h3>Position of Class in Batch: </h3>
						<h5>(i) Based on highest ND Candidates (CGPA): #<?php
							echo '<span class="rank">'.getClassRankBasedOnHNDSCG($ClassID, $CurrSem, $db).'</span>';
						?></h5>
						
						<h5>(ii) Based on highest ND Candidates (GPA): #<?php
							echo '<span class="rank">'.getClassRankBasedOnHNDSG($ClassID, $CurrSem, $db).'</span>';
						?></h5>
						
						<h5>(iii) Based on highest ND Candidates' Range (CGPA): #<?php
							echo '<span class="rank">'.getClassRankBasedOnHNDSRCG($ClassID, $CurrSem, $db).'</span>';
						?></h5>	
						
						<h5>(iv) Based on highest ND Candidates' Range (GPA): #<?php
							echo '<span class="rank">'.getClassRankBasedOnHNDSRG($ClassID, $CurrSem, $db).'</span>';
						?></h5>		
						
						<h5>(v) Based on highest Average CGPA: #<?php
							echo '<span class="rank">'.getClassRankBasedOnHAVGCG($ClassID, $CurrSem, $db).'</span>';
						?></h5>	
						
						<h5>(vi) Based on highest Average GPA: #<?php						
							echo '<span class="rank">'.getClassRankBasedOnHAVGG($ClassID, $CurrSem, $db).'</span>';
						?></h5>
						
						<h5>(vii) Based on highest Number of Passouts (CGPA): #<?php
							echo '<span class="rank">'.getClassRankBasedOnNPCG($ClassID, $CurrSem, $db).'</span>';
						?></h5>
						
						<h5>(viii) Based on highest Number of Passouts (GPA): #<?php
							echo '<span class="rank">'.getClassRankBasedOnNPG($ClassID, $CurrSem, $db).'</span>';
						?></h5>
					</div>
				</div>
			</section>
<?php include 'footer.php'; ?>