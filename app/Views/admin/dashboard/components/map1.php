<script type="text/javascript">
	jQuery(document).ready(function ($) {

		// JVector Maps
		var map = $("#map");

		map.vectorMap({
			map: 'europe_merc_en',
			zoomMin: '3',
			backgroundColor: '#383f47',
			focusOn: { x: 0.5, y: 0.8, scale: 3 }
		});


	});
</script>



	<div class="tile-entry">
		<h3>Map</h3>
		<span>top visitors location</span>
	</div>

	<div class="tile-entry">
		<img src="<?= base_url(); ?>assets/images/sample-al.png" alt="" class="pull-right op" />

		<h4>Albania</h4>
		<span>25%</span>
	</div>

	<div class="tile-entry">
		<img src="<?= base_url(); ?>assets/images/sample-it.png" alt="" class="pull-right op" />

		<h4>Italy</h4>
		<span>18%</span>
	</div>

	<div class="tile-entry">
		<img src="<?= base_url(); ?>assets/images/sample-au.png" alt="" class="pull-right op" />

		<h4>Austria</h4>
		<span>15%</span>
	</div>
