<?php

// Exit if accessed directly
if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

/**
 * Helper funtions
 *
 * @package   InsightFramework
 */
class Insight_Helper {

	static public $img_width;
	static public $img_height;
	static public $class_name;

	public static function get_post_meta( $name, $default = false ) {
		$post_meta = unserialize( get_post_meta( get_the_ID(), 'insight_page_options', true ) );

		return isset( $post_meta[ $name ] ) ? $post_meta[ $name ] : $default;
	}

	public static function get_post_meta_by_id( $post_id, $name, $default = false ) {
		$post_meta = unserialize( get_post_meta( $post_id, 'insight_page_options', true ) );

		return isset( $post_meta[ $name ] ) ? $post_meta[ $name ] : $default;
	}

	/**
	 * @return array|int|WP_Error
	 */
	public static function get_all_menus() {
		$args      = array(
			'hide_empty' => true,
			'fields'     => 'id=>name',
			'slug'       => '',
		);
		$menus     = get_terms( 'nav_menu', $args );
		$menus[''] = esc_html__( 'Default Menu', 'tm-organik' );

		return $menus;
	}

	/**
	 * @param bool $default_option
	 *
	 * @return array
	 */
	public static function get_registered_sidebars( $default_option = false ) {
		global $wp_registered_sidebars;
		$sidebars = array();
		if ( $default_option == true ) {
			$sidebars['default'] = esc_html__( 'Default', 'tm-organik' );
		}
		foreach ( $wp_registered_sidebars as $sidebar ) {
			$sidebars[ $sidebar['id'] ] = $sidebar['name'];
		}

		return $sidebars;
	}

	/**
	 * Get list page layout
	 *
	 * @return array
	 */
	public static function get_list_page_layout() {
		return array(
			'fullwidth'       => INSIGHT_THEME_URI . '/assets/admin/images/1c.png',
			'content-sidebar' => INSIGHT_THEME_URI . '/assets/admin/images/2cr.png',
			'sidebar-content' => INSIGHT_THEME_URI . '/assets/admin/images/2cl.png',
		);
	}

	/**
	 *
	 * @return string
	 */
	public static function add_style( $style, $property, $value, $contain_value = '' ) {
		if ( empty( $style ) ) {
			$style = '';
		}
		$style .= $property . ':' . $contain_value . $value . $contain_value . ';';

		return $style;
	}

	/**
	 *
	 * @return string
	 */
	public static function apply_style( $style, $selector, $echo = true ) {
		if ( empty( $style ) ) {
			return;
		}
		$style = $selector . '{' . $style . '}';
		if ( $echo ) {
			self::add_style_to_head( $style );
		} else {
			return $style;
		}
	}

	/**
	 *
	 * @return string
	 */
	public static function add_style_to_head( $style, $echo = true ) {
		//$script = '<style id=\'' . uniqid( 'custom-style-' ) . '\' scoped>' . $style . '</style>';
		$script = '<script id=\'' . uniqid( 'custom-style-' ) . '\' type=\'text/javascript\'>';
		$script .= '(function($) {';
		$script .= '$(document).ready(function() {';
		$script .= '$("head").append("<style>' . str_replace( '"', "'", $style ) . '</style>");';
		//$script .= 'document.writeln("'.$style.'");';
		$script .= '});';
		$script .= '})(jQuery);';
		$script .= '</script>';
		if ( $echo ) {
			echo '' . $script;
		} else {
			return $script;
		}
	}

	/**
	 *
	 * @return string
	 */
	public static function esc_js( $string ) {
		return str_replace( "\n", '\n', str_replace( '"', '\"', addcslashes( str_replace( "\r", '', (string) $string ), "\0..\37" ) ) );
	}

	/**
	 *
	 * @return string
	 */
	public static function base_decode( $string ) {
		return call_user_func( 'base' . '64' . '_' . 'decode', $string );
	}

	/**
	 *
	 * @return string
	 */
	public static function rgbaToHexUltimate( $r, $g, $b ) {
		$hex = "#";
		$hex .= str_pad( dechex( $r ), 2, "0", STR_PAD_LEFT );
		$hex .= str_pad( dechex( $g ), 2, "0", STR_PAD_LEFT );
		$hex .= str_pad( dechex( $b ), 2, "0", STR_PAD_LEFT );

		return $hex;
	}

	/**
	 *
	 * @return context
	 */
	public static function output( $string ) {
		echo '' . $string;
	}

	/**
	 *
	 * @return string
	 */
	public static function img_fullsize( $id ) {
		$img = wp_get_attachment_image_src( $id, 'full' );

		return $img[0];
	}

