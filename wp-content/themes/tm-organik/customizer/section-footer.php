<?php
$section  = 'footer';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'footer_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'General', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'preset',
	'settings'    => 'footer_preset',
	'description' => esc_html__( 'Choose a preset you want', 'tm-organik' ),
	'label'       => esc_html__( 'Preset', 'tm-organik' ),
	'section'     => $section,
	'default'     => '1',
	'priority'    => $priority ++,
	'multiple'    => 3,
	'choices'     => array(
		'1' => array(
			'label'    => esc_html__( 'Preset 1', 'tm-organik' ),
			'settings' => array(
				'footer_visibility'                => 1,
				'footer_logo_enable'               => 1,
				'footer_social_enable'             => 1,
				'copyright_visibility'             => 1,
				'copyright_backtotop_visibility'   => 1,
				'footer_bg_color'                  => '#444444',
				'footer_text_color'                => '#ababab',
				'footer_link_color'                => '#ababab',
				'footer_widget_title_color'        => '#ffffff',
				'footer_widget_title_border_color' => '#545454',
				'copyright_bg_color'               => '#333333',
				'copyright_text_color'             => '#696969',
				'copyright_link_color'             => '#ababab',
				'copyright_backtotop_color'        => '#5fbd74',
				'footer_logo_img'                  => get_template_directory_uri() . '/assets/images/footer_logo_01.png'
			),
		),
		'2' => array(
			'label'    => esc_html__( 'Preset 2', 'tm-organik' ),
			'settings' => array(
				'footer_visibility'                => 1,
				'footer_logo_enable'               => 1,
				'footer_social_enable'             => 1,
				'copyright_visibility'             => 1,
				'copyright_backtotop_visibility'   => 1,
				'footer_bg_color'                  => '#f5f3f0',
				'footer_text_color'                => '#5e5a54',
				'footer_link_color'                => '#5e5a54',
				'footer_widget_title_color'        => '#392a25',
				'footer_widget_title_border_color' => '#e4e1dd',
				'copyright_bg_color'               => '#e4e1dd',
				'copyright_text_color'             => '#8e8b87',
				'copyright_link_color'             => '#5e5a54',
				'copyright_backtotop_color'        => '#5fbd74',
				'footer_logo_img'                  => get_template_directory_uri() . '/assets/images/footer_logo_02.png'
			),
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'footer_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Layout', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'footer_visibility',
	'label'       => esc_html__( 'Visibility', 'tm-organik' ),
	'description' => esc_html__( 'Show/hide the footer.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'footer_logo_enable',
	'label'       => esc_html__( 'Footer logo', 'tm-organik' ),
	'description' => esc_html__( 'Enable to show the logo in footer.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1
) );

Kiki::add_field( 'theme', array(
	'type'     => 'image',
	'settings' => 'footer_logo_img',
	'label'    => esc_html__( 'Footer logo image', 'tm-organik' ),
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => get_template_directory_uri() . '/assets/images/footer_logo_01.png',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'footer_social_enable',
	'label'       => esc_html__( 'Social links', 'tm-organik' ),
	'description' => esc_html__( 'Enable to show the social links in footer.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'footer_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Spacing', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'footer_padding_top',
	'label'     => esc_html__( 'Padding top', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 50,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.footer',
			'property' => 'padding-top',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'footer_padding_bottom',
	'label'     => esc_html__( 'Padding bottom', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 70,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.footer',
			'property' => 'padding-bottom',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'footer_margin_top',
	'label'     => esc_html__( 'Margin top', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 0,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.footer',
			'property' => 'margin-top',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'footer_margin_bottom',
	'label'     => esc_html__( 'Margin bottom', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 0,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.footer',
			'property' => 'margin-bottom',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'footer_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Typography', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'footer_font_size',
	'label'     => esc_html__( 'Font size', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 15,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.footer',
			'property' => 'font-size',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'footer_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Color', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'footer_bg_color',
	'label'     => esc_html__( 'Background', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#444444',
	'output'    => array(
		array(
			'element'  => '.footer',
			'property' => 'background-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'footer_text_color',
	'label'     => esc_html__( 'Text', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#ababab',
	'output'    => array(
		array(
			'element'  => '.footer',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'footer_link_color',
	'label'     => esc_html__( 'Link', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#ababab',
	'output'    => array(
		array(
			'element'  => '.footer a',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'footer_widget_title_color',
	'label'     => esc_html__( 'Widget title', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#ffffff',
	'output'    => array(
		array(
			'element'  => '.footer .widget .widget-title',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'footer_widget_title_border_color',
	'label'     => esc_html__( 'Widget title border', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#545454',
	'output'    => array(
		array(
			'element'  => '.footer .widget .widget-title',
			'property' => 'border-color',
		),
	),
) );