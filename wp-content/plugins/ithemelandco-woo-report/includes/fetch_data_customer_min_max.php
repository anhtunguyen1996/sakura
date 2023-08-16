<?php

	if($file_used=="sql_table")
	{
		//GET POSTED PARAMETERS
		$request 			= array();
		$start				= 0;
		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
		$date_format = $this->it_date_format($it_from_date);

		$it_min_price			= $this->it_get_woo_requests('it_min_price',NULL,true);
		$it_max_price			= $this->it_get_woo_requests('it_max_price',NULL,true);
		$it_id_order_status 	= $this->it_get_woo_requests('it_id_order_status',NULL,true);
		$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
		$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

		///////////HIDDEN FIELDS////////////
		$it_hide_os		= $this->it_get_woo_requests('it_hide_os','-1',true);
		$it_publish_order='no';
		$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);
		//////////////////////


		//ORDER SATTUS
		$it_id_order_status_join='';
		$it_order_status_condition='';

		//ORDER STATUS
		$it_id_order_status_condition='';

		//DATE
		$it_from_date_condition='';

		//PUBLISH ORDER
		$it_publish_order_condition='';

		//HIDE ORDER STATUS
		$it_hide_os_condition ='';

		$sql_columns= "
		SUM(it_postmeta1.meta_value) 		AS 'total_amount' ,
		it_postmeta2.meta_value 			AS 'billing_email',
		it_postmeta3.meta_value 			AS 'billing_first_name',
		COUNT(it_postmeta2.meta_value) 		AS 'order_count',
		it_postmeta4.meta_value 			AS  customer_id,
		it_postmeta5.meta_value 			AS  billing_last_name,
		MAX(it_posts.post_date)				AS  order_date,
		CONCAT(it_postmeta3.meta_value, ' ',it_postmeta5.meta_value) AS billing_name,
		MAX((it_woocommerce_order_itemmeta_ttl.meta_value/it_woocommerce_order_itemmeta_qty.meta_value)) AS max_product_price,
		MIN((it_woocommerce_order_itemmeta_ttl.meta_value/it_woocommerce_order_itemmeta_qty.meta_value)) AS min_product_price ";


		$sql_joins = "
		{$wpdb->prefix}posts as it_posts
		LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta1 ON it_postmeta1.post_id=it_posts.ID
		LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta2 ON it_postmeta2.post_id=it_posts.ID
		LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta3 ON it_postmeta3.post_id=it_posts.ID
        LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta4 ON it_postmeta4.post_id=it_posts.ID
        LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta5 ON it_postmeta5.post_id=it_posts.ID
        LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items ON it_woocommerce_order_items.order_id = it_posts.ID
        LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_ttl ON it_woocommerce_order_itemmeta_ttl.order_item_id=it_woocommerce_order_items.order_item_id
        LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_qty ON it_woocommerce_order_itemmeta_qty.order_item_id=it_woocommerce_order_items.order_item_id ";


		$sql_condition = "
		it_posts.post_type							= 'shop_order'
		AND it_postmeta1.meta_key						= '_order_total'
		AND it_postmeta2.meta_key						= '_billing_email'
		AND it_postmeta3.meta_key						= '_billing_first_name'
		AND it_postmeta4.meta_key						= '_customer_user'
		AND it_postmeta5.meta_key						= '_billing_last_name'
		AND it_woocommerce_order_items.order_item_type	= 'line_item'
		AND it_woocommerce_order_itemmeta_ttl.meta_key	= '_line_total'
		AND it_woocommerce_order_itemmeta_qty.meta_key	= '_qty' ";

		if(strlen($it_min_price) > 0 and $it_min_price >= 0){
			if(is_numeric($it_min_price)) $sql_condition .= " AND (it_woocommerce_order_itemmeta_ttl.meta_value/it_woocommerce_order_itemmeta_qty.meta_value) > $it_min_price ";
		}

		if(strlen($it_max_price) > 0 and $it_max_price >= 0){
			if(is_numeric($it_max_price)) $sql_condition .= " AND (it_woocommerce_order_itemmeta_ttl.meta_value/it_woocommerce_order_itemmeta_qty.meta_value) < $it_max_price ";
		}


		if ($it_from_date != NULL &&  $it_to_date !=NULL){
			$sql_condition.= " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format')";
		}

		if($it_order_status  && $it_order_status != '-1' and $it_order_status != "'-1'")
			$it_order_status_condition= " AND it_posts.post_status IN (".$it_order_status.")";

		if($it_hide_os  && $it_hide_os != '-1' and $it_hide_os != "'-1'")
			$it_hide_os_condition= " AND it_posts.post_status NOT IN ('".$it_hide_os."')";


		$sql_group_by= " GROUP BY  it_postmeta2.meta_value ";

		$sql_order_by= " Order By billing_last_name ASC, billing_first_name ASC ";

		$sql = "SELECT $sql_columns FROM $sql_joins WHERE $sql_condition $it_order_status_condition
                $it_hide_os_condition
				$sql_group_by $sql_order_by	";

		//echo $sql;

	}elseif($file_used=="data_table"){

		////ADDE IN VER4.0
		/// TOTAL ROWS VARIABLES
		$customer_count=$order_count=$total_amnt=0;

		foreach($this->results as $items) {
			$index_cols=0;

			////ADDE IN VER4.0
			/// TOTAL ROWS
			$customer_count++;

			$datatable_value.=("<tr>");

				//First Name
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->billing_first_name;
				$datatable_value.=("</td>");

                //Last Name
                $display_class='';
               	if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $items->billing_last_name;
                $datatable_value.=("</td>");

                //Email
                $display_class='';
               	if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $items->billing_email;
                $datatable_value.=("</td>");

				//Min Price
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->min_product_price == 0 ? $this->price(0) : $this->price($items->min_product_price);
				$datatable_value.=("</td>");

                //Max Price
                $display_class='';
               	if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $items->max_product_price== 0 ? $this->price(0) : $this->price($items->max_product_price);
                $datatable_value.=("</td>");

                //Order Count
                $display_class='';
               	if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                    $datatable_value.= $items->order_count;

                    ////ADDE IN VER4.0
                    /// TOTAL ROWS
			        $order_count+= $items->order_count;

                $datatable_value.=("</td>");

                ////ADDE IN VER4.0
                /// TOTAL ROWS
			    $total_amnt+= $items->total_amount;

			$datatable_value.=("</tr>");
		}

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$table_name_total= $table_name;
		$this->table_cols_total = $this->table_columns_total( $table_name_total );
		$datatable_value_total='';

		$datatable_value_total.=("<tr>");
		$datatable_value_total.="<td>$customer_count</td>";
		$datatable_value_total.="<td>$order_count</td>";
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
			            <?php _e('Min Price',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa fa-battery-4"></i></span>
                    <input name="it_min_price" id="it_min_price" type="text"/>
                </div>

                <div class="col-md-6">
                    <div class="awr-form-title">
			            <?php _e('Max Price',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa fa-battery-4"></i></span>
                    <input name="it_max_price" id="it_max_price" type="text"/>
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