	/**
	 *
	 * @return string
	 * $params array('height' => '', 'width' => '')
	 */
	public static function img_thumb( $id, $params ) {
		//$image = self::img_fullsize( $id );
		$size = 'full';
		if ( isset( $params['height'] ) && isset( $params['width'] ) ) {
			$size = array( $params['width'], $params['height'] );
		}
		$image = wp_get_attachment_image_src( $id, $size );

		return $image[0];
	}

	/**
	 *
	 * @return array
	 */
	public static function get_param( $param_name, $group = 'Design Options', $dependency = '' ) {
		$param = array();
		switch ( $param_name ) {
			case 'el_class':
				$param = array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Extra class name', 'tm-organik' ),
					'description' => esc_html__( 'Style particular content element differently - add a class name and refer to it in custom CSS.', 'tm-organik' ),
					'param_name'  => 'el_class',
					'admin_label' => true,
				);
				break;
			case 'css':
				$param = array(
					'type'       => 'css_editor',
					'heading'    => esc_html__( 'CSS', 'tm-organik' ),
					'param_name' => 'css',
					'group'      => $group,
				);
				break;
			case 'animation':
				$param = array(
					'group'       => $group,
					'type'        => 'dropdown',
					'heading'     => esc_html__( 'Animation', 'tm-organik' ),
					'desc'        => esc_html__( 'Select type of animation for element to be animated when it "enters" the browsers viewport (Note: works only in modern browsers).',
						'tm-organik' ),
					'param_name'  => 'animation',
					'value'       => array(
						esc_html__( 'None', 'tm-organik' )             => '',
						esc_html__( 'Fade In', 'tm-organik' )          => 'fade-in',
						esc_html__( 'Move Up', 'tm-organik' )          => 'move-up',
						esc_html__( 'Move Down', 'tm-organik' )        => 'move-down',
						esc_html__( 'Move Left', 'tm-organik' )        => 'move-left',
						esc_html__( 'Move Right', 'tm-organik' )       => 'move-right',
						esc_html__( 'Scale Up', 'tm-organik' )         => 'scale-up',
						esc_html__( 'Fall Perspective', 'tm-organik' ) => 'fall-perspective',
						esc_html__( 'Fly', 'tm-organik' )              => 'fly',
						esc_html__( 'Flip', 'tm-organik' )             => 'flip',
						esc_html__( 'Helix', 'tm-organik' )            => 'helix',
						esc_html__( 'Pop Up', 'tm-organik' )           => 'pop-up',
					),
					'std'         => 'move-up',
					'admin_label' => true,
				);
				break;
			case 'note':
				$param = array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Note', 'tm-organik' ),
					'param_name'  => 'note',
					'group'       => esc_html__( 'Note', 'tm-organik' ),
					'description' => esc_html__( 'Describe more about this element. This text just appearance in the page editor for you more easy to manage the content.', 'tm-organik' ),
					'admin_label' => true,
				);
				break;
			case 'title':
				$param = array(
					'type'        => 'textfield',
					'heading'     => esc_html__( 'Title', 'tm-organik' ),
					'param_name'  => 'title',
					'admin_label' => true,
				);
				break;
			case 'element_tag':
				$param = array(
					'type'        => 'dropdown',
					'class'       => '',
					'heading'     => esc_html__( 'Element tag', 'tm-organik' ),
					'description' => esc_html__( 'Select element tag.', 'tm-organik' ),
					'param_name'  => 'element_tag',
					'value'       => array(
						'Default' => '',
						'h1'      => 'h1',
						'h2'      => 'h2',
						'h3'      => 'h3',
						'h4'      => 'h4',
						'h5'      => 'h5',
						'h6'      => 'h6',
						'p'       => 'p',
						'div'     => 'div',
					),
					'save_always' => true,
				);
				break;
			case 'content':
				$param = array(
					'type'        => 'textarea',
					'heading'     => esc_html__( 'Content', 'tm-organik' ),
					'param_name'  => 'content',
					'admin_label' => true,
				);
				break;
			case 'categories':
				return self::get_categories();
				break;
			case 'woo_categories':
				return self::get_woo_categories( $dependency );
				break;
			case 'woo_categories_dropdown':
				return self::get_woo_categories_dropdown( $dependency );
				break;
			case 'gallery_categories':
				return self::get_gallery_categories();
				break;
			case 'sale_products':
				return self::get_sale_products();
				break;
		}

		return $param;
	}

	/**
	 *
	 * @return array
	 */
	public static function get_value_num( $min = 1, $max = 10, $default = 1 ) {
		$value_num                                          = array();
		$value_num[ esc_html__( 'Default', 'tm-organik' ) ] = $default;
		for ( $i = $min; $i <= $max; $i ++ ) {
			$value_num[ $i ] = $i;
		}

		return $value_num;
	}

	/**
	 *
	 * @return array
	 */
	public static function fonticon( $fontname ) {
		$font_array = array();
		switch ( $fontname ) {
			case 'fontawesome':
				$font_array = array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'tm-organik' ),
					'param_name'  => 'icon_fontawesome',
					'value'       => 'fas fa-adjust', // default value to backend editor admin_label
					'settings'    => array(
						'emptyIcon'    => false,
						// default true, display an "EMPTY" icon?
						'iconsPerPage' => 4000,
						// default 100, how many icons per/page to display, we use (big number) to display all icons in single page
					),
					'dependency'  => array(
						'element' => 'icon_lib',
						'value'   => 'fontawesome',
					),
					'description' => esc_html__( 'Select icon from library.', 'tm-organik' ),
				);
				break;

			case 'openiconic':
				$font_array = array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'tm-organik' ),
					'param_name'  => 'icon_openiconic',
					'value'       => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
					'settings'    => array(
						'emptyIcon'    => false, // default true, display an "EMPTY" icon?
						'type'         => 'openiconic',
						'iconsPerPage' => 4000, // default 100, how many icons per/page to display
					),
					'dependency'  => array(
						'element' => 'icon_lib',
						'value'   => 'openiconic',
					),
					'description' => esc_html__( 'Select icon from library.', 'tm-organik' ),
				);
				break;
			case 'typicons':
				$font_array = array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'tm-organik' ),
					'param_name'  => 'icon_typicons',
					'value'       => 'vc-oi vc-oi-dial', // default value to backend editor admin_label
					'settings'    => array(
						'emptyIcon'    => false, // default true, display an "EMPTY" icon?
						'type'         => 'typicons',
						'iconsPerPage' => 4000, // default 100, how many icons per/page to display
					),
					'dependency'  => array(
						'element' => 'icon_lib',
						'value'   => 'typicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'tm-organik' ),
				);
				break;
			case 'entypo':
				$font_array = array(
					'type'       => 'iconpicker',
					'heading'    => esc_html__( 'Icon', 'tm-organik' ),
					'param_name' => 'icon_entypo',
					'value'      => 'entypo-icon entypo-icon-note', // default value to backend editor admin_label
					'settings'   => array(
						'emptyIcon'    => false, // default true, display an "EMPTY" icon?
						'type'         => 'entypo',
						'iconsPerPage' => 4000, // default 100, how many icons per/page to display
					),
					'dependency' => array(
						'element' => 'icon_lib',
						'value'   => 'entypo',
					),
				);
				break;
			case 'linecons':
				$font_array = array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'tm-organik' ),
					'param_name'  => 'icon_linecons',
					'value'       => 'vc_li vc_li-heart', // default value to backend editor admin_label
					'settings'    => array(
						'emptyIcon'    => false, // default true, display an "EMPTY" icon?
						'type'         => 'linecons',
						'iconsPerPage' => 4000, // default 100, how many icons per/page to display
					),
					'dependency'  => array(
						'element' => 'icon_lib',
						'value'   => 'linecons',
					),
					'description' => esc_html__( 'Select icon from library.', 'tm-organik' ),
				);
				break;
			case 'ionicons':
				$font_array = array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'tm-organik' ),
					'param_name'  => 'icon_ionicons',
					'value'       => 'ion-ionic',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'ionicons',
						'iconsPerPage' => 4000,
					),
					'dependency'  => array(
						'element' => 'icon_lib',
						'value'   => 'ionicons',
					),
					'description' => esc_html__( 'Select icon from library.', 'tm-organik' ),
				);
				break;
			case 'organik':
				$font_array = array(
					'type'        => 'iconpicker',
					'heading'     => esc_html__( 'Icon', 'tm-organik' ),
					'param_name'  => 'icon_organik',
					'value'       => 'organik-apple',
					'settings'    => array(
						'emptyIcon'    => false,
						'type'         => 'organik',
						'iconsPerPage' => 40,
					),
					'dependency'  => array(
						'element' => 'icon_lib',
						'value'   => 'organik',
					),
					'description' => esc_html__( 'Select icon from library.', 'tm-organik' ),
				);
				break;
		}

		return $font_array;
	}

	public static function get_categories() {
		$args = array(
			'taxonomy'   => 'category',
			'hide_empty' => false,
		);

		$terms = get_categories( $args );

		$categories = array();

		foreach ( $terms as $key => $term ) {
			$categories[ $term->name ] = $term->slug;
		}

		return array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Categories', 'tm-organik' ),
			'value'       => $categories,
			'param_name'  => 'categories',
			'admin_label' => true,
		);
	}

	public static function get_woo_categories( $dependency = '' ) {
		$args = array(
			'taxonomy'   => 'product_cat',
			'hide_empty' => false,
		);

		$terms = get_categories( $args );

		$categories = array();

		foreach ( $terms as $key => $term ) {
			$categories[ $term->name ] = $term->slug;
		}

		return array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Categories', 'tm-organik' ),
			'value'       => $categories,
			'param_name'  => 'categories',
			'admin_label' => true,
			'dependency'  => $dependency
		);
	}

	public static function get_woo_categories_dropdown( $dependency = '' ) {
		$terms      = get_terms( 'product_cat', array() );
		$categories = array();
		if ( isset( $terms ) && ! empty( $terms ) ) {
			foreach ( $terms as $key => $term ) {
				if ( isset( $term->slug ) ) {
					$categories[ $term->name ] = $term->slug;
				}
			}
		}

		return array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Category', 'tm-organik' ),
			'value'       => $categories,
			'param_name'  => 'category',
			'description' => esc_html__( 'Product category list', 'tm-organik' ),
			'admin_label' => true,
			'dependency'  => $dependency
		);
	}

	public static function get_gallery_categories( $dependency = '' ) {
		$terms      = get_terms( 'gallery_category', array() );
		$categories = array();
		if ( isset( $terms ) && ! empty( $terms ) ) {
			foreach ( $terms as $key => $term ) {
				if ( isset( $term->slug ) ) {
					$categories[ $term->name ] = $term->slug;
				}
			}
		}

		return array(
			'type'        => 'checkbox',
			'heading'     => esc_html__( 'Categories', 'tm-organik' ),
			'value'       => $categories,
			'param_name'  => 'categories',
			'admin_label' => true,
			'dependency'  => $dependency,
		);
	}

	public static function get_sale_products() {
		$sale_products = array();
		$params        = array(
			'posts_per_page'      => - 1,
			'post_type'           => 'product',
			'ignore_sticky_posts' => 1,
			'stock'               => 1,
			'meta_query'          => array(
				'relation' => 'or',
				array(
					'key'     => '_sale_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'numeric'
				),
				array(
					'key'     => '_min_variation_sale_price',
					'value'   => 0,
					'compare' => '>',
					'type'    => 'numeric'
				)
			)
		);
		$product_loop  = new WP_Query( $params );
		if ( $product_loop->have_posts() ) {
			while ( $product_loop->have_posts() ) {
				$product_loop->the_post();
				$sale_products[ get_the_title() ] = get_the_ID();
			}
			wp_reset_postdata();
		}

		return array(
			'type'        => 'dropdown',
			'heading'     => esc_html__( 'Product', 'tm-organik' ),
			'value'       => $sale_products,
			'param_name'  => 'product_id',
			'admin_label' => true,
		);
	}

	public static function mark_product_viewed( $pid ) {
		$viewed_cookie = '';
		if ( isset( $_COOKIE['tm_organik_viewed_products'] ) ) {
			$viewed        = array_reverse( explode( ',', $_COOKIE['tm_organik_viewed_products'] ) );
			$viewed[]      = $pid;
			$viewed        = array_unique( array_reverse( $viewed ) );
			$viewed_cookie = implode( ',', $viewed );
		} else {
			$viewed_cookie = $pid;
		}
		setcookie( 'tm_organik_viewed_products', $viewed_cookie, time() + 60 * 60 * 24 * 7, '/' );
	}

	public static function nice_class( $class ) {
		return trim( preg_replace( '/\s+/', ' ', $class ) );
	}

	/* Get inline CSS */
	public static function get_css_prefix( $property, $value ) {
		$css = '';
		switch ( $property ) {
			case 'border-radius' :
				$css = "-moz-border-radius: {$value};-webkit-border-radius: {$value};border-radius: {$value};";
				break;

			case 'box-shadow' :
				$css = "-moz-box-shadow: {$value};-webkit-box-shadow: {$value};box-shadow: {$value};";
				break;

			case 'order' :
				$css = "-webkit-order: $value; -moz-order: $value; order: $value;";
				break;
		}

		return $css;
	}
}
