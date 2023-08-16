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

		$it_publish_order		= $this->it_get_woo_requests('publish_order','no',true);//if publish display publish order only, no or null display all order

		$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
		//$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

		$it_paid_customer		= str_replace(",","','",$it_paid_customer);
		//$it_country_code		= str_replace(",","','",$it_country_code);
		//$state_code		= str_replace(",","','",$state_code);
		//$it_country_code		= str_replace(",","','",$it_country_code);

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

		$it_payment_method='';

		$it_order_meta_key='';

		$data_format=$this->it_get_woo_requests('date_format',get_option('date_format'),true);

		$amont_zero='';
		//////////////////////

		/////////////////////////
		//APPLY PERMISSION TERMS
		$key='all_orders';

		$it_product_id=$this->it_get_form_element_permission('it_product_id',$it_product_id,$key);

		$it_order_status 			= $this->it_get_woo_requests('it_orders_status',NULL,true);
        if($it_order_status=='OandA'){
            $it_order_status="Open','Abandoned";
        }






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


		if(!$it_from_date){	$it_from_date = date_i18n('Y-m-d');}
		if(!$it_to_date){
			$last_days_orders 		= apply_filters($page.'_back_day', $last_days_orders);//-1,-2,-3,-4,-5
			$it_to_date = date('Y-m-d', strtotime($last_days_orders.' day', strtotime(date_i18n("Y-m-d"))));}

		$it_sort_by 			= $this->it_get_woo_requests('sort_by','order_id',true);
		$it_order_by 			= $this->it_get_woo_requests('order_by','DESC',true);
		///

		if($p > 1){	$start = ($p - 1) * $limit;}

		if($it_detail_view == "yes"){
			$it_variations_value		= $this->it_get_woo_requests('variations_value',"-1",true);
			$it_variations_formated = '-1';
			if($it_variations_value != "-1" and strlen($it_variations_value)>0){
				$it_variations_value = explode(",",$it_variations_value);
				$var = array();
				foreach($it_variations_value as $key => $value):
					$var[] .=  $value;
				endforeach;
				$result = array_unique ($var);
				//$this->print_array($var);
				$it_variations_formated = implode("', '",$result);
			}
			$_REQUEST['variations_formated'] = $it_variations_formated;
		}


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
		$it_order_status_join = '';

		//HIDE ORDER STATUS
		$it_hide_os_condition = '';

        ////ADDED IN VER4.0
        /// COST OF GOOD
        $it_show_cog_cols='';
        $it_show_cog_join='';
        $it_show_cog_condition='';



		//echo $it_product_id;
		if($it_product_id  && $it_product_id != "-1") {
		    $it_product_id=explode(",",$it_product_id);
		    $it_product_id_condition.=" AND (";
		    $op=array();
		    foreach($it_product_id as $pid){
			    $op[]=" meta.meta_value LIKE '%\"product_id\";i:$pid%' OR meta.meta_value LIKE '%\"variation_id\";i:$pid%'";
            }

			$it_product_id_condition.=implode(" OR ",$op);

            $it_product_id_condition.=' ) ';
		}


//		if($it_order_status  && $it_order_status != "-1") {
//			$it_order_status_join = "
//				LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships 			ON it_term_relationships.object_id		=	it_posts.ID
//				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy 				ON term_taxonomy.term_taxonomy_id	=	it_term_relationships.term_taxonomy_id
//				LEFT JOIN  {$wpdb->prefix}terms 				as it_terms 						ON it_terms.term_id					=	term_taxonomy.term_id";
//		}


		if($it_paid_customer  && $it_paid_customer != '-1' and $it_paid_customer != "'-1'")
			$it_paid_customer_condition.= " AND it_posts.post_author IN ('".$it_paid_customer."')";


//		if($it_order_status  && $it_order_status != "-1")
//			$it_order_status_condition = " AND term_taxonomy.taxonomy LIKE('shop_cart_status') AND it_terms.slug IN ('".$it_order_status ."')";

		if ($it_from_date != NULL &&  $it_to_date !=NULL){
			$date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format')";
		}




        $columns_total='';
		if($it_detail_view=="yes"){

			$columns=array(
				array('lable'=>esc_html__('Title',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Owner',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Email',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Cart Status',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Last Online',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Cart Value',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				//CUSTOM WORK - 4187
				//array('lable'=>esc_html__('Trannsaction ID',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),

				array('lable'=>esc_html__('Product',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('SKU',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Variation',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Qty.',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Rate',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'),

				array('lable'=>esc_html__('Actions',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),

			);


		}else{

			$columns=array(
				array('lable'=>esc_html__('Title',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Owner',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Email',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Cart Status',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Last Online',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Cart Value',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
				array('lable'=>esc_html__('Actions',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),
			);

		}


		$columns=array_values($columns);
		$this->table_cols = $columns;

		$start = date('Y-m-d G:i:s', $it_from_date." ");
		$end = date('Y-m-d G:i:s', $it_to_date + 86400);

		$offset = get_option('gmt_offset');
		$timeout = get_option(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.'abandoned_cart_timeout');;
		$where='';
		if($it_order_status  && $it_order_status != "-1"){
			if ($it_order_status == "Open") {
				$where .= " AND it_posts.post_modified > '".date('Y-m-d G:i:s', time() + ($offset * 3600) - $timeout)."'";
			} elseif ($it_order_status =="Abandoned") {
				$where .= " AND it_posts.post_modified < '".date('Y-m-d G:i:s', (time()  + ($offset * 3600)- $timeout))."'";
			}
		}

		$where = " AND it_posts.post_modified > '" . $it_from_date . "' AND it_posts.post_modified < '" . $it_to_date . "'";

		echo $where;


		$sql="Select DATE_FORMAT(it_posts.post_modified,'%M %e, %Y %l:%i'	) as modify,it_posts.id as id,it_posts.post_author as author,meta.meta_value as  it_cartitems from {$wpdb->prefix}posts as it_posts LEFT JOIN {$wpdb->prefix}postmeta as meta ON
it_posts.ID=meta.post_id $it_order_status_join where meta.meta_key='it_cartitems' AND it_posts.post_type='carts' $date_condition $it_order_status_condition $it_paid_customer_condition $it_product_id_condition $where";

//echo $sql;

	}
	elseif($file_used=="data_table"){

		$order_items=$this->results;

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
		$it_detail_view		= $this->it_get_woo_requests('it_view_details',"no",true);

		//print_r($order_items);

		if($it_detail_view=="yes") {

			foreach ( $order_items as $item ) {

				$cart = new IT_Cart_Receipt();
				$cart->load_receipt($item->id);
				$cart->set_guest_details();
				//print_r($cart);

				$items = ( unserialize( $item->it_cartitems ) );
				$sum=0;
				foreach ( $items as $pitem ) {
					$_product = wc_get_product($pitem['product_id']);
					$sum+=($pitem['quantity']*$_product->get_price());
				}

				//$items = ( unserialize( $pitem->it_cartitems ) );
				$datatable_value .= ( "<tr>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= ( get_the_title($item->id ));
				$datatable_value .= ( "</td>" );

				//AUTHOR
				$author='';
				if($item->author==0)
					$author=esc_html__('Guest',__IT_REPORT_WCREPORT_TEXTDOMAIN__);
				else
					$author=get_user_meta($item->author,'billing_first_name',true).' '.get_user_meta($item->author,'billing_last_name',true);
				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .=  $author;
				$datatable_value .= ( "</td>" );


				//Email

				$email='';
				if($item->author==0)
					$email=esc_html__('Not Available',__IT_REPORT_WCREPORT_TEXTDOMAIN__);
				else
					$email=get_user_meta($item->author,'billing_email',true);

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .=  $email;
				$datatable_value .= ( "</td>" );


				//CART STATUS
				$show_custom_state = $cart->status();
				$filter_link = admin_url('edit.php?post_type=carts&status=' . $show_custom_state);
				$cart_status= __('<div class="awr_index_status"><mark class="awr_' . strtolower($show_custom_state) .'_index">'. __($show_custom_state, 'woocommerce_cart_reports') .'</mark></div>');


				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= $cart_status;
				$datatable_value .= ( "</td>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= ( $item->modify );
				$datatable_value .= ( "</td>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= wc_price($sum);
				$datatable_value .= ( "</td>" );


				//PRODUCTS COLUMNS
				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= '';
				$datatable_value .= ( "</td>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= '';
				$datatable_value .= ( "</td>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= '';
				$datatable_value .= ( "</td>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= '';
				$datatable_value .= ( "</td>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= '';
				$datatable_value .= ( "</td>" );


				//ACTIONS
				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= '<a href="'.esc_url( admin_url('post.php?post='. $item->id .'&action=edit') ).'">'.esc_html__('View Cart',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</a>';
				$datatable_value .= ( "</td>" );

				$datatable_value .= ( "</tr>" );


				$items = ( unserialize( $item->it_cartitems ) );
				$sum=0;
				foreach ( $items as $pitem ) {

					$datatable_value .= ( "<tr>" );

					$_product = wc_get_product($pitem['product_id']);
//					$sum+=($pitem['quantity']*$_product->get_price());

					//MAIN ROW
					//PRODUCTS COLUMNS
					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= '';
					$datatable_value .= ( "</td>" );

					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= '';
					$datatable_value .= ( "</td>" );

					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= '';
					$datatable_value .= ( "</td>" );

					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= '';
					$datatable_value .= ( "</td>" );

					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= '';
					$datatable_value .= ( "</td>" );

					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= '';
					$datatable_value .= ( "</td>" );


					//PRODUCTS COLUMNS
					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= $_product->get_title();
					$datatable_value .= ( "</td>" );

					//SKU
					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= $_product->get_sku();
					$datatable_value .= ( "</td>" );

					//VARIATION
					$variation='';
					if (isset( $pitem['variation'] ) && count( $pitem['variation'] ) > 0 ) {
						$variation_data = wc_get_formatted_variation( $pitem['variation'] , true );

						$variation = $variation_data;
					}
					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= $variation;
					$datatable_value .= ( "</td>" );

					//QTY
					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= $pitem['quantity'];
					$datatable_value .= ( "</td>" );

					//PRICE
					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= wc_price($_product->get_price());
					$datatable_value .= ( "</td>" );

					//ACTIONS
					$display_class = '';
					if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
						$display_class = 'display:none';
					}
					$datatable_value .= ( "<td style='" . $display_class . "'>" );
					$datatable_value .= '';
					$datatable_value .= ( "</td>" );

					$datatable_value .= ( "</tr>" );
				}

			}
		}else{
			foreach ( $order_items as $item ) {

				$cart = new IT_Cart_Receipt();
				$cart->load_receipt($item->id);
				$cart->set_guest_details();
				//print_r($cart);

				$items = ( unserialize( $item->it_cartitems ) );
				$sum=0;
				foreach ( $items as $pitem ) {
					$_product = wc_get_product($pitem['product_id']);
				    $sum+=($pitem['quantity']*$_product->get_price());
				}

				//$items = ( unserialize( $pitem->it_cartitems ) );
				$datatable_value .= ( "<tr>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= ( get_the_title($item->id ));
				$datatable_value .= ( "</td>" );

				//AUTHOR
                $author='';
                if($item->author==0)
                    $author=esc_html__('Guest',__IT_REPORT_WCREPORT_TEXTDOMAIN__);
                else
                    $author=get_user_meta($item->author,'billing_first_name',true).' '.get_user_meta($item->author,'billing_last_name',true);
				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .=  $author;
				$datatable_value .= ( "</td>" );


				//Email

				$email='';
				if($item->author==0)
					$email=esc_html__('Not Available',__IT_REPORT_WCREPORT_TEXTDOMAIN__);
				else
					$email=get_user_meta($item->author,'billing_email',true);

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .=  $email;
				$datatable_value .= ( "</td>" );


				//CART STATUS
				$show_custom_state = $cart->status();
				$filter_link = admin_url('edit.php?post_type=carts&status=' . $show_custom_state);
				$cart_status= __('<div class="awr_index_status"><mark class="awr_' . strtolower($show_custom_state) .'_index">'. __($show_custom_state, 'woocommerce_cart_reports') .'</mark></div>');


				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= $cart_status;
				$datatable_value .= ( "</td>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= ( $item->modify );
				$datatable_value .= ( "</td>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= wc_price($sum);
				$datatable_value .= ( "</td>" );

				$display_class = '';
				if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
					$display_class = 'display:none';
				}
				$datatable_value .= ( "<td style='" . $display_class . "'>" );
				$datatable_value .= '<a href="'.esc_url( admin_url('post.php?post='. $item->id .'&action=edit') ).'">'.esc_html__('View Cart',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</a>';
				$datatable_value .= ( "</td>" );

				$datatable_value .= ( "</tr>" );
			}
        }
	    //die();




	}elseif($file_used=="search_form"){
	?>
		<form class='alldetails search_form_report' action='' method='post'>
            <input type='hidden' name='action' value='submit-form' />

                <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Date From',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
                    <input name="it_from_date" id="pwr_from_date" type="text" readonly='true' class="datepick"/>
                </div>

                <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Date To',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
                    <input name="it_to_date" id="pwr_to_date" type="text" readonly='true' class="datepick"/>
                </div>
                <?php
					$col_style='';
					$permission_value=$this->get_form_element_value_permission('it_product_id');
					if($this->get_form_element_permission('it_product_id') ||  $permission_value!=''){

						if(!$this->get_form_element_permission('it_product_id') &&  $permission_value!='')
							$col_style='display:none';

				?>

                <div class="col-md-6" style=" <?php echo $col_style;?>">
                    <div class="awr-form-title">
                        <?php _e('Product',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-gear"></i></span>
					<?php
                        $products=$this->it_get_product_woo_data('all');
                        $option='';
                        $current_product=$this->it_get_woo_requests_links('it_product_id','',true);
                        //echo $current_product;

                        foreach($products as $product){
							$selected='';
							if(is_array($permission_value) && !in_array($product->id,$permission_value))
								continue;

							/*if(!$this->get_form_element_permission('it_product_id') &&  $permission_value!='')
								$selected="selected";*/


                            if($current_product==$product->id)
                                $selected="selected";
                            $option.="<option $selected value='".$product -> id."' >".$product -> label." </option>";
                        }


                    ?>
                    <select name="it_product_id[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                        <?php
                        	if($this->get_form_element_permission('it_product_id') && ((!is_array($permission_value)) || (is_array($permission_value) && in_array('all',$permission_value))))
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

                </div>
                <?php
					}
				?>

                 <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Customer',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-user"></i></span>
					<?php
                        $customers=$this->it_get_woo_customers_orders();

                        $cust=$this->it_dropdown_users();

                        $option='';
                        foreach($customers as $customer){
                            $option.="<option value='".$customer -> id."' >".$customer -> label." ($customer->counts)</option>";
                        }
                    ?>
                    <select name="it_customers_paid[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                        <option value="-1"><?php _e('Select All',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                        <?php
                            echo $cust;
                        ?>
                    </select>

                </div>


                <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Cart Status',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-sort-alpha-asc"></i></span>

                    <select name="it_orders_status[]" id="it_orders_status" class="it_orders_status">
                        <option value="">Show All Carts  </option>
                        <option value="Open">Open  </option>
                        <option value="Converted">Converted  </option>
                        <option value="Abandoned">Abandoned  </option>
                        <option value="OandA">Open + Abandoned Carts  </option>
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Show Order Item Details',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>

                    <input name="it_view_details" type="checkbox" value="yes" checked/>

                </div>


           	 	<div class="col-md-12 awr-save-form">
				<?php
                    $it_hide_os=$this->otder_status_hide;
                    $it_publish_order='no';
                    $it_order_item_name='';
                    $it_coupon_code='';
                    $it_coupon_codes='';
                    $it_payment_method='';

                    $it_variation_only=$this->it_get_woo_requests_links('it_variation_only','-1',true);
                    $it_order_meta_key='';

                    $data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);


                    $amont_zero='';

                ?>

                <input type="hidden" name="it_hide_os" value="<?php echo $it_hide_os;?>" />
                <input type="hidden" name="publish_order" value="<?php echo $it_publish_order;?>" />
                <input type="hidden" name="order_item_name" value="<?php echo $it_order_item_name;?>" />
                <input type="hidden" name="coupon_code" value="<?php echo $it_coupon_code;?>" />
                <input type="hidden" name="payment_method" value="<?php echo $it_payment_method;?>" />


                <input type="hidden" name="date_format" value="<?php echo $data_format; ?>" />

                <input type="hidden" name="table_names" value="<?php echo $table_name;?>"/>
                <div class="fetch_form_loading search-form-loading"></div>
                <button type="submit" value="Search" class="button-primary"><i class="fa fa-search"></i> <span><?php echo esc_html__('Search',__IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
                <button type="button" value="Reset" class="button-secondary form_reset_btn"><i class="fa fa-reply"></i><span><?php echo esc_html__('Reset Form',__IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
            </div>

        </form>

    <?php
	}

?>
