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
                <div class="col-md-3 header-left">
					<?php Insight::branding_logo(); ?>
                </div>
                <div class="col-md-9 header-right">
                    <nav id="menu" class="menu menu--primary header-02">
						<?php Insight::menu_primary() ?>
                    </nav>
                    <div class="btn-wrap">
                        <div class="btn-wrap-inner">
							<?php if ( Insight::setting( 'header_search_enable' ) ) { ?>
                                <div class="top-search-btn-wrap">
                                    <div class="top-search-btn"></div>
                                </div>
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
                        </div>
                    </div>
                </div>
            </div><!-- /.row -->
        </div>
    </header><!-- /.header -->
<?php } ?>
