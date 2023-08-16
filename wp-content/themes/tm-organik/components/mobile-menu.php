<div id="slideout-menu" class="slideout-menu hidden-md-up">
	<?php
	$mobileNav = array(
		'menu'            => Insight_Helper::get_post_meta( 'menu_display' ),
		'theme_location'  => 'primary',
		'menu_id'         => 'mobile-menu',
		'container_class' => 'mobile-menu',
		'after'           => '<i class="sub-menu-toggle fas fa-angle-down"></i>',
		'fallback_cb'     => function() {
			echo esc_html__( 'Please choose a menu', 'tm-organik' );
		}
	);
	if ( class_exists( 'InsightCore_WalkerNavMenu' ) && has_nav_menu( 'primary' ) ) {
		$mobileNav['walker'] = new InsightCore_WalkerNavMenu;
	}
	if ( has_nav_menu( 'mobile' ) ) {
		$mobileNav['theme_location'] = 'mobile';
	}
	wp_nav_menu( $mobileNav );
	?>
</div>
