<div class="sidebar-menu-inner">
			
			<header class="logo-env">

				<!-- logo -->
				<div class="logo">
					<a href="index.html">
						<img src="<?=base_url();?>assets/images/logo@2x.png" width="120" alt="" />
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
				
				<li>
					<a href="<?=site_url("dashboards");?>">
						<i class="entypo-gauge"></i>
						<span class="title"><?=lang("system.dashboards");?></span>
					</a>
				</li>

				<li>
					<a href="<?=site_url("denominations");?>">
						<i class="entypo-trophy"></i>
						<span class="title"><?=lang("system.denominations");?></span>
					</a>
				</li>

				<li>
					<a href="<?=site_url("ministers");?>">
						<i class="entypo-book"></i>
						<span class="title"><?=lang("system.ministers");?></span>
					</a>
				</li>

				<li>
					<a href="<?=site_url("churches");?>">
						<i class="entypo-home"></i>
						<span class="title"><?=lang("system.churches");?></span>
					</a>
				</li>

				<li>
					<a href="<?=site_url("events");?>">
						<i class="entypo-layout"></i>
						<span class="title"><?=lang("system.events");?></span>
					</a>
				</li>

				<li>
					<a href="<?=site_url("users");?>">
						<i class="entypo-users"></i>
						<span class="title"><?=lang("system.users");?></span>
					</a>
				</li>

				<li>
					<a href="<?=site_url("settings");?>">
						<i class="entypo-cog"></i>
						<span class="title"><?=lang("system.settings");?></span>
					</a>
				</li>
			</ul>
			
		</div>