<?php

class WPBakeryShortCode_Insight_About extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'About', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_about',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'attach_image',
			'heading'     => 'Main Images',
			'param_name'  => 'image',
			'save_always' => true,
		),
		array(
			'type'       => 'toggle',
			'heading'    => esc_html__( 'Custom size', 'tm-organik' ),
			'param_name' => 'custom_image_size',
			'value'      => '',
			'options'    => array(
				'yes' => array(
					'label' => '',
					'on'    => esc_html__( 'Yes', 'tm-organik' ),
					'off'   => esc_html__( 'No', 'tm-organik' )
				)
			),
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Width', 'tm-organik' ),
			'param_name' => 'width',
			'value'      => 500,
			'min'        => 10,
			'step'       => 1,
			'suffix'     => 'px',
			'dependency' => array( 'element' => 'custom_image_size', 'value' => array( 'yes' ) ),
		),
		array(
			'type'       => 'number',
			'heading'    => esc_html__( 'Height', 'tm-organik' ),
			'param_name' => 'height',
			'value'      => 500,
			'min'        => 10,
			'step'       => 1,
			'suffix'     => 'px',
			'dependency' => array( 'element' => 'custom_image_size', 'value' => array( 'yes' ) ),
		),
		Insight_Helper::get_param( 'title' ),
		Insight_Helper::get_param( 'content' ),
		array(
			'type'        => 'attach_images',
			'heading'     => 'Carousel Images',
			'param_name'  => 'carousel_images',
			'save_always' => true,
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
