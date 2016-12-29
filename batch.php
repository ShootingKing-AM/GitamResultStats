<?php 
	$Page = 'Batch';
	include 'header.php';
	include_once 'db.php';
	include_once 'funcs.student.php';
	
	$BatchID = htmlspecialchars($_GET['i']);//1210813;
	
?>
		<!-- Main -->
			<section id="main" class="wrapper">
				<div class="container">
					<header class="major">
						<h2>Batch <?php echo BatchNo($BatchID); ?></h2>
						<p><?php echo BranchOf($BatchID); ?></p>
					</header>
					<div class="studentbox">
						<h4> Number of Sections : <?php
							$sql = "SELECT COUNT(*) FROM resultsfinalultimate WHERE RegdNo LIKE '$BatchID%01'";
							$res = mysqli_query($db, $sql);
							$array = mysqli_fetch_array($res, MYSQLI_ASSOC);
							$NoOfSec = $array['COUNT(*)'];
							echo $NoOfSec;
						?>
						</h4>
						<ul>
						<?php for( $i = 1; $i <= $NoOfSec; $i++ )
						{
							echo '<li><a href="'.SITE_ROOT.'c/'.$BatchID.$i.'">Section '. SectionOf($BatchID.$i). '</a></li>'; //target=_blank
						}
						?>
						</ul>
					</div>
					<div class="studentbox">
						<!-- ND MaxStudens CGPA, X- SemNo, Y- No of Students, Lines - Sections -->
						<h3> Normal Distribution MaxStudens (CGPA) : </h3>
						
						<canvas id="MaxStudentsCGPAC"></canvas>
						<script>
						$(function() {
							var MaxStudentsCGPAChartx = $('#MaxStudentsCGPAC');
							var MaxStudentsCGPAx1 = document.getElementById("MaxStudentsCGPAC").getContext("2d");
							MaxStudentsCGPAx1.canvas.width = 250;
							MaxStudentsCGPAx1.canvas.height = 150;
							
							var dataMaxStudentsCGPACx = {
								labels:							
								<?php						
									echo '[';
									$CurrSem = GetCurrentSemOfClass($db, $BatchID.'1');
									
									for( $i = 1; $i <= $CurrSem; $i++ )
									{
										if( $i != $CurrSem )
										{
											echo '"Sem '.$i.'", ';
										}
										else
										{
											echo '"Sem '.$i.'"]'; break;
										}
									}
								?>,
								datasets: [
								<?php for( $i = 1; $i <= $NoOfSec; $i++ ) { 
									$rgbcolor = "rgba(".rand(0,255).",".rand(0,255).",".rand(0,255).",";
								?>									
									{
										label: "<?php echo SectionOf($BatchID.$i); ?>",
										fill: false,
										lineTension: 0.2,
										backgroundColor: "<?php echo $rgbcolor;?>0.4)",
										borderColor: "<?php echo $rgbcolor;?>1)",
										borderCapStyle: 'butt',
										borderDash: [],
										borderDashOffset: 0.0,
										borderJoinStyle: 'miter',
										pointBorderColor: "<?php echo $rgbcolor;?>1)",
										pointBackgroundColor: "#fff",
										pointBorderWidth: 1,
										pointHoverRadius: 7,
										pointHoverBackgroundColor: "<?php echo $rgbcolor;?>1)",
										pointHoverBorderColor: "rgba(220,220,220,1)",
										pointHoverBorderWidth: 2,
										pointRadius: 5,
										pointHitRadius: 10,
										data: [ //[65, 59, 80, 81, 56, 55, 40
										<?php
											$sql = "SELECT MaxStudentsCGPA,SemNo FROM resultsclasstats WHERE ClassID LIKE '$BatchID".$i."' ORDER BY SemNo ASC";
											$res = mysqli_query($db, $sql);											
											
											while( $DataArr = mysqli_fetch_array($res, MYSQLI_ASSOC) )
											{
												echo $DataArr['MaxStudentsCGPA'];
												
												if( $DataArr['SemNo'] == $CurrSem )
													echo ']';
												else
													echo ', ';
											}
										?>
									},
									<?php } ?>
								]
							};
							var MaxStudentsCGPAChart = new Chart(MaxStudentsCGPAChartx, {
								type: 'line',
								data: dataMaxStudentsCGPACx,
								options:{
									scales: {
										yAxes: [{
											display: true,
											scaleLabel: {
												display: true,
												labelString: "No of Students"
											}
										}]
									}
								}
							});
						});
						</script>	
					</div>
					<div class="studentbox">
						<!-- ND MaxStudens CGPA, X- SemNo, Y- Ramge, Lines - Sections -->
						<h3> Normal Distribution MaxStudens Range (CGPA) : </h3>
						
						<canvas id="MaxStudentsRangeCGPAC"></canvas>
						<script>
						$(function() {
							var MaxStudentsCGPARangeChartx = $('#MaxStudentsRangeCGPAC');
							var MaxStudentsCGPARangeChartx1 = document.getElementById("MaxStudentsRangeCGPAC").getContext("2d");
							MaxStudentsCGPARangeChartx1.canvas.width = 250;
							MaxStudentsCGPARangeChartx1.canvas.height = 150;
							
							var dataMaxStudentsCGPARangeChartx = {
								labels:							
								<?php						
									echo '[';
									$CurrSem = GetCurrentSemOfClass($db, $BatchID.'1');
									
									for( $i = 1; $i <= $CurrSem; $i++ )
									{
										if( $i != $CurrSem )
										{
											echo '"Sem '.$i.'", ';
										}
										else
										{
											echo '"Sem '.$i.'"]'; break;
										}
									}
								?>,
								datasets: [
								<?php for( $i = 1; $i <= $NoOfSec; $i++ ) { 
									$rgbcolor = "rgba(".rand(0,255).",".rand(0,255).",".rand(0,255).",";
								?>									
									{
										label: "<?php echo SectionOf($BatchID.$i); ?>",
										fill: false,
										lineTension: 0.2,
										backgroundColor: "<?php echo $rgbcolor;?>0.4)",
										borderColor: "<?php echo $rgbcolor;?>1)",
										borderCapStyle: 'butt',
										borderDash: [],
										borderDashOffset: 0.0,
										borderJoinStyle: 'miter',
										pointBorderColor: "<?php echo $rgbcolor;?>1)",
										pointBackgroundColor: "#fff",
										pointBorderWidth: 1,
										pointHoverRadius: 7,
										pointHoverBackgroundColor: "<?php echo $rgbcolor;?>1)",
										pointHoverBorderColor: "rgba(220,220,220,1)",
										pointHoverBorderWidth: 2,
										pointRadius: 5,
										pointHitRadius: 10,
										data: [ //[65, 59, 80, 81, 56, 55, 40
										<?php
											$sql = "SELECT MaxIndexCGPA,SemNo FROM resultsclasstats WHERE ClassID LIKE '$BatchID".$i."' ORDER BY SemNo ASC";
											$res = mysqli_query($db, $sql);											
											
											while( $DataArr = mysqli_fetch_array($res, MYSQLI_ASSOC) )
											{
												$Range = intval(substr($DataArr['MaxIndexCGPA'],0,1));
												
												echo (2*$Range+1)*0.5;
												
												if( $DataArr['SemNo'] == $CurrSem )
													echo ']';
												else
													echo ', ';
											}
										?>
									},
									<?php } ?>
								]
							};
							var MaxStudentsCGPARangeChart = new Chart(MaxStudentsCGPARangeChartx, {
								type: 'line',
								data: dataMaxStudentsCGPARangeChartx,
								options:{
									scales: {
										yAxes: [{
											display: true,
											scaleLabel: {
												display: true,
												labelString: "CGPA Range"
											},
											ticks: {
												stepSize: 1
											}
										}]
									}
								}
							});
						});
						</script>	
					</div>
					<div class="studentbox">
						<!-- ND MaxStudens CGPA, X- SemNo, Y- CGPA, Lines - Sections -->
						<h3> Total Average CGPA : </h3>
						
						<canvas id="AvgCGPAC"></canvas>
						<script>
						$(function() {
							var AvgCGPAx = $('#AvgCGPAC');
							var AvgCGPAx1 = document.getElementById("AvgCGPAC").getContext("2d");
							AvgCGPAx1.canvas.width = 250;
							AvgCGPAx1.canvas.height = 150;
							
							var dataAvgCGPAx = {
								labels:							
								<?php						
									echo '[';
									$CurrSem = GetCurrentSemOfClass($db, $BatchID.'1');
									
									for( $i = 1; $i <= $CurrSem; $i++ )
									{
										if( $i != $CurrSem )
										{
											echo '"Sem '.$i.'", ';
										}
										else
										{
											echo '"Sem '.$i.'"]'; break;
										}
									}
								?>,
								datasets: [
								<?php for( $i = 1; $i <= $NoOfSec; $i++ ) { 
									$rgbcolor = "rgba(".rand(0,255).",".rand(0,255).",".rand(0,255).",";
								?>									
									{
										label: "<?php echo SectionOf($BatchID.$i); ?>",
										fill: false,
										lineTension: 0.2,
										backgroundColor: "<?php echo $rgbcolor;?>0.4)",
										borderColor: "<?php echo $rgbcolor;?>1)",
										borderCapStyle: 'butt',
										borderDash: [],
										borderDashOffset: 0.0,
										borderJoinStyle: 'miter',
										pointBorderColor: "<?php echo $rgbcolor;?>1)",
										pointBackgroundColor: "#fff",
										pointBorderWidth: 1,
										pointHoverRadius: 7,
										pointHoverBackgroundColor: "<?php echo $rgbcolor;?>1)",
										pointHoverBorderColor: "rgba(220,220,220,1)",
										pointHoverBorderWidth: 2,
										pointRadius: 5,
										pointHitRadius: 10,
										data: [ //[65, 59, 80, 81, 56, 55, 40
										<?php
											$sql = "SELECT AvgCGPA,SemNo FROM resultsclasstats WHERE ClassID LIKE '$BatchID".$i."' ORDER BY SemNo ASC";
											$res = mysqli_query($db, $sql);											
											
											while( $DataArr = mysqli_fetch_array($res, MYSQLI_ASSOC) )
											{
												echo substr($DataArr['AvgCGPA'],0,6);
												
												if( $DataArr['SemNo'] == $CurrSem )
													echo ']';
												else
													echo ', ';
											}
										?>
									},
									<?php } ?>
								]
							};
							var AvgCGPAChart = new Chart(AvgCGPAx, {
								type: 'line',
								data: dataAvgCGPAx,
								options:{
									scales: {
										yAxes: [{
											display: true,
											scaleLabel: {
												display: true,
												labelString: "No of Students"
											}
										}]
									}
								}
							});
						});
						</script>	
					</div>
					<div class="studentbox">
						<!-- ND MaxStudens CGPA, X- SemNo, Y- No of Students, Lines - Sections -->
						<h3> Passouts (CGPA) : </h3>
						
						<canvas id="PassoutsCGPAC"></canvas>
						<script>
						$(function() {
							var PassoutsChartx = $('#PassoutsCGPAC');
							var PassoutsChartx1 = document.getElementById("PassoutsCGPAC").getContext("2d");
							PassoutsChartx1.canvas.width = 250;
							PassoutsChartx1.canvas.height = 150;
							
							var dataPassoutsChartx = {
								labels:							
								<?php						
									echo '[';
									$CurrSem = GetCurrentSemOfClass($db, $BatchID.'1');
									
									for( $i = 1; $i <= $CurrSem; $i++ )
									{
										if( $i != $CurrSem )
										{
											echo '"Sem '.$i.'", ';
										}
										else
										{
											echo '"Sem '.$i.'"]'; break;
										}
									}
								?>,
								datasets: [
								<?php for( $i = 1; $i <= $NoOfSec; $i++ ) { 
									$rgbcolor = "rgba(".rand(0,255).",".rand(0,255).",".rand(0,255).",";
								?>									
									{
										label: "<?php echo SectionOf($BatchID.$i); ?>",
										fill: false,
										lineTension: 0.2,
										backgroundColor: "<?php echo $rgbcolor;?>0.4)",
										borderColor: "<?php echo $rgbcolor;?>1)",
										borderCapStyle: 'butt',
										borderDash: [],
										borderDashOffset: 0.0,
										borderJoinStyle: 'miter',
										pointBorderColor: "<?php echo $rgbcolor;?>1)",
										pointBackgroundColor: "#fff",
										pointBorderWidth: 1,
										pointHoverRadius: 7,
										pointHoverBackgroundColor: "<?php echo $rgbcolor;?>1)",
										pointHoverBorderColor: "rgba(220,220,220,1)",
										pointHoverBorderWidth: 2,
										pointRadius: 5,
										pointHitRadius: 10,
										data: [ //[65, 59, 80, 81, 56, 55, 40
										<?php
											$sql = "SELECT NoOfPassCGPA,SemNo FROM resultsclasstats WHERE ClassID LIKE '$BatchID".$i."' ORDER BY SemNo ASC";
											$res = mysqli_query($db, $sql);											
											
											while( $DataArr = mysqli_fetch_array($res, MYSQLI_ASSOC) )
											{
												echo $DataArr['NoOfPassCGPA'];
												
												if( $DataArr['SemNo'] == $CurrSem )
													echo ']';
												else
													echo ', ';
											}
										?>
									},
									<?php } ?>
								]
							};
							var PassoutsChart = new Chart(PassoutsChartx, {
								type: 'line',
								data: dataPassoutsChartx,
								options:{
									scales: {
										yAxes: [{
											display: true,
											scaleLabel: {
												display: true,
												labelString: "No of Students"
											}
										}]
									}
								}
							});
						});
						</script>	
					</div>
					<div class="studentbox">
						<script>
							$(function(){
								$('#Classes').DataTable({
									dom: 'Bfrtip',
									buttons: [
										'copy', 'csv', 'excel', 'pdf', 'print'
									]
								} );
							});
						</script>
						<table id="Classes" data-order='[[ 0, "asc" ],[ 1, "asc" ]]' data-page-length='25'>
							<thead>
								<tr>
									<th> ClassName </th>
									<th> SemNo </th>
									<th> ND MaxStudens CGPA </th>
									<th> ND MaxStudens GPA </th>
									<th> ND Max CGPA Range </th>
									<th> ND Max GPA Range </th>
									<th> Average CGPA </th>
									<th> Average GPA </th>
									<th> Passouts (CGPA) </th>
									<th> Passouts (GPA) </th>
								</tr>
							</thead>
							<tbody>
							<?php
								$sql = "SELECT * FROM resultsclasstats WHERE ClassID LIKE '$BatchID%'";
								$res = mysqli_query($db, $sql);
										
								while( $Data = mysqli_fetch_array($res) )
								{
									echo '<tr><td>'.SectionOf($Data['ClassID']).'</td>'.
										'<td>'.$Data['SemNo'].'</td>'.
										'<td>'.$Data['MaxStudentsCGPA'].'</td>'.
										'<td>'.$Data['MaxStudentsGPA'].'</td>'.
										'<td>'.$Data['MaxIndexCGPA'].'</td>'.
										'<td>'.$Data['MaxIndexGPA'].'</td>'.
										'<td>'.substr($Data['AvgCGPA'],0,6).'</td>'.
										'<td>'.substr($Data['AvgGPA'],0,6).'</td>'.
										'<td>'.$Data['NoOfPassCGPA'].'</td>'.
										'<td>'.$Data['NoOfPassGPA'].'</td></tr>';
								}
							?>
							</tbody>
						</table>			
					</div>
					<div class="studentbox">
						<h3> Students : </h3>
						<script>
							$(function(){
								$('#ClassStudents').DataTable( {
									dom: 'Bfrtip',
									buttons: [
										'copy', 'csv', 'excel', 'pdf', 'print'
									]
								} );
							});
							$(function(){
								$('#ClassStudents').on('click','.datarow',function () {
									var Data = $(this).children().first().next().text();
									Data = Data.trim();
									
									// var path = window.location.href.substring(0, (window.location.href.lastIndexOf("/")+1));					
									window.open( '<?php echo SITE_ROOT;?>s/'+Data, '_self');
								});
							});
						</script>
						<style>
						
							td
							{
								vertical-align: middle;
							}
							.label
							{
								font-size: 0.75em;
								border-radius: 3px;
								
								padding-top: 2px;
								padding-bottom: 2px;
								padding-left: 5px;
								padding-right: 5px;
								font-weight: bold;
							}
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
							<?php
								for( $i = 1; $i <= $NoOfSec; $i++ )
								{
									$rgbcolor = "rgba(".rand(0,225).",".rand(0,225).",".rand(0,225).",";
									echo '.sec'.$i.' { color: rgb(255, 255, 255);background-color: '.$rgbcolor.'0.8);}';
								}							
							?>
						</style>
						<table id="ClassStudents" data-order='[[ 5, "dsc" ]]' data-page-length='25'>
							<thead>
								<tr>
									<th> # </th>
									<th> Roll Number </th>
									<th> Image </th>
									<th> Name </th>
									<th> GPA </th>
									<th> CGPA </th>
								</tr>
							</thead>
							<tbody>
								<?php
									$i = 0;
									if( $CurrSem > 1 )
									{
										$sql = "SELECT RegdNo,Name,CGPA".$CurrSem.",GPA".$CurrSem.",GPA".($CurrSem-1)." FROM resultsfinalultimate WHERE RegdNo LIKE '$BatchID%' ORDER BY CGPA".$CurrSem." DESC";
										$res = mysqli_query($db, $sql);
										
										while( $DataSet = mysqli_fetch_array($res, MYSQLI_ASSOC) )
										{
											$i++;
											$ClassID = floor(intval($DataSet['RegdNo'])/100)%10;							
											echo '<tr class="datarow"><td> #'.$i.'</td>'.
													'<td>'.$DataSet['RegdNo'].'</td>'.
													'<td><img src="'.SITE_ROOT.'funcs.images.php?i='.$DataSet['RegdNo'].'" class="iconImg" /></td>'.
													'<td>'.$DataSet['Name'].'<span class="label sec'.$ClassID.'">'.str_replace(' ', '', SectionOf($DataSet['RegdNo'])).'</td>'.
													'<td>'.$DataSet['GPA'.$CurrSem].'</span><span class="arrow-'.(($DataSet['GPA'.$CurrSem]>$DataSet['GPA'.($CurrSem-1)])?'up':'down').'"></span></td>'.
													'<td>'.$DataSet['CGPA'.$CurrSem].'</td></tr>';
										}
									}
									else
									{
										$sql = "SELECT RegdNo,Name,CGPA".$CurrSem.",GPA".$CurrSem." FROM resultsfinalultimate WHERE RegdNo LIKE '$ClassID%' ORDER BY RegdNo ASC";
										$res = mysqli_query($db, $sql);
										
										while( $DataSet = mysqli_fetch_array($res, MYSQLI_ASSOC) )
										{
											$i++;
											$ClassID = floor(intval($DataSet['RegdNo'])/100)%10;
											
											echo '<tr><td> #'.$i.'</td>'.
													'<td>'.$DataSet['RegdNo'].'</td>'.
													'<td><img src="'.SITE_ROOT.'funcs.images.php?i='.$DataSet['RegdNo'].'" class="iconImg" /></td>'.
													'<td>'.$DataSet['Name'].'<span class="label sec'.$ClassID.'">'.str_replace(' ', '', SectionOf($DataSet['RegdNo'])).'</span></td>'.
													'<td>'.$DataSet['GPA'.$CurrSem].'</td>'.
													'<td>'.$DataSet['CGPA'.$CurrSem].'</td></tr>';
										}
									}										
								?>
							</tbody>
						</table>
					</div>
				</div>
			</section>
<?php include 'footer.php'; ?>