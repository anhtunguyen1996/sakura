<?php
$section  = 'site';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'site_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Layout', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'site_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="desc">' . esc_html__( 'Easily adjust your site\'s layout.', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'     => 'radio-image',
	'settings' => 'page_layout',
	'label'    => esc_html__( 'Page', 'tm-organik' ),
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => 'fullwidth',
	'choices'  => Insight_Helper::get_list_page_layout(),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'radio-image',
	'settings' => 'post_layout',
	'label'    => esc_html__( 'Post', 'tm-organik' ),
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => 'content-sidebar',
	'choices'  => Insight_Helper::get_list_page_layout(),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'radio-image',
	'settings' => 'archive_layout',
	'label'    => esc_html__( 'Archive', 'tm-organik' ),
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => 'content-sidebar',
	'choices'  => Insight_Helper::get_list_page_layout(),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'radio-image',
	'settings' => 'search_layout',
	'label'    => esc_html__( 'Search', 'tm-organik' ),
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => 'content-sidebar',
	'choices'  => Insight_Helper::get_list_page_layout(),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'hide_sidebar_mobile',
	'label'       => esc_html__( 'Hide Sidebar on Mobile', 'tm-organik' ),
	'description' => esc_html__( 'Enable this option to hide the sidebar on mobile screen.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 0,
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'site_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Main Color', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'primary_color',
	'label'     => esc_html__( 'Primary color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => Insight::PRIMARY_COLOR,
	'output'    => array(
		array(
			'element'  => implode( ',', array(
				'body a:hover',
				'.insight-product-grid a:hover, a:focus, a:active',
				'.breadcrumbs ul li:last-child',
				'.insight-title .page-title-style',
				'.separator--icon i',
				'.icon-boxes--icon',
				'.insight-product-column .product-item .product-info .product-price',
				'.mini-cart-wrap .widget_shopping_cart_content .total .amount',
				'.mini-cart-wrap .widget_shopping_cart_content .buttons a.checkout',
				'.mini-cart-wrap .widget_shopping_cart_content .cart_list li .quantity',
				'.insight-about2 .link',
				'#menu .menu__container > li.current-menu-item > a',
				'#menu .menu__container > li.current-menu-parent > a',
				'body.landing .demo-coming a:after',
				'#menu a:hover',
				'#menu .menu__container .sub-menu li a:hover',
				'#menu .menu__container .sub-menu li.menu-item-has-children:hover:after',
				'.insight-process--step--icon',
				'.insight-product-carousel .insight-title',
				'.insight-filter ul li a.active, .insight-grid-filter ul li a.active, .insight-gallery-filter ul li a.active',
				'.insight-featured-product .title-2',
				'body.woocommerce .products .product .product-info .price .amount, .insight-woo .products .product .product-info .price .amount, body.woocommerce-page .products .product .product-info .price .amount',
				'.blog-list-style .entry-more a:hover',
				'.widget_products a:hover',
				'.widget_product_categories a:hover',
				'body.woocommerce .sidebar .widget.widget_product_categories .product-categories li:hover > span, .insight-woo .sidebar .widget.widget_product_categories .product-categories li:hover > span',
				'.copyright .backtotop:before, .copyright .backtotop:after',
				'.insight-icon',
				'.insight-filter a:hover',
				'.insight-btn.brown:hover, .insight-featured-product.style-07 .insight-btn.btn:hover',
				'.blog-grid .blog-grid-style .entry-more a:hover, .insight-blog.grid .blog-grid-style .entry-more a:hover, .insight-blog.grid_has_padding .blog-grid-style .entry-more a:hover',
				'.insight-accordion .item .title .icon i',
				'.insight-product-column .product-item .product-price',
				'.insight-featured-product.style-02 .title-1, .insight-featured-product.style-03 .title-1',
				'blog.grid .blog-grid-style .entry-more a:hover',
				'.insight-about--carousel a span',
				'.insight-blog.grid_has_padding .blog-grid-style .entry-more a:hover',
				'.insight-about3 .row-bottom .about3-quote span',
				'.insight-about3 .row-bottom .about3-quote span',
				'.insight-about3 .about3-title h1, .insight-about3 .about3-title .sub-title',
				'.insight-our-services .icon',
				'.insight-countdown-product .item .product-price',
				'.insight-our-services .more',
				'.insight-gallery .insight-gallery-image .desc-wrap .icon',
				'.insight-gallery-filter a:hover',
				'.widget-area .widget.widget_tag_cloud a:hover',
				'.blog-classic-style .entry-share i',
				'.blog-grid .blog-grid-style .entry-more a:hover',
				'.single .content .content-area .entry-footer .share i, .page .content .content-area .entry-footer .share i',
				'.single .content .entry-nav .left:hover i, .single .content .entry-nav .right:hover i, .page .content .entry-nav .left:hover i, .page .content .entry-nav .right:hover i',
				'.widget-area .widget.widget_categories_widget .item:hover span',
				'.single .content .content-area .entry-content blockquote, .page .content .content-area .entry-content blockquote',
				'.single .content .content-area .entry-footer .tags a:hover, .page .content .content-area .entry-footer .tags a:hover',
				'body.woocommerce.single-product .product .summary a.compare:hover',
				'.woocommerce div.product p.price, .woocommerce div.product span.price',
				'body.woocommerce.single-product .product .summary .price ins .amount',
				'body.woocommerce-account .woocommerce-MyAccount-navigation ul li a:hover',
				'body.woocommerce a.remove:hover, body.woocommerce-page a.remove:hover',
				'body.woocommerce-page.woocommerce-cart table.shop_table td.product-subtotal',
				'body.woocommerce-page.woocommerce-cart table.shop_table input[type="submit"]',
				'.wishlist_table tr td.product-stock-status span.wishlist-in-stock',
				'body.woocommerce a.remove:hover, body.woocommerce-page a.remove:hover',
				'body.woocommerce .woocommerce-message:before, body.woocommerce-page .woocommerce-message:before',
				'body.woocommerce .products.list .product .product-info .product-action-list .quick-view-btn a, .insight-woo .products.list .product .product-info .product-action-list .quick-view-btn a, body.woocommerce-page .products.list .product .product-info .product-action-list .quick-view-btn a',
				'body.woocommerce .sidebar .widget.widget_product_categories .product-categories li.current-cat a, .insight-woo .sidebar .widget.widget_product_categories .product-categories li.current-cat a',
				'body.woocommerce.single-product .up-sells h2 span, body.woocommerce.single-product .viewed h2 span, body.woocommerce.single-product .related h2 span',
				'body.woocommerce .sidebar .widget.widget_product_tag_cloud a:hover, .insight-woo .sidebar .widget.widget_product_tag_cloud a:hover',
				'body.woocommerce.single-product .product .summary .price > .amount',
				'body.woocommerce .sidebar .widget.widget_products li .amount, body.woocommerce .sidebar .widget.widget_recent_reviews li .amount, body.woocommerce .sidebar .widget.widget_top_rated_products li .amount, body.woocommerce .sidebar .widget.widget_recently_viewed_products li .amount, .insight-woo .sidebar .widget.widget_products li .amount, .insight-woo .sidebar .widget.widget_recent_reviews li .amount, .insight-woo .sidebar .widget.widget_top_rated_products li .amount, .insight-woo .sidebar .widget.widget_recently_viewed_products li .amount',
				'.insight-testimonials.style7 .item .text',
				'.insight-separator .separator .separator--icon i',
				'.insight-title--title',
				'.woocommerce.single-product .product .summary a.compare:hover, .woocommerce.single-product .product .summary .wooscp-btn:hover',
				'.single .content .comments-area .comment-list li article .comment-metadata:before, .page .content .comments-area .comment-list li article .comment-metadata:before',
				'.single .content .comments-area .comment-list li article .reply a:hover, .page .content .comments-area .comment-list li article .reply a:hover',
				'.insight-icon-boxes--icon',
			) ),
			'property' => 'color',
		),
		array(
			'element'  => implode( ',', array(
				'.insight-icon-boxes.icon_on_left:hover .insight-icon-boxes--icon i, .insight-icon-boxes.icon_on_right:hover .insight-icon-boxes--icon i',
				'header.header-01 .header-right .mini-cart .mini-cart-icon:after',
				'.mini-cart-wrap .mini-cart .mini-cart-icon:after',
				'.insight-team-member .name:after',
				'.mini-cart-wrap .widget_shopping_cart_content .buttons a',
				'.insight-process--step--icon:hover',
				'.insight-process--step--icon:hover .order',
				'.top-search',
				'body.landing .demo-hover a:after',
				'.insight-process--small-icon',
				'body.woocommerce .products .product .product-thumb .product-action, .insight-woo .products .product .product-thumb .product-action, body.woocommerce-page .products .product .product-thumb .product-action',
				'.blog-list-style .entry-title:before',
				'.footer .mc4wp-form input[type="submit"]',
				'.hint--success:after',
				'.icon-boxes.icon_on_left:hover .icon-boxes--icon i, .icon-boxes.icon_on_right:hover .icon-boxes--icon i',
				'.insight-countdown-product .item .product-countdown .product-countdown-timer > div',
				'header.header-03 .header-container .header-right .btn-wrap .top-call-btn',
				'.insight-product-column .product-item .product-info .product-categories a:hover',
				'#menu .mega-menu .wpb_text_column ul li.sale a:after',
				'.insight-accordion .item.active .title, .insight-accordion .item:hover .title',
				'.insight-product-column .product-item .product-categories a:hover',
				'.insight-testimonials .slick-dots li.slick-active button',
				'.insight-pagination a.current, .insight-pagination a:hover, .insight-pagination span.current, .insight-pagination span:hover',
				'button, input[type="button"], input[type="reset"], input[type="submit"]',
				'body.woocommerce-page.woocommerce-cart table.shop_table input[type="submit"]:hover',
				'body.woocommerce-page.woocommerce-cart a.wc-backward, body.woocommerce-page.woocommerce-cart a.checkout-button',
				'body.woocommerce-page.woocommerce-checkout form.checkout_coupon .button',
				'body.woocommerce-page.woocommerce-checkout #payment input[type="submit"]',
				'body.woocommerce-wishlist table.shop_table .add_to_cart, body.woocommerce-wishlist table.wishlist_table .add_to_cart',
				'#menu .mega-menu .wpb_text_column ul li.new a:after',
				'body.woocommerce.single-product .product .summary form.cart button',
				'.single .content .comments-area .comment-form input[type="submit"], .page .content .comments-area .comment-form input[type="submit"]',
				'.mini-cart-wrap .widget_shopping_cart_content .buttons a:hover',
				'body.woocommerce.single-product .woocommerce-tabs .woocommerce-Tabs-panel input[type="submit"]',
				'body.woocommerce .sidebar .widget.widget_price_filter .price_slider_amount button:hover, .insight-woo .sidebar .widget.widget_price_filter .price_slider_amount button:hover',
				'body.woocommerce .sidebar .widget.widget_price_filter .ui-slider .ui-slider-range, .insight-woo .sidebar .widget.widget_price_filter .ui-slider .ui-slider-range',
				'body.woocommerce .sidebar .widget.widget_price_filter .ui-slider .ui-slider-handle, .insight-woo .sidebar .widget.widget_price_filter .ui-slider .ui-slider-handle',
				'body.woocommerce .products.list .product .product-info .product-action-list .product_type_simple, .insight-woo .products.list .product .product-info .product-action-list .product_type_simple, body.woocommerce-page .products.list .product .product-info .product-action-list .product_type_simple',
				'body.woocommerce .shop-filter .switch-view .switcher:hover, body.woocommerce .shop-filter .switch-view .switcher.active, .insight-woo .shop-filter .switch-view .switcher:hover, .insight-woo .shop-filter .switch-view .switcher.active',
				'body.woocommerce .woocommerce-pagination .page-numbers li span.current, body.woocommerce .woocommerce-pagination .page-numbers li span:hover, body.woocommerce .woocommerce-pagination .page-numbers li a.current, body.woocommerce .woocommerce-pagination .page-numbers li a:hover, .insight-woo .woocommerce-pagination .page-numbers li span.current, .insight-woo .woocommerce-pagination .page-numbers li span:hover, .insight-woo .woocommerce-pagination .page-numbers li a.current, .insight-woo .woocommerce-pagination .page-numbers li a:hover',
			) ),
			'property' => 'background-color',
		),
		array(
			'element'  => implode( ',', array(
				'a.cookie_notice_ok',
				'.mini-cart-wrap .widget_shopping_cart_content .buttons a',
				'.woocommerce.single-product .product .woocommerce-product-gallery ol .slick-slide img:hover',
				'.mini-cart-wrap .widget_shopping_cart_content .buttons a.checkout',
				'body.woocommerce .products .product:hover .product-thumb, .insight-woo .products .product:hover .product-thumb, body.woocommerce-page .products .product:hover .product-thumb',
				'.insight-about--carousel a:before',
				'.insight-pagination a.current, .insight-pagination a:hover, .insight-pagination span.current, .insight-pagination span:hover',
				'.insight-gallery .insight-gallery-image .desc-wrap',
				'button, input[type="button"], input[type="reset"], input[type="submit"]',
				'.widget-area .widget.widget_search .search-form input[type="search"]:focus',
				'.widget-area .widget.widget_tag_cloud a:hover',
				'.insight-product-column .product-item .product-thumb:before',
				'.insight-product-column .product-item .product-thumb:after',
				'.blog-list-style .post-thumbnail:before, .blog-list-style .post-thumbnail:after',
				'body.woocommerce-page.woocommerce-cart table.shop_table input[type="submit"]',
				'.woocommerce form .form-row.woocommerce-validated .select2-container, .woocommerce form .form-row.woocommerce-validated input.input-text, .woocommerce form .form-row.woocommerce-validated select',
				'body.woocommerce .sidebar .widget.widget_product_search .woocommerce-product-search input[type="search"]:focus, .insight-woo .sidebar .widget.widget_product_search .woocommerce-product-search input[type="search"]:focus',
				'body.woocommerce.single-product .woocommerce-tabs ul.tabs li.active',
				'body.woocommerce.single-product .product .summary form.cart button',
				'body.woocommerce .sidebar .widget.widget_product_tag_cloud a:hover, .insight-woo .sidebar .widget.widget_product_tag_cloud a:hover',
				'body.woocommerce .sidebar .widget.widget_products li:hover img, body.woocommerce .sidebar .widget.widget_recent_reviews li:hover img, body.woocommerce .sidebar .widget.widget_top_rated_products li:hover img, body.woocommerce .sidebar .widget.widget_recently_viewed_products li:hover img, .insight-woo .sidebar .widget.widget_products li:hover img, .insight-woo .sidebar .widget.widget_recent_reviews li:hover img, .insight-woo .sidebar .widget.widget_top_rated_products li:hover img, .insight-woo .sidebar .widget.widget_recently_viewed_products li:hover img',
				'body.woocommerce.single-product .product .images .thumbnails img:hover',
				'.single .content .comments-area .comment-form input[type="submit"], .page .content .comments-area .comment-form input[type="submit"]',
				'.single .content .content-area .entry-footer .tags a:hover, .page .content .content-area .entry-footer .tags a:hover',
				'body.woocommerce.single-product .product .images .woocommerce-main-image img:hover',
				'body.woocommerce .products.list .product .product-info .product-action-list .quick-view-btn a:hover, .insight-woo .products.list .product .product-info .product-action-list .quick-view-btn a:hover, body.woocommerce-page .products.list .product .product-info .product-action-list .quick-view-btn a:hover',
				'body.woocommerce .shop-filter .switch-view .switcher:hover, body.woocommerce .shop-filter .switch-view .switcher.active, .insight-woo .shop-filter .switch-view .switcher:hover, .insight-woo .shop-filter .switch-view .switcher.active',
				'body.woocommerce .woocommerce-pagination .page-numbers li span.current, body.woocommerce .woocommerce-pagination .page-numbers li span:hover, body.woocommerce .woocommerce-pagination .page-numbers li a.current, body.woocommerce .woocommerce-pagination .page-numbers li a:hover, .insight-woo .woocommerce-pagination .page-numbers li span.current, .insight-woo .woocommerce-pagination .page-numbers li span:hover, .insight-woo .woocommerce-pagination .page-numbers li a.current, .insight-woo .woocommerce-pagination .page-numbers li a:hover',
			) ),
			'property' => 'border-color',
		),
		array(
			'element'  => implode( ',', array(
				'.hint--success.hint--top:before',
				'body.woocommerce .woocommerce-message, body.woocommerce-page .woocommerce-message',
			) ),
			'property' => 'border-top-color',
		),
		array(
			'element'  => implode( ',', array(
				'.hint--success.hint--right:before',
			) ),
			'property' => 'border-right-color',
		),
		array(
			'element'  => implode( ',', array(
				'.hint--success.hint--bottom:before',
			) ),
			'property' => 'border-bottom-color',
		),
		array(
			'element'  => implode( ',', array(
				'.hint--success.hint--left:before',
				'.woocommerce.single-product .product .woocommerce-tabs ul.tabs li.active',
			) ),
			'property' => 'border-left-color',
		),
		array(
			'element'  => implode( ',', array(
				'a.cookie_notice_ok',
			) ),
			'property' => 'color',
			'suffix'   => ' !important',
		),
		array(
			'element'  => implode( ',', array(
				'body.woocommerce.single-product .woocommerce-tabs .woocommerce-Tabs-panel input[type="submit"]',
				'body.woocommerce .woocommerce-message .button, .insight-woo .woocommerce-message .button',
				'body.woocommerce-page.woocommerce-cart a.wc-backward, body.woocommerce-page.woocommerce-cart a.checkout-button',
				'a.cookie_notice_ok:hover',
			) ),
			'property' => 'background-color',
			'suffix'   => ' !important',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'secondary_color',
	'label'     => esc_html__( 'Secondary color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => Insight::SECONDARY_COLOR,
	'output'    => array(
		array(
			'element'  => implode( ',', array(
				'.ndColor',
				'.insight-btn:hover',
			) ),
			'property' => 'color',
		),
		array(
			'element'  => implode( ',', array(
				'.insight-featured-product.style-07 .price',
				'.insight-featured-product.style-07',
				'.insight-btn',
			) ),
			'property' => 'background-color',
		),
		array(
			'element'  => implode( ',', array(
				'.insight-btn',
			) ),
			'property' => 'border-color',
		),

	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'site_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Link Color', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'link_color',
	'label'     => esc_html__( 'Normal', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => Insight::TEXT_COLOR,
	'output'    => array(
		array(
			'element'  => 'a',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'link_color_hover',
	'label'     => esc_html__( 'Hover', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => Insight::PRIMARY_COLOR,
	'output'    => array(
		array(
			'element'  => 'a:hover',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'site_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Body Typography', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'typography',
	'settings'    => 'site_body_typo',
	'label'       => esc_html__( 'Font family', 'tm-organik' ),
	'description' => esc_html__( 'These settings control the typography for all body text.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => Insight::PRIMARY_FONT,
		'variant'        => 'regular',
		'color'          => Insight::TEXT_COLOR,
		'line-height'    => '1.5',
		'letter-spacing' => '0em',
		'subsets'        => array( 'latin-ext' ),
	),
	'output'      => array(
		array(
			'element' => 'body',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'body_font_size',
	'label'     => esc_html__( 'Font size', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 16,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => 'body',
			'property' => 'font-size',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'spectial_heading_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Special Heading Typography', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'typography',
	'settings'    => 'spectial_heading_typo',
	'label'       => esc_html__( 'Font family', 'tm-organik' ),
	'description' => esc_html__( 'These settings control the typography for all special heading text.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => Insight::SECONDARY_FONT,
		'variant'        => '400',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
	),
	'output'      => array(
		array(
			'element' => '.special-heading, .insight-testimonials.style7 .text, .insight-title--title',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'site_heading_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Normal Heading Typography', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'typography',
	'settings'    => 'heading_typo',
	'label'       => esc_html__( 'Font family', 'tm-organik' ),
	'description' => esc_html__( 'These settings control the typography for all heading text.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => Insight::PRIMARY_FONT,
		'variant'        => '700',
		'color'          => '#392a25',
		'line-height'    => '1.5',
		'letter-spacing' => '0',
		'subsets'        => array( 'latin-ext' ),
	),
	'output'      => array(
		array(
			'element' => 'h1,h2,h3,h4,h5,h6,.h1,.h2,.h3,.h4,.h5,.h6, .insight-countdown.color-dark .countdown-inner .countdown-timer',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => 'h1_font_size',
	'label'       => esc_html__( 'Font size', 'tm-organik' ),
	'description' => esc_html__( 'H1', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 56,
	'transport'   => 'auto',
	'choices'     => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'      => array(
		array(
			'element'  => 'h1,.h1',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => 'h2_font_size',
	'description' => esc_html__( 'H2', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 40,
	'transport'   => 'auto',
	'choices'     => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'      => array(
		array(
			'element'  => 'h2,.h2',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => 'h3_font_size',
	'description' => esc_html__( 'H3', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 34,
	'transport'   => 'auto',
	'choices'     => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'      => array(
		array(
			'element'  => 'h3,.h3',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => 'h4_font_size',
	'description' => esc_html__( 'H4', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 24,
	'transport'   => 'auto',
	'choices'     => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'      => array(
		array(
			'element'  => 'h4,.h4',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => 'h5_font_size',
	'description' => esc_html__( 'H5', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 20,
	'transport'   => 'auto',
	'choices'     => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'      => array(
		array(
			'element'  => 'h5,.h5',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => 'h6_font_size',
	'description' => esc_html__( 'H6', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 16,
	'transport'   => 'auto',
	'choices'     => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'      => array(
		array(
			'element'  => 'h6,.h6',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );
