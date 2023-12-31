<?php
/**
 * Date: 6/10/2017
 * Desc : For Mail sending
 */

if ( ! defined( 'ABSPATH' ) ) exit; // Exit if accessed directly

if(!class_exists('IT_send_mail_schedule')){
	class IT_send_mail_schedule{

		var $constants = array();

		public function __construct() {

			add_filter('cron_schedules',array($this, 'cron_schedules'),10, 1);
			add_action('wp', array( $this, 'wp_next_scheduled'));

			add_action(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.'_schedule_mailing_sales_status_event', array($this, 'schedule_mailing_sales_status_cron'));
			add_action(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.'_schedule_event', array($this, 'schedule_event_cron'));

		}

		function schedule_mailing_sales_status_cron(){
			global $it_rpt_main_class;
			$it_rpt_main_class->wcx_send_email_schedule();
		}

		function wp_next_scheduled(){

			global $it_rpt_main_class;

			$original_args 					= array();
			$timestamp 						= time();

			$schedule_activate				= $it_rpt_main_class->get_options(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.'active_email' , 0);
			$schedule_recurrence			= $it_rpt_main_class->get_options(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.'email_schedule' , 0);
			$schedule_hook_name				= __IT_REPORT_WCREPORT_FIELDS_PERFIX__.'_schedule_mailing_sales_status_event';

			if($schedule_activate == 1 and strlen($schedule_recurrence) > 2){
				if (!wp_next_scheduled($schedule_hook_name)){
					wp_schedule_event($timestamp, $schedule_recurrence, $schedule_hook_name);
				}
			}else{
				wp_unschedule_event( $timestamp, $schedule_hook_name, $original_args );
				wp_clear_scheduled_hook( $schedule_hook_name, $original_args );
			}

			if(!wp_next_scheduled(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.'_schedule_event')){
				wp_schedule_event($timestamp, 'weekly', __IT_REPORT_WCREPORT_FIELDS_PERFIX__.'_schedule_event');
			}
		}

		function schedule_event_cron(){
			global $it_rpt_main_class;
			$it_rpt_main_class->it_cron_event_schedule();
		}

		function cron_schedules($schedules){

			$schedules['it_schd_hourly']		= isset($schedules['it_schd_hourly']) 		? $schedules['it_schd_hourly'] 		:	array('interval'=>	HOUR_IN_SECONDS,		'display'=> esc_html__('iThemelandCo Once Hourly'));

			$schedules['it_schd_daily']			= isset($schedules['it_schd_daily']) 		? $schedules['it_schd_daily'] 		:	array('interval'=>	DAY_IN_SECONDS,			'display'=> esc_html__('iThemelandCo Once Daily'));

			$schedules['it_schd_weekly'] 		= isset($schedules['it_schd_weekly']) 		? $schedules['it_schd_weekly'] 		:	array('interval'=>	WEEK_IN_SECONDS,		'display'=> esc_html__('iThemelandCo Once Weekly'));

			$schedules['it_schd_twicehourly']	= isset($schedules['it_schd_twicehourly']) 	? $schedules['it_schd_twicehourly']	:	array('interval'=>	HOUR_IN_SECONDS*2,		'display'=> esc_html__('iThemelandCo Twice Hourly'));

			$schedules['it_schd_twicedaily']	= isset($schedules['it_schd_twicedaily']) 	? $schedules['it_schd_twicedaily'] 	:	array('interval'=>	DAY_IN_SECONDS*2,		'display'=> esc_html__('iThemelandCo Twice Daily'));

			$schedules['it_schd_twiceweekly']	= isset($schedules['it_schd_twiceweekly']) 	? $schedules['it_schd_twiceweekly'] :	array('interval'=>	WEEK_IN_SECONDS*2,		'display'=> esc_html__('iThemelandCo Twice Weekly'));

			//$schedules['it_schd_min']	= isset($schedules['it_schd_min']) 	? $schedules['it_schd_min'] :	array('interval'=>	60,		'display'=> esc_html__('iThemelandCo Miniue'));



			return $schedules;
		}

		function set_error_log($str){
			$this->set_error_on();
			error_log("[".date("Y-m-d H:i:s")."] PHP Notice: \t".$str."\n",3,$this->log_destination);
		}

		var $error_on = NULL;

		var $log_destination = NULL;

		function set_error_on(){

			if($this->error_on) return '';

			$plugin_path	= __IT_REPORT_WCREPORT_URL__;

			$plugin_path = str_replace("\includes","",$plugin_path);
			$plugin_path = str_replace("/includes","",$plugin_path);

			$error_folder = $plugin_path . '/ic-logerror/';

			if (!file_exists($error_folder)) {
				@mkdir($error_folder, 0777, true);
			}

			$this->log_destination = $error_folder.'wp_error_'.date("Ymd").'.log';

			@ini_set('error_reporting', E_ALL);

			@ini_set('log_errors','On');

			@ini_set('error_log',$this->log_destination);

			$this->error_on = true;
		}

		function set_error_off(){
			@ini_set('log_errors','off');
		}


	}//End Class
	$GLOBALS['IT_send_mail_schedule'] = new IT_send_mail_schedule();
}
