<?php

class WPBakeryShortCode_Insight_Our_Services extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Our Services', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_our_services',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'       => 'dropdown',
			'heading'    => esc_html__( 'Type', 'tm-organik' ),
			'param_name' => 'type',
			'std'        => 'icon',
			'value'      => array(
				esc_html__( 'Icon', 'tm-organik' )  => 'icon',
				esc_html__( 'Image', 'tm-organik' ) => 'image',

			),
		),
		array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Icon library', 'tm-organik' ),
			'description' => esc_html__( 'Select icon library.', 'tm-organik' ),
			'param_name'  => 'icon_lib',
			'std'         => 'organik',
			'value'       => array(
				esc_html__( 'Organik', 'tm-organik' )      => 'organik',
				esc_html__( 'Font Awesome', 'tm-organik' ) => 'fontawesome',
				esc_html__( 'Ionicons', 'tm-organik' )     => 'ionicons',

			),
			'dependency'  => array( 'element' => 'type', 'value' => array( 'icon' ) ),
		),
		Insight_Helper::fonticon( 'organik' ),
		Insight_Helper::fonticon( 'fontawesome' ),
		Insight_Helper::fonticon( 'ionicons' ),
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Image', 'tm-organik' ),
			'description' => esc_html__( 'Select an image from media library.', 'tm-organik' ),
			'param_name'  => 'image',
			'value'       => '',
			'dependency'  => array( 'element' => 'type', 'value' => array( 'image' ) ),
		),
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
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Link', 'tm-organik' ),
			'param_name'  => 'link',
			'value'       => '',
			'admin_label' => true
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
