<?php
if ($file_used == "sql_table") {
    $request = array();
    $start   = 0;

    $it_from_date = $this->it_get_woo_requests('it_from_date', null, true);
    $it_to_date   = $this->it_get_woo_requests('it_to_date', null, true);
    $date_format  = $this->it_date_format($it_from_date);

    //CUSTOM WORK - 11899
    $it_from_date_delivery = $this->it_get_woo_requests('it_from_date_delivery', null, true);
    $it_to_date_delivery   = $this->it_get_woo_requests('it_to_date_delivery', null, true);

    $it_id_order_status = $this->it_get_woo_requests('it_id_order_status', null, true);
    $it_paid_customer   = $this->it_get_woo_requests('it_customers_paid', null, true);
    $txtProduct         = $this->it_get_woo_requests('txtProduct', null, true);
    $it_product_id      = $this->it_get_woo_requests('it_product_id', "-1", true);
    $category_id        = $this->it_get_woo_requests('it_category_id', '-1', true);

    ////ADDED IN VER4.0
    //BRANDS ADDONS
    $brand_id = $this->it_get_woo_requests('it_brand_id', '-1', true);

    $limit = $this->it_get_woo_requests('limit', 15, true);
    $p     = $this->it_get_woo_requests('p', 1, true);

    $page     = $this->it_get_woo_requests('page', null, true);
    $order_id = $this->it_get_woo_requests('it_id_order', null, true);
    if ($order_id) {
        $order_id = "'" . str_replace(",", "','", $order_id) . "'";
    }

    $it_from_date = $this->it_get_woo_requests('it_from_date', null, true);
    $it_to_date   = $this->it_get_woo_requests('it_to_date', null, true);

    $it_txt_email = $this->it_get_woo_requests('it_email_text', null, true);

    $it_txt_first_name = $this->it_get_woo_requests('it_first_name_text', null, true);

    $it_detail_view     = 'yes';
    $it_country_code    = $this->it_get_woo_requests('it_countries_code', null, true);
    $state_code         = $this->it_get_woo_requests('it_states_code', '-1', true);
    $it_payment_method  = $this->it_get_woo_requests('payment_method', null, true);
    $it_order_item_name = $this->it_get_woo_requests('order_item_name', null, true);//for coupon
    $it_coupon_code     = $this->it_get_woo_requests('coupon_code', null, true);//for coupon

    $it_publish_order  = $this->it_get_woo_requests('publish_order', 'no',
        true);//if publish display publish order only, no or null display all order
    $it_coupon_used    = $this->it_get_woo_requests('it_use_coupon', 'no', true);
    $it_order_meta_key = $this->it_get_woo_requests('order_meta_key', '-1', true);
    $it_order_status   = $this->it_get_woo_requests('it_orders_status', '-1', true);
    //$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

    $it_paid_customer = str_replace(",", "','", $it_paid_customer);
    //$it_country_code		= str_replace(",","','",$it_country_code);
    //$state_code		= str_replace(",","','",$state_code);
    //$it_country_code		= str_replace(",","','",$it_country_code);

    $it_coupon_code  = $this->it_get_woo_requests('coupon_code', '-1', true);
    $it_coupon_codes = $this->it_get_woo_requests('it_codes_of_coupon', '-1', true);

    $it_coupon_code  = '';
    $it_coupon_codes = '';
    ////////////////////CUSTOM WORK/////////////////////
    $it_coupon_code  = $this->it_get_woo_requests('coupon_code', '-1', true);
    $it_coupon_codes = $this->it_get_woo_requests('it_codes_of_coupon', '-1', true);
    //echo $it_coupon_codes;
    if ($it_coupon_codes != "-1") {
        $it_coupon_codes = "'" . str_replace(",", "','", $it_coupon_codes) . "'";
    }

    //echo $it_coupon_codes;
    $coupon_discount_types = $this->it_get_woo_requests('it_coupon_discount_types', '-1', true);
    if ($coupon_discount_types != "-1") {
        $coupon_discount_types = "'" . str_replace(",", "','", $coupon_discount_types) . "'";
    }


    $it_max_amount = $this->it_get_woo_requests('max_amount', '-1', true);
    $it_min_amount = $this->it_get_woo_requests('min_amount', '-1', true);

    $it_billing_post_code = $this->it_get_woo_requests('it_bill_post_code', '-1', true);

    ////ADDED IN V4.0
    $it_variation_id   = $this->it_get_woo_requests('it_variation_id', '-1', true);
    $it_variation_only = $this->it_get_woo_requests('it_variation_only', '-1', true);
    $it_variations     = $it_item_meta_key = '';
    if ($it_variation_id != '-1' and strlen($it_variation_id) > 0) {

        $it_variations = explode(",", $it_variation_id);
        //$this->print_array($it_variations);
        $var      = array();
        $item_att = array();
        foreach ($it_variations as $key => $value):
            $var[]      .= "attribute_pa_" . $value;
            $var[]      .= "attribute_" . $value;
            $item_att[] .= "pa_" . $value;
            $item_att[] .= $value;
        endforeach;
        $it_variations    = implode("', '", $var);
        $it_item_meta_key = implode("', '", $item_att);
    }
    $it_variation_attributes    = $it_variations;
    $it_variation_item_meta_key = $it_item_meta_key;

    $it_hide_os = $this->it_get_woo_requests('it_hide_os', '"trash"', true);

    $it_show_cog = $this->it_get_woo_requests('it_show_cog', 'no', true);

    ///////////HIDDEN FIELDS////////////
    $it_hide_os         = $this->otder_status_hide;
    $it_publish_order   = 'no';
    $it_order_item_name = '';

    $it_payment_method = '';

    $it_order_meta_key = '';

    $data_format = $this->it_get_woo_requests('date_format', get_option('date_format'), true);

    $amont_zero = '';
    //////////////////////

    /////////////////////////
    //APPLY PERMISSION TERMS
    $key = 'all_orders';

    $category_id = $this->it_get_form_element_permission('it_category_id', $category_id, $key);

    ////ADDED IN VER4.0
    //BRANDS ADDONS
    $brand_id = $this->it_get_form_element_permission('it_brand_id', $brand_id, $key);

    $it_product_id = $this->it_get_form_element_permission('it_product_id', $it_product_id, $key);

    $it_country_code = $this->it_get_form_element_permission('it_countries_code', $it_country_code, $key);

    if ($it_country_code != null && $it_country_code != '-1') {
        $it_country_code = "'" . str_replace(",", "','", $it_country_code) . "'";
    }

    $state_code = $this->it_get_form_element_permission('it_states_code', $state_code, $key);

    if ($state_code != null && $state_code != '-1') {
        $state_code = "'" . str_replace(",", "','", $state_code) . "'";
    }

    $it_order_status = $this->it_get_form_element_permission('it_orders_status', $it_order_status, $key);

    if ($it_order_status != null && $it_order_status != '-1') {
        $it_order_status = "'" . str_replace(",", "','", $it_order_status) . "'";
    }
    ///////////////////////////


    $it_variations_formated = '';

    if (strlen($it_max_amount) <= 0) {
        $_REQUEST['max_amount'] = $it_max_amount = '-1';
    }
    if (strlen($it_min_amount) <= 0) {
        $_REQUEST['min_amount'] = $it_min_amount = '-1';
    }

    if ($it_max_amount != '-1' || $it_min_amount != '-1') {
        if ($it_order_meta_key == '-1') {
            $_REQUEST['order_meta_key'] = "_order_total";
        }
    }

    $last_days_orders = "0";
    if (is_array($it_id_order_status)) {
        $it_id_order_status = implode(",", $it_id_order_status);
    }
    if (is_array($category_id)) {
        $category_id = implode(",", $category_id);
    }

    /////ADDED IN VER4.0
    //BRANDS ADDONS
    if (is_array($brand_id)) {
        $brand_id = implode(",", $brand_id);
    }

    if ( ! $it_from_date) {
        $it_from_date = date_i18n('Y-m-d');
    }
    if ( ! $it_to_date) {
        $last_days_orders = apply_filters($page . '_back_day', $last_days_orders);//-1,-2,-3,-4,-5
        $it_to_date       = date('Y-m-d', strtotime($last_days_orders . ' day', strtotime(date_i18n("Y-m-d"))));
    }

    $it_sort_by  = $this->it_get_woo_requests('sort_by', 'order_id', true);
    $it_order_by = $this->it_get_woo_requests('order_by', 'DESC', true);
    ///

    if ($p > 1) {
        $start = ($p - 1) * $limit;
    }

    if ($it_detail_view == "yes") {
        $it_variations_value    = $this->it_get_woo_requests('variations_value', "-1", true);
        $it_variations_formated = '-1';
        if ($it_variations_value != "-1" and strlen($it_variations_value) > 0) {
            $it_variations_value = explode(",", $it_variations_value);
            $var                 = array();
            foreach ($it_variations_value as $key => $value):
                $var[] .= $value;
            endforeach;
            $result = array_unique($var);
            //$this->print_array($var);
            $it_variations_formated = implode("', '", $result);
        }
        $_REQUEST['variations_formated'] = $it_variations_formated;
    }


    //it_first_name_text
    $it_txt_first_name_cols        = '';
    $it_txt_first_name_join        = '';
    $it_txt_first_name_condition_1 = '';
    $it_txt_first_name_condition_2 = '';

    //it_email_text
    $it_txt_email_cols        = '';
    $it_txt_email_join        = '';
    $it_txt_email_condition_1 = '';
    $it_txt_email_condition_2 = '';

    //SORT BY
    $it_sort_by_cols = '';

    //CATEGORY
    $category_id_join      = '';
    $category_id_condition = '';

    ////ADDED IN VER4.0
    //BRANDS ADDONS
    $brand_id_join      = '';
    $brand_id_condition = '';

    //ORDER ID
    $it_id_order_status_join      = '';
    $it_id_order_status_condition = '';

    //COUNTRY
    $it_country_code_join        = '';
    $it_country_code_condition_1 = '';
    $it_country_code_condition_2 = '';

    //STATE
    $state_code_join        = '';
    $state_code_condition_1 = '';
    $state_code_condition_2 = '';

    //PAYMENT METHOD
    $it_payment_method_join        = '';
    $it_payment_method_condition_1 = '';
    $it_payment_method_condition_2 = '';

    //POSTCODE
    $it_billing_post_code_join      = '';
    $it_billing_post_code_condition = '';

    //COUPON USED
    $it_coupon_used_join      = '';
    $it_coupon_used_condition = '';

    //VARIATION ID
    $it_variation_id_join      = '';
    $it_variation_id_condition = '';

    ////ADDED IN V4.0
    //VARIATION
    $it_variation_item_meta_key_join      = '';
    $sql_variation_join                   = '';
    $it_show_variation_join               = '';
    $it_variation_item_meta_key_condition = '';
    $sql_variation_condition              = '';

    //VARIATION ONLY
    $it_variation_only_join      = '';
    $it_variation_only_condition = '';

    //VARIATION FORMAT
    $it_variations_formated_join      = '';
    $it_variations_formated_condition = '';

    //ORDER META KEY
    $it_order_meta_key_join      = '';
    $it_order_meta_key_condition = '';

    //COUPON CODES
    $it_coupon_codes_join      = '';
    $it_coupon_codes_condition = '';

    //COUPON CODE
    $it_coupon_code_condition = '';

    //DATA CONDITION
    $date_condition = '';

    //CUSTOM WORK - 11899
    //DELIVERY DATA CONDITION
    $date_delivery_condition = '';
    $delivery_date_join      = '';

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
    $it_show_cog_cols      = '';
    $it_show_cog_join      = '';
    $it_show_cog_condition = '';


    if (($it_txt_first_name and $it_txt_first_name != '-1') || $it_sort_by == "billing_name") {
        $it_txt_first_name_cols = " CONCAT(it_postmeta1.meta_value, ' ', it_postmeta2.meta_value) AS billing_name,";
    }
    if ($it_txt_email || ($it_paid_customer && $it_paid_customer != '-1' and $it_paid_customer != "'-1'") || $it_sort_by == "billing_email") {
        $it_txt_email_cols = " postmeta.meta_value AS billing_email,";
    }

    if ($it_sort_by == "status") {
        $it_sort_by_cols = " terms2.name as status, ";
    }
    $sql_columns = " $it_txt_first_name_cols $it_txt_email_cols $it_sort_by_cols";
    $sql_columns .= "
		IF ( (woocommerce_order_itemmeta.meta_key = '_fee_amount'), 1, 0) AS fee,

        DATE_FORMAT(it_posts.post_date,'%m/%d/%Y') 													AS order_date,
		it_woocommerce_order_items.order_id 															AS order_id,
		it_woocommerce_order_items.order_item_name 													AS product_name,
		it_woocommerce_order_items.order_item_id														AS order_item_id,
		woocommerce_order_itemmeta.meta_value 														AS woocommerce_order_itemmeta_meta_value,
		(it_woocommerce_order_itemmeta2.meta_value/it_woocommerce_order_itemmeta3.meta_value) 			AS sold_rate,
		IF ( (woocommerce_order_itemmeta.meta_key = '_fee_amount'), woocommerce_order_itemmeta.meta_value , (it_woocommerce_order_itemmeta4.meta_value/it_woocommerce_order_itemmeta3.meta_value))AS product_rate,

		IF ( (woocommerce_order_itemmeta.meta_key = '_fee_amount'), woocommerce_order_itemmeta.meta_value , (it_woocommerce_order_itemmeta4.meta_value))AS item_amount,
		(it_woocommerce_order_itemmeta2.meta_value) 													AS item_net_amount,
		(it_woocommerce_order_itemmeta4.meta_value - it_woocommerce_order_itemmeta2.meta_value) 			AS item_discount,
		it_woocommerce_order_itemmeta2.meta_value 														AS total_price,
		count(it_woocommerce_order_items.order_item_id) 												AS product_quentity,
		woocommerce_order_itemmeta.meta_value 														AS product_id,
		woocommerce_order_itemmeta_var.meta_value 														AS variation_id

		,it_woocommerce_order_itemmeta3.meta_value 													AS 'product_quantity'
		,it_posts.post_status 																			AS post_status
		,it_posts.post_status 																			AS order_status

		";

//		if($it_variation_id  && $it_variation_id != "-1") {
//			$sql_columns .= " ,woocommerce_order_itemmeta22.meta_value AS variation_id ";
//		}

    ////ADDED IN V4.0
    if (($it_variation_item_meta_key != "-1" and strlen($it_variation_item_meta_key) > 1)) {
        $sql_columns .= " , it_woocommerce_order_itemmeta_variation.meta_key AS variation_key";
        $sql_columns .= " , it_woocommerce_order_itemmeta_variation.meta_value AS variation_value";
    }

    ////ADDED IN VER4.0
    /// COST OF GOOD
    if ($it_show_cog == "yes") {
        $sql_columns .= " ,woo_itemmeta_cog.meta_value as cog ";
    }


    $sql_joins = "{$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items

		LEFT JOIN  {$wpdb->prefix}posts as it_posts ON it_posts.ID=it_woocommerce_order_items.order_id

		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as woocommerce_order_itemmeta 	ON woocommerce_order_itemmeta.order_item_id		=	it_woocommerce_order_items.order_item_id

    LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as woocommerce_order_itemmeta_var 	ON woocommerce_order_itemmeta_var.order_item_id		=	it_woocommerce_order_items.order_item_id";

    ////ADDED IN V4.0
    if (($it_variation_item_meta_key != "-1" and strlen($it_variation_item_meta_key) > 1)) {
        $it_variation_item_meta_key_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_variation ON it_woocommerce_order_itemmeta_variation.order_item_id= it_woocommerce_order_items.order_item_id";
    }


    $sql_joins .= "
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta2 	ON it_woocommerce_order_itemmeta2.order_item_id	=	it_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta3 	ON it_woocommerce_order_itemmeta3.order_item_id	=	it_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta4 	ON it_woocommerce_order_itemmeta4.order_item_id	=	it_woocommerce_order_items.order_item_id AND it_woocommerce_order_itemmeta4.meta_key='_line_subtotal'

        ";


    if ($category_id && $category_id != "-1") {
        $category_id_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships 			ON it_term_relationships.object_id		=	woocommerce_order_itemmeta.meta_value
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy 				ON term_taxonomy.term_taxonomy_id	=	it_term_relationships.term_taxonomy_id";
        //LEFT JOIN  {$wpdb->prefix}terms 				as it_terms 						ON it_terms.term_id					=	term_taxonomy.term_id";
    }

    /////ADDED IN VER4.0
    //BRANDS ADDONS
    if ($brand_id && $brand_id != "-1") {
        $brand_id_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships_brand 			ON it_term_relationships_brand.object_id		=	woocommerce_order_itemmeta.meta_value
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy_brand				ON term_taxonomy_brand.term_taxonomy_id	=	it_term_relationships_brand.term_taxonomy_id";
        //LEFT JOIN  {$wpdb->prefix}terms 				as it_terms_brand 						ON it_terms_brand.term_id					=	term_taxonomy_brand.term_id";
    }

    if (($it_id_order_status && $it_id_order_status != '-1') || $it_sort_by == "status") {
        $it_id_order_status_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships2			ON it_term_relationships2.object_id	= it_woocommerce_order_items.order_id
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as it_term_taxonomy2				ON it_term_taxonomy2.term_taxonomy_id	= it_term_relationships2.term_taxonomy_id";
        if ($it_sort_by == "status") {
            $it_id_order_status_join .= " LEFT JOIN  {$wpdb->prefix}terms 	as terms2 						ON terms2.term_id					=	it_term_taxonomy2.term_id";
        }
    }

    if ($it_txt_email || ($it_paid_customer && $it_paid_customer != '-1' and $it_paid_customer != "'-1'") || $it_sort_by == "billing_email") {
        $it_txt_email_join = "
				LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id=it_woocommerce_order_items.order_id";
    }
    if (($it_txt_first_name and $it_txt_first_name != '-1') || $it_sort_by == "billing_name") {
        $it_txt_first_name_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta1 ON it_postmeta1.post_id=it_woocommerce_order_items.order_id
			LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta2 ON it_postmeta2.post_id=it_woocommerce_order_items.order_id";
    }

    if ($it_country_code and $it_country_code != '-1') {
        $it_country_code_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta4 ON it_postmeta4.post_id=it_woocommerce_order_items.order_id";
    }

    if ($state_code && $state_code != '-1') {
        $state_code_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta_billing_state ON it_postmeta_billing_state.post_id=it_posts.ID";
    }

    if ($it_payment_method) {
        $it_payment_method_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta5 ON it_postmeta5.post_id=it_woocommerce_order_items.order_id";
    }

    if ($it_billing_post_code and $it_billing_post_code != '-1') {
        $it_billing_post_code_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta_billing_postcode ON it_postmeta_billing_postcode.post_id	=	it_posts.ID";
    }

    if ($it_coupon_used == "yes") {
        $it_coupon_used_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta6 ON it_postmeta6.post_id=it_woocommerce_order_items.order_id";
    }

    if ($it_coupon_used == "yes") {
        $it_coupon_used_join .= " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta7 ON it_postmeta7.post_id=it_posts.ID";
    }

//		if($it_variation_id  && $it_variation_id != "-1") {
//			$it_variation_id_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta_variation			ON it_woocommerce_order_itemmeta_variation.order_item_id 		= 	it_woocommerce_order_items.order_item_id";
//		}

    if ($it_variation_only && $it_variation_only != "-1" && $it_variation_only == "yes") {
        $it_variation_only_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta_variation_o			ON it_woocommerce_order_itemmeta_variation_o.order_item_id 		= 	it_woocommerce_order_items.order_item_id";
    }

    if ($it_variations_formated != "-1" and $it_variations_formated != null) {
        $it_variations_formated_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta8 ON it_woocommerce_order_itemmeta8.order_item_id = it_woocommerce_order_items.order_item_id";
        $it_variations_formated_join .= " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta_variation ON it_postmeta_variation.post_id = it_woocommerce_order_itemmeta8.meta_value";
    }

    if ($it_order_meta_key and $it_order_meta_key != '-1') {
        $it_order_meta_key_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_order_meta_key ON it_order_meta_key.post_id=it_posts.ID";
    }

    if (($it_coupon_codes != '' && $it_coupon_codes != "-1") or ($it_coupon_code && $it_coupon_code != "-1")) {
        $it_coupon_codes_join = " LEFT JOIN {$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_coupon_item ON it_woocommerce_order_coupon_item.order_id = it_posts.ID AND it_woocommerce_order_coupon_item.order_item_type = 'coupon'";
    }


    ////ADDED IN VER4.0
    /// COST OF GOOD
    if ($it_show_cog == "yes") {
        $it_show_cog_join = " LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as woo_itemmeta_cog ON woocommerce_order_itemmeta.order_item_id	=	woo_itemmeta_cog.order_item_id  ";
    }


    //CUSTOM WORK - 11899
    if ($it_from_date_delivery != null && $it_to_date_delivery != null) {
        $delivery_date_join      = " LEFT JOIN {$wpdb->prefix}postmeta as it_delivery ON it_delivery.post_id=it_posts.ID ";
        $date_delivery_condition .= " AND it_delivery.meta_key='_delivery_date' ";
    }

    $post_type_condition = "it_posts.post_type = 'shop_order' AND billing_country.meta_key	= '_billing_country' ";
    $post_type_condition = "";


    if ($it_txt_email || ($it_paid_customer && $it_paid_customer != '-1' and $it_paid_customer != "'-1'") || $it_sort_by == "billing_email") {
        $it_txt_email_condition_1 = "
				AND postmeta.meta_key='_billing_email'";
    }

    if (($it_txt_first_name and $it_txt_first_name != '-1') || $it_sort_by == "billing_name") {
        $it_txt_first_name_condition_1 = "
				AND it_postmeta1.meta_key='_billing_first_name'
				AND it_postmeta2.meta_key='_billing_last_name'";
    }

    $other_condition_1 = "
		((woocommerce_order_itemmeta.meta_key = '_product_id'  AND it_woocommerce_order_itemmeta3.meta_key='_qty') OR (woocommerce_order_itemmeta.meta_key = '_fee_amount'))


		AND woocommerce_order_itemmeta_var.meta_key = '_variation_id'

		AND it_woocommerce_order_itemmeta2.meta_key='_line_total'
		";

    //AND woocommerce_order_itemmeta.meta_key = '_product_id'
    //AND it_woocommerce_order_itemmeta3.meta_key='_qty'
//
//		if($it_variation_id  && $it_variation_id != "-1") {
//			$other_condition_1 .= " AND woocommerce_order_itemmeta22.meta_key = '_variation_id' ";
//		}


    if ($it_country_code and $it_country_code != '-1') {
        $it_country_code_condition_1 = " AND it_postmeta4.meta_key='_billing_country'";
    }

    if ($state_code && $state_code != '-1') {
        $state_code_condition_1 = " AND it_postmeta_billing_state.meta_key='_billing_state'";
    }

    if ($it_billing_post_code and $it_billing_post_code != '-1') {
        $it_billing_post_code_condition = " AND it_postmeta_billing_postcode.meta_key='_billing_postcode' AND it_postmeta_billing_postcode.meta_value LIKE '%{$it_billing_post_code}%' ";
    }

    if ($it_payment_method) {
        $it_payment_method_condition_1 = " AND it_postmeta5.meta_key='_payment_method_title'";
    }

    if ($it_from_date != null && $it_to_date != null) {

        $date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format')";

        //$date_condition = " AND DATE(it_posts.post_date) BETWEEN ('" . $it_from_date . "') and ('" . $it_to_date . "') ";
        //$date_condition = '';

    }


    //CUSTOM WORK - 11899
    if ($it_from_date_delivery != null && $it_to_date_delivery != null) {
        $date_delivery_condition = " AND it_delivery.meta_value BETWEEN '" . $it_from_date_delivery . "' AND '" . $it_to_date_delivery . "'";
    }

    if ($order_id) {
        $order_id_condition = " AND it_woocommerce_order_items.order_id IN (" . $order_id . ") ";
    }

    if ($it_txt_email) {
        $it_txt_email_condition_2 = " AND postmeta.meta_value LIKE '%" . $it_txt_email . "%'";
    }

    if ($it_paid_customer && $it_paid_customer != '-1' and $it_paid_customer != "'-1'") {
        $it_paid_customer_condition = " AND postmeta.meta_value IN ('" . $it_paid_customer . "')";
    }

    //if($it_txt_first_name and $it_txt_first_name != '-1') $sql .= " AND (it_postmeta1.meta_value LIKE '%".$it_txt_first_name."%' OR it_postmeta2.meta_value LIKE '%".$it_txt_first_name."%')";
    if ($it_txt_first_name and $it_txt_first_name != '-1') {
        $it_txt_first_name_condition_2 = " AND (lower(concat_ws(' ', it_postmeta1.meta_value, it_postmeta2.meta_value)) like lower('%" . $it_txt_first_name . "%') OR lower(concat_ws(' ', it_postmeta2.meta_value, it_postmeta1.meta_value)) like lower('%" . $it_txt_first_name . "%'))";
    }

    //if($it_id_order_status  && $it_id_order_status != "-1") $sql .= " AND terms2.term_id IN (".$it_id_order_status .")";

    if ($it_publish_order == 'yes') {
        $it_publish_order_condition_1 = " AND it_posts.post_status = 'publish'";
    }

    if ($it_publish_order == 'publish' || $it_publish_order == 'trash') {
        $it_publish_order_condition_2 = " AND it_posts.post_status = '" . $it_publish_order . "'";
    }

    //if($it_country_code and $it_country_code != '-1')	$sql .= " AND it_postmeta4.meta_value LIKE '%".$it_country_code."%'";

    //if($state_code and $state_code != '-1')	$sql .= " AND it_postmeta_billing_state.meta_value LIKE '%".$state_code."%'";

    if ($it_country_code and $it_country_code != '-1') {
        $it_country_code_condition_2 = " AND it_postmeta4.meta_value IN (" . $it_country_code . ")";
    }

    if ($state_code && $state_code != '-1') {
        $state_code_condition_2 = " AND it_postmeta_billing_state.meta_value IN (" . $state_code . ")";
    }

    if ($it_payment_method) {
        $it_payment_method_condition_2 = " AND it_postmeta5.meta_value LIKE '%" . $it_payment_method . "%'";
    }

    if ($it_order_meta_key and $it_order_meta_key != '-1') {
        $it_order_meta_key_condition = " AND it_order_meta_key.meta_key='{$it_order_meta_key}' AND it_order_meta_key.meta_value > 0";
    }

    if ($it_order_item_name) {
        $it_order_item_name_condition = " AND it_woocommerce_order_items.order_item_name LIKE '%" . $it_order_item_name . "%'";
    }

    if ($txtProduct && $txtProduct != '-1') {
        $txtProduct_condition = " AND it_woocommerce_order_items.order_item_name LIKE '%" . $txtProduct . "%'";
    }

    if ($it_product_id && $it_product_id != "-1") {
        $it_product_id_condition = " AND woocommerce_order_itemmeta.meta_value IN (" . $it_product_id . ")";
    }

    //if($category_id  && $category_id != "-1") $sql .= " AND it_terms.name NOT IN('simple','variable','grouped','external') AND term_taxonomy.taxonomy LIKE('product_cat') AND term_taxonomy.term_id IN (".$category_id .")";
    if ($category_id && $category_id != "-1") {
        $category_id_condition = " AND term_taxonomy.taxonomy LIKE('product_cat') AND term_taxonomy.term_id IN (" . $category_id . ")";
    }

    ////ADDED IN VER4.0
    //BRANDS ADDONS
    if ($brand_id && $brand_id != "-1") {
        $brand_id_condition = " AND term_taxonomy_brand.taxonomy LIKE('" . __IT_BRAND_SLUG__ . "') AND term_taxonomy_brand.term_id IN (" . $brand_id . ")";
    }


    if ($it_id_order_status && $it_id_order_status != "-1") {
        $it_id_order_status_condition = " AND it_term_taxonomy2.taxonomy LIKE('shop_order_status') AND it_term_taxonomy2.term_id IN (" . $it_id_order_status . ")";
    }

    if ($it_coupon_used == "yes") {
        $it_coupon_used_condition = " AND( (it_postmeta6.meta_key='_order_discount' AND it_postmeta6.meta_value > 0) ||  (it_postmeta7.meta_key='_cart_discount' AND it_postmeta7.meta_value > 0))";
    }


    if ($it_coupon_code != '' && $it_coupon_code != "-1") {
        $it_coupon_code_condition = " AND (it_woocommerce_order_coupon_item.order_item_name IN ('{$it_coupon_code}') OR it_woocommerce_order_coupon_item.order_item_name LIKE '%{$it_coupon_code}%')";
    }
    //echo $it_coupon_codes.'---';

    if ($it_coupon_codes != '' && $it_coupon_codes != "-1") {
        $it_coupon_codes_condition = " AND it_woocommerce_order_coupon_item.order_item_name IN ({$it_coupon_codes})";
    }

//		if($it_variation_id  && $it_variation_id != "-1") {
//			$it_variation_id_condition = " AND it_woocommerce_order_itemmeta_variation.meta_key = '_variation_id' AND it_woocommerce_order_itemmeta_variation.meta_value IN (".$it_variation_id .")";
//		}

    if ($it_variation_only && $it_variation_only != "-1" && $it_variation_only == "yes") {
        $it_variation_only_condition = " AND it_woocommerce_order_itemmeta_variation_o.meta_key 	= '_variation_id'
					 AND (it_woocommerce_order_itemmeta_variation_o.meta_value IS NOT NULL AND it_woocommerce_order_itemmeta_variation_o.meta_value > 0)";
    }

    ////ADDED IN V4.0
    if (($it_variation_item_meta_key != "-1" and strlen($it_variation_item_meta_key) > 1)) {
        $it_variation_item_meta_key_condition = " AND it_woocommerce_order_itemmeta_variation.meta_key IN ('{$it_variation_item_meta_key}')";
    }

    if ($it_variations_formated != "-1" and $it_variations_formated != null) {
        $it_variations_formated_condition = "
			AND it_woocommerce_order_itemmeta8.meta_key = '_variation_id' AND (it_woocommerce_order_itemmeta8.meta_value IS NOT NULL AND it_woocommerce_order_itemmeta8.meta_value > 0)";
        $it_variations_formated_condition .= "
			AND it_postmeta_variation.meta_value IN ('{$it_variations_formated}')";
    }

    ////ADDED IN VER4.0
    /// COST OF GOOD
    if ($it_show_cog == "yes") {
        $it_show_cog_condition = " AND woo_itemmeta_cog.meta_key='" . __IT_COG_TOTAL__ . "' ";
    }


    if ($it_order_status && $it_order_status != '-1' and $it_order_status != "'-1'") {
        $it_order_status_condition = " AND it_posts.post_status IN (" . $it_order_status . ")";
    }

    if ($it_hide_os && $it_hide_os != '-1' and $it_hide_os != "'-1'") {
        $it_hide_os_condition = " AND it_posts.post_status NOT IN ('" . $it_hide_os . "')";
    }


    $sql = "SELECT $sql_columns FROM $sql_joins";

    $sql .= "$category_id_join $brand_id_join $it_id_order_status_join $it_txt_email_join $it_txt_first_name_join
				$it_country_code_join $state_code_join $it_payment_method_join $it_billing_post_code_join
				$it_coupon_used_join $it_variation_id_join $it_variation_only_join $it_variations_formated_join
				$it_order_meta_key_join $it_coupon_codes_join $it_variation_item_meta_key_join $it_show_cog_join
				$delivery_date_join";

    $sql .= " Where $other_condition_1 $post_type_condition $it_txt_email_condition_1 $it_txt_first_name_condition_1
						 $it_country_code_condition_1 $state_code_condition_1
						$it_billing_post_code_condition $it_payment_method_condition_1 $date_condition
						$order_id_condition $it_txt_email_condition_2 $it_paid_customer_condition
						$it_txt_first_name_condition_2 $it_publish_order_condition_1 $it_publish_order_condition_2
						$it_country_code_condition_2 $state_code_condition_2 $it_payment_method_condition_2
						$it_order_meta_key_condition $it_order_item_name_condition $txtProduct_condition
						$it_product_id_condition $category_id_condition $brand_id_condition $it_id_order_status_condition
						$it_coupon_used_condition $it_coupon_code_condition $it_coupon_codes_condition $it_variation_item_meta_key_condition
						$it_variation_id_condition $it_variation_only_condition $it_variations_formated_condition $it_show_cog_condition
						$it_order_status_condition $it_hide_os_condition
						$date_delivery_condition";

    $sql_group_by = " GROUP BY it_woocommerce_order_items.order_item_id ";
    $sql_order_by = " ORDER BY {$it_sort_by} {$it_order_by}";

    $sql .= $sql_group_by . $sql_order_by;

    //print_r($search_fields);
// echo $sql;


    $columns_total = '';
    if ($it_detail_view == "yes") {

        $columns = array(

            array('lable' => esc_html__('Order ID', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Date', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Status', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),

            array('lable' => esc_html__('Customer Name', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Email', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Address 1', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Address 2', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Post Code', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing City', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing State', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing County', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Phone', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),

            array('lable' => esc_html__('Shipping Address 1', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping Address 2', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping Post Code', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping City', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping State', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping County', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),

            array('lable' => esc_html__('Products', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('SKU', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Category', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Variation', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Qty.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Rate', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Prod. Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),

            //SHIPPING AMNT
            array('lable' => esc_html__('Delivery charge', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Order total', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
        );


    } else {

        $columns = array(
            array('lable' => esc_html__('Customer Name', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Email', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Address 1', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Address 2', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Post Code', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing City', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing State', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing County', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Billing Phone', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Order ID', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Date', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Status', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Coupon Code', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),

            //SHIPPING AMNT
            array('lable' => esc_html__('Delivery charge', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Order total', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
        );

    }

    $columns          = array_values($columns);
    $this->table_cols = $columns;

} elseif ($file_used == "data_table") {

    $first_order_id = '';


    $order_items = $this->results;
    $categories  = array();
    $order_meta  = array();
    if (count($order_items) > 0) // print_r($order_items);
    {
        foreach ($order_items as $key => $order_item) {


            $order_id                              = $order_item->order_id;
            $order_items[$key]->billing_first_name = '';//Default, some time it missing
            $order_items[$key]->billing_last_name  = '';//Default, some time it missing
            $order_items[$key]->billing_email      = '';//Default, some time it missing

            if ( ! isset($order_meta[$order_id])) {
                $order_meta[$order_id] = $this->it_get_full_post_meta($order_id);
            }

            //die(print_r($order_meta[$order_id]));

            foreach ($order_meta[$order_id] as $k => $v) {
                $order_items[$key]->$k = $v;
            }


            $order_items[$key]->order_total    = isset($order_item->order_total) ? $order_item->order_total : 0;
            $order_items[$key]->order_shipping = isset($order_item->order_shipping) ? $order_item->order_shipping : 0;


            $order_items[$key]->cart_discount  = isset($order_item->cart_discount) ? $order_item->cart_discount : 0;
            $order_items[$key]->order_discount = isset($order_item->order_discount) ? $order_item->order_discount : 0;
            $order_items[$key]->total_discount = isset($order_item->total_discount) ? $order_item->total_discount : ($order_items[$key]->cart_discount + $order_items[$key]->order_discount);


            $order_items[$key]->order_tax          = isset($order_item->order_tax) ? $order_item->order_tax : 0;
            $order_items[$key]->order_shipping_tax = isset($order_item->order_shipping_tax) ? $order_item->order_shipping_tax : 0;
            $order_items[$key]->total_tax          = isset($order_item->total_tax) ? $order_item->total_tax : ($order_items[$key]->order_tax + $order_items[$key]->order_shipping_tax);

            $transaction_id                    = "ransaction ID";
            $order_items[$key]->transaction_id = isset($order_item->$transaction_id) ? $order_item->$transaction_id : (isset($order_item->transaction_id) ? $order_item->transaction_id : '');
            $order_items[$key]->gross_amount   = ($order_items[$key]->order_total + $order_items[$key]->total_discount) - ($order_items[$key]->order_shipping + $order_items[$key]->order_shipping_tax + $order_items[$key]->order_tax);


            $order_items[$key]->billing_first_name = isset($order_item->billing_first_name) ? $order_item->billing_first_name : '';
            $order_items[$key]->billing_last_name  = isset($order_item->billing_last_name) ? $order_item->billing_last_name : '';
            $order_items[$key]->billing_name       = $order_items[$key]->billing_first_name .' '. $order_items[$key]->billing_last_name ;
            $order_items[$key]->billing_address_1  = $order_items[$key]->billing_address_1 ? $order_items[$key]->billing_address_1 : '';
            $order_items[$key]->billing_address_2  = $order_items[$key]->billing_address_2 ? $order_items[$key]->billing_address_2 : '';
            $order_items[$key]->billing_postcode   = $order_items[$key]->billing_postcode ? $order_items[$key]->billing_postcode : '';
            $order_items[$key]->billing_city       = $order_items[$key]->billing_city ? $order_items[$key]->billing_city : '';
            $order_items[$key]->billing_state      = $order_items[$key]->billing_state ? $order_items[$key]->billing_state : '';
            $order_items[$key]->billing_country    = $order_items[$key]->billing_country ? $order_items[$key]->billing_country : '';
            $order_items[$key]->billing_phone    = $order_items[$key]->billing_phone ? $order_items[$key]->billing_phone : '';


            $order_items[$key]->shipping_address_1  = $order_items[$key]->shipping_address_1 ? $order_items[$key]->shipping_address_1 : '';
            $order_items[$key]->shipping_address_2  = $order_items[$key]->shipping_address_2 ? $order_items[$key]->shipping_address_2 : '';
            $order_items[$key]->shipping_postcode   = $order_items[$key]->shipping_postcode ? $order_items[$key]->shipping_postcode : '';
            $order_items[$key]->shipping_city       = $order_items[$key]->shipping_city ? $order_items[$key]->shipping_city : '';
            $order_items[$key]->shipping_state      = $order_items[$key]->shipping_state ? $order_items[$key]->shipping_state : '';
            $order_items[$key]->shipping_country    = $order_items[$key]->shipping_country ? $order_items[$key]->shipping_country : '';


        }
    }


    //print_r($order_items);

    $this->results = $order_items;


    //print_r($this->results);

    $items_render = array();


    ////ADDE IN VER4.0
    /// TOTAL ROWS VARIABLES
    $gross_amnt = $discount_amnt = $shipping_amnt = $shipping_tax_amnt = $cog_amnt = $profit_amnt =
    $order_tax_amnt = $total_tax_amnt = $part_refund_amnt = $order_count =
    $product_count = $product_qty = $total_rate = $product_amnt = $product_discount = $net_amnt = 0;

    foreach ($this->results as $items) {
        $index_cols = 0;
        //for($i=1; $i<=20 ; $i++){


        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $product_count++;

        $order_id         = $items->order_id;
        $fetch_other_data = '';

        if ( ! isset($this->order_meta[$order_id])) {
            $fetch_other_data = $this->it_get_full_post_meta($order_id);
        }

        $new_order = false;
        if ($first_order_id == '') {
            $first_order_id = $items->order_id;
            $new_order      = true;
        } elseif ($first_order_id != $items->order_id) {
            $first_order_id = $items->order_id;
            $new_order      = true;
        }
        $it_detail_view        = 'yes';


        if ($it_detail_view == "yes") {
            if (1){

                $datatable_value .= ("<tr>");

                //order ID
                $order_id = $items->order_id;

                //CUSTOM WORK - 15862
                if (is_array(__CUSTOMWORK_ID__) && in_array('15862', __CUSTOMWORK_ID__)) {
                    $order_id = get_post_meta($order_id, '_order_number_formatted', true);
                }

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= ($order_id);
                $datatable_value .= ("</td>");

                //Date
                $date_format   = get_option('date_format');
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= date($date_format, strtotime($items->order_date));
                $datatable_value .= ("</td>");

                //Status
                $it_table_value = isset($items->order_status) ? $items->order_status : '';

                if ($it_table_value == 'wc-completed') {
                    $it_table_value = '<span class="awr-order-status awr-order-status-' . sanitize_title($it_table_value) . '" >' . ucwords(__($it_table_value,
                            __IT_REPORT_WCREPORT_TEXTDOMAIN__)) . '</span>';
                } elseif ($it_table_value == 'wc-refunded') {
                    $it_table_value = '<span class="awr-order-status awr-order-status-' . sanitize_title($it_table_value) . '" >' . ucwords(__($it_table_value,
                            __IT_REPORT_WCREPORT_TEXTDOMAIN__)) . '</span>';
                } else {
                    $it_table_value = '<span class="awr-order-status awr-order-status-' . sanitize_title($it_table_value) . '" >' . ucwords(__($it_table_value,
                            __IT_REPORT_WCREPORT_TEXTDOMAIN__)) . '</span>';
                }

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= str_replace("Wc-", "", $it_table_value);
                $datatable_value .= ("</td>");

                //Name
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $items->billing_name;
                $datatable_value .= ("</td>");

                //Email
                $it_table_value = isset($items->billing_email) ? $items->billing_email : '';
                $it_table_value = $this->it_email_link_format($it_table_value, false);
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");


                //Address 1
                $it_table_value = isset($items->billing_address_1) ? $items->billing_address_1 : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //Address 2
                $it_table_value = isset($items->billing_address_2) ? $items->billing_address_2 : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //Postcode
                $it_table_value = isset($items->billing_postcode) ? $items->billing_postcode : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //City
                $it_table_value = isset($items->billing_city) ? $items->billing_city : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //State
                $it_table_value = isset($items->billing_state) ? $items->billing_state : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //Country
                $it_table_value = isset($items->billing_country) ? $items->billing_country : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");


                //Phone
                $it_table_value = isset($items->billing_phone) ? $items->billing_phone : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");



                //Address 1
                $it_table_value = isset($items->shipping_address_1) ? $items->shipping_address_1 : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //Address 2
                $it_table_value = isset($items->shipping_address_2) ? $items->shipping_address_2 : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //Postcode
                $it_table_value = isset($items->shipping_postcode) ? $items->shipping_postcode : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //City
                $it_table_value = isset($items->shipping_city) ? $items->shipping_city : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //State
                $it_table_value = isset($items->shipping_state) ? $items->shipping_state : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //Country
                $it_table_value = isset($items->shipping_country) ? $items->shipping_country : '';
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");


                //Products
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $items->product_name;
                $datatable_value .= ("</td>");

                //SKU
                $display_class = '';
                $sku           = $this->it_get_prod_sku($items->order_item_id, $items->product_id);
                if ($items->fee) {
                    $sku = 'Fee';
                }
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $sku;
                $datatable_value .= ("</td>");

                //Category
                $display_class = '';
                $categoriess   = $this->it_get_cn_product_id($items->product_id, "product_cat");
                if ($items->fee) {
                    $categoriess = '';
                }
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $categoriess;
                $datatable_value .= ("</td>");

                //Variation
                $it_table_value  = $this->it_get_woo_variation($items->order_item_id);
                $order_item_id   = ($items->order_item_id);
                $attributes      = $this->it_get_variaiton_attributes('order_item_id', '', $order_item_id);
                $varation_string = isset($attributes['item_varation_string']) ? $attributes['item_varation_string'] : array();
                $it_table_value  = isset($varation_string[$order_item_id]['varation_string']) ? $varation_string[$order_item_id]['varation_string'] : "";

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");


                //Qty.
                $display_class = '';
                $qty           = $items->product_quantity;
                if ($items->fee) {
                    $qty = 0;
                }
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $qty;

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $product_qty     += $items->product_quantity;
                $datatable_value .= ("</td>");

                //Rate
                $it_table_value = isset($items->product_rate) ? $items->product_rate : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency'], "order_id" => $items->order_id),
                    'multi_currency');

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $total_rate      += $it_table_value;
                $datatable_value .= ("</td>");

                //Prod. Amt.
                $it_table_value = isset($items->item_amount) ? $items->item_amount : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency'], "order_id" => $items->order_id),
                    'multi_currency');

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $product_amnt    += $it_table_value;
                $datatable_value .= ("</td>");

                //Order Shipping
                $display_class  = '';
                $it_table_value = isset($items->order_shipping) ? $items->order_shipping : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency'], "order_id" => $items->order_id),
                    'multi_currency');

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $shipping_amnt   += $it_table_value;
                $datatable_value .= ("</td>");

                //Net Amt.
                $it_table_value    = isset($items->total_price) ? $items->total_price : 0;
                $order_refund_amnt = $this->it_get_por_amount($items->order_id);
                $part_refund       = (isset($order_refund_amnt[$items->order_id]) ? $order_refund_amnt[$items->order_id] : 0);
                $it_table_value    = isset($items->order_total) ? ($items->order_total) - $part_refund : 0;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency'], "order_id" => $items->order_id),
                    'multi_currency');

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $net_amnt        += $it_table_value;
                $datatable_value .= ("</td>");

                $datatable_value .= ("</tr>");
            }

        }
    }

    ////ADDED IN VER4.0
    /// TOTAL ROW
    $datatable_value_total = '';
    $it_detail_view        = 'yes';
    $it_show_cog           = $this->it_get_woo_requests('it_show_cog', 'no', true);
    $table_name            = $table_name_total = "details";

    if ($it_detail_view == "yes") {
        $table_name_total = $table_name . "_with_items";

        $this->table_cols_total = $this->table_columns_total($table_name_total);
        if ($it_show_cog != 'yes') {
            ////ADDE IN VER4.0
            /// COST OF GOOD
            unset($this->table_cols_total[count($this->table_cols_total) - 1]);
            unset($this->table_cols_total[count($this->table_cols_total) - 1]);
        }

        $datatable_value_total .= ("<tr>");
        $datatable_value_total .= "<td>$order_count</td>";
        $datatable_value_total .= "<td>$product_count</td>";
        $datatable_value_total .= "<td>$product_qty</td>";
        $datatable_value_total .= "<td>" . (($total_rate) == 0 ? $this->price(0) : $this->price($total_rate)) . "</td>";
        $datatable_value_total .= "<td>" . (($product_amnt) == 0 ? $this->price(0) : $this->price($product_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($product_discount) == 0 ? $this->price(0) : $this->price($product_discount)) . "</td>";
        $datatable_value_total .= "<td>" . (($net_amnt) == 0 ? $this->price(0) : $this->price($net_amnt)) . "</td>";

        if ($it_show_cog == 'yes') {
            $datatable_value_total .= "<td>" . (($cog_amnt) == 0 ? $this->price(0) : $this->price($cog_amnt)) . "</td>";
            $datatable_value_total .= "<td>" . (($profit_amnt) == 0 ? $this->price(0) : $this->price($profit_amnt)) . "</td>";
        }
        $datatable_value_total .= ("</tr>");
    } else {
        $table_name_total = $table_name . "_no_items";

        $this->table_cols_total = $this->table_columns_total($table_name_total);
        if ($it_show_cog != 'yes') {
            ////ADDE IN VER4.0
            /// COST OF GOOD
            unset($this->table_cols_total[count($this->table_cols_total) - 1]);
            unset($this->table_cols_total[count($this->table_cols_total) - 1]);
        }

        $datatable_value_total .= ("<tr>");
        $datatable_value_total .= "<td>$order_count</td>";
        $datatable_value_total .= "<td>" . (($gross_amnt) == 0 ? $this->price(0) : $this->price($gross_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($discount_amnt) == 0 ? $this->price(0) : $this->price($discount_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($shipping_amnt) == 0 ? $this->price(0) : $this->price($shipping_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($shipping_tax_amnt) == 0 ? $this->price(0) : $this->price($shipping_tax_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($order_tax_amnt) == 0 ? $this->price(0) : $this->price($order_tax_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($total_tax_amnt) == 0 ? $this->price(0) : $this->price($total_tax_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($part_refund_amnt) == 0 ? $this->price(0) : $this->price($part_refund_amnt)) . "</td>";
        $datatable_value_total .= "<td>" . (($net_amnt) == 0 ? $this->price(0) : $this->price($net_amnt)) . "</td>";

        if ($it_show_cog == 'yes') {
            $datatable_value_total .= "<td>" . (($cog_amnt) == 0 ? $this->price(0) : $this->price($cog_amnt)) . "</td>";
            $datatable_value_total .= "<td>" . (($profit_amnt) == 0 ? $this->price(0) : $this->price($profit_amnt)) . "</td>";
        }

        $datatable_value_total .= ("</tr>");
    }


} elseif ($file_used == "search_form") {
    ?>
    <form class='alldetails search_form_report' action='' method='post'>
        <input type='hidden' name='action' value='submit-form'/>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Date From', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
            <input name="it_from_date" id="pwr_from_date" type="text" readonly='true' class="datepick"/>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Date To', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
            <input name="it_to_date" id="pwr_to_date" type="text" readonly='true' class="datepick"/>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Order ID', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
            <input name="it_id_order" type="text" class=""/>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Customer', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-user"></i></span>
            <input name="it_first_name_text" type="text" class=""/>
        </div>

        <?php
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_category_id');
        if ($this->get_form_element_permission('it_category_id') || $permission_value != '') {

            if ( ! $this->get_form_element_permission('it_category_id') && $permission_value != '') {
                $col_style = 'display:none';
            }
            ?>
            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Category', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-tags"></i></span>
                <?php
                $args = array(
                    'orderby'      => 'name',
                    'order'        => 'ASC',
                    'hide_empty'   => 1,
                    'hierarchical' => 0,
                    'exclude'      => '',
                    'include'      => '',
                    'child_of'     => 0,
                    'number'       => '',
                    'pad_counts'   => false

                );

                //$categories = get_categories($args);
                $current_category = $this->it_get_woo_requests_links('it_category_id', '', true);

                $categories = get_terms('product_cat', $args);
                $option     = '';
                foreach ($categories as $category) {

                    $selected = '';
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($category->term_id, $permission_value)) {
                        continue;
                    }



                    $option .= '<option value="' . $category->term_id . '" ' . $selected . '>';
                    $option .= $category->name;
                    $option .= ' (' . $category->count . ')';
                    $option .= '</option>';
                }
                ?>
                <select name="it_category_id[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('it_category_id') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

            </div>
            <?php
        }

        ////ADDED IN VER4.0
        //BRANDS ADDONS
        ////////////////BRANDS-ADDON////////////
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_brand_id');

        if (__IT_BRAND_SLUG__ && ($this->get_form_element_permission('it_brand_id') || $permission_value != '')) {
            if ( ! $this->get_form_element_permission('it_brand_id') && $permission_value != '') {
                $col_style = 'display:none';
            }

            //if(count($permission_value)==1) $col_style='display:none';
            ?>
            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php echo __IT_BRAND_LABEL__; ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-tags"></i></span>
                <?php
                $args = array(
                    'orderby'      => 'name',
                    'order'        => 'ASC',
                    'hide_empty'   => 1,
                    'hierarchical' => 0,
                    'exclude'      => '',
                    'include'      => '',
                    'child_of'     => 0,
                    'number'       => '',
                    'pad_counts'   => false

                );

                //$categories = get_categories($args);
                $current_category = $this->it_get_woo_requests_links('it_brand_id', '', true);

                $current_category = $permission_value;

                $categories = get_terms(__IT_BRAND_SLUG__, $args);
                $option     = '';
                foreach ($categories as $category) {
                    $selected = '';
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($category->term_id, $permission_value)) {
                        continue;
                    }


                    $option .= '<option value="' . $category->term_id . '" ' . $selected . '>';
                    $option .= $category->name;
                    $option .= ' (' . $category->count . ')';
                    $option .= '</option>';
                }
                ?>
                <select name="it_brand_id[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('it_brand_id') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

            </div>
            <?php
        }

        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_product_id');
        if ($this->get_form_element_permission('it_product_id') || $permission_value != '') {

            if ( ! $this->get_form_element_permission('it_product_id') && $permission_value != '') {
                $col_style = 'display:none';
            }

            ?>

            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Product', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-gear"></i></span>
                <?php
                $products        = $this->it_get_product_woo_data('all');
                $option          = '';
                $current_product = $this->it_get_woo_requests_links('it_product_id', '', true);
                //echo $current_product;

                foreach ($products as $product) {
                    $selected = '';
                    if (is_array($permission_value) && ! in_array($product->id, $permission_value)) {
                        continue;
                    }


                    if ($current_product == $product->id) {
                        $selected = "selected";
                    }
                    $option .= "<option $selected value='" . $product->id . "' >" . $product->label . " </option>";
                }


                ?>
                <select name="it_product_id[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('it_product_id') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

            </div>
            <?php
        }
        ?>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Customer', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-user"></i></span>
            <?php
            $customers = $this->it_get_woo_customers_orders();
            $option    = '';
            foreach ($customers as $customer) {
                $option .= "<option value='" . $customer->id . "' >" . $customer->label . " ($customer->counts)</option>";
            }
            ?>
            <select name="it_customers_paid[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                <?php
                echo $option;
                ?>
            </select>

        </div>

        <?php
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_orders_status');
        if ($this->get_form_element_permission('it_orders_status') || $permission_value != '') {

            if ( ! $this->get_form_element_permission('it_orders_status') && $permission_value != '') {
                $col_style = 'display:none';
            }
            ?>

            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Status', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-check"></i></span>
                <?php
                $it_order_status = $this->it_get_woo_orders_statuses();

                ////ADDED IN VER4.0
                $shop_status_selected = '';
                /// APPLY DEFAULT STATUS AT FIRST
                if ($this->it_shop_status) {
                    $shop_status_selected = explode(",", $this->it_shop_status);
                }

                $option = '';
                foreach ($it_order_status as $key => $value) {

                    $selected = "";
                    if (is_array($permission_value) && ! in_array($key, $permission_value)) {
                        continue;
                    }


                    ////ADDED IN VER4.0
                    /// APPLY DEFAULT STATUS AT FIRST
                    if (is_array($shop_status_selected) && in_array($key, $shop_status_selected)) {
                        $selected = "selected";
                    }

                    $option .= "<option value='" . $key . "' $selected >" . $value . "</option>";
                }
                ?>

                <select name="it_orders_status[]" multiple="multiple" size="5" data-size="5"
                        class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('it_orders_status') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
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
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_countries_code');
        if ($this->get_form_element_permission('it_countries_code') || $permission_value != '') {
            if ( ! $this->get_form_element_permission('it_countries_code') && $permission_value != '')
                $col_style = 'display:none'

            ?>
            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Country', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-globe"></i></span>
                <?php
                $country_data = $this->it_get_paying_woo_state('billing_country');
                $country      = $this->it_get_woo_countries();
                $option       = '';
                foreach ($country_data as $countries) {
                    $selected = '';
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($countries->id, $permission_value)) {
                        continue;
                    }


                    $it_table_value = $country->countries[$countries->id];
                    $option         .= "<option value='" . $countries->id . "' $selected >" . $it_table_value . "</option>";
                }

                $country_states      = $this->it_get_woo_country_of_state();
                $json_country_states = json_encode($country_states);
                //print_r($json_country_states);
                ?>
                <select id="it_adr_country" name="it_countries_code[]" multiple="multiple" size="5" data-size="5"
                        class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('it_countries_code') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

                <script type="text/javascript">
                    "use strict";
                    jQuery(document).ready(function ($) {

                        var country_state = '';
                        country_state =<?php echo $json_country_states?>;

                        $("#it_adr_country").change(function () {
                            var country_val = $(this).val();

                            if (country_val == null) {
                                return false;
                            }

                            var option_data = Array();
                            var optionss = '<option value="-1">Select All</option>';
                            var i = 1;
                            $.each(country_state, function (key, val) {

                                if (country_val.indexOf(val.parent_id) >= 0 || country_val == "-1") {
                                    optionss += '<option value="' + val.id + '">' + val.label + '</option>';
                                    option_data[val.id] = val.label;
                                }
                                i++;
                            });

                            $('#it_adr_state').empty(); //remove all child nodes
                            $("#it_adr_state").html(optionss);
                            $('#it_adr_state').trigger("chosen:updated");
                        });


                    });

                </script>

            </div>

            <?php
        }
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_states_code');
        if ($this->get_form_element_permission('it_states_code') || $permission_value != '') {
            if ( ! $this->get_form_element_permission('it_states_code') && $permission_value != '') {
                $col_style = 'display:none';
            }
            ?>

            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('State', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-map"></i></span>
                <?php
                //$state_codes = $this->it_get_paying_woo_state('shipping_state','shipping_country');
                //$this->it_get_woo_country_of_state();
                //$this->it_get_woo_bsn($items->billing_country,$items->billing_state_code);
                $state_codes = $this->it_get_paying_woo_state('billing_state', 'billing_country');
                $option      = '';
                foreach ($state_codes as $state) {
                    $selected = "";
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($state->id, $permission_value)) {
                        continue;
                    }


                    $it_table_value = $this->it_get_woo_bsn($state->billing_country, $state->id);
                    $option         .= "<option $selected value='" . $state->id . "' >" . $it_table_value . " ($state->billing_country)</option>";
                }
                ?>

                <select id="it_adr_state" name="it_states_code[]" multiple="multiple" size="5" data-size="5"
                        class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('it_states_code') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

            </div>
            <?php
        }
        ?>

        <?php
        ////ADDED IN V4.0
        ?>
        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Variations', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-bolt"></i></span>
            <?php
            $option        = '';
            $it_variations = $this->it_get_woo_pv_atts('yes');

            $all_value = array();
            foreach ($it_variations as $key => $value) {
                $selected    = '';
                $new_key     = str_replace("wcv_", "", $key);
                $option      .= "<option value='" . $new_key . "' >" . $value . " </option>";
                $all_value[] = $new_key;
            }

            if ( ! is_array($all_value)) {
                $all_value = '-1';
            } else {
                $all_value = implode(",", $all_value);
            }
            ?>

            <select name="it_variation_id[]" multiple="multiple" size="5" data-size="5"
                    class="chosen-select-search variation_elements">
                <option value="<?php echo $all_value ?>"><?php _e('Select All',
                        __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                <?php
                echo $option;
                ?>
            </select>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Variation Only', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>

            <input name="it_variation_only" type="checkbox" value="yes"/>

        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Postcode(Zip)', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-map-marker"></i></span>
            <input name="it_bill_post_code" type="text"/>
        </div>


        <!--<div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Min & Max By', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-arrows-h"></i></span>
                    <select name="order_meta_key[]" id="order_meta_key2" class="order_meta_key normal_view_only">
                        <option value="-1">Select All</option>
                        <option value="_order_total">Order Net Amount</option>
                        <option value="_order_discount">Order Discount Amount</option>
                        <option value="_order_shipping">Order Shipping Amount</option>
                        <option value="_order_shipping_tax">Order Shipping Tax Amount</option>
                    </select>
                    <br />
                    <span class="description"><?php _e("Enable this selection by uncheck 'Show Order Item Details'
", __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>

                 <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Min Amount', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-battery-0"></i></span>
                    <input name="min_amount" type="text"/>
                    <br />
                    <span class="description"><?php _e("Enable this selection by uncheck 'Show Order Item Details'
", __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>

                 <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Max Amount', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-battery-4"></i></span>
                    <input name="max_amount" type="text"/>
                    <br />
                    <span class="description"><?php _e("Enable this selection by uncheck 'Show Order Item Details'
", __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>-->

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Email', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-envelope-o"></i></span>
            <input name="it_email_text" type="text"/>
        </div>


        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Order By', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-sort-alpha-asc"></i></span>
            <div class="row">
                <div class="col-md-6">

                    <select name="sort_by" id="sort_by" class="sort_by">
                        <option value="order_id" selected="selected">Order ID</option>
                        <option value="billing_name">Name</option>
                        <option value="billing_email">Email</option>
                        <option value="order_date">Date</option>
                        <option value="post_status">Status</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select name="order_by" id="order_by" class="order_by">
                        <option value="ASC">Ascending</option>
                        <option value="DESC" selected="selected">Descending</option>
                    </select>
                </div>
            </div>
        </div>


        <!--CUSTOM WORK-->
        <div class="col-md-6">
            <div class="awr-form-title">
                <?php
                $it_coupon_codes = $this->it_get_woo_coupons_codes();
                $option          = '';
                foreach ($it_coupon_codes as $coupon) {
                    $selected = '';

                    $option .= "<option $selected value='" . $coupon->id . "' >" . $coupon->label . " </option>";
                }
                ?>
                <?php _e('Coupon Codes', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-key"></i></span>
            <select name="it_codes_of_coupon[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                <?php
                echo $option;
                ?>
            </select>
        </div>

        <!--<div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Discount Type', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-money"></i></span>
                    <select name="it_coupon_discount_types" >
                        <option value="-1"><?php _e('Select One', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <option value="percent"><?php _e('Percentage Discount', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <option value="fixed_cart"><?php _e('Fixed Cart Discount',
            __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <option value="fixed_product"><?php _e('Fixed Product Discount',
            __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                    </select>
                </div>-->



        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Coupon Used Only', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>

            <input name="it_use_coupon" type="checkbox" value="yes"/>

        </div>


        <?php
        if (__IT_COG__ != '') {
            ?>

            <div class="col-md-6">
                <div class="awr-form-title">
                    <?php _e('SHOW JUST INCLUDE C.O.G & PROFIT', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    <br/>
                    <span class="description"><?php _e('Include just products with current Profit(Cost of good) plugin(Selected in Setting -> Add-on Settings -> Cost of Good).',
                            __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>

                <input name="it_show_cog" type="checkbox" value="yes"/>

            </div>
            <?php
        }
        ?>


        <div class="col-md-12">
            <?php
            $it_hide_os         = $this->otder_status_hide;
            $it_publish_order   = 'no';
            $it_order_item_name = '';
            $it_coupon_code     = '';
            $it_coupon_codes    = '';
            $it_payment_method  = '';

            $it_variation_only = $this->it_get_woo_requests_links('it_variation_only', '-1', true);
            $it_order_meta_key = '';

            $data_format = $this->it_get_woo_requests_links('date_format', get_option('date_format'), true);


            $amont_zero = '';

            ?>

            <input type="hidden" name="it_hide_os" value="<?php echo $it_hide_os; ?>"/>
            <input type="hidden" name="publish_order" value="<?php echo $it_publish_order; ?>"/>
            <input type="hidden" name="order_item_name" value="<?php echo $it_order_item_name; ?>"/>
            <input type="hidden" name="coupon_code" value="<?php echo $it_coupon_code; ?>"/>
            <input type="hidden" name="payment_method" value="<?php echo $it_payment_method; ?>"/>


            <input type="hidden" name="date_format" value="<?php echo $data_format; ?>"/>

            <input type="hidden" name="table_names" value="<?php echo $table_name; ?>"/>
            <div class="fetch_form_loading search-form-loading"></div>
            <button type="submit" value="Search" class="button-primary"><i class="fa fa-search"></i>
                <span><?php echo esc_html__('Search', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
            <button type="button" value="Reset" class="button-secondary form_reset_btn"><i
                    class="fa fa-reply"></i><span><?php echo esc_html__('Reset Form',
                        __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
        </div>

    </form>
    <?php
}

?>
