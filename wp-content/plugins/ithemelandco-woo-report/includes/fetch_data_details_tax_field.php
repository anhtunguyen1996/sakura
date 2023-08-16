<?php
if ($file_used == "sql_table") {

    $request = array();
    $start   = 0;

    $it_from_date = $this->it_get_woo_requests('it_from_date', null, true);
    $it_to_date   = $this->it_get_woo_requests('it_to_date', null, true);
    $date_format  = $this->it_date_format($it_from_date);

    $it_id_order_status = $this->it_get_woo_requests('it_id_order_status', null, true);
    $it_paid_customer   = $this->it_get_woo_requests('it_customers_paid', null, true);
    $txtProduct         = $this->it_get_woo_requests('txtProduct', null, true);
    $it_product_id      = $this->it_get_woo_requests('it_product_id', "-1", true);
    $category_id        = $this->it_get_woo_requests('it_category_id', '-1', true);

    $brand_id = $this->it_get_woo_requests('it_brand_id', '-1', true);
    $model_id = $this->it_get_woo_requests('it_model_id', '-1', true);

    $limit = $this->it_get_woo_requests('limit', 15, true);
    $p     = $this->it_get_woo_requests('p', 1, true);

    $page         = $this->it_get_woo_requests('page', null, true);
    $order_id     = $this->it_get_woo_requests('it_id_order', null, true);
    $it_from_date = $this->it_get_woo_requests('it_from_date', null, true);
    $it_to_date   = $this->it_get_woo_requests('it_to_date', null, true);

    $it_txt_email = $this->it_get_woo_requests('it_email_text', null, true);

    $it_txt_first_name = $this->it_get_woo_requests('it_first_name_text', null, true);

    $it_detail_view     = $this->it_get_woo_requests('it_view_details', "no", true);
    $it_country_code    = $this->it_get_woo_requests('it_countries_code', null, true);
    $state_code         = $this->it_get_woo_requests('it_states_code', '-1', true);
    $it_payment_method  = $this->it_get_woo_requests('payment_method', null, true);
    $it_order_item_name = $this->it_get_woo_requests('order_item_name', null, true);//for coupon
    $it_coupon_code     = $this->it_get_woo_requests('coupon_code', null, true);//for coupon
    $it_publish_order   = $this->it_get_woo_requests('publish_order', 'no',
        true);//if publish display publish order only, no or null display all order
    $it_coupon_used     = $this->it_get_woo_requests('it_use_coupon', 'no', true);
    $it_order_meta_key  = $this->it_get_woo_requests('order_meta_key', '-1', true);
    $it_order_status    = $this->it_get_woo_requests('it_orders_status', '-1', true);
    //$it_order_status  		= "'".str_replace(",","','",$it_order_status)."'";

    $it_paid_customer = str_replace(",", "','", $it_paid_customer);
    //$it_country_code		= str_replace(",","','",$it_country_code);
    //$state_code		= str_replace(",","','",$state_code);
    //$it_country_code		= str_replace(",","','",$it_country_code);

    $it_coupon_code  = $this->it_get_woo_requests('coupon_code', '-1', true);
    $it_coupon_codes = $this->it_get_woo_requests('it_codes_of_coupon', '-1', true);

    $it_max_amount = $this->it_get_woo_requests('max_amount', '-1', true);
    $it_min_amount = $this->it_get_woo_requests('min_amount', '-1', true);

    $it_billing_post_code = $this->it_get_woo_requests('it_bill_post_code', '-1', true);
    $it_variation_id      = $this->it_get_woo_requests('variation_id', '-1', true);
    $it_variation_only    = $this->it_get_woo_requests('variation_only', '-1', true);
    $it_hide_os           = $this->it_get_woo_requests('it_hide_os', '"trash"', true);


    /////////////////////////
    //APPLY PERMISSION TERMS
    $key = $this->it_get_woo_requests('table_names', '', true);

    $category_id = $this->it_get_form_element_permission('it_category_id', $category_id, $key);

    $it_product_id = $this->it_get_form_element_permission('it_product_id', $it_product_id, $key);

    $it_country_code = $this->it_get_form_element_permission('it_countries_code', $it_country_code, $key);

    if ($it_country_code != null && $it_country_code != '-1') {
        $it_country_code = "'" . str_replace(",", "','", $it_country_code) . "'";
    }

    $state_code = $this->it_get_form_element_permission('it_states_code', $state_code, $key);

    if ($state_code != null && $state_code != '-1') {
        $state_code = "'" . str_replace(",", "','", $state_code) . "'";
    }

    $it_order_status = $this->it_get_form_element_permission('it_orders_status', $it_order_status, $key);

    if ($it_order_status != null && $it_order_status != '-1') {
        $it_order_status = "'" . str_replace(",", "','", $it_order_status) . "'";
    }

    ///////////////////////////


    $key                     = $this->it_get_woo_requests('table_names', '', true);
    $visible_custom_taxonomy = array();
    $post_name               = 'product';

    $all_tax_joins   = $all_tax_conditions = '';
    $custom_tax_cols = array();
    $all_tax         = $this->fetch_product_taxonomies($post_name);
    $current_value   = array();
    if (is_array($all_tax) && count($all_tax) > 0) {
        //FETCH TAXONOMY
        $i = 1;
        foreach ($all_tax as $tax) {

            $tax_status = get_option(__IT_REPORT_WCREPORT_FIELDS_PERFIX__ . 'set_default_search_' . $key . '_' . $tax);
            if ($tax_status == 'on') {


                $taxonomy = get_taxonomy($tax);
                $values   = $tax;
                $label    = $taxonomy->label;

                $show_column = get_option($key . '_' . $tax . "_column");
                $translate   = get_option($key . '_' . $tax . "_translate");
                if ($translate != '') {
                    $label = $translate;
                }

                if ($show_column == "on") {
                    $custom_tax_cols[] = array('lable'  => __($label, __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                               'status' => 'show'
                    );
                }


                $visible_custom_taxonomy[] = $tax;

                ${$tax} = $this->it_get_woo_requests('it_custom_taxonomy_in_' . $tax, '-1', true);


                /////////////////////////
                //APPLY PERMISSION TERMS
//					$permission_value=$this->get_form_element_value_permission($tax,$key);
//					$permission_enable=$this->get_form_element_permission($tax,$key);
//
//					if($permission_enable && ${$tax}=='-1' && $permission_value!=1){
//						${$tax}=implode(",",$permission_value);
//					}

                ${$tax} = $this->it_get_form_element_permission($tax, ${$tax}, $key);

                /////////////////////////


                //echo(${$tax});

                if (is_array(${$tax})) {
                    ${$tax} = implode(",", ${$tax});
                }

                $lbl_join = $tax . "_join";
                $lbl_con  = $tax . "_condition";

                ${$lbl_join} = '';
                ${$lbl_con}  = '';

                if (${$tax} && ${$tax} != "-1") {
                    ${$lbl_join} = "
							LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships$i 			ON it_term_relationships$i.object_id		=	woocommerce_order_itemmeta.meta_value
							LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy$i				ON term_taxonomy$i.term_taxonomy_id	=	it_term_relationships$i.term_taxonomy_id";
                    //LEFT JOIN  {$wpdb->prefix}terms 				as it_terms 						ON it_terms.term_id					=	term_taxonomy.term_id";
                }

                $all_tax_joins .= " " . ${$lbl_join} . " ";

                if (${$tax} && ${$tax} != "-1") {
                    ${$lbl_con} = " AND term_taxonomy$i.taxonomy LIKE('$tax') AND term_taxonomy$i.term_id IN (" . ${$tax} . ")";
                }

                $all_tax_conditions .= " " . ${$lbl_con} . " ";

                $i++;
            }
        }
    }


    ////////////CUSTOM FIELDS////////////
    global $wpdb;

    //GET GENERAL PRODUCT FIELDS
    $product_custom_fields          = array();
    $order_custom_fields            = array();
    $gravity_form_custom_fields     = array();
    $extra_addon_form_custom_fields = array();

    $types = $wpdb->get_results("SELECT it_postmeta.meta_key as meta_key FROM " . $wpdb->postmeta . " as it_postmeta INNER JOIN " . $wpdb->posts . " as it_post ON it_postmeta.post_id=it_post.ID where it_post.post_type='product'  GROUP BY it_postmeta.meta_key",
        ARRAY_A);

    if ($types != null && is_array($types)) {

        foreach ($types as $k => $v) {

            $product_custom_fields[] = $v['meta_key'];
        }

    }

    $types = $wpdb->get_results("SELECT it_postmeta.meta_key as meta_key FROM " . $wpdb->postmeta . " as it_postmeta INNER JOIN " . $wpdb->posts . " as it_post ON it_postmeta.post_id=it_post.ID where it_post.post_type='shop_order' GROUP BY it_postmeta.meta_key",
        ARRAY_A);


    if ($types != null && is_array($types)) {
        foreach ($types as $k => $v) {
            $order_custom_fields[] = substr($v['meta_key'], 1);
        }
    }


    /////////////GRAVITY FORM CUSTOM FIELD//////////////
    if (defined("GRAVITY_MANAGER_URL")) {
        $types = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}gf_form_meta", ARRAY_A);
        if ($types != null && is_array($types)) {
            foreach ($types as $type) {
                //print_r($type['display_meta']);
                $form = json_decode($type['display_meta']);
                //print_r($form->fields[1]->label);
                foreach ($form->fields as $fields) {
                    $value                        = ($fields->label);
                    $value                        = str_replace(" ", "_", $value);
                    $gravity_form_custom_fields[] = $value;
                }
            }
        }
    }


    if (class_exists("WC_Product_Addons")) {
        $types = $wpdb->get_results("SELECT meta_value,post_id FROM {$wpdb->prefix}postmeta where meta_key='_product_addons'",
            ARRAY_A);
        if ($types != null && is_array($types)) {
            foreach ($types as $type) {
                //print_r(unserialize ($type['meta_value']));
                $form = unserialize($type['meta_value']);
                foreach ($form as $fields) {
                    $value  = ($fields['options']);
                    $parent = $type['post_id'] . '_' . str_replace(" ", "___", $fields['name']);
//						if($fields['type']=='file_upload' || $fields['type']=='custom_textarea' )
//							continue;
                    //print_r($value);
                    foreach ($value as $ffield) {
                        $valuew      = str_replace(" ", "___", $ffield['label']);
                        $final_value = '';
                        $final_label = '';
                        if ($ffield['label'] != '') {
                            $final_value = $parent . '__' . $valuew;
                            $final_label = $parent . '__' . $ffield['label'];
                        } else {
                            $final_value = $parent;
                            $final_label = $parent;
                        }
                    }
                    $extra_addon_form_custom_fields[] = $parent;
                }
            }
        }
    }
    //print_r($extra_addon_form_custom_fields);


    $custom_fields_cols       = array();
    $order_custom_fields_cols = array();
    //print_r($order_custom_fields);
    function get_operator($op, $field)
    {
        switch ($op) {
            case 'eq':
                $operator = "= '$field'";
                break;
            case 'neq':
                $operator = "<> $field";
                break;
            case 'lt':
                $operator = "< $field";
                break;
            case 'gt':
                $operator = "> $field";
                break;
            case 'meq':
                $operator = ">= $field";
                break;
            case 'leq':
                $operator = "<= $field";
                break;
            case 'elike':
                $operator = "= '$field'";
                $ll_like  = "'";
                $rr_like  = "'";
                break;
            case 'like':
                //$operator = "LIKE '%$field' OR '$field%'";
                $operator = "LIKE '%$field%'";
                $ll_like  = "'%";
                $rr_like  = "%'";
                break;
            default:
                $operator = "= '$field'";
                break;
        }

        return $operator;
    }


    ////BUILD SQL RELAED TO GENERAL FIELDS OF PRODUCT
    $all_fields_joins = $all_fields_conditions = $all_fields_cols = '';
    $custom_fields    = get_option(__IT_REPORT_WCREPORT_FIELDS_PERFIX__ . 'set_default_fields');
    //print_r($custom_fields);
    $i = 9;

    //print_r($extra_addon_form_custom_fields);

    if (is_array($custom_fields)) {
        foreach ($custom_fields as $fields) {
            ${$fields} = $this->it_get_woo_requests('it_' . $fields, null, true);

            $show_column = get_option($fields . '_column');

            //echo ${$fields}.'_column#';

            $label = get_option($fields . '_translate');
            if ($label == '') {
                $id_fieldss = explode("_", $fields);
                $id_field   = $id_fieldss[0];
                $id_fieldss = str_replace($id_field . "_", "", $fields);
                $id_fieldss = str_replace("___", " ", $id_fieldss);
                $label      = $id_fieldss;
            }
            ///print_r($order_custom_fields_cols);
            if ($show_column == "on") {
                if (in_array($fields, $order_custom_fields)) {
                    $order_custom_fields_cols[] = array('lable'  => __($label, __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                        'status' => 'show'
                    );
                } else {

                    // SHOW FIELDS OPTIONS AS SEPARATE COLUMN
                    $id_fieldss = explode("_", $fields);
                    $id_field   = $id_fieldss[0];
                    $id_fieldss = str_replace($id_field . "_", "", $fields);
                    $types      = $wpdb->get_results("SELECT meta.meta_value FROM {$wpdb->prefix}postmeta as meta LEFT JOIN {$wpdb->prefix}postmeta as meta2 ON meta.post_id=meta2.post_id where meta2.post_id='$id_field' AND meta.meta_key='_product_addons' GROUP BY meta.meta_value",
                        ARRAY_A);

                    //echo "SELECT meta.meta_value FROM {$wpdb->prefix}postmeta as meta LEFT JOIN {$wpdb->prefix}postmeta as meta2 ON meta.post_id=meta2.post_id where meta2.post_id='$id_field' AND meta.meta_key='_product_addons' GROUP BY meta.meta_value";


                    if ($types != null && is_array($types)) {
                        foreach ($types as $type) {
                            $form = unserialize($type['meta_value']);
                            foreach ($form as $form_field) {


                                //echo $form_field['name']."=".$form_field['type'].'@@';

                                $value       = ($form_field['options']);
                                $description = ($form_field['description']);
                                $parent      = str_replace(" ", "___", $form_field['name']);
                                if ($parent != $id_fieldss) {
                                    continue;
                                }
                                $parent_label = get_the_title($type['post_id']) . ' - ' . $form_field['name'] . '(' . $form_field['type'] . ')';

                                switch ($form_field['type']) {

                                    case "custom_price" :

                                        $options = $form_field['options'];
                                        $i       = 0;
                                        foreach ($options as $opt) {
                                            if ($label == '') {
                                                $label = $form_field['name'];
                                            }
                                            $labels = $label . ' - ' . $opt['label'];

                                            $custom_fields_cols[] = array('lable'  => __($labels,
                                                __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                          'status' => 'show'
                                            );

                                        }

                                        break;

                                    case "input_multiplier" :

                                        $options = $form_field['options'];
                                        $i       = 0;
                                        foreach ($options as $opt) {
                                            if ($label == '') {
                                                $label = $form_field['name'];
                                            }
                                            $labels = $label . ' - ' . $opt['label'];

                                            $custom_fields_cols[] = array('lable'  => __($labels,
                                                __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                          'status' => 'show'
                                            );
                                        }


                                        break;

                                    case "checkbox" :

                                        if ($label == '') {
                                            $label = $form_field['name'];
                                        }

                                        $custom_fields_cols[] = array('lable'  => __($label,
                                            __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                      'status' => 'show'
                                        );

                                        break;

                                    //NOT INCLUDE IN SEARCH FIELDS
                                    case "custom_textarea" :

                                        $options = $form_field['options'];
                                        $i       = 0;
                                        foreach ($options as $opt) {
                                            if ($label == '') {
                                                $label = $form_field['name'];
                                            }
                                            $labels = $label . ' - ' . $opt['label'];

                                            $custom_fields_cols[] = array('lable'  => __($labels,
                                                __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                          'status' => 'show'
                                            );
                                        }
                                        break;

                                    case "custom" :
                                        $options = $form_field['options'];
                                        $i       = 0;
                                        foreach ($options as $opt) {
                                            if ($label == '') {
                                                $label = $form_field['name'];
                                            }
                                            $labels = $label . ' - ' . $opt['label'];

                                            $custom_fields_cols[] = array('lable'  => __($labels,
                                                __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                          'status' => 'show'
                                            );
                                        }
                                        break;

                                    case "custom_email" :
                                        $options = $form_field['options'];
                                        $i       = 0;
                                        foreach ($options as $opt) {
                                            if ($label == '') {
                                                $label = $form_field['name'];
                                            }
                                            $labels = $label . ' - ' . $opt['label'];

                                            $custom_fields_cols[] = array('lable'  => __($labels,
                                                __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                          'status' => 'show'
                                            );
                                        }
                                        break;

                                    case "custom_letters_only" :
                                        $options = $form_field['options'];
                                        $i       = 0;
                                        foreach ($options as $opt) {
                                            if ($label == '') {
                                                $label = $form_field['name'];
                                            }
                                            $labels = $label . ' - ' . $opt['label'];

                                            $custom_fields_cols[] = array('lable'  => __($labels,
                                                __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                          'status' => 'show'
                                            );
                                        }
                                        break;

                                    case "custom_letters_or_digits" :
                                        $options = $form_field['options'];
                                        $i       = 0;
                                        foreach ($options as $opt) {
                                            if ($label == '') {
                                                $label = $form_field['name'];
                                            }
                                            $labels = $label . ' - ' . $opt['label'];

                                            $custom_fields_cols[] = array('lable'  => __($labels,
                                                __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                          'status' => 'show'
                                            );
                                        }
                                        break;

                                    case "custom_digits_only" :
                                        $options = $form_field['options'];
                                        $i       = 0;
                                        foreach ($options as $opt) {
                                            if ($label == '') {
                                                $label = $form_field['name'];
                                            }
                                            $labels = $label . ' - ' . $opt['label'];

                                            $custom_fields_cols[] = array('lable'  => __($labels,
                                                __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                          'status' => 'show'
                                            );
                                        }
                                        break;

                                    case "radiobutton" :
                                        if ($label == '') {
                                            $label = $form_field['name'];
                                        }

                                        $custom_fields_cols[] = array('lable'  => __($label,
                                            __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                      'status' => 'show'
                                        );
                                        break;

                                    case "custom_text" :
                                        $display = $form_field['restrictions_type'];

                                        switch ($display) {

                                            case 'any_text':
                                                $options = $form_field['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {

                                                }
                                                if ($label == '') {
                                                    $label = $form_field['name'];
                                                }
                                                $labels = $label;

                                                $custom_fields_cols[] = array('lable'  => __($labels,
                                                    __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                              'status' => 'show'
                                                );

                                                break;

                                            case 'only_letters':
                                                $options = $form_field['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {

                                                }

                                                if ($label == '') {
                                                    $label = $form_field['name'];
                                                }
                                                $labels = $label;

                                                $custom_fields_cols[] = array('lable'  => __($labels,
                                                    __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                              'status' => 'show'
                                                );
                                                break;

                                            case 'only_numbers':
                                                $options = $form_field['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {

                                                }

                                                if ($label == '') {
                                                    $label = $form_field['name'];
                                                }
                                                $labels = $label;

                                                $custom_fields_cols[] = array('lable'  => __($labels,
                                                    __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                              'status' => 'show'
                                                );
                                                break;

                                            case 'only_letters_numbers':
                                                $options = $form_field['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {

                                                }

                                                if ($label == '') {
                                                    $label = $form_field['name'];
                                                }
                                                $labels = $label;

                                                $custom_fields_cols[] = array('lable'  => __($labels,
                                                    __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                              'status' => 'show'
                                                );
                                                break;

                                            case 'email':
                                                $options = $form_field['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {

                                                }
                                                if ($label == '') {
                                                    $label = $form_field['name'];
                                                }
                                                $labels = $label;

                                                $custom_fields_cols[] = array('lable'  => __($labels,
                                                    __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                              'status' => 'show'
                                                );
                                                break;

                                        }

                                        break;

                                    case "multiple_choice" :

                                        if ($form_field['display'] == 'radiobutton') {

                                            //display
                                            if ($label == '') {
                                                $label = $form_field['name'];
                                            }

                                            $custom_fields_cols[] = array(
                                                'lable'  => __($label, __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                'status' => 'show'
                                            );
                                        }


                                        if ($form_field['display'] == 'select') {

                                            //display
                                            if ($label == '') {
                                                $label = $form_field['name'];
                                            }

                                            $custom_fields_cols[] = array(
                                                'lable'  => __($label, __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                'status' => 'show'
                                            );
                                        }
                                        break;

                                    case "select" :

                                        if ($label == '') {
                                            $label = $form_field['name'];
                                        }

                                        $custom_fields_cols[] = array('lable'  => __($label,
                                            __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                      'status' => 'show'
                                        );

                                        break;

                                    case "file_upload" :

                                        if ($label == '') {
                                            $label = $form_field['name'];
                                        }

                                        $custom_fields_cols[] = array('lable'  => __($label,
                                            __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                                      'status' => 'show'
                                        );

                                        break;

                                }

                            }
                        }
                    } else {
                        $custom_fields_cols[] = array('lable'  => __($label, __IT_REPORT_WCREPORT_TEXTDOMAIN__),
                                                      'status' => 'show'
                        );
                    }


                }
            }


            if (is_array($gravity_form_custom_fields) && in_array($fields, $gravity_form_custom_fields)) {
                continue;
            }

            //$cond_field=str_replace("___"," ",$fields);
            if (is_array($extra_addon_form_custom_fields) && in_array($fields, $extra_addon_form_custom_fields)) {
                continue;
            }

//			echo '[['.$fields.']]';
            $operator           = get_option($fields . '_operator');
            $operator_condition = get_operator($operator, ${$fields});

            $lbl_join = $fields . "_join";
            $lbl_con  = $fields . "_condition";
            $lbl_col  = $fields . "_col";


            ${$lbl_join} = '';
            ${$lbl_con}  = '';
            ${$lbl_col}  = '';

            if (${$fields}) {

            }


            if (in_array($fields, $product_custom_fields)) {
                ${$lbl_col} = " postmeta$i.meta_value as $fields , ";

                ${$lbl_join} = " LEFT JOIN  {$wpdb->prefix}postmeta as postmeta$i ON postmeta$i.post_id=woocommerce_order_itemmeta.meta_value";

                ${$lbl_con} = " AND postmeta$i.meta_key='$fields' ";
            }

            if (${$fields} && in_array($fields, $product_custom_fields)) {
            }

            if (in_array($fields, $order_custom_fields)) {
                if (${$fields} && in_array($fields, $order_custom_fields)) {
                    ${$lbl_col} = " postmeta$i.meta_value as $fields , ";

                    ${$lbl_join} = " LEFT JOIN  {$wpdb->prefix}postmeta as postmeta$i ON postmeta$i.post_id=it_woocommerce_order_items.order_id";
                }
            }

            if (${$fields}) {

            }

            $all_fields_cols  .= " " . ${$lbl_col} . " ";
            $all_fields_joins .= " " . ${$lbl_join} . " ";

            if (${$fields}) {

                ${$lbl_con} .= " AND postmeta$i.meta_value $operator_condition ";
            }

            $all_fields_conditions .= " " . ${$lbl_con} . " ";

            $i++;

        }

    }


    //GRAVITY FROM Query
    //$all_fields_conditions=$all_fields_cols=$all_fields_joins='';
    if (is_array($custom_fields)) {
        foreach ($custom_fields as $extra_fields) {

            if ( ! is_array($gravity_form_custom_fields) || ! in_array($extra_fields, $gravity_form_custom_fields)) {
                continue;
            }

            ${$extra_fields} = $this->it_get_woo_requests('it_' . $extra_fields, null, true);

            $db_fields = str_replace("_", "", $extra_fields);

            if (strpos(${$extra_fields}, ",")) {
                ${$extra_fields} = str_replace(",", ", ", ${$extra_fields});
            }

            //echo '[['.$extra_fields.']][['.${$extra_fields}.']]';

            $lbl_join = $db_fields . "_join";
            $lbl_con  = $db_fields . "_condition";
            $lbl_col  = $db_fields . "_col";

            ${$lbl_join} = '';
            ${$lbl_con}  = '';
            ${$lbl_col}  = '';

            $show_column = get_option($extra_fields . '_column');


            $operator           = get_option($extra_fields . '_operator');
            $operator_condition = get_operator($operator, ${$extra_fields});


            if (${$extra_fields}) {
                if ($show_column == 'on') {
                    ${$lbl_col}  = " pwoocommerce_order_itemmeta$i.meta_value as $db_fields , ";
                    ${$lbl_join} = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as pwoocommerce_order_itemmeta$i ON pwoocommerce_order_itemmeta$i.order_item_id=it_woocommerce_order_items.order_item_id";
                }
                $val        = ${$extra_fields};
                $db_fields  = str_replace("___", " ", $extra_fields);
                $db_fields  = str_replace("_", " ", $extra_fields);
                ${$lbl_con} = " AND pwoocommerce_order_itemmeta$i.meta_key='$db_fields' AND pwoocommerce_order_itemmeta$i.meta_value $operator_condition";
            } else {
                //${$lbl_con} = " AND pwoocommerce_order_itemmeta$i.meta_key='$db_fields' ";
            }

            $all_fields_cols       .= " " . ${$lbl_col} . " ";
            $all_fields_joins      .= " " . ${$lbl_join} . " ";
            $all_fields_conditions .= ${$lbl_con};
            $i++;
        }
    }


//	echo $all_fields_cols;
//	echo $all_fields_joins;
//	echo $all_fields_conditions;
    //$all_fields_conditions=$all_fields_cols=$all_fields_joins='';


    //$all_fields_conditions=$all_fields_cols=$all_fields_joins='';
    //PRODUCT ADD-0N Query
    if (is_array($custom_fields)) {
        foreach ($custom_fields as $extra_fields) {

            if ( ! is_array($extra_addon_form_custom_fields) || ! in_array($extra_fields,
                    $extra_addon_form_custom_fields)) {
                continue;
            }

            ${$extra_fields} = $this->it_get_woo_requests('it_' . $extra_fields, null, true);

            $db_fields = explode("_", $extra_fields, 2);
            $db_fields = $db_fields[1];

            //echo '[['.$extra_fields.']][['.${$extra_fields}.']]';

            $lbl_join = $db_fields . "_join";
            $lbl_con  = $db_fields . "_condition";
            $lbl_col  = $db_fields . "_col";

            ${$lbl_join} = '';
            ${$lbl_con}  = '';
            ${$lbl_col}  = '';

            $show_column = get_option($extra_fields . '_column');


            $operator           = get_option($extra_fields . '_operator');
            $operator_condition = get_operator($operator, ${$extra_fields});


            if (${$extra_fields}) {
                if ($show_column == 'on') {
                    ${$lbl_col}  = " pwoocommerce_order_itemmeta$i.meta_value as $db_fields , ";
                    ${$lbl_join} = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as pwoocommerce_order_itemmeta$i ON pwoocommerce_order_itemmeta$i.order_item_id=it_woocommerce_order_items.order_item_id";
                }
                $val        = ${$extra_fields};
                $db_fields  = str_replace("___", " ", $db_fields);
                ${$lbl_con} = " AND pwoocommerce_order_itemmeta$i.meta_key='$db_fields' AND pwoocommerce_order_itemmeta$i.meta_value $operator_condition";
            } else {
                //${$lbl_con} = " AND pwoocommerce_order_itemmeta$i.meta_key='$db_fields' ";
            }

            $all_fields_cols       .= " " . ${$lbl_col} . " ";
            $all_fields_joins      .= " " . ${$lbl_join} . " ";
            $all_fields_conditions .= ${$lbl_con};
            $i++;
        }
    }


//	echo $all_fields_cols;
//	echo $all_fields_joins;
//	echo $all_fields_conditions;
    //$all_fields_conditions=$all_fields_cols=$all_fields_joins='';

    ///////////HIDDEN FIELDS////////////
    $it_hide_os         = $this->otder_status_hide;
    $it_publish_order   = 'no';
    $it_order_item_name = '';
    $it_coupon_code     = '';
    $it_coupon_codes    = '';
    $it_payment_method  = '';

    $it_variation_only = $this->it_get_woo_requests('variation_only', '-1', true);
    $it_order_meta_key = '';

    $data_format = $this->it_get_woo_requests('date_format', get_option('date_format'), true);


    $it_variation_id = '-1';
    $amont_zero      = '';
    //////////////////////


    $it_variations_formated = '';

    if (strlen($it_max_amount) <= 0) {
        $_REQUEST['max_amount'] = $it_max_amount = '-1';
    }
    if (strlen($it_min_amount) <= 0) {
        $_REQUEST['min_amount'] = $it_min_amount = '-1';
    }

    if ($it_max_amount != '-1' || $it_min_amount != '-1') {
        if ($it_order_meta_key == '-1') {
            $_REQUEST['order_meta_key'] = "_order_total";
        }
    }

    $last_days_orders = "0";
    if (is_array($it_id_order_status)) {
        $it_id_order_status = implode(",", $it_id_order_status);
    }
    if (is_array($category_id)) {
        $category_id = implode(",", $category_id);
    }

    if (is_array($brand_id)) {
        $brand_id = implode(",", $brand_id);
    }
    if (is_array($model_id)) {
        $model_id = implode(",", $model_id);
    }

    if ( ! $it_from_date) {
        $it_from_date = date_i18n('Y-m-d');
    }
    if ( ! $it_to_date) {
        $last_days_orders = apply_filters($page . '_back_day', $last_days_orders);//-1,-2,-3,-4,-5
        $it_to_date       = date('Y-m-d', strtotime($last_days_orders . ' day', strtotime(date_i18n("Y-m-d"))));
    }

    $it_sort_by  = $this->it_get_woo_requests('sort_by', 'order_id', true);
    $it_order_by = $this->it_get_woo_requests('order_by', 'DESC', true);
    ///

    if ($p > 1) {
        $start = ($p - 1) * $limit;
    }

    if ($it_detail_view == "yes") {
        $it_variations_value    = $this->it_get_woo_requests('variations_value', "-1", true);
        $it_variations_formated = '-1';
        if ($it_variations_value != "-1" and strlen($it_variations_value) > 0) {
            $it_variations_value = explode(",", $it_variations_value);
            $var                 = array();
            foreach ($it_variations_value as $key => $value):
                $var[] .= $value;
            endforeach;
            $result = array_unique($var);
            //$this->print_array($var);
            $it_variations_formated = implode("', '", $result);
        }
        $_REQUEST['variations_formated'] = $it_variations_formated;
    }


    //it_first_name_text
    $it_txt_first_name_cols        = '';
    $it_txt_first_name_join        = '';
    $it_txt_first_name_condition_1 = '';
    $it_txt_first_name_condition_2 = '';

    //it_email_text
    $it_txt_email_cols        = '';
    $it_txt_email_join        = '';
    $it_txt_email_condition_1 = '';
    $it_txt_email_condition_2 = '';

    //SORT BY
    $it_sort_by_cols = '';

    //CATEGORY
    $category_id_join      = '';
    $category_id_condition = '';

    //BRAND
    $brand_id_join      = '';
    $brand_id_condition = '';

    //MODEL
    $model_id_join      = '';
    $model_id_condition = '';

    //ORDER ID
    $it_id_order_status_join      = '';
    $it_id_order_status_condition = '';

    //COUNTRY
    $it_country_code_join        = '';
    $it_country_code_condition_1 = '';
    $it_country_code_condition_2 = '';

    //STATE
    $state_code_join        = '';
    $state_code_condition_1 = '';
    $state_code_condition_2 = '';

    //PAYMENT METHOD
    $it_payment_method_join        = '';
    $it_payment_method_condition_1 = '';
    $it_payment_method_condition_2 = '';

    //POSTCODE
    $it_billing_post_code_join      = '';
    $it_billing_post_code_condition = '';

    //COUPON USED
    $it_coupon_used_join      = '';
    $it_coupon_used_condition = '';

    //VARIATION ID
    $it_variation_id_join      = '';
    $it_variation_id_condition = '';

    //VARIATION ONLY
    $it_variation_only_join      = '';
    $it_variation_only_condition = '';

    //VARIATION FORMAT
    $it_variations_formated_join      = '';
    $it_variations_formated_condition = '';

    //ORDER META KEY
    $it_order_meta_key_join      = '';
    $it_order_meta_key_condition = '';

    //COUPON CODES
    $it_coupon_codes_join      = '';
    $it_coupon_codes_condition = '';

    //COUPON CODE
    $it_coupon_code_condition = '';

    //DATA CONDITION
    $date_condition = '';

    //ORDER ID
    $order_id_condition = '';

    //PAID CUSTOMER
    $it_paid_customer_condition = '';

    //PUBLISH ORDER
    $it_publish_order_condition_1 = '';
    $it_publish_order_condition_2 = '';

    //ORDER ITEM NAME
    $it_order_item_name_condition = '';

    //txt PRODUCT
    $txtProduct_condition = '';

    //PRODUCT ID
    $it_product_id_condition = '';

    //CATEGORY ID
    $category_id_condition = '';

    //BRAND ID
    $brand_id_condition = '';
    $model_id_condition = '';

    //ORDER STATUS ID
    $it_id_order_status_condition = '';

    //ORDER STATUS
    $it_order_status_condition = '';

    //HIDE ORDER STATUS
    $it_hide_os_condition = '';


    if (($it_txt_first_name and $it_txt_first_name != '-1') || $it_sort_by == "billing_name") {
        $it_txt_first_name_cols = " CONCAT(it_postmeta1.meta_value, ' ', it_postmeta2.meta_value) AS billing_name,";
    }
    if ($it_txt_email || ($it_paid_customer && $it_paid_customer != '-1' and $it_paid_customer != "'-1'") || $it_sort_by == "billing_email") {
        $it_txt_email_cols = " postmeta.meta_value AS billing_email,";
    }

    if ($it_sort_by == "status") {
        $it_sort_by_cols = " terms2.name as status, ";
    }
    $sql_columns = " $it_txt_first_name_cols $it_txt_email_cols $it_sort_by_cols";
    $sql_columns .= "
		DATE_FORMAT(it_posts.post_date,'%m/%d/%Y') 													AS order_date,
		it_woocommerce_order_items.order_id 															AS order_id,
		it_woocommerce_order_items.order_item_name 													AS product_name,
		it_woocommerce_order_items.order_item_id														AS order_item_id,
		woocommerce_order_itemmeta.meta_value 														AS woocommerce_order_itemmeta_meta_value,
		(it_woocommerce_order_itemmeta2.meta_value/it_woocommerce_order_itemmeta3.meta_value) 			AS sold_rate,
		(it_woocommerce_order_itemmeta4.meta_value/it_woocommerce_order_itemmeta3.meta_value) 			AS product_rate,
		(it_woocommerce_order_itemmeta4.meta_value) 													AS item_amount,
		(it_woocommerce_order_itemmeta2.meta_value) 													AS item_net_amount,
		(it_woocommerce_order_itemmeta4.meta_value - it_woocommerce_order_itemmeta2.meta_value) 			AS item_discount,
		it_woocommerce_order_itemmeta2.meta_value 														AS total_price,
		count(it_woocommerce_order_items.order_item_id) 												AS product_quentity,
		woocommerce_order_itemmeta.meta_value 														AS product_id
		,it_woocommerce_order_itemmeta3.meta_value 													AS 'product_quantity'
		,it_posts.post_status 																			AS post_status
		,it_posts.post_status 																			AS order_status

		";

    $sql_joins = "{$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_items

		LEFT JOIN  {$wpdb->prefix}posts as it_posts ON it_posts.ID=it_woocommerce_order_items.order_id

		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as woocommerce_order_itemmeta 	ON woocommerce_order_itemmeta.order_item_id		=	it_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta2 	ON it_woocommerce_order_itemmeta2.order_item_id	=	it_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta3 	ON it_woocommerce_order_itemmeta3.order_item_id	=	it_woocommerce_order_items.order_item_id
		LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta4 	ON it_woocommerce_order_itemmeta4.order_item_id	=	it_woocommerce_order_items.order_item_id AND it_woocommerce_order_itemmeta4.meta_key='_line_subtotal'";


    if ($category_id && $category_id != "-1") {
        $category_id_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships 			ON it_term_relationships.object_id		=	woocommerce_order_itemmeta.meta_value
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy 				ON term_taxonomy.term_taxonomy_id	=	it_term_relationships.term_taxonomy_id";
        //LEFT JOIN  {$wpdb->prefix}terms 				as it_terms 						ON it_terms.term_id					=	term_taxonomy.term_id";
    }

    if ($brand_id && $brand_id != "-1") {
        $brand_id_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships1 			ON it_term_relationships1.object_id		=	woocommerce_order_itemmeta.meta_value
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy1				ON term_taxonomy1.term_taxonomy_id	=	it_term_relationships1.term_taxonomy_id";
        //LEFT JOIN  {$wpdb->prefix}terms 				as it_terms 						ON it_terms.term_id					=	term_taxonomy.term_id";
    }
    if ($model_id && $model_id != "-1") {
        $model_id_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships2 			ON it_term_relationships2.object_id		=	woocommerce_order_itemmeta.meta_value
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as term_taxonomy2				ON term_taxonomy2.term_taxonomy_id	=	it_term_relationships2.term_taxonomy_id";
        //LEFT JOIN  {$wpdb->prefix}terms 				as it_terms 						ON it_terms.term_id					=	term_taxonomy.term_id";
    }

    if (($it_id_order_status && $it_id_order_status != '-1') || $it_sort_by == "status") {
        $it_id_order_status_join = "
				LEFT JOIN  {$wpdb->prefix}term_relationships 	as it_term_relationships2			ON it_term_relationships2.object_id	= it_woocommerce_order_items.order_id
				LEFT JOIN  {$wpdb->prefix}term_taxonomy 		as it_term_taxonomy2				ON it_term_taxonomy2.term_taxonomy_id	= it_term_relationships2.term_taxonomy_id";
        if ($it_sort_by == "status") {
            $it_id_order_status_join .= " LEFT JOIN  {$wpdb->prefix}terms 	as terms2 						ON terms2.term_id					=	it_term_taxonomy2.term_id";
        }
    }

    if ($it_txt_email || ($it_paid_customer && $it_paid_customer != '-1' and $it_paid_customer != "'-1'") || $it_sort_by == "billing_email") {
        $it_txt_email_join = "
				LEFT JOIN  {$wpdb->prefix}postmeta as postmeta ON postmeta.post_id=it_woocommerce_order_items.order_id";
    }
    if (($it_txt_first_name and $it_txt_first_name != '-1') || $it_sort_by == "billing_name") {
        $it_txt_first_name_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta1 ON it_postmeta1.post_id=it_woocommerce_order_items.order_id
			LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta2 ON it_postmeta2.post_id=it_woocommerce_order_items.order_id";
    }

    if ($it_country_code and $it_country_code != '-1') {
        $it_country_code_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta4 ON it_postmeta4.post_id=it_woocommerce_order_items.order_id";
    }

    if ($state_code && $state_code != '-1') {
        $state_code_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta_billing_state ON it_postmeta_billing_state.post_id=it_posts.ID";
    }

    if ($it_payment_method) {
        $it_payment_method_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta5 ON it_postmeta5.post_id=it_woocommerce_order_items.order_id";
    }

    if ($it_billing_post_code and $it_billing_post_code != '-1') {
        $it_billing_post_code_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta_billing_postcode ON it_postmeta_billing_postcode.post_id	=	it_posts.ID";
    }

    if ($it_coupon_used == "yes") {
        $it_coupon_used_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta6 ON it_postmeta6.post_id=it_woocommerce_order_items.order_id";
    }

    if ($it_coupon_used == "yes") {
        $it_coupon_used_join .= " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta7 ON it_postmeta7.post_id=it_posts.ID";
    }

    if ($it_variation_id && $it_variation_id != "-1") {
        $it_variation_id_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta_variation			ON it_woocommerce_order_itemmeta_variation.order_item_id 		= 	it_woocommerce_order_items.order_item_id";
    }

    if ($it_variation_only && $it_variation_only != "-1" && $it_variation_only == "1") {
        $it_variation_only_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta 	as it_woocommerce_order_itemmeta_variation			ON it_woocommerce_order_itemmeta_variation.order_item_id 		= 	it_woocommerce_order_items.order_item_id";
    }

    if ($it_variations_formated != "-1" and $it_variations_formated != null) {
        $it_variations_formated_join = " LEFT JOIN  {$wpdb->prefix}woocommerce_order_itemmeta as it_woocommerce_order_itemmeta8 ON it_woocommerce_order_itemmeta8.order_item_id = it_woocommerce_order_items.order_item_id";
        $it_variations_formated_join .= " LEFT JOIN  {$wpdb->prefix}postmeta as it_postmeta_variation ON it_postmeta_variation.post_id = it_woocommerce_order_itemmeta8.meta_value";
    }

    if ($it_order_meta_key and $it_order_meta_key != '-1') {
        $it_order_meta_key_join = " LEFT JOIN  {$wpdb->prefix}postmeta as it_order_meta_key ON it_order_meta_key.post_id=it_posts.ID";
    }

    if (($it_coupon_codes && $it_coupon_codes != "-1") or ($it_coupon_code && $it_coupon_code != "-1")) {
        $it_coupon_codes_join = " LEFT JOIN {$wpdb->prefix}woocommerce_order_items as it_woocommerce_order_coupon_item ON it_woocommerce_order_coupon_item.order_id = it_posts.ID AND it_woocommerce_order_coupon_item.order_item_type = 'coupon'";
    }


    $post_type_condition = "it_posts.post_type = 'shop_order'";


    if ($it_txt_email || ($it_paid_customer && $it_paid_customer != '-1' and $it_paid_customer != "'-1'") || $it_sort_by == "billing_email") {
        $it_txt_email_condition_1 = "
				AND postmeta.meta_key='_billing_email'";
    }

    if (($it_txt_first_name and $it_txt_first_name != '-1') || $it_sort_by == "billing_name") {
        $it_txt_first_name_condition_1 = "
				AND it_postmeta1.meta_key='_billing_first_name'
				AND it_postmeta2.meta_key='_billing_last_name'";
    }

    $other_condition_1 = "
		AND (woocommerce_order_itemmeta.meta_key = '_product_id' OR woocommerce_order_itemmeta.meta_key = '_variation_id')
		AND it_woocommerce_order_itemmeta2.meta_key='_line_total'
		AND it_woocommerce_order_itemmeta3.meta_key='_qty' ";


    if ($it_country_code and $it_country_code != '-1') {
        $it_country_code_condition_1 = " AND it_postmeta4.meta_key='_billing_country'";
    }

    if ($state_code && $state_code != '-1') {
        $state_code_condition_1 = " AND it_postmeta_billing_state.meta_key='_billing_state'";
    }

    if ($it_billing_post_code and $it_billing_post_code != '-1') {
        $it_billing_post_code_condition = " AND it_postmeta_billing_postcode.meta_key='_billing_postcode' AND it_postmeta_billing_postcode.meta_value LIKE '%{$it_billing_post_code}%' ";
    }

    if ($it_payment_method) {
        $it_payment_method_condition_1 = " AND it_postmeta5.meta_key='_payment_method_title'";
    }

    if ($it_from_date != null && $it_to_date != null) {
        $date_condition = " AND DATE(it_posts.post_date) BETWEEN STR_TO_DATE('" . $it_from_date . "', '$date_format') and STR_TO_DATE('" . $it_to_date . "', '$date_format')";
    }

    if ($order_id) {
        $order_id_condition = " AND it_woocommerce_order_items.order_id = " . $order_id;
    }

    if ($it_txt_email) {
        $it_txt_email_condition_2 = " AND postmeta.meta_value LIKE '%" . $it_txt_email . "%'";
    }

    if ($it_paid_customer && $it_paid_customer != '-1' and $it_paid_customer != "'-1'") {
        $it_paid_customer_condition = " AND postmeta.meta_value IN ('" . $it_paid_customer . "')";
    }

    //if($it_txt_first_name and $it_txt_first_name != '-1') $sql .= " AND (it_postmeta1.meta_value LIKE '%".$it_txt_first_name."%' OR it_postmeta2.meta_value LIKE '%".$it_txt_first_name."%')";
    if ($it_txt_first_name and $it_txt_first_name != '-1') {
        $it_txt_first_name_condition_2 = " AND (lower(concat_ws(' ', it_postmeta1.meta_value, it_postmeta2.meta_value)) like lower('%" . $it_txt_first_name . "%') OR lower(concat_ws(' ', it_postmeta2.meta_value, it_postmeta1.meta_value)) like lower('%" . $it_txt_first_name . "%'))";
    }

    //if($it_id_order_status  && $it_id_order_status != "-1") $sql .= " AND terms2.term_id IN (".$it_id_order_status .")";

    if ($it_publish_order == 'yes') {
        $it_publish_order_condition_1 = " AND it_posts.post_status = 'publish'";
    }

    if ($it_publish_order == 'publish' || $it_publish_order == 'trash') {
        $it_publish_order_condition_2 = " AND it_posts.post_status = '" . $it_publish_order . "'";
    }

    //if($it_country_code and $it_country_code != '-1')	$sql .= " AND it_postmeta4.meta_value LIKE '%".$it_country_code."%'";

    //if($state_code and $state_code != '-1')	$sql .= " AND it_postmeta_billing_state.meta_value LIKE '%".$state_code."%'";

    if ($it_country_code and $it_country_code != '-1') {
        $it_country_code_condition_2 = " AND it_postmeta4.meta_value IN (" . $it_country_code . ")";
    }

    if ($state_code && $state_code != '-1') {
        $state_code_condition_2 = " AND it_postmeta_billing_state.meta_value IN (" . $state_code . ")";
    }

    if ($it_payment_method) {
        $it_payment_method_condition_2 = " AND it_postmeta5.meta_value LIKE '%" . $it_payment_method . "%'";
    }

    if ($it_order_meta_key and $it_order_meta_key != '-1') {
        $it_order_meta_key_condition = " AND it_order_meta_key.meta_key='{$it_order_meta_key}' AND it_order_meta_key.meta_value > 0";
    }

    if ($it_order_item_name) {
        $it_order_item_name_condition = " AND it_woocommerce_order_items.order_item_name LIKE '%" . $it_order_item_name . "%'";
    }

    if ($txtProduct && $txtProduct != '-1') {
        $txtProduct_condition = " AND it_woocommerce_order_items.order_item_name LIKE '%" . $txtProduct . "%'";
    }

    if ($it_product_id && $it_product_id != "-1") {
        $it_product_id_condition = " AND woocommerce_order_itemmeta.meta_value IN (" . $it_product_id . ")";
    }

    //if($category_id  && $category_id != "-1") $sql .= " AND it_terms.name NOT IN('simple','variable','grouped','external') AND term_taxonomy.taxonomy LIKE('product_cat') AND term_taxonomy.term_id IN (".$category_id .")";
    if ($category_id && $category_id != "-1") {
        $category_id_condition = " AND term_taxonomy.taxonomy LIKE('product_cat') AND term_taxonomy.term_id IN (" . $category_id . ")";
    }

    if ($brand_id && $brand_id != "-1") {
        $brand_id_condition = " AND term_taxonomy1.taxonomy LIKE('product_brand') AND term_taxonomy1.term_id IN (" . $brand_id . ")";
    }
    if ($model_id && $model_id != "-1") {
        $model_id_condition = " AND term_taxonomy2.taxonomy LIKE('product_model') AND term_taxonomy2.term_id IN (" . $model_id . ")";
    }


    if ($it_id_order_status && $it_id_order_status != "-1") {
        $it_id_order_status_condition = " AND it_term_taxonomy2.taxonomy LIKE('shop_order_status') AND it_term_taxonomy2.term_id IN (" . $it_id_order_status . ")";
    }

    if ($it_coupon_used == "yes") {
        $it_coupon_used_condition = " AND( (it_postmeta6.meta_key='_order_discount' AND it_postmeta6.meta_value > 0) ||  (it_postmeta7.meta_key='_cart_discount' AND it_postmeta7.meta_value > 0))";
    }


    if ($it_coupon_code && $it_coupon_code != "-1") {
        $it_coupon_code_condition = " AND (it_woocommerce_order_coupon_item.order_item_name IN ('{$it_coupon_code}') OR it_woocommerce_order_coupon_item.order_item_name LIKE '%{$it_coupon_code}%')";
    }

    if ($it_coupon_codes && $it_coupon_codes != "-1") {
        $it_coupon_codes_condition = " AND it_woocommerce_order_coupon_item.order_item_name IN ({$it_coupon_codes})";
    }

    if ($it_variation_id && $it_variation_id != "-1") {
        $it_variation_id_condition = " AND it_woocommerce_order_itemmeta_variation.meta_key = '_variation_id' AND it_woocommerce_order_itemmeta_variation.meta_value IN (" . $it_variation_id . ")";
    }

    if ($it_variation_only && $it_variation_only != "-1" && $it_variation_only == "1") {
        $it_variation_only_condition = " AND it_woocommerce_order_itemmeta_variation.meta_key 	= '_variation_id'
			AND (it_woocommerce_order_itemmeta_variation.meta_value IS NOT NULL AND it_woocommerce_order_itemmeta_variation.meta_value > 0)";
    }


    if ($it_variations_formated != "-1" and $it_variations_formated != null) {
        $it_variations_formated_condition = "
			AND it_woocommerce_order_itemmeta8.meta_key = '_variation_id' AND (it_woocommerce_order_itemmeta8.meta_value IS NOT NULL AND it_woocommerce_order_itemmeta8.meta_value > 0)";
        $it_variations_formated_condition .= "
			AND it_postmeta_variation.meta_value IN ('{$it_variations_formated}')";
    }

    if ($it_order_status && $it_order_status != '-1' and $it_order_status != "'-1'") {
        $it_order_status_condition = " AND it_posts.post_status IN (" . $it_order_status . ")";
    }

    if ($it_hide_os && $it_hide_os != '-1' and $it_hide_os != "'-1'") {
        $it_hide_os_condition = " AND it_posts.post_status NOT IN ('" . $it_hide_os . "')";
    }


    $sql = "SELECT $all_fields_cols $sql_columns FROM $sql_joins";

    $sql .= "$category_id_join  $all_tax_joins $it_id_order_status_join $it_txt_email_join $it_txt_first_name_join $all_fields_joins
				$it_country_code_join $state_code_join $it_payment_method_join $it_billing_post_code_join
				$it_coupon_used_join $it_variation_id_join $it_variation_only_join $it_variations_formated_join
				$it_order_meta_key_join $it_coupon_codes_join";

    $sql .= " Where $post_type_condition  $all_fields_conditions $it_txt_email_condition_1 $it_txt_first_name_condition_1
						$other_condition_1 $it_country_code_condition_1 $state_code_condition_1
						$it_billing_post_code_condition $it_payment_method_condition_1 $date_condition
						$order_id_condition $it_txt_email_condition_2 $it_paid_customer_condition
						$it_txt_first_name_condition_2 $it_publish_order_condition_1 $it_publish_order_condition_2
						$it_country_code_condition_2 $state_code_condition_2 $it_payment_method_condition_2
						$it_order_meta_key_condition $it_order_item_name_condition $txtProduct_condition
						$it_product_id_condition $category_id_condition $all_tax_conditions  $it_id_order_status_condition
						$it_coupon_used_condition $it_coupon_code_condition $it_coupon_codes_condition
						$it_variation_id_condition $it_variation_only_condition $it_variations_formated_condition
						$it_order_status_condition $it_hide_os_condition ";

    $sql_group_by = " GROUP BY it_woocommerce_order_items.order_item_id ";

    $sql_order_by = " ORDER BY {$it_sort_by} {$it_order_by}";

    $sql .= $sql_group_by . $sql_order_by;

    //print_r($search_fields);
    //echo $sql;
    //print_r($custom_tax_cols);


    if ($it_detail_view == "yes") {

        $columns = array(
            array('lable' => esc_html__('Order ID', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Name', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Email', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Date', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Status', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Coupon Code', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Products', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Category', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('SKU', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Variation', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Qty.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Rate', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Prod. Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Prod. Discount', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Net Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            ////ADDE IN VER4.0
            /// INVOICE ACTION
            array('lable' => esc_html__('Invoice Action', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            /*array('lable'=>esc_html__('Order Detail',__IT_REPORT_WCREPORT_TEXTDOMAIN__),'status'=>'show'),*/
        );

        $product_custom_fields          = array();
        $order_custom_fields            = array();
        $gravity_form_custom_fields     = array();
        $extra_addon_form_custom_fields = array();

        $array_index = 6;
        if (is_array($order_custom_fields_cols)) {
            array_splice($columns, $array_index, 0, $order_custom_fields_cols);
            $array_index += count($order_custom_fields_cols) + 2;
        } else {
            $array_index = 8;
        }


        //
        if (is_array($custom_tax_cols)) {
            array_splice($columns, $array_index, 0, $custom_tax_cols);
            $array_index += count($custom_tax_cols);
        } else {
            $array_index = 8;
            $array_index += count($order_custom_fields_cols);
        }

        //$array_index=10;

        if (is_array($custom_fields_cols)) {
            array_splice($columns, $array_index, 0, $custom_fields_cols);
        }

    } else {

        $columns = array(
            array('lable' => esc_html__('Order ID', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Name', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Email', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Date', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Status', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Tax Name', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Shipping Method', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Payment Method', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Order Currency', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Coupon Code', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Items', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
            array('lable' => esc_html__('Gross Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Order Discount Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Cart Discount Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Total Discount Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Shipping Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Shipping Tax Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Order Tax Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Total Tax Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Part Refund Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            array('lable' => esc_html__('Net Amt.', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'currency'),
            ////ADDE IN VER4.0
            /// INVOICE ACTION
            array('lable' => esc_html__('Invoice Action', __IT_REPORT_WCREPORT_TEXTDOMAIN__), 'status' => 'show'),
        );

    }

    $this->table_cols = $columns;

} elseif ($file_used == "data_table") {

    $first_order_id = '';


    //$aaa=$this->it_get_full_post_meta(537);
    //die(print_r($aaa));

    $order_items = $this->results;
    $categories  = array();
    $order_meta  = array();
    if (count($order_items) > 0) {
        foreach ($order_items as $key => $order_item) {

            $order_id                              = $order_item->order_id;
            $order_items[$key]->billing_first_name = '';//Default, some time it missing
            $order_items[$key]->billing_last_name  = '';//Default, some time it missing
            $order_items[$key]->billing_email      = '';//Default, some time it missing

            if ( ! isset($order_meta[$order_id])) {
                $order_meta[$order_id] = $this->it_get_full_post_meta($order_id);
            }

            foreach ($order_meta[$order_id] as $k => $v) {
                $order_items[$key]->$k = $v;
            }


            $order_items[$key]->order_total    = isset($order_item->order_total) ? $order_item->order_total : 0;
            $order_items[$key]->order_shipping = isset($order_item->order_shipping) ? $order_item->order_shipping : 0;


            $order_items[$key]->cart_discount  = isset($order_item->cart_discount) ? $order_item->cart_discount : 0;
            $order_items[$key]->order_discount = isset($order_item->order_discount) ? $order_item->order_discount : 0;
            $order_items[$key]->total_discount = isset($order_item->total_discount) ? $order_item->total_discount : ($order_items[$key]->cart_discount + $order_items[$key]->order_discount);


            $order_items[$key]->order_tax          = isset($order_item->order_tax) ? $order_item->order_tax : 0;
            $order_items[$key]->order_shipping_tax = isset($order_item->order_shipping_tax) ? $order_item->order_shipping_tax : 0;
            $order_items[$key]->total_tax          = isset($order_item->total_tax) ? $order_item->total_tax : ($order_items[$key]->order_tax + $order_items[$key]->order_shipping_tax);

            $transaction_id                    = "ransaction ID";
            $order_items[$key]->transaction_id = isset($order_item->$transaction_id) ? $order_item->$transaction_id : (isset($order_item->transaction_id) ? $order_item->transaction_id : '');
            $order_items[$key]->gross_amount   = ($order_items[$key]->order_total + $order_items[$key]->total_discount) - ($order_items[$key]->order_shipping + $order_items[$key]->order_shipping_tax + $order_items[$key]->order_tax);


            $order_items[$key]->billing_first_name = isset($order_item->billing_first_name) ? $order_item->billing_first_name : '';
            $order_items[$key]->billing_last_name  = isset($order_item->billing_last_name) ? $order_item->billing_last_name : '';
            $order_items[$key]->billing_name       = $order_items[$key]->billing_first_name . ' ' . $order_items[$key]->billing_last_name;


        }
    }


    $this->results = $order_items;


    //print_r($this->results);

    /////////////CUSTOM TAXONOMY AND FIELDS////////////
    $key                     = $this->it_get_woo_requests('table_names', '', true);
    $visible_custom_taxonomy = array();
    $post_name               = 'product';
    $all_tax                 = $this->fetch_product_taxonomies($post_name);
    $current_value           = array();
    if (is_array($all_tax) && count($all_tax) > 0) {
        //FETCH TAXONOMY
        foreach ($all_tax as $tax) {
            $tax_status  = get_option(__IT_REPORT_WCREPORT_FIELDS_PERFIX__ . 'set_default_search_' . $key . '_' . $tax);
            $show_column = get_option($key . '_' . $tax . '_column');
            if ($show_column == 'on') {
                $visible_custom_taxonomy[] = $tax;
            }
        }
    }

    $visible_custom_field = array();
    $custom_fields        = get_option(__IT_REPORT_WCREPORT_FIELDS_PERFIX__ . 'set_default_fields');

    //print_r($custom_fields);
    global $wpdb;
    if (is_array($custom_fields)) {
        foreach ($custom_fields as $fieldss) {
            $show_column = get_option($fieldss . '_column');
            if ($show_column == "on") {
                //if($this->it_get_woo_requests('it_'.$fields,NULL,true))

                $id_fieldss_ = explode("_", $fieldss);
                $id_field    = $id_fieldss_[0];
                $id_fieldss_ = str_replace($id_field . "_", "", $fieldss);
                $types       = $wpdb->get_results("SELECT meta.meta_value FROM {$wpdb->prefix}postmeta as meta LEFT JOIN {$wpdb->prefix}postmeta as meta2 ON meta.post_id=meta2.post_id where meta2.post_id='$id_field' AND meta.meta_key='_product_addons' GROUP BY meta.meta_value",
                    ARRAY_A);

                $html = '';
                if ($types != null && is_array($types)) {
                    foreach ($types as $type) {
                        $form = unserialize($type['meta_value']);
                        foreach ($form as $fields) {
                            $id_fieldss = $fields['name'];
                            //if($fields['type']=='custom_textarea' || $fields['type']=='file_upload') continue;
                            $array_index_ = $id_fieldss_ . ' - ' . $opt['label'];
                            $parent       = str_replace(" ", "___", $fields['name']);
                            $parent_id    = ($type['post_id']) . '_' . str_replace(" ", "___", $fields['name']);

                            if ($parent != $id_fieldss_) {
                                continue;
                            }

                            switch ($fields['type']) {

                                case "custom_price" :

                                    $options = $fields['options'];
                                    $i       = 0;
                                    foreach ($options as $opt) {
                                        $value_opt                                  = sanitize_title($opt['label']);
                                        $index                                      = $parent . '---' . $value_opt;
                                        $visible_custom_field[$fieldss][$i]['html'] = $index;
                                        $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];

                                        $i++;
                                    }

                                    break;

                                case "input_multiplier" :

                                    $options = $fields['options'];
                                    $i       = 0;
                                    foreach ($options as $opt) {
                                        $value_opt                                  = sanitize_title($opt['label']);
                                        $index                                      = $parent . '---' . $value_opt;
                                        $visible_custom_field[$fieldss][$i]['html'] = $index;
                                        $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                        $i++;
                                    }


                                    break;

                                case "checkbox" :
                                    $index                                     = $parent;
                                    $visible_custom_field[$fieldss][0]['html'] = $index;
                                    $visible_custom_field[$fieldss][0]['db']   = $id_fieldss;


                                    break;


                                case "custom" :
                                    $options = $fields['options'];
                                    $i       = 0;
                                    foreach ($options as $opt) {
                                        $value_opt                                  = sanitize_title($opt['label']);
                                        $index                                      = $parent . '---' . $value_opt;
                                        $visible_custom_field[$fieldss][$i]['html'] = $index;
                                        $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                        $i++;
                                    }
                                    break;

                                case "custom_textarea":
                                    $options = $fields['options'];
                                    $i       = 0;
                                    foreach ($options as $opt) {
                                        $value_opt                                  = sanitize_title($opt['label']);
                                        $index                                      = $parent . '---' . $value_opt;
                                        $visible_custom_field[$fieldss][$i]['html'] = $index;
                                        $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                        $i++;
                                    }
                                    break;

                                case "custom_email" :
                                    $options = $fields['options'];
                                    $i       = 0;
                                    foreach ($options as $opt) {
                                        $value_opt                                  = sanitize_title($opt['label']);
                                        $index                                      = $parent . '---' . $value_opt;
                                        $visible_custom_field[$fieldss][$i]['html'] = $index;
                                        $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];

                                        $i++;
                                    }
                                    break;

                                case "custom_letters_only" :
                                    $options = $fields['options'];
                                    $i       = 0;
                                    foreach ($options as $opt) {
                                        $value_opt                                  = sanitize_title($opt['label']);
                                        $index                                      = $parent . '---' . $value_opt;
                                        $visible_custom_field[$fieldss][$i]['html'] = $index;
                                        $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                        $i++;
                                    }
                                    break;

                                case "custom_letters_or_digits" :
                                    $options = $fields['options'];
                                    $i       = 0;
                                    foreach ($options as $opt) {
                                        $value_opt                                  = sanitize_title($opt['label']);
                                        $index                                      = $parent . '---' . $value_opt;
                                        $visible_custom_field[$fieldss][$i]['html'] = $index;
                                        $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                        $i++;
                                    }
                                    break;

                                case "custom_digits_only" :
                                    $options = $fields['options'];
                                    $i       = 0;
                                    foreach ($options as $opt) {
                                        $value_opt                                  = sanitize_title($opt['label']);
                                        $index                                      = $parent . '---' . $value_opt;
                                        $visible_custom_field[$fieldss][$i]['html'] = $index;
                                        $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];

                                        $i++;
                                    }
                                    break;

                                case "radiobutton" :
                                    $index                                     = $parent;
                                    $visible_custom_field[$fieldss][0]['html'] = $index;
                                    $visible_custom_field[$fieldss][0]['db']   = $id_fieldss;

                                    break;

                                case "custom_text" :
                                    $display = $fields['restrictions_type'];

                                    switch ($display) {

                                        case 'any_text':
                                            $options = $fields['options'];
                                            $i       = 0;


                                            $label                                      = $fields['name'];
                                            $value_opt                                  = sanitize_title($label);
                                            $index                                      = $parent . '---' . $value_opt;
                                            $visible_custom_field[$fieldss][$i]['html'] = $index;
                                            $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss;


                                            break;

                                        case 'only_letters':
                                            $options = $fields['options'];
                                            $i       = 0;

                                            $label = $fields['name'];

                                            $value_opt                                  = sanitize_title($label);
                                            $index                                      = $parent . '---' . $value_opt;
                                            $visible_custom_field[$fieldss][$i]['html'] = $index;
                                            $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss;
                                            break;

                                        case 'only_numbers':
                                            $options = $fields['options'];
                                            $i       = 0;

                                            $label = $fields['name'];

                                            $value_opt                                  = sanitize_title($label);
                                            $index                                      = $parent . '---' . $value_opt;
                                            $visible_custom_field[$fieldss][$i]['html'] = $index;
                                            $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss;
                                            break;

                                        case 'only_letters_numbers':
                                            $options = $fields['options'];
                                            $i       = 0;

                                            $label                                      = $fields['name'];
                                            $value_opt                                  = sanitize_title($label);
                                            $index                                      = $parent . '---' . $value_opt;
                                            $visible_custom_field[$fieldss][$i]['html'] = $index;
                                            $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss;

                                            break;

                                        case 'email':
                                            $options = $fields['options'];
                                            $i       = 0;

                                            $label = $fields['name'];

                                            $value_opt                                  = sanitize_title($label);
                                            $index                                      = $parent . '---' . $value_opt;
                                            $visible_custom_field[$fieldss][$i]['html'] = $index;
                                            $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss;

                                            break;

                                    }

                                    break;

                                case "multiple_choice" :

                                    if ($fields['display'] == 'radiobutton') {

                                        $index                                     = $parent;
                                        $visible_custom_field[$fieldss][0]['html'] = $index;
                                        $visible_custom_field[$fieldss][0]['db']   = $id_fieldss;
                                    }

                                    if ($fields['display'] == 'select') {

                                        $index                                     = $parent;
                                        $visible_custom_field[$fieldss][0]['html'] = $index;
                                        $visible_custom_field[$fieldss][0]['db']   = $id_fieldss;
                                    }

                                    break;


                                case "select" :
                                    $index                                     = $parent;
                                    $visible_custom_field[$fieldss][0]['html'] = $index;
                                    $visible_custom_field[$fieldss][0]['db']   = $id_fieldss;

                                    break;

                                case "file_upload" :

                                    $options = $fields['options'];
                                    $i       = 0;
                                    foreach ($options as $opt) {
                                        $value_opt                                  = sanitize_title($opt['label']);
                                        $index                                      = $parent . '---' . $value_opt;
                                        $visible_custom_field[$fieldss][$i]['html'] = $index;
                                        $visible_custom_field[$fieldss][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];

                                        $i++;
                                    }
                                    break;

                                    break;

                            }

                        }
                    }
                } else {
                    //$visible_custom_field[$fieldss]=$fieldss;
                    $visible_custom_field[$fieldss][0] = $fieldss;
                    //$visible_custom_field[$fieldss][0]['db']=$fieldss ;
                }

            }
        }
    }
//print_r($visible_custom_field);

    global $wpdb;
    $gravity_form_custom_fields = array();
    if (defined("GRAVITY_MANAGER_URL")) {
        $types = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}gf_form_meta", ARRAY_A);
        if ($types != null && is_array($types)) {
            foreach ($types as $type) {
                //print_r($type['display_meta']);
                $form = json_decode($type['display_meta']);
                //print_r($form->fields[1]->label);
                foreach ($form->fields as $fields) {
                    $value                        = ($fields->label);
                    $value                        = str_replace(" ", "_", $value);
                    $gravity_form_custom_fields[] = $value;
                }
            }
        }
    }

    $extra_addon_form_custom_fields = array();
    if (class_exists("WC_Product_Addons")) {
        $types = $wpdb->get_results("SELECT meta.post_id,meta.meta_value FROM {$wpdb->prefix}postmeta as meta LEFT JOIN {$wpdb->prefix}postmeta as meta2 ON meta.post_id=meta2.post_id where meta.meta_key='_product_addons' GROUP BY meta.meta_value",
            ARRAY_A);

        $html = '';
        if ($types != null && is_array($types)) {
            foreach ($types as $type) {
                $form = unserialize($type['meta_value']);
                foreach ($form as $fields) {
                    $id_fieldss = $fields['name'];
                    //if($fields['type']=='custom_textarea' || $fields['type']=='file_upload') continue;
                    $array_index_ = $id_fieldss . ' - ' . $opt['label'];
                    $parent       = str_replace(" ", "___", $fields['name']);
                    $parent_id    = ($type['post_id']) . '_' . str_replace(" ", "___", $fields['name']);

                    switch ($fields['type']) {

                        case "custom_price" :

                            $options = $fields['options'];
                            $i       = 0;
                            foreach ($options as $opt) {
                                $value_opt                                              = sanitize_title($opt['label']);
                                $index                                                  = $parent . '---' . $value_opt;
                                $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                $i++;
                            }

                            break;

                        case "input_multiplier" :

                            $options = $fields['options'];
                            $i       = 0;
                            foreach ($options as $opt) {
                                $value_opt                                              = sanitize_title($opt['label']);
                                $index                                                  = $parent . '---' . $value_opt;
                                $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                $i++;
                            }
                            break;

                        case "checkbox" :
                            $index                                  = $parent;
                            $extra_addon_form_custom_fields[$index] = $id_fieldss;
                            break;


                        case "custom" :
                            $options = $fields['options'];
                            $i       = 0;
                            foreach ($options as $opt) {
                                $value_opt                                              = sanitize_title($opt['label']);
                                $index                                                  = $parent . '---' . $value_opt;
                                $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                $i++;
                            }
                            break;

                        case "custom_textarea" :
                            $options = $fields['options'];
                            $i       = 0;
                            foreach ($options as $opt) {
                                $value_opt                                              = sanitize_title($opt['label']);
                                $index                                                  = $parent . '---' . $value_opt;
                                $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                $i++;
                            }
                            break;

                        case "custom_email" :
                            $options = $fields['options'];
                            $i       = 0;
                            foreach ($options as $opt) {
                                $value_opt                                              = sanitize_title($opt['label']);
                                $index                                                  = $parent . '---' . $value_opt;
                                $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                $i++;
                            }
                            break;

                        case "custom_letters_only" :
                            $options = $fields['options'];
                            $i       = 0;
                            foreach ($options as $opt) {
                                $value_opt                                              = sanitize_title($opt['label']);
                                $index                                                  = $parent . '---' . $value_opt;
                                $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                $i++;
                            }
                            break;

                        case "custom_letters_or_digits" :
                            $options = $fields['options'];
                            $i       = 0;
                            foreach ($options as $opt) {
                                $value_opt                                              = sanitize_title($opt['label']);
                                $index                                                  = $parent . '---' . $value_opt;
                                $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                $i++;
                            }
                            break;

                        case "custom_digits_only" :
                            $options = $fields['options'];
                            $i       = 0;
                            foreach ($options as $opt) {
                                $value_opt                                              = sanitize_title($opt['label']);
                                $index                                                  = $parent . '---' . $value_opt;
                                $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                $i++;
                            }
                            break;

                        case "radiobutton" :
                            $index                                  = $parent;
                            $extra_addon_form_custom_fields[$index] = $id_fieldss;

                            break;

                        case "custom_text" :
                            $display = $fields['restrictions_type'];

                            switch ($display) {

                                case 'any_text':
                                    $options = $fields['options'];
                                    $i       = 0;

                                    $label                                                  = $fields['name'];
                                    $value_opt                                              = sanitize_title($label);
                                    $index                                                  = $parent . '---' . $value_opt;
                                    $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $label;
                                    $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss;
                                    $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;

                                    break;

                                case 'only_letters':
                                    $options = $fields['options'];
                                    $i       = 0;

                                    $label                                                  = $fields['name'];
                                    $value_opt                                              = sanitize_title($label);
                                    $index                                                  = $parent . '---' . $value_opt;
                                    $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $label;
                                    $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss;
                                    $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                    break;

                                case 'only_numbers':
                                    $options = $fields['options'];
                                    $i       = 0;

                                    $label = $fields['name'];

                                    $value_opt                                              = sanitize_title($label);
                                    $index                                                  = $parent . '---' . $value_opt;
                                    $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $label;
                                    $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss;
                                    $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                    break;

                                case 'only_letters_numbers':
                                    $options = $fields['options'];
                                    $i       = 0;

                                    $label = $fields['name'];

                                    $value_opt                                              = sanitize_title($label);
                                    $index                                                  = $parent . '---' . $value_opt;
                                    $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $label;
                                    $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss;
                                    $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                    break;

                                case 'email':
                                    $options = $fields['options'];
                                    $i       = 0;

                                    $label                                                  = $fields['name'];
                                    $value_opt                                              = sanitize_title($label);
                                    $index                                                  = $parent . '---' . $value_opt;
                                    $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $label;
                                    $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss;
                                    $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                    break;

                            }

                            break;

                        case "multiple_choice" :

                            if ($fields['display'] == 'radiobutton') {
                                $index                                  = $parent;
                                $extra_addon_form_custom_fields[$index] = $id_fieldss;
                            }

                            if ($fields['display'] == 'select') {
                                $index                                  = $parent;
                                $extra_addon_form_custom_fields[$index] = $id_fieldss;
                            }

                            break;

                        case "select" :
                            $index                                  = $parent;
                            $extra_addon_form_custom_fields[$index] = $id_fieldss;

                            break;

                        case "file_upload" :

                            $options = $fields['options'];
                            $i       = 0;
                            foreach ($options as $opt) {
                                $value_opt                                              = sanitize_title($opt['label']);
                                $index                                                  = $parent . '---' . $value_opt;
                                $extra_addon_form_custom_fields[$index]                 = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['db']   = $id_fieldss . ' - ' . $opt['label'];
                                $extra_addon_form_custom_fields[$parent_id][$i]['html'] = $index;
                                $i++;
                            }
                            break;

                    }

                }
            }
        }
    }
    ///
    /// $extra_addon_form_custom_fields['html element name']=database field

    //print_r($extra_addon_form_custom_fields);


    function fetch_gravity_value($order_item_id, $field, $gravity_form_custom_fields)
    {

        global $wpdb, $it_rpt_main_class;
        if (is_array($gravity_form_custom_fields) && in_array($field, $gravity_form_custom_fields)) {

            $cond_field = str_replace("_", " ", $field);

            ${$field} = $it_rpt_main_class->it_get_woo_requests('it_' . $field, null, true);

            $operator           = get_option($field . '_operator');
            $operator_condition = get_operator($operator, ${$field});

            $sql = "SELECT woocommerce_order_itemmeta.meta_value as $field FROM {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta Where woocommerce_order_itemmeta.meta_key='$cond_field' AND woocommerce_order_itemmeta.order_item_id='$order_item_id'";


//			if(${$field}){
//
//				$sql .= " AND woocommerce_order_itemmeta.meta_value $operator_condition ";
//			}

            //	echo $sql;

            $g_fields = $wpdb->get_results($sql, ARRAY_A);

            if (isset($g_fields[0])) {
                return $g_fields[0][$field];
            } else {
                return '-';
            }

        } else {
            return false;
        }
    }


    function fetch_extra_addon_value($order_item_id, $field, $extra_addon_form_custom_fields, $index)
    {

        //$cond_field=str_replace("___"," ",$field);
        //echo $field.$index. '       ';
        global $wpdb, $it_rpt_main_class;
        //if(is_array($extra_addon_form_custom_fields) && in_array($field,$extra_addon_form_custom_fields)){
        if (isset($extra_addon_form_custom_fields[$field]) && isset($extra_addon_form_custom_fields[$field][$index]['db'])) {

            $html_field = $extra_addon_form_custom_fields[$field][$index]['html'];
            $db_field   = $extra_addon_form_custom_fields[$field][$index]['db'];

            //echo $html_field." @@@ ";
            //echo $db_field." @@@ ";


            ${$field} = $it_rpt_main_class->it_get_woo_requests('it_' . $html_field, null, true);
            ${$field} = '';

            //echo $field;
            //echo 'FIELD : '.${$field}."<br />";

            $operator           = get_option($field . '_operator');
            $operator_condition = get_operator($operator, ${$field});

            //echo $operator_condition;

            //$cond_field=str_replace("___"," ",$field);
            //$cond_field=str_replace("@"," ",$cond_field);
            //$cond_field=str_replace("__"," - ",$cond_field);
            $cond_field   = $db_field;
            $select_field = $it_rpt_main_class->slug_str($db_field);

            //echo $select_field;

            $sql = "SELECT woocommerce_order_itemmeta.meta_value as $select_field FROM {$wpdb->prefix}woocommerce_order_itemmeta as woocommerce_order_itemmeta Where woocommerce_order_itemmeta.meta_key LIKE '%$cond_field%' AND woocommerce_order_itemmeta.order_item_id='$order_item_id'";


            if (${$field}) {
                $sql .= " AND woocommerce_order_itemmeta.meta_value $operator_condition ";
            }
            //echo $sql."<br />";
            //echo $sql;

            $g_fields = $wpdb->get_results($sql, ARRAY_A);

            if (isset($g_fields[0])) {

                $image = $it_rpt_main_class->validImage($g_fields[0][$select_field]);
                if ($image) {
                    $field_value = '<img width="100px" height="100px" src="' . $g_fields[0][$select_field] . '"/>';

                    return $field_value;
                } elseif (filter_var($g_fields[0][$select_field], FILTER_VALIDATE_URL)) {
                    $field_value = '<a target="_blank" href="' . $g_fields[0][$select_field] . '">' . esc_html__("Download",
                            __IT_REPORT_WCREPORT_TEXTDOMAIN__) . '</a>';

                    return $field_value;
                }

                return $g_fields[0][$select_field];
            } elseif (${$field}) {
                return false;
            } else {
                return '-';
            }
        } else {
            return false;
        }
    }

    function is_order_product_field($field, $type)
    {
        global $wpdb;
        $product_custom_fields = array();
        $order_custom_fields   = array();

        if ($type == 'product') {

            $types = $wpdb->get_results("SELECT it_postmeta.meta_key as meta_key FROM " . $wpdb->postmeta . " as it_postmeta INNER JOIN " . $wpdb->posts . " as it_post ON it_postmeta.post_id=it_post.ID where it_post.post_type='product'  GROUP BY it_postmeta.meta_key",
                ARRAY_A);


            if ($types != null && is_array($types)) {

                foreach ($types as $k => $v) {
                    $product_custom_fields[] = $v['meta_key'];
                }

            }
            if (in_array($field, $product_custom_fields)) {
                return true;
            }

        } else {

            $types = $wpdb->get_results("SELECT it_postmeta.meta_key as meta_key FROM " . $wpdb->postmeta . " as it_postmeta INNER JOIN " . $wpdb->posts . " as it_post ON it_postmeta.post_id=it_post.ID where it_post.post_type='shop_order' GROUP BY it_postmeta.meta_key",
                ARRAY_A);


            if ($types != null && is_array($types)) {
                foreach ($types as $k => $v) {
                    $order_custom_fields[] = substr($v['meta_key'], 1);
                }
            }

            if (in_array($field, $order_custom_fields)) {
                return true;
            }
        }

        return false;
    }

    //////////////////////////////////////////////////////

    $items_render = array();
    global $it_rpt_main_class;

    ////ADDE IN VER4.0
    /// TOTAL ROWS VARIABLES
    $gross_amnt = $discount_amnt = $shipping_amnt = $shipping_tax_amnt =
    $order_tax_amnt = $total_tax_amnt = $part_refund_amnt = $order_count =
    $product_count = $product_qty = $total_rate = $product_amnt = $product_discount = $net_amnt = 0;

    foreach ($this->results as $items) {
        $index_cols = 0;
        //for($i=1; $i<=20 ; $i++){


        ////ADDE IN VER4.0
        /// TOTAL ROWS
        $product_count++;

        $flag = array(true);
        $fill = false;
        if (is_array($gravity_form_custom_fields)) {
            foreach ($gravity_form_custom_fields as $gfields) {

                ${$gfields} = $it_rpt_main_class->it_get_woo_requests('it_' . $gfields, null, true);
                if (${$gfields}) {
                    $fill = true;
                } else {
                    $fill = false;
                }

                $order_item_id = $items->order_item_id;
                if ($fill && fetch_gravity_value($order_item_id, $gfields,
                        $gravity_form_custom_fields) && fetch_gravity_value($order_item_id, $gfields,
                        $gravity_form_custom_fields) != '-') {
                    $flag[] = true;

                } elseif ($fill && ( ! fetch_gravity_value($order_item_id, $gfields,
                            $gravity_form_custom_fields) || fetch_gravity_value($order_item_id, $gfields,
                            $gravity_form_custom_fields) == '-')) {
                    $flag[] = false;
                }

            }
        }


        if (in_array(false, $flag)) {
            continue;
        }


        $flag = array(true);
        $fill = false;

        if (is_array($visible_custom_field)) {
            foreach ($visible_custom_field as $gfields => $val) {
                $j = 0;

                foreach ($val as $ggfields => $vval) {

                    ${$gfields} = $it_rpt_main_class->it_get_woo_requests('it_' . $gfields, null, true);
                    ${$gfields} = '';

                    //echo "HTML: ".$vval['html']." | gfields: ".$gfields."@";

                    if (${$gfields}) {
                        $fill = true;
                        echo " ggfields: " . ${$gfields} . "| FUNC:" . fetch_extra_addon_value($order_item_id, $gfields,
                                $visible_custom_field, $j);
                    } else {
                        $fill = false;
                    }

                    //echo  '<br />';


                    $order_item_id = $items->order_item_id;
                    if ($fill && fetch_extra_addon_value($order_item_id, $gfields, $visible_custom_field,
                            $j) && fetch_extra_addon_value($order_item_id, $gfields, $visible_custom_field,
                            $j) != '-') {

                        $flag = true;

                    } elseif ($fill && ( ! fetch_extra_addon_value($order_item_id, $gfields, $visible_custom_field,
                                $j) || fetch_extra_addon_value($order_item_id, $gfields, $visible_custom_field,
                                $j) == '-')) {
                        $flag = false;
                        break;
                    }
                    $j++;
                }


            }
        }


        //die(print_r($flag));

        if ( ! ($flag)) {
            continue;
        }

        $order_id         = $items->order_id;
        $fetch_other_data = '';

        if ( ! isset($this->order_meta[$order_id])) {
            $fetch_other_data = $this->it_get_full_post_meta($order_id);
        }

        $new_order = false;
        if ($first_order_id == '') {
            $first_order_id = $items->order_id;
            $new_order      = true;
        } elseif ($first_order_id != $items->order_id) {
            $first_order_id = $items->order_id;
            $new_order      = true;
        }
        $it_detail_view = $this->it_get_woo_requests('it_view_details', "no", true);
        if ($it_detail_view == "yes") {
            if ($new_order) {

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $order_count++;

                $datatable_value .= ("<tr class='awr-colored-tbl-row'>");

                //order ID
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $items->order_id;
                $datatable_value .= ("</td>");

                //Name
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $items->billing_name;
                $datatable_value .= ("</td>");

                //Email
                $it_table_value = isset($items->billing_email) ? $items->billing_email : '';
                $it_table_value = $this->it_email_link_format($it_table_value, false);
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
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
                $it_table_value = isset($items->order_status) ? $items->order_status : '';

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


                //Coupon Code

                //$it_table_value= $this->it_oin_list($items->order_id,'coupon');

                $it_table_value = $this->it_get_woo_coupons($items->order_id);

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //CUSTOM FIELDS
                if (is_array($visible_custom_field)) {
                    foreach ((array)$visible_custom_field as $field => $key) {
                        $j = 0;
                        foreach ($key as $ggfields) {
                            if ( ! is_order_product_field($field, 'order')) {
                                continue;
                            }
                            //CUSTOM FIELDS
                            $display_class = '';
                            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                                $display_class = 'display:none';
                            }
                            $datatable_value .= ("<td style='" . $display_class . "'>");
                            $order_item_id   = $items->order_item_id;

                            if ( ! fetch_gravity_value($order_item_id, $field,
                                    $gravity_form_custom_fields) && ! fetch_extra_addon_value($order_item_id, $field,
                                    $visible_custom_field, $j)) {
                                if (is_order_product_field($field, 'order') && isset($items->$field)) {
                                    $datatable_value .= $items->$field;
                                }
                            }

                            $datatable_value .= ("</td>");
                            $j++;
                        }
                    }
                }

                //Products
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");


                /*if(is_array($visible_custom_field)){
					foreach((array)$visible_custom_field as $field){
						//Category
						$display_class='';
						if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
						$datatable_value.=("<td style='".$display_class."'>");
							$datatable_value.= '';
						$datatable_value.=("</td>");
					}
				}*/

                //Category
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");


                //CUSTOM TAXONOMY
                if (is_array($visible_custom_taxonomy)) {
                    foreach ((array)$visible_custom_taxonomy as $tax) {
                        //Category
                        $display_class = '';
                        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                            $display_class = 'display:none';
                        }
                        $datatable_value .= ("<td style='" . $display_class . "'>");
                        $datatable_value .= '';
                        $datatable_value .= ("</td>");
                    }
                }

                //CUSTOM FIELDS
                if (is_array($visible_custom_field)) {
                    foreach ((array)$visible_custom_field as $field => $key) {
                        $j = 0;
                        foreach ($key as $ggfields) {
                            if (is_order_product_field($field, 'order')) {
                                continue;
                            }
                            //CUSTOM FIELDS
                            $display_class = '';
                            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                                $display_class = 'display:none';
                            }
                            $datatable_value .= ("<td style='" . $display_class . "'>");
                            $order_item_id   = $items->order_item_id;

                            if ( ! fetch_gravity_value($order_item_id, $field,
                                    $gravity_form_custom_fields) && ! fetch_extra_addon_value($order_item_id, $field,
                                    $visible_custom_field, $j)) {
                                if (is_order_product_field($field, 'product')) {
                                    $datatable_value .= '';
                                }
                            }

                            $datatable_value .= ("</td>");
                            $j++;
                        }
                    }
                }

                //SKU
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Variation
                $it_table_value = $this->it_get_woo_variation($items->order_item_id);
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Qty.
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Rate
                $it_table_value = isset($items->product_rate) ? $items->product_rate : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $this->price($it_table_value);

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Prod. Amt.

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Prod. Discount
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Net Amt.
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                ////ADDE IN VER4.0
                /// INVOICE ACTION
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");

                $datatable_value .= '<a href="javascript:void(0);" title="' . esc_html__("Generate Invoice",
                        __IT_REPORT_WCREPORT_TEXTDOMAIN__) . '" class="it_pdf_invoice button" data-order-id="' . $items->order_id . '"><i class="fa fa-file-text-o  "></i></a>';

                //COMPATIBLE WITH WOO INVOICE
                if (class_exists("WC_pdf_admin")) {
                    $datatable_value .= '<a href="' . admin_url() . 'edit.php?post_type=shop_order&pdfid=' . $items->order_id . '"><i class="fa fa-file-pdf-o button "></i></a>';
                }
                //COMPATIBLE WITH CODECANYON WOO INVOICE
                if (class_exists("WooPDF")) {
                    $datatable_value .= '<a href="' . admin_url() . 'edit.php?post_type=shop_order&wpd_proforma=' . $items->order_id . '"><i class="fa fa-download button "></i></a>';
                }

                $datatable_value .= ("</tr>");


                //////////////////////////
                //ITEMS
                //////////////////////////
                $index_cols      = 0;
                $datatable_value .= ("<tr>");

                //order ID
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '<span style="display:none">' . $items->order_id . '<span>';
                $datatable_value .= ("</td>");

                //Name
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Email
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Date
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Status
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");


                //Coupon Code

                //$it_table_value= $this->it_oin_list($items->order_id,'coupon');

                $it_table_value = $this->it_get_woo_coupons($items->order_id);

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //CUSTOM FIELDS
                if (is_array($visible_custom_field)) {
                    foreach ((array)$visible_custom_field as $field => $key) {
                        $j = 0;
                        foreach ($key as $ggfields) {
                            if ( ! is_order_product_field($field, 'order')) {
                                continue;
                            }
                            //CUSTOM FIELDS
                            $display_class = '';
                            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                                $display_class = 'display:none';
                            }
                            $datatable_value .= ("<td style='" . $display_class . "'>");
                            $order_item_id   = $items->order_item_id;

                            if ( ! fetch_gravity_value($order_item_id, $field,
                                    $gravity_form_custom_fields) && ! fetch_extra_addon_value($order_item_id, $field,
                                    $visible_custom_field, $j)) {
                                if (is_order_product_field($field, 'order')) {
                                    $datatable_value .= '';
                                }

                            }
                            $datatable_value .= ("</td>");
                            $j++;
                        }
                    }
                }

                //Products
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $items->product_name;
                $datatable_value .= ("</td>");

                //Category
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->it_get_cn_product_id($items->product_id, "product_cat");
                $datatable_value .= ("</td>");

                //CUSTOM TAXONOMY
                if (is_array($visible_custom_taxonomy)) {
                    foreach ((array)$visible_custom_taxonomy as $tax) {
                        //Category
                        $display_class = '';
                        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                            $display_class = 'display:none';
                        }
                        $datatable_value .= ("<td style='" . $display_class . "'>");
                        $datatable_value .= $this->it_get_cn_product_id($items->product_id, $tax);
                        $datatable_value .= ("</td>");
                    }
                }

                //Category
                /*$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $this->it_get_cn_product_id($items->product_id,"product_cat");
				$datatable_value.=("</td>");
				*/

                //CUSTOM FIELDS
                if (is_array($visible_custom_field)) {
                    foreach ((array)$visible_custom_field as $field => $key) {
                        $j = 0;
                        foreach ($key as $ggfields) {
                            if (is_order_product_field($field, 'order')) {
                                continue;
                            }
                            //CUSTOM FIELDS
                            $display_class = '';
                            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                                $display_class = 'display:none';
                            }
                            $datatable_value .= ("<td style='" . $display_class . "'>");
                            $order_item_id   = $items->order_item_id;

                            if ( ! fetch_gravity_value($order_item_id, $field,
                                    $gravity_form_custom_fields) && ! fetch_extra_addon_value($order_item_id, $field,
                                    $visible_custom_field, $j)) {
                                if (is_order_product_field($field, 'product')) //$datatable_value.=$items->$field;
                                {
                                    $datatable_value .= $this->it_get_prod_custom_fields($items->order_item_id,
                                        $items->product_id, $field);
                                } else {
                                    $datatable_value .= '';
                                }

                            } elseif (fetch_gravity_value($order_item_id, $field, $gravity_form_custom_fields)) {

                                $datatable_value .= fetch_gravity_value($order_item_id, $field,
                                    $gravity_form_custom_fields);
                            } elseif (fetch_extra_addon_value($order_item_id, $field, $visible_custom_field, $j)) {
                                $datatable_value .= fetch_extra_addon_value($order_item_id, $field,
                                    $visible_custom_field, $j);
                            }

                            $datatable_value .= ("</td>");
                            $j++;
                        }
                    }
                }

                //SKU
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->it_get_prod_sku($items->order_item_id, $items->product_id);
                $datatable_value .= ("</td>");

                //Variation
                $it_table_value = $this->it_get_woo_variation($items->order_item_id);
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //Qty.
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $items->product_quantity;

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $product_qty     += $items->product_quantity;
                $datatable_value .= ("</td>");

                //Rate
                $it_table_value = isset($items->product_rate) ? $items->product_rate : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency']));

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $total_rate      += $it_table_value;
                $datatable_value .= ("</td>");

                //Prod. Amt.
                $it_table_value = isset($items->item_amount) ? $items->item_amount : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency']));

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $product_amnt    += $it_table_value;
                $datatable_value .= ("</td>");


                //Prod. Discount
                $it_table_value = isset($items->item_discount) ? $items->item_discount : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency']));

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $product_discount += $it_table_value;
                $datatable_value  .= ("</td>");

                //Net Amt.
                $it_table_value = isset($items->total_price) ? $items->total_price : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency']));

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $net_amnt        += $it_table_value;
                $datatable_value .= ("</td>");

                ////ADDE IN VER4.0
                /// INVOICE ACTION
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                $datatable_value .= ("</tr>");

            } else {
                $datatable_value .= ("<tr>");

                //order ID
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '<span style="display:none">' . $items->order_id . '<span>';
                $datatable_value .= ("</td>");

                //Name
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Email
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Date
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //Status
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");


                //Coupon Code

                //$it_table_value= $this->it_oin_list($items->order_id,'coupon');

                $it_table_value = $this->it_get_woo_coupons($items->order_id);

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                //CUSTOM FIELDS
                if (is_array($visible_custom_field)) {
                    foreach ((array)$visible_custom_field as $field => $key) {
                        $j = 0;
                        foreach ($key as $ggfields) {
                            if ( ! is_order_product_field($field, 'order')) {
                                continue;
                            }
                            //Category
                            $display_class = '';
                            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                                $display_class = 'display:none';
                            }
                            $datatable_value .= ("<td style='" . $display_class . "'>");

                            $order_item_id = $items->order_item_id;
                            /*if(!fetch_gravity_value($order_item_id,$field,$gravity_form_custom_fields)){
								$datatable_value.= $items->$field;
							}else{
								$datatable_value.= fetch_gravity_value($order_item_id,$field,$gravity_form_custom_fields);
							}*/

                            if ( ! fetch_gravity_value($order_item_id, $field,
                                    $gravity_form_custom_fields) && ! fetch_extra_addon_value($order_item_id, $field,
                                    $visible_custom_field, $j)) {
                                if (is_order_product_field($field, 'product')) {
                                    $datatable_value .= '';
                                }
                            }

                            $datatable_value .= ("</td>");
                            $j++;
                        }
                    }
                }

                //Products
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $items->product_name;
                $datatable_value .= ("</td>");

                //Category
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->it_get_cn_product_id($items->product_id, "product_cat");
                $datatable_value .= ("</td>");

                //CUSTOM TAXONOMY
                if (is_array($visible_custom_taxonomy)) {
                    foreach ((array)$visible_custom_taxonomy as $tax) {
                        //Category
                        $display_class = '';
                        if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                            $display_class = 'display:none';
                        }
                        $datatable_value .= ("<td style='" . $display_class . "'>");
                        $datatable_value .= $this->it_get_cn_product_id($items->product_id, $tax);
                        $datatable_value .= ("</td>");
                    }
                }

                //Category
                /*$display_class='';
				if($this->table_cols[$index_cols++]['status']=='hide') $display_class='display:none';
				$datatable_value.=("<td style='".$display_class."'>");
					$datatable_value.= $this->it_get_cn_product_id($items->product_id,"product_cat");
				$datatable_value.=("</td>");*/

                //CUSTOM FIELDS
                if (is_array($visible_custom_field)) {
                    foreach ((array)$visible_custom_field as $field => $key) {
                        $j = 0;
                        foreach ($key as $ggfields) {
                            if (is_order_product_field($field, 'order')) {
                                continue;
                            }
                            //Category
                            $display_class = '';
                            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                                $display_class = 'display:none';
                            }
                            $datatable_value .= ("<td style='" . $display_class . "'>");

                            $order_item_id = $items->order_item_id;
                            /*if(!fetch_gravity_value($order_item_id,$field,$gravity_form_custom_fields)){
								$datatable_value.= $items->$field;
							}else{
								$datatable_value.= fetch_gravity_value($order_item_id,$field,$gravity_form_custom_fields);
							}*/

                            if ( ! fetch_gravity_value($order_item_id, $field,
                                    $gravity_form_custom_fields) && ! fetch_extra_addon_value($order_item_id, $field,
                                    $visible_custom_field, $j)) {
                                if (is_order_product_field($field, 'product')) //$datatable_value.= $items->$field;
                                {
                                    $datatable_value .= $this->it_get_prod_custom_fields($items->order_item_id,
                                        $items->product_id, $field);
                                } else {
                                    $datatable_value .= '';
                                }
                            } elseif (fetch_gravity_value($order_item_id, $field, $gravity_form_custom_fields)) {
                                $datatable_value .= fetch_gravity_value($order_item_id, $field,
                                    $gravity_form_custom_fields);
                            } elseif (fetch_extra_addon_value($order_item_id, $field, $visible_custom_field, $j)) {
                                $datatable_value .= fetch_extra_addon_value($order_item_id, $field,
                                    $visible_custom_field, $j);
                            }


                            $datatable_value .= ("</td>");
                            $j++;
                        }
                    }
                }

                //SKU
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->it_get_prod_sku($items->order_item_id, $items->product_id);
                $datatable_value .= ("</td>");

                //Variation
                $it_table_value = $this->it_get_woo_variation($items->order_item_id);
                $display_class  = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $it_table_value;
                $datatable_value .= ("</td>");

                //Qty.
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $items->product_quantity;

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $product_qty     += $items->product_quantity;
                $datatable_value .= ("</td>");

                //Rate
                $it_table_value = isset($items->product_rate) ? $items->product_rate : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency']));

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $total_rate      += $it_table_value;
                $datatable_value .= ("</td>");

                //Prod. Amt.
                $it_table_value = isset($items->item_amount) ? $items->item_amount : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency']));

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $product_amnt    += $it_table_value;
                $datatable_value .= ("</td>");

                //Prod. Discount
                $it_table_value = isset($items->item_discount) ? $items->item_discount : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency']));

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $product_discount += $it_table_value;
                $datatable_value  .= ("</td>");

                //Net Amt.
                $it_table_value = isset($items->total_price) ? $items->total_price : 0;
                $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;

                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= $this->price($it_table_value,
                    array("currency" => $fetch_other_data['order_currency']));

                ////ADDE IN VER4.0
                /// TOTAL ROWS
                $net_amnt        += $it_table_value;
                $datatable_value .= ("</td>");

                ////ADDE IN VER4.0
                /// INVOICE ACTION
                $display_class = '';
                if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                    $display_class = 'display:none';
                }
                $datatable_value .= ("<td style='" . $display_class . "'>");
                $datatable_value .= '';
                $datatable_value .= ("</td>");

                $datatable_value .= ("</tr>");
            }

        } else {
            if (in_array($items->order_id, $items_render)) {
                continue;
            } else {
                $items_render[] = $items->order_id;
            }

            ////ADDE IN VER4.0
            /// TOTAL ROWS
            $order_count++;

            $datatable_value .= ("<tr>");

            //order ID
            $display_class = '';
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $items->order_id;
            $datatable_value .= ("</td>");

            //Name
            $display_class = '';
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $items->billing_name;
            $datatable_value .= ("</td>");

            //Email
            $it_table_value = isset($items->billing_email) ? $items->billing_email : '';
            $it_table_value = $this->it_email_link_format($it_table_value, false);
            $display_class  = '';
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $it_table_value;
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
            $it_table_value = isset($items->order_status) ? $items->order_status : '';

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

            //Tax Name
            $tax_name = $this->it_oin_list($items->order_id, 'tax');

            $display_class = '';
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= isset($tax_name[$items->order_id]) ? $tax_name[$items->order_id] : "";
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

            //Payment Method
            $display_class = '';
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= isset($items->payment_method_title) ? $items->payment_method_title : "";
            $datatable_value .= ("</td>");

            //print_r($items);

            //Order Currency
            $display_class = '';
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= isset($items->order_currency) ? $items->order_currency : "";
            $datatable_value .= ("</td>");

            //Coupon Code
            $display_class  = '';
            $it_coupon_code = $this->it_oin_list($items->order_id, 'coupon');
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= isset($it_coupon_code[$items->order_id]) ? $it_coupon_code[$items->order_id] : "";
            $datatable_value .= ("</td>");

            //Items Count
            $display_class = '';
            $items_count   = $this->it_get_oi_count($items->order_id, 'line_item');
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= isset($items_count[$items->order_id]) ? $items_count[$items->order_id] : "";
            $datatable_value .= ("</td>");

            //Cross Amt
            $display_class  = '';
            $it_table_value = isset($items->gross_amount) ? $items->gross_amount : 0;
            $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $this->price($it_table_value, array("currency" => $fetch_other_data['order_currency']));

            ////ADDE IN VER4.0
            /// TOTAL ROWS
            $gross_amnt      += $it_table_value;
            $datatable_value .= ("</td>");

            //Order Discount
            $display_class  = '';
            $it_table_value = isset($items->order_discount) ? $items->order_discount : 0;
            $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $this->price($it_table_value, array("currency" => $fetch_other_data['order_currency']));
            $datatable_value .= ("</td>");

            //Cart Discount
            $display_class  = '';
            $it_table_value = isset($items->cart_discount) ? $items->cart_discount : 0;
            $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $this->price($it_table_value, array("currency" => $fetch_other_data['order_currency']));
            $datatable_value .= ("</td>");

            //Total Discount
            $display_class  = '';
            $it_table_value = isset($items->total_discount) ? $items->total_discount : 0;
            $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $this->price($it_table_value, array("currency" => $fetch_other_data['order_currency']));

            ////ADDE IN VER4.0
            /// TOTAL ROWS
            $discount_amnt   += $it_table_value;
            $datatable_value .= ("</td>");

            //Order Shipping
            $display_class  = '';
            $it_table_value = isset($items->order_shipping) ? $items->order_shipping : 0;
            $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $this->price($it_table_value, array("currency" => $fetch_other_data['order_currency']));

            ////ADDE IN VER4.0
            /// TOTAL ROWS
            $shipping_amnt   += $it_table_value;
            $datatable_value .= ("</td>");

            //Order Shipping Tax
            $display_class  = '';
            $it_table_value = isset($items->order_shipping_tax) ? $items->order_shipping_tax : 0;
            $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $this->price($it_table_value, array("currency" => $fetch_other_data['order_currency']));

            ////ADDE IN VER4.0
            /// TOTAL ROWS
            $shipping_tax_amnt += $it_table_value;
            $datatable_value   .= ("</td>");

            //Order Tax
            $display_class  = '';
            $it_table_value = isset($items->order_tax) ? $items->order_tax : 0;
            $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $this->price($it_table_value, array("currency" => $fetch_other_data['order_currency']));

            ////ADDE IN VER4.0
            /// TOTAL ROWS
            $order_tax_amnt  += $it_table_value;
            $datatable_value .= ("</td>");

            //Total Tax
            $display_class  = '';
            $it_table_value = isset($items->total_tax) ? $items->total_tax : 0;
            $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $this->price($it_table_value, array("currency" => $fetch_other_data['order_currency']));

            ////ADDE IN VER4.0
            /// TOTAL ROWS
            $total_tax_amnt  += $it_table_value;
            $datatable_value .= ("</td>");

            //Part Refund
            $display_class     = '';
            $order_refund_amnt = $this->it_get_por_amount($items->order_id);

            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= (isset($order_refund_amnt[$items->order_id]) ? $this->price($order_refund_amnt[$items->order_id],
                array("currency" => $fetch_other_data['order_currency'])) : $this->price(0,
                array("currency" => $fetch_other_data['order_currency'])));

            ////ADDE IN VER4.0
            /// TOTAL ROWS
            $part_refund_amnt += $order_refund_amnt[$items->order_id];
            $datatable_value  .= ("</td>");
            $part_refund      = (isset($order_refund_amnt[$items->order_id]) ? $order_refund_amnt[$items->order_id] : 0);


            //Order Total
            $display_class  = '';
            $it_table_value = isset($items->order_total) ? ($items->order_total) - $part_refund : 0;
            $it_table_value = $it_table_value == 0 ? $it_null_val : $it_table_value;
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");
            $datatable_value .= $this->price($it_table_value, array("currency" => $fetch_other_data['order_currency']));

            ////ADDE IN VER4.0
            /// TOTAL ROWS
            $net_amnt        += $it_table_value;
            $datatable_value .= ("</td>");

            ////ADDE IN VER4.0
            /// INVOICE ACTION
            $display_class = '';
            if ($this->table_cols[$index_cols++]['status'] == 'hide') {
                $display_class = 'display:none';
            }
            $datatable_value .= ("<td style='" . $display_class . "'>");

            $datatable_value .= '<a href="javascript:void(0);" title="' . esc_html__("Generate Invoice",
                    __IT_REPORT_WCREPORT_TEXTDOMAIN__) . '" class="it_pdf_invoice button" data-order-id="' . $items->order_id . '"><i class="fa fa-file-text-o "></i></a>';

            //COMPATIBLE WITH WOO INVOICE
            if (class_exists("WC_pdf_admin")) {
                $datatable_value .= '<a href="' . admin_url() . 'edit.php?post_type=shop_order&pdfid=' . $items->order_id . '"><i class="fa fa-file-pdf-o button "></i></a>';
            }
            //COMPATIBLE WITH CODECANYON WOO INVOICE
            if (class_exists("WooPDF")) {
                $datatable_value .= '<a href="' . admin_url() . 'edit.php?post_type=shop_order&wpd_proforma=' . $items->order_id . '"><i class="fa fa-download button "></i></a>';
            }

            $datatable_value .= ("</tr>");
        }
    }

    ////ADDED IN VER4.0
    /// TOTAL ROW
    $it_detail_view        = $this->it_get_woo_requests('it_view_details', "no", true);
    $datatable_value_total = '';
    $table_name_total      = "details";
    if ($it_detail_view == "yes") {
        $table_name_total       = $table_name . "_with_items";
        $this->table_cols_total = $this->table_columns_total($table_name_total);
        $datatable_value_total  .= ("<tr>");
        $datatable_value_total  .= "<td>$order_count</td>";
        $datatable_value_total  .= "<td>$product_count</td>";
        $datatable_value_total  .= "<td>$product_qty</td>";
        $datatable_value_total  .= "<td>" . (($total_rate) == 0 ? $this->price(0) : $this->price($total_rate)) . "</td>";
        $datatable_value_total  .= "<td>" . (($product_amnt) == 0 ? $this->price(0) : $this->price($product_amnt)) . "</td>";
        $datatable_value_total  .= "<td>" . (($product_discount) == 0 ? $this->price(0) : $this->price($product_discount)) . "</td>";
        $datatable_value_total  .= "<td>" . (($net_amnt) == 0 ? $this->price(0) : $this->price($net_amnt)) . "</td>";
        $datatable_value_total  .= ("</tr>");
    } else {
        $table_name_total = $table_name . "_no_items";

        $this->table_cols_total = $this->table_columns_total($table_name_total);

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
    }

} elseif ($file_used == "search_form") {
    ?>
    <form class='alldetails search_form_report' action='' method='post'>
        <input type='hidden' name='action' value='submit-form'/>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Date From', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
            <input name="it_from_date" id="pwr_from_date" type="text" readonly='true' class="datepick"/>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Date To', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
            <input name="it_to_date" id="pwr_to_date" type="text" readonly='true' class="datepick"/>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Order ID', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-calendar"></i></span>
            <input name="it_id_order" type="text" class=""/>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Customer', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-user"></i></span>
            <input name="it_first_name_text" type="text" class=""/>
        </div>

        <?php
        /////////////////
        //CUSTOM TAXONOMY
        $key    = isset($_GET['smenu']) ? $_GET['smenu'] : $_GET['parent'];
        $args_f = array("page" => $key);
        echo $this->make_custom_taxonomy($args_f);
        ?>

        <?php
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_category_id');

        if ($this->get_form_element_permission('it_category_id') || $permission_value != '') {
            if ( ! $this->get_form_element_permission('it_category_id') && $permission_value != '') {
                $col_style = 'display:none';
            }

            //if(count($permission_value)==1) $col_style='display:none';
            ?>
            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Category', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-tags"></i></span>
                <?php
                $args = array(
                    'orderby'      => 'name',
                    'order'        => 'ASC',
                    'hide_empty'   => 1,
                    'hierarchical' => 0,
                    'exclude'      => '',
                    'include'      => '',
                    'child_of'     => 0,
                    'number'       => '',
                    'pad_counts'   => false

                );

                //$categories = get_categories($args);
                $current_category = $this->it_get_woo_requests_links('it_category_id', '', true);

                $current_category = $permission_value;

                $categories = get_terms('product_cat', $args);
                $option     = '';
                foreach ($categories as $category) {
                    $selected = '';
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($category->term_id, $permission_value)) {
                        continue;
                    }

                    if ( ! $this->get_form_element_permission('it_category_id') && $permission_value != '') {
                        $selected = "selected";
                    }


                    if (is_array($current_category) && in_array($category->term_id, $current_category)) {
                        $selected = "selected";
                    }

                    $option .= '<option value="' . $category->term_id . '" ' . $selected . '>';
                    $option .= $category->name;
                    $option .= ' (' . $category->count . ')';
                    $option .= '</option>';
                }
                ?>
                <select name="it_category_id[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('it_category_id') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
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
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_product_id');
        if ($this->get_form_element_permission('it_product_id') || $permission_value != '') {

            if ( ! $this->get_form_element_permission('it_product_id') && $permission_value != '') {
                $col_style = 'display:none';
            }
            ?>


            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Product', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-gear"></i></span>
                <?php
                $products        = $this->it_get_product_woo_data('all');
                $option          = '';
                $current_product = $this->it_get_woo_requests_links('it_product_id', '', true);
                //echo $current_product;

                foreach ($products as $product) {

                    $selected = '';
                    if (is_array($permission_value) && ! in_array($product->id, $permission_value)) {
                        continue;
                    }
                    /*if(!$this->get_form_element_permission('it_product_id') &&  $permission_value!='')
						$selected="selected";


					//if($current_product==$product->id)
					if(in_array($product->id,$current_product))
						$selected="selected";*/
                    $option .= "<option $selected value='" . $product->id . "' >" . $product->label . " </option>";
                }


                ?>
                <select name="it_product_id[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">

                    <?php
                    if ($this->get_form_element_permission('it_product_id') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
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
                <?php _e('Customer', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-user"></i></span>
            <?php
            $customers = $this->it_get_woo_customers_orders();
            $option    = '';
            foreach ($customers as $customer) {
                $option .= "<option value='" . $customer->id . "' >" . $customer->label . " ($customer->counts)</option>";
            }
            ?>
            <select name="it_customers_paid[]" multiple="multiple" size="5" data-size="5" class="chosen-select-search">
                <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                <?php
                echo $option;
                ?>
            </select>

        </div>

        <?php
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_orders_status' || $permission_value != '');
        if ($this->get_form_element_permission('it_orders_status') || $permission_value != '') {
            if ( ! $this->get_form_element_permission('it_orders_status') && $permission_value != '') {
                $col_style = 'display:none';
            }
            ?>

            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Status', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-check"></i></span>
                <?php
                $it_order_status = $this->it_get_woo_orders_statuses();

                ////ADDED IN VER4.0
                /// APPLY DEFAULT STATUS AT FIRST
                $shop_status_selected = '';
                if ($this->it_shop_status) {
                    $shop_status_selected = explode(",", $this->it_shop_status);
                }

                $option = '';
                foreach ($it_order_status as $key => $value) {

                    $selected = "";
                    if (is_array($permission_value) && ! in_array($key, $permission_value)) {
                        continue;
                    }

                    /*if(!$this->get_form_element_permission('it_orders_status') &&  $permission_value!='')
						$selected="selected";*/

                    ////ADDED IN VER4.0
                    /// APPLY DEFAULT STATUS AT FIRST
                    if (is_array($shop_status_selected) && in_array($key, $shop_status_selected)) {
                        $selected = "selected";
                    }

                    $option .= "<option value='" . $key . "' $selected >" . $value . "</option>";
                }
                ?>

                <select name="it_orders_status[]" multiple="multiple" size="5" data-size="5"
                        class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('it_orders_status') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
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
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_countries_code');
        if ($this->get_form_element_permission('it_countries_code') || $permission_value != '') {
            if ( ! $this->get_form_element_permission('it_countries_code') && $permission_value != '') {
                $col_style = 'display:none';
            }

            ?>
            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('Country', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-globe"></i></span>
                <?php
                $country_data = $this->it_get_paying_woo_state('billing_country');
                $country      = $this->it_get_woo_countries();
                $option       = '';
                foreach ($country_data as $countries) {

                    $selected = '';
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($countries->id, $permission_value)) {
                        continue;
                    }

                    /*if(!$this->get_form_element_permission('it_countries_code') &&  $permission_value!='')
						$selected="selected";*/


                    $it_table_value = $country->countries[$countries->id];
                    $option         .= "<option $selected value='" . $countries->id . "' >" . $it_table_value . "</option>";
                }

                $country_states      = $this->it_get_woo_country_of_state();
                $json_country_states = json_encode($country_states);
                //print_r($json_country_states);
                ?>
                <select id="it_adr_country" name="it_countries_code[]" multiple="multiple" size="5" data-size="5"
                        class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('it_countries_code') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
                        <?php
                    }
                    ?>
                    <?php
                    echo $option;
                    ?>
                </select>

                <script type="text/javascript">
                    "use strict";
                    jQuery(document).ready(function ($) {

                        var country_state = '';
                        country_state =<?php echo $json_country_states?>;

                        $("#it_adr_country").change(function () {
                            var country_val = $(this).val();

                            if (country_val == null) {
                                return false;
                            }

                            var option_data = Array();
                            var optionss = '<option value="-1">Select All</option>';
                            var i = 1;
                            $.each(country_state, function (key, val) {

                                if (country_val.indexOf(val.parent_id) >= 0 || country_val == "-1") {
                                    optionss += '<option value="' + val.id + '">' + val.label + '</option>';
                                    option_data[val.id] = val.label;
                                }
                                i++;
                            });

                            $('#it_adr_state').empty(); //remove all child nodes
                            $("#it_adr_state").html(optionss);
                            $('#it_adr_state').trigger("chosen:updated");
                        });


                    });

                </script>

            </div>

            <?php
        }
        $col_style        = '';
        $permission_value = $this->get_form_element_value_permission('it_states_code');
        if ($this->get_form_element_permission('it_states_code') || $permission_value != '') {
            if ( ! $this->get_form_element_permission('it_states_code') && $permission_value != '') {
                $col_style = 'display:none';
            }
            ?>

            <div class="col-md-6" style=" <?php echo $col_style; ?>">
                <div class="awr-form-title">
                    <?php _e('State', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <span class="awr-form-icon"><i class="fa fa-map"></i></span>
                <?php
                //$state_codes = $this->it_get_paying_woo_state('shipping_state','shipping_country');
                //$this->it_get_woo_country_of_state();
                //$this->it_get_woo_bsn($items->billing_country,$items->billing_state_code);
                $state_codes = $this->it_get_paying_woo_state('billing_state', 'billing_country');
                $option      = '';
                foreach ($state_codes as $state) {
                    $selected = "";
                    //CHECK IF IS IN PERMISSION
                    if (is_array($permission_value) && ! in_array($state->id, $permission_value)) {
                        continue;
                    }

                    /*if(!$this->get_form_element_permission('it_states_code') &&  $permission_value!='')
						$selected="selected";*/

                    $it_table_value = $this->it_get_woo_bsn($state->billing_country, $state->id);
                    $option         .= "<option value='" . $state->id . "' >" . $it_table_value . " ($state->billing_country)</option>";
                }
                ?>

                <select id="it_adr_state" name="it_states_code[]" multiple="multiple" size="5" data-size="5"
                        class="chosen-select-search">
                    <?php
                    if ($this->get_form_element_permission('it_states_code') && (( ! is_array($permission_value)) || (is_array($permission_value) && in_array('all',
                                    $permission_value)))) {
                        ?>
                        <option value="-1"><?php _e('Select All', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></option>
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
                <?php _e('Postcode(Zip)', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-map-marker"></i></span>
            <input name="it_bill_post_code" type="text"/>
        </div>


        <!--<div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Min & Max By', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-arrows-h"></i></span>
                    <select name="order_meta_key[]" id="order_meta_key2" class="order_meta_key normal_view_only">
                        <option value="-1">Select All</option>
                        <option value="_order_total">Order Net Amount</option>
                        <option value="_order_discount">Order Discount Amount</option>
                        <option value="_order_shipping">Order Shipping Amount</option>
                        <option value="_order_shipping_tax">Order Shipping Tax Amount</option>
                    </select>
                    <br />
                    <span class="description"><?php _e("Enable this selection by uncheck 'Show Order Item Details'
", __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>

                 <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Min Amount', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
                    <span class="awr-form-icon"><i class="fa fa-battery-0"></i></span>
                    <input name="min_amount" type="text"/>
                    <br />
                    <span class="description"><?php _e("Enable this selection by uncheck 'Show Order Item Details'
", __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>

                 <div class="col-md-6">
                    <div class="awr-form-title">
                        <?php _e('Max Amount', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                    </div>
					<span class="awr-form-icon"><i class="fa fa-battery-4"></i></span>
                    <input name="max_amount" type="text"/>
                    <br />
                    <span class="description"><?php _e("Enable this selection by uncheck 'Show Order Item Details'
", __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?></span>
                </div>-->

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Email', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-envelope-o"></i></span>
            <input name="it_email_text" type="text"/>
        </div>


        <?php
        $custom_fields = get_option(__IT_REPORT_WCREPORT_FIELDS_PERFIX__ . 'set_default_fields');
        if (is_array($custom_fields)) {
            ?>

            <div class="col-md-12 ">
                <div class="awr-form-title awr-product-addon-title"
                     style="padding: 7px 5px 10px;text-align: center;background: #f2c811;color: #fff;">
                    <?php _e('Custom Fields', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
                </div>
                <div class="awr-product-addon-fields">

                    <?php
                    ///////////CUSTOM FIELDS///////////
                    $custom_fields = get_option(__IT_REPORT_WCREPORT_FIELDS_PERFIX__ . 'set_default_fields');

                    //print_r($custom_fields);
                    $gravity_form_custom_fields  = array();
                    $product_addon_custom_fields = array();

                    global $wpdb;
                    foreach ($custom_fields as $op_fields) {


                        //echo $op_fields;

                        $id_fieldss = explode("_", $op_fields);
                        $id_field   = $id_fieldss[0];
                        $html       = '';
                        //if(get_post_type($id_field)!='global_product_addon') continue;
//						if(get_post_type($id_field)!='global_product_addon') {
//							$html .= '<input type="text" name="it_' . $op_fields .'"/>';
//						}else{
                        if (1) {


                            if (defined("GRAVITY_MANAGER_URL")) {

                                $types = $wpdb->get_results("SELECT display_meta FROM {$wpdb->prefix}gf_form_meta",
                                    ARRAY_A);
                                if ($types != null && is_array($types)) {

                                    foreach ($types as $type) {
                                        //print_r($type['display_meta']);
                                        $form = json_decode($type['display_meta']);
                                        //print_r($form->fields[1]->label);
                                        foreach ($form->fields as $fields) {

                                            $gid_fieldss = str_replace("_", " ", $op_fields);
                                            $value       = ($fields->label);
                                            $glabel      = ($fields->label);

                                            if ($value != $gid_fieldss) {
                                                continue;
                                            }

                                            $gravity_form_custom_fields[] = $op_fields;

                                            $gtype = $fields->type;

                                            switch ($gtype) {

                                                case "text":
                                                    $choices = $fields->choices;

                                                    $html .= '<input type="text" name="it_' . $op_fields . '">';
                                                    break;

                                                case "number":
                                                    $choices = $fields->choices;

                                                    $html .= '<input type="text" name="it_' . $op_fields . '">';
                                                    break;

                                                case "select":
                                                    $choices = $fields->choices;

                                                    $html .= '<select name="it_' . $op_fields . '"><option value="">' . esc_html__("Choose One",
                                                            __IT_REPORT_WCREPORT_TEXTDOMAIN__) . '</option>';
                                                    foreach ($choices as $choice) {
                                                        $item_text  = $choice->text;
                                                        $item_value = $choice->value;

                                                        $html .= '<option value="' . $item_value . '">' . $item_text . '</option>';
                                                    }
                                                    $html .= '</select>';

                                                    break;

                                                case "multiselect":
                                                    $choices = $fields->choices;

                                                    $html .= '<span class="awr-form-icon"><i class="fa fa-list"></i></span><select name="it_' . $op_fields . '[]" multiple="multiple" size="5"  data-size="5" class="chosen-select-search"><option value="-1">' . esc_html__("Select All",
                                                            __IT_REPORT_WCREPORT_TEXTDOMAIN__) . '</option>';
                                                    foreach ($choices as $choice) {
                                                        $item_text  = $choice->text;
                                                        $item_value = $choice->value;

                                                        $html .= '<option value="' . $item_value . '">' . $item_text . '</option>';
                                                    }
                                                    $html .= '</select>';

                                                    break;

                                                case "checkbox":
                                                    $choices = $fields->choices;
                                                    foreach ($choices as $choice) {
                                                        $item_text  = $choice->text;
                                                        $item_value = $choice->value;

                                                        $html .= $item_text . '<input type="checkbox" name="it_' . $op_fields . '[]" value="' . $item_value . '" />';

                                                    }
                                                    break;

                                                case "radio":
                                                    $choices = $fields->choices;
                                                    foreach ($choices as $choice) {
                                                        $item_text  = $choice->text;
                                                        $item_value = $choice->value;

                                                        $html .= $item_text . '<input type="radio" name="it_' . $op_fields . '" value="' . $item_value . '" />';

                                                    }
                                                    break;
                                            }

                                        }
                                    }

                                }

                            }


                            $id_fieldss = str_replace($id_field . "_", "", $op_fields);
                            $types      = $wpdb->get_results("SELECT meta2.post_id as post_id,meta.meta_value FROM {$wpdb->prefix}postmeta as meta LEFT JOIN {$wpdb->prefix}postmeta as meta2 ON meta.post_id=meta2.post_id where meta2.post_id='$id_field' AND meta.meta_key='_product_addons' GROUP BY meta.meta_value",
                                ARRAY_A);

                            if ($types != null && is_array($types) && ! in_array($op_fields,
                                    $gravity_form_custom_fields)) {
                                foreach ($types as $type) {
                                    $form = unserialize($type['meta_value']);
                                    foreach ($form as $fields) {
                                        if ($fields['type'] == 'custom_textarea' || $fields['type'] == 'file_upload') {
                                            continue;
                                        }

                                        $value       = ($fields['options']);
                                        $description = ($fields['description']);
                                        $parent      = str_replace(" ", "___", $fields['name']);
                                        if ($parent != $id_fieldss) {
                                            continue;
                                        }

                                        $product_addon_custom_fields[] = $op_fields;

                                        $parent_label = get_the_title($type['post_id']) . ' - ' . $fields['name'] . '(' . $fields['type'] . ')';

                                        switch ($fields['type']) {

                                            case "custom_price" :

                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = sanitize_title($opt['label']);
                                                    $min       = $fields['options']['min'];
                                                    $max       = $fields['options']['max'];
                                                    $html      .= '<input type="number" name="it_' . $id_fieldss . '[' . $value_opt . ']" min="' . $min . '" max="' . $max . '" />';
                                                }

                                                break;

                                            case "input_multiplier" :

                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = sanitize_title($opt['label']);
                                                    $min       = $opt['min'];
                                                    $max       = $opt['max'];
                                                    $html      .= $opt['label'] . '<input type="number" name="it_' . $id_fieldss . '[' . $value_opt . ']" min="' . $min . '" max="' . $max . '" />';
                                                }


                                                break;

                                            case "checkbox" :

                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = ($opt['label']);
                                                    $min       = $opt['min'];
                                                    $max       = $opt['max'];
                                                    $html      .= $opt['label'] . '<input type="checkbox" name="it_' . $id_fieldss . '[]" min="' . $min . '" max="' . $max . '" value="' . $value_opt . '" />';
                                                }

                                                break;

                                            //NOT INCLUDE IN SEARCH FIELDS
                                            case "custom_textareaa" :

                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = sanitize_title($opt['label']);
                                                    $html      .= $opt['label'] . '<textarea name="it_' . $id_fieldss . '[' . $value_opt . ']"  /></textarea>';
                                                }
                                                break;

                                            case "custom" :
                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = sanitize_title($opt['label']);
                                                    $html      .= $opt['label'] . '<input type="text" name="it_' . $id_fieldss . '[' . $value_opt . ']"  />';
                                                }
                                                break;

                                            case "custom_email" :
                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = sanitize_title($opt['label']);
                                                    $html      .= $opt['label'] . '<input type="text" name="it_' . $id_fieldss . '---' . $value_opt . '"  />';
                                                }
                                                break;

                                            case "custom_letters_only" :
                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = sanitize_title($opt['label']);
                                                    $html      .= $opt['label'] . '<input type="text" name="it_' . $id_fieldss . '[' . $value_opt . ']"  />';
                                                }
                                                break;

                                            case "custom_letters_or_digits" :
                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = sanitize_title($opt['label']);
                                                    $html      .= $opt['label'] . '<input type="text" name="it_' . $id_fieldss . '[' . $value_opt . ']"  />';
                                                }
                                                break;

                                            case "custom_digits_only" :
                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = sanitize_title($opt['label']);
                                                    $html      .= $opt['label'] . '<input type="text" name="it_' . $id_fieldss . '[' . $value_opt . ']"  />';
                                                }
                                                break;

                                            case "radiobutton" :
                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = ($opt['label']);
                                                    $min       = $opt['min'];
                                                    $max       = $opt['max'];
                                                    $html      .= $opt['label'] . '<input type="radio" name="it_' . $id_fieldss . '" min="' . $min . '" max="' . $max . '" value="' . $value_opt . '" />';
                                                }
                                                break;

                                            case "custom_text" :
                                                $display = $fields['restrictions_type'];

                                                switch ($display) {

                                                    case 'any_text':
                                                        $value_opt = sanitize_title($options['label']);
                                                        $html      .= $options['label'] . '<input type="text" name="it_' . $op_fields . '"  />';
                                                        break;

                                                    case 'only_letters':
                                                        $value_opt = sanitize_title($options['label']);
                                                        $html      .= $options['label'] . '<input type="text" name="it_' . $op_fields . '"  />';
                                                        break;

                                                    case 'only_numbers':
                                                        $value_opt = sanitize_title($options['label']);
                                                        $html      .= $options['label'] . '<input type="text" name="it_' . $op_fields . '"  />';
                                                        break;

                                                    case 'only_letters_numbers':
                                                        $value_opt = sanitize_title($options['label']);
                                                        $html      .= $options['label'] . '<input type="text" name="it_' . $op_fields . '"  />';
                                                        break;

                                                    case 'email':
                                                        $value_opt = sanitize_title($options['label']);
                                                        $html      .= $options['label'] . '<input type="text" name="it_' . $op_fields . '"  />';
                                                        break;

                                                }

                                                break;

                                            case "multiple_choice" :

                                                if ($fields['display'] == 'radiobutton') {
                                                    $options = $fields['options'];
                                                    $i       = 0;
                                                    foreach ($options as $opt) {
                                                        $value_opt = ($opt['label']);
                                                        $min       = $opt['min'];
                                                        $max       = $opt['max'];
                                                        $html      .= $opt['label'] . '<input type="radio" name="it_' . $id_fieldss . '" min="' . $min . '" max="' . $max . '" value="' . $value_opt . '" />';
                                                    }
                                                }


                                                if ($fields['display'] == 'select') {
                                                    $options = $fields['options'];
                                                    $i       = 0;
                                                    $html    .= '<select name="it_' . $op_fields . '"><option value="">' . esc_html__("Choose One",
                                                            __IT_REPORT_WCREPORT_TEXTDOMAIN__) . '</option>';
                                                    foreach ($options as $opt) {
                                                        $value_opt = ($opt['label']);
                                                        $min       = $opt['min'];
                                                        $max       = $opt['max'];
                                                        $html      .= '<option value="' . $value_opt . '">' . $opt['label'] . '</option>';
                                                    }
                                                    $html .= '</select>';
                                                }

                                                break;

                                            case "select" :

                                                $html .= '<select name="it_' . $id_fieldss . '"><option value="">' . esc_html__("Choose One",
                                                        __IT_REPORT_WCREPORT_TEXTDOMAIN__) . '</option> ';

                                                $options = $fields['options'];
                                                $i       = 0;
                                                foreach ($options as $opt) {
                                                    $value_opt = ($opt['label']);
                                                    $html      .= '<option value="' . $value_opt . '">' . $opt['label'] . '</option>';
                                                }

                                                $html .= '</select>';

                                                break;

                                        }
                                        $html .= '<br /><div class="description">' . $description . '</div>';

                                    }
                                }
                                $id_fieldss = str_replace("___", " ", $id_fieldss);
                            }

                            if ( ! in_array($op_fields, $product_addon_custom_fields) && ! in_array($op_fields,
                                    $gravity_form_custom_fields)) {
                                $id_fieldss = $op_fields;
                                $html       .= '<input name="it_' . $op_fields . '" type="text" placeholder="' . get_option($op_fields . "_translate") . '"/>';
                            }

                        }


                        if ($html != '') {
                            echo '
							<div class="col-md-6">
								<div class="awr-form-title">
									' . get_option($op_fields . "_translate", $id_fieldss) . '
								</div>
								' . $html . '
							</div>';
                        }

                    }
                    ?>
                </div>
            </div>
        <?php } ?>


        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Order By', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>
            <span class="awr-form-icon"><i class="fa fa-sort-alpha-asc"></i></span>
            <div class="row">
                <div class="col-md-6">

                    <select name="sort_by" id="sort_by" class="sort_by">
                        <option value="order_id" selected="selected">Order ID</option>
                        <option value="billing_name">Name</option>
                        <option value="billing_email">Email</option>
                        <option value="order_date">Date</option>
                        <option value="post_status">Status</option>
                    </select>
                </div>
                <div class="col-md-6">
                    <select name="order_by" id="order_by" class="order_by">
                        <option value="ASC">Ascending</option>
                        <option value="DESC" selected="selected">Descending</option>
                    </select>
                </div>
            </div>
        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Show Order Item Details', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>

            <input name="it_view_details" type="checkbox" value="yes" checked/>

        </div>

        <div class="col-md-6">
            <div class="awr-form-title">
                <?php _e('Coupon Used Only', __IT_REPORT_WCREPORT_TEXTDOMAIN__); ?>
            </div>

            <input name="it_use_coupon" type="checkbox" value="yes"/>

        </div>


        <div class="col-md-12">
            <?php
            $it_hide_os         = $this->otder_status_hide;
            $it_publish_order   = 'no';
            $it_order_item_name = '';
            $it_coupon_code     = '';
            $it_coupon_codes    = '';
            $it_payment_method  = '';

            $it_variation_only = $this->it_get_woo_requests_links('variation_only', '-1', true);
            $it_order_meta_key = '';

            $data_format = $this->it_get_woo_requests_links('date_format', get_option('date_format'), true);


            $it_variation_id = '-1';
            $amont_zero      = '';

            ?>

            <input type="hidden" name="it_hide_os" value="<?php echo $it_hide_os; ?>"/>
            <input type="hidden" name="publish_order" value="<?php echo $it_publish_order; ?>"/>
            <input type="hidden" name="order_item_name" value="<?php echo $it_order_item_name; ?>"/>
            <input type="hidden" name="coupon_code" value="<?php echo $it_coupon_code; ?>"/>
            <input type="hidden" name="it_codes_of_coupon" value="<?php echo $it_coupon_codes; ?>"/>
            <input type="hidden" name="payment_method" value="<?php echo $it_payment_method; ?>"/>
            <input type="hidden" name="variation_id" value="<?php echo $it_variation_id; ?>"/>
            <input type="hidden" name="variation_only" value="<?php echo $it_variation_only; ?>"/>
            <input type="hidden" name="date_format" value="<?php echo $data_format; ?>"/>

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
