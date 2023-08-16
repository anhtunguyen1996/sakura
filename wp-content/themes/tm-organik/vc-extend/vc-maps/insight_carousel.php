<?php

class WPBakeryShortCode_Insight_Carousel extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Images Carousel', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_carousel',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'attach_images',
			'heading'     => 'Images',
			'param_name'  => 'images',
			'save_always' => true,
		),
		array(
			'type'        => 'toggle',
			'heading'     => esc_html__( 'Custom image size', 'tm-organik' ),
			'param_name'  => 'custom_image_size',
			'value'       => '',
			'options'     => array(
				'yes' => array(
					'label' => '',
					'on'    => esc_html__( 'Yes', 'tm-organik' ),
					'off'   => esc_html__( 'No', 'tm-organik' )
				)
			),
			'admin_label' => true,
		),
		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Width', 'tm-organik' ),
			'param_name'  => 'width',
			'value'       => 500,
			'min'         => 10,
			'step'        => 1,
			'suffix'      => 'px',
			'dependency'  => array( 'element' => 'custom_image_size', 'value' => array( 'yes' ) ),
			'admin_label' => true,
		),
		array(
			'type'        => 'number',
			'heading'     => esc_html__( 'Height', 'tm-organik' ),
			'param_name'  => 'height',
			'value'       => 500,
			'min'         => 10,
			'step'        => 1,
			'suffix'      => 'px',
			'dependency'  => array( 'element' => 'custom_image_size', 'value' => array( 'yes' ) ),
			'admin_label' => true,
		),
		array(
			'type'        => 'toggle',
			'heading'     => esc_html__( 'Auto play', 'tm-organik' ),
			'param_name'  => 'autoplay',
			'value'       => '',
			'options'     => array(
				'yes' => array(
					'label' => '',
					'on'    => esc_html__( 'Yes', 'tm-organik' ),
					'off'   => esc_html__( 'No', 'tm-organik' )
				)
			),
			'admin_label' => true,
		),
		array(
			'type'       => 'toggle',
			'heading'    => esc_html__( 'Show dots', 'tm-organik' ),
			'param_name' => 'dots',
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
			'type'       => 'toggle',
			'heading'    => esc_html__( 'Gray style', 'tm-organik' ),
			'param_name' => 'gray_style',
			'value'      => 'yes',
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
			'heading'    => esc_html__( 'Slides per row', 'tm-organik' ),
			'param_name' => 'slides_per_row',
			'value'      => 5,
			'min'        => 1,
			'max'        => 10,
			'step'       => 1,
			'suffix'     => 'slide(s)',
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
