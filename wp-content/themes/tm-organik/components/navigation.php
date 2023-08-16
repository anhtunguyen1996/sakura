<?php if ( Insight::setting( 'navigation_visibility' ) == 1 ) { ?>
    <div <?php Insight::navigation_attributes(); ?>>
        <div class="wrapper">
            <div class="row row-xs-center">
				<?php if ( Insight::setting( 'header_sticky_enable' ) == 1 ) { ?>
                    <div class="navigation__logo">
                        <a href="<?php echo esc_url( home_url( '/' ) ); ?>" rel="home"><?php bloginfo( 'name' ); ?></a>
                    </div><!-- /.navigation__logo -->
				<?php } ?>
                <nav id="menu" class="menu menu--primary">
					<?php Insight::menu_primary() ?>
                </nav><!-- /.menu -->
                <div class="header__extra">
                    <div class="toggle">
                        <a href="#mobile"><i class="fas fa-bars"></i></a>
                    </div>
                </div><!-- /.header__extra -->
            </div><!-- /.row -->
        </div>
    </div><!-- /.navigation -->
<?php } ?>
