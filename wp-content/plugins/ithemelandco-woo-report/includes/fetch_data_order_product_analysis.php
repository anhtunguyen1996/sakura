<?php

	if($file_used=="sql_table")
	{
		//GET POSTED PARAMETERS
		$request 			= array();
		$start				= 0;
		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
		$date_format = $this->it_date_format($it_from_date);

		$it_sort_by			= $this->it_get_woo_requests('it_sort_by',NULL,true);
		$it_order_by			= $this->it_get_woo_requests('it_order_by',NULL,true);
		$it_product_id			= $this->it_get_woo_requests('it_product_id',"-1",true);

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

		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
		$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
		$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

		$sql='';
		if ($it_product_id!="-1")
			$products = $this->it_get_simple_variation_product("SIMPLE",$it_product_id,"ARRAY_A");
		else
			$products = $this->it_get_simple_variation_product("SIMPLE",NULL,"ARRAY_A");


		//die(print_r($products));




        $sql1='';
		foreach($products  as $key=>$value):
			$product_id =$value["id"];

            if($sql1==''):
                $sql_columns= "
                it_qty.meta_value as qty, count(*) as order_count,
                (count(*) * it_line_total.meta_value) as line_total,
                it_order_items.order_item_name as order_item_name,
                it_product_id.meta_value  as product_id ";

                $sql_joins = "
                {$wpdb->prefix}posts as it_posts
                LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as it_order_items ON it_order_items.order_id=it_posts.ID
                LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_product_id ON it_product_id.order_item_id=it_order_items.order_item_id
                LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_qty ON it_qty.order_item_id=it_order_items.order_item_id
                LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_line_total ON it_line_total.order_item_id=it_order_items.order_item_id
                LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_variation_id ON it_variation_id.order_item_id=it_order_items.order_item_id ";

                $sql_condition = "
                it_posts.post_type		= 'shop_order'
                AND it_posts.post_type='shop_order'
                AND it_order_items.order_item_type='line_item'
                AND it_product_id.meta_key='_product_id'
                AND it_qty.meta_key='_qty'
                AND it_line_total.meta_key='_line_total'
                AND it_variation_id.meta_value='0'
                AND it_variation_id.meta_key='_variation_id'
                AND it_product_id.meta_value={$product_id}";

                if ($it_from_date != NULL &&  $it_to_date !=NULL){
	                $it_from_date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format') ";
                }
                $sql_group_by= " GROUP By it_qty.meta_value ";

                $sql1 = "SELECT $sql_columns FROM $sql_joins  WHERE $sql_condition $it_from_date_condition
                        $sql_group_by 	";
            endif;

            $sql_columns= "
            it_qty.meta_value as qty, count(*) as order_count,
            (count(*) * it_line_total.meta_value) as line_total,
            it_order_items.order_item_name as order_item_name,
            it_product_id.meta_value  as product_id";

            $sql_joins = "
            {$wpdb->prefix}posts as it_posts
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as it_order_items ON it_order_items.order_id=it_posts.ID
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_product_id ON it_product_id.order_item_id=it_order_items.order_item_id
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_qty ON it_qty.order_item_id=it_order_items.order_item_id
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_line_total ON it_line_total.order_item_id=it_order_items.order_item_id
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_variation_id ON it_variation_id.order_item_id=it_order_items.order_item_id ";

            $sql_condition = "
            it_posts.post_type='shop_order'
            AND it_order_items.order_item_type='line_item'
            AND it_product_id.meta_key='_product_id'
            AND it_qty.meta_key='_qty'
            AND it_line_total.meta_key='_line_total'
            AND it_variation_id.meta_value='0'
            AND it_variation_id.meta_key='_variation_id'
            AND it_product_id.meta_value={$product_id} ";

            if ($it_from_date != NULL &&  $it_to_date !=NULL){
	            $it_from_date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format') ";
            }

            $sql_group_by= " GROUP By it_qty.meta_value ";

            $sql2 = "SELECT $sql_columns FROM $sql_joins  WHERE $sql_condition $it_from_date_condition
                    $sql_group_by ";

            $sql.=" UNION ".$sql2;
		endforeach;

		$sql_order_by='';
		if ($it_sort_by == "quantity")
			$sql_order_by= " order By CAST(qty AS SIGNED) " . $it_order_by;
		if ($it_sort_by == "product_name")
			$sql_order_by= " order By order_item_name " . $it_order_by;

		$sql=$sql1.$sql.$sql_order_by;

		//echo $sql;

		$sql_columns= "
            ID as order_id, count(ID) as order_count,sum(it_qty.meta_value) as qty,  sum(it_line_total.meta_value) as line_total,
            it_order_items.order_item_name as order_item_name,
            it_product_id.meta_value  as product_id";

		$sql_joins = "
            {$wpdb->prefix}posts as it_posts
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_items as it_order_items ON it_order_items.order_id=it_posts.ID
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_product_id ON it_product_id.order_item_id=it_order_items.order_item_id
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_qty ON it_qty.order_item_id=it_order_items.order_item_id
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_line_total ON it_line_total.order_item_id=it_order_items.order_item_id
            LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_variation_id ON it_variation_id.order_item_id=it_order_items.order_item_id ";

		$sql_condition = "
            it_posts.post_type='shop_order'
            AND it_order_items.order_item_type='line_item'
            AND it_product_id.meta_key='_product_id'
            AND it_qty.meta_key='_qty'
            AND it_line_total.meta_key='_line_total'
            AND it_variation_id.meta_value='0'
            AND it_variation_id.meta_key='_variation_id'
            ";

		if ($it_from_date != NULL &&  $it_to_date !=NULL){
			$it_from_date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format') ";
		}

		$sql_group_by= "  group by  product_id ";

		$sql1 = "SELECT $sql_columns FROM $sql_joins  WHERE $sql_condition $it_from_date_condition 	$sql_group_by";

		$sql_order_by='';
		if ($it_sort_by == "quantity")
			$sql_order_by= " order By (qty) " . $it_order_by;
		if ($it_sort_by == "product_name")
			$sql_order_by= " order By order_item_name " . $it_order_by;

		$sql=$sql1.$sql_order_by;

		//echo $sql;


	}elseif($file_used=="data_table"){

		foreach($this->results as $items){
		    $index_cols=0;
		//for($i=1; $i<=20 ; $i++){
			$datatable_value.=("<tr>");

                //Product SKU
                $display_class='';
               	if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $this->it_get_product_sku( $items->product_id);
                $datatable_value.=("</td>");

                //Categories
                $display_class='';
               	if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $this->it_get_cn_product_id($items->product_id,"product_cat");
                $datatable_value.=("</td>");

                //Product Name
                $display_class='';
               	if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= " <a href=\"".get_permalink($items->product_id)."\" target=\"_blank\">{$items->order_item_name}</a>";
                $datatable_value.=("</td>");


				//Number Order
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->order_count;
				$datatable_value.=("</td>");

				//Qty
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->qty;
				$datatable_value.=("</td>");

				//Price

				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $this->price(get_post_meta($items->product_id, '_price',true));
				$datatable_value.=("</td>");

                //Total
                $display_class='';
               	if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $items->line_total == 0 ? $this->price(0) : $this->price($items->line_total);
                $datatable_value.=("</td>");


			$datatable_value.=("</tr>");
		}
	}elseif($file_used=="search_form"){
	?>
        <form class='alldetails search_form_report' action='' method='post' id="product_form">
            <input type='hidden' name='action' value='submit-form' />
            <div class="row">

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

                    <div class="col-md-6"  style=" <?php echo $col_style;?>">
                        <div class="awr-form-title">
							<?php _e('Product',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                        </div>
                        <span class="awr-form-icon"><i class="fa fa-cog"></i></span>
						<?php
						//$products=$this->it_get_product_woo_data('all');
						$products = $this->it_get_simple_variation_product("SIMPLE",NULL,"ARRAY_A");
						$option='';
						$current_product=$this->it_get_woo_requests_links('it_product_id','',true);
						//echo $current_product;

						foreach($products as $key=>$value){
							$selected='';
							if(is_array($permission_value) && !in_array($value["id"],$permission_value))
								continue;
							if(!$this->get_form_element_permission('it_product_id') &&  $permission_value!='')
								$selected="selected";

							/* if($current_product==$product->id)
								 $selected="selected";*/
							$option.="<option $selected value='".$value["id"]."' >".$value["label"]." </option>";
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
						<?php _e('Order By',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-sort-alpha-asc"></i></span>
                    <div class="row">
                        <div class="col-md-6">

                            <select name="it_sort_by" id="it_sort_by" class="it_sort_by">
                                <option value="quantity" selected="selected"><?php _e('Quantity',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                                <option value="product_name"><?php _e('Product Name',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                            </select>
                        </div>
                        <div class="col-md-6">
                            <select name="it_order_by" id="order_by" class="it_order_by">
                                <option value="ASC"><?php _e('Ascending',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                                <option value="DESC" selected="selected"><?php _e('Descending',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                            </select>
                        </div>
                    </div>
                </div>

            </div>


            <div class="col-md-12 awr-save-form">
				<?php
				$it_hide_os=$this->otder_status_hide;
				$it_publish_order='no';

				$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);
				?>

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
