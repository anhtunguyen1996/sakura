<?php
$section  = 'shop';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'shop_layout_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Layout', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'radio-image',
	'settings'    => 'shop_layout',
	'label'       => esc_html__( 'Archive Pages', 'tm-organik' ),
	'description' => esc_html__( 'Choose layout for all product archive pages as product category, product tag, product search...', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 'sidebar-content',
	'choices'     => Insight_Helper::get_list_page_layout(),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'radio-image',
	'settings'    => 'product_layout',
	'label'       => esc_html__( 'Product Detail', 'tm-organik' ),
	'description' => esc_html__( 'Choose layout for single product page.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 'sidebar-content',
	'choices'     => Insight_Helper::get_list_page_layout(),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'shop_hide_sidebar_mobile',
	'label'       => esc_html__( 'Hide Sidebar on Mobile', 'tm-organik' ),
	'description' => esc_html__( 'Enable this option to hide the sidebar on mobile screen.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'shop_archive_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Product Archive', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'shop_archive_compare',
	'label'       => esc_html__( 'Compare', 'tm-organik' ),
	'description' => esc_html__( 'Enable to show the compare button.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'shop_archive_wishlist',
	'label'       => esc_html__( 'Wishlist', 'tm-organik' ),
	'description' => esc_html__( 'Enable to show the wishlist button.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'shop_archive_quickview',
	'label'       => esc_html__( 'Quickview', 'tm-organik' ),
	'description' => esc_html__( 'Enable to show Quickview button.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'shop_archive_view_switch',
	'label'       => esc_html__( 'View Switch', 'tm-organik' ),
	'description' => esc_html__( 'Switch between grid/list style on shop or product category page.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'shop_archive_view_switch_layout',
	'label'       => esc_html__( 'View Switch Layout', 'tm-organik' ),
	'description' => esc_html__( 'Switch between grid or list style on shop or product category page.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 'grid',
	'choices'     => array(
		'grid'  => esc_html__( 'Grid', 'tm-organik' ),
		'list'  => esc_html__( 'List', 'tm-organik' ),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'shop_archive_category_slider',
	'label'       => esc_html__( 'Categories Slider', 'tm-organik' ),
	'description' => esc_html__( 'Enable slider for categories or sub-categories on product archive page. This is a different section with the default option in WooCommerce.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'select',
	'settings'    => 'shop_archive_new_days',
	'label'       => esc_html__( 'New Badge (Days)', 'tm-organik' ),
	'description' => esc_html__( 'If the product was published within the newness time frame display the new badge.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => '3',
	'choices'     => array(
		'1'  => esc_html__( '1 day', 'tm-organik' ),
		'2'  => esc_html__( '2 days', 'tm-organik' ),
		'3'  => esc_html__( '3 days', 'tm-organik' ),
		'4'  => esc_html__( '4 days', 'tm-organik' ),
		'5'  => esc_html__( '5 days', 'tm-organik' ),
		'6'  => esc_html__( '6 days', 'tm-organik' ),
		'7'  => esc_html__( '7 days', 'tm-organik' ),
		'8'  => esc_html__( '8 days', 'tm-organik' ),
		'9'  => esc_html__( '9 days', 'tm-organik' ),
		'10' => esc_html__( '10 days', 'tm-organik' ),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'shop_single_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Product Single', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'shop_single_compare',
	'label'       => esc_html__( 'Compare', 'tm-organik' ),
	'description' => esc_html__( 'Enable to show the compare button.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'shop_single_wishlist',
	'label'       => esc_html__( 'Wishlist', 'tm-organik' ),
	'description' => esc_html__( 'Enable to show the wishlist button.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'shop_single_share',
	'label'       => esc_html__( 'Share Buttons', 'tm-organik' ),
	'description' => esc_html__( 'Enable to show the share buttons.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => 'shop_single_upsells',
	'label'       => esc_html__( 'Up Sells', 'tm-organik' ),
	'description' => esc_html__( 'Number of up-sells products. Set 0 to hide this section.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 9,
	'choices'     => array(
		'min'  => 0,
		'max'  => 15,
		'step' => 1,
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => 'shop_single_viewed',
	'label'       => esc_html__( 'Recent Viewed Products', 'tm-organik' ),
	'description' => esc_html__( 'Number of recent viewed products. Set 0 to hide this section.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 9,
	'choices'     => array(
		'min'  => 0,
		'max'  => 15,
		'step' => 1,
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'slider',
	'settings'    => 'shop_single_related',
	'label'       => esc_html__( 'Related Products', 'tm-organik' ),
	'description' => esc_html__( 'Number of related products. Set 0 to hide this section.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 9,
	'choices'     => array(
		'min'  => 0,
		'max'  => 15,
		'step' => 1,
	),
) );
