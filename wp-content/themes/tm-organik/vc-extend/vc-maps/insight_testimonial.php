<?php

class WPBakeryShortCode_Insight_Testimonial extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Testimonials', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_testimonial',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Style', 'tm-organik' ),
			'param_name'  => 'style',
			'admin_label' => true,
			'value'       => array(
				esc_html__( 'Style 01', 'tm-organik' )                    => '1',
				esc_html__( 'Style 01 (white background)', 'tm-organik' ) => '3',
				esc_html__( 'Style 01 (gray background)', 'tm-organik' )  => '6',
				esc_html__( 'Style 01 (primay color)', 'tm-organik' )     => '7',
				esc_html__( 'Style 02', 'tm-organik' )                    => '2',
				esc_html__( 'Style 02 (white background)', 'tm-organik' ) => '4',
				esc_html__( 'Style 02 (gray background)', 'tm-organik' )  => '5',
				esc_html__( 'Style 03', 'tm-organik' )                    => '8',
				esc_html__( 'Style 04', 'tm-organik' )                    => '9',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Enable Carousel', 'tm-organik' ),
			'param_name' => 'enable_carousel',
			'value'      => array(
				esc_html__( 'Yes', 'tm-organik' ) => 'true',
				esc_html__( 'No', 'tm-organik' )  => 'false',
			),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Show Bullets', 'tm-organik' ),
			'param_name' => 'display_bullets',
			'value'      => array(
				esc_html__( 'Yes', 'tm-organik' ) => 'true',
				esc_html__( 'No', 'tm-organik' )  => 'false',
			),
			'dependency' => array( 'element' => 'enable_carousel', 'value' => array( 'true' ) ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Show Arrows', 'tm-organik' ),
			'param_name' => 'display_arrows',
			'value'      => array(
				esc_html__( 'Yes', 'tm-organik' ) => 'true',
				esc_html__( 'No', 'tm-organik' )  => 'false',
			),
			'dependency' => array( 'element' => 'enable_carousel', 'value' => array( 'true' ) ),
		),
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Enable Autoplay', 'tm-organik' ),
			'param_name' => 'enable_autoplay',
			'value'      => array(
				esc_html__( 'Yes', 'tm-organik' ) => 'true',
				esc_html__( 'No', 'tm-organik' )  => 'false',
			),
			'dependency' => array( 'element' => 'enable_carousel', 'value' => array( 'true' ) ),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Slides to display', 'tm-organik' ),
			'param_name'  => 'slides_to_display',
			'value'       => Insight_Helper::get_value_num( 1, 6, 1 ),
			'description' => esc_html__( 'Just for Style 02. Number of slides to display (default: 1)', 'tm-organik' ),
			'dependency'  => array( 'element' => 'enable_carousel', 'value' => array( 'true' ) ),
		),
		array(
			'type'       => 'param_group',
			'heading'    => esc_html__( 'Testimonials', 'tm-organik' ),
			'param_name' => 'testimonials',
			'params'     => array(
				array(
					'type'        => 'attach_image',
					'heading'     => esc_html__( 'Photo', 'tm-organik' ),
					'param_name'  => 'photo',
					'admin_label' => true,
					'description' => esc_html__( 'Photo', 'tm-organik' ),
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Name', 'tm-organik' ),
					'param_name'  => 'name',
					'value'       => '',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Tagline', 'tm-organik' ),
					'param_name'  => 'tagline',
					'value'       => '',
					'admin_label' => true,
				),
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Heading', 'tm-organik' ),
					'param_name'  => 'heading',
					'value'       => '',
					'admin_label' => true,
					'dependency'  => array( 'style' => '9' ),
				),
				array(
					'type'       => 'textarea',
					'heading'    => esc_html__( 'Content', 'tm-organik' ),
					'param_name' => 'content',
					'value'      => '',
				),
				array(
					'type'       => 'colorpicker',
					'heading'    => 'Background Color',
					'param_name' => 'background_color',
					'std'        => '#eee',
					'dependency' => array( 'style' => '9' ),
				),
			),
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'note' ),
	),
) );
