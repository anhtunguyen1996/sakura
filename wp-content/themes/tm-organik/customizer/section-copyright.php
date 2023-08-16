<?php
$section  = 'copyright';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'copyright_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Layout', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'copyright_visibility',
	'label'       => esc_html__( 'Visibility', 'tm-organik' ),
	'description' => esc_html__( 'Enable to show the copyright section.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'copyright_backtotop_visibility',
	'label'       => esc_html__( 'Back to top', 'tm-organik' ),
	'description' => esc_html__( 'Enable to show the back to top button.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'copyright_general_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Spacing', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'copyright_padding_top',
	'label'     => esc_html__( 'Padding top', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 15,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.copyright',
			'property' => 'padding-top',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'copyright_padding_bottom',
	'label'     => esc_html__( 'Padding bottom', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 15,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 0,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.copyright',
			'property' => 'padding-bottom',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'copyright_margin_top',
	'label'     => esc_html__( 'Margin top', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 0,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => - 200,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.copyright',
			'property' => 'margin-top',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'copyright_margin_bottom',
	'label'     => esc_html__( 'Margin bottom', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 0,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => - 200,
		'max'  => 200,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.copyright',
			'property' => 'margin-bottom',
			'units'    => 'px',
		),
	),
) );

/*--------------------------------------------------------------
# Text typography
--------------------------------------------------------------*/
Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'copyright_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Typography', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'copyright_font_size',
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
			'element'  => '.copyright__text',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'copyright_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Color', 'tm-organik' ) . '</div>',
) );


Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'copyright_bg_color',
	'label'     => esc_html__( 'Background', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#333333',
	'output'    => array(
		array(
			'element'  => '.copyright',
			'property' => 'background-color',
		),
		array(
			'element'  => '.copyright .backtotop svg g',
			'property' => 'fill',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'copyright_text_color',
	'label'     => esc_html__( 'Text', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#696969',
	'output'    => array(
		array(
			'element'  => '.copyright',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'copyright_link_color',
	'label'     => esc_html__( 'Link', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#ababab',
	'output'    => array(
		array(
			'element'  => '.copyright a',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'copyright_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Content', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'textarea',
	'settings'    => 'copyright_text',
	'label'       => esc_html__( 'Text', 'tm-organik' ),
	'description' => esc_html__( 'Enter the text that displays in the copyright section. HTML markup can be used.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => esc_html__( 'Copyright &copy; 2019 TM Organik - All Rights Reserved.', 'tm-organik' ),
	'transport'   => 'postMessage',
) );

Kiki::add_field( 'theme', array(
	'type'     => 'image',
	'settings' => 'copyright_payment_img',
	'label'    => esc_html__( 'Payment Image', 'tm-organik' ),
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => get_template_directory_uri() . '/assets/images/footer_payment_01.png',
) );