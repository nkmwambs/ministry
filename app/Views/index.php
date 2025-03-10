<!DOCTYPE html>
<html lang="en">
<head>
	<?php extract($page_data);?>
	<meta http-equiv="X-UA-Compatible" content="IE=edge">

	<meta charset="utf-8">
	<meta name="viewport" content="width=device-width, initial-scale=1" />
	<meta name="description" content="Church Management System" />
	<meta name="author" content="" />

	<link rel="icon" href="<?php echo base_url(); ?>assets/images/favicon.ico">

	<title><?=humanize($feature);?> | <?=humanize($action);?></title>
	

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jquery-ui/css/no-theme/jquery-ui-1.10.3.custom.min.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/font-icons/entypo/css/entypo.css">
	<link rel="stylesheet" href="//fonts.googleapis.com/css?family=Noto+Sans:400,700,400italic">
	<link href="https://fonts.googleapis.com/css?family=Raleway" rel="stylesheet">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/bootstrap.css">
	<!-- Select2 CSS -->
	<link href="<?php echo base_url(); ?>assets/js/select2/select2-bootstrap.css" rel="stylesheet" />
	<link href="<?php echo base_url(); ?>assets/js/select2/select2.css" rel="stylesheet" />

	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-core.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-theme.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/neon-forms.css">
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/custom.css">
	<link href="<?php echo base_url(); ?>assets/font-awesome/css/font-awesome.min.css" rel="stylesheet" />
	<!-- <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css"> -->
	<!-- <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.7/css/all.css"> -->
	<link rel="stylesheet" href="https://cdn.datatables.net/2.1.3/css/dataTables.dataTables.min.css"/>

	<script src="<?php echo base_url(); ?>assets/js/jquery-1.11.3.min.js"></script>
	
	<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/">

	<script src="https://cdn.jsdelivr.net/npm/pluralize@8.0.0/pluralize.min.js"></script>
	<!-- <script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-rc.0/dist/js/select2.min.js"></script> -->
	<!-- <script src='https://kit.fontawesome.com/a076d05399.js' crossorigin='anonymous'></script> -->

	<!--[if lt IE 9]><script src="assets/js/ie8-responsive-file-warning.js"></script><![endif]-->
	
	<!-- HTML5 shim and Respond.js for IE8 support of HTML5 elements and media queries -->
	<!--[if lt IE 9]>
		<script src="https://oss.maxcdn.com/html5shiv/3.7.2/html5shiv.min.js"></script>
		<script src="https://oss.maxcdn.com/respond/1.4.2/respond.min.js"></script>
	<![endif]-->

	<link href="https://gitcdn.github.io/bootstrap-toggle/2.2.2/css/bootstrap-toggle.min.css" rel="stylesheet">
	<script src="https://gitcdn.github.io/bootstrap-toggle/2.2.2/js/bootstrap-toggle.min.js"></script>

</head>
<body class="page-body  page-fade" data-url="http://neon.dev">

<script>
	const base_url = "<?=site_url(service('session')->has('user_type') ? service('session')->user_type : "church" );?>/"
</script>

<div class="page-container"><!-- add class "sidebar-collapsed" to close sidebar by default, "chat-visible" to make chat appear always -->
	
	<div class="sidebar-menu">
		<?=view("templates/navigation.php", $page_data);?>
	</div>

	<div class="main-content">
				
		<div class="row header">
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
		<div class="main">
        	<?php 
				// $content Has been replace with a view
				// All non-ajax responses MUST place the page_data in a compact method
				echo view($page_data['view'], $page_data);
			?>
		</div>
	
		<!-- Footer -->
		<footer class="footer">
			
			&copy; 2024 <strong>Church Management System</strong> by <a href="#" target="_blank">Techsys</a>
		
		</footer>
	</div>
</div>

    <?php 
        include APPPATH."Views/templates/modals.php";
    ?>

	<script src="https://cdn.datatables.net/2.1.3/js/dataTables.min.js"></script>


	<script src="<?php echo base_url(); ?>assets/js/jquery-ui/js/jquery-ui-1.10.3.minimal.min.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/bootstrap.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/neon-api.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/resizeable.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/joinable.js"></script>
	<script src="<?php echo base_url(); ?>assets/js/gsap/TweenMax.min.js"></script>
	
	<!-- Imported scripts on this page -->
	<script src="<?php echo base_url(); ?>assets/js/toastr.js"></script>
	<!-- <script src="<?php echo base_url(); ?>assets/js/neon-chat.js"></script> -->
	<script src="<?php echo base_url(); ?>assets/js/bootstrap-datepicker.js"></script>

	<!-- JavaScripts initializations and stuff -->
	<script src="<?php echo base_url(); ?>assets/js/neon-custom.js"></script>


	<!-- Demo Settings -->
	<script src="<?php echo base_url(); ?>assets/js/neon-demo.js"></script>

	<!-- Select2 JS -->
	<script src="<?php echo base_url(); ?>assets/js/select2/select2.min.js"></script>
	<!-- <script src="<?php echo base_url();?>assets/js/selectboxit/jquery.selectBoxIt.min.js"></script> -->

	<?php 
		include APPPATH."Views/templates/js_scripts.php";
	?>

</body>
</html>