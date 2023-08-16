<?php

class WPBakeryShortCode_Insight_Icon_Boxes extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Icon Box', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_icon_boxes',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'imgradio',
			'admin_label' => true,
			'heading'     => esc_html__( 'Style', 'tm-organik' ),
			'param_name'  => 'style',
			'value'       => array(
				'icon_on_left'  => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/icon-boxes/icon-on-left.png',
					'title' => 'Icon on Left',
				),
				'icon_on_top'   => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/icon-boxes/icon-on-top.png',
					'title' => 'Icon on Top',
				),
				'icon_on_right' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/icon-boxes/icon-on-right.png',
					'title' => 'Icon on Right',
				),
			),
			'std'         => 'icon_on_left',
		),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => 'Icon type',
			'param_name'  => 'icon_type',
			'value'       => array(
				'Font icons' => 'font-icons',
				'Custom'     => 'custom',
			),
			'description' => '',
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Icon library', 'tm-organik' ),
			'std'         => 'ionicons',
			'value'       => array(
				esc_html__( 'Font Awesome', 'tm-organik' ) => 'fontawesome',
				esc_html__( 'Open Iconic', 'tm-organik' )  => 'openiconic',
				esc_html__( 'Typicons', 'tm-organik' )     => 'typicons',
				esc_html__( 'Entypo', 'tm-organik' )       => 'entypo',
				esc_html__( 'Linecons', 'tm-organik' )     => 'linecons',
				esc_html__( 'Ionicons', 'tm-organik' )     => 'ionicons',
				esc_html__( 'Organik', 'tm-organik' )      => 'organik',

			),
			'param_name'  => 'icon_lib',
			'description' => esc_html__( 'Select icon library.', 'tm-organik' ),
			'dependency'  => array( 'element' => 'icon_type', 'value' => array( 'font-icons' ) ),
		),
		Insight_Helper::fonticon( 'fontawesome' ),
		Insight_Helper::fonticon( 'openiconic' ),
		Insight_Helper::fonticon( 'typicons' ),
		Insight_Helper::fonticon( 'entypo' ),
		Insight_Helper::fonticon( 'linecons' ),
		Insight_Helper::fonticon( 'ionicons' ),
		Insight_Helper::fonticon( 'organik' ),
		array(
			'type'       => 'attach_image',
			'class'      => '',
			'heading'    => 'Custom Icon',
			'param_name' => 'custom_icon',
			'dependency' => array( 'element' => 'icon_type', 'value' => array( 'custom' ) ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Title', 'tm-organik' ),
			'param_name'  => 'title',
			'admin_label' => true,
		),
		array(
			'type'        => 'textarea',
			'heading'     => esc_html__( 'Content', 'tm-organik' ),
			'param_name'  => 'content',
			'admin_label' => true,
		),
		array(
			'type'        => 'dropdown',
			'class'       => '',
			'heading'     => 'Title Element Tag',
			'param_name'  => 'element_tag',
			'value'       => array(
				'Default' => '',
				'h1'      => 'h1',
				'h2'      => 'h2',
				'h3'      => 'h3',
				'h4'      => 'h4',
				'h5'      => 'h5',
				'h6'      => 'h6',
				'p'       => 'p',
				'div'     => 'div',
			),
			'save_always' => true,
			'description' => 'Select element tag.',
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	),
) );
