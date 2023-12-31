<?php

	if($file_used=="sql_table")
	{
		$limit 				= $this->it_get_woo_requests('limit',3,true);
		$p 					= $this->it_get_woo_requests('p',1,true);
		$page				= $this->it_get_woo_requests('page',NULL);
		$it_order_status		= $this->it_get_woo_requests('it_orders_status',"-1",true);

		$it_stock_less_than		= $this->it_get_woo_requests('it_stock_less_than',"0",true);


		//GET POSTED PARAMETERS
		$request 			= array();
		$start				= 0;
		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
		$it_id_order_status 	= $this->it_get_woo_requests('it_id_order_status',NULL,true);
		$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
		$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

		///////////HIDDEN FIELDS////////////
		$it_hide_os		= $this->it_get_woo_requests('it_hide_os','-1',true);
		$it_publish_order='no';
		$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);
		//////////////////////


		$sql_columns = "
		it_product.ID 										AS product_id ,
		it_product.post_parent								AS product_parent ,
		it_product.post_title 								AS stock_product_name,
		it_product.post_type 								AS post_type,
	    it_manage_stock.meta_value 							AS manage_stock,
		(it_stock.meta_value + 0) 							AS stock ";



		$sql_joins = "{$wpdb->prefix}posts AS it_product
		LEFT JOIN {$wpdb->postmeta} AS it_manage_stock ON it_manage_stock.post_id = it_product.ID AND it_manage_stock.meta_key = '_manage_stock'
		LEFT JOIN {$wpdb->postmeta} AS it_stock ON it_stock.post_id = it_product.ID AND it_stock.meta_key = '_stock'";

		$sql_condition = " it_product.post_type IN ('product','product_variation') AND it_product.post_status IN ('publish') AND it_manage_stock.meta_value = 'yes' ";

		if(strlen($it_stock_less_than) > 0){
			$sql_condition .= " AND it_stock.meta_value <= {$it_stock_less_than}";
		}


		$sql_group_by = " GROUP BY product_id ";

		$sql_order_by = " ORDER BY it_stock.meta_value *1 ASC ";

		$sql = "SELECT $sql_columns
				FROM $sql_joins
				WHERE $sql_condition $sql_group_by $sql_order_by";


		//CUSTOM WORK - 15862
		$this->table_cols =$this->table_columns($table_name);
		if(is_array(__CUSTOMWORK_ID__) && in_array('15862',__CUSTOMWORK_ID__)) {
			$custom_sku_cols[]=array('lable'=>'Custom SKU','status'=>'show');
			array_splice($this->table_cols,1,0,$custom_sku_cols);
		}
