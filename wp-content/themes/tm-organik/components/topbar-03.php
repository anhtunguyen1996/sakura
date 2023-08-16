<?php if ( Insight::setting( 'topbar_visibility' ) == 1 ) { ?>
	<div class="topbar topbar-03">
		<div class="container topbar-container topbar-03">
			<div class="row row-xs-center">
				<div class="col-md-6">
					<div class="topbar_03__text">
						<?php echo wp_kses( Insight::setting( 'topbar_03_text' ), 'insight-default' ); ?>
					</div>
				</div>
				<div class="col-md-6">
					<div class="top-bar-right">
						<div class="topbar__menu">
							<?php
							wp_nav_menu( array(
								'theme_location' => 'top',
								'menu_class'     => 'topbar-menu',
								'container'      => false
							) );
							?>
						</div>

						<?php
						if(is_user_logged_in()) {
							$current_user = wp_get_current_user();
							$user_name    = $current_user->display_name;
							$user_link    = get_edit_user_link($current_user->ID);
							$avatar_url   = get_avatar_url($current_user->ID);
							?>
							<div class="account logged-in">
								<div class="user-show">
									<a class="avatar" href="<?php echo esc_url($user_link); ?>"><img src="<?php echo esc_url($avatar_url); ?>" title="<?php echo esc_attr($user_name); ?>" alt="<?php echo esc_attr($user_name); ?>" ></a>
								</div>
								​
								<div class="logout">
									<a href="<?php echo wp_logout_url(home_url()); ?>">
										<span><?php esc_html_e('Log out','tm-organik'); ?></span>
									</a>
								</div>
							</div>
						<?php } else { ?>
							<div class="account logged-out">
								<a href="<?php echo get_permalink( get_option('woocommerce_myaccount_page_id') ); ?>" title="<?php _e('Login / Register','tm-organik'); ?>">
									<?php esc_html_e('Login / Register','tm-organik'); ?>
								</a>
							</div>
						<?php } ?>

						<div class="topbar_03__phone">
							<i class="fas fa-phone"></i>
							<?php echo wp_kses( Insight::setting( 'topbar_03_phone' ), 'insight-default' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>