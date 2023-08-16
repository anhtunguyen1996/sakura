<?php
if ( ! class_exists( 'ThemeMove_Social_Links' ) ) {
	/**
	 * Class ThemeMove_Social_Links
	 *
	 * @package tm-organik
	 */
	class ThemeMove_Social_Links {

		private $settings = array();

		private $value = '';

		private $social_networks = array();

		/**
		 * @param $settings
		 * @param $value
		 */
		public function __construct( $settings, $value ) {
			$this->settings = $settings;
			$this->value    = $value;

			$this->social_networks = array(
				'amazon'        => esc_html( 'Amazon', 'tm-organik' ),
				'500px'         => esc_html( '500px', 'tm-organik' ),
				'behance'       => esc_html( 'Behance', 'tm-organik' ),
				'bitbucket'     => esc_html( 'Bitbucket', 'tm-organik' ),
				'codepen'       => esc_html( 'Codepen', 'tm-organik' ),
				'dashcube'      => esc_html( 'Dashcube', 'tm-organik' ),
				'delicious'     => esc_html( 'Delicious', 'tm-organik' ),
				'deviantart'    => esc_html( 'DeviantArt', 'tm-organik' ),
				'digg'          => esc_html( 'Digg', 'tm-organik' ),
				'dribbble'      => esc_html( 'Dribbble', 'tm-organik' ),
				'facebook'      => esc_html( 'Facebook', 'tm-organik' ),
				'flickr'        => esc_html( 'Flickr', 'tm-organik' ),
				'foursquare'    => esc_html( 'Foursquare', 'tm-organik' ),
				'github'        => esc_html( 'Github', 'tm-organik' ),
				'google-plus'   => esc_html( 'Google+', 'tm-organik' ),
				'instagram'     => esc_html( 'Instagram', 'tm-organik' ),
				'linkedin'      => esc_html( 'Linkedin', 'tm-organik' ),
				'odnoklassniki' => esc_html( 'Odnoklassniki', 'tm-organik' ),
				'pinterest'     => esc_html( 'Pinterest', 'tm-organik' ),
				'qq'            => esc_html( 'QQ', 'tm-organik' ),
				'rss'           => esc_html( 'RSS', 'tm-organik' ),
				'reddit'        => esc_html( 'Reddit', 'tm-organik' ),
				'skype'         => esc_html( 'Skype', 'tm-organik' ),
				'slack'         => esc_html( 'Slack', 'tm-organik' ),
				'soundcloud'    => esc_html( 'Soundcloud', 'tm-organik' ),
				'stumbleupon'   => esc_html( 'StumbleUpon', 'tm-organik' ),
				'tripadvisor'   => esc_html( 'Tripadvisor', 'tm-organik' ),
				'tumblr'        => esc_html( 'Tumblr', 'tm-organik' ),
				'twitch'        => esc_html( 'Twitch', 'tm-organik' ),
				'twitter'       => esc_html( 'Twitter', 'tm-organik' ),
				'vine'          => esc_html( 'Vine', 'tm-organik' ),
				'weibo'         => esc_html( 'Weibo', 'tm-organik' ),
				'wikipedia-w'   => esc_html( 'Wikipedia', 'tm-organik' ),
				'whatsapp'      => esc_html( 'WhatsApp', 'tm-organik' ),
				'wordpress'     => esc_html( 'Wordpress', 'tm-organik' ),
				'yahoo'         => esc_html( 'Yahoo', 'tm-organik' ),
				'youtube'  => esc_html( 'Youtube', 'tm-organik' ),
			);
		}

		/**
		 * @return array
		 */
		private function getData() {
			$data     = preg_split( '/\s+/', $this->value );
			$data_arr = array();

			foreach ( $data as $d ) {
				$pieces = explode( '|', $d );
				if ( count( $pieces ) == 2 ) {
					$key              = $pieces[0];
					$link             = $pieces[1];
					$data_arr[ $key ] = $link;
				}
			}

			return $data_arr;
		}

		private function getLink( $key ) {
			$link_arr = $this->getData();
			foreach ( $link_arr as $key1 => $link ) {
				if ( $key == $key1 ) {
					return $link;
				}
			}

			return '';
		}

		/**
		 * Render HTML
		 *
		 * @return string
		 */
		public function render() {
			$html = '';
			$html .= '<div class="tm_social_links" data-social-links="true">
              <input name="' . esc_attr( $this->settings['param_name'] ) . '" class="wpb_vc_param_value ' . esc_attr( $this->settings['param_name'] ) . ' ' . esc_attr( $this->settings['type'] ) . '_field" type="hidden" value="' . esc_attr( $this->value ) . '"/>
             <table class="vc_table tm_table tm_social-links-table">
              <tr data-social="">
                <th>' . esc_html__( 'Social Network', 'tm-organik' ) . '</th>
                <th>' . esc_html__( 'Link', 'tm-organik' ) . '</th>
              </tr>
            ';
			foreach ( $this->social_networks as $key => $social ) {
				$html .= '
            <tr data-social="' . $key . '">
                <td class="tm_social tm_social--' . $key . '">
                    <label><span><i class="fab fa-' . $key . '"></i>' . $social . '</span></label>
                </td>
                <td>
                    <input type="text" name="' . $key . '" class="social_links_field" value="' . $this->getLink( $key ) . '' . '">
                </td>
            </tr>';
			}


			$html .= '</table></div>';

			return $html;
		}
	}
}

if ( class_exists( 'ThemeMove_Social_Links' ) ) {
	/**
	 * Register params
	 *
	 * @param $settings
	 * @param $value
	 *
	 * @return string
	 */
	function thememove_social_links_settings_field( $settings, $value ) {
		$social_links = new ThemeMove_Social_Links( $settings, $value );

		return $social_links->render();
	}

	WpbakeryShortcodeParams::addField( 'social_links', 'thememove_social_links_settings_field', INSIGHT_THEME_URI . '/assets/admin/js/thememove_social_links.js' );
}
