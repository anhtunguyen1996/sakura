<?php
if($file_used=="sql_table")
{
	$request 			= array();
	$start				= 0;

	$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
	$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
	$date_format = $this->it_date_format($it_from_date);

	$it_id_order_status 	= $this->it_get_woo_requests('it_id_order_status',NULL,true);
	$it_paid_customer		= $this->it_get_woo_requests('it_customers_paid',NULL,true);
	$txtProduct 		= $this->it_get_woo_requests('txtProduct',NULL,true);
	$it_product_id			= $this->it_get_woo_requests('it_product_id',"-1",true);
	$category_id 		= $this->it_get_woo_requests('it_category_id','-1',true);

	////ADDED IN VER4.0
	//BRANDS ADDONS
	$brand_id 		= $this->it_get_woo_requests('it_brand_id','-1',true);

	$limit 				= $this->it_get_woo_requests('limit',15,true);
	$p 					= $this->it_get_woo_requests('p',1,true);

	$page 				= $this->it_get_woo_requests('page',NULL,true);
	$order_id 			= $this->it_get_woo_requests('it_id_order',NULL,true);
	$it_from_date 		= $this->it_get_woo_requests('it_from_date',NULL,true);
	$it_to_date 			= $this->it_get_woo_requests('it_to_date',NULL,true);

	$it_txt_email 			= $this->it_get_woo_requests('it_email_text',NULL,true);

	$it_txt_first_name		= $this->it_get_woo_requests('it_first_name_text',NULL,true);

	$it_detail_view		= $this->it_get_woo_requests('it_view_details',"no",true);
	$it_country_code		= $this->it_get_woo_requests('it_countries_code',NULL,true);
	$state_code			= $this->it_get_woo_requests('it_states_code','-1',true);
	$it_payment_method		= $this->it_get_woo_requests('payment_method',NULL,true);
	$it_order_item_name	= $this->it_get_woo_requests('order_item_name',NULL,true);//for coupon
	$it_coupon_code		= $this->it_get_woo_requests('coupon_code',NULL,true);//for coupon
	$it_publish_order		= $this->it_get_woo_requests('publish_order','no',true);//if publish display publish order only, no or null display all order
	$it_coupon_used		= $this->it_get_woo_requests('it_use_coupon','no',true);
	$it_order_meta_key		= $this->it_get_woo_requests('order_meta_key','-1',true);
	$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
	//$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

	$it_paid_customer		= str_replace(",","','",$it_paid_customer);
	//$it_country_code		= str_replace(",","','",$it_country_code);
	//$state_code		= str_replace(",","','",$state_code);
	//$it_country_code		= str_replace(",","','",$it_country_code);

	$it_coupon_code		= $this->it_get_woo_requests('coupon_code','-1',true);
	$it_coupon_codes		= $this->it_get_woo_requests('it_codes_of_coupon','-1',true);

	$it_max_amount			= $this->it_get_woo_requests('max_amount','-1',true);
	$it_min_amount			= $this->it_get_woo_requests('min_amount','-1',true);

	$it_billing_post_code		= $this->it_get_woo_requests('it_bill_post_code','-1',true);

	////ADDED IN V4.0
	$it_variation_id		= $this->it_get_woo_requests('it_variation_id','-1',true);
	$it_variation_only		= $this->it_get_woo_requests('it_variation_only','-1',true);
	$it_variations=$it_item_meta_key='';
	if($it_variation_id != '-1' and strlen($it_variation_id) > 0){

		$it_variations = explode(",",$it_variation_id);
		//$this->print_array($it_variations);
		$var = array();
		$item_att = array();
		foreach($it_variations as $key => $value):
			$var[] .=  "attribute_pa_".$value;
			$var[] .=  "attribute_".$value;
			$item_att[] .=  "pa_".$value;
			$item_att[] .=  $value;
		endforeach;
		$it_variations =  implode("', '",$var);
		$it_item_meta_key =  implode("', '",$item_att);
	}
	$it_variation_attributes= $it_variations;
	$it_variation_item_meta_key= $it_item_meta_key;

	$it_hide_os		= $this->it_get_woo_requests('it_hide_os','"trash"',true);

	$it_show_cog		= $this->it_get_woo_requests('it_show_cog','no',true);

	///////////HIDDEN FIELDS////////////
	$it_hide_os=$this->otder_status_hide;
	$it_publish_order='no';
	$it_order_item_name='';
	$it_coupon_code='';
	$it_coupon_codes='';
	$it_payment_method='';

	$it_order_meta_key='';

	$data_format=$this->it_get_woo_requests('date_format',get_option('date_format'),true);

	$amont_zero='';
	//////////////////////

	/////////////////////////
	//APPLY PERMISSION TERMS
	$key='all_orders';

	$category_id=$this->it_get_form_element_permission('it_category_id',$category_id,$key);

	////ADDED IN VER4.0
	//BRANDS ADDONS
	$brand_id=$this->it_get_form_element_permission('it_brand_id',$brand_id,$key);

	$it_product_id=$this->it_get_form_element_permission('it_product_id',$it_product_id,$key);

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

	$it_variations_formated='';

	if(strlen($it_max_amount)<=0) $_REQUEST['max_amount']	= 	$it_max_amount = '-1';
	if(strlen($it_min_amount)<=0) $_REQUEST['min_amount']	=	$it_min_amount = '-1';

	if($it_max_amount != '-1' || $it_min_amount != '-1'){
		if($it_order_meta_key == '-1'){
			$_REQUEST['order_meta_key']	= "_order_total";
		}
	}

	$last_days_orders 		= "0";
	if(is_array($it_id_order_status)){		$it_id_order_status 	= implode(",", $it_id_order_status);}
	if(is_array($category_id)){ 		$category_id		= implode(",", $category_id);}

	/////ADDED IN VER4.0
	//BRANDS ADDONS
	if(is_array($brand_id)){ 		$brand_id		= implode(",", $brand_id);}

	if(!$it_from_date){	$it_from_date = date_i18n('Y-m-d');}
	if(!$it_to_date){
		$last_days_orders 		= apply_filters($page.'_back_day', $last_days_orders);//-1,-2,-3,-4,-5
		$it_to_date = date('Y-m-d', strtotime($last_days_orders.' day', strtotime(date_i18n("Y-m-d"))));}

	$it_sort_by 			= $this->it_get_woo_requests('sort_by','order_id',true);
	$it_order_by 			= $this->it_get_woo_requests('order_by','DESC',true);


	//it_first_name_text
	$it_txt_first_name_cols='';
	$it_txt_first_name_join = '';
	$it_txt_first_name_condition_1 = '';
	$it_txt_first_name_condition_2 = '';

	//it_email_text
	$it_txt_email_cols ='';
	$it_txt_email_join = '';
	$it_txt_email_condition_1 = '';
	$it_txt_email_condition_2 = '';

	//SORT BY
	$it_sort_by_cols ='';

	//CATEGORY
	$category_id_join ='';
	$category_id_condition = '';

	////ADDED IN VER4.0
	//BRANDS ADDONS
	$brand_id_join ='';
	$brand_id_condition = '';

	//ORDER ID
	$it_id_order_status_join ='';
	$it_id_order_status_condition = '';

	//COUNTRY
	$it_country_code_join = '';
	$it_country_code_condition_1 = '';
	$it_country_code_condition_2 = '';

	//STATE
	$state_code_join= '';
	$state_code_condition_1 = '';
	$state_code_condition_2 = '';

	//PAYMENT METHOD
	$it_payment_method_join= '';
	$it_payment_method_condition_1 = '';
	$it_payment_method_condition_2 = '';

	//POSTCODE
	$it_billing_post_code_join = '';
	$it_billing_post_code_condition= '';

	//COUPON USED
	$it_coupon_used_join = '';
	$it_coupon_used_condition = '';

	//VARIATION ID
	$it_variation_id_join = '';
	$it_variation_id_condition = '';

	////ADDED IN V4.0
	//VARIATION
	$it_variation_item_meta_key_join='';
	$sql_variation_join='';
	$it_show_variation_join='';
	$it_variation_item_meta_key_condition='';
	$sql_variation_condition='';

	//VARIATION ONLY
	$it_variation_only_join = '';
	$it_variation_only_condition = '';

	//VARIATION FORMAT
	$it_variations_formated_join = '';
	$it_variations_formated_condition = '';

	//ORDER META KEY
	$it_order_meta_key_join = '';
	$it_order_meta_key_condition = '';

	//COUPON CODES
	$it_coupon_codes_join = '';
	$it_coupon_codes_condition = '';

	//COUPON CODE
	$it_coupon_code_condition = '';

	//DATA CONDITION
	$date_condition = '';

	//ORDER ID
	$order_id_condition = '';

	//PAID CUSTOMER
	$it_paid_customer_condition = '';

	//PUBLISH ORDER
	$it_publish_order_condition_1 = '';
	$it_publish_order_condition_2 = '';

	//ORDER ITEM NAME
	$it_order_item_name_condition = '';

	//txt PRODUCT
	$txtProduct_condition = '';

	//PRODUCT ID
	$it_product_id_condition = '';

	//CATEGORY ID
	$category_id_condition = '';

	//ORDER STATUS ID
	$it_id_order_status_condition = '';

	//ORDER STATUS
	$it_order_status_condition = '';

	//HIDE ORDER STATUS
	$it_hide_os_condition = '';

	////ADDED IN VER4.0
	/// COST OF GOOD
	$it_show_cog_cols='';
	$it_show_cog_join='';
	$it_show_cog_condition='';

	$sql_columns .= "
        billing_country.meta_value as billing_country,
        DATE_FORMAT(it_posts.post_date,'%m/%d/%Y') 													AS order_date,
        it_posts.post_date  													AS full_date,
		it_woocommerce_order_items.order_id 															AS order_id,
		it_woocommerce_order_items.order_item_name 													AS product_name,
		it_woocommerce_order_items.order_item_id														AS order_item_id,
		woocommerce_order_itemmeta.meta_value 														AS woocommerce_order_itemmeta_meta_value,
		(it_woocommerce_order_itemmeta2.meta_value/it_woocommerce_order_itemmeta3.meta_value) 			AS sold_rate,
		(it_woocommerce_order_itemmeta4.meta_value/it_woocommerce_order_itemmeta3.meta_value) 			AS product_rate,
		(it_woocommerce_order_itemmeta4.meta_value) 													AS item_amount,
		(it_woocommerce_order_itemmeta2.meta_value) 													AS item_net_amount,
		(it_woocommerce_order_itemmeta4.meta_value - it_woocommerce_order_itemmeta2.meta_value) 			AS item_discount,
		it_woocommerce_order_itemmeta2.meta_value 														AS total_price,
		count(it_woocommerce_order_items.order_item_id) 												AS product_quentity,
		woocommerce_order_itemmeta.meta_value 														AS product_id
		,woocommerce_order_itemmeta_v.meta_value 														AS variation_id

		,it_woocommerce_order_itemmeta3.meta_value 													AS 'product_quantity'
		,it_posts.post_status 																			AS post_status
		,it_posts.post_status 																			AS order_status

		";

	$sql_joins ="{$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items

		LEFT JOIN  {$wpdb->prefix}posts as it_posts ON it_posts.ID=it_woocommerce_order_items.order_id

		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as woocommerce_order_itemmeta 	ON woocommerce_order_itemmeta.order_item_id		=	it_woocommerce_order_items.order_item_id

		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as woocommerce_order_itemmeta_v 	ON woocommerce_order_itemmeta_v.order_item_id		=	it_woocommerce_order_items.order_item_id

		";

	$sql_joins.="
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta2 	ON it_woocommerce_order_itemmeta2.order_item_id	=	it_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta3 	ON it_woocommerce_order_itemmeta3.order_item_id	=	it_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta4 	ON it_woocommerce_order_itemmeta4.order_item_id	=	it_woocommerce_order_items.order_item_id AND it_woocommerce_order_itemmeta4.meta_key='_line_subtotal'
        LEFT JOIN  {$wpdb->prefix}postmeta as billing_country ON billing_country.post_id = it_posts.ID
        ";

	$post_type_condition="it_posts.post_type = 'shop_order' AND billing_country.meta_key	= '_billing_country'";

	$other_condition_1 = "
		AND woocommerce_order_itemmeta.meta_key = '_product_id' AND woocommerce_order_itemmeta_v.meta_key = '_product_id' ";

	$other_condition_1 .= "
		AND it_woocommerce_order_itemmeta2.meta_key='_line_total'
		AND it_woocommerce_order_itemmeta3.meta_key='_qty' ";


	if ($it_from_date != NULL &&  $it_to_date !=NULL){
		$date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format')";
	}

	if($it_order_status  && $it_order_status != '-1' and $it_order_status != "'-1'")
		$it_order_status_condition = " AND it_posts.post_status IN (".$it_order_status.")";

	if($it_hide_os  && $it_hide_os != '-1' and $it_hide_os != "'-1'")
		$it_hide_os_condition = " AND it_posts.post_status NOT IN ('".$it_hide_os."')";


	$sql ="SELECT $sql_columns FROM $sql_joins";

	$sql .="$category_id_join $brand_id_join $it_id_order_status_join $it_txt_email_join $it_txt_first_name_join
				$it_country_code_join $state_code_join $it_payment_method_join $it_billing_post_code_join
				$it_coupon_used_join $it_variation_id_join $it_variation_only_join $it_variations_formated_join
				$it_order_meta_key_join $it_coupon_codes_join $it_variation_item_meta_key_join $it_show_cog_join ";

	$sql .= " Where $post_type_condition $it_txt_email_condition_1 $it_txt_first_name_condition_1
						$other_condition_1 $it_country_code_condition_1 $state_code_condition_1
						$it_billing_post_code_condition $it_payment_method_condition_1 $date_condition
						$order_id_condition $it_txt_email_condition_2 $it_paid_customer_condition
						$it_txt_first_name_condition_2 $it_publish_order_condition_1 $it_publish_order_condition_2
						$it_country_code_condition_2 $state_code_condition_2 $it_payment_method_condition_2
						$it_order_meta_key_condition $it_order_item_name_condition $txtProduct_condition
						$it_product_id_condition $category_id_condition $brand_id_condition $it_id_order_status_condition
						$it_coupon_used_condition $it_coupon_code_condition $it_coupon_codes_condition $it_variation_item_meta_key_condition
						$it_variation_id_condition $it_variation_only_condition $it_variations_formated_condition $it_show_cog_condition
						$it_order_status_condition $it_hide_os_condition ";

	$sql_group_by = " GROUP BY it_woocommerce_order_items.order_item_id ";
	$sql_order_by = " ORDER BY {$it_sort_by} {$it_order_by}";

	$sql .=$sql_group_by.$sql_order_by;


	//////////////////////////////////////////////////////
	//GET LAST x DAYS FOR DETECT RANK of ITEMS
	// X = from-lenofrange
	//////////////////////////////////////////////////////
	$from=date_create($it_from_date);
	$to=date_create($it_to_date);
	$diff=date_diff($to,$from);

	$days = $diff->format('%a')+1;
	$days_ago = date('Y-m-d', strtotime("-$days days", strtotime($it_from_date)));
	$to=$it_from_date;
	$it_from_date=$days_ago;
	$it_to_date = date('Y-m-d', strtotime("-1 days", strtotime($to)));
	if ($it_from_date != NULL &&  $it_to_date !=NULL) {
		$date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format') ";
	}

	$sql_last_x_days ="SELECT $sql_columns FROM $sql_joins";

	$sql_last_x_days .="$category_id_join $brand_id_join $it_id_order_status_join $it_txt_email_join $it_txt_first_name_join
				$it_country_code_join $state_code_join $it_payment_method_join $it_billing_post_code_join
				$it_coupon_used_join $it_variation_id_join $it_variation_only_join $it_variations_formated_join
				$it_order_meta_key_join $it_coupon_codes_join $it_variation_item_meta_key_join $it_show_cog_join ";
	$sql_last_x_days .= " Where $post_type_condition $it_txt_email_condition_1 $it_txt_first_name_condition_1
						$other_condition_1 $it_country_code_condition_1 $state_code_condition_1
						$it_billing_post_code_condition $it_payment_method_condition_1 $date_condition
						$order_id_condition $it_txt_email_condition_2 $it_paid_customer_condition
						$it_txt_first_name_condition_2 $it_publish_order_condition_1 $it_publish_order_condition_2
						$it_country_code_condition_2 $state_code_condition_2 $it_payment_method_condition_2
						$it_order_meta_key_condition $it_order_item_name_condition $txtProduct_condition
						$it_product_id_condition $category_id_condition $brand_id_condition $it_id_order_status_condition
						$it_coupon_used_condition $it_coupon_code_condition $it_coupon_codes_condition $it_variation_item_meta_key_condition
						$it_variation_id_condition $it_variation_only_condition $it_variations_formated_condition $it_show_cog_condition
						$it_order_status_condition $it_hide_os_condition ";

	$sql_group_by = " GROUP BY it_woocommerce_order_items.order_item_id ";
	$sql_order_by = " ORDER BY {$it_sort_by} {$it_order_by}";

	$sql_last_x_days .=$sql_group_by.$sql_order_by;
	$this->sql_int_last_x_days=$sql_last_x_days;
	//echo $sql;
	//echo $this->sql_int_last_x_days;

}
elseif($file_used=="data_table"){

	//print_r($this->results);

	$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
	$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);

	$from=date_create($it_from_date);
	$to=date_create($it_to_date);
	$diff=date_diff($to,$from);

	$days = $diff->format('%a')+1;


	$order_items=$this->results;
	$categories = array();
	$order_meta = array();
	if(count($order_items)>0)
		foreach ( $order_items as $key => $order_item ) {

			$order_id								= $order_item->order_id;
			$order_items[$key]->billing_first_name  = '';//Default, some time it missing
			$order_items[$key]->billing_last_name  	= '';//Default, some time it missing
			$order_items[$key]->billing_email  		= '';//Default, some time it missing

			if(!isset($order_meta[$order_id])){
				$order_meta[$order_id]					= $this->it_get_full_post_meta($order_id);
			}

			//die(print_r($order_meta[$order_id]));

			foreach($order_meta[$order_id] as $k => $v){
				$order_items[$key]->$k			= $v;
			}


			$order_items[$key]->order_total			= isset($order_item->order_total)		? $order_item->order_total 		: 0;
			$order_items[$key]->order_shipping		= isset($order_item->order_shipping)	? $order_item->order_shipping 	: 0;


			$order_items[$key]->cart_discount		= isset($order_item->cart_discount)		? $order_item->cart_discount 	: 0;
			$order_items[$key]->order_discount		= isset($order_item->order_discount)	? $order_item->order_discount 	: 0;
			$order_items[$key]->total_discount 		= isset($order_item->total_discount)	? $order_item->total_discount 	: ($order_items[$key]->cart_discount + $order_items[$key]->order_discount);


			$order_items[$key]->order_tax 			= isset($order_item->order_tax)			? $order_item->order_tax : 0;
			$order_items[$key]->order_shipping_tax 	= isset($order_item->order_shipping_tax)? $order_item->order_shipping_tax : 0;
			$order_items[$key]->total_tax 			= isset($order_item->total_tax)			? $order_item->total_tax 	: ($order_items[$key]->order_tax + $order_items[$key]->order_shipping_tax);

			$transaction_id = "ransaction ID";
			$order_items[$key]->transaction_id		= isset($order_item->$transaction_id) 	? $order_item->$transaction_id		: (isset($order_item->transaction_id) ? $order_item->transaction_id : '');
			$order_items[$key]->gross_amount 		= ($order_items[$key]->order_total + $order_items[$key]->total_discount) - ($order_items[$key]->order_shipping +  $order_items[$key]->order_shipping_tax + $order_items[$key]->order_tax );


			$order_items[$key]->billing_first_name	= isset($order_item->billing_first_name)? $order_item->billing_first_name 	: '';
			$order_items[$key]->billing_last_name	= isset($order_item->billing_last_name)	? $order_item->billing_last_name 	: '';
			$order_items[$key]->billing_name		= $order_items[$key]->billing_first_name.' '.$order_items[$key]->billing_last_name;
			$order_items[$key]->customer_user		= $order_items[$key]->customer_user;


		}

	//print_r($order_items);

	$heat_chart_array=$sale_chart_array=$date_array=array();
	$heat_chart_max=0;

	$currency_decimal=get_option('woocommerce_price_decimal_sep','.');
	$currency_thousand=get_option('woocommerce_price_thousand_sep',',');
	$currency_thousand=',';

	$this->results=$order_items;
	$net_amnt=$part_refund_amnt=$order_count=0;
	$first_order_id='';
	$customer_array=array();
	foreach($this->results as $items){

		$date_format		= get_option( 'date_format' );

		$order_refund_amnt= $this->it_get_por_amount($items -> order_id);
		$part_refund=(isset($order_refund_amnt[$items->order_id])? $order_refund_amnt[$items->order_id]:0);


		//Order Total
		$it_table_value = isset($items -> order_total) ? ($items -> order_total)-$part_refund : 0;
		$it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

		$it_table_value = isset($items -> order_total) ? ($items -> order_total)-$part_refund : 0;
		// $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

		$new_order=false;
		if($first_order_id=='')
		{
			$first_order_id=$items->order_id;
			$new_order=true;
		}else if($first_order_id!=$items->order_id)
		{
			$first_order_id=$items->order_id;
			$new_order=true;
		}
		if($new_order){

			$part_refund_amnt+=$order_refund_amnt[$items->order_id];
			$net_amnt+=$it_table_value;

			$customer_array[$items->order_id]['order_id']=$items->order_id;
			$customer_array[$items->order_id]['id']=$items->customer_user;
			$customer_array[$items->order_id]['date']=date("M d, Y",strtotime($items->order_date));
			$customer_array[$items->order_id]['name']=$items->billing_name;
			$customer_array[$items->order_id]['total']=$it_table_value;
			$customer_array[$items->order_id]['status']=$items->order_status;

			$tempDate = $items->full_date;
			$time = ltrim(date("H",strtotime($tempDate)),0);
			$weekday= date('l', strtotime( $tempDate));
			$heat_chart_array[$weekday][$time][]= $it_table_value;
			if($it_table_value>$heat_chart_max) $heat_chart_max=$it_table_value;


			//FOR SALE CHART
			if(isset($date_array[$items->order_date]))
			{
				$date_array[$items->order_date]+=$it_table_value;
			}else{
				$date_array[$items->order_date]=$it_table_value;
			}

			$order_count++;
		}
	}

	//////////////////////////////////////////////////////
	/// CALCULATE THE PERCENTAGE OF SALES - TOP-BOX LEFT
	//////////////////////////////////////////////////////
	$order_items=$wpdb->get_results($this->sql_int_last_x_days);

	if(count($order_items)>0)
		foreach ( $order_items as $key => $order_item ) {

			$order_id								= $order_item->order_id;
			$order_items[$key]->billing_first_name  = '';//Default, some time it missing
			$order_items[$key]->billing_last_name  	= '';//Default, some time it missing
			$order_items[$key]->billing_email  		= '';//Default, some time it missing

			if(!isset($order_meta[$order_id])){
				$order_meta[$order_id]					= $this->it_get_full_post_meta($order_id);
			}

			//die(print_r($order_meta[$order_id]));

			foreach($order_meta[$order_id] as $k => $v){
				$order_items[$key]->$k			= $v;
			}


			$order_items[$key]->order_total			= isset($order_item->order_total)		? $order_item->order_total 		: 0;
			$order_items[$key]->order_shipping		= isset($order_item->order_shipping)	? $order_item->order_shipping 	: 0;


			$order_items[$key]->cart_discount		= isset($order_item->cart_discount)		? $order_item->cart_discount 	: 0;
			$order_items[$key]->order_discount		= isset($order_item->order_discount)	? $order_item->order_discount 	: 0;
			$order_items[$key]->total_discount 		= isset($order_item->total_discount)	? $order_item->total_discount 	: ($order_items[$key]->cart_discount + $order_items[$key]->order_discount);


			$order_items[$key]->order_tax 			= isset($order_item->order_tax)			? $order_item->order_tax : 0;
			$order_items[$key]->order_shipping_tax 	= isset($order_item->order_shipping_tax)? $order_item->order_shipping_tax : 0;
			$order_items[$key]->total_tax 			= isset($order_item->total_tax)			? $order_item->total_tax 	: ($order_items[$key]->order_tax + $order_items[$key]->order_shipping_tax);

			$transaction_id = "ransaction ID";
			$order_items[$key]->transaction_id		= isset($order_item->$transaction_id) 	? $order_item->$transaction_id		: (isset($order_item->transaction_id) ? $order_item->transaction_id : '');
			$order_items[$key]->gross_amount 		= ($order_items[$key]->order_total + $order_items[$key]->total_discount) - ($order_items[$key]->order_shipping +  $order_items[$key]->order_shipping_tax + $order_items[$key]->order_tax );


			$order_items[$key]->billing_first_name	= isset($order_item->billing_first_name)? $order_item->billing_first_name 	: '';
			$order_items[$key]->billing_last_name	= isset($order_item->billing_last_name)	? $order_item->billing_last_name 	: '';
			$order_items[$key]->billing_name		= $order_items[$key]->billing_first_name.' '.$order_items[$key]->billing_last_name;
			$order_items[$key]->customer_user		= $order_items[$key]->customer_user;


		}
	$net_amnt_last_x_days=0;
	$first_order_id='';

	foreach($order_items as $items){

		$date_format		= get_option( 'date_format' );

		$order_refund_amnt= $this->it_get_por_amount($items -> order_id);
		$part_refund=(isset($order_refund_amnt[$items->order_id])? $order_refund_amnt[$items->order_id]:0);


		//Order Total
		$it_table_value = isset($items -> order_total) ? ($items -> order_total)-$part_refund : 0;
		$it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

		$it_table_value = isset($items -> order_total) ? ($items -> order_total)-$part_refund : 0;
		// $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

		$new_order=false;
		if($first_order_id=='')
		{
			$first_order_id=$items->order_id;
			$new_order=true;
		}else if($first_order_id!=$items->order_id)
		{
			$first_order_id=$items->order_id;
			$new_order=true;
		}
		if($new_order){
			$net_amnt_last_x_days+=$it_table_value;
		}
	}

	//Percent Increase/Decrease = (This Year - Last Year) ÷ Last Year
	// if This Year> Last Year -> Increase ,, else decrease
	$percentage_down_up='100';
	$percentage_down_up_html='
            <span class="pw-val"><i class="fa fa-arrow-up pw-green"></i></span>
            <span class="pw-green">'.$percentage_down_up.'%</span>';
	$percentage_down_up_class="green";
	if($net_amnt_last_x_days!=0){
		$percentage_down_up= abs(($net_amnt-$net_amnt_last_x_days)/$net_amnt_last_x_days)*100;
		$percentage_down_up=number_format($percentage_down_up,2);
		if($net_amnt>$net_amnt_last_x_days){

			$percentage_down_up_html='
	                <span class="pw-val "><i class="fa fa-arrow-down pw-red"></i></span>
                    <span class="pw-red ">'.$percentage_down_up.'%</span>';
		}else{
			$percentage_down_up_html='
	                <span class="pw-val "><i class="fa fa-arrow-up pw-green"></i></span>
                    <span class="pw-green ">'.$percentage_down_up.'%</span>';
		}

	}



	//////////////////////////////////////////////////////
	//SALE CHART
	//////////////////////////////////////////////////////
	ksort ($date_array);
	$i=0;
	foreach($date_array as $key=>$value){
		$date=trim($key);
		$date=explode("/",$date);
		$mm=$date[0];
		$dd=$date[1];
		$yy=$date[2];
		$value=  (is_numeric($value) ?  number_format($value,2):0);
		$value=str_replace($currency_thousand,"",$value);

		$sale_chart_array[$i]['value']= $this->price_value($value);
		$sale_chart_array[$i]['date']= $yy.'-'.$mm.'-'.$dd;
		$i++;
	}

	//////////////////////////////////////////////////////
	//HEATMAP CHART
	//////////////////////////////////////////////////////
	$week_array = array(
		'Sunday',
		'Monday',
		'Tuesday',
		'Wednesday',
		'Thursday',
		'Friday',
		'Saturday',
	);

	foreach($week_array as $week) {
		for ( $f = 0; $f <= 23; $f ++ ) {
			//for ( $g = 1; $g <= 23; $g ++ ) {
			$g=($f+1==24) ? 0 : ($f+1);
			if(isset($heat_chart_array[$week][$f])){
				if(isset($heat_chart_array_final[$week][$f." - ".$g])){
					$heat_chart_array_final[$week][$f." - ".$g]+=$heat_chart_array[$week][$f];
				}else{
					$heat_chart_array_final[$week][$f." - ".$g]=$heat_chart_array[$week][$f];
				}
			}else{
				$heat_chart_array_final[$week][$f." - ".$g]= 0;
			}

			//}
		}
	}


	$heatmap_html= '<table class="it_heatmap_tbl" width="100%"><tr><td style="display: inline-block;"></td>';
	for ( $g = 1; $g <= 23; $g ++ ) {
		$hour='';
		if($g%3==0) {
			$hour=$g;
			if($hour<12)
				$hour.='am';
//	            if ( $g == 12 ) {
//		            $hour = "N";
//	            }
		}
		$heatmap_html .= '<td class="it_heatmap_chart_head" >' . $hour . '</td>';
	}
	$heatmap_html.='</tr>';

	foreach($week_array as $week){
		$heatmap_html.= '<tr ><td style="display: inline-block;">'.$week[0].'</td>';
		foreach($heat_chart_array_final[$week] as $key=>$circle){
			$value=$circle." #0";
			$main_value=$circle;
			$count=0;

			if(is_array($circle)){
				$value=0;
				foreach($circle as $val){
					$value+=$val;
				}
				$main_value=$value;
				$value=$value.' #'.count($circle);
				$count=count($circle);
			}


			$color=$randomcolor = '#' . dechex(round($main_value)+255);
			$onsale_time="0min";
			if($main_value==0){
				$color="#fff";
				$onesale_time="0min";
			}else{
				$onesale_time=$count!=0 ? (60/$count)."min" : "0 min";
			}



			$heatmap_html.= '<td class="it_int_heatmap_circle" data-value="'.$value.'" data-time="'.$week.', '.$key.'" data-onesale="'.$onesale_time.'" style="background-color: '.$color.';"></td>';
		}
		$heatmap_html.= '</tr>';
	}
	$heatmap_html.= '</table>';

	$avg_rev_sale=$order_count!=0 ? (number_format($net_amnt/$order_count,2 )) : 0;
	$avg_rev_day=$days!=0 ? (float)number_format($net_amnt/$days,2 ) : 0;
	$net_amnt=($net_amnt) == 0 ? $this->price(0) : $this->price($net_amnt);
	$part_refund_amnt=($part_refund_amnt) == 0 ? $this->price(0) : $this->price($part_refund_amnt);
	$avg_rev_sale=($avg_rev_sale) == 0 ? $this->price(0) : $this->price($avg_rev_sale);
	$avg_rev_day=($avg_rev_day) == 0 ? $this->price(0) : $this->price($avg_rev_day);


	$sold_every_html='-';
	$sold_every=1;

	$from=date_create($it_from_date);
	$to=date_create($it_to_date);
	$diff=date_diff($to,$from);

	$days = $diff->format('%a')+1;
	$sold_every_html='';
	if($order_count>0){
		$sold_every = round( $days / $order_count );

		$sold_every = $sold_every * 86400;

		$dtF = new DateTime( "@0" );
		$dtT = new DateTime( "@$sold_every" );

		$year_sold  = $dtF->diff( $dtT )->y;
		$month_sold = $dtF->diff( $dtT )->m;
		$day_sold   = $dtF->diff( $dtT )->d;
		$week_sold=0;
		if ( $day_sold > 7 ) {
			$week_sold = floor( $day_sold / 7 ) ;
			$day_sold=$day_sold-($week_sold*7);
		}
		$hour_sold       = $dtF->diff( $dtT )->h;
		$sold_every_html = ( $year_sold != 0 ? $year_sold . "y " : "" ) . ( $month_sold != 0 ? $month_sold . "m " : "" ) . ( $week_sold != 0 ? $week_sold . "w " : "" ). ( $day_sold != 0 ? $day_sold . "d " : "" ) . ( $hour_sold != 0 ? $hour_sold . "h " : "" );
	}
	//////////////////////////////////////////////////////
	// END HEATMAP CHART
	//////////////////////////////////////////////////////


	$output.= '
        <div class="col-xs-12 col-md-3">
            <div class="int-awr-box pw-main-box">
                <div class="int-awr-box-content">
                    <div class="pw-box-padder">
                        <div class="pw-pull-left pw-val">'.$net_amnt.'
                            <div class="pw-pull-right">
                            '.$percentage_down_up_html.'
                            </div>
                        </div>
                        <div class="pw-pull-right">
                            $net_amnt/User (ARPU)
                        </div>
                    </div>

                    <div id="it_int_sale_chartdiv"></div>

                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-3">
            <div class="int-awr-box pw-main-box">

                <div class="int-awr-box-content">

                    <div class="pw-box-padder it_heatmap_chart">
                    </div>
                    <div class="pw-box-padder">
                        <div class="pw-pull-left pw-center-align">
                            <div class="pw-val pw-sm-font it_int_heatmap_time">
                                '.$it_from_date.' - '.$it_to_date.'
                            </div>
                            <span class="pw-blue pw-sm-font it_int_heatmap_value">
                                '.$net_amnt.'#'.$order_count.'
                            </span>
                        </div>
                        <div class="pw-pull-left pw-center-align pw-col2">
                            <div class="pw-val pw-sm-font">
                                '.esc_html__('One Sale Every',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'
                            </div>
                            <span class="pw-blue pw-sm-font it_int_heatmap_onesale">
                                '.$sold_every_html.'
                            </span>
                        </div>
                    </div>
                </div>

            </div>
        </div>
        <div class="pw-cols col-xs-12 col-md-3">
            <div class="int-awr-box pw-main-box">
                <div class="int-awr-box-content">
                    <div class="pw-box-padder">
                        <div id="it_int_customer_chartdiv"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pw-cols col-xs-12 col-md-3">
            <div class="int-awr-box pw-main-box pw-main-box-half">
                <div class="int-awr-box-content">
                    <div class="pw-box-padder">
                    </div>
                </div>
            </div>
        </div>
        <div class="pw-cols col-xs-12 col-md-3">
            <div class="int-awr-box pw-main-box pw-main-box-half ">
                <div class="int-awr-box-content">
                    <div class="pw-box-padder">
                    </div>
                </div>
            </div>
        </div>
        <div class="col-xs-12 col-md-9">
            <div class="int-awr-box pw-center-align pw-pr-sum-box">
                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="pw-box-padder">
                        <div class="pw-lg-font pw-green">'.$net_amnt.'#'.$order_count.'</div>
                        <div class="pw-val pwl-lbl">'.esc_html__('NET SALES',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="pw-box-padder">
                        <div class="pw-lg-font pw-green">'.$part_refund_amnt.'</div>
                        <div class="pw-val pwl-lbl">'.esc_html__('REFUNDS',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="pw-box-padder">
                        <div class="pw-lg-font pw-green">'.$avg_rev_sale.'</div>
                        <div class="pw-val pwl-lbl">'.esc_html__('AVERAGE REVENUE / SALE',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                    </div>
                </div>

                <div class="col-xs-12 col-sm-6 col-md-3">
                    <div class="pw-box-padder">
                        <div class="pw-lg-font pw-green">'.$avg_rev_day.'</div>
                        <div class="pw-val pwl-lbl">'.esc_html__('AVERAGE REVENUE / DAY',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                    </div>
                </div>
            </div>
        </div>
        <div class="pw-cols col-xs-12 col-md-3">
            <div class="int-awr-box int-fixed-height-box">
                <div class="awr-title">
                    <h3>
                        <i class="fa fa-money"></i>'.esc_html__('Recent Transactions',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'

                    </h3>

                </div>

                <div class="int-awr-box-content">
                    <div class="pw-box-padder">
                    </div>
                </div>
            </div>
        </div>

        <div class="pw-cols col-xs-6 col-md-6 col-lg-6">
            <div class="int-awr-box int-fixed-height-box">
                <div class="awr-title">
                    <h3>
                        <i class="fa fa-money"></i>'.esc_html__('Top Products',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'

                    </h3>

                </div>

                <div class="int-awr-box-content">
                    <div class="pw-box-padder">
                    </div>
                </div>
            </div>
        </div>

        <div class="pw-cols col-xs-6 col-md-6 col-lg-6">
            <div class="int-awr-box int-fixed-height-box">

                <div class="int-awr-box-content">
                    <div class="pw-box-padder">
                    </div>
                </div>
            </div>
        </div>
        ';

	$table_html='';
	//print_r($customer_array);
	foreach($customer_array as $customer){

		$it_table_value_status = $customer['status'];

		if($it_table_value_status=='wc-completed')
			$it_table_value_status = '<span class="awr-order-status awr-order-status-'.sanitize_title($it_table_value_status).'" >'.$this->price($customer['total']).'</span>';
		else if($it_table_value_status=='wc-refunded')
			$it_table_value_status = '<span class="awr-order-status awr-order-status-'.sanitize_title($it_table_value_status).'" >'.$this->price($customer['total']).'</span>';
		else
			$it_table_value_status = '<span class="awr-order-status awr-order-status-'.sanitize_title($it_table_value_status).'" >'.$this->price($customer['total']).'</span>';

		$table_html.='<tr role="row" class="odd"><td style="" data-order-id="'.$customer['order_id'].'"><a target="_blank" href="'.admin_url().'post.php?post='.$customer['order_id'].'&action=edit">'.$customer['order_id'].'</a></td><td style="">'.$customer['date'].'</td><td style="">'.$customer['name'].'</td><td style="">'.$it_table_value_status.'</td></tr>';
	}



	//////////////////////////////////////////////////////
	/// SORT ARRAY BY DATE
	//////////////////////////////////////////////////////
	function array_sort_by_column(&$arr, $col, $dir = SORT_ASC) {
		$sort_col = array();
		foreach ($arr as $key=> $row) {
			$sort_col[$key] = $row[$col];
		}

		array_multisort($sort_col, $dir, $arr);
	}

	array_sort_by_column($sale_chart_array, 'date');


	?>
    <script>
        var chart_int_data=<?php echo json_encode(($sale_chart_array)); ?>;
    </script>
	<?php
}elseif($file_used=="search_form"){
	global $it_rpt_main_class;
	$this->it_get_date_form_to();
	$it_from_date=$it_rpt_main_class->it_from_date_dashboard;
	$it_to_date=$it_rpt_main_class->it_to_date_dashboard;
	?>
    <form class='alldetails search_form_report' action='' method='post' id="intelligence_customer_datatable">
        <input type='hidden' name='action' value='submit-form' />


        <input type='hidden' name='action' value='submit-form' />
        <input type='hidden' name="it_from_date" id="pwr_from_date_dashboard" value="<?php echo $it_from_date;?>"/>
        <input type='hidden' name="it_to_date" id="pwr_to_date_dashboard"  value="<?php echo $it_to_date;?>"/>


        <button type="submit" value="Search" class="button-primary"><i class="fa fa-search"></i> <span><?php echo esc_html__('Search',__IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
        <div id="dashboard-report-range" class="pull-right tooltips  btn-fit-height grey-salt" data-placement="top" data-original-title="Change dashboard date range">
            <div id="reportrange" class="pull-right" style="background: #fff; cursor: pointer; padding: 5px 10px; border: 1px solid #ccc; width: 100%">
                <i class="fa fa-calendar"></i>&nbsp;
                <span></span> <b class="caret"></b>
            </div>
        </div>



        <div class="col-md-12 awr-save-form">

			<?php
			$it_hide_os=$this->otder_status_hide;
			$it_publish_order='no';
			$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);
			?>
            <input type="hidden" name="it_id_order_status[]" id="it_id_order_status" value="-1">
            <input type="hidden" name="it_orders_status[]" id="order_status" value="<?php echo $this->it_shop_status; ?>">
            <input type="hidden" name="it_hide_os" value="<?php echo $it_hide_os;?>" />
            <input type="hidden" name="publish_order" value="<?php echo $it_publish_order;?>" />
            <input type="hidden" name="list_parent_category" value="">
            <input type="hidden" name="it_category_id" value="-1">
            <input type="hidden" name="group_by_parent_cat" value="0">

            <input type="hidden" name="it_hide_os" id="it_hide_os" value="<?php echo $it_hide_os;?>" />

            <input type="hidden" name="date_format" id="date_format" value="<?php echo $data_format;?>" />

            <input type="hidden" name="table_names" value="<?php echo $table_name;?>"/>
            <div class="fetch_form_loading search-form-loading"></div>

        </div>

    </form>
	<?php
}
//print_r($sale_chart_array);
//echo json_encode($sale_chart_array);
?>
