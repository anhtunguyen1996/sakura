<?php

class WPBakeryShortCode_Insight_Product_Carousel extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Product Carousel', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_product_carousel',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		Insight_Helper::get_param( 'title' ),
		array(
			'type'       => 'textfield',
			'heading'    => esc_html__( 'Sub title', 'tm-organik' ),
			'param_name' => 'sub_title',
		),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => 'Product type',
			'param_name'  => 'product_type',
			'value'       => array(
				'Recent Products'       => 'recent_products',
				'Featured Products'     => 'featured_products',
				'Sale Products'         => 'sale_products',
				'Best-Selling Products' => 'best_selling_products',
				'Related Products'      => 'related_products',
				'Top Rated Products'    => 'top_rated_products',
				'Special Categories'    => 'categories',
				'Special Products'      => 'special_products',
			),
			'admin_label' => true,
			'save_always' => true,
		),
		Insight_Helper::get_param( 'woo_categories', '', array(
			'element' => 'product_type',
			'value'   => array( 'categories' )
		) ),
		array(
			'type'        => 'ajax-search',
			'heading'     => esc_html__( 'Special products', 'tm-organik' ),
			'param_name'  => 'special_products',
			'ajax_type'   => 'post_type',
			'ajax_get'    => 'product',
			'ajax_field'  => 'id',
			'ajax_limit'  => 100,
			'admin_label' => true,
			'dependency'  => array( 'element' => 'product_type', 'value' => array( 'special_products' ) )
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Number', 'tm-organik' ),
			'param_name' => 'number',
			'value'      => 10,
			'min'        => 0,
			'max'        => 500,
			'suffix'     => esc_html__( 'Number of products (0 is all)', 'tm-organik' ),
		),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => 'Order by',
			'param_name'  => 'order_by',
			'value'       => array(
				'Default' => '',
				'Title'   => 'title',
				'Date'    => 'date',
			),
			'save_always' => true,
		),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => 'Order',
			'param_name'  => 'order',
			'value'       => array(
				'Default' => '',
				'ASC'     => 'ASC',
				'DESC'    => 'DESC',
			),
			'save_always' => true,
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
