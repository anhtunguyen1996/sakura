<?php
	if($file_used=="sql_table")
	{
		//GET POSTED PARAMETERS
		$request 			= array();
		$start				= 0;
		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
		$date_format = $this->it_date_format($it_from_date);

		$it_product_id			= $this->it_get_woo_requests('it_product_id',"-1",true);
		$category_id 		= $this->it_get_woo_requests('it_category_id','-1',true);
		$tag_id 		= $this->it_get_woo_requests('it_tags_id','-1',true);
		$it_id_order_status 	= $this->it_get_woo_requests('it_id_order_status',NULL,true);
		$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
		//$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";
		$it_cat_prod_id_string = $this->it_get_woo_pli_category($category_id,$it_product_id);
		$it_show_cog		= $this->it_get_woo_requests('it_show_cog','no',true);

		//BRAND ADDONS
		$brand_id 		= $this->it_get_woo_requests('it_brand_id','-1',true);
		$it_brand_prod_id_string = $this->it_get_woo_pli_category($brand_id,$it_product_id);

		///////////HIDDEN FIELDS////////////
		$it_hide_os		= $this->it_get_woo_requests('it_hide_os','-1',true);
		$it_publish_order='no';

		$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);
		//////////////////////
		//$category_id 				= "-1";
		if(is_array($category_id)){ 		$category_id		= implode(",", $category_id);}
		if(is_array($tag_id)){ 		$tag_id		= implode(",", $tag_id);}

		//BRANDS ADDON
		if(is_array($brand_id)){ 		$brand_id		= implode(",", $brand_id);}


		/////////CUSTOM TAXONOMY//////////
		$key=$this->it_get_woo_requests('table_names','',true);

		$visible_custom_taxonomy=array();
		$post_name='product';

		$all_tax_cols=$all_tax_joins=$all_tax_conditions='';
		$custom_tax_cols=array();
		$all_tax=$this->fetch_product_taxonomies( $post_name );
		$current_value=array();
		if(defined("__IT_TAX_FIELD_ADD_ON__") && is_array($all_tax) && count($all_tax)>0){
			//FETCH TAXONOMY
			$i=10;
			foreach ( $all_tax as $tax ) {

				$tax_status=get_option(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.'set_default_search_'.$key.'_'.$tax);
				if($tax_status=='on'){


					$taxonomy=get_taxonomy($tax);
					$values=$tax;
					$label=$taxonomy->label;

					$translate=get_option($key.'_'.$tax."_translate");
					$show_column=get_option($key.'_'.$tax."_column");
					if($translate!='')
					{
						$label=$translate;
					}

					if($show_column=="on")
						$custom_tax_cols[]=array('lable'=>esc_html__($label,__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show');


					$visible_custom_taxonomy[]=$tax;

					${$tax} 		= $this->it_get_woo_requests('it_custom_taxonomy_in_'.$tax,'-1',true);

					/////////////////////////
					//APPLY PERMISSION TERMS
					$permission_value=$this->get_form_element_value_permission($tax,$key);
					$permission_enable=$this->get_form_element_permission($tax,$key);

					if($permission_enable && ${$tax}=='-1' && $permission_value!=1){
						${$tax}=implode(",",$permission_value);
					}
					/////////////////////////

					//echo(${$tax});

					if(is_array(${$tax})){ 		${$tax}		= implode(",", ${$tax});}

					$lbl_col=$tax."_cols";
					$lbl_join=$tax."_join";
					$lbl_con=$tax."_condition";


					${$lbl_col} ='';
					${$lbl_join} ='';
					${$lbl_con} = '';

					if(${$tax}  && ${$tax} != "-1") {
						${$lbl_col} = "

							,term_taxonomy$i.parent						AS term_parent";
					}

					$all_tax_cols=" ".${$lbl_col}." ";

					if(${$tax}  && ${$tax} != "-1") {
						${$lbl_join} = "
							LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships$i 	ON it_term_relationships$i.object_id		=	it_woocommerce_order_itemmeta7.meta_value
					LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy$i 		ON term_taxonomy$i.term_taxonomy_id	=	it_term_relationships$i.term_taxonomy_id
					";
					}

					$all_tax_joins.=" ".${$lbl_join}." ";

					if(${$tax}  && ${$tax} != "-1")
						${$lbl_con} = "AND term_taxonomy$i.taxonomy LIKE('$tax') AND term_taxonomy$i.term_id IN (".${$tax} .")";

					$all_tax_conditions.=" ".${$lbl_con}." ";

					$i++;
				}
			}
		}
		//////////////////


		//CATEGORY
		$category_id_cols='';
		$category_id_join='';
		$category_id_condition='';

		//TAG
		$tag_id_cols='';
		$tag_id_join='';
		$tag_id_condition='';

		//CATEGORY
		$brand_id_cols='';
		$brand_id_join='';
		$brand_id_condition='';
		$it_brand_prod_id_string_condition='';

		//PRODUCT
		$it_product_id_condition='';

		//DATE
		$it_from_date_condition='';

		//PRODUCT STRING
		$it_cat_prod_id_string_condition='';

		//ORDER STATUS
		$it_order_status_condition='';
		$it_id_order_status_join='';
		$it_id_order_status_condition='';

		//PUBLISH STATUS
		$it_publish_order_condition='';

		//HIDE ORDER STATUS
		$it_hide_os_condition='';


		/////////////////////////
		//APPLY PERMISSION TERMS
		$key=$this->it_get_woo_requests('table_names','',true);

		$category_id=$this->it_get_form_element_permission('it_category_id',$category_id,$key);
		$tag_id=$this->it_get_form_element_permission('it_tag_id',$category_id,$key);

		////ADDED IN VER4.0
		//BRANDS ADDONS
		$brand_id=$this->it_get_form_element_permission('it_brand_id',$brand_id,$key);

		$it_product_id=$this->it_get_form_element_permission('it_product_id',$it_product_id,$key);

		$it_order_status=$this->it_get_form_element_permission('it_orders_status',$it_order_status,$key);

		if($it_order_status != NULL  && $it_order_status != '-1')
			$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";
		///////////////////////////


		$sql = " SELECT ";

		$sql_columns = "
					it_woocommerce_order_items.order_item_name		AS 'product_name'
					,it_woocommerce_order_items.order_item_id		AS order_item_id
					,it_woocommerce_order_itemmeta7.meta_value		AS product_id
					,it_woocommerce_order_itemmeta8.meta_value		AS variation_id	,
											shop_order.ID as order_id
					,DATE(shop_order.post_date)					AS post_date
					";

		if($category_id  && $category_id != "-1") {

			$category_id_cols = "
					,it_terms.term_id								AS term_id
					,it_terms.name									AS term_name
					,term_taxonomy.parent						AS term_parent
				";
		}

		/////ADDED IN VER4.0
		/// PRODUCT TAG
		if($tag_id  && $tag_id != "-1") {

			$tag_id_cols = "
					,it_terms_tag.term_id								AS term_id_tag
					,it_terms_tag.name									AS term_name_tag
					,term_taxonomy_tag.parent						AS term_parent_tag
				";
		}

		//BRANDS ADDON
		if($brand_id  && $brand_id != "-1") {

			$brand_id_cols = "
					,it_terms_brand.term_id								AS term_id
					,it_terms_brand.name									AS term_name
					,term_taxonomy_brand.parent						AS term_parent
				";
		}

		//$sql .= " ,woocommerce_order_itemmeta.meta_value AS 'quantity' ,it_woocommerce_order_itemmeta6.meta_value AS 'total_amount'";
		$sql_columns .= "$category_id_cols $tag_id_cols $brand_id_cols ,SUM(woocommerce_order_itemmeta.meta_value) AS 'quantity' ,SUM(it_woocommerce_order_itemmeta6.meta_value) AS 'total_amount' ";


		//COST OF GOOD
		if($it_show_cog=='yes'){
			$sql_columns .= " ,SUM(woocommerce_order_itemmeta.meta_value * it_woocommerce_order_itemmeta22.meta_value) AS 'total_cost'";
		}


		$sql_joins = "
					{$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta ON woocommerce_order_itemmeta.order_item_id=it_woocommerce_order_items.order_item_id
					LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta6 ON it_woocommerce_order_itemmeta6.order_item_id=it_woocommerce_order_items.order_item_id ";

		//COST OF GOOD
		if($it_show_cog=='yes'){
			$sql_joins .=	"
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta22 ON it_woocommerce_order_itemmeta22.order_item_id=it_woocommerce_order_items.order_item_id ";
		}

		$sql_joins .=	"
        LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta7 ON it_woocommerce_order_itemmeta7.order_item_id=it_woocommerce_order_items.order_item_id

        LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta8 ON it_woocommerce_order_itemmeta8.order_item_id=it_woocommerce_order_items.order_item_id
                ";

		if($category_id  && $category_id != "-1") {
			$category_id_join = "
					LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships 	ON it_term_relationships.object_id		=	it_woocommerce_order_itemmeta7.meta_value
					LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy 		ON term_taxonomy.term_taxonomy_id	=	it_term_relationships.term_taxonomy_id
					LEFT JOIN  {$wpdb->prefix}terms 				as it_terms 				ON it_terms.term_id					=	term_taxonomy.term_id";
		}

		/////ADDED IN VER4.0
		/// PRODUCT TAG
		if($tag_id  && $tag_id != "-1") {
			$tag_id_join = "
					LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships_tag 	ON it_term_relationships_tag.object_id		=	it_woocommerce_order_itemmeta7.meta_value
					LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy_tag 		ON term_taxonomy_tag.term_taxonomy_id	=	it_term_relationships_tag.term_taxonomy_id
					LEFT JOIN  {$wpdb->prefix}terms 				as it_terms_tag 				ON it_terms_tag.term_id					=	term_taxonomy_tag.term_id";
		}


		//BRANDS ADDON
		if($brand_id  && $brand_id != "-1") {
			$brand_id_join = "
					LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships_brand 	ON it_term_relationships_brand.object_id		=	it_woocommerce_order_itemmeta7.meta_value
					LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy_brand 		ON term_taxonomy_brand.term_taxonomy_id	=	it_term_relationships_brand.term_taxonomy_id
					LEFT JOIN  {$wpdb->prefix}terms 				as it_terms_brand 				ON it_terms_brand.term_id					=	term_taxonomy_brand.term_id";
		}

		if($it_id_order_status  && $it_id_order_status != "-1") {
			$it_id_order_status_join= "
					LEFT JOIN  {$wpdb->prefix}term_relationships	as it_term_relationships2 	ON it_term_relationships2.object_id	=	it_woocommerce_order_items.order_id
					LEFT JOIN  {$wpdb->prefix}term_taxonomy			as it_term_taxonomy2 		ON it_term_taxonomy2.term_taxonomy_id	=	it_term_relationships2.term_taxonomy_id
					LEFT JOIN  {$wpdb->prefix}terms					as terms2 				ON terms2.term_id					=	it_term_taxonomy2.term_id";
		}




		$sql_joins .= " $category_id_join $tag_id_join $brand_id_join $it_id_order_status_join
					LEFT JOIN  {$wpdb->prefix}posts as shop_order ON shop_order.id=it_woocommerce_order_items.order_id";

		$sql_condition = "
					1*1
					AND woocommerce_order_itemmeta.meta_key	= '_qty'
					AND it_woocommerce_order_itemmeta6.meta_key	= '_line_total'";

		//COST OF GOOD
		if($it_show_cog=='yes'){
			$sql_condition .="
            AND it_woocommerce_order_itemmeta22.meta_key	= '".__IT_COG_TOTAL__."' ";
		}

		$sql_condition .="
        AND it_woocommerce_order_itemmeta7.meta_key 	= '_product_id'
        AND it_woocommerce_order_itemmeta8.meta_key 	= '_variation_id'
        AND shop_order.post_type					= 'shop_order'
        ";



		if ($it_from_date != NULL &&  $it_to_date !=NULL){
			$it_from_date_condition= "
					AND (DATE(shop_order.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format'))";
		}

		if($it_product_id  && $it_product_id != "-1")
			$it_product_id_condition = "
					AND it_woocommerce_order_itemmeta7.meta_value IN (".$it_product_id .")";

		if($category_id  && $category_id != "-1")
			$category_id_condition = "
					AND it_terms.term_id IN (".$category_id .")";

		////ADDED IN VER4.0
		/// PRODUCT TAG
		if($tag_id  && $tag_id != "-1")
			$tag_id_condition = "
					AND it_terms_tag.term_id IN (".$tag_id .")";

		//BRANDS ADDON
		if($brand_id  && $brand_id != "-1")
			$brand_id_condition = "
					AND it_terms_brand.term_id IN (".$brand_id .")";

		if($it_cat_prod_id_string  && $it_cat_prod_id_string != "-1")
			$it_cat_prod_id_string_condition= " AND it_woocommerce_order_itemmeta7.meta_value IN (".$it_cat_prod_id_string .")";

		////ADDED IN VER4.0
		//BRANDS ADDONS
		if($it_brand_prod_id_string  && $it_brand_prod_id_string != "-1")
			$it_brand_prod_id_string_condition= " AND it_woocommerce_order_itemmeta7.meta_value IN (".$it_brand_prod_id_string .")";

		if($it_id_order_status  && $it_id_order_status != "-1")
			$it_id_order_status_condition = "
					AND terms2.term_id IN (".$it_id_order_status .")";


		if(strlen($it_publish_order)>0 && $it_publish_order != "-1" && $it_publish_order != "no" && $it_publish_order != "all"){
			$in_post_status		= str_replace(",","','",$it_publish_order);
			$it_publish_order_condition= " AND  shop_order.post_status IN ('{$in_post_status}')";
		}
		//echo $it_order_status;
		if($it_order_status  && $it_order_status != '-1' and $it_order_status != "'-1'")
			$it_order_status_condition= " AND shop_order.post_status IN (".$it_order_status.")";

		if($it_hide_os  && $it_hide_os != '-1' and $it_hide_os != "'-1'")
			$it_hide_os_condition = " AND shop_order.post_status NOT IN ('".$it_hide_os."')";

		//$sql_group_by = " GROUP BY  it_woocommerce_order_itemmeta7.meta_value";
        //AFTER VARIATION PRODUCTS
		//$sql_group_by = " GROUP BY  order_item_id";
		$sql_group_by = " GROUP BY it_woocommerce_order_itemmeta7.meta_value,it_woocommerce_order_itemmeta8.meta_value";

		$sql_order_by = " ORDER BY total_amount DESC";

		$sql = "SELECT $sql_columns $all_tax_cols FROM $sql_joins $all_tax_joins WHERE
							$sql_condition $it_from_date_condition $it_product_id_condition
							$category_id_condition $tag_id_condition $brand_id_condition $all_tax_conditions  $it_cat_prod_id_string_condition
							$it_brand_prod_id_string_condition $it_id_order_status_condition $it_publish_order_condition
							$it_order_status_condition $it_hide_os_condition $sql_group_by $sql_order_by";

		//echo $sql;

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
		if ($it_from_date != NULL &&  $it_to_date !=NULL){
			$it_from_date_condition= "
					AND (DATE(shop_order.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format'))";
		}
		$this->sql_int_last_x_days = "SELECT $sql_columns $all_tax_cols FROM $sql_joins $all_tax_joins WHERE
							$sql_condition $it_from_date_condition $it_product_id_condition
							$category_id_condition $tag_id_condition $brand_id_condition $all_tax_conditions  $it_cat_prod_id_string_condition
							$it_brand_prod_id_string_condition $it_id_order_status_condition $it_publish_order_condition
							$it_order_status_condition $it_hide_os_condition $sql_group_by $sql_order_by";

		//echo $this->sql_int_last_x_days;

		//////////////////////////////////////////////////////
        //GET REFUNDED PRODUCTS FOR TOP-RIGHT BOX
		//////////////////////////////////////////////////////
		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
        $this->sql_int_refund_products="SELECT  it_woocommerce_order_itemmeta_v.meta_value as variation_id,DATE_FORMAT(it_posts.post_date,'%m/%d/%Y') AS order_date, it_woocommerce_order_items.order_id AS order_id, it_woocommerce_order_items.order_item_name AS product_name,	it_woocommerce_order_items.order_item_id	AS order_item_id, woocommerce_order_itemmeta.meta_value AS woocommerce_order_itemmeta_meta_value,	(it_woocommerce_order_itemmeta2.meta_value/it_woocommerce_order_itemmeta3.meta_value) AS sold_rate, (it_woocommerce_order_itemmeta4.meta_value/it_woocommerce_order_itemmeta3.meta_value) AS product_rate, (it_woocommerce_order_itemmeta4.meta_value) AS item_amount, (it_woocommerce_order_itemmeta2.meta_value) AS item_net_amount, (it_woocommerce_order_itemmeta4.meta_value - it_woocommerce_order_itemmeta2.meta_value) AS item_discount,	it_woocommerce_order_itemmeta2.meta_value AS total_price, count(it_woocommerce_order_items.order_item_id) AS product_quentity, woocommerce_order_itemmeta.meta_value AS product_id ,it_woocommerce_order_itemmeta3.meta_value AS 'product_quantity'	,it_posts.post_status AS post_status ,it_posts.post_status AS order_status FROM {$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items LEFT JOIN {$wpdb->prefix}posts as it_posts ON it_posts.ID=it_woocommerce_order_items.order_id	LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta ON woocommerce_order_itemmeta.order_item_id	=	it_woocommerce_order_items.order_item_id LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta2 ON it_woocommerce_order_itemmeta2.order_item_id	=	it_woocommerce_order_items.order_item_id LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta3 ON it_woocommerce_order_itemmeta3.order_item_id	=	it_woocommerce_order_items.order_item_id LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta4 ON it_woocommerce_order_itemmeta4.order_item_id	=	it_woocommerce_order_items.order_item_id AND it_woocommerce_order_itemmeta4.meta_key='_line_subtotal' LEFT JOIN {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_v ON it_woocommerce_order_itemmeta_v.order_item_id	=	it_woocommerce_order_items.order_item_id Where it_posts.post_type = 'shop_order' AND (woocommerce_order_itemmeta.meta_key = '_product_id') AND  it_woocommerce_order_itemmeta_v.meta_key = '_variation_id' AND it_woocommerce_order_itemmeta2.meta_key='_line_total' AND it_woocommerce_order_itemmeta3.meta_key='_qty' AND DATE(it_posts.post_date) BETWEEN '$it_from_date' AND '$it_to_date' AND it_posts.post_status NOT IN ('trash') GROUP BY it_woocommerce_order_items.order_item_id ORDER BY order_id DESC ";
        //echo  $this->sql_int_refund_products;

	}
    elseif($file_used=="data_table"){

        //////////////////////////////////////////////////////
	    //FETCH REFUND PRODUCTS & CUSTOMER NO for EACH PRODUCT
        //////////////////////////////////////////////////////
	    $order_items=$wpdb->get_results($this->sql_int_refund_products);

	    $categories = array();
	    $order_meta = array();
	    $product_customers_no=array();
	    if(count($order_items)>0)
		    foreach ( $order_items as $key => $order_item ) {

			    $order_id								= $order_item->order_id;
			    $order_items[$key]->billing_first_name  = '';//Default, some time it missing
			    $order_items[$key]->billing_last_name  	= '';//Default, some time it missing
			    $order_items[$key]->billing_email  		= '';//Default, some time it missing

			    if(!isset($order_meta[$order_id])){
				    $order_meta[$order_id]					= $this->it_get_full_post_meta($order_id);
			    }

			    //	die(print_r($order_meta[$order_id]));

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
		    }

	    $refunded_products=array();


	    $net_amnt_main=$part_refund_amnt=$order_count=0;
	    $first_order_id='';
	    $customer_array=array();
	    foreach($order_items as $items){

		    $p_id=$items->product_id;
		    if($items->variation_id)
			    $p_id=$items->variation_id;

		    $date_format		= get_option( 'date_format' );

		    $order_refund_amnt= $this->it_get_por_amount($items -> order_id);
		    $part_refund=(isset($order_refund_amnt[$items->order_id])? $order_refund_amnt[$items->order_id]:0);
		    if($items->post_status=='wc-refunded') {
			    //echo $items -> order_item_id.$items->post_status.$items->product_name;;
			    //die();
			    $refunded_products[ $p_id ]['name']        = $items->product_name;
			    if(!isset($refunded_products[ $p_id ]['quantity']))
				    $refunded_products[ $p_id ]['quantity']    = $items->product_quantity;
			    else
				    $refunded_products[ $p_id ]['quantity']   += $items->product_quantity;
			    $refunded_products[ $p_id ]['item_amount'] = $items->item_amount;

			    $part_refund_amnt+=$items->total_price;
		    }
		    $customer_array[ $p_id ][]  = $items->customer_user;

		    //Order Total
		    $it_table_value = isset($items -> order_total) ? ($items -> order_total)-$part_refund : 0;
		    $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

		    $it_table_value = isset($items -> order_total) ? ($items -> order_total)-$part_refund : 0;
		    // $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

            //CALC INDIVIDUAL PARTIAL REFUND
		    $order_p_refund_amnt= $this->it_get_por_amount_individual($items -> order_id,$items->order_item_id ,'order');
		    $individual_part_refund=(isset($order_p_refund_amnt[$items->order_id])? $order_p_refund_amnt[$items->order_id]:0);
		    $individual_part_refund=abs($individual_part_refund);

		    if($individual_part_refund){
			    $refunded_products[ $p_id ]['name']        = $items->product_name;
			    if(!isset($refunded_products[ $p_id ]['quantity']))
				    $refunded_products[ $p_id ]['quantity']    = $items->product_quantity;
			    else
				    $refunded_products[ $p_id ]['quantity']   += $items->product_quantity;
			    $refunded_products[ $p_id ]['item_amount'] = $individual_part_refund;
            }

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

			    if($items->post_status!='wc-refunded') {
			        $part_refund_amnt+=$order_refund_amnt[$items->order_id];
			        $net_amnt_main+=$it_table_value;
                }
			    $order_count++;
		    }
	    }

	    //print_r($refunded_products);

	    $id1=$id2=$id3='';
	    $vid1=$vid2=$vid3=0;

	    //////////////////////////////////////////////////////
        /// 3 products - TOP-RIGHT BOX HTML
        //////////////////////////////////////////////////////
	    foreach($refunded_products as $key=>$refunded){

	        $refund_percent=($refunded['item_amount']*$refunded['quantity']*100)/$net_amnt_main;
		    $refund_percent=number_format($refund_percent,2);

	        if($id1==''){
		        $id1='
                <div class="pw-info">
                    <div class="pw-cols col-xs-4 col-md-4">
                        <span class="pw-md-font">'.$refund_percent.'%</span>
                    </div>

                    <div class="pw-cols col-xs-8 col-md-8">
                        <div class="pw-sm-font">'.$refunded['name'].'</div>
                        <div class="pw-sm-font pw-val">'.$this->price($refunded['item_amount']).' • '.$refunded['quantity'].'</div>
                    </div>
                </div>
                ';
	            $vid1=$refund_percent;
            }else{
	            if($refund_percent>$vid1){
	                $id3=$id2;
	                $id2=$id1;
	                $id1='
	                <div class="pw-info">
                        <div class="pw-cols col-xs-4 col-md-4">
                            <span class="pw-md-font">'.$refund_percent.'%</span>
                        </div>

                        <div class="pw-cols col-xs-8 col-md-8">
                            <div class="pw-sm-font">'.$refunded['name'].'</div>
                            <div class="pw-sm-font pw-val">'.$this->price($refunded['item_amount']).' • '.$refunded['quantity'].'</div>
                        </div>
                    </div>
	                ';
	                $vid3=$vid2;
	                $vid2=$vid1;
	                $vid1=$refund_percent;
                }elseif($refund_percent>$vid2 && $refund_percent<$vid1){
		            $id3=$id2;
		            $id2='
	                <div class="pw-info">
                        <div class="pw-cols col-xs-4 col-md-4">
                            <span class="pw-md-font">'.$refund_percent.'%</span>
                        </div>

                        <div class="pw-cols col-xs-8 col-md-8">
                            <div class="pw-sm-font">'.$refunded['name'].'</div>
                            <div class="pw-sm-font pw-val">'.$this->price($refunded['item_amount']).' • '.$refunded['quantity'].'</div>
                        </div>
                    </div>
	                ';
		            $vid3=$vid2;
		            $vid2=$refund_percent;
                }elseif($refund_percent>$vid3 && $refund_percent<$vid2){
		            $id3='
	                <div class="pw-info">
                        <div class="pw-cols col-xs-4 col-md-4">
                            <span class="pw-md-font">'.$refund_percent.'%</span>
                        </div>

                        <div class="pw-cols col-xs-8 col-md-8">
                            <div class="pw-sm-font">'.$refunded['name'].'</div>
                            <div class="pw-sm-font pw-val">'.$refunded['item_amount'].' • '.$refunded['quantity'].'</div>
                        </div>
                    </div>
	                ';
		            $vid3=$refund_percent;
	            }
            }

        }

        $refunded_products_html=$id1.$id2.$id3;


	    $it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
	    $it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);

	    $from=date_create($it_from_date);
	    $to=date_create($it_to_date);
	    $diff=date_diff($to,$from);

	    $days = $diff->format('%a')+1;

	    $days_ago = date('Y-m-d', strtotime("-$days days", strtotime($it_from_date)));

	    $order_items=$this->results;
        //echo $this->sql_int_last_x_days;

	    //////////////////////////////////////////////////////
	    //GET LAST x DAYS FOR DETECT RANK of ITEMS
	    //////////////////////////////////////////////////////
	    $result_last_x_days=$wpdb->get_results($this->sql_int_last_x_days);
	    $product_last_x_days=array();
	    $product_current_x_days=array();
        if(count($order_items)>0){
            foreach($result_last_x_days as $items){
                    $product_last_x_days[]=$items->product_id;
            }
        }

	    $top_3_products_html='';
	    $top_1_products_html='';
	    $top_5_product_chart=array();
	    $top_5_product_ids=array();
	    $top_5_product_chart_array=array();
	    $products_list_html='';


	    $product_count=$sales_qty=$total_amnt=$product_amnt=$profit_amnt=$top_20_products=0;

	    $currency_decimal=get_option('woocommerce_price_decimal_sep','.');
	    $currency_thousand=get_option('woocommerce_price_thousand_sep',',');
	    $currency_thousand=',';

	    //////////////////////////////////////////////////////
	    //TOP 20% Products
	    //////////////////////////////////////////////////////
	    //sum((sold_item_no*20%))/total*100
	    $sold_item_no = count($this->results);
        $sold_item_no= round(($sold_item_no*20)/100);

        $product_fast_slow_move=array();
	    $today_date=date("Y-m-d");
	    $categories = array();
	    $order_meta = array();

	    $trending_product_title=$trending_product_rank=$falling_product_title=$falling_product_rank='';

	    //////////////////////////////////////////////////////
        /// GET ALL PRODUCTS - MAIN SQL
        /// PRODUCT RANK - PRODUCT HTML
        /// FAST-SLOW-TRENDING-FALLING PRODUCTS
	    //////////////////////////////////////////////////////
	    if(count($order_items)>0)
	        $i=0;
	        foreach($this->results as $items){
		        $product_count++;

		        $p_id=$items->product_id;
		        if($items->variation_id)
			        $p_id=$items->variation_id;

		        $_product = wc_get_product( $p_id );
		        $product_price= $_product->get_regular_price();
		        $product_amnt+=$product_price;
		        $img=wp_get_attachment_image( $_product->get_image_id(), 'thumbnail' );
		        $img_url=wp_get_attachment_image_url( $_product->get_image_id(), 'thumbnail' );
		        if($img==''){
			        $img='<img src="'.__IT_REPORT_WCREPORT_URL__ .'/assets/images/no_image.jpg">';
                }

		        $p_title=$items->product_name;
		        if($items->product_name=='')
		            $p_title=get_the_title($items->product_id);



		        //FAST - SLOW MOVEMENT PRODUCTS
		        $publish_date=$_product->get_date_created();

		        $from=date_create($today_date);
		        $to=date_create($publish_date);
		        $diff=date_diff($to,$from);
		        $diff_days = $diff->format('%a')+1;

		        $slow_fast_calc=$items->total_amount==0 ? 0 : ($items->total_amount/$diff_days);
		        $product_fast_slow_move[$p_id]=$slow_fast_calc;

		        $product_current_x_days[]=$p_id;
		        //DETECT THE RANK OF ITEMS
                $this_rank='<i class="fa fa-arrow-up pw-green"></i>';
                $this_rank_title='Up by 1 positions';
                $this_rank_type="fa-arrow-up pw-green";
		        if(in_array($p_id,$product_last_x_days)){
			        if(array_search($p_id,$product_last_x_days)>$i){
				        $this_rank='<i class="fa fa-arrow-up pw-green"></i>';
				        $this_rank_type="fa-arrow-up pw-green";
				        $diff_rank=array_search($p_id,$product_last_x_days)-$i;
				        $this_rank_title="Up by $diff_rank positions";
				        if($trending_product_rank==''){
					        $trending_product_rank=$diff_rank;
					        $trending_product_title=$p_title;
				        }elseif($diff_rank>$trending_product_rank){
					        $trending_product_rank=$diff_rank;
					        $trending_product_title=$p_title;
				        }

			        }else if(array_search($p_id,$product_last_x_days)<$i){
				        $this_rank='<i class="fa fa-arrow-down pw-red"></i>';
				        $this_rank_type="fa-arrow-down pw-red";
				        $diff_rank=$i-array_search($p_id,$product_last_x_days);
				        $this_rank_title="Down by $diff_rank positions";
				        if($falling_product_rank==''){
					        $falling_product_rank=$diff_rank;
					        $falling_product_title=$p_title;
				        }elseif($diff_rank>$falling_product_rank){
					        $falling_product_rank=$diff_rank;
					        $falling_product_title=$p_title;
				        }
			        }else{
				        $this_rank='';
			        }
		        }else{
			        $this_rank='<i class="fa fa-arrow-up pw-green"></i>';
			        $this_rank_type="fa-arrow-up pw-green";
			        $diff_rank=$i;
			        $this_rank_title="Up by $diff_rank positions";
			        if($falling_product_rank==''){
				        $trending_product_rank=$diff_rank;
				        $trending_product_title=$p_title;
			        }elseif($diff_rank>$trending_product_rank){
				        $trending_product_rank=$diff_rank;
				        $trending_product_title=$p_title;
			        }
		        }

		        if($diff_rank==0){
		            $this_rank='';
		            $this_rank_title='Same Position';
			        $this_rank_type="";
                }



		        $sales_qty+=$items->quantity;
		        $total_amnt+=$items->total_amount;



		        $sku=$this->it_get_prod_sku($items->order_item_id, $p_id);


		        //INDIVIDUAL REFUNDS
		        $order_p_refund_amnt= $this->it_get_por_amount_individual($items -> order_id,$p_id ,'item',$it_from_date,$it_to_date);
		        $individual_part_refund=(isset($order_p_refund_amnt[$p_id])? $order_p_refund_amnt[$p_id]:0);
		        $individual_part_refund=abs($individual_part_refund);

		        //echo $p_id.':'.$items->total_amount.'-'.$individual_part_refund.'@';

		        $it_table_value = isset($items->total_amount) ? ($items->total_amount)-$individual_part_refund : 0;

		        $product_price= $it_table_value == 0 ? $this->price(0) : $this->price($it_table_value);


		        //TOP %20 Products
		        if($i<$sold_item_no){
			        $top_20_products+=$it_table_value;
                }

		        if($i==0){
                    $top_1_products_html= $product_price == 0 ? $this->price(0) : $this->price($product_price);
                }
                if($i<=2){
                    $top_3_total=$it_table_value == 0 ? $this->price(0) : $this->price($it_table_value);
	                $top_3_products_html.='
                            <div class="pw-info">
                                <div class="pw-sm-font">'.get_the_title($p_id).'</div>
                                <div class="pw-val pwl-lbl">'.$top_3_total.' • '.$items->quantity.'</div>
                            </div>';

                }

		        if($i<4){
                    $value=  (is_numeric($it_table_value) ?  number_format($it_table_value,2):0);
			        $value=str_replace($currency_thousand,"",$value);
                    $top_5_product_chart[$items->post_date][$p_id]=$this->price_value($value);
                    $top_5_product_ids[$p_id]=$this->price_value($value);


			        $top_5_product_chart_ballon[$i]['balloonText']="<img src='$img_url' style='vertical-align:bottom; margin-right: 10px; width:28px; height:21px;'><span style='font-size:14px; color:#000000;'><b>".$current_currency=get_woocommerce_currency_symbol()."[[value]]</b></span>";
			        $top_5_product_chart_ballon[$i]['fillAlphas']=0.6;
			        $top_5_product_chart_ballon[$i]['lineAlpha']=0.4;
			        $top_5_product_chart_ballon[$i]['title']=$p_title;
			        $top_5_product_chart_ballon[$i]['valueField']=$p_id;

		        }

		        $i++;



		        $class="pw-cols col-xs-12 col-md-3";
		        if($i>8){
			        $class="pw-cols col-xs-12 col-md-2";
                }


                $customer_count=isset($customer_array[$p_id]) ? count(array_unique($customer_array[$p_id])) : 0;
		        $products_list_html.='
		        <div class="'.$class.' it_int_products_single" data-product-id="'.$p_id.'" data-product-rank-type="'.$this_rank_type.'" data-product-rank-val="'.$i.'" data-product-rank-title="'.$this_rank_title.'">
                    <div class="pw-cards-cnt" href="#">
                        <div class="awr-int-loading">
                            <div class="awr-loading-css"><div class="rect1"></div><div class="rect2"></div> <div class="rect3"></div><div class="rect4"></div><div class="rect5"></div></div>
                        </div>
                        <div class="pw-cards-thumb">
                            '.$img.'
                            <div class="pw-rank-cnt" title="'.$this_rank_title.'">
                                <span class="pw-xs-font">
                                    <span>'.$i.'</span>
                                    <sup>st</sup>
                                </span>
                                '.$this_rank.'
                            </div>
                        </div>
                        <div class="pw-card-detail pw-center-align">
                            <div class="pw-box-padder">
                                <div class="pw-md-font">'.$p_title.'</div>
                                <div class="pw-val pw-sm-font" title="Product ID: sku-woo">'.$sku.'</div>
                            </div>
                        </div>
                        <div class="pw-card-bottom">
                            <div class="pw-box-padder">
                                <span class="pw-sm-font" title="Sales">
                                    <span class="pw-val"><i class="fa fa-money"></i></span>
                                    <span>'.$product_price.'</span>
                                </span>
                                <span class="pw-sm-font pull-right pw-card-user" title="'.esc_html__( 'Customer', __IT_REPORT_WCREPORT_TEXTDOMAIN__ ).'">
                                    <span class="pw-val"><i class="fa fa-user"></i></span>
                                    <span>'.$customer_count.'</span>
                                </span>
                                <span class="pw-sm-font pull-right" title="'.esc_html__( 'Quantities Sold', __IT_REPORT_WCREPORT_TEXTDOMAIN__ ).'">
                                    <span class="pw-val"><i class="fa fa-shopping-bag"></i></span>
                                    <span>'.$items->quantity.'</span>
                                </span>


                            </div>
                        </div>
                    </div>
                </div>
		        ';
		    }


		//print_r($order_products);
		//print_r($product_last_x_days);
//	    $product_ranking=array();
//		foreach($product_current_x_days as $key=>$c_rank_id){
//		    if(in_array($c_rank_id,$product_last_x_days)){
//		        if(array_search($c_rank_id,$product_last_x_days)>$key){
//			        $product_ranking[$c_rank_id]="up";
//                }else if(array_search($c_rank_id,$product_last_x_days)<$key){
//			        $product_ranking[$c_rank_id]="down";
//                }else{
//			        $product_ranking[$c_rank_id]="equal";
//                }
//            }else{
//		        $product_ranking[$c_rank_id]="up";
//            }
//        }
//
//        print_r($product_ranking);


	    asort ($product_fast_slow_move);
        //print_r($product_fast_slow_move);
        $product_fast_move=end($product_fast_slow_move);
        $product_fast_move_id=end(array_keys($product_fast_slow_move));

        $product_slow_move=reset($product_fast_slow_move);
        $product_slow_move_id=key($product_fast_slow_move);

	    $product_fast_move=get_the_title($product_fast_move_id);
	    $product_slow_move=get_the_title($product_slow_move_id);


//        foreach ($product_fast_slow_move as $key=>$p_slow_fast){
//	        $from=date_create($today_date);
//	        $to=date_create($key);
//	        $diff=date_diff($to,$from);
//	        $diff_days = $diff->format('%a')+1;
//	        $product_fast_slow_move[$key]['days']=$diff_days;
//        }

	    //sum((sold_item_no*20%))/total*100

        //$top_20_products=(float)number_format($top_20_products,2 ) ;
	    //echo $top_20_products;
        //echo $total_amnt;
	    $top_20_products_percent=(float)number_format(($top_20_products/$total_amnt)*100,2 ) ."%";
	    $top_20_products= $top_20_products == 0 ? $this->price(0) : $this->price($top_20_products);

        // print_r($top_5_product_ids);

	    //////////////////////////////////////////////////////
        /// TOP 5 PRODUCTS CHART
	    //////////////////////////////////////////////////////
	    foreach ($top_5_product_chart as $key=>$data){
		    $result=array_diff($top_5_product_ids,$data);
	        if(count($result)>0){
		        foreach ($result as $k=>$ids) {
			        $top_5_product_chart[$key][$k]=0;
		        }
            }
        }

        //print_r($top_5_product_chart);
        $i=0;
        foreach ($top_5_product_chart as $key=>$data){

            $top_5_product_chart_array[$i]['date']= $key;
            foreach($data as $k=>$val){
                $top_5_product_chart_array[$i][$k]= $val;
            }
            $i++;
        }

		$total_amnt_html= $total_amnt == 0 ? $this->price(0) : $this->price($total_amnt);
	    $avg_rev_day=number_format($sales_qty/$days,2 );

	    //////////////////////////////////////////////////////
	    //GET NUMBER OF ALL PRODUCTS
	    //////////////////////////////////////////////////////
	    $query = new WP_Query( array( 'post_type' => 'product', 'post_status' => 'publish' ) );
	    $all_products_no = $query->found_posts;


        $output.= '
        <div id="it_rpt_fetch_single_product_main">
            <div class="pw-cols col-xs-12 col-md-6">
                <div class="int-awr-box pw-main-box">
                    <div class="awr-title">
                        <h3>
                            <i class="fa fa-money"></i>'.esc_html__('Top Products',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</h3>
                        <div class="awr-title-icons">
                            <div class="awr-title-icon awr-setting-icon" style="display: none;"><i class="fa fa-cog"></i></div>
                            <div class="awr-title-icon awr-close-icon" style="display: none;"><i class="fa fa-times"></i></div>
                        </div>
                    </div>

                    <div class="int-awr-box-content">
                        <div id="int_top_products_chart_args"></div>
                    </div>
                </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-3">
                <div class="int-awr-box pw-main-box">
                    <div class="awr-title">
                        <h3>
                            <i class="fa fa-map-marker"></i>'.esc_html__('Best First Purchases',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</h3>
                        <div class="awr-title-icons">
                            <div class="awr-title-icon awr-add-fav-icon awr-tooltip-wrapper" data-smenu="all_orders">
                                <i class="fa  fa-info "></i>
                                <div class="awr-tooltip-cnt">
                                    <div class="awr-tooltip-header">'.esc_html__('Best First Purchases',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                                    <div class="awr-tooltip-content">'.esc_html__('This is a list of products that the customers buy the very first time they make a purchase on your store. After which, they also buy more products on your store.',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                                </div>
                            </div>
                            <div class="awr-title-icon awr-setting-icon" style="display: none;"><i class="fa fa-cog"></i></div>
                            <div class="awr-title-icon awr-close-icon" style="display: none;"><i class="fa fa-times"></i></div>
                        </div>
                    </div>

                    <div class="int-awr-box-content">

                        <div class="pw-box-padder">
                            <div class="pw-info-cnt">
                                '.$top_3_products_html.'
                             </div>
                        </div>

                    </div>

                </div>
            </div>
            <div class="pw-cols col-xs-12 col-md-3">
                <div class="int-awr-box pw-main-box">
                    <div class="awr-title">
                        <h3>
                            <i class="fa fa-map-marker"></i>'.esc_html__('Highest Refunded',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</h3>
                        <div class="awr-title-icons">
                            <div class="awr-title-icon awr-add-fav-icon awr-tooltip-wrapper" data-smenu="all_orders">
                                <i class="fa  fa-info "></i>
                                <div class="awr-tooltip-cnt">
                                    <div class="awr-tooltip-header">'.esc_html__('Highest Refunded',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                                    <div class="awr-tooltip-content">'.esc_html__('List of products which had the highest percentage of refunds for the selected date range.',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                                </div>
                            </div>
                            <div class="awr-title-icon awr-setting-icon" style="display: none;"><i class="fa fa-cog"></i></div>
                            <div class="awr-title-icon awr-close-icon" style="display: none;"><i class="fa fa-times"></i></div>
                        </div>
                    </div>

                    <div class="int-awr-box-content">
                        <div class="pw-box-padder">
                            <div class="pw-info-cnt">
                                '.$refunded_products_html.'
                            </div>
                        </div>
                    </div>

                </div>
            </div>

            <div class="col-xs-12 col-md-12">
                <div class="int-awr-box pw-center-align pw-pr-sum-box">
                    <div class="col-xs-12 col-sm-6 col-md-3 pw-border-bottom">
                        <div class="pw-box-padder">
                            <div class="pw-lg-font pw-green">'.$top_20_products.' • '.$top_20_products_percent.'</div>
                            <div class="pw-val pwl-lbl">'.esc_html__('TOP 20% PRODUCTS',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3 pw-border-bottom">
                        <div class="pw-box-padder">
                            <div class="pw-lg-font pw-green">'.$total_amnt_html.' • '.$sales_qty.'</div>
                            <div class="pw-val pwl-lbl">'.esc_html__('TOTAL',__IT_REPORT_WCREPORT_TEXTDOMAIN__).' • '.esc_html__('QTY SOLD',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3 pw-border-bottom">
                        <div class="pw-box-padder">
                            <div class="pw-lg-font pw-green">'.$product_fast_move.'</div>
                            <div class="pw-val pwl-lbl">'.esc_html__('FASTEST MOVING PRODUCT',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3 pw-border-bottom">
                        <div class="pw-box-padder">
                            <div class="pw-lg-font pw-green">'.$product_slow_move.'</div>
                            <div class="pw-val pwl-lbl">'.esc_html__('SLOWEST MOVING PRODUCT',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="pw-box-padder">
                            <div class="pw-lg-font pw-green">'.(float)$avg_rev_day.' / day</div>
                            <div class="pw-val pwl-lbl">'.esc_html__('AVERAGE QTY SOLD',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="pw-box-padder">
                            <div class="pw-lg-font pw-green">'.$product_count.' / '.$all_products_no.'</div>
                            <div class="pw-val pwl-lbl">'.esc_html__('PRODUCTS SOLD VS TOTAL',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="pw-box-padder">
                            <div class="pw-lg-font pw-green">'.$trending_product_title.'</div>
                            <div class="pw-val pwl-lbl">'.esc_html__('TRENDING UP',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                        </div>
                    </div>

                    <div class="col-xs-12 col-sm-6 col-md-3">
                        <div class="pw-box-padder">
                            <div class="pw-lg-font pw-green">'.$falling_product_title.'</div>
                            <div class="pw-val pwl-lbl">'.esc_html__('FALLING DOWN',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-xs-12 col-md-12">
                <h3 class="pw-out-title">'.esc_html__('Product Cards',__IT_REPORT_WCREPORT_TEXTDOMAIN__).'</h3>
                '.$products_list_html.'
            </div>
        </div><!--it_rpt_fetch_single_product_main-->
        <div id="it_rpt_fetch_single_product_html" class="pw-cols col-xs-12 col-md-12"></div>
	    <div id="it_rpt_fetch_single_customer_html" class="pw-cols col-xs-12 col-md-12"></div>';
    ?>


    <script>

        var int_top_products_chart_args_data =<?php echo json_encode(($top_5_product_chart_array)); ?>;
        var int_top_products_chart_args_graph =<?php echo json_encode(($top_5_product_chart_ballon)); ?>;
        var int_total_products_amnt =<?php echo $total_amnt; ?>;
        var int_total_refund_products_amnt =<?php echo $part_refund_amnt; ?>;

    </script>
    <?php

	}elseif($file_used=="search_form"){
		global $it_rpt_main_class;
		$this->it_get_date_form_to();
		$it_from_date=$it_rpt_main_class->it_from_date_dashboard;
		$it_to_date=$it_rpt_main_class->it_to_date_dashboard;
	?>
		<form class='alldetails search_form_report' action='' method='post'  id="intelligence_top_product_chart">
            <input type='hidden' name='action' value='submit-form' />


                <input type='hidden' name='action' value='submit-form' />
                <input type='hidden' name="it_from_date" id="pwr_from_date_dashboard" value="<?php echo $it_from_date;?>"/>
                <input type='hidden' name="it_to_date" id="pwr_to_date_dashboard"  value="<?php echo $it_to_date;?>"/>
                <input type="hidden" name="it_orders_status[]" id="order_status" value="<?php echo $this->it_shop_status; ?>">


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
	//print_r($top_5_product_chart_array);
//echo json_encode($top_5_product_chart_array);
?>
