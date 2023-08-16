<?php

class WPBakeryShortCode_Insight_Custom_Menu extends WPBakeryShortCode {
}

$custom_menus = array();
if ( 'vc_edit_form' === vc_post_param( 'action' ) && vc_verify_admin_nonce() ) {
	$menus = get_terms( 'nav_menu', array( 'hide_empty' => false ) );
	if ( is_array( $menus ) && ! empty( $menus ) ) {
		foreach ( $menus as $single_menu ) {
			if ( is_object( $single_menu ) && isset( $single_menu->name, $single_menu->slug ) ) {
				$custom_menus[ $single_menu->name ] = $single_menu->slug;
			}
		}
	}
}

$styling_tab = esc_html__( 'Styling', 'tm-organik' );

vc_map( array(
	'name'     => esc_html__( 'Custom Menu', 'tm-organik' ),
	'base'     => 'insight_custom_menu',
	'category' => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'icon'     => 'tm-shortcode-ico default-icon',
	'class'    => 'wpb_vc_wp_widget',
	'params'   => array(
		array(
			'heading'     => esc_html__( 'Widget title', 'tm-organik' ),
			'type'        => 'textfield',
			'param_name'  => 'title',
			'description' => esc_html__( 'What text use as a widget title. Leave blank to use default widget title.', 'tm-organik' ),
		),
		array(
			'heading'    => esc_html__( 'Style', 'tm-organik' ),
			'type'       => 'dropdown',
			'param_name' => 'style',
			'value'      => array(
				esc_html__( 'Normal', 'tm-organik' )                => '1',
			),
			'std'        => '1',
		),
		array(
			'heading'    => esc_html__( 'Menu desktop Align', 'tm-organik' ),
			'type'       => 'dropdown',
			'param_name' => 'align',
			'value'      => array(
				esc_html__( 'Left', 'tm-organik' )   => 'left',
				esc_html__( 'Right', 'tm-organik' )  => 'right',
				esc_html__( 'Center', 'tm-organik' ) => 'center',
			),
			'std'        => 'left',
		),
		array(
			'heading'     => esc_html__( 'Menu', 'tm-organik' ),
			'description' => empty( $custom_menus ) ? wp_kses( __( 'Custom menus not found. Please visit <b>Appearance > Menus</b> page to create new menu.', 'tm-organik' ), array(
				'b' => array(),

			) ) : esc_html__( 'Select menu to display.', 'tm-organik' ),
			'type'        => 'dropdown',
			'param_name'  => 'nav_menu',
			'value'       => $custom_menus,
			'save_always' => true,
			'admin_label' => true,
		),
		array(
			'group'            => $styling_tab,
			'heading'          => esc_html__( 'Custom Link Color', 'tm-organik' ),
			'type'             => 'colorpicker',
			'param_name'       => 'link_color',
			'std'              => '#5E5A54',
			'edit_field_class' => 'vc_col-sm-6',
		),
		array(
			'group'            => $styling_tab,
			'heading'          => esc_html__( 'Custom Link Hover Color', 'tm-organik' ),
			'type'             => 'colorpicker',
			'param_name'       => 'link_hover_color',
			'std'              => Insight::PRIMARY_COLOR,
			'edit_field_class' => 'vc_col-sm-6',
		),
	),
) );
