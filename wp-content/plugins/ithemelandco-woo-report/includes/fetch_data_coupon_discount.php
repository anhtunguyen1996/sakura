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

	//COUPON DISCOUNT
	$coupon_discount_types_condition='';

	$sql_columns = "
		it_woocommerce_order_items.order_item_name	AS	'coupon_code_label',
		it_woocommerce_order_items.order_item_name	AS	'coupon_code',
		it_coupon_discount_type.meta_value 	AS discount_type,
		it_woocommerce_order_items.order_item_name	AS 'product_name' ,
		SUM(it_woocommerce_order_itemmeta_product_qty.meta_value)	AS 'quantity' ,
		CONCAT(it_woocommerce_order_items_product.order_item_name, '-', it_coupon_discount_type.meta_value, '-' ,it_woocommerce_order_items.order_item_name) 	AS order_by,
		SUM(it_woocommerce_order_itemmeta_line_subtotal.meta_value)	AS line_subtotal,
		SUM(it_woocommerce_order_itemmeta_line_total.meta_value)	AS line_total,
		(SUM(it_woocommerce_order_itemmeta_line_subtotal.meta_value) - SUM(it_woocommerce_order_itemmeta_line_total.meta_value)) AS total_amount";



	$sql_joins = "
		{$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items
		LEFT JOIN	{$wpdb->prefix}posts	as it_posts ON it_posts.ID = it_woocommerce_order_items.order_id
		LEFT JOIN	{$wpdb->prefix}posts	as it_coupons ON it_coupons.post_title = it_woocommerce_order_items.order_item_name
		LEFT JOIN	{$wpdb->prefix}postmeta	as it_coupon_discount_type ON it_coupon_discount_type.post_id = it_coupons.ID
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items_product ON it_woocommerce_order_items_product.order_id=it_woocommerce_order_items.order_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_product_qty ON it_woocommerce_order_itemmeta_product_qty.order_item_id=it_woocommerce_order_items_product.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_line_subtotal ON it_woocommerce_order_itemmeta_line_subtotal.order_item_id=it_woocommerce_order_items_product.order_item_id AND it_woocommerce_order_itemmeta_line_subtotal.meta_key = '_line_subtotal'
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_line_total ON it_woocommerce_order_itemmeta_line_total.order_item_id=it_woocommerce_order_items_product.order_item_id AND it_woocommerce_order_itemmeta_line_total.meta_key = '_line_total'";

	$sql_condition = "it_posts.post_type 								=	'shop_order'
		AND it_woocommerce_order_items.order_item_type		=	'coupon'
		AND it_coupons.post_type 								=	'shop_coupon'
		AND it_coupon_discount_type.meta_key						=	'discount_type'
		AND it_woocommerce_order_items_product.order_item_type	=	'line_item'
		AND it_woocommerce_order_itemmeta_product_qty.meta_key	=	'_qty'";

	if ($it_from_date != NULL &&  $it_to_date !=NULL){
		$it_from_date_condition= " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format')";
	}

	if($coupon_discount_types && $coupon_discount_types != "-1"){
		$coupon_discount_types_condition = " AND it_coupon_discount_type.meta_value IN ({$coupon_discount_types})";
	}

	if($it_order_status  && $it_order_status != '-1' and $it_order_status != "'-1'")
		$it_order_status_condition = " AND it_posts.post_status IN (".$it_order_status.")";

	if($it_hide_os  && $it_hide_os != '-1' and $it_hide_os != "'-1'")
		$it_hide_os_condition = " AND it_posts.post_status NOT IN ('".$it_hide_os."')";

	$sql_group_by = " Group BY order_by";
	$sql_order_by = " ORDER BY -1 DESC";

	$sql = "SELECT $sql_columns
				FROM $sql_joins
				WHERE $sql_condition $it_from_date_condition $coupon_discount_types_condition $it_order_status_condition $it_hide_os_condition
				$sql_group_by $sql_order_by";

	//echo $sql;
}
elseif($file_used=="data_table"){

	////ADDE IN VER4.0
	/// TOTAL ROWS VARIABLES
	$result_count=$product_count=$discount_amnt=0;

	foreach($this->results as $items){
	    $index_cols=0;
		//for($i=1; $i<=20 ; $i++){

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$result_count++;

		$datatable_value.=("<tr>");

		//Product Name
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->product_name;
		$datatable_value.=("</td>");

		//Coupon Code
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->coupon_code;
		$datatable_value.=("</td>");

		//Coupon Type
		$display_class='';
		$discount_type=array(
			'fixed_cart'      => esc_html__( 'Fixed cart discount', 			__IT_REPORT_WCREPORT_TEXTDOMAIN__ ),
			'percent'         => esc_html__( 'Percentage discount', 		__IT_REPORT_WCREPORT_TEXTDOMAIN__ ),
			'fixed_product'   => esc_html__( 'Fixed product discount', 		__IT_REPORT_WCREPORT_TEXTDOMAIN__ ),
			'percent_product' => esc_html__( 'Product % Discount', 		__IT_REPORT_WCREPORT_TEXTDOMAIN__ )
		);
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= ($items->discount_type!='' ? $discount_type[$items->discount_type] : "");
		$datatable_value.=("</td>");

		//Qty
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->quantity;

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$product_count+= $items->quantity;

		$datatable_value.=("</td>");

		//Discount Amount
		$display_class='';
		if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
		$datatable_value.=("<td style='".$display_class."'>");
		$datatable_value.= $items->total_amount == 0 ? $this->price(0) : $this->price($items->total_amount);

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$discount_amnt+= $items->total_amount;

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
	$datatable_value_total.="<td>$product_count</td>";
	$datatable_value_total.="<td>".(($discount_amnt) == 0 ? $this->price(0) : $this->price($discount_amnt))."</td>";
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
