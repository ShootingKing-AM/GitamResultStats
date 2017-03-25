<?php include_once 'conf.php'; ?>
<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="UTF-8">
		<title><?php echo $Page;?> ~ AwwStats</title>
		<meta http-equiv="content-type" content="text/html; charset=utf-8" />
		<meta name="description" content="Gitam Institute of Techonology results with AwwStats" />
		<meta name="keywords" content="gitam,git,reults,stats,statistics,graphs,charts" />
		<meta name="author" content="Harsha Raghu">
		
		<link rel="icon" type="image/png" sizes="32x32" href="<?php echo SITE_ROOT;?>images/fav/favicon-32x32.png">
		<link rel="icon" type="image/png" sizes="96x96" href="<?php echo SITE_ROOT;?>images/fav/favicon-96x96.png">
		<link rel="icon" type="image/png" sizes="16x16" href="<?php echo SITE_ROOT;?>images/fav/favicon-16x16.png">
		
		<meta property="og:url" content="http://gitstats.otakud.in" />
		<meta property="og:type" content="article" />
		<meta property="og:title" content="GIT Stats." />
		<meta property="og:image" content="http://gitstats.otakud.in/images/banner.jpg" />
		<meta property="og:image:width" content="502" />
		<meta property="og:image:height" content="264" />
		<meta property="og:description" content="Gitam Institute of Techonology results with AwwStats" />
		<meta property="og:site_name" content="gitstats.otakud.in" />
		
		<link rel="stylesheet/less" type="text/css" href="<?php echo SITE_ROOT;?>css/circlestuff.less" />
		<!--[if lte IE 8]><script src="css/ie/html5shiv.js"></script><![endif]-->
		<link href='https://fonts.googleapis.com/css?family=Raleway:400,600,300' rel='stylesheet' type='text/css'>
		<script src="<?php echo SITE_ROOT;?>js/jquery.min.js"></script>
		<script src="<?php echo SITE_ROOT;?>js/skel.min.js"></script>
		<script src="<?php echo SITE_ROOT;?>js/skel-layers.min.js"></script>
		<script src="<?php echo SITE_ROOT;?>js/init.js"></script>
		<script src="<?php echo SITE_ROOT;?>js/Chart.js"></script>
		<script src="<?php echo SITE_ROOT;?>js/jquery.waypoints.min.js"></script>
		<script src="<?php echo SITE_ROOT;?>js/less.min.js" type="text/javascript"></script>
		
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/1.10.11/css/jquery.dataTables.css">
		<link rel="stylesheet" type="text/css" href="//cdn.datatables.net/buttons/1.2.4/css/buttons.dataTables.min.css">
		
  		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/1.10.11/js/jquery.dataTables.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/pdfmake.min.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.rawgit.com/bpampuch/pdfmake/0.1.18/build/vfs_fonts.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.html5.min.js"></script>
		<script type="text/javascript" charset="utf8" src="//cdn.datatables.net/buttons/1.2.4/js/buttons.print.min.js"></script>

		<noscript>
			<link rel="stylesheet" href="<?php echo SITE_ROOT;?>css/skel.css" />
			<link rel="stylesheet" href="<?php echo SITE_ROOT;?>css/style.css" />
			<link rel="stylesheet" href="<?php echo SITE_ROOT;?>css/style-xlarge.css" />
		</noscript>
		<!--[if lte IE 8]><link rel="stylesheet" href="css/ie/v8.css" /><![endif]-->
	</head>
	<?php if( $Page == 'GIT Stats' ) echo '<body class="landing">'; else echo '<body>'; ?>
