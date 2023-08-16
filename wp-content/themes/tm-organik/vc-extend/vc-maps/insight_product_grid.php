<?php

class WPBakeryShortCode_Insight_Product_Grid extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Product Grid', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_product_grid',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'ajax-search',
			'heading'     => esc_html__( 'Product Categories', 'tm-organik' ),
			'param_name'  => 'categories',
			'ajax_type'   => 'taxonomy',
			'ajax_get'    => 'product_cat',
			'ajax_field'  => 'slug',
			'ajax_limit'  => 10,
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => 'Product Type',
			'param_name'  => 'product_type',
			'value'       => array(
				'Default'               => '',
				'Recent Products'       => 'recent_products',
				'Featured Products'     => 'featured_products',
				'Sale Products'         => 'sale_products',
				'Best-Selling Products' => 'best_selling_products',
				'Related Products'      => 'related_products',
				'Top Rated Products'    => 'top_rated_products',
				'Categories above'      => 'categories',
			),
			'save_always' => true,
			'admin_label' => true,
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Number', 'tm-organik' ),
			'param_name' => 'number',
			'min'        => - 1,
			'suffix'     => esc_html__( 'Number of product on grid (-1 is all)', 'tm-organik' ),
		),
		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Columns', 'tm-organik' ),
			'param_name'  => 'columns',
			'min'         => 1,
			'max'         => 6,
			'admin_label' => true,
		),
		array(
			'type'       => 'toggle',
			'heading'    => esc_html__( 'Show Load More', 'tm-organik' ),
			'param_name' => 'show_load_more',
			'value'      => '',
			'options'    => array(
				'yes' => array(
					'label' => '',
					'on'    => esc_html__( 'Yes', 'tm-organik' ),
					'off'   => esc_html__( 'No', 'tm-organik' ),
				),
			),
			'dependency' => array( 'element' => 'product_type', 'value' => array( '', 'categories' ) ),
		),
		array(
			'type'       => 'toggle',
			'heading'    => esc_html__( 'Disable Filter', 'tm-organik' ),
			'param_name' => 'disable_filter',
			'value'      => '',
			'options'    => array(
				'yes' => array(
					'label' => '',
					'on'    => esc_html__( 'Yes', 'tm-organik' ),
					'off'   => esc_html__( 'No', 'tm-organik' ),
				),
			),
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
