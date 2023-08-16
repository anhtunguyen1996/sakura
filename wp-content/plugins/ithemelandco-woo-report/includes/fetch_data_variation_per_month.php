<?php

	if($file_used=="sql_table")
	{
		//GET POSTED PARAMETERS
		$start				= 0;
		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
		$date_format = $this->it_date_format($it_from_date);

		$it_from_date=substr($it_from_date,0,strlen($it_from_date)-3);
		$it_to_date=substr($it_to_date,0,strlen($it_to_date)-3);

		$it_product_id			= $this->it_get_woo_requests('it_products',"-1",true);

		$category_id 		= $this->it_get_woo_requests('it_categories','-1',true);
		$it_cat_prod_id_string = $this->it_get_woo_pli_category($category_id,$it_product_id);
		$category_id 				= "-1";


		////ADDED IN VER4.0
		//BRANDS ADDONS
		$brand_id 		= $this->it_get_woo_requests('it_brand_id','-1',true);
		$it_brand_prod_id_string = $this->it_get_woo_pli_category($brand_id,$it_product_id);


		$it_sort_by 			= $this->it_get_woo_requests('sort_by','item_name',true);
		$it_order_by 			= $this->it_get_woo_requests('order_by','ASC',true);

		$it_id_order_status 	= $this->it_get_woo_requests('it_id_order_status',NULL,true);
		$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
		//$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

		$it_variation_attributes 	= $this->it_get_woo_requests('it_variations',NULL,true);
		//if($it_variation_attributes!=NULL)
		if($it_variation_attributes != NULL  && $it_variation_attributes != '-1')
		{

			$it_variations = explode(",",$it_variation_attributes);
			$var=array();
			foreach($it_variations as $key => $value):
				$var[] .=  "attribute_pa_".$value;
				$var[] .=  "attribute_".$value;
			endforeach;
			$it_variation_attributes =  implode("', '",$var);
		}

		///////////HIDDEN FIELDS////////////
		$it_hide_os		= $this->it_get_woo_requests('it_hide_os','-1',true);
		$it_publish_order='no';

		/////////////////////////
		//APPLY PERMISSION TERMS
		$key=$this->it_get_woo_requests('table_names','',true);

		$category_id=$this->it_get_form_element_permission('it_category_id',$category_id,$key);

		////ADDED IN VER4.0
		//BRANDS ADDONS
		$brand_id=$this->it_get_form_element_permission('it_brand_id',$brand_id,$key);

		$it_product_id=$this->it_get_form_element_permission('it_product_id',$it_product_id,$key);

		$it_order_status=$this->it_get_form_element_permission('it_orders_status',$it_order_status,$key);

		if($it_order_status != NULL  && $it_order_status != '-1')
			$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

		///////////////////////////

		$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);
		//////////////////////

		//Category ID
		$category_id_join="";

		////ADDED IN VER4.0
		//BRANDS ADDONS
		$brand_id_join="";

		//Variations Attributes
		$it_variation_attributes_join="";

		//ORDER Status
		$it_id_order_status_join="";
		$it_id_order_status_condition="";

		//Variations Attributes
		$it_variation_attributes_condition="";

		//Start Date
		$it_from_date_condition="";

		//Publish ORDER
		$it_publish_order_condition="";

		//ORDER Status
		$it_order_status_condition="";

		//Category ID
		$category_id_condition="";

		//Category Product ID
		$it_cat_prod_id_string_condition="";


		////ADDED IN VER4.0
		//BRANDS ADDONS
		$brand_id_condition="";
		$it_brand_prod_id_string_condition="";

		//Product ID
		$it_product_id_condition="";


		//HIDE ORDER Status
		$it_hide_os_condition="";

		//SQL GROUP
		$sql_group_by="";

		$sql_columns = "
			it_woocommerce_order_itemmeta_variation.meta_value			as ids
			,it_woocommerce_order_itemmeta_product.meta_value 			as product_id
			,it_woocommerce_order_items.order_item_id 					as order_item_id
			,it_woocommerce_order_items.order_item_name 				as product_name
			,it_woocommerce_order_items.order_item_name 				as item_name


			,SUM(it_woocommerce_order_itemmeta_product_total.meta_value) 	as total
			,SUM(it_woocommerce_order_itemmeta_product_qty.meta_value) 	as quantity

			,MONTH(shop_order.post_date) 							as month_number
			,DATE_FORMAT(shop_order.post_date, '%Y-%m')				as month_key
			,it_woocommerce_order_itemmeta_variation.meta_value		as variation_id
			,it_woocommerce_order_items.order_id						as order_id
			,shop_order.post_status
			,it_woocommerce_order_items.order_item_id					as order_item_id";

			$sql_joins ="{$wpdb->prefix}woocommerce_order_items		as it_woocommerce_order_items
			LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta_product 			ON it_woocommerce_order_itemmeta_product.order_item_id			=	it_woocommerce_order_items.order_item_id
			LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta_product_total 	ON it_woocommerce_order_itemmeta_product_total.order_item_id	=	it_woocommerce_order_items.order_item_id
			LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta_product_qty		ON it_woocommerce_order_itemmeta_product_qty.order_item_id		=	it_woocommerce_order_items.order_item_id
			LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta_variation			ON it_woocommerce_order_itemmeta_variation.order_item_id 		= 	it_woocommerce_order_items.order_item_id

			LEFT JOIN  {$wpdb->prefix}posts 						as shop_order 									ON shop_order.id											=	it_woocommerce_order_items.order_id
		";

		if($category_id != NULL  && $category_id != "-1"){
			$category_id_join = "
			LEFT JOIN  {$wpdb->prefix}term_relationships 			as it_term_relationships 							ON it_term_relationships.object_id		=	it_woocommerce_order_itemmeta_product.meta_value
			LEFT JOIN  {$wpdb->prefix}term_taxonomy 				as term_taxonomy 								ON term_taxonomy.term_taxonomy_id	=	it_term_relationships.term_taxonomy_id
			LEFT JOIN  {$wpdb->prefix}terms 						as it_terms 										ON it_terms.term_id					=	term_taxonomy.term_id";
		}

		if($brand_id != NULL  && $brand_id != "-1"){
			$brand_id_join = "
			LEFT JOIN  {$wpdb->prefix}term_relationships 			as it_term_relationships_brand 							ON it_term_relationships_brand.object_id		=	it_woocommerce_order_itemmeta_product.meta_value
			LEFT JOIN  {$wpdb->prefix}term_taxonomy 				as term_taxonomy_brand 								ON term_taxonomy_brand.term_taxonomy_id	=	it_term_relationships_brand.term_taxonomy_id
			LEFT JOIN  {$wpdb->prefix}terms 						as it_terms_brand 										ON it_terms_brand.term_id					=	term_taxonomy_brand.term_id";
		}

		if($it_id_order_status != NULL  && $it_id_order_status != '-1'){
			$it_id_order_status_join  = "
			LEFT JOIN  {$wpdb->prefix}term_relationships 			as it_term_relationships2 							ON it_term_relationships2.object_id	=	it_woocommerce_order_items.order_id
			LEFT JOIN  {$wpdb->prefix}term_taxonomy 				as it_term_taxonomy2 								ON it_term_taxonomy2.term_taxonomy_id	=	it_term_relationships2.term_taxonomy_id
			LEFT JOIN  {$wpdb->prefix}terms 						as terms2 										ON terms2.term_id					=	it_term_taxonomy2.term_id";
		}

		if($it_variation_attributes != "-1" and strlen($it_variation_attributes)>1)
			$it_variation_attributes_join = "
				LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta_variation ON it_postmeta_variation.post_id = it_woocommerce_order_itemmeta_variation.meta_value
				";

		$sql_condition = "
			it_woocommerce_order_itemmeta_product.meta_key		=	'_product_id'
			AND it_woocommerce_order_items.order_item_type		=	'line_item'
			AND shop_order.post_type						=	'shop_order'

			AND it_woocommerce_order_itemmeta_product_total.meta_key		='_line_total'
			AND it_woocommerce_order_itemmeta_product_qty.meta_key			=	'_qty'
			AND it_woocommerce_order_itemmeta_variation.meta_key 			= '_variation_id'
			AND (it_woocommerce_order_itemmeta_variation.meta_value IS NOT NULL AND it_woocommerce_order_itemmeta_variation.meta_value > 0)
		";

		if($it_variation_attributes != "-1" and strlen($it_variation_attributes)>1)
			$it_variation_attributes_condition = " AND it_postmeta_variation.meta_key IN ('{$it_variation_attributes}')";


		if ($it_from_date != NULL &&  $it_to_date !=NULL)
			$it_from_date_condition= " AND DATE_FORMAT(shop_order.post_date, '%Y-%m') BETWEEN ('" . $it_from_date . "') and ('" . $it_to_date . "')";


		if($category_id  != NULL && $category_id != "-1"){

			$category_id_condition = "
			AND term_taxonomy.taxonomy LIKE('product_cat')
			AND it_terms.term_id IN (".$category_id .")";
		}

		////ADDED IN VER4.0
		//BRANDS ADDONS
		if($brand_id  != NULL && $brand_id != "-1"){

			$brand_id_condition = "
			AND term_taxonomy_brand.taxonomy LIKE('".__IT_BRAND_SLUG__."')
			AND it_terms_brand.term_id IN (".$brand_id .")";
		}


		if($it_cat_prod_id_string  && $it_cat_prod_id_string != "-1")
			$it_cat_prod_id_string_condition = " AND it_woocommerce_order_itemmeta_product.meta_value IN (".$it_cat_prod_id_string .")";

		////ADDED IN VER4.0
		//BRANDS ADDONS
		if($it_brand_prod_id_string  && $it_brand_prod_id_string != "-1")
			$it_brand_prod_id_string_condition = " AND it_woocommerce_order_itemmeta_product.meta_value IN (".$it_brand_prod_id_string .")";

		if($it_id_order_status != NULL  && $it_id_order_status != '-1'){
			$it_id_order_status_condition = "
			AND it_term_taxonomy2.taxonomy LIKE('shop_order_status')
			AND terms2.term_id IN (".$it_id_order_status .")";
		}

		if($it_product_id != NULL  && $it_product_id != '-1'){
			$it_product_id_condition = "
			AND it_woocommerce_order_itemmeta_product.meta_value IN ($it_product_id)";
		}

		if($it_order_status  && $it_order_status != '-1' and $it_order_status != "'-1'")
			$it_order_status_condition = " AND shop_order.post_status IN (".$it_order_status.")";

		if($it_hide_os  && $it_hide_os != '-1' and $it_hide_os != "'-1'")
			$it_hide_os_condition = " AND shop_order.post_status NOT IN ('".$it_hide_os."')";

		$sql_group_by = " GROUP BY it_woocommerce_order_itemmeta_variation.meta_value";

		$sql_order_by = " ORDER BY {$it_sort_by} {$it_order_by}";

		$sql = "SELECT $sql_columns
				FROM $sql_joins $it_id_order_status_join $category_id_join $brand_id_join $it_variation_attributes_join
				WHERE $sql_condition $it_variation_attributes_condition $it_from_date_condition
				$category_id_condition $brand_id_condition $it_cat_prod_id_string_condition $it_brand_prod_id_string_condition $it_id_order_status_condition
				$it_product_id_condition $it_order_status_condition
				$it_hide_os_condition $sql_group_by $sql_order_by";

		//echo $sql;


		$data_variation='';
		$array_index=3;
		$this->table_cols =$this->table_columns($table_name);
		//print_r($this->table_cols);
		$data_variation=array();
		$attributes_available	= $this->it_get_woo_atts('-1');


		$it_variation_attributes 	= $this->it_get_woo_requests('it_variations','-1',true);


		$variation_sel_arr	= '';
		if($it_variation_attributes != NULL  && $it_variation_attributes != '-1')
		{
			$it_variation_attributes = str_replace("','", ",",$it_variation_attributes);
			$variation_sel_arr = explode(",",$it_variation_attributes);
		}

		foreach($attributes_available as $key => $value){
			if($it_variation_attributes=='-1' || is_array($variation_sel_arr) && in_array($key,$variation_sel_arr))
			{
				$data_variation[]=$key;
				$value=array(array('lable'=>$value,'status'=>'show'));
				array_splice($this->table_cols, $array_index++, 0, $value );
			}
		}

		$this->data_variation=$data_variation;

		//IMPORTANT : DISTANCE CURRENT YEAR AND NEXT YEAR + DETERMINE YEAR FOR MONTHS

		$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
		$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);

		$time1  = strtotime($it_from_date);
	   	$time2  = strtotime($it_to_date);
	   	$my     = date('mY', $time2);
		$this->month_start=date('m', $time1);
		$months=array();

		$month_count=0;

		$data_month=array();

		if($my!=date('mY', $time1))
		{
			$year=date('Y', $time1);

			$months = array(array('lable'=>$this->it_translate_function(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time1).'_translate',date('M', $time1))."-".$year,'status'=>'currency'));
			$month_count=1;
			$data_month[]=$year."-".date('m', $time1);

			while($time1 < $time2) {

				$time1 = strtotime(date('Y-m-d', $time1).' +1 month');

				if(date('mY', $time1) != $my && ($time1 < $time2))
				{
					if($year!=date('Y', $time1))
					{
						$year=date('Y', $time1);
						$label = $this->it_translate_function(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time1).'_translate',date('M', $time1))."-".$year;
					}else
						$label = $this->it_translate_function(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time1).'_translate',date('M', $time1));

					$month_count++;
					$months[] = array('lable'=>$label,'status'=>'currency');
					$data_month[]=$year."-".date('m', $time1);
				}
			}

			if($year!=date('Y', $time2)){
				$year=date('Y', $time2);
				$label = $this->it_translate_function(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time2).'_translate',date('M', $time2))."-".$year;
			}else
				$label = $this->it_translate_function(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time2).'_translate',date('M', $time2));
			$months[] = array('lable'=>$label,'status'=>'currency');
			$data_month[]=$year."-".date('m', $time2);
		}else
		{
			$year=date('Y', $time1);

			$months = array(array('lable'=>$this->it_translate_function(__IT_REPORT_WCREPORT_FIELDS_PERFIX__.date('M', $time1).'_translate',date('M', $time1))."-".$year,'status'=>'currency'));
			$data_month[]=$year."-".date('m', $time1);
			$month_count=1;
		}
	  	//print_r( $data_month);


		$value=array(array('lable'=>esc_html__('Total',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'));
		$value=array_merge($months,$value);

		array_splice($this->table_cols, $array_index, count($this->table_cols), $value);

		//print_r($this->table_cols);


		$this->month_count=$month_count;
		$this->data_month=$data_month;

		//print_r($this->month_count);

	}elseif($file_used=="data_table"){

		foreach($this->results as $items){		    $index_cols=0;
		//for($i=1; $i<=20 ; $i++){


			$datatable_value.=("<tr>");

				//Product SKU
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $this->it_get_prod_sku($items->order_item_id, $items->product_id);
				$datatable_value.=("</td>");

				//Product Name
				$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $items->product_name;
				$datatable_value.=("</td>");


                //PAYMENT GATEWAY
                $display_class='';
                if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
                $datatable_value.=("<td style='".$display_class."'>");
                $datatable_value.= get_post_meta($items->order_id,"_payment_method_title",true);
                $datatable_value.=("</td>");

				////////////////////
				//Variation

				$variation_arr=array();
				$variation = $this->it_get_product_var_col_separated($items->order_item_id);
				foreach($variation as $key => $value){
					//$month_arr[$item_product->month_number]['total']=$item_product->total;
					//$month_arr[$item_product->month_number]['qty']=$item_product->quantity;
					$variation_arr[$key]=$value;
				}

				$j=2;
				foreach($this->data_variation as $variation_name){
					$display_class='';
					if($this->table_cols[$j++]['status']=='hide') $display_class='display:none';
					$datatable_value.=("<td style='".$display_class."'>");
						$datatable_value.= $it_table_value=(isset($variation_arr[$variation_name]) ?$variation_arr[$variation_name]:"-"); //$this->it_get_woo_variation($items->order_item_id);
					$datatable_value.=("</td>");
				}
				////////////////////


				$type = 'total_row';$items_only = true; $id = $items->ids;

				$it_from_date		  = $this->it_get_woo_requests('it_from_date',NULL,true);
				$it_to_date			= $this->it_get_woo_requests('it_to_date',NULL,true);
				$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
				$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";
				$it_from_date=substr($it_from_date,0,strlen($it_from_date)-3);
				$it_to_date=substr($it_to_date,0,strlen($it_to_date)-3);

				$params=array(
					"it_from_date"=>$it_from_date,
					"it_to_date"=>$it_to_date,
					"order_status"=>$it_order_status,
					"it_hide_os"=>'"trash"'
				);

				$items_product=$this->it_get_product_var_items($type , $items_only, $id,$params);

				$month_arr='';
				$month_arr=array();
				//print_r($items_product);
				foreach($items_product as $item_product){
					//$month_arr[$item_product->month_number]['total']=$item_product->total;
					//$month_arr[$item_product->month_number]['qty']=$item_product->quantity;
					$month_arr[$item_product->month_key]['total']=$item_product->total;
					$month_arr[$item_product->month_key]['qty']=$item_product->quantity;
				}

				//die($this->month_count."ww".$this->month_count);

				//$j=3;
				$total=0;
				$qty=0;

				//print_r($month_arr);
				//print_r($this->data_month);

				foreach($this->data_month as $month_name){
				//for($i=((int)$this->month_start-1);$i<=($this->month_count+(int)$this->month_start);$i++){

					$it_table_value=$this->price(0);
					if(isset($month_arr[$month_name]['total'])){
						$it_table_value=$this->price($month_arr[$month_name]['total']) .' #'.$month_arr[$month_name]['qty'];
						$total+=$month_arr[$month_name]['total'];
						$qty+=$month_arr[$month_name]['qty'];
					}


					$display_class='';
					if($this->table_cols[$j++]['status']=='hide') $display_class='display:none';
					$datatable_value.=("<td style='".$display_class."'>");
						$datatable_value.= $it_table_value;
					$datatable_value.=("</td>");
				}

				$display_class='';
				if($this->table_cols[$j]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $this->price($total) .' #'.$qty;
				$datatable_value.=("</td>");


			$datatable_value.=("</tr>");
		}
	}elseif($file_used=="search_form"){
			$now_date= date("Y-m-d");
			$cur_year=substr($now_date,0,4);
			$it_from_date= $cur_year."-01-01";
			$it_to_date= $cur_year."-12-31";
		?>
		<form class='alldetails search_form_report' action='' method='post'>
			<input type='hidden' name='action' value='submit-form' />
			<div class="row">

				<div class="col-md-6">
					<div>
						<?php _e('From Date',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
					</div>
					<span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
					<input name="it_from_date" id="pwr_from_date" type="text" readonly='true' class="datepick" value="<?php echo $it_from_date;?>"/>
				</div>
				<div class="col-md-6">
					<div class="awr-form-title">
						<?php _e('To Date',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
					</div>
					<span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
					<input name="it_to_date" id="pwr_to_date" type="text" readonly='true' class="datepick"  value="<?php echo $it_to_date;?>"/>
				</div>

            	<?php
               		$col_style='';
					$permission_value=$this->get_form_element_value_permission('it_categories');
					if($this->get_form_element_permission('it_categories') ||  $permission_value!=''){

						if(!$this->get_form_element_permission('it_categories') &&  $permission_value!='')
							$col_style='display:none';
				?>

                <div class="col-md-6"  style=" <?php echo $col_style;?>">
                	<div class="awr-form-title">
						<?php _e('Category',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-tags"></i></span>
					<?php
                        $categories = $this->it_get_woo_var_cat_data('product_cat');
                        $option='';
                        foreach($categories as $category){
							$selected="";
							//CHECK IF IS IN PERMISSION
							if(is_array($permission_value) && !in_array($category -> id,$permission_value))
								continue;
					

                            $option.="<option value='".$category -> id."' $selected>".$category -> label."</option>";
                        }
                    ?>

                    <select name="it_categories[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                        <?php
                        	if($this->get_form_element_permission('it_categories') && ((!is_array($permission_value)) || (is_array($permission_value) && in_array('all',$permission_value))))
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

                    ////ADDED IN VER4.0
                    //BRANDS ADDONS
                    $col_style='';
                    $permission_value=$this->get_form_element_value_permission('it_brand_id');
                    if(__IT_BRAND_SLUG__ && ($this->get_form_element_permission('it_brand_id') ||  $permission_value!='')){
                        if(!$this->get_form_element_permission('it_brand_id') &&  $permission_value!='')
                            $col_style='display:none';
                        ?>

                        <div class="col-md-6"  style=" <?php echo $col_style;?>">
                            <div class="awr-form-title">
                                <?php echo __IT_BRAND_LABEL__;?>
                            </div>
                            <span class="awr-form-icon"><i class="fa fa-tags"></i></span>
                            <?php
                            $args = array(
                                'orderby'                  => 'name',
                                'order'                    => 'ASC',
                                'hide_empty'               => 1,
                                'hierarchical'             => 0,
                                'exclude'                  => '',
                                'include'                  => '',
                                'child_of'          		 => 0,
                                'number'                   => '',
                                'pad_counts'               => false

                            );

                            //$categories = get_categories($args);
                            $current_category=$this->it_get_woo_requests_links('it_brand_id','',true);

                            $categories = get_terms(__IT_BRAND_SLUG__,$args);
                            $option='';
                            foreach ($categories as $category) {
                                $selected='';
                                //CHECK IF IS IN PERMISSION
                                if(is_array($permission_value) && !in_array($category->term_id,$permission_value))
                                    continue;


                                $option .= '<option value="'.$category->term_id.'" '.$selected.'>';
                                $option .= $category->name;
                                $option .= ' ('.$category->count.')';
                                $option .= '</option>';
                            }
                            ?>
                            <select name="it_brand_id[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                                <?php
                                if($this->get_form_element_permission('it_brand_id') && ((!is_array($permission_value)) || (is_array($permission_value) && in_array('all',$permission_value))))
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

					$col_style='';
					$permission_value=$this->get_form_element_value_permission('it_products');
					if($this->get_form_element_permission('it_products') ||  $permission_value!=''){

						if(!$this->get_form_element_permission('it_products') &&  $permission_value!='')
							$col_style='display:none';
				?>

                <div class="col-md-6"  style=" <?php echo $col_style;?>">
                	<div class="awr-form-title">
						<?php _e('Product',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-cog"></i></span>
					<?php
                        $products = $this->it_get_woo_var_data();
                        $option='';
                        foreach($products as $product){
							$selected="";
							//CHECK IF IS IN PERMISSION
							if(is_array($permission_value) && !in_array($product -> id,$permission_value))
								continue;

                            $option.="<option value='".$product -> id."' $selected>".$product -> label."</option>";
                        }
                    ?>

                    <select name="it_products[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                        <?php
                        	if($this->get_form_element_permission('it_products') && ((!is_array($permission_value)) || (is_array($permission_value) && in_array('all',$permission_value))))
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
					$col_style='';
					$permission_value=$this->get_form_element_value_permission('it_orders_status');
					if($this->get_form_element_permission('it_orders_status') ||  $permission_value!=''){

						if(!$this->get_form_element_permission('it_orders_status') &&  $permission_value!='')
							$col_style='display:none';
				?>

                <div class="col-md-6"  style=" <?php echo $col_style;?>">
                    <div class="awr-form-title">
                        <?php _e('Status',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-check"></i></span>
					<?php
                        $it_order_status=$this->it_get_woo_orders_statuses();

                        ////ADDED IN VER4.0
                        /// APPLY DEFAULT STATUS AT FIRST
                        $shop_status_selected='';
                        if($this->it_shop_status)
                            $shop_status_selected=explode(",",$this->it_shop_status);

                        $option='';
                        foreach($it_order_status as $key => $value){
							$selected="";
							//CHECK IF IS IN PERMISSION
							if(is_array($permission_value) && !in_array($key,$permission_value))
								continue;

	                        ////ADDED IN VER4.0
	                        /// APPLY DEFAULT STATUS AT FIRST
	                        if(is_array($shop_status_selected) && in_array($key,$shop_status_selected))
		                        $selected="selected";

	                        $option.="<option value='".$key."' $selected >".$value."</option>";
                        }
                    ?>

                    <select name="it_orders_status[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                        <?php
                        	if($this->get_form_element_permission('it_orders_status') && ((!is_array($permission_value)) || (is_array($permission_value) && in_array('all',$permission_value))))
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
                    <input type="hidden" name="it_id_order_status[]" id="it_id_order_status" value="-1">
                </div>

                <?php
					}
				?>

                <div class="col-md-6">
                	<div class="awr-form-title">
						<?php _e('Variations',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-bolt"></i></span>
					<?php
                        $attributes_available	= $this->it_get_woo_atts('-1');
                        $option='';
                        foreach($attributes_available as $key => $value){
                            $option.="<option value='".$key."' >".$value."</option>";
                        }
                    ?>

                    <select name="it_variations[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                        <option value="-1"><?php _e('Select All',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                        <?php
                            echo $option;
                        ?>
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
