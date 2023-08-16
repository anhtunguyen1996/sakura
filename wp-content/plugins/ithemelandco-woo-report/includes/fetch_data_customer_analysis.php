<?php

if($file_used=="sql_table")
{
	//GET POSTED PARAMETERS
	$request 			= array();
	$start				= 0;
	$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
	$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
	$date_format = $this->it_date_format($it_from_date);

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
		SUM(it_order_total.meta_value)	AS order_total,
		COUNT(it_posts.ID) AS order_count ,
		DATE_FORMAT(it_posts.post_date,'%Y%m') AS month_key ,
		DATE_FORMAT(it_posts.post_date,'%M, %Y') AS month_name ,
		it_billing_email.meta_value AS billing_email";


	$sql_joins = " {$wpdb->prefix}posts AS it_posts
		LEFT JOIN {$wpdb->postmeta} AS it_order_total ON it_order_total.post_id = it_posts.ID
		LEFT JOIN {$wpdb->postmeta} AS it_billing_email ON it_billing_email.post_id = it_posts.ID";

	$sql_condition = " it_posts.post_type		= 'shop_order' AND it_order_total.meta_key 	= '_order_total' AND it_billing_email.meta_key 	= '_billing_email'";

	if ($it_from_date != NULL &&  $it_to_date !=NULL){
		$it_from_date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format')";
	}

	if($it_order_status  && $it_order_status != '-1' and $it_order_status != "'-1'")
		$it_order_status_condition= " AND it_posts.post_status IN (".$it_order_status.")";

	if($it_hide_os  && $it_hide_os != '-1' and $it_hide_os != "'-1'")
		$it_hide_os_condition= " AND it_posts.post_status NOT IN ('".$it_hide_os."')";

	$sql_group_by= " GROUP BY month_key, billing_email ";

	$sql_order_by= " ORDER BY month_key DESC";

	$sql = "SELECT $sql_columns FROM $sql_joins WHERE $sql_condition $it_order_status_condition $it_hide_os_condition $it_from_date_condition
				$sql_group_by $sql_order_by	";

	//echo $sql;

}elseif($file_used=="data_table"){

	$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
	$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
	$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
	$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

	$params=array(
		"it_from_date"=>$it_from_date,
		"it_to_date"=>$it_to_date,
		"order_status"=>$it_order_status,
		"it_hide_os"=>'trash'
	);

	$it_matched_array 			= array();
	$it_final_list 			= array();
	$it_total_customers_cnt		= array();
	$it_grp_customers		= $this->it_fetch_old_emails_of_customer($params);
	$it_repeat_customers		= array();
	$it_repeat_total_customers		= array();
	$it_repeat_count_customers		= array();
	$it_new_total_amnt			= array();
	$it_new_count_amnt			= array();
	$it_array_months			= array();

	//print_r($it_grp_customers);

	foreach($this->results as $items) {

		$order_total   = $items->order_total;
		$order_count   = $items->order_count;
		$month_key     = $items->month_key;
		$billing_email = $items->billing_email;
		$month_name    = $items->month_name;
		if ( isset( $it_final_list[ $month_key ] ) ) {
			$it_final_list[ $month_key ]['order_total'] = $it_final_list[ $month_key ]['order_total'] + $order_total;
			$it_final_list[ $month_key ]['order_count'] = $it_final_list[ $month_key ]['order_count'] + $order_count;
		} else {
			$it_final_list[ $month_key ]['order_total'] = $order_total;
			$it_final_list[ $month_key ]['order_count'] = $order_count;
			$it_final_list[ $month_key ]['month_key']   = $month_key;
			$it_final_list[ $month_key ]['month_name']  = $month_name;
		}

		if ( isset( $it_grp_customers[ $billing_email ] ) ) {
			$it_repeat_customers[ $month_key ][ $billing_email ] = $billing_email;
			$it_repeat_total_customers[ $month_key ]                   = isset( $it_repeat_total_customers[ $month_key ] ) ? ( $it_repeat_total_customers[ $month_key ] + $order_total ) : $order_total;
			$it_repeat_count_customers[ $month_key ]                   = isset( $it_repeat_count_customers[ $month_key ] ) ? ( $it_repeat_count_customers[ $month_key ] + $order_count ) : $order_count;
		} else {
//			if ( $order_count > 1 ) {
//				$it_repeat_customers[ $month_key ][ $billing_email ] = $billing_email;
//				$it_repeat_total_customers[ $month_key ]                   = isset( $it_repeat_total_customers[ $month_key ] ) ? ( $it_repeat_total_customers[ $month_key ] + $order_total ) : $order_total;
//				$it_repeat_count_customers[ $month_key ]                   = isset( $it_repeat_count_customers[ $month_key ] ) ? ( $it_repeat_count_customers[ $month_key ] + $order_count ) : $order_count;
//			}

			if ( ! isset( $it_total_customers_cnt[ $month_key ][ $billing_email ] ) ) {
				$it_total_customers_cnt[ $month_key ][ $billing_email ] = $billing_email;
				$it_new_total_amnt[ $month_key ]                     = isset( $it_new_total_amnt[ $month_key ] ) ? ( $it_new_total_amnt[ $month_key ] + $order_total ) : $order_total;
				$it_new_count_amnt[ $month_key ]                     = isset( $it_new_count_amnt[ $month_key ] ) ? ( $it_new_count_amnt[ $month_key ] + $order_count ) : $order_count;
			}
		}

		$it_final_list[ $month_key ]['repeat_customer'] = isset( $it_repeat_count_customers[ $month_key ] ) ? ( $it_repeat_count_customers[ $month_key ] ) : 0;
		$it_final_list[ $month_key ]['new_customer']    = isset( $it_new_count_amnt[ $month_key ] ) ? ( $it_new_count_amnt[ $month_key ] ) : 0;

		$it_final_list[ $month_key ]['new_total']    = isset( $it_new_total_amnt[ $month_key ] ) ? $it_new_total_amnt[ $month_key ] : 0;
		$it_final_list[ $month_key ]['repeat_total'] = isset( $it_repeat_total_customers[ $month_key ] ) ? $it_repeat_total_customers[ $month_key ] : 0;

		$it_grp_customers[ $billing_email ] = $billing_email;
	}

	$order_items = array();
	$ind			= count($it_final_list);
	$i			= 0;

	foreach($it_final_list as $month_key => $list){
		$it_array_months[]	= $list['month_key'];
	}

	for($ind;$ind>0;$ind--){
		$key = $it_array_months[$ind-1];
		$order_items[$i] = new stdClass();
		$order_items[$i]->month_key 					= $it_final_list[$key]['month_key'];
		$order_items[$i]->month_name 					= $it_final_list[$key]['month_name'];
		$order_items[$i]->total_sales_amount 			= $it_final_list[$key]['order_total'];
		$order_items[$i]->total_order_count 			= $it_final_list[$key]['order_count'];
		$order_items[$i]->repeat_customer_count 		= $it_final_list[$key]['repeat_customer'];
		$order_items[$i]->new_customer_count 			= $it_final_list[$key]['new_customer'];
		$order_items[$i]->new_customer_sales_amount 	= $it_final_list[$key]['new_total'];
		$order_items[$i]->repeat_customer_sales_amount 	= $it_final_list[$key]['repeat_total'];
		$i++;
	}

	////ADDE IN VER4.0
	/// TOTAL ROWS VARIABLES
	$month_count=$t_order_count=$new_customer_count=$rep_customer_count=$new_customer_amnt=$rep_customer_amnt=$total_amnt=0;

	foreach ($order_items as $items){

		$index_cols=0;

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$month_count++;

		$datatable_value.=("<tr>");

		//Months
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->month_name;
		$datatable_value.=("</td>");

		//Total Sale Amnt
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->total_sales_amount == 0 ? $this->price(0) : $this->price($items->total_sales_amount);

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$total_amnt+= $items->total_sales_amount;
		$datatable_value.=("</td>");

		//Total Order Count
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->total_order_count;

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$t_order_count+= $items->total_order_count;
		$datatable_value.=("</td>");

		//New Customer Count
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->new_customer_count;

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$new_customer_count+= $items->new_customer_count;

		$datatable_value.=("</td>");

		//Repeat Customer Count
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->repeat_customer_count;

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$rep_customer_count+= $items->repeat_customer_count;

		$datatable_value.=("</td>");

		//New Customer Total
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->new_customer_sales_amount== 0 ? $this->price(0) : $this->price($items->new_customer_sales_amount);

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$new_customer_amnt+= $items->new_customer_sales_amount;
		$datatable_value.=("</td>");

		//Repeat Customer Total
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->repeat_customer_sales_amount== 0 ? $this->price(0) : $this->price($items->repeat_customer_sales_amount);

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$rep_customer_amnt+= $items->repeat_customer_sales_amount;

		$datatable_value.=("</td>");


		$datatable_value.=("</tr>");
	}

	////ADDE IN VER4.0
	/// TOTAL ROWS
	$table_name_total= $table_name;
	$this->table_cols_total = $this->table_columns_total( $table_name_total );
	$datatable_value_total='';

	$datatable_value_total.=("<tr>");
	$datatable_value_total.="<td>$month_count</td>";
	$datatable_value_total.="<td>".(($total_amnt) == 0 ? $this->price(0) : $this->price($total_amnt))."</td>";
	$datatable_value_total.="<td>$t_order_count</td>";
	$datatable_value_total.="<td>$new_customer_count</td>";
	$datatable_value_total.="<td>$rep_customer_count</td>";
	$datatable_value_total.="<td>".(($new_customer_amnt) == 0 ? $this->price(0) : $this->price($new_customer_amnt))."</td>";
	$datatable_value_total.="<td>".(($rep_customer_amnt) == 0 ? $this->price(0) : $this->price($rep_customer_amnt))."</td>";
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
