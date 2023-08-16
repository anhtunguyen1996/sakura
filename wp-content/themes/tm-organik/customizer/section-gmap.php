<?php
$section  = 'gmap';
$priority = 1;

Kiki::add_field( 'theme', array(
	'type'        => 'text',
	'settings'    => 'gmap_api_key',
	'label'       => esc_html__( 'Google Map API Key', 'tm-organik' ),
	'description' => esc_html__( 'Enter the API key for Google Map.', 'tm-organik' ),
	'section'     => $section,
	'priority'    => $priority ++,
	'default'     => 'AIzaSyA2gHgnwnas_j_283ngFLGzpVffPH9wiHM',
) );
