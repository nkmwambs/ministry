<div class="sidebar-menu-inner">
	<header class="logo-env">
		<!-- logo -->
		<div class="logo">
			<a href="index.html">
				<img src="<?= base_url(); ?>assets/images/logo.png" width="120" alt="" />
			</a>
		</div>
		<!-- logo collapse icon -->
		<div class="sidebar-collapse">
			<a href="#" class="sidebar-collapse-icon"><!-- add class "with-animation" if you want sidebar to have animation during expanding/collapsing transition -->
				<i class="entypo-menu"></i>
			</a>
		</div>
		<!-- open/close menu icon (do not remove if you want to enable menu on mobile devices) -->
		<div class="sidebar-mobile-menu visible-xs">
			<a href="#" class="with-animation"><!-- add class "with-animation" to support animation -->
				<i class="entypo-menu"></i>
			</a>
		</div>
	</header>

	<ul id="main-menu" class="main-menu">
		<?php
		foreach ($navigation_items[service('session')->user_type] as $navigation_name => $navigation_item) {
			if ($navigation_name != 'dashboards' && !auth()->user()->canDo(singular($navigation_name) . ".read")) {
				continue;
			}
			$hasSub = array_key_exists('children', $navigation_item);
			$parentUri = array_key_exists('uri', $navigation_item) && $navigation_item['uri'] != "" ? $navigation_item['uri'] : '';
		?>
			<li class="<?= $hasSub ? 'has-sub' : '' ?>">
				<a href="<?= site_url($navigation_item['uri'] != "" ? $navigation_item['uri'] : service('session')->user_type . '/' . $navigation_name . '/' . $parentUri . '/list'); ?>">
					<i class="<?= $navigation_item['iconClass'] ?>"></i>
					<?php
					$label = $navigation_item['label'];
					?>
					<span class="title"><?= lang("system.$label"); ?></span>
				</a>
				<?php if ($hasSub) { ?>
					<ul>
						<?php
						foreach ($navigation_item['children'] as $child_name => $child_item) {
							$childUri = array_key_exists('uri', $child_item) && $child_item['uri'] != "" ? $child_item['uri'] : '';
						?>
							<li>
								<a href="<?= site_url(service('session')->user_type . '/' . $navigation_name . '/' . $childUri . '/' . $child_name); ?>">
									<span class="title"><?= $child_item['label']; ?></span>
								</a>
							</li>
						<?php } ?>
					</ul>
				<?php } ?>
			</li>
		<?php } ?>

	</ul>

</div>