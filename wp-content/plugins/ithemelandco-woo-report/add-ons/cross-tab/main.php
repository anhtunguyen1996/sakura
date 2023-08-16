<?php
/*
Plugin Name: PW Advanced Woo Reporting CrossTab ADD-ON
Plugin URI: https://ithemelandco.com/plugins/woocommerce-report/
Description: This add-on adds extra reports(CrossTab) to the main plugins(Advanced Woocommerce Reporting).
Version: 1.3
Author: iThemelandCo
Author URI: https://ithemelandco.com
Text Domain: it_report_wcreport_textdomain
Domain Path: /languages/
*/

/*
V1.3 : Update : Add PAYMENT METHON IN Variation Per Month & Product Prt Month
V1.2 : Update : Compatible with PW Advanced Woo Reporting ver 4.0
 */

define("__IT_CROSSTABB_ADD_ON__",'');
define( '__IT_REPORT_WCREPORT_ROOT_DIR_CROSSTABB_ADD_ON__', dirname(__FILE__));
define ('__IT_REPORT_WCREPORT_URL_CROSSTABB_ADD_ON__',plugins_url('', __FILE__));

if(!class_exists('it_report_wcreport_crosstab_addon_class')){

	class it_report_wcreport_crosstab_addon_class{

		function __construct(){
			add_action( 'it_report_wcreport_admin_menu', array($this,'add_cross_menu' ));
			add_filter( 'it_report_wcreport_page_fetch_menu', array($this,'add_fetch_page_cross_menu'));
			add_filter( 'it_report_wcreport_page_titles', array($this,'add_page_titles') );
		}

		function add_page_titles($page_titles){

			$page_titles['prod_per_month']= __( "Product per Month",__IT_REPORT_WCREPORT_TEXTDOMAIN__);
			$page_titles['variation_per_month']= __( "Variation per Month",__IT_REPORT_WCREPORT_TEXTDOMAIN__);
			$page_titles['prod_per_country']= __( "Product per Country",__IT_REPORT_WCREPORT_TEXTDOMAIN__);
			$page_titles['prod_per_state']= __( "Product per State",__IT_REPORT_WCREPORT_TEXTDOMAIN__);
			$page_titles['country_per_month']= __( "Country per Month",__IT_REPORT_WCREPORT_TEXTDOMAIN__);
			$page_titles['payment_per_month']= __( "Payment per Month",__IT_REPORT_WCREPORT_TEXTDOMAIN__);
			$page_titles['ord_status_per_month']= __( "Order Status per Month",__IT_REPORT_WCREPORT_TEXTDOMAIN__);
			$page_titles['summary_per_month']= __( "Summary per Month",__IT_REPORT_WCREPORT_TEXTDOMAIN__);

			return $page_titles;
		}

		function add_cross_menu() {
			global $it_rpt_main_class;
			$role_capability=$it_rpt_main_class->get_capability();

			//CROSS TABS
			add_submenu_page(null, __('Prod./Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), __('Prod./Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), $role_capability, 'wcx_wcreport_plugin_prod_per_month',   array($this,'wcx_plugin_menu_prod_per_month' ) );
			add_submenu_page(null, __('Variation/Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), __('Variation/Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), $role_capability, 'wcx_wcreport_plugin_variation_per_month',   array($this,'wcx_plugin_menu_variation_per_month' ) );
			add_submenu_page(null, __('Prod./Country',__IT_REPORT_WCREPORT_TEXTDOMAIN__), __('Prod./Country',__IT_REPORT_WCREPORT_TEXTDOMAIN__), $role_capability, 'wcx_wcreport_plugin_prod_per_country',   array($this,'wcx_plugin_menu_prod_per_country' ) );
			add_submenu_page(null, __('Prod./State',__IT_REPORT_WCREPORT_TEXTDOMAIN__), __('Prod./State',__IT_REPORT_WCREPORT_TEXTDOMAIN__), $role_capability, 'wcx_wcreport_plugin_prod_per_state',   array($this,'wcx_plugin_menu_prod_per_state' ) );
			add_submenu_page(null, __('Country/Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), __('Country/Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), $role_capability, 'wcx_wcreport_plugin_country_per_month',   array($this,'wcx_plugin_menu_country_per_month' ) );
			add_submenu_page(null, __('Payment G/Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), __('Payment G/Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), $role_capability, 'wcx_wcreport_plugin_payment_per_month',   array($this,'wcx_plugin_menu_payment_per_month' ) );
			add_submenu_page(null, __('Ord. Status/Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), __('Ord. Status/Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), $role_capability, 'wcx_wcreport_plugin_ord_status_per_month',   array($this,'wcx_plugin_menu_ord_status_per_month' ) );
			/*add_submenu_page(null, __('Summary/Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), __('Summary/Month',__IT_REPORT_WCREPORT_TEXTDOMAIN__), 'manage_options', 'wcx_wcreport_plugin_summary_per_month',   array($this,'wcx_plugin_menu_summary_per_month' ) );*/

		}

		//////////////////////CROSS TABS//////////////////////
		//1-PROD./MONTH
		function wcx_plugin_menu_prod_per_month(){
			global $it_rpt_main_class;
			$it_rpt_main_class->pages_fetch(__IT_REPORT_WCREPORT_ROOT_DIR_CROSSTABB_ADD_ON__."/class/prod_per_month.php");
		}
		//2-VARIATION/MONTH
		function wcx_plugin_menu_variation_per_month(){
			global $it_rpt_main_class;
			$it_rpt_main_class->pages_fetch(__IT_REPORT_WCREPORT_ROOT_DIR_CROSSTABB_ADD_ON__."/class/variation_per_month.php");
		}

		//3-Prod.Country
		function wcx_plugin_menu_prod_per_country(){
			global $it_rpt_main_class;
			$it_rpt_main_class->pages_fetch(__IT_REPORT_WCREPORT_ROOT_DIR_CROSSTABB_ADD_ON__."/class/prod_per_country.php");
		}

		//4-prod./State
		function wcx_plugin_menu_prod_per_state(){
			global $it_rpt_main_class;
			$it_rpt_main_class->pages_fetch(__IT_REPORT_WCREPORT_ROOT_DIR_CROSSTABB_ADD_ON__."/class/prod_per_state.php");
		}

		//5-VARIATION/MONTH
		function wcx_plugin_menu_country_per_month(){
			global $it_rpt_main_class;
			$it_rpt_main_class->pages_fetch(__IT_REPORT_WCREPORT_ROOT_DIR_CROSSTABB_ADD_ON__."/class/country_per_month.php");
		}
		//6-PAYMENT G/MONTH
		function wcx_plugin_menu_payment_per_month(){
			global $it_rpt_main_class;
			$it_rpt_main_class->pages_fetch(__IT_REPORT_WCREPORT_ROOT_DIR_CROSSTABB_ADD_ON__."/class/payment_per_month.php");
		}
		//7-ORD STATUS/MONTH
		function wcx_plugin_menu_ord_status_per_month(){
			global $it_rpt_main_class;
			$it_rpt_main_class->pages_fetch(__IT_REPORT_WCREPORT_ROOT_DIR_CROSSTABB_ADD_ON__."/class/ord_status_per_month.php");
		}
		//8-SUMMARY/MONTH
		function wcx_plugin_menu_summary_per_month(){
			global $it_rpt_main_class;
			$it_rpt_main_class->pages_fetch(__IT_REPORT_WCREPORT_ROOT_DIR_CROSSTABB_ADD_ON__."/class/summary_per_month.php");
		}

		//CHANGE FETCH MENU VISIBLE MENUS
		function add_fetch_page_cross_menu( $visible_menu ) {
			$crosstab_menu=array(
					"label" => __('CrossTab',__IT_REPORT_WCREPORT_TEXTDOMAIN__),
					"id" => "cross_tab",
					"link" => "#",
					"icon" => "fa-random",
					"childs" => array(
						"prod_per_month" => array(
							"label" => __("Product/Month" ,__IT_REPORT_WCREPORT_TEXTDOMAIN__),
							"id" => "prod_per_month",
							"link" => "admin.php?page=wcx_wcreport_plugin_prod_per_month&parent=cross_tab&smenu=prod_per_month",
							"icon" => "fa-cog",
						),
						"variation_per_month" => array(
							"label" => '<span style="color:#d97c7c">'.__("Variation/Month(Pro)" ,__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</span>',
							"id" => "variation_per_month",
							"link" => "#",
							"icon" => "fa-line-chart",
						),
						"prod_per_country" => array(
							"label" => __("Product/Country" ,__IT_REPORT_WCREPORT_TEXTDOMAIN__),
							"id" => "prod_per_country",
							"link" => "admin.php?page=wcx_wcreport_plugin_prod_per_country&parent=cross_tab&smenu=prod_per_country",
							"icon" => "fa-globe",
						),
						"prod_per_state" => array(
							"label" => '<span style="color:#d97c7c">'.__("Product/State(Pro)" ,__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</span>',
							"id" => "prod_per_state",
							"link" => "#",
							"icon" => "fa-map",
						),
						"country_per_month" => array(
							"label" => '<span style="color:#d97c7c">'.__("Country/Month(Pro)" ,__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</span>',
							"id" => "country_per_month",
							"link" => "#",
							"icon" => "fa-globe",
						),
						"payment_per_month" => array(
							"label" => '<span style="color:#d97c7c">'.__("Payment Gateway/Month(Pro)" ,__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</span>',
							"id" => "payment_per_month",
							"link" => "#",
							"icon" => "fa-cog",
						),
						"order_status_per_month" => array(
							"label" => '<span style="color:#d97c7c">'.__("Order Status/Month(Pro)" ,__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</span>',
							"id" => "order_status_per_month",
							"link" => "#",
							"icon" => "fa-check",
						),
					)
				);

			global $it_rpt_main_class;
			$it_rpt_main_class->our_menu=$it_rpt_main_class->array_insert_after("more_reports",$it_rpt_main_class->our_menu,"cross_tab",$crosstab_menu);
			$visible_menu=$it_rpt_main_class->our_menu;
			return $visible_menu;
		}

	}
	new it_report_wcreport_crosstab_addon_class;
}
?>
