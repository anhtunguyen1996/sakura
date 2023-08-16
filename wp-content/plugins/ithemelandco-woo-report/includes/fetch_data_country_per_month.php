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

		$it_product_id			= $this->it_get_woo_requests('it_product_id',"-1",true);
		$category_id 		= $this->it_get_woo_requests('it_category_id','-1',true);
		$it_cat_prod_id_string = $this->it_get_woo_pli_category($category_id,$it_product_id);
		$category_id 				= "-1";

		$it_sort_by 			= $this->it_get_woo_requests('sort_by','item_name',true);
		$it_order_by 			= $this->it_get_woo_requests('order_by','ASC',true);

		$it_id_order_status 	= $this->it_get_woo_requests('it_id_order_status',NULL,true);
		$it_order_status		= $this->it_get_woo_requests('it_orders_status','-1',true);
		//$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

		$it_country_code		= $this->it_get_woo_requests('it_countries_code','-1',true);



		///////////HIDDEN FIELDS////////////
		$it_hide_os		= $this->it_get_woo_requests('it_hide_os','-1',true);
		$it_publish_order='no';
		$data_format=$this->it_get_woo_requests_links('date_format',get_option('date_format'),true);

		/////////////////////////
		//APPLY PERMISSION TERMS
		$key=$this->it_get_woo_requests('table_names','',true);

		$it_country_code=$this->it_get_form_element_permission('it_countries_code',$it_country_code,$key);

		if($it_country_code != NULL  && $it_country_code != '-1')
			$it_country_code  		= "'".str_replace(",","','",$it_country_code)."'";

		$it_order_status=$this->it_get_form_element_permission('it_orders_status',$it_order_status,$key);

		if($it_order_status != NULL  && $it_order_status != '-1')
			$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

		///////////////////////////


		$it_id_order_status_joins ="";
		//Order Status id
		$it_id_order_status_join="";
		//ORDER Status
		$it_id_order_status_condition ="";
		//Start Date
		$it_from_date_condition ="";
		//Country Code
		$it_country_code_condition ="";
		//ORDER Status Condition
		$it_order_status_condition ="";
		//Hide ORDER Status
		$it_hide_os_condition ="";

		$sql_columns = "
		it_postmeta1.meta_value 							as id
		,it_postmeta1.meta_value						 	as country_name
		,it_postmeta1.meta_value						 	as country_code
		,it_postmeta1.meta_value						 	as item_name
		,SUM(it_postmeta2.meta_value)						as total
		,COUNT(shop_order.ID) 							as quantity

		,MONTH(shop_order.post_date) 					as month_number
		,DATE_FORMAT(shop_order.post_date, '%Y-%m')		as month_key";

		$sql_joins="{$wpdb->prefix}posts as shop_order
		LEFT JOIN	{$wpdb->prefix}postmeta as it_postmeta1 on it_postmeta1.post_id = shop_order.ID
		LEFT JOIN	{$wpdb->prefix}postmeta as it_postmeta2 on it_postmeta2.post_id = shop_order.ID
		";

		if($it_id_order_status != NULL  && $it_id_order_status != '-1'){
			$it_id_order_status_joins = "
			LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships2 	ON it_term_relationships2.object_id	=	shop_order.ID
			LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as it_term_taxonomy2 		ON it_term_taxonomy2.term_taxonomy_id	=	it_term_relationships2.term_taxonomy_id
			LEFT JOIN  {$wpdb->prefix}terms 				as terms2 				ON terms2.term_id					=	it_term_taxonomy2.term_id";
		}

		$sql_condition = "
		shop_order.post_type	= 'shop_order'
		AND it_postmeta1.meta_key 		= '_billing_country'
		AND	it_postmeta2.meta_key 		= '_order_total'";

		if($it_id_order_status != NULL  && $it_id_order_status != '-1'){
			$it_id_order_status_condition = "
			AND it_term_taxonomy2.taxonomy LIKE('shop_order_status')
			AND terms2.term_id IN (".$it_id_order_status .")";
		}

		if ($it_from_date != NULL &&  $it_to_date !=NULL)
			$it_from_date_condition  = " AND DATE_FORMAT(shop_order.post_date, '%Y-%m') BETWEEN ('" . $it_from_date . "') and ('" . $it_to_date . "')";

		if($it_country_code != NULL  && $it_country_code != '-1')
			$it_country_code_condition = "
				AND	it_postmeta1.meta_value 	IN ({$it_country_code})";

		if($it_order_status  && $it_order_status != '-1' and $it_order_status != "'-1'")
			$it_order_status_condition .= " AND shop_order.post_status IN (".$it_order_status.")";
		if($it_hide_os  && $it_hide_os != '-1' and $it_hide_os != "'-1'")
			$it_hide_os_condition = " AND shop_order.post_status NOT IN ('".$it_hide_os."')";


		$sql_group_by  = " group by it_postmeta1.meta_value";
		$sql_order_by="ORDER BY {$it_sort_by} {$it_order_by}";

		$sql = "SELECT $sql_columns FROM $sql_joins $it_id_order_status_joins $it_id_order_status_join WHERE $sql_condition $it_id_order_status_condition $it_from_date_condition $it_country_code_condition $it_order_status_condition $it_hide_os_condition
			$sql_group_by $sql_order_by";

		//echo $sql;

		///////////////////
		//MONTHS

		$array_index=2;
		$this->table_cols =$this->table_columns($table_name);

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
	  	//print_r( $months);


		$value=array(array('lable'=>esc_html__('Total',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'currency'));
		$value=array_merge($months,$value);

		array_splice($this->table_cols, $array_index, count($this->table_cols), $value);

		//print_r($this->table_cols);


		$this->month_count=$month_count;
		$this->data_month=$data_month;

	}elseif($file_used=="data_table"){

		foreach($this->results as $items){
		    $index_cols=0;
		//for($i=1; $i<=20 ; $i++){
			$datatable_value.=("<tr>");

				//Country Name
				$display_class='';
				$country      	= $this->it_get_woo_countries();
				$it_table_value = isset($country->countries[$items->country_name]) ? $country->countries[$items->country_name]: $items->country_name;
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $it_table_value;
				$datatable_value.=("</td>");

				$type = 'total_row';$items_only = true; $id = $items->country_code;
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
				$items_product 			=  $this->it_get_woo_countries_items($type,$items_only,$id,$params);

				$month_arr='';
				$month_arr=array();
				//print_r($items_product);
				foreach($items_product as $item_product){
					$month_arr[$item_product->month_key]['total']=$item_product->total;
					$month_arr[$item_product->month_key]['qty']=$item_product->quantity;
				}


				$j=1;
				$total=0;
				$qty=0;


				foreach($this->data_month as $month_name){

					$it_table_value=$this->price(0);
					if(isset($month_arr[$month_name]['total'])){
						$it_table_value=$this->price($month_arr[$month_name]['total']);
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
					$permission_value=$this->get_form_element_value_permission('it_countries_code');
					if($this->get_form_element_permission('it_countries_code') ||  $permission_value!=''){

						if(!$this->get_form_element_permission('it_countries_code') &&  $permission_value!='')
							$col_style='display:none';
				?>

                 <div class="col-md-6" style=" <?php echo $col_style;?>">
                	<div class="awr-form-title">
						<?php _e('Country',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-globe"></i></span>
                    <?php
                        $country_data = $this->it_get_paying_woo_country();

                        $option='';
                        //$current_product=$this->it_get_woo_requests_links('it_product_id','',true);
                        //echo $current_product;

                        foreach($country_data as $country){
							$selected='';
							//CHECK IF IS IN PERMISSION
							if(is_array($permission_value) && !in_array($country->id,$permission_value))
								continue;

                            $option.="<option $selected value='".$country -> id."' >".$country -> label." </option>";
                        }
                    ?>

                    <select name="it_countries_code[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search">
                       <?php
                        	if($this->get_form_element_permission('it_countries_code') && ((!is_array($permission_value)) || (is_array($permission_value) && in_array('all',$permission_value))))
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

                <div class="col-md-6" style=" <?php echo $col_style;?>">
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

                    <select name="it_orders_status[]" multiple="multiple" size="5"  data-size="5"  class="chosen-select-search">
                        <option value="-1"><?php _e('Select All',__IT_REPORT_WCREPORT_TEXTDOMAIN__);?></option>
                        <?php
                            echo $option;
                        ?>
                    </select>
                    <input type="hidden" name="it_id_order_status[]" id="it_id_order_status" value="-1">
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
