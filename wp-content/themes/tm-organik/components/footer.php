<footer <?php Insight::footer_attributes(); ?>>
    <div class="container">
        <div class="row">
            <div class="col-md-5 footer-c1">
				<?php if ( Insight::setting( 'footer_logo_enable' ) == 1 ) { ?>
                    <img src="<?php echo esc_url( Insight::setting( 'footer_logo_img' ) ); ?>"
                         alt="<?php bloginfo( 'name' ); ?>"/>
				<?php } ?>
				<?php
				if ( is_active_sidebar( 'footer_01' ) ) {
					dynamic_sidebar( 'footer_01' );
				}
				?>
				<?php if ( Insight::setting( 'footer_social_enable' ) == 1 ) {
					echo '<div class="footer-social">';
					Insight::social_icons();
					echo '</div>';
				} ?>
            </div>
            <div class="col-md-3 footer-c2">
				<?php
				if ( is_active_sidebar( 'footer_02' ) ) {
					dynamic_sidebar( 'footer_02' );
				}
				?>
            </div>

            <div class="col-md-4 footer-c4">
				<?php
				if ( is_active_sidebar( 'footer_04' ) ) {
					dynamic_sidebar( 'footer_04' );
				}
				?>
            </div>
        </div> <!-- /.row -->
    </div><!-- /.wrapper -->
</footer><!-- /.footer -->
