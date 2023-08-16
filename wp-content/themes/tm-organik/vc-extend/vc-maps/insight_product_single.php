<?php

class WPBakeryShortCode_Insight_Product_Single extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Product Single', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_product_single',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'ajax-search',
			'heading'     => esc_html__( 'Product', 'tm-organik' ),
			'param_name'  => 'product',
			'ajax_type'   => 'post_type',
			'ajax_get'    => 'product',
			'ajax_field'  => 'id',
			'ajax_limit'  => 1,
			'admin_label' => true,
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
