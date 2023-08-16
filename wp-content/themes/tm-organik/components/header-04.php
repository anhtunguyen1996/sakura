<?php if ( Insight::setting( 'header_visibility' ) ) { ?>
	<header <?php Insight::header_attributes(); ?>>
		<?php get_template_part( 'components/' . Insight::setting( 'topbar_type' ) ); ?>
		<div class="top-search">
			<div class="container">
				<div class="row row-xs-center">
					<div class="col-md-12">
						<?php get_search_form(); ?>
					</div>
				</div>
			</div>
		</div>
		<div class="container header-container">
			<div class="row row-xs-center">
				<div class="col-md-2 header-left">
					<?php Insight::branding_logo(); ?>
				</div>

				<div class="col-md-7 header-center">
					<nav id="menu" class="menu menu--primary header-02">
						<?php Insight::menu_primary() ?>
					</nav>
				</div>

				<div class="col-md-3 header-right">

					<div class="btn-wrap">
						<div class="btn-wrap-inner">
							<?php if ( Insight::setting( 'header_search_enable' ) ) { ?>
								<?php get_search_form(); ?>
								<div class="top-search-btn"></div>
							<?php } ?>
							<?php if ( Insight::setting( 'header_wishlist_enable' ) && class_exists( 'WooCommerce' ) && class_exists( 'WPcleverWoosw' ) ) {
								echo '<div class="wishlist-wrap">' . Insight_Woo::header_wishlist() . '</div>';
							} ?>
							<?php if ( Insight::setting( 'header_minicart_enable' ) ) { ?>
								<div class="mini-cart-wrap">
									<?php echo Insight_Woo::header_cart(); ?>
									<div class="widget_shopping_cart_content"></div>
								</div>
							<?php } ?>
							<?php if ( Insight::setting( 'header_account_enable' ) ) { ?>
								<div class="account-wrap">
									<?php
									if ( is_user_logged_in() ) {
										?>
										<div class="account logged-in">
											<div class="logout">
												<a class="hint--top hint--bounce hint--success"
												   aria-label="<?php echo esc_html( 'Logout', 'tm-organik' ); ?>"
												   href="<?php echo wp_logout_url( home_url() ); ?>">
													<i class="fal fa-user"></i>
												</a>
											</div>
										</div>
									<?php } else { ?>
										<div class="account logged-out">
											<a class="hint--top hint--bounce hint--success"
											   aria-label="<?php echo esc_html( 'Login', 'tm-organik' ); ?>"
											   href="<?php echo get_permalink( get_option( 'woocommerce_myaccount_page_id' ) ); ?>"
											   title="<?php _e( 'Login / Register', 'tm-organik' ); ?>">
												<i class="fal fa-user"></i>
											</a>
										</div>
									<?php } ?>
								</div>
							<?php } ?>
						</div>
					</div>
				</div>
			</div><!-- /.row -->
		</div>
	</header><!-- /.header -->
<?php } ?>
