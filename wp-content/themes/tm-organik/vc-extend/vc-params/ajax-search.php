<?php
if ( ! class_exists( 'Insight_Ajax_Search' ) ) {
	class Insight_Ajax_Search {
		function __construct() {
			if ( class_exists( 'WpbakeryShortcodeParams' ) ) {
				WpbakeryShortcodeParams::addField( 'ajax-search', array( $this, 'ajax_search' ) );

				if ( is_admin() ) {
					wp_enqueue_style( 'tokeninput', INSIGHT_THEME_URI . '/assets/admin/libs/tokeninput/styles/token-input-insight.css' );
					wp_enqueue_script( 'tokeninput', INSIGHT_THEME_URI . '/assets/admin/libs/tokeninput/src/jquery.tokeninput.js', array( 'jquery' ), INSIGHT_THEME_VERSION, true );
				}
			}
		}

		function ajax_search( $settings, $value ) {
			$param_name = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$ajax_type  = isset( $settings['ajax_type'] ) ? $settings['ajax_type'] : 'post_type';
			$ajax_get   = isset( $settings['ajax_get'] ) ? $settings['ajax_get'] : 'post';
			$ajax_field = isset( $settings['ajax_field'] ) ? $settings['ajax_field'] : 'id';
			$ajax_limit = isset( $settings['ajax_limit'] ) ? $settings['ajax_limit'] : 10;

			$uni = uniqid( 'tokeninput-' . rand() );

			$pre_populate = '';
			if ( $value != '' ) {
				$value_items = explode( ',', $value );
				if ( $ajax_type == 'post_type' ) {
					foreach ( $value_items as $value_item ) {
						$value_item_info = get_post( $value_item );
						$pre_populate    .= '{id: ' . $value_item_info->ID . ', name: "' . $value_item_info->post_title . '"},';
					}
				} elseif ( $ajax_type == 'taxonomy' ) {
					foreach ( $value_items as $value_item ) {
						$value_item_info = get_term_by( $ajax_field, $value_item, $ajax_get );
						$pre_populate    .= '{id: "' . $value_item . '", name: "' . $value_item_info->name . '"},';
					}
				}
			}

			$output = '<div class="tokeninput">';
			$output .= '<input id="' . $uni . '" name="' . $param_name . '" value="' . $value . '" type="text" class="wpb_vc_param_value" />';
			$output .= '</div>';
			$output .= '<script>jQuery("#' . $uni . '").tokenInput("' . esc_js( admin_url( 'admin-ajax.php' ) ) . '?action=vc_ajax_search_post&ajax_type=' . urlencode( $ajax_type ) . '&ajax_get=' . urlencode( $ajax_get ) . '&ajax_field=' . urlencode( $ajax_field ) . '", {
                prePopulate: [' . $pre_populate . '], tokenLimit: ' . $ajax_limit . '});</script>';

			return $output;
		}

	}
}

if ( class_exists( 'Insight_Ajax_Search' ) ) {
	$Insight_Ajax_Search = new Insight_Ajax_Search();
}
