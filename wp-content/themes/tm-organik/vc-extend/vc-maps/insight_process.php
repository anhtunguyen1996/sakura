<?php

class WPBakeryShortCode_Insight_Process extends WPBakeryShortCode {
}

vc_map( array(
	'name'                      => esc_html__( 'Process', 'tm-organik' ),
	'description'               => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'category'                  => sprintf( esc_html__( 'by %s', 'tm-organik' ), INSIGHT_THEME_NAME ),
	'base'                      => 'insight_process',
	'icon'                      => 'tm-shortcode-ico default-icon',
	'allowed_container_element' => 'vc_row',
	'params'                    => array(
		array(
			'type'        => 'imgradio',
			'admin_label' => true,
			'heading'     => esc_html__( 'Style', 'tm-organik' ),
			'param_name'  => 'style',
			'value'       => array(
				'big-icon'   => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/process/large-icon.png',
					'title' => 'Big icon style',
				),
				'small-icon' => array(
					'img'   => INSIGHT_THEME_URI . '/assets/admin/images/shortcode-style/process/small-icon.png',
					'title' => 'Small icon style',
				),
			),
			'std'         => 'big-icon',
			'admin_label' => true,
		),
		array(
			'type'       => 'param_group',
			'param_name' => 'steps',
			'params'     => array(
				array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'tm-organik' ),
					'param_name'  => 'title',
					'value'       => 'Step ',
					'admin_label' => true,
				),
				Insight_Helper::get_param( 'content' ),
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
					'type'       => 'attach_image',
					'class'      => '',
					'heading'    => 'Custom Icon',
					'param_name' => 'custom_icon',
				),
				array(
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Icon library', 'tm-organik' ),
					'std'         => 'ionicons',
					'value'       => array(
						esc_html__( 'Organik', 'tm-organik' )      => 'organik',
						esc_html__( 'Ionicons', 'tm-organik' )     => 'ionicons',
						esc_html__( 'Font Awesome', 'tm-organik' ) => 'fontawesome',

					),
					'param_name'  => 'icon_lib',
					'description' => esc_html__( 'Select icon library.', 'tm-organik' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Organik', 'tm-organik' ),
					'param_name'  => 'icon_organik',
					'value'       => 'organik-apple',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'organik',
						'iconsPerPage' => 40,
					),
					'description' => esc_html__( 'Select icon from library.', 'tm-organik' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Ionicons', 'tm-organik' ),
					'param_name'  => 'icon_ionicons',
					'value'       => 'ion-ionic',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'ionicons',
						'iconsPerPage' => 4000,
					),
					'description' => esc_html__( 'Select icon from library.', 'tm-organik' ),
				),
				array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'FontAwesome', 'tm-organik' ),
					'param_name'  => 'icon_fontawesome',
					'value'       => 'fas fa-adjust',
					'settings'    => array(
						'emptyIcon'    => false,
						'iconsPerPage' => 4000,
					),
					'description' => esc_html__( 'Select icon from library.', 'tm-organik' ),
				),
			)
		),
		Insight_Helper::get_param( 'el_class' ),
		Insight_Helper::get_param( 'animation' ),
		Insight_Helper::get_param( 'css' ),
		Insight_Helper::get_param( 'note' ),
	)
) );
