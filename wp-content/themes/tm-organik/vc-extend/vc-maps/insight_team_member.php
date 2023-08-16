<?php

class WPBakeryShortCode_Insight_Team_Member extends WPBakeryShortCode {
	public function getSocialLinks( $atts ) {
		$social_links     = preg_split( '/\s+/', $atts['social_links'] );
		$social_links_arr = array();

		foreach ( $social_links as $social ) {
			$pieces = explode( '|', $social );
			if ( count( $pieces ) == 2 ) {
				$key                      = $pieces[0];
				$link                     = $pieces[1];
				$social_links_arr[ $key ] = $link;
			}
		}

		return $social_links_arr;
	}
}

$group_social = esc_html__( 'Social', 'tm-organik' );

vc_map( array(
	'name'                      => esc_html__( 'Team Member', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_team_member',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'attach_image',
			'heading'     => esc_html__( 'Image', 'tm-organik' ),
			'param_name'  => 'image',
			'value'       => '',
			'description' => esc_html__( 'Select an image from media library.', 'tm-organik' ),
		),
		array(
			'type'        => 'textfield',
			'heading'     => esc_html__( 'Name', 'tm-organik' ),
			'param_name'  => 'name',
			'admin_label' => true,
		),
		array(
			'type'       => 'textarea',
			'heading'    => esc_html__( 'Biography', 'tm-organik' ),
			'param_name' => 'biography',
		),
		array(
			'type'       => 'toggle',
			'heading'    => esc_html__( 'Open links in new tab', 'tm-organik' ),
			'param_name' => 'link_new_page',
			'value'      => '',
			'options'    => array(
				'yes' => array(
					'label' => '',
					'on'    => esc_html__( 'Yes', 'tm-organik' ),
					'off'   => esc_html__( 'No', 'tm-organik' )
				)
			),
			'group'      => $group_social,
		),
		array(
			'type'       => 'social_links',
			'heading'    => esc_html__( 'Social links', 'tm-organik' ),
			'param_name' => 'social_links',
			'group'      => $group_social,
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
