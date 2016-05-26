<?php 
	$Page = 'Student';
	include 'header.php';
	$RegdNo = htmlspecialchars($_GET['i']);// 1210813162; // Expecting from $_POST/$_GET
	include_once 'db.php';
	// RewriteRule    "^/student/.php$"  "/error" [PT]
	$Details = mysqli_fetch_array(mysqli_query($db, "SELECT * FROM resultsfinalultimate WHERE RegdNo='$RegdNo'"), MYSQLI_ASSOC);
	// var_dump($Details);
	include_once 'funcs.student.php';
	
	$CurrentSem = GetCurrentSem($Details);
?>
		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">

					<header class="major">
						<h2>Student Stats</h2>
					</header>
					<!--<h3> Details : </h3>-->
					<dl class="studentbox" >
						<dt>Name :</dt>
						<dd><?php echo $Details['Name']; ?></dd>
						<dt>RegdNo :</dt>
						<dd><?php echo '<a href="'.SITE_ROOT.'s/'.$RegdNo.'">'.$RegdNo.'</a>' ?></dd>
						<dt>RollNo :</dt>
						<dd><?php echo ($RegdNo%100); ?></dd>
						<dt>Branch :</dt>
						<dd><?php echo '<a href="'.SITE_ROOT.'branch.php">'.BranchOf($RegdNo).'</a>'; ?></dd>
						<dt>Section :</dt>
						<dd><?php echo '<a href="'.SITE_ROOT.'c/'.floor($RegdNo/100).'">'.SectionOf($RegdNo).'</a>'; ?></dd>
						<dt>Batch :</dt>
						<dd><?php echo '<a href="'.SITE_ROOT.'b/'.floor($RegdNo/1000).'">'.BatchNo($RegdNo).'</a>'; ?></dd>
						<dt>Ongoing :</dt>
						<dd><?php echo (IsOnGoing($Details)?'Yes':'No'); ?></dd>
						<dt>CGPA :</dt>
						<dd><?php echo $Details['CGPA'.GetCurrentSem($Details)]; ?></dd>
						<dt>GPA :</dt>
						<dd><?php echo $Details['GPA'.GetCurrentSem($Details)]; ?></dd>
					</dl>
					
					<h2> Previous SemResults : </h2>
					<select id="SemSelector">
						<?php					
							for( $i = 1; $i < $CurrentSem; $i++ )
							{
								echo "<option sem='$i'>Sem - ".$i.'</option>';
							}		
							echo "<option sem='$i' selected>Sem - ".$i.' (Click to change Sem)</option>';				
						?>
					</select> <br/>
					<script>
						$(function() {
							$('#SemSelector').change(function() {
								$('#SemSelector').prop('disabled', 'disabled');
								$.post( "../getSemResults.php", { regdno: '<?php echo $RegdNo;?>', sem: $('option:selected', this).attr('sem')})
									.done(function( data ) {
										console.log( "Data Loaded: " + data );
										$('#resultsBody').html(data);
										$('#SemSelector').prop('disabled', false);
								});
							});
						});
					</script>
					<table>
						<thead>
							<tr>
								<th> Course Code </th>
								<th> Name </th>
								<th> Credits </th>
								<th> Grade </th>
							</tr>
						</thead>
						<tbody id="resultsBody">
							<?php 
								
								for( $i = 1; $i < 10; $i++ )
								{
									echo '<tr><td>'.$Details[$CurrentSem.'Sub'.$i.'Code'].'</td>'.
										'<td>'.$Details[$CurrentSem.'Sub'.$i].'</td>'.
										'<td>'.$Details[$CurrentSem.'Sub'.$i.'Credits'].'</td>'.
										'<td>'.$Details[$CurrentSem.'Sub'.$i.'Points'].'</td></tr>';
								}
							?>
							<tr> <td/><td/>
								<td> <b>GPA</b> </td>
								<td> <b><?php echo $Details['GPA'.GetCurrentSem($Details)]; ?></b> </td>
							</tr>
							<tr> <td/><td/>
								<td> <b>CGPA</b> </td>
								<td> <b><?php echo $Details['CGPA'.GetCurrentSem($Details)]; ?></b> </td>
							</tr>
						</tbody>
					</table>
				</div>
				<div class="studentbox" >
					<canvas id="cgpaLineC"></canvas>
					<script>
					$(function() {
						var ctx = $('#cgpaLineC');
						var ctx1 = document.getElementById("cgpaLineC").getContext("2d");
						ctx1.canvas.width = 250;
						ctx1.canvas.height = 150;
						
						var data = {
							labels:
							<?php						
								echo '[';
								for( $i = 1; $i < 9; $i++ )
								{
									if( $Details['CGPA'.$i] != NULL && $Details['CGPA'.$i] != '' && $i!=8 )
									{
										echo '"Sem '.$i.'", ';
									}
									else
									{
										if( $i == 8 && $Details['CGPA'.$i] != NULL && $Details['CGPA'.$i])
										{
											echo '"Sem '.$i.'"';
										}
										echo ']'; break;
									}
								}
							?>,
							datasets: [
								{
									label: "CGPA",
									fill: false,
									lineTension: 0.1,
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
										echo '[';
										for( $i = 1; $i < 9; $i++ )
										{
											echo $Details['CGPA'.$i];
											if( $i == 8 ||
												$Details['CGPA'.($i+1)] == NULL || 
												$Details['CGPA'.($i+1)] == '' )
											{
												echo ']';break;
											}
											else
											{
												echo ', ';
											}
										}
									?>,
								},								
								{
									label: "GPA",
									fill: false,
									lineTension: 0.1,
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
									data: //[65, 59, 80, 81, 56, 55, 40
									<?php
										echo '[';
										for( $i = 1; $i < 9; $i++ )
										{
											echo $Details['GPA'.$i];
											if(  $i == 8 || 
												$Details['GPA'.($i+1)] == NULL || 
												$Details['GPA'.($i+1)] == '')
											{
												echo ']';break;
											}
											else
											{
												echo ', ';
											}
										}
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
										ticks: {
											// suggestedMin: 0,
											// beginAtZero: true
										}
									}]
								}
							}
						});
					});
					</script>
				</div>
				<div class="studentbox">
					<h3> Position in Class : </h3>
					<span>Based on CGPA : #<?php echo GetPositionInClassCGPA($db, $Details); ?></span><br/>
					<span>Based on GPA : #<?php echo GetPositionInClassGPA($db, $Details); ?></span>
				</div>
				<div class="studentbox">
					<h3> Position in Batch(<?php echo BatchNo($RegdNo);?>) : </h3>
					<span>Based on CGPA : #<?php echo GetPositionInBatchCGPA($db, $Details); ?></span><br/>
					<span>Based on GPA : #<?php echo GetPositionInBatchGPA($db, $Details); ?></span>
				</div>
				<div class="studentbox">
					<h3> Position in Branch(from 2008 to current) : </h3>
					<span>Based on CGPA : #<?php echo GetPositionInBranchCGPA($db, $Details); ?></span><br/>
					<span>Based on GPA : #<?php echo GetPositionInBranchGPA($db, $Details); ?></span>
				</div>
				<div class="studentbox">
					<canvas id="gradesDonut"></canvas>
					<script>
					$(function() {
						var ctx1Donut = document.getElementById("gradesDonut").getContext("2d");
						ctx1Donut.canvas.width = 75;
						ctx1Donut.canvas.height = 50;
						
						var datad = {
							labels: [
								"O Grades", "A+ Grades", "A Grades", "B+ Grades", "B Grades", "C Grades", "F Grades"
							],
							datasets: [
							{
								data: //[300, 50, 100]
								<?php
									$Grades = array(
										"O" => 0,
										"A+" => 0,
										"A" => 0,
										"B+" => 0,
										"B" => 0,
										"C" => 0,
										"F" => 0
									);
									
									for( $Sem = 1; $Sem <= GetCurrentSem($Details); $Sem++ )
									{
										for( $Sub = 1; $Sub <= 9; $Sub++ )
										{
											if( $Details[$Sem.'Sub'.$Sub.'Points'] != NULL && $Details[$Sem.'Sub'.$Sub.'Points'] != '' )
											{
												$Details[$Sem.'Sub'.$Sub.'Points'] = trim($Details[$Sem.'Sub'.$Sub.'Points']);
												$Grades[$Details[$Sem.'Sub'.$Sub.'Points']]++;
											}
										}
									}
									
									echo '['.$Grades["O"].', '.$Grades["A+"].', '.$Grades["A"].', '.$Grades["B+"].', '.$Grades["B"].', '.$Grades["C"].', '.$Grades["F"].']';
								?>
								,
								backgroundColor: [
									"#FF6384",
									"#36A2EB",
									"#FFCE56",
									"rgb(189, 99, 255)",
									"rgb(99, 110, 255)",
									"rgb(99, 255, 105)",
									"rgb(255, 179, 99)"
								],
								hoverBackgroundColor: [
									"#FF6384",
									"#36A2EB",
									"#FFCE56",
									"rgb(189, 99, 255)",
									"rgb(99, 110, 255)",
									"rgb(99, 255, 105)",
									"rgb(255, 179, 99)"
								]
							}]
						};
						var myDonutChart = new Chart(ctx1Donut, {
							type: 'doughnut',
							data: datad
						});
					});
					</script>
				</div>
			</section>
<?php include 'footer.php'; ?>