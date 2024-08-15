<!DOCTYPE html>
<html lang="en">
<head>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Church Management System" />
	<meta name="author" content="" />

	<link rel="icon" href="assets/images/favicon.ico">

	<title><?=humanize($feature);?> | <?=humanize($action);?></title>

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-core.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-forms.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
	<link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css"/>

	<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
	
	<script src="https://cdn.jsdelivr.net/npm/pluralize@8.0.0/pluralize.min.js"></script>
	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->


</head>
<body class="page-body  page-fade" data-url="http://neon.dev">

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<div class="sidebar-menu">
		<?=view("templates/navigation.php");?>
	</div>

	<div class="main-content">
				
		<div class="row">
			<!-- Profile Info and Notifications -->
			<div class="col-md-6 col-sm-8 clearfix">
				<?php 
					echo view("templates/user_area.php");
					echo view("templates/user_notification.php");
				?>
			</div>
		
			<!-- Raw Links -->
			<div class="col-md-6 col-sm-4 clearfix hidden-xs">
				<?=view("templates/language_selector.php");?>
			</div>
		
		</div>
		
		<hr />
		
        <?=$content;?>
	
		<!-- Footer -->
		<footer class="main">
			
			&copy; 2024 <strong>Church Management System</strong> Admin Theme by <a href="http://laborator.co" target="_blank">Laborator</a>
		
		</footer>
	</div>
</div>

    <?php 
        include APPPATH."Views/templates/modals.php";
    ?>

	<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>

	<!-- Imported styles on this page -->
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/rickshaw/rickshaw.min.css">

	<!-- Bottom scripts (common) -->
	<script src="<?php echo base_url(); ?>assets/js/gsap/TweenMax.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/joinable.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/resizeable.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/neon-api.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>


	<!-- Imported scripts on this page -->
	<script src="<?php echo base_url(); ?>assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/jquery.sparkline.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/rickshaw/vendor/d3.v3.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/rickshaw/rickshaw.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/raphael-min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/morris.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/toastr.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/neon-chat.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>

	<!-- JavaScripts initializations and stuff -->
	<script src="<?php echo base_url(); ?>assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="<?php echo base_url(); ?>assets/js/neon-demo.js"></script>

	<?php 
		include APPPATH."Views/templates/js_scripts.php";
	?>

</body>
</html>