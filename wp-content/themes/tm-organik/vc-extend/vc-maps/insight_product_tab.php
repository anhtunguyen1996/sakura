<?php

class WPBakeryShortCode_Insight_Product_Tab extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Product Tab', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_product_tab',
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
			'heading'    => esc_html__( 'Show Filter', 'tm-organik' ),
			'param_name' => 'show_filter',
			'std'        => 'yes',
			'options'    => array(
				'yes' => array(
					'label' => '',
					'on'    => esc_html__( 'Yes', 'tm-organik' ),
					'off'   => esc_html__( 'No', 'tm-organik' ),
				),
			),
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
