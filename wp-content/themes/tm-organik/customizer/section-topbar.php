<?php
$section  = 'topbar';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'header_topbar_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Layout', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'        => 'toggle',
	'settings'    => 'topbar_visibility',
	'label'       => esc_html__( 'Visibility', 'tm-organik' ),
	'description' => esc_html__( 'Show/hide top bar.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 1,
) );

Kiki::add_field( 'theme', array(
	'type'     => 'select',
	'settings' => 'topbar_type',
	'label'    => esc_html__( 'Topbar Type', 'tm-organik' ),
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => 'topbar',
	'choices'  => array(
		'topbar'    => 'Topbar 01',
		'topbar-02' => 'Topbar 02',
		'topbar-03' => 'Topbar 03',
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'header_topbar_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Topbar 01', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'textarea',
	'settings'  => 'topbar_text',
	'label'     => esc_html__( 'Text', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => esc_html__( 'Work time: Monday - Friday: 08AM-06PM', 'tm-organik' ),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.topbar__text',
			'function' => 'html',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_padding_top',
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
			'element'  => '.topbar.topbar-01 > .topbar-container',
			'property' => 'padding-top',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_padding_bottom',
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
			'element'  => '.topbar.topbar-01 > .topbar-container',
			'property' => 'padding-bottom',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'typography',
	'settings'    => 'topbar_typo',
	'label'       => esc_html__( 'Font family', 'tm-organik' ),
	'description' => esc_html__( 'These settings control the typography for all top bar text.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => Insight::PRIMARY_FONT,
		'variant'        => 'regular',
		'line-height'    => '1.5',
		'letter-spacing' => '0em',
		'subsets'        => array( 'latin-ext' ),
	),
	'output'      => array(
		array(
			'element' => '.topbar.topbar-01, body #lang_sel a.lang_sel_sel',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_font_size',
	'label'     => esc_html__( 'Font size', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 14,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-01, body #lang_sel a.lang_sel_sel, body #lang_sel li ul a:link',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'topbar_bg_color',
	'label'     => esc_html__( 'Background', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#444444',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-01, .topbar.topbar-01 > .topbar-container, body #lang_sel li ul a:link, body #lang_sel li ul a:visited',
			'property' => 'background-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_text_color',
	'label'     => esc_html__( 'Text', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#999999',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-01, body #lang_sel a.lang_sel_sel, body #lang_sel a.lang_sel_sel:hover, body #lang_sel li ul a:link, body #lang_sel li ul a:visited',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_link_color',
	'label'     => esc_html__( 'Link normal', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#999999',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-01 a',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'header_topbar_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Topbar 02', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'topbar_02_bg_color',
	'label'     => esc_html__( 'Background', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#fff',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-02, .topbar.topbar-02 > .topbar-container',
			'property' => 'background-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'topbar_02_border_bottom_color',
	'label'     => esc_html__( 'Border Bottom Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#eee',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-02',
			'property' => 'border-bottom-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'textarea',
	'settings'  => 'topbar_02_text',
	'label'     => esc_html__( 'Text', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => esc_html__( 'Free shipping for orders over $59. $5.00 USPS Shipping on $25+ !', 'tm-organik' ),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.topbar_02__text',
			'function' => 'html',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'textarea',
	'settings'  => 'topbar_02_phone',
	'label'     => esc_html__( 'Phone', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => esc_html__( '0122 889990', 'tm-organik' ),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.topbar_02__phone',
			'function' => 'html',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_02_padding_top',
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
			'element'  => '.topbar.topbar-02 > .topbar-container',
			'property' => 'padding-top',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_02_padding_bottom',
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
			'element'  => '.topbar.topbar-02 > .topbar-container',
			'property' => 'padding-bottom',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'typography',
	'settings'    => 'topbar_02_typo',
	'label'       => esc_html__( 'Font family', 'tm-organik' ),
	'description' => esc_html__( 'These settings control the typography for all top bar text.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => Insight::THIRD_FONT,
		'variant'        => 'regular',
		'line-height'    => '1.5',
		'letter-spacing' => '0em',
		'subsets'        => array( 'latin-ext' ),
	),
	'output'      => array(
		array(
			'element' => '.topbar.topbar-02, body #lang_sel a.lang_sel_sel',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_02_font_size',
	'label'     => esc_html__( 'Font size', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 14,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-02, body #lang_sel a.lang_sel_sel, body #lang_sel li ul a:link',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_02_text_color',
	'label'     => esc_html__( 'Text Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#5E5A54',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-02',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_02_link_color',
	'label'     => esc_html__( 'Link normal Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#5E5A54',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-02 a',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_02_link_hover_color',
	'label'     => esc_html__( 'Link normal hover Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => Insight::PRIMARY_COLOR,
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-02 a:hover, .topbar.topbar-02 .topbar__menu ul li .sub-menu a:hover',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_02_submenu_color',
	'label'     => esc_html__( 'Submenu Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#5E5A54',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-02 .topbar__menu ul li .sub-menu a',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_02_submenu_bg_color',
	'label'     => esc_html__( 'Submenu Background Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#fff',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-02 .topbar__menu ul li .sub-menu',
			'property' => 'background-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_02_phone_number_color',
	'label'     => esc_html__( 'Phone number Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#392A25',
	'output'    => array(
		array(
			'element'  => '.topbar_02__phone',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'typography',
	'settings'    => 'topbar_02_phone_number_typo',
	'label'       => esc_html__( 'Phone number Font family', 'tm-organik' ),
	'description' => esc_html__( 'These settings control the typography for all top bar text.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => Insight::THIRD_FONT,
		'variant'        => 'bold',
		'line-height'    => '1.5',
		'letter-spacing' => '0em',
		'subsets'        => array( 'latin-ext' ),
	),
	'output'      => array(
		array(
			'element' => '.topbar_02__phone',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_02_phone_number_font_size',
	'label'     => esc_html__( 'Phone number Font size', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 16,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.topbar_02__phone',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'     => 'custom',
	'settings' => 'header_topbar_group_title_' . $priority ++,
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => '<div class="group_title">' . esc_html__( 'Topbar 03', 'tm-organik' ) . '</div>',
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'topbar_03_bg_color',
	'label'     => esc_html__( 'Background', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#FAF8F6',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-03, .topbar.topbar-03 > .topbar-container',
			'property' => 'background-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color-alpha',
	'settings'  => 'topbar_03_border_bottom_color',
	'label'     => esc_html__( 'Border Bottom Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => 'transparent',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-03',
			'property' => 'border-bottom-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'textarea',
	'settings'  => 'topbar_03_text',
	'label'     => esc_html__( 'Text', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => esc_html__( 'Free shipping for orders over $59. $5.00 USPS Shipping on $25+ !', 'tm-organik' ),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.topbar_03__text',
			'function' => 'html',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'textarea',
	'settings'  => 'topbar_03_phone',
	'label'     => esc_html__( 'Phone', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => esc_html__( '0122 889990', 'tm-organik' ),
	'transport' => 'postMessage',
	'js_vars'   => array(
		array(
			'element'  => '.topbar_03__phone',
			'function' => 'html',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_03_padding_top',
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
			'element'  => '.topbar.topbar-03 > .topbar-container',
			'property' => 'padding-top',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_03_padding_bottom',
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
			'element'  => '.topbar.topbar-03 > .topbar-container',
			'property' => 'padding-bottom',
			'units'    => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'typography',
	'settings'    => 'topbar_03_typo',
	'label'       => esc_html__( 'Font family', 'tm-organik' ),
	'description' => esc_html__( 'These settings control the typography for all top bar text.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => Insight::THIRD_FONT,
		'variant'        => 'regular',
		'line-height'    => '1.5',
		'letter-spacing' => '0em',
		'subsets'        => array( 'latin-ext' ),
	),
	'output'      => array(
		array(
			'element' => '.topbar.topbar-03, body #lang_sel a.lang_sel_sel',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_03_font_size',
	'label'     => esc_html__( 'Font size', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 14,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-03, body #lang_sel a.lang_sel_sel, body #lang_sel li ul a:link',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_03_text_color',
	'label'     => esc_html__( 'Text Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#5E5A54',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-03',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_03_link_color',
	'label'     => esc_html__( 'Link normal Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#5E5A54',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-03 a',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_03_link_hover_color',
	'label'     => esc_html__( 'Link normal hover Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => Insight::PRIMARY_COLOR,
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-03 a:hover, .topbar.topbar-03 .topbar__menu ul li .sub-menu a:hover',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_03_submenu_color',
	'label'     => esc_html__( 'Submenu Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#5E5A54',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-03 .topbar__menu ul li .sub-menu a',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_03_submenu_bg_color',
	'label'     => esc_html__( 'Submenu Background Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#fff',
	'output'    => array(
		array(
			'element'  => '.topbar.topbar-03 .topbar__menu ul li .sub-menu',
			'property' => 'background-color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'color',
	'settings'  => 'topbar_03_phone_number_color',
	'label'     => esc_html__( 'Phone number Color', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'transport' => 'auto',
	'default'   => '#392A25',
	'output'    => array(
		array(
			'element'  => '.topbar_03__phone',
			'property' => 'color',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'        => 'typography',
	'settings'    => 'topbar_03_phone_number_typo',
	'label'       => esc_html__( 'Phone number Font family', 'tm-organik' ),
	'description' => esc_html__( 'These settings control the typography for all top bar text.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'transport'   => 'auto',
	'default'     => array(
		'font-family'    => Insight::THIRD_FONT,
		'variant'        => 'bold',
		'line-height'    => '1.5',
		'letter-spacing' => '0em',
		'subsets'        => array( 'latin-ext' ),
	),
	'output'      => array(
		array(
			'element' => '.topbar_03__phone',
		),
	),
) );

Kiki::add_field( 'theme', array(
	'type'      => 'slider',
	'settings'  => 'topbar_03_phone_number_font_size',
	'label'     => esc_html__( 'Phone number Font size', 'tm-organik' ),
	'section'   => $section,
	'priority'  => $priority ++,
	'default'   => 16,
	'transport' => 'auto',
	'choices'   => array(
		'min'  => 10,
		'max'  => 50,
		'step' => 1,
	),
	'output'    => array(
		array(
			'element'  => '.topbar_03__phone',
			'property' => 'font-size',

			'units' => 'px',
		),
	),
) );