<?php
/*
 * Example
	array(
		'type' => 'toggle',
		'heading' => esc_html__('Test toggle', 'tm-organik'),
		'param_name' => 'enable_overlay',
		'value' => '',
		'options' => array(
			'enable' => array(
				'label' => '',
				'on' => esc_html__('Yes', 'tm-organik'),
				'off' => esc_html__('No', 'tm-organik'),
			),
		),
	),
*/
if ( ! class_exists( 'TM_Toggle_Param' ) ) {
	class TM_Toggle_Param {
		function __construct() {
			if ( class_exists( 'WpbakeryShortcodeParams' ) ) {
				WpbakeryShortcodeParams::addField( 'toggle', array( $this, 'checkbox_param' ) );
			}
		}

		function checkbox_param( $settings, $value ) {
			$dependency  = '';
			$param_name  = isset( $settings['param_name'] ) ? $settings['param_name'] : '';
			$type        = isset( $settings['type'] ) ? $settings['type'] : '';
			$options     = isset( $settings['options'] ) ? $settings['options'] : '';
			$class       = isset( $settings['class'] ) ? $settings['class'] : '';
			$default_set = isset( $settings['default_set'] ) ? $settings['default_set'] : false;
			$output      = $checked = '';
			$un          = uniqid( 'tmswitch-' . rand() );
			if ( is_array( $options ) && ! empty( $options ) ) {
				foreach ( $options as $key => $opts ) {
					if ( $value == $key ) {
						$checked = "checked";
					} else {
						$checked = "";
					}
					$uid    = uniqid( 'tmswitchparam-' . rand() );
					$output .= '<div class="onoffswitch">
							<input type="checkbox" name="' . $param_name . '" value="' . $value . '" ' . $dependency . ' class="wpb_vc_param_value ' . $param_name . ' ' . $type . ' ' . $class . ' ' . $dependency . ' onoffswitch-checkbox chk-switch-' . $un . '" id="switch' . $uid . '" ' . $checked . '>
							<label class="onoffswitch-label" for="switch' . $uid . '">
								<div class="onoffswitch-inner">
									<div class="onoffswitch-active">
										<div class="onoffswitch-switch">' . $opts['on'] . '</div>
									</div>
									<div class="onoffswitch-inactive">
										<div class="onoffswitch-switch">' . $opts['off'] . '</div>
									</div>
								</div>
							</label>
						</div>';
					if ( isset( $opts['label'] ) ) {
						$lbl = $opts['label'];
					} else {
						$lbl = '';
					}
					$output .= '<div class="chk-label">' . $lbl . '</div><br/>';
				}
			}

			if ( $default_set ) {
				$set_value = 'off';
			} else {
				$set_value = '';
			}

			$output .= '<script type="text/javascript">
				jQuery("#switch' . $uid . '").change(function(){

					 if(jQuery("#switch' . $uid . '").is(":checked")){
						jQuery("#switch' . $uid . '").val("' . $key . '");
						jQuery("#switch' . $uid . '").attr("checked","checked");
					 } else {
						jQuery("#switch' . $uid . '").val("' . $set_value . '");
						jQuery("#switch' . $uid . '").removeAttr("checked");
					 }

				});
			</script>';

			return $output;
		}

	}
}

if ( class_exists( 'TM_Toggle_Param' ) ) {
	$TM_Toggle_Param = new TM_Toggle_Param();
}
