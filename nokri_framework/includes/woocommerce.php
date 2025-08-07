<?php
// Free packgae function
if (!function_exists('nokri_free_package')) {

    function nokri_free_package($product_id, $user_id = '') {
        global $nokri;
        if ($user_id != '') {
            $uid = $user_id;
        } else {
            $uid = get_current_user_id();
        }
        if (get_user_meta($uid, '_sb_reg_type', true) == '0')
            return '';
        $cand_is_search = (int) get_post_meta($product_id, 'is_candidates_search', true);
        $cand_search_val = (int) get_post_meta($product_id, 'candidate_search_values', true);
        $c_terms = get_terms('job_class', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
        $cand_bump_add = (int) get_post_meta($product_id, 'pack_bump_ads_limit', true);

        if (count($c_terms) > 0) {
            foreach ($c_terms as $c_term) {
                $meta_name = '';
                $get_origtermid = nokri_get_origional_term_id($c_term->term_id);
                $meta_name = 'package_job_class_' . $get_origtermid;
                $class = (int) get_post_meta($product_id, $meta_name, true);
                if ($class == '-1') {
                    update_user_meta($uid, $meta_name, (int) '-1');
                } else if (is_numeric($class) && $class > 0) {
                    $no_of_jobs = (int) get_user_meta($uid, $meta_name, true);
                    if ($class != 0) {
                        $new_jobs = $class + $no_of_jobs;
                    }
                    update_user_meta($uid, $meta_name, (int) $new_jobs);
                }
            }
        }
        $is_pkg_free = get_post_meta($product_id, 'op_pkg_typ', true);

        if ($is_pkg_free == 1) {
            update_user_meta($uid, 'avail_free_package', (int) '1');
        }

        //adding bump up adds
        if ($cand_bump_add != "") {
            $bump_up = get_user_meta($uid, 'bump_ads_limit', true);
            if ($bump_up == "") {
                update_user_meta($uid, 'bump_ads_limit', $cand_bump_add);
            } else if ($bump_up == "-1") {
                update_user_meta($uid, 'bump_ads_limit', "-1");
            } else {
                $new_bump_up = (int) $cand_bump_add + (int) $bump_up;
                update_user_meta($uid, 'bump_ads_limit', $new_bump_up);
            }
        }

        //feature profiles logic
        //Features profiles
        $emp_feature_profile = (int) get_post_meta($product_id, 'pack_emp_featured_profile', true);
        if ($emp_feature_profile == '-1') {
            update_user_meta($uid, '_emp_feature_profile', '-1');
        } else {
            $expiry_feature_date = get_user_meta($uid, '_emp_feature_profile', true);
            $exp_date = strtotime($expiry_feature_date);
            $today = strtotime(date('Y-m-d'));
            if ($expiry_feature_date && $today > $exp_date) {
                $new_featur_expiry = date('Y-m-d', strtotime("+$emp_feature_profile days"));
            } else {
                $date_created = date_create($expiry_feature_date);
                date_add($date_created, date_interval_create_from_date_string("$emp_feature_profile days"));
                $new_featur_expiry = date_format($date_created, "Y-m-d");
            }
            update_user_meta($uid, '_emp_feature_profile', $new_featur_expiry);
        }
        // Expiry date logic
        $days = get_post_meta($product_id, 'package_expiry_days', true);
        if ($days == '-1') {
            update_user_meta($uid, '_sb_expire_ads', '-1');
        } else {
            $expiry_date = get_user_meta($uid, '_sb_expire_ads', true);
            $e_date = strtotime($expiry_date);
            $today = strtotime(date('Y-m-d'));
            if ($expiry_date && $today > $e_date) {
                $new_expiry = date('Y-m-d', strtotime("+$days days"));
            } else {
                $date = date_create($expiry_date);
                date_add($date, date_interval_create_from_date_string("$days days"));
                $new_expiry = date_format($date, "Y-m-d");
            }
            update_user_meta($uid, '_sb_expire_ads', $new_expiry);
            /* Updating candidate search */
            if ((isset($nokri['cand_search_mode'])) && $nokri['cand_search_mode'] == '2') {
                /* Counting existing values */
                if ($cand_search_val == '-1') {
                    update_user_meta($uid, '_sb_cand_search_value', (int) '-1');
                } else if (is_numeric($cand_search_val) && $cand_search_val > 0) {
                    $no_of_search = get_user_meta($uid, '_sb_cand_search_value', $cand_is_search);

                    if ($no_of_search != "") {

                        $new_searches = $cand_search_val + (int) $no_of_search;
                    } else {

                        $new_searches = $cand_search_val;
                    }
                    update_user_meta($uid, '_sb_cand_search_value', (int) $new_searches);
                } else {
                    update_user_meta($uid, '_sb_cand_search_value', (int) '0');
                }
                update_user_meta($uid, '_sb_cand_is_search', $cand_is_search);
            }
        }
    }

}
// Free packgae function for candidate
if (!function_exists('nokri_free_package_for_candidate')) {

    function nokri_free_package_for_candidate($product_id, $user_id = '') {
        global $nokri;
        if ($user_id != '') {
            $uid = $user_id;
        } else {
            $uid = get_current_user_id();
        }
        if (get_user_meta($uid, '_sb_reg_type', true) == '1')
            return '';

        $candidate_jobs = (int) get_post_meta($product_id, 'candidate_jobs', true);
        $candidate_feature_list = (int) get_post_meta($product_id, 'candidate_feature_list', true);
        // Expiry date logic
        $days = get_post_meta($product_id, 'package_expiry_days', true);
        if(!empty($days)) {
            if ($days == '-1') {
                update_user_meta($uid, '_sb_expire_ads', '-1');
            } else {
                $expiry_date = get_user_meta($uid, '_sb_expire_ads', true);
                $e_date = strtotime($expiry_date);
                $today = strtotime(date('Y-m-d'));
                if ($expiry_date && $today > $e_date) {
                    $new_expiry = date('Y-m-d', strtotime("+$days days"));
                } else {
                    $date = date_create($expiry_date);
                    date_add($date, date_interval_create_from_date_string("$days days"));
                    $new_expiry = date_format($date, "Y-m-d");
                }
                update_user_meta($uid, '_sb_expire_ads', $new_expiry);
            }
        }
        /* Job info */
        if ($candidate_jobs != '') {
            update_user_meta($uid, '_candidate_applied_jobs', $candidate_jobs);
        }
        /* free package */
        $is_pkg_free = get_post_meta($product_id, 'op_pkg_typ', true);

        if ($is_pkg_free == 1) {
            update_user_meta($uid, 'avail_free_package', (int) '1');
        }
        /* Feature profile info */
        $days = get_post_meta($product_id, 'candidate_feature_list', true);


        if(!empty($days)){
            if ($days == '-1') {
                update_user_meta($uid, '_candidate_feature_profile', '-1');
                update_user_meta($uid, '_is_candidate_featured', '1');
            } else {
                $expiry_date = get_user_meta($uid, '_candidate_feature_profile', true);
                $e_date = strtotime($expiry_date);
                $today = strtotime(date('Y-m-d'));
                if ($expiry_date && $today > $e_date) {
                    $new_expiry = date('Y-m-d', strtotime("+$days days"));
                } else {
                    $date = date_create($expiry_date);
                    date_add($date, date_interval_create_from_date_string("$days days"));
                    $new_expiry = date_format($date, "Y-m-d");
                }
                update_user_meta($uid, '_is_candidate_featured', '1');
                update_user_meta($uid, '_candidate_feature_profile', $new_expiry);
            }
        }
    }

}
// After Successfull payment
add_action('woocommerce_order_status_completed', 'nokri_after_payment');
if (!function_exists('nokri_after_payment')) {

    function nokri_after_payment($order_id) {
        global $nokri;
        global $woocommerce;
        $order = new WC_Order($order_id);
        $uid = get_post_meta($order_id, '_customer_user', true);
        if($uid == "")
        {
            $uid = $order->get_user_id();
        }
        $user_type = get_user_meta($uid, '_sb_reg_type', true);
        $product_id = isset($nokri['job_alert_package']) ? $nokri['job_alert_package'] : "";

        if ($user_type == "1") 
        {
            $c_terms = get_terms('job_class', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
            $items = $order->get_items();
            foreach ($items as $item) {
                $product_id = $item['product_id'];
                
                $cand_is_search = (int) get_post_meta($product_id, 'is_candidates_search', true);
                $cand_search_val = (int) get_post_meta($product_id, 'candidate_search_values', true);
                if (count((array) $c_terms) > 0) {
                    foreach ($c_terms as $c_term) {
                        $meta_name = '';
                        $get_origtermid = nokri_get_origional_term_id($c_term->term_id);
                        $meta_name = 'package_job_class_' . $get_origtermid;
                        $class = (int) get_post_meta($product_id, $meta_name, true);
                        if ($class == '-1') {
                            update_user_meta($uid, $meta_name, (int) '-1');
                        } else if (is_numeric($class) && $class > 0) {
                            $no_of_jobs = get_user_meta($uid, $meta_name, true);
                            $new_jobs = $class + (int) ( $no_of_jobs);
                            update_user_meta($uid, $meta_name, (int) $new_jobs);
                        }
                    }
                }
                $cand_bump_add = (int) get_post_meta($product_id, 'pack_bump_ads_limit', true);
                if ($cand_bump_add != "") {
                    $bump_up = get_user_meta($uid, 'bump_ads_limit', true);
                    if ($bump_up == "") {
                        update_user_meta($uid, 'bump_ads_limit', $cand_bump_add);
                    } else if ($bump_up == "-1") {
                        update_user_meta($uid, 'bump_ads_limit', "-1");
                    } else {
                        $new_bump_up = (int) $cand_bump_add + (int) $bump_up;
                        update_user_meta($uid, 'bump_ads_limit', $new_bump_up);
                    }
                }

                //Features profiles
                $emp_feature_profile = (int) get_post_meta($product_id, 'pack_emp_featured_profile', true);
                if ($emp_feature_profile == '-1') {
                    update_user_meta($uid, '_emp_feature_profile', '-1');
                } else {
                    $expiry_feature_date = get_user_meta($uid, '_emp_feature_profile', true);
                    $exp_date = strtotime($expiry_feature_date);
                    $today = strtotime(date('Y-m-d'));
                    if ($expiry_feature_date && $today > $exp_date) {
                        $new_featur_expiry = date('Y-m-d', strtotime("+$emp_feature_profile days"));
                    } else {
                        $date_created = date_create($expiry_feature_date);
                        date_add($date_created, date_interval_create_from_date_string("$emp_feature_profile days"));
                        $new_featur_expiry = date_format($date_created, "Y-m-d");
                    }
                    update_user_meta($uid, '_emp_feature_profile', $new_featur_expiry);
                }
                // Expiry date logic
                $days = get_post_meta($product_id, 'package_expiry_days', true);
                if ($days == '-1') {
                    update_user_meta($uid, '_sb_expire_ads', '-1');
                } else {
                    $expiry_date = get_user_meta($uid, '_sb_expire_ads', true);
                    $e_date = strtotime($expiry_date);
                    $today = strtotime(date('Y-m-d'));
                    if ($expiry_date && $today > $e_date) {
                        $new_expiry = date('Y-m-d', strtotime("+$days days"));
                    } else {
                        $date = date_create($expiry_date);
                        date_add($date, date_interval_create_from_date_string("$days days"));
                        $new_expiry = date_format($date, "Y-m-d");
                    }
                    update_user_meta($uid, '_sb_expire_ads', $new_expiry);
                    /* Updating candidate search */
                    if ((isset($nokri['cand_search_mode'])) && $nokri['cand_search_mode'] == '2') {
                        /* Counting existing values */
                        if ($cand_search_val == '-1') {
                            update_user_meta($uid, '_sb_cand_search_value', (int) '-1');
                        } else if (is_numeric($cand_search_val) && $cand_search_val > 0) {
                            $no_of_search = get_user_meta($uid, '_sb_cand_search_value', true);
                            $new_searches = $cand_search_val + (int) $no_of_search;
                            update_user_meta($uid, '_sb_cand_search_value', (int) $new_searches);
                        }
                        update_user_meta($uid, '_sb_cand_is_search', $cand_is_search);
                    }
                }
            }
        } else if ($user_type == "0") {
            $items = $order->get_items();
            foreach ($items as $item) {
                $product_id = $item['product_id'];
                $op_pkg_for = get_post_meta($product_id, 'op_pkg_for', true);
                if ($op_pkg_for != "3") {
                    $candidate_jobs = (int) get_post_meta($product_id, 'candidate_jobs', true);
                    $candidate_feature_list = (int) get_post_meta($product_id, 'candidate_feature_list', true);
                    // Expiry date logic
                    $days = get_post_meta($product_id, 'package_expiry_days', true);
                    if ($days == '-1') {
                        update_user_meta($uid, '_sb_expire_ads', '-1');
                    } else {
                        $expiry_date = get_user_meta($uid, '_sb_expire_ads', true);
                        $e_date = strtotime($expiry_date);
                        $today = strtotime(date('Y-m-d'));
                        if ($expiry_date && $today > $e_date) {
                            $new_expiry = date('Y-m-d', strtotime("+$days days"));
                        } else {
                            $date = date_create($expiry_date);
                            date_add($date, date_interval_create_from_date_string("$days days"));
                            $new_expiry = date_format($date, "Y-m-d");
                        }
                        update_user_meta($uid, '_sb_expire_ads', $new_expiry);
                    }
                    /* Job info */
                    if ($candidate_jobs != '' && $candidate_jobs == '-1') {

                        update_user_meta($uid, '_candidate_applied_jobs', '-1');
                    } else {
                        $saved_jobs = (int) get_user_meta($uid, '_candidate_applied_jobs', true);
                        $total_apply_job = $candidate_jobs;
                        if ($saved_jobs != "" && $saved_jobs == '-1') {

                            $total_apply_job = $candidate_jobs;
                            update_user_meta($uid, '_candidate_applied_jobs', $total_apply_job);
                        } else {

                            $total_apply_job = $saved_jobs + $candidate_jobs;
                        }
                        update_user_meta($uid, '_candidate_applied_jobs', $total_apply_job);
                    }

                    /* Feature profile info */
                    $days = get_post_meta($product_id, 'candidate_feature_list', true);
                    if ($days == '-1') {
                        update_user_meta($uid, '_candidate_feature_profile', '-1');
                        update_user_meta($uid, '_is_candidate_featured', '1');
                    } else {
                        $expiry_date = get_user_meta($uid, '_candidate_feature_profile', true);
                        $e_date = strtotime($expiry_date);
                        $today = strtotime(date('Y-m-d'));
                        if ($expiry_date && $today > $e_date) {
                            $new_expiry = date('Y-m-d', strtotime("+$days days"));
                        } else {
                            $date = date_create($expiry_date);
                            date_add($date, date_interval_create_from_date_string("$days days"));
                            $new_expiry = date_format($date, "Y-m-d");
                        }
                        update_user_meta($uid, '_candidate_feature_profile', $new_expiry);
                        update_user_meta($uid, '_is_candidate_featured', '1');
                    }
                } else if ($op_pkg_for == "3") {

                    $item_id = $item->get_id();
                    $alert_data = wc_get_order_item_meta($item_id, 'temp_alert', true);
                    $random_string = nokri_randomString(5);
                    update_user_meta($uid, '_cand_alerts_' . $uid . $random_string, ($alert_data));
                    delete_user_meta($uid, 'temp_test_alert');
                    if (get_user_meta($uid, '_cand_alerts_en', true) == '') {
                        update_user_meta($uid, '_cand_alerts_en', 1);
                    }
                }
            }
        }
    }

}