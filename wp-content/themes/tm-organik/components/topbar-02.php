<?php if ( Insight::setting( 'topbar_visibility' ) == 1 ) { ?>
	<div class="topbar topbar-02">
		<div class="container topbar-container topbar-02">
			<div class="row row-xs-center">
				<div class="col-md-6">
					<div class="topbar_02__text">
						<?php echo wp_kses( Insight::setting( 'topbar_02_text' ), 'insight-default' ); ?>
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

						<div class="topbar_02__phone">
							<i class="fas fa-phone"></i>
							<?php echo wp_kses( Insight::setting( 'topbar_02_phone' ), 'insight-default' ); ?>
						</div>
					</div>
				</div>
			</div>
		</div>
	</div>
<?php } ?>