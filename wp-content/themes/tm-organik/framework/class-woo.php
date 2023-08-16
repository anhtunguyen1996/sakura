<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Custom functions for WooCommerce
 *
 * @package   InsightFramework
 */
class Insight_Woo {

	/**
	 * The constructor.
	 */
	public function __construct() {
		add_filter( 'woocommerce_add_to_cart_fragments', array( $this, 'woo_header_cart_fragment' ) );
		add_filter( 'subcategory_archive_thumbnail_size', array( $this, 'woo_subcategory_archive_thumbnail_size' ) );
		add_action( 'wp_footer', array( $this, 'woo_footer_actions' ) );

		// Hide default smart wishlist button
		add_filter( 'woosw_button_position_archive', function() {
			return '0';
		} );
		add_filter( 'woosw_button_position_single', function() {
			return '0';
		} );
		add_filter( 'woosw_color_default', function() {
			return Insight::PRIMARY_COLOR;
		} );

		// Hide default smart compare button
		add_filter( 'filter_wooscp_button_archive', function() {
			return '0';
		} );
		add_filter( 'filter_wooscp_button_single', function() {
			return '0';
		} );
		add_filter( 'wooscp_bar_btn_color_default', function() {
			return Insight::PRIMARY_COLOR;
		} );

		// Hide default smart quick view button
		add_filter( 'woosq_button_position', function() {
			return '0';
		} );

		// Move section You may be interested in…
		remove_action( 'woocommerce_cart_collaterals', 'woocommerce_cross_sell_display' );
		add_action( 'woocommerce_after_cart_table', 'woocommerce_cross_sell_display' );

		// Ajax tab
		add_action( 'wp_ajax_insight_ajax_load_more_tab', array( $this, 'ajax_load_more_tab' ) );
		add_action( 'wp_ajax_nopriv_insight_ajax_load_more_tab', array( $this, 'ajax_load_more_tab' ) );
	}

	public function ajax_load_more_tab() {
		$args = array(
			'post_type'      => 'product',
			'posts_per_page' => isset( $_POST['perpage'] ) ? $_POST['perpage'] : 10,
			'paged'          => isset( $_POST['page'] ) ? $_POST['page'] : 1,
			'order'          => isset( $_POST['order'] ) ? $_POST['order'] : '',
			'orderby'        => isset( $_POST['orderby'] ) ? $_POST['orderby'] : ''
		);

		if ( isset( $_POST['cat'] ) && ( $_POST['cat'] != '*' ) ) {
			$args['product_cat'] = $_POST['cat'];
		}

		$query = new WP_Query( $args );
		if ( $query->have_posts() ) {
			while ( $query->have_posts() ) {
				$query->the_post();
				wc_get_template_part( 'content', 'product' );
			}
		} else {
			echo 'end';
		}

		die();
	}

	public static function header_wishlist() {
		$wishlist_html = '<a href="' . WPcleverWoosw::get_url() . '"><span class="wishlist-btn" data-count="' . WPcleverWoosw::get_count() . '"></span></a>';

		return $wishlist_html;
	}

	public static function header_cart( $mobile = false ) {
		if ( class_exists( 'WooCommerce' ) ) {
			$cart_url  = wc_get_cart_url();
			$qty       = WC()->cart->get_cart_contents_count();
			$total     = WC()->cart->get_cart_subtotal();
			$cart_html = '';

			if ( $mobile ) {
				$cart_html .= '<a href="' . esc_url( $cart_url ) . '">';
				$cart_html .= '<div class="mini-cart"><div class="mini-cart-icon" data-count="' . $qty . '"><i class="ion-bag"></i></div>';
				$cart_html .= '<div class="mini-cart-text">' . esc_html__( 'My Cart', 'tm-organik' ) . '<div class="mini-cart-total">' . $total . '</div></div></div>';
				$cart_html .= '</a>';
			} else {
				$cart_html .= '<div class="mini-cart"><div class="mini-cart-icon" data-count="' . $qty . '"><i class="ion-bag"></i></div>';
				$cart_html .= '<div class="mini-cart-text">' . esc_html__( 'My Cart', 'tm-organik' ) . '<div class="mini-cart-total">' . $total . '</div></div></div>';
			}

			return $cart_html;
		}
	}

	function woo_header_cart_fragment( $fragments ) {
		ob_start();
		echo self::header_cart();
		$fragments['.mini-cart'] = ob_get_clean();

		return $fragments;
	}

	function woo_footer_actions() {
		if ( is_singular( 'product' ) ) {
			?>
            <script>
				jQuery( document ).ready( function() {
					insightMarkProductViewed(<?php echo get_the_ID(); ?>);
				} );
            </script>
			<?php
		}
	}

	function woo_subcategory_archive_thumbnail_size() {
		return 'full';
	}
}
