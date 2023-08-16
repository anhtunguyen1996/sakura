<?php

class WPBakeryShortCode_Insight_About2 extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'About 2', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_about2',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'imgradio',
			'admin_label' => true,
			'heading'     => esc_html__( 'Style', 'tm-organik' ),
			'param_name'  => 'style',
			'value'       => array(
				'about_2_big_image'   => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/about-2/big-image.png',
					'title' => 'Big image',
				),
				'icon_on_small_image' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/about-2/small-image.png',
					'title' => 'Small image',
				),
			),
			'std'         => 'about_2_big_image',
		),
		array(
			'type'        => 'attach_image',
			'heading'     => 'Image',
			'param_name'  => 'image',
			'save_always' => true,
		),
		array(
			'type'       => 'colorpicker',
			'class'      => '',
			'heading'    => 'Background Color for Image icon',
			'param_name' => 'img_icon_bg_color',
			'dependency' => array( 'element' => 'style', 'value' => array( 'icon_on_small_image' ) ),
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
			'type'       => 'vc_link',
			'heading'    => esc_html__( 'Link', 'tm-organik' ),
			'param_name' => 'link',
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
