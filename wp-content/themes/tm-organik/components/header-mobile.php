<header class="header header-mobile">
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
            <div class="col-xs-4 header-left">
                <div id="open-left" class=""><i class="ion-navicon"></i></div>
            </div>
            <div class="col-xs-4 header-center">
				<?php Insight::branding_logo( true ); ?>
            </div>
            <div class="col-xs-4 header-right">
                <div class="btn-wrap">
                    <div class="btn-wrap-inner">
						<?php if ( Insight::setting( 'header_search_enable' ) == 1 ) { ?>
                            <div class="top-search-btn-wrap">
                                <div class="top-search-btn"></div>
                            </div>
						<?php } ?>
						<?php if ( Insight::setting( 'header_wishlist_enable' ) && class_exists( 'WooCommerce' ) && class_exists( 'WPcleverWoosw' ) ) {
							echo '<div class="wishlist-wrap">' . Insight_Woo::header_wishlist() . '</div>';
						} ?>
						<?php if ( Insight::setting( 'header_minicart_enable' ) == 1 ) { ?>
                            <div class="mini-cart-wrap">
								<?php echo Insight_Woo::header_cart(); ?>
                                <div class="widget_shopping_cart_content"></div>
                            </div>
						<?php } ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
