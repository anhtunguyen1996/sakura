<?php

	if($file_used=="sql_table")
	{

		//GET POSTED PARAMETERS
		$start				= 0;
		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
		$date_format = $this->it_date_format($it_from_date);

		$it_coupon_code		= $this->it_get_woo_requests('coupon_code','-1',true);
		$it_coupon_codes	= $this->it_get_woo_requests('it_codes_of_coupon','-1',true);
		if($it_coupon_codes!="-1")
			$it_coupon_codes  		= "'".str_replace(",","','",$it_coupon_codes)."'";
		$coupon_discount_types		= $this->it_get_woo_requests('it_coupon_discount_types','-1',true);
		if($coupon_discount_types!="-1")
			$coupon_discount_types  		= "'".str_replace(",","','",$coupon_discount_types)."'";
		$it_country_code		= $this->it_get_woo_requests('it_countries_code','-1',true);

		$it_sort_by 			= $this->it_get_woo_requests('sort_by','-1',true);
		$it_order_by 			= $this->it_get_woo_requests('order_by','DESC',true);

		$it_id_order_status 	= $this->it_get_woo_requests('it_id_order_status',NULL,true);
		$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
		if($it_order_status!="-1")
			$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";


		///////////HIDDEN FIELDS////////////
		$it_hide_os		= $this->it_get_woo_requests('it_hide_os','-1',true);
		$it_publish_order='no';
		$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);
		//////////////////////


		//COPUN DISCOUNT
		$coupon_discount_types_join='';
		$coupon_discount_types_condition_1='';
		$coupon_discount_types_condition_2='';

		//DATE
		$it_from_date_condition='';

		//ORDER STATUS ID
		$it_id_order_status_join='';
		$it_id_order_status_condition='';
		$it_order_status_condition='';

		//PUBLISH
		$it_publish_order_condition='';

		//COUPON COED
		$it_coupon_code_condition='';
		$it_coupon_codes_condition ='';

		//COUNTRY
		$it_country_code_condition='';

		//HIDE ORDER
		$it_hide_os_condition ='';

		$sql_columns = "
		it_woocommerce_order_items.order_item_name				AS		'order_item_name',
		it_woocommerce_order_items.order_item_name				AS		'coupon_code',
		SUM(woocommerce_order_itemmeta.meta_value) 			AS		'total_amount',
		SUM(woocommerce_order_itemmeta.meta_value) 				AS 		'coupon_amount' ,
		Count(*) 											AS 		'coupon_count'";

		$sql_joins = "
		{$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items
		LEFT JOIN	{$wpdb->prefix}posts	as it_posts ON it_posts.ID = it_woocommerce_order_items.order_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta ON woocommerce_order_itemmeta.order_item_id=it_woocommerce_order_items.order_item_id
		";


		if($coupon_discount_types && $coupon_discount_types != "-1"){
			$coupon_discount_types_join = " LEFT JOIN	{$wpdb->prefix}posts	as coupons ON coupons.post_title = it_woocommerce_order_items.order_item_name";
			$coupon_discount_types_join .= " LEFT JOIN	{$wpdb->prefix}postmeta	as it_coupon_discount_type ON it_coupon_discount_type.post_id = coupons.ID";
		}

		if(strlen($it_id_order_status)>0 && $it_id_order_status != "-1" && $it_id_order_status != "no" && $it_id_order_status != "all"){
				$it_id_order_status_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships 	ON it_term_relationships.object_id		=	it_posts.ID
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy 		ON term_taxonomy.term_taxonomy_id	=	it_term_relationships.term_taxonomy_id";
		}

		$sql_condition = "
		it_posts.post_type 								=	'shop_order'
		AND it_woocommerce_order_items.order_item_type		=	'coupon'
		AND woocommerce_order_itemmeta.meta_key			=	'discount_amount'";

		if($coupon_discount_types && $coupon_discount_types != "-1"){
			$coupon_discount_types_condition_1 = " AND coupons.post_type 				=	'shop_coupon'";
			$coupon_discount_types_condition_1 .= " AND it_coupon_discount_type.meta_key		=	'discount_type'";
		}
		if ($it_from_date != NULL &&  $it_to_date !=NULL){
			$it_from_date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format')";
		}

		if(strlen($it_id_order_status)>0 && $it_id_order_status != "-1" && $it_id_order_status != "no" && $it_id_order_status != "all"){
			$it_id_order_status_condition = " AND  term_taxonomy.term_id IN ({$it_id_order_status})";
		}

		if(strlen($it_publish_order)>0 && $it_publish_order != "-1" && $it_publish_order != "no" && $it_publish_order != "all"){
			$in_post_status		= str_replace(",","','",$it_publish_order);
			$it_publish_order_condition= " AND  it_posts.post_status IN ('{$in_post_status}')";
		}

		if($it_coupon_code && $it_coupon_code != "-1"){
			$it_coupon_code_condition = " AND (it_woocommerce_order_items.order_item_name IN ('{$it_coupon_code}') OR it_woocommerce_order_items.order_item_name LIKE '%{$it_coupon_code}%')";
		}

		if($it_coupon_codes && $it_coupon_codes != "-1"){
			$it_coupon_codes_condition = " AND it_woocommerce_order_items.order_item_name IN ({$it_coupon_codes})";
		}

		if($coupon_discount_types && $coupon_discount_types != "-1"){
			$coupon_discount_types_condition_2 = " AND it_coupon_discount_type.meta_value IN ({$coupon_discount_types})";
		}

		if($it_country_code && $it_country_code != "-1"){
			$it_country_code_condition= " AND billing_country.meta_value IN ({$it_country_code})";
		}

		if($it_order_status  && $it_order_status != '-1' and $it_order_status != "'-1'")
			$it_order_status_condition = " AND it_posts.post_status IN (".$it_order_status.")";

		if($it_hide_os  && $it_hide_os != '-1' and $it_hide_os != "'-1'")
			$it_hide_os_condition = " AND it_posts.post_status NOT IN ('".$it_hide_os."')";


		$sql_group_by = " Group BY it_woocommerce_order_items.order_item_name";
		$sql_order_by = " ORDER BY total_amount DESC";

		$sql = "SELECT $sql_columns
				FROM $sql_joins $coupon_discount_types_join $it_id_order_status_join
				WHERE $sql_condition $coupon_discount_types_condition_1 $it_from_date_condition
				$it_id_order_status_condition $it_publish_order_condition $it_coupon_code_condition
				$it_coupon_codes_condition $coupon_discount_types_condition_2
				$it_country_code_condition $it_order_status_condition $it_hide_os_condition
				$sql_group_by $sql_order_by";

		//echo $sql;
	}
	elseif($file_used=="data_table"){

		////ADDE IN VER4.0
		/// TOTAL ROWS VARIABLES
		$result_count=$coupon_count=$total_amnt=0;

		foreach($this->results as $items){
		    $index_cols=0;
		//for($i=1; $i<=20 ; $i++){

			////ADDE IN VER4.0
			/// TOTAL ROWS
			$result_count++;

			$datatable_value.=("<tr>");

				//Coupon Code
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->coupon_code;
				$datatable_value.=("</td>");

				//Coupon Count
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->coupon_count;

                    ////ADDE IN VER4.0
                    /// TOTAL ROWS
                    $coupon_count+= $items->coupon_count;
				$datatable_value.=("</td>");

				//Coupon Amount
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->coupon_amount == 0 ? $this->price(0) : $this->price($items->coupon_amount);

                    ////ADDE IN VER4.0
                    /// TOTAL ROWS
                    $total_amnt+= $items->coupon_amount;
				$datatable_value.=("</td>");

			$datatable_value.=("</tr>");
		}

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$table_name_total= $table_name;
		$this->table_cols_total = $this->table_columns_total( $table_name_total );
		$datatable_value_total='';

		$datatable_value_total.=("<tr>");
		$datatable_value_total.="<td>$result_count</td>";
		$datatable_value_total.="<td>$coupon_count</td>";
		$datatable_value_total.="<td>".(($total_amnt) == 0 ? $this->price(0) : $this->price($total_amnt))."</td>";
		$datatable_value_total.=("</tr>");

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
                    <input type="hidden" name="it_id_order_status[]" id="it_id_order_status" value="-1">
                    <input type="hidden" name="it_orders_status[]" id="order_status" value="<?php echo $this->it_shop_status; ?>">
                </div>

                <div class="col-md-6">
                    <div class="awr-form-title">
                    	<?php
                        	$it_coupon_codes=$this->it_get_woo_coupons_codes();
							$option='';
							foreach($it_coupon_codes as $coupon){
								$selected='';

								$option.="<option $selected value='".$coupon -> id."' >".$coupon -> label." </option>";
							}
						?>
                        <?php _e('Coupon Codes',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-key"></i></span>
                    <select name="it_codes_of_coupon[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                        <option value="-1"><?php _e('Select All',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                        <?php
                            echo $option;
                        ?>
                    </select>
                </div>

                <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Discount Type',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-money"></i></span>
                    <select name="it_coupon_discount_types" >
                        <option value="-1"><?php _e('Select One',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                        <option value="percent"><?php _e('Percentage Discount',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                        <option value="fixed_cart"><?php _e('Fixed Cart Discount',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                        <option value="fixed_product"><?php _e('Fixed Product Discount',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                    </select>
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
                    <button type="submit" value="Search" class="button-primary"><i class="fa fa-search"></i> <span><?php echo esc_html__('Search',__IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
					<button type="button" value="Reset" class="button-secondary form_reset_btn"><i class="fa fa-reply"></i><span><?php echo esc_html__('Reset Form',__IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span></button>
            </div>

        </form>
    <?php
	}

?>
