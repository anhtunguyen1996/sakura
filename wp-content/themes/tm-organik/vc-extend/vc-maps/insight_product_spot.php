<?php

class WPBakeryShortCode_Insight_Product_Spot extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Product Spot', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_product_spot',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Type', 'tm-organik' ),
			'param_name'  => 'type',
			'value'       => array(
				'Left'  => 'left',
				'Right' => 'right',
			),
			'save_always' => true,
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Spot length', 'tm-organik' ),
			'param_name' => 'length',
			'value'      => 180,
			'min'        => 0,
			'step'       => 1,
			'suffix'     => 'px',
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Icon library', 'tm-organik' ),
			'std'         => 'ionicons',
			'value'       => array(
				esc_html__( 'FontAwesome', 'tm-organik' ) => 'fontawesome',
				esc_html__( 'OpenIconic', 'tm-organik' )  => 'openiconic',
				esc_html__( 'Typicons', 'tm-organik' )    => 'typicons',
				esc_html__( 'Entypo', 'tm-organik' )      => 'entypo',
				esc_html__( 'Linecons', 'tm-organik' )    => 'linecons',
				esc_html__( 'Ionicons', 'tm-organik' )    => 'ionicons',
				esc_html__( 'Organik', 'tm-organik' )     => 'organik',

			),
			'param_name'  => 'icon_lib',
			'description' => esc_html__( 'Select icon library.', 'tm-organik' ),
			'admin_label' => true,
		),
		Insight_Helper::fonticon( 'fontawesome' ),
		Insight_Helper::fonticon( 'openiconic' ),
		Insight_Helper::fonticon( 'typicons' ),
		Insight_Helper::fonticon( 'entypo' ),
		Insight_Helper::fonticon( 'linecons' ),
		Insight_Helper::fonticon( 'ionicons' ),
		Insight_Helper::fonticon( 'organik' ),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'tm-organik' ),
			'param_name'  => 'title',
			'value'       => '',
			'admin_label' => true
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Content', 'tm-organik' ),
			'param_name' => 'content',
			'value'      => ''
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