<style>
	@media (min-width: 980px) 
	{
		#SearchRes
		{
			z-index: 100;
			position: fixed;
			
			top:0px;
			left:50%;
			width:40%;
			background: #444;
			background-image: linear-gradient(#444 80%,rgba(255,255,255,0.1));
			color: white;
			transition: .5s all;
			overflow:hidden;
			padding: 20px;
			border: 2px solid;
			border-radius: 7px;
			opacity:0;
		}
	}
	@media (max-width: 979px) 
	{
		#SearchRes
		{
			z-index: 100;
			position: fixed;
			
			top:0px;
			left:10%;
			width:89%;
			background: #444;
			background-image: linear-gradient(#444 80%,rgba(255,255,255,0.1));
			color: white;
			transition: .5s all;
			overflow:hidden;
			padding: 5px;
			padding-top: 15px;
			border: 1px solid;
			border-radius: 3px;
			opacity:0;
		}
	}
	
	#SearchRes > ul
	{
		list-style-type: none;
	}
	#SearchRes::-webkit-scrollbar 
	{
		width: 1em;
	}
	 
	#SearchRes::-webkit-scrollbar-track 
	{
		-webkit-box-shadow: inset 0 0 6px rgba(0,0,0,0.3);
	}
	 
	#SearchRes::-webkit-scrollbar-thumb 
	{
		background-color: darkgrey;
		outline: 1px solid slategrey;
	}
</style>
<script>
	$(function() {
		
		$('#Search').keyup(function(){
			if( $(this).val().trim() != '' )
			{
				$.post( "search.php", { arg: $(this).val() })
					.done(function( data ) {
						if( data.trim() != '' )
						{
							$('#SearchRes').html(data.trim());
							
							var top_of_element = $('#SearchRes').offset().top;
							var bottom_of_element = $('#SearchRes').offset().top + $('#SearchRes').outerHeight();
							var bottom_of_screen = $('#SearchRes').scrollTop() + $(window).height();
							// console.log( 'Top of element : ' + top_of_element + ' Bottomof Elem : ' + bottom_of_element + ' BottOFScreen: ' + bottom_of_screen );
							if((bottom_of_screen > top_of_element) && (bottom_of_screen > bottom_of_element))
							{
								// The element is visible, do something
								console.log( "Inview" );
								$('#SearchRes').css('overflow-y', 'auto');
								$('#SearchRes').css('height', 'auto');
							}
							else 
							{
								// The element is not visible, do something else
								// console.log( "Outview" + " Elem Height : " + $('#SearchRes').outerHeight() );
								$('#SearchRes').outerHeight(bottom_of_screen-top_of_element);////bottom_of_element-bottom_of_screen+$('#SearchRes').height());
								// console.log( "eOutview" + " Elem Height : " + $('#SearchRes').outerHeight() );
								$('#SearchRes').css('overflow-y', 'scroll');
							}
						}
						else
						{
							$('#SearchRes').text("No Matches.");
						}
						animateShow();
				});
			}
			else
			{
				animateHide();
			}				
		});
		
		var focusOn = false;
		var focusOutSearch = false;
		$( "#SearchRes" ).hover(
		  function() {
			focusOn = true;
		  }, function() {
			focusOn = false;
			if( focusOutSearch == true )
				animateHide();
		  }
		);
		
		$('#Search').focusin(function(){
			focusOutSearch = false;
		});
		
		$('#Search').focusout(function(){
			focusOutSearch = true;
			if( focusOn == false )
				animateHide();
		});
				
		function animateShow()
		{
			$("#SearchRes").css('top',$('#Search').parent().parent().parent().height()*1.2 + 'px');
			if( $(window).width() <= 980 )
			{
				$("#SearchRes").css('left','10%');
			}
			else
			{
				$("#SearchRes").css('left','50%');
			}
				
			//$("#SearchRes").css('height','auto');
			$("#SearchRes").css('opacity','1');
		}
		
		function animateHide()
		{
			$("#SearchRes").css('top','0px');
			$("#SearchRes").css('height','0px');
			$("#SearchRes").css('opacity','0');
		}		
	});
</script>
		<!-- Header -->
			<header id="header" style="z-index:1000;position:fixed;">
				<h1><a id="sitename" href="<?php echo SITE_ROOT;?>index.php">GIT Stats</a></h1>
				<nav id="nav">
					<ul>
						<li><a href="<?php echo SITE_ROOT;?>index.php" style="color: #cee8d8;text-decoration: none;">Home</a></li>
						<li><a href="<?php echo SITE_ROOT;?>branch.php" style="color: #cee8d8;text-decoration: none;">Branches</a></li>
						<li><input type="text" name="Search" placeholder="RegdNo, Name, Classid etc..." id="Search"/></a></li>
						<li><div id="SearchRes"></div></li>
					</ul>
				</nav>
			</header>