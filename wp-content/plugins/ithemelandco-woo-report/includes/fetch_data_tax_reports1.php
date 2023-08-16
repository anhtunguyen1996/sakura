<?php
	if($file_used=="sql_table")
	{

		//GET POSTED PARAMETERS
		$start				= 0;
		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
		$date_format = $this->it_date_format($it_from_date);

		$it_sort_by 			= $this->it_get_woo_requests('sort_by','item_name',true);
		$it_order_by 			= $this->it_get_woo_requests('order_by','ASC',true);

		$it_tax_group_by 			= $this->it_get_woo_requests('it_tax_groupby','tax_group_by_state',true);

		$it_id_order_status 	= $this->it_get_woo_requests('it_id_order_status',NULL,true);
		$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
		//$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

		$it_country_code		= $this->it_get_woo_requests('it_countries_code','-1',true);

		/*if($it_country_code != NULL  && $it_country_code != '-1')
		{
			$it_country_code = "'".str_replace(",", "','",$it_country_code)."'";
		}*/

		$state_code		= $this->it_get_woo_requests('it_states_code','-1',true);

		/*if($state_code != NULL  && $state_code != '-1')
		{
			$state_code = "'".str_replace(",", "','",$state_code)."'";
		}*/

		///////////HIDDEN FIELDS////////////
		$it_hide_os		= $this->it_get_woo_requests('it_hide_os','-1',true);
		$it_publish_order='no';

		/////////////////////////
		//APPLY PERMISSION TERMS
		$key=$this->it_get_woo_requests('table_names','',true);

		$it_country_code=$this->it_get_form_element_permission('it_countries_code',$it_country_code,$key);

		if($it_country_code != NULL  && $it_country_code != '-1')
			$it_country_code  		= "'".str_replace(",","','",$it_country_code)."'";

		$state_code=$this->it_get_form_element_permission('it_states_code',$state_code,$key);

		if($state_code != NULL  && $state_code != '-1')
			$state_code  		= "'".str_replace(",","','",$state_code)."'";

		$it_order_status=$this->it_get_form_element_permission('it_orders_status',$it_order_status,$key);

		if($it_order_status != NULL  && $it_order_status != '-1')
			$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

		///////////////////////////

		$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);
		//////////////////////

		//Start Date
		$it_from_date_condition ="";

		//Order Status
		$it_id_order_status_join="";
		$it_id_order_status_condition="";

		//Tax Group
		$it_tax_group_by_join="";
		$tax_based_on_condition="";

		//State Code
		$state_code_condition="";

		//Coutry Code
		$it_country_code_condition="";

		//Order Status
		$it_order_status_condition="";

		//Hide Order
		$it_hide_os_condition="";

		$sql_columns = "
		SUM(it_woocommerce_order_itemmeta_tax_amount.meta_value)  AS _order_tax,
		SUM(it_woocommerce_order_itemmeta_shipping_tax_amount.meta_value)  AS _shipping_tax_amount,

		SUM(it_postmeta1.meta_value)  AS _order_shipping_amount,
		SUM(it_postmeta2.meta_value)  AS _order_total_amount,
		COUNT(it_posts.ID)  AS _order_count,

		ANY_VALUE(it_woocommerce_order_items.order_item_name) as tax_rate_code,
		ANY_VALUE(it_woocommerce_tax_rates.tax_rate_name )as tax_rate_name,
		ANY_VALUE(it_woocommerce_tax_rates.tax_rate )as order_tax_rate,

		ANY_VALUE(it_woocommerce_order_itemmeta_tax_amount.meta_value )AS order_tax,
		ANY_VALUE(it_woocommerce_order_itemmeta_shipping_tax_amount.meta_value) AS shipping_tax_amount,
		ANY_VALUE(it_postmeta1.meta_value )		as order_shipping_amount,
		ANY_VALUE(it_postmeta2.meta_value )		as order_total_amount,
		ANY_VALUE(it_postmeta3.meta_value )		as billing_state,
		ANY_VALUE(it_postmeta4.meta_value )		as billing_country
		";

		if($it_tax_group_by == "tax_group_by_city" || $it_tax_group_by == "tax_group_by_city_summary"){
			$sql_columns .= ",ANY_VALUE( it_postmeta5.meta_value 	)	as tax_city";
		}

		$group_sql='';

		switch($it_tax_group_by){
			case "tax_group_by_city":
				$group_sql = ", CONCAT(it_postmeta4.meta_value,'-',it_postmeta3.meta_value,'-',it_postmeta5.meta_value,'-',lpad(it_woocommerce_tax_rates.tax_rate,3,'0'),'-',it_woocommerce_order_items.order_item_name,'-',it_woocommerce_tax_rates.tax_rate_name,'-',it_woocommerce_tax_rates.tax_rate) as group_column
				    , CONCAT(it_postmeta4.meta_value,'-',it_postmeta3.meta_value,'-',it_postmeta5.meta_value) as group_column_array
				";
				break;
			case "tax_group_by_state":
				$group_sql = ", CONCAT(it_postmeta4.meta_value,'-',it_postmeta3.meta_value,'-',lpad(it_woocommerce_tax_rates.tax_rate,3,'0'),'-',it_woocommerce_order_items.order_item_name,'-',it_woocommerce_tax_rates.tax_rate_name,'-',it_woocommerce_tax_rates.tax_rate) as group_column
				    , CONCAT(it_postmeta4.meta_value,'-',it_postmeta3.meta_value) as group_column_array
				";
				break;
			case "tax_group_by_country":
				$group_sql = ", CONCAT(it_postmeta4.meta_value,'-',lpad(it_woocommerce_tax_rates.tax_rate,3,'0'),'-',it_woocommerce_order_items.order_item_name,'-',it_woocommerce_tax_rates.tax_rate_name,'-',it_woocommerce_tax_rates.tax_rate) as group_column
				    , CONCAT(it_postmeta4.meta_value) as group_column_array
				";
				break;
			case "tax_group_by_tax_name":
				$group_sql = ", CONCAT(it_woocommerce_tax_rates.tax_rate_name,'-',lpad(it_woocommerce_tax_rates.tax_rate,3,'0'),'-',it_woocommerce_tax_rates.tax_rate_name,'-',it_woocommerce_tax_rates.tax_rate,'-',it_postmeta4.meta_value,'-',it_postmeta3.meta_value) as group_column";
				break;
			case "tax_group_by_tax_summary":
				$group_sql = ", CONCAT(it_woocommerce_tax_rates.tax_rate_name,'-',lpad(it_woocommerce_tax_rates.tax_rate,3,'0'),'-',it_woocommerce_order_items.order_item_name) as group_column";
				break;
			case "tax_group_by_city_summary":
				$group_sql = ", CONCAT(it_postmeta4.meta_value,'',it_postmeta3.meta_value,'',it_postmeta5.meta_value) as group_column";
				break;
			case "tax_group_by_state_summary":
				$group_sql = ", CONCAT(it_postmeta4.meta_value,'',it_postmeta3.meta_value) as group_column";
				break;
			case "tax_group_by_country_summary":
				$group_sql = ", CONCAT(it_postmeta4.meta_value) as group_column";
				break;
			default:
				$group_sql = ", CONCAT(it_woocommerce_order_items.order_item_name,'-',it_woocommerce_tax_rates.tax_rate_name,'-',it_woocommerce_tax_rates.tax_rate,'-',it_postmeta4.meta_value,'-',it_postmeta3.meta_value) as group_column";
				break;
		}

		$sql_columns .= $group_sql;

		$sql_joins = "{$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items LEFT JOIN  {$wpdb->prefix}posts as it_posts ON it_posts.ID=	it_woocommerce_order_items.order_id";

		if(($it_id_order_status  && $it_id_order_status != '-1') || $it_sort_by == "status"){
			$it_id_order_status_join = "
			LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships 	ON it_term_relationships.object_id		=	it_posts.ID
			LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy 		ON term_taxonomy.term_taxonomy_id	=	it_term_relationships.term_taxonomy_id";

			if($it_sort_by == "status"){
				$it_id_order_status_join .= " LEFT JOIN  {$wpdb->prefix}terms 				as it_terms 				ON it_terms.term_id					=	term_taxonomy.term_id";
			}
		}

		$sql_joins.=$it_id_order_status_join;

		$sql_joins .= "
		LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta1 ON it_postmeta1.post_id=it_woocommerce_order_items.order_id
		LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta2 ON it_postmeta2.post_id=it_woocommerce_order_items.order_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_tax ON it_woocommerce_order_itemmeta_tax.order_item_id=it_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_tax_amount ON it_woocommerce_order_itemmeta_tax_amount.order_item_id=it_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_shipping_tax_amount ON it_woocommerce_order_itemmeta_shipping_tax_amount.order_item_id=it_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_tax_rates as it_woocommerce_tax_rates ON it_woocommerce_tax_rates.tax_rate_id=it_woocommerce_order_itemmeta_tax.meta_value
		LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta3 ON it_postmeta3.post_id=it_woocommerce_order_items.order_id
		LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta4 ON it_postmeta4.post_id=it_woocommerce_order_items.order_id";


		if($it_tax_group_by == "tax_group_by_city" || $it_tax_group_by == "tax_group_by_city_summary"){
			$it_tax_group_by_join= " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta5 ON it_postmeta5.post_id=it_woocommerce_order_items.order_id";
		}

		$sql_joins.=$it_tax_group_by_join;

		$sql_condition = "it_postmeta1.meta_key = '_order_shipping' AND it_woocommerce_order_items.order_item_type = 'tax'
		AND it_posts.post_type='shop_order' AND it_postmeta2.meta_key='_order_total' AND it_woocommerce_order_itemmeta_tax.meta_key='rate_id' AND it_woocommerce_order_itemmeta_tax_amount.meta_key='tax_amount' AND it_woocommerce_order_itemmeta_shipping_tax_amount.meta_key='shipping_tax_amount' AND it_postmeta3.meta_key='_shipping_state' AND it_postmeta4.meta_key='_shipping_country'";
		if($it_tax_group_by == "tax_group_by_city" || $it_tax_group_by == "tax_group_by_city_summary"){
			$tax_based_on_condition = " AND it_postmeta5.meta_key='_shipping_city'";
		}

		$sql_condition .=$tax_based_on_condition;

		if($it_id_order_status  && $it_id_order_status != '-1')
			$it_id_order_status_condition = " AND term_taxonomy.term_id IN (".$it_id_order_status .")";

		if($state_code and $state_code != '-1')
			$state_code_condition = " AND it_postmeta3.meta_value IN (".$state_code.")";

		if($it_country_code and $it_country_code != '-1')
			$it_country_code_condition= " AND it_postmeta4.meta_value IN (".$it_country_code.")";

		if($it_order_status  && $it_order_status != '-1' and $it_order_status != "'-1'")
			$it_order_status_condition = " AND it_posts.post_status IN (".$it_order_status.")";

		if($it_hide_os  && $it_hide_os != '-1' and $it_hide_os != "'-1'")
			$it_hide_os_condition = " AND it_posts.post_status NOT IN ('".$it_hide_os."')";

		if ($it_from_date != NULL &&  $it_to_date !=NULL){
			$it_from_date_condition = " AND (DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format'))";
		}

		$sql_group_by= "  GROUP BY group_column";

		$sql_order_by= "  ORDER BY group_column ASC";

		$sql = "SELECT $sql_columns FROM $sql_joins
				WHERE $sql_condition $it_id_order_status_condition $state_code_condition
				$it_country_code_condition $it_order_status_condition $it_hide_os_condition
				$it_from_date_condition
				$sql_group_by $sql_order_by";

		//echo $sql;


		$c=$it_tax_group_by;
		if($c == 'tax_group_by_city'){
			$columns = array(

				array('id'=>'billing_country' ,'lable'=>esc_html__('Tax Country',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),	
				array('id'=>'billing_state' ,'lable'=>esc_html__('Tax State',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'tax_city' ,'lable'=>esc_html__('Tax City',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'tax_rate_name' ,'lable'=>esc_html__('Tax Name',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'tax_rate_code' ,'lable'=>esc_html__('Tax Rate Code',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'order_tax_rate' ,'lable'=>esc_html__('Tax Rate',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_count' ,'lable'=>esc_html__('Order Count',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_order_shipping_amount' ,'lable'=>esc_html__('Shipping Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_amount' ,'lable'=>esc_html__('Gross Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'order_total_amount' ,'lable'=>esc_html__('Net Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_shipping_tax_amount' ,'lable'=>esc_html__('Shipping Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_tax' ,'lable'=>esc_html__('Order Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_total_tax' ,'lable'=>esc_html__('Total Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency')
			);
		}elseif($c == 'tax_group_by_state'){
			$columns = array(

				array('id'=>'billing_country' ,'lable'=>esc_html__('Tax Country',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'billing_state' ,'lable'=>esc_html__('Tax State',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'tax_rate_name' ,'lable'=>esc_html__('Tax Name',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'tax_rate_code' ,'lable'=>esc_html__('Tax Rate Code',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'order_tax_rate' ,'lable'=>esc_html__('Tax Rate',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_count' ,'lable'=>esc_html__('Order Count',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_order_shipping_amount' ,'lable'=>esc_html__('Shipping Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_amount' ,'lable'=>esc_html__('Gross Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'order_total_amount' ,'lable'=>esc_html__('Net Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_shipping_tax_amount' ,'lable'=>esc_html__('Shipping Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_tax' ,'lable'=>esc_html__('Order Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_total_tax' ,'lable'=>esc_html__('Total Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency')
			);
		}elseif($c == 'tax_group_by_country'){
			$columns = array(

				array('id'=>'billing_country' ,'lable'=>esc_html__('Tax Country',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'tax_rate_name' ,'lable'=>esc_html__('Tax Name',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'tax_rate_code' ,'lable'=>esc_html__('Tax Rate Code',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'order_tax_rate' ,'lable'=>esc_html__('Tax Rate',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_count' ,'lable'=>esc_html__('Order Count',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_order_shipping_amount' ,'lable'=>esc_html__('Shipping Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_amount' ,'lable'=>esc_html__('Gross Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'order_total_amount' ,'lable'=>esc_html__('Net Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_shipping_tax_amount' ,'lable'=>esc_html__('Shipping Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_tax' ,'lable'=>esc_html__('Order Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_total_tax' ,'lable'=>esc_html__('Total Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency')
			);
		}elseif($c == 'tax_group_by_tax_name'){
			$columns = array(

				array('id'=>'tax_rate_name' ,'lable'=>esc_html__('Tax Name',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'tax_rate_code' ,'lable'=>esc_html__('Tax Rate Code',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'order_tax_rate' ,'lable'=>esc_html__('Tax Rate',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_count' ,'lable'=>esc_html__('Order Count',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_order_shipping_amount' ,'lable'=>esc_html__('Shipping Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_amount' ,'lable'=>esc_html__('Gross Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'order_total_amount' ,'lable'=>esc_html__('Net Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_shipping_tax_amount' ,'lable'=>esc_html__('Shipping Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_tax' ,'lable'=>esc_html__('Order Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_total_tax' ,'lable'=>esc_html__('Total Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency')

			);
		}elseif($c == 'tax_group_by_tax_summary'){
			$columns = array(

				array('id'=>'tax_rate_name' ,'lable'=>esc_html__('Tax Name',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'order_tax_rate' ,'lable'=>esc_html__('Tax Rate',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_count' ,'lable'=>esc_html__('Order Count',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_order_shipping_amount' ,'lable'=>esc_html__('Shipping Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_amount' ,'lable'=>esc_html__('Gross Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'order_total_amount' ,'lable'=>esc_html__('Net Amt.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_shipping_tax_amount' ,'lable'=>esc_html__('Shipping Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_tax' ,'lable'=>esc_html__('Order Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_total_tax' ,'lable'=>esc_html__('Total Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency')

			);
		}elseif($c == 'tax_group_by_city_summary'){
			$columns = array(

				array('id'=>'billing_country' ,'lable'=>esc_html__('Tax Country',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'billing_state' ,'lable'=>esc_html__('Tax State',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'tax_city' ,'lable'=>esc_html__('Tax City',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_order_count' ,'lable'=>esc_html__('Order Count',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_shipping_tax_amount' ,'lable'=>esc_html__('Shipping Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_tax' ,'lable'=>esc_html__('Order Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_total_tax' ,'lable'=>esc_html__('Total Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency')

			);
		}elseif($c == 'tax_group_by_state_summary'){
			$columns = array(
				array('id'=>'billing_country' ,'lable'=>esc_html__('Tax Country',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'billing_state' ,'lable'=>esc_html__('Tax State',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_order_count' ,'lable'=>esc_html__('Order Count',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_shipping_tax_amount' ,'lable'=>esc_html__('Shipping Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_tax' ,'lable'=>esc_html__('Order Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_total_tax' ,'lable'=>esc_html__('Total Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency')

			);
		}elseif($c == 'tax_group_by_country_summary'){
			$columns = array(

				array('id'=>'billing_country' ,'lable'=>esc_html__('Tax Country',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_order_count' ,'lable'=>esc_html__('Order Count',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('id'=>'_shipping_tax_amount' ,'lable'=>esc_html__('Shipping Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_tax' ,'lable'=>esc_html__('Order Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_total_tax' ,'lable'=>esc_html__('Total Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency')

			);
		}else{
			$columns = array(

				array('id'=>'order_tax_rate' ,'lable'=>esc_html__('Tax Rate',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_shipping_tax_amount' ,'lable'=>esc_html__('Shipping Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_order_tax' ,'lable'=>esc_html__('Order Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),
				array('id'=>'_total_tax' ,'lable'=>esc_html__('Total Tax',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency')

			);
		}

		$this->table_cols = $columns;

	}elseif($file_used=="data_table"){

		$it_tax_group_by 			= $this->it_get_woo_requests('it_tax_groupby','tax_group_by_state',true);
	    $data_array=array();
		foreach($this->results as $items){		    $index_cols=0;
            $data_array[$items->group_column_array][]=$items;
        }

        //print_r($data_array);

        foreach($data_array as $key=>$item){
	        $sum_shipping_tax=$sum_order_tax=$sum_total_tax=$sum_refund_tax=$sum_redund_ship_tax=$sum_total_tax_refund=$sum_net_tax=0;
            foreach($item as $items){
	            if($it_tax_group_by=='tax_group_by_country'){
		            $datatable_value.=("<tr class='awr-colored-tbl-row'><td >$items->billing_country</td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td></tr>");
	            }elseif($it_tax_group_by=='tax_group_by_state'){
		            $datatable_value.=("<tr class='awr-colored-tbl-row'><td >$items->billing_country</td><td >".$this->it_get_woo_bsn($items->billing_country,$items->billing_state)."</td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td></tr>");
	            }elseif($it_tax_group_by=='tax_group_by_city'){
		            $datatable_value.=("<tr class='awr-colored-tbl-row'><td >$items->billing_country</td><td >".$this->it_get_woo_bsn($items->billing_country,$items->billing_state)."</td><td >$items->tax_city</td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td></tr>");
	            }


	            $datatable_value.=("<tr>");

	            $shipping_tax='';
	            $order_tax='';
	            $country_billing='';



	            $j=0;
	            foreach($this->table_cols as $cols){

		            $bb=$cols['id'];
		            $value=$items->$bb;

		            switch($cols['id']){

			            case "billing_country":
				            if($it_tax_group_by=='tax_group_by_country' || $it_tax_group_by=='tax_group_by_state' || $it_tax_group_by=='tax_group_by_city')
					            $value='';

				            $country_billing=$value;
				            $country      	= $this->it_get_woo_countries();
				            $value = isset($country->countries[$value]) ? $country->countries[$value]: $items->country_name;
				            $value=$country_billing;
				            break;

			            case "billing_state":

				            if($it_tax_group_by=='tax_group_by_state' || $it_tax_group_by=='tax_group_by_city')
					            $value='';

				            $value =$this->it_get_woo_bsn($country_billing,$value);
				            break;

			            case "tax_city":
				            if($it_tax_group_by=='tax_group_by_city')
					            $value='';
				            break;

			            case "order_tax_rate":
				            $value=round($value,2).'%';
				            break;

			            case "_order_shipping_amount":
				            $sum_shipping_tax+=$value;
				            $value=$this->price($value);
				            break;

			            case "_order_amount":

				            $val=$this->it_get_number_percentage($items->_order_tax,$items->order_tax_rate);

				            $value=$this->price($val);
				            break;

			            case "order_total_amount":

				            $value=$this->price($value);
				            break;

			            case "_shipping_tax_amount":

				            $shipping_tax=$value;
				            $value=$this->price($shipping_tax);
				            break;

			            case "_order_tax":
				            $sum_order_tax+=$value;
				            $order_tax=$value;
				            $value=$this->price($order_tax);
				            break;

			            case "_total_tax":
				            $sum_total_tax+=$value;
				            $value=$this->price($shipping_tax+$order_tax);
				            break;
		            }

		            //Tax Country
		            $display_class='';
		            if($this->table_cols[$j++]['status']=='hide') $display_class='display:none';
		            $datatable_value.=("<td style='".$display_class."'>");
		            $datatable_value.= $value;
		            $datatable_value.=("</td>");

	            }

	            $datatable_value.=("</tr>");
            }


	        if($it_tax_group_by=='tax_group_by_country'){
		        $datatable_value.=("<tr class='awr-colored-tbl-total-row'><td ></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''$sum_shipping_tax</td><td colspan=''>3</td><td colspan=''>4</td><td colspan=''>5</td><td colspan=''>6</td><td colspan=''>7</td></tr>");
	        }elseif($it_tax_group_by=='tax_group_by_state'){
		        $datatable_value.=("<tr class='awr-colored-tbl-total-row'><td ></td><td ></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''>$sum_shipping_tax</td><td colspan=''>3</td><td colspan=''>4</td><td colspan=''>5</td><td colspan=''>6</td><td colspan=''>7</td></tr>");
	        }elseif($it_tax_group_by=='tax_group_by_city'){
		        $datatable_value.=("<tr class='awr-colored-tbl-total-row'><td ></td><td ></td><td ></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''></td><td colspan=''>$sum_shipping_tax</td><td colspan=''>3</td><td colspan=''>4</td><td colspan=''>5</td><td colspan=''>6</td><td colspan=''>7</td></tr>");
	        }
        }



	}elseif($file_used=="search_form"){
	?>
		<form class='alldetails search_form_report' action='' method='post'>
            <input type='hidden' name='action' value='submit-form' />
            <div class="row">

                <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('From Date',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
                    <input name="it_from_date" id="pwr_from_date" type="text" readonly='true' class="datepick"/>
                </div>

                <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('To Date',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
                    <input name="it_to_date" id="pwr_to_date" type="text" readonly='true' class="datepick"/>
                </div>

                <div class="col-md-6" >
                	<div class="awr-form-title">
						<?php _e('Country',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-globe"></i></span>
					<?php
                        $country_data = $this->it_get_paying_woo_state('shipping_country');

                        $option='';
                        //$current_product=$this->it_get_woo_requests_links('it_product_id','',true);
                        //echo $current_product;

                        foreach($country_data as $country){
							$selected='';

                            $option.="<option $selected value='".$country -> id."' >".$country -> label." </option>";
                        }
                    ?>

                    <select name="it_countries_code[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">

                        <option value="-1"><?php _e('Select All',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>

                       <?php
                            echo $option;
                        ?>
                    </select>

                </div>


                <div class="col-md-6" >
                	<div class="awr-form-title">
						<?php _e('State',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-map"></i></span>
					<?php
                        $state_code = '-1';
                        //$state_data = $this->it_get_paying_woo_state('billing_state','billing_country');
                        $state_data = $this->it_get_paying_woo_state('shipping_state','shipping_country');
                        //print_r($state_data);
                        $option='';
                        //$current_product=$this->it_get_woo_requests_links('it_product_id','',true);
                        //echo $current_product;

                        foreach($state_data as $state){
							$selected='';
                            $option.="<option $selected value='".$state -> id."' >".$state -> label." </option>";
                        }
                    ?>

                    <select name="it_states_code[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">

                        <option value="-1"><?php _e('Select All',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>

                       <?php
                            echo $option;
                        ?>
                    </select>

                </div>


                <div class="col-md-6">
                	<div class="awr-form-title">
						<?php _e('Tax Group By',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-suitcase"></i></span>
                    <select name="it_tax_groupby" id="it_tax_groupby" class="it_tax_groupby">
                        <option value="tax_group_by_city">City</option>
                        <option value="tax_group_by_state" selected="selected">State</option>
                        <option value="tax_group_by_country">Country</option>
                        <option value="tax_group_by_tax_name">Tax Name</option>
                        <option value="tax_group_by_tax_summary">Tax Summary</option>
                        <option value="tax_group_by_city_summary">City Summary</option>
                        <option value="tax_group_by_state_summary">State Summary</option>
                        <option value="tax_group_by_country_summary">Country Summary</option>
                    </select>

                </div>

                <?php
	                $col_style='';
					$permission_value=$this->get_form_element_value_permission('it_orders_status');
					if($this->get_form_element_permission('it_orders_status') ||  $permission_value!=''){

						if(!$this->get_form_element_permission('it_orders_status') &&  $permission_value!='')
							$col_style='display:none';
				?>

                <div class="col-md-6"  style=" <?php echo $col_style;?>">
                    <div class="awr-form-title">
                        <?php _e('Status',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-check"></i></span>
					<?php
                        $it_order_status=$this->it_get_woo_orders_statuses();

                        ////ADDED IN VER4.0
                        /// APPLY DEFAULT STATUS AT FIRST
                        $shop_status_selected='';
                        if($this->it_shop_status)
                            $shop_status_selected=explode(",",$this->it_shop_status);

                        $option='';
                        foreach($it_order_status as $key => $value){
							$selected='';
							//CHECK IF IS IN PERMISSION
							if(is_array($permission_value) && !in_array($key,$permission_value))
								continue;

							/*if(!$this->get_form_element_permission('it_orders_status') &&  $permission_value!='')
								$selected="selected";*/

	                        ////ADDED IN VER4.0
	                        /// APPLY DEFAULT STATUS AT FIRST
	                        if(is_array($shop_status_selected) && in_array($key,$shop_status_selected))
		                        $selected="selected";

	                        $option.="<option value='".$key."' $selected >".$value."</option>";
                        }
                    ?>

                    <select name="it_orders_status[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                        <?php
                        	if($this->get_form_element_permission('it_orders_status') && ((!is_array($permission_value)) || (is_array($permission_value) && in_array('all',$permission_value))))
							{
						?>
                        <option value="-1"><?php _e('Select All',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                        <?php
							}
						?>
                        <?php
                            echo $option;
                        ?>
                    </select>
                    <input type="hidden" name="it_id_order_status[]" id="it_id_order_status" value="-1">
                </div>
                <?php
					}
				?>

            </div>

            <div class="col-md-12 awr-save-form">
                    <?php
                    	$it_hide_os=$this->otder_status_hide;
						$it_publish_order='no';

						$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);
					?>
                    <input type="hidden" name="list_parent_category" value="">
                    <input type="hidden" name="group_by_parent_cat" value="0">

                	<input type="hidden" name="it_hide_os" id="it_hide_os" value="<?php echo $it_hide_os;?>" />

                    <input type="hidden" name="date_format" id="date_format" value="<?php echo $data_format;?>" />

                	<input type="hidden" name="table_names" value="<?php echo $table_name;?>"/>
                    <div class="fetch_form_loading search-form-loading"></div>
                    <button type="submit" value="Search" class="button-primary"><i class="fa fa-search"></i> <span><?php echo esc_html__('Search',__IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
					<button type="button" value="Reset" class="button-secondary form_reset_btn"><i class="fa fa-reply"></i><span><?php echo esc_html__('Reset Form',__IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
            </div>
        </form>
    <?php
	}

?>
