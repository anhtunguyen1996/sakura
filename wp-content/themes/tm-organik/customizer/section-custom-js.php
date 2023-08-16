<?php
$section  = 'custom_code_js';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'     => 'code',
	'settings' => 'custom_js',
	'section'  => $section,
	'priority' => $priority ++,
	'choices'  => array(
		'language' => 'javascript',
	),
	'default'  => 'jQuery(document).ready(function ($) {});',
) );

Kiki::add_field( 'theme', array(
	'type'     => 'toggle',
	'settings' => 'custom_js_enable',
	'label'    => esc_html__( 'Enable', 'tm-organik' ),
	'section'  => $section,
	'priority' => $priority ++,
	'default'  => 1,
) );
