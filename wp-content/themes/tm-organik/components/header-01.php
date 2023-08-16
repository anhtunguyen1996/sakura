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
                <div class="header-left">
					<?php if ( ( Insight::setting( 'header_call_text' ) != '' ) && ( Insight::setting( 'header_call_number' ) != '' ) ) { ?>
                        <div class="header-call">
                            <div class="text"><?php echo esc_html( Insight::setting( 'header_call_text' ) ); ?>
                                <span><?php echo esc_html( Insight::setting( 'header_call_number' ) ); ?></span></div>
                            <div class="icon"><i class="ion-ios-telephone-outline"></i></div>
                        </div>
					<?php } ?>
                </div>
                <div class="header-center col-md-12">
					<?php Insight::branding_logo(); ?>
                    <nav id="menu" class="menu menu--primary header-01">
						<?php Insight::menu_primary() ?>
                    </nav>
	                <div class="btn-wrap">
		                <div class="btn-wrap-inner">
			                <?php if ( Insight::setting( 'header_search_enable' ) ) { ?>
				                <div class="top-search-btn"></div>
			                <?php }
			                if ( Insight::setting( 'header_wishlist_enable' ) && class_exists( 'WooCommerce' ) && class_exists( 'WPcleverWoosw' ) ) {
				                echo '<div class="wishlist-wrap">' . Insight_Woo::header_wishlist() . '</div>';
			                } ?>
		                </div>
	                </div>
                </div>
	            <div class="header-right">
		            <div class="mini-cart-wrap">
			            <?php if ( Insight::setting( 'header_minicart_enable' ) ) { ?>
				            <?php echo Insight_Woo::header_cart(); ?>
				            <div class="widget_shopping_cart_content"></div>
			            <?php } ?>
		            </div>
	            </div>
            </div><!-- /.row -->
        </div>
    </header><!-- /.header -->
<?php } ?>
