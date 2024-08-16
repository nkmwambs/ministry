<div class="row">
	<div class="col-sm-3 col-xs-6">
		<?php include "components/registered_users.php"; ?>
	</div>

	<div class="col-sm-3 col-xs-6">
		<?php include "components/visitors.php"; ?>
	</div>

	<div class="clear visible-xs"></div>

	<div class="col-sm-3 col-xs-6">
		<?php include "components/messages.php"; ?>
	</div>

	<div class="col-sm-3 col-xs-6">
		<?php include "components/subscribers.php" ?>
	</div>
</div>

<br />

<div class="row">
	<div class="col-sm-8">
		<?php include "components/site_stats.php"; ?>
	</div>
	<div class="col-sm-4">
		<!-- <?php include "components/real_time_stats.php" ?> -->
	</div>
</div>


<br />

<div class="row">
	<div class="col-sm-4">
		<?php include "components/monthly_sales.php" ?>
	</div>
	<div class="col-sm-8">
		<?php include "components/profile_status.php"; ?>
	</div>
</div>

<br />

<div class="row">
	<div class="col-sm-3">
		<?php include "components/tasks.php"; ?>
	</div>
	<div class="col-sm-9">
		<div class="tile-group">
			<div class="tile-left">
				<?php include "components/map1.php"; ?>
			</div>
			<div class="tile-right">
				<?php include "components/map2.php" ?>
			</div>
		</div>
	</div>
</div>


<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/jvectormap/jquery-jvectormap-1.2.2.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>assets/js/rickshaw/rickshaw.min.css">




<script src="<?php echo base_url(); ?>assets/js/jvectormap/jquery-jvectormap-1.2.2.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jvectormap/jquery-jvectormap-europe-merc-en.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.sparkline.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/rickshaw/vendor/d3.v3.js"></script>
<script src="<?php echo base_url(); ?>assets/js/rickshaw/rickshaw.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/raphael-min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/morris.min.js"></script>