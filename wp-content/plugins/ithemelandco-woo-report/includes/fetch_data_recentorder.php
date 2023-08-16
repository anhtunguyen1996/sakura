<?php

if ($file_used == "sql_table") {

    //GET POSTED PARAMETERS
    $request            = array();
    $start              = 0;
    $it_from_date       = $this->it_get_woo_requests('it_from_date', null, true);
    $it_to_date         = $this->it_get_woo_requests('it_to_date', null, true);
    $date_format        = $this->it_date_format($it_from_date);
    $it_id_order_status = $this->it_get_woo_requests('it_id_order_status', null, true);
    $it_order_status    = $this->it_get_woo_requests('it_orders_status', '-1', true);
    $it_order_status    = "'" . str_replace(",", "','", $it_order_status) . "'";

    ///////////HIDDEN FIELDS////////////
    $it_hide_os       = $this->it_get_woo_requests('it_hide_os', '-1', true);
    $it_publish_order = 'no';

    $data_format = $this->it_get_woo_requests_links('date_format', get_option('date_format'), true);
    //////////////////////

    //ORDER SATTUS
    $it_id_order_status_join   = '';
    $it_order_status_condition = '';

    //ORDER STATUS
    $it_id_order_status_condition = '';

    //DATE
    $it_from_date_condition = '';

    //PUBLISH ORDER
    $it_publish_order_condition = '';

    //HIDE ORDER STATUS
    $it_hide_os_condition = '';

    $sql_columns = "
			it_posts.ID AS order_id,
			DATE_FORMAT(it_posts.post_date,'%m/%d/%Y') AS order_date
			,it_postmeta3.meta_value As 'total_amount'
			,it_posts.post_status As order_status
		";

    $sql_joins = " {$wpdb->prefix}posts as it_posts
					LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta3 ON it_postmeta3.post_id=it_posts.ID";

    if (strlen($it_id_order_status) > 0 && $it_id_order_status != "-1" && $it_id_order_status != "no" && $it_id_order_status != "all") {
        $it_id_order_status_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships 	ON it_term_relationships.object_id		=	it_posts.ID
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy 		ON term_taxonomy.term_taxonomy_id	=	it_term_relationships.term_taxonomy_id";
    }

    $sql_condition = " it_posts.post_type='shop_order'
		AND it_postmeta3.meta_key='_order_total'";

    if (strlen($it_id_order_status) > 0 && $it_id_order_status != "-1" && $it_id_order_status != "no" && $it_id_order_status != "all") {
        $it_id_order_status_condition = " AND  term_taxonomy.term_id IN ({$it_id_order_status})";
    }

    if ($it_from_date != null && $it_to_date != null) {
        $it_from_date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format')";
    }


    if (strlen($it_publish_order) > 0 && $it_publish_order != "-1" && $it_publish_order != "no" && $it_publish_order != "all") {
        $in_post_status             = str_replace(",", "','", $it_publish_order);
        $it_publish_order_condition = " AND  it_posts.post_status IN ('{$in_post_status}')";
    }


    if ($it_order_status && $it_order_status != '-1' and $it_order_status != "'-1'") {
        $it_order_status_condition = " AND it_posts.post_status IN (" . $it_order_status . ")";
    }

    if ($it_hide_os && $it_hide_os != '-1' and $it_hide_os != "'-1'") {
        $it_hide_os_condition = " AND it_posts.post_status NOT IN ('" . $it_hide_os . "')";
    }

    $sql_group_by = " GROUP BY it_posts.ID";

    $sql_order_by = " Order By it_posts.post_date DESC ";

    $sql = "SELECT $sql_columns
				FROM $sql_joins $it_id_order_status_join
				WHERE $sql_condition
				$it_id_order_status_condition $it_from_date_condition $it_publish_order_condition
				$it_order_status_condition $it_hide_os_condition
				$sql_group_by $sql_order_by";

    //echo $sql;

} elseif ($file_used == "data_table") {


    ////ADDE IN VER4.0
    /// TOTAL ROWS VARIABLES
    $gross_amnt = $discount_amnt = $shipping_amnt = $shipping_tax_amnt =
    $order_tax_amnt = $total_tax_amnt = $part_refund_amnt = $order_count =
    $product_count = $product_qty = $total_rate = $product_amnt = $product_discount = $net_amnt = 0;

    foreach ($this->results as $items) {
        $index_cols = 0;
        //for($i=1; $i<=20 ; $i++){

        $order_id         = $items->order_id;
        $fetch_other_data = '';

        if ( ! isset($this->order_meta[$order_id])) {
            $fetch_other_data = $this->it_get_full_post_meta($order_id);
        }

        //print_r($fetch_other_data);


        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $order_count++;

        $datatable_value .= ("<tr>");

        $it_order_total = isset($fetch_other_data['order_total']) ? $fetch_other_data['order_total'] : 0;

        $order_shipping = isset($fetch_other_data['order_shipping']) ? $fetch_other_data['order_shipping'] : 0;

        $it_cart_discount = isset($fetch_other_data['cart_discount']) ? $fetch_other_data['cart_discount'] : 0;

        $it_order_discount = isset($fetch_other_data['order_discount']) ? $fetch_other_data['order_discount'] : 0;

        $total_discount = isset($fetch_other_data['total_discount']) ? $fetch_other_data['total_discount'] : ($it_cart_discount + $it_order_discount);


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
        $datatable_value .= $order_id;
        $datatable_value .= ("</td>");

        //Name
        $display_class = '';
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $fetch_other_data['billing_first_name'] . ' ' . $fetch_other_data['billing_last_name'];
        $datatable_value .= ("</td>");

        //Email
        $display_class = '';
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $fetch_other_data['billing_email'];
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
        $it_table_value = $items->order_status;
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

        //Items
        $display_class   = '';
        $order_items_cnt = $this->it_get_oi_count($items->order_id, 'line_item');
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= isset($order_items_cnt[$items->order_id]) ? $order_items_cnt[$items->order_id] : "";
        $datatable_value .= ("</td>");

        //Payment Method
        $display_class = '';
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= isset($fetch_other_data['payment_method_title']) ? $fetch_other_data['payment_method_title'] : "";
        $datatable_value .= ("</td>");

        //Shipping Method
        $shipping_method = $this->it_oin_list($items->order_id, 'shipping');
        $display_class   = '';
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= isset($shipping_method[$items->order_id]) ? $shipping_method[$items->order_id] : "";
        $datatable_value .= ("</td>");

        //Order Currency
        $display_class = '';
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= isset($fetch_other_data['order_currency']) ? $fetch_other_data['order_currency'] : "";
        $datatable_value .= ("</td>");

        //Gross Amt.
        $display_class  = '';
        $it_table_value = ($it_order_total + $total_discount) - ($fetch_other_data['order_shipping'] + $fetch_other_data['order_shipping_tax'] + $fetch_other_data['order_tax']);
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $this->price($it_table_value);

        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $gross_amnt      += $it_table_value;
        $datatable_value .= ("</td>");

        //Order Discount Amt.
        $display_class = '';
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $this->price($it_order_discount);
        $datatable_value .= ("</td>");

        //Cart Discount Amt.
        $display_class = '';
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $this->price(isset($fetch_other_data['cart_discount']) ? $fetch_other_data['cart_discount'] : 0);
        $datatable_value .= ("</td>");

        //Total Discount Amt.
        $display_class = '';
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $this->price($total_discount);

        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $discount_amnt   += $total_discount;
        $datatable_value .= ("</td>");

        //Shipping Amt.
        $display_class = '';
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $this->price($fetch_other_data['order_shipping']);

        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $shipping_amnt   += $fetch_other_data['order_shipping'];
        $datatable_value .= ("</td>");

        //Shipping Tax Amt.
        $display_class  = '';
        $it_table_value = (isset($fetch_other_data['order_shipping_tax']) ? $fetch_other_data['order_shipping_tax'] : 0);
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $this->price($it_table_value);

        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $shipping_tax_amnt += $it_table_value;
        $datatable_value   .= ("</td>");

        //Order Tax Amt.
        $display_class  = '';
        $it_table_value = (isset($fetch_other_data['order_tax']) ? $fetch_other_data['order_tax'] : 0);
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $this->price($it_table_value);

        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $order_tax_amnt  += $it_table_value;
        $datatable_value .= ("</td>");

        //Total Tax Amt.
        $display_class  = '';
        $it_table_value = isset($fetch_other_data['total_tax']) ? $fetch_other_data['total_tax'] : ($fetch_other_data['order_tax'] + $fetch_other_data['order_shipping_tax']);
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $this->price($it_table_value);

        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $total_tax_amnt  += $it_table_value;
        $datatable_value .= ("</td>");

        //Part Refund Amt.
        $display_class     = '';
        $order_refund_amnt = $this->it_get_por_amount($items->order_id);
        $it_table_value    = (isset($order_refund_amnt[$items->order_id]) ? $this->price($order_refund_amnt[$items->order_id]) : $this->price(0));
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= ($it_table_value);

        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $part_refund_amnt += isset($order_refund_amnt[$items->order_id]) ? $order_refund_amnt[$items->order_id] : 0;
        $datatable_value  .= ("</td>");
        $part_refund      = (isset($order_refund_amnt[$items->order_id]) ? $order_refund_amnt[$items->order_id] : 0);

        //Net Amt.
        $it_table_value = isset($items->total_amount) ? ($items->total_amount) - $part_refund : 0;
        $display_class  = '';
        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
            $display_class = 'display:none';
        }
        $datatable_value .= ("<td style='" . $display_class . "'>");
        $datatable_value .= $this->price($it_table_value);

        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $net_amnt        += $it_table_value;
        $datatable_value .= ("</td>");

        $datatable_value .= ("</tr>");
    }

    ////ADDE IN VER4.0
    /// TOTAL ROWS
    $table_name_total       = $table_name;
    $this->table_cols_total = $this->table_columns_total($table_name_total);
    $datatable_value_total  = '';

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
    $datatable_value_total .= ("</tr>");

} elseif ($file_used == "search_form") {
    ?>
    <form class='alldetails search_form_report' action='' method='post'>
        <input type='hidden' name='action' value='submit-form'/>
        <div class="row">

            <div class="col-md-6">
                <div class="awr-form-title">
                    <?php _e('From Date', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
                <input name="it_from_date" id="pwr_from_date" type="text" readonly='true' class="datepick"/>
            </div>

            <div class="col-md-6">
                <div class="awr-form-title">
                    <?php _e('To Date', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
                <input name="it_to_date" id="pwr_to_date" type="text" readonly='true' class="datepick"/>

                <input type="hidden" name="it_id_order_status[]" id="it_id_order_status" value="-1">
                <input type="hidden" name="it_orders_status[]" id="order_status"
                       value="<?php echo $this->it_shop_status; ?>">
            </div>

        </div>

        <div class="col-md-12">
            <?php
            $it_hide_os       = $this->otder_status_hide;
            $it_publish_order = 'no';

            $data_format = $this->it_get_woo_requests_links('date_format', get_option('date_format'), true);
            ?>
            <input type="hidden" name="list_parent_category" value="">
            <input type="hidden" name="it_category_id" value="-1">
            <input type="hidden" name="group_by_parent_cat" value="0">

            <input type="hidden" name="it_hide_os" id="it_hide_os" value="<?php echo $it_hide_os; ?>"/>

            <input type="hidden" name="date_format" id="date_format" value="<?php echo $data_format; ?>"/>

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
