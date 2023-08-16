<?php

	if($file_used=="sql_table")
	{

		//GET POSTED PARAMETERS
		$request 			= array();
		$start				= 0;
		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
		$date_format = $this->it_date_format($it_from_date);

		$it_parent_tag_id		= $this->it_get_woo_requests('it_tags_id','-1',true);

		$it_child_cat_id	= $this->it_get_woo_requests('child_category_id','-1',true);
		$it_id_order_status 	= $this->it_get_woo_requests('it_id_order_status',NULL,true);
		$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
		$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";
		$it_hide_os		= $this->it_get_woo_requests('it_hide_os','-1',true);

		$it_list_parent_cat			= $this->it_get_woo_requests('list_parent_category',NULL,false);
		$category_id			= $this->it_get_woo_requests('it_category_id','-1',true);
		$it_group_by_parent_cat			= $this->it_get_woo_requests('group_by_parent_cat','-1',true);
		$it_show_cog		= $this->it_get_woo_requests('it_show_cog','no',true);

		/////////////////////////
		//APPLY PERMISSION TERMS
		$key=$this->it_get_woo_requests('table_names','',true);

		$it_parent_tag_id=$this->it_get_form_element_permission('it_tags_id',$it_parent_tag_id,$key);

		///////////////////////////

		///////////HIDDEN FIELDS////////////
		$it_publish_order='no';
		$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);
		//////////////////////


		//DATE
		$it_from_date_condition='';

		//ORDER STATUS
		$it_order_status_condition='';
		$it_id_order_status_join='';
		$it_id_order_status_condition='';

		//CATEGORY
		$category_id_condition='';

		//ORDER STATUS
		$it_order_status_condition='';

		//PARENT CATEGORY
		$it_parent_tag_id_condition='';

		//CHILD CATEGORY
		$it_child_cat_id_condition='';

		//LIST PARENT CATEGORY
		$it_list_parent_cat_condition='';

		//PUBLISH STATUS
		$it_publish_order_condition='';

		//HIDE ORDER STATUS
		$it_hide_os_condition='';

		$sql_columns = "
		SUM(it_woocommerce_order_itemmeta_product_qty.meta_value) 				AS 'quantity',
		SUM(it_woocommerce_order_itemmeta_tags.meta_value) 				AS 'total_amount' ,
		it_woocommerce_order_items.order_item_name					AS 'product_name' ,
		it_woocommerce_order_items.order_item_id					AS order_item_id ,
		woocommerce_order_itemmeta_product_id.meta_value		AS product_id ,
		DATE(shop_order.post_date)								AS post_date ,
		it_terms.name											AS tag_name ,
		it_terms.term_id											AS tag_id";

		//COST OF GOOD
		if($it_show_cog=='yes'){
			$sql_columns .= " ,SUM(it_woocommerce_order_itemmeta_product_qty.meta_value * it_woocommerce_order_itemmeta22.meta_value) AS 'total_cost'";
		}

		$sql_joins= "{$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items
							LEFT JOIN  {$wpdb->prefix}posts as it_posts ON it_posts.id=it_woocommerce_order_items.order_id
							LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_product_qty ON it_woocommerce_order_itemmeta_product_qty.order_item_id=it_woocommerce_order_items.order_item_id
							LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta_tags ON it_woocommerce_order_itemmeta_tags.order_item_id=it_woocommerce_order_items.order_item_id
							LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta_product_id ON woocommerce_order_itemmeta_product_id.order_item_id=it_woocommerce_order_items.order_item_id

							LEFT JOIN  {$wpdb->prefix}term_relationships	as it_term_relationships_tags 	ON it_term_relationships_tags.object_id	=	woocommerce_order_itemmeta_product_id.meta_value
							LEFT JOIN  {$wpdb->prefix}term_taxonomy			as it_term_taxonomy_tags 		ON it_term_taxonomy_tags.term_taxonomy_id	=	it_term_relationships_tags.term_taxonomy_id
							LEFT JOIN  {$wpdb->prefix}terms					as it_terms 				ON it_terms.term_id					=	it_term_taxonomy_tags.term_id
							LEFT JOIN  {$wpdb->prefix}posts as shop_order ON shop_order.id=it_woocommerce_order_items.order_id
							";


		//COST OF GOOD
		if($it_show_cog=='yes'){
			$sql_joins .=	"
			LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta22 ON it_woocommerce_order_itemmeta22.order_item_id=it_woocommerce_order_items.order_item_id ";
		}



		$sql_condition = "  it_woocommerce_order_itemmeta_product_qty.meta_key				= '_qty'
							AND it_woocommerce_order_itemmeta_tags.meta_key			= '_line_total'
							AND woocommerce_order_itemmeta_product_id.meta_key 	= '_product_id'
							AND shop_order.post_type							= 'shop_order'
							AND it_term_taxonomy_tags.taxonomy = 'product_tag'";


		if ($it_from_date != NULL &&  $it_to_date !=NULL){
			$it_from_date_condition= " AND DATE(shop_order.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format')";
		}

		if($it_parent_tag_id  && $it_parent_tag_id != "-1") {
			$category_id_condition= " AND it_terms.term_id IN ({$it_parent_tag_id}) ";
		}


		if($it_order_status  && $it_order_status != '-1' and $it_order_status != "'-1'")
			$it_order_status_condition= " AND it_posts.post_status IN (".$it_order_status.")";

		if($it_hide_os  && $it_hide_os != '-1' and $it_hide_os != "'-1'")
			$it_hide_os_condition= " AND it_posts.post_status NOT IN ('".$it_hide_os."')";

		//COST OF GOOD
		if($it_show_cog=='yes'){
			$sql_condition .="
			AND it_woocommerce_order_itemmeta22.meta_key	= '".__IT_COG_TOTAL__."' ";
		}


		$sql_group_by='';

		$sql_group_by= " GROUP BY  it_terms.term_id";

		$sql_order_by= "  ORDER BY total_amount DESC, quantity DESC, tag_id ASC";

		$sql = "SELECT $sql_columns FROM $sql_joins $it_id_order_status_join WHERE $sql_condition
				$it_id_order_status_condition $it_parent_tag_id_condition $it_child_cat_id_condition
				$it_list_parent_cat_condition $it_from_date_condition $it_publish_order_condition
				$it_order_status_condition $it_hide_os_condition $category_id_condition
				$sql_group_by $sql_order_by
				";

		//echo $sql;

		$this->table_cols =$this->table_columns($table_name);
		//CHECK IF COST OF GOOD IS ENABLE


		if($it_show_cog!='yes'){
			unset($this->table_cols[count($this->table_cols)-1]);
			unset($this->table_cols[count($this->table_cols)-1]);
		}

	}elseif($file_used=="data_table"){

		////ADDE IN VER4.0
		/// TOTAL ROWS VARIABLES
		$sales_qty=$category_count=$total_amnt=$cog_amnt=$profit_amnt=0;

		foreach($this->results as $items){
		    $index_cols=0;
		//for($i=1; $i<=20 ; $i++){
			$datatable_value.=("<tr>");

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $category_count++;

				//Tag Name
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->tag_name;
				$datatable_value.=("</td>");

				//Quantity
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->quantity;

                    ////ADDE IN VER4.0
                    /// TOTAL ROWS
                    $sales_qty+=$items->quantity;
				$datatable_value.=("</td>");

				//Amount
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->total_amount == 0 ? $this->price(0) : $this->price($items->total_amount);

                    ////ADDED IN VER4.0
                    /// TOTAL ROWS
                    $total_amnt+=$items->total_amount;
				$datatable_value.=("</td>");

				//COST OF GOOD
				$it_show_cog= $this->it_get_woo_requests('it_show_cog',"no",true);
				if($it_show_cog=='yes'){
					$display_class='';
					/*$cog=get_post_meta($items->product_id,__IT_COG__,true);
					$cog*=$items->quantity;*/
					if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
					$datatable_value.=("<td style='".$display_class."'>");
						//$datatable_value.= $cog == 0 ? $this->price(0) : $this->price($cog);
						$datatable_value.= $items->total_cost == 0 ? $this->price(0) : $this->price($items->total_cost);

                        ////ADDED IN VER4.0
                        /// TOTAL ROWS
                        $cog_amnt+=$items->total_cost;

					$datatable_value.=("</td>");

					if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
					$datatable_value.=("<td style='".$display_class."'>");
						//$datatable_value.= $cog == 0 ? $this->price(0) : $this->price($cog);
						$datatable_value.= ($items->total_amount-$items->total_cost) == 0 ? $this->price(0) : $this->price($items->total_amount-$items->total_cost);

                        ////ADDED IN VER4.0
                        /// TOTAL ROWS
                        $profit_amnt+=($items->total_amount-$items->total_cost);

					$datatable_value.=("</td>");
				}

			$datatable_value.=("</tr>");
		}

		////ADDED IN VER4.0
		/// TOTAL ROW
		$table_name_total= $table_name;
		$it_show_cog		= $this->it_get_woo_requests('it_show_cog','no',true);
		$this->table_cols_total = $this->table_columns_total( $table_name_total );
		$datatable_value_total='';
		if($it_show_cog!='yes'){
			////ADDE IN VER4.0
			/// COST OF GOOD
			unset($this->table_cols_total[count($this->table_cols_total)-1]);
			unset($this->table_cols_total[count($this->table_cols_total)-1]);
		}

		$datatable_value_total.=("<tr>");
		$datatable_value_total.="<td>$category_count</td>";
		$datatable_value_total.="<td>$sales_qty</td>";
		$datatable_value_total.="<td>".(($total_amnt) == 0 ? $this->price(0) : $this->price($total_amnt))."</td>";
		if($it_show_cog=='yes'){
			$datatable_value_total.="<td>".(($cog_amnt) == 0 ? $this->price(0) : $this->price($cog_amnt))."</td>";
			$datatable_value_total.="<td>".(($profit_amnt) == 0 ? $this->price(0) : $this->price($profit_amnt))."</td>";
		}
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

                <?php
                $col_style='';
                $permission_value=$this->get_form_element_value_permission('it_tags_id');

                if($this->get_form_element_permission('it_tags_id') ||  $permission_value!=''){

                    if ( ! $this->get_form_element_permission( 'it_tags_id' ) && $permission_value != '' ) {
                        $col_style = 'display:none';
                    }
                    ?>

                    <div class="col-md-6" >
                        <div class=" awr-form-title">
                    <?php _e( 'Tags', __IT_REPORT_WCREPORT_TEXTDOMAIN__ ); ?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-tags"></i></span>
                    <?php
                    $p_categories     = $this->it_get_tag_products( 'product_tag' );
                    $option           = '';
                    $current_category = $this->it_get_woo_requests_links( 'it_tags_id', '', true );
                    //echo $current_product;

                    foreach ( $p_categories as $category ) {
                        $selected = '';

                        /*if(!$this->get_form_element_permission('it_tags_id') &&  $permission_value!='')
                            $selected="selected";

                        if($current_category==$category->id)
                            $selected="selected";*/
                        $option .= "<option $selected value='" . $category->id . "' >" . $category->label . " </option>";
                    }

                    ?>
                    <select name="it_tags_id[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                        <?php
                        if ( $this->get_form_element_permission( 'it_tags_id' ) && ( ( ! is_array( $permission_value ) ) || ( is_array( $permission_value ) && in_array( 'all', $permission_value ) ) ) ) {
                            ?>
                            <option value="-1"><?php _e( 'Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__ ); ?></option>
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
            	if(__IT_COG__!=''){
				?>

					<div class="col-md-6">
						<div class="awr-form-title">
							<?php _e('SHOW JUST INCLUDE C.O.G & PROFIT',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                            <br />
                            <span class="description"><?php _e('Include just products with current Profit(Cost of good) plugin(Selected in Setting -> Add-on Settings -> Cost of Good).',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></span>
						</div>

						<input name="it_show_cog" type="checkbox" value="yes"/>

					</div>
				<?php
					}
				?>

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