//		print_r($this->table_cols);
//		die;

		//echo $sql;

	}
	elseif($file_used=="data_table"){

		////ADDE IN VER4.0
		/// TOTAL ROWS VARIABLES
		$product_count=$total_stock=0;

		foreach($this->results as $items){
		    $index_cols=0;
		//for($i=1; $i<=20 ; $i++){

			////ADDE IN VER4.0
			/// TOTAL ROWS
			$product_count++;

			$datatable_value.=("<tr>");

				//Product SKU
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $this->it_get_product_sku($items->product_id);
				$datatable_value.=("</td>");

                //CUSTOM WORK - 15862
                if(is_array(__CUSTOMWORK_ID__) && in_array('15862',__CUSTOMWORK_ID__)) {
                    //Custom SKU
                    $display_class = '';
                    $custom_sku    = get_post_meta( $items->product_id, 'jk_sku', true );
                    if ( $this->table_cols[ $index_cols ++ ]['status'] == 'hide' ) {
                        $display_class = 'display:none';
                    }
                    $datatable_value .= ( "<td style='" . $display_class . "' data-product-id='" . $items->product_id . "'>" );
                    $datatable_value .= $custom_sku;
                    $datatable_value .= ( "</td>" );
                }

				//Product Name
                $product_name=get_the_title($items->product_id);
                global $woocommerce;
                //before woo 3.0
                if (version_compare($woocommerce->version, 3.0, "<")) {
                    global $product;
                    $product=wc_get_product($items->product_id);
                    $attributes = $product->get_attributes();
                    if($items->product_parent!=0) {
                        $product_name=get_the_title($items->product_parent)." | ";
                        $variations = wc_get_product( $items->product_id );
                        $variations = $variations->get_variation_attributes();
                        $product_name_var=array();
                        foreach ( $attributes as $att ) {
                            $product_name_var[] = wc_attribute_label($att['name'])." : ". $variations[ "attribute_" . $att['name'] ];
                        }
                        $product_name.=implode($product_name_var," - ");
                    }
                }

                $display_class='';
                if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $product_name;
                $datatable_value.=("</td>");

                //Last Sale Date
                $display_class='';
			    $date_format		= get_option( 'date_format' );
			    //date($date_format,strtotime($items->order_date));

			    $product_last_order_dates 	= $this->it_product_last_sale_order_date($items->product_parent);
                $product_id_order_dates 	= isset($product_last_order_dates['product_id']) ? $product_last_order_dates['product_id'] : array();
                $variation_id_order_dates 	= isset($product_last_order_dates['variation_id']) ? $product_last_order_dates['variation_id'] : array();

			    $date_value='';
                if($items->post_type=='product')
                {
	                $date_value=($product_id_order_dates[$items->product_id]!='' ? date($date_format,strtotime($product_id_order_dates[$items->product_id])): "");
                }else{
	                $date_value=(isset($variation_id_order_dates[$items->product_id]) && $variation_id_order_dates[$items->product_id]!='' ? date($date_format,strtotime($variation_id_order_dates[$items->product_id])): "");
                }


               	if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $date_value;
                $datatable_value.=("</td>");

				//Sales Qty.
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->stock;

                    ////ADDE IN VER4.0
                    /// TOTAL ROWS
			        $total_stock+= $items->stock;
				$datatable_value.=("</td>");

                //Actions
                $display_class='';
                $p_label=$items->stock_product_name;
                $product_id=$items->product_id;
                if($items->product_parent>0)
                {
                    $product_id=$items->product_parent;
                }
                $edit_product	= admin_url("post.php")."?action=edit&post=$product_id";
                $view_product		= get_permalink($product_id);
                $edit_product = "<a href='{$edit_product}' target='_blank'>".esc_html__("Edit Product",__IT_REPORT_WCREPORT_TEXTDOMAIN__)."</a>";
                $view_product = "<a href='{$view_product}' target='_blank'>".esc_html__("View Product",__IT_REPORT_WCREPORT_TEXTDOMAIN__)."</a>";

               	if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= $edit_product ." | ".$view_product;
                $datatable_value.=("</td>");

			$datatable_value.=("</tr>");
		}

		////ADDE IN VER4.0
		/// TOTAL ROWS
		$table_name_total= $table_name;
		$this->table_cols_total = $this->table_columns_total( $table_name_total );
		$datatable_value_total='';

		$datatable_value_total.=("<tr>");
		$datatable_value_total.="<td>$product_count</td>";
		$datatable_value_total.="<td>$total_stock</td>";
		$datatable_value_total.=("</tr>");

	}elseif($file_used=="search_form"){
	?>
		<form class='alldetails search_form_report' action='' method='post'>
            <input type='hidden' name='action' value='submit-form' />
            <div class="row">

                <div class="col-md-6">
                    <div class="awr-form-title">
	                    <?php _e('Stock Less Than',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-battery-4"></i></span>
                    <input name="it_stock_less_than" type="text" class="it_stock_less_than" value="0"/>
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

                	<input type="hidden" name="it_hide_os" id="it_hide_os" value="<?php echo $it_hide_os;?>" />
                    <input type="hidden" name="it_id_order_status[]" id="it_id_order_status" value="-1">
                    <input type="hidden" name="it_orders_status[]" id="order_status" value="<?php echo $this->it_shop_status; ?>">

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
