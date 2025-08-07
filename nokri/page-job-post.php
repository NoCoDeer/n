<?php
/* Template Name: Job Post */
get_header();
global $nokri;
$current_id = get_current_user_id();
/* Checking if Employer have Account Members with job posting permissions */
$emp_id = get_user_meta($current_id, 'account_owner', true);
$member_id = get_user_meta($current_id, '_sb_is_member', true);
if (isset($member_id) && $member_id != '') {

    $user_id = $emp_id;
} else {
    $user_id = $current_id;
}

/* Signin  Page */
$signin = '';
if ((isset($nokri['sb_sign_in_page'])) && $nokri['sb_sign_in_page'] != '') {
    $signin = ($nokri['sb_sign_in_page']);
}
if (!is_user_logged_in()) {
    echo nokri_redirect(esc_url(get_the_permalink($signin)));
}
$rtl_class = $expire_pkg = '';
if (is_rtl()) {
    $rtl_class = "flip";
}
$mapType = nokri_mapType();
$allow_map = isset($nokri['nokri_allow_map']) ? $nokri['nokri_allow_map'] : true;
if ($allow_map) {
    if ($mapType == 'google_map') {
        wp_enqueue_script('google-map-callback', false);
    }
}
if (get_user_meta($user_id, '_sb_reg_type', true) == '0') {
    echo nokri_redirect(esc_url(home_url('/')));
}

/* package Page */
$package_page = '';
if ((isset($nokri['package_page'])) && $nokri['package_page'] != '') {
    $package_page = ($nokri['package_page']);
}
$restrict_update = false;
if (!isset($_GET['id'])) {

    if (!is_super_admin($user_id)) {

        $crnt_user = get_current_user_id();
        /* Check Employer Have Free Jobs */
        $job_class_free = nokri_simple_jobs();
        /* Checking if an Employer have account Members */
        $emp_id = get_user_meta($crnt_user, 'account_owner', true);
        $member_id = get_user_meta($crnt_user, '_sb_is_member', true);

        $regular_jobs = get_user_meta($user_id, 'package_job_class_' . $job_class_free, true);

        $expiry_date = get_user_meta($user_id, '_sb_expire_ads', true);
        $today = date("Y-m-d");
        $expiry_date_string = strtotime($expiry_date);
        $today_string = strtotime($today);
        $expire_jobs = false;

        if ($regular_jobs == 0 || $today_string > $expiry_date_string) {
            $expire_jobs = true;
            nokri_simple_jobs($expire_jobs);
            /*             * * Checking if Employer don't have Jobs Package ** */
            if ($emp_id != "" && $member_id != "") {
                echo '<script>alert("employer dont have package")</script>';
                nokri_redirect(esc_url(get_the_permalink()));
                exit();
            }
            echo nokri_redirect(esc_url(get_the_permalink($package_page)));
        }
    }
}

$job_id = $job_ext_url = $job_apply_with = $job_ext_mail = $job_ext_whatsapp = $job_deadline = $job_type = $job_level = $job_shift = $job_experience = $job_skills = $job_salary = $job_qualifications = $job_currency = $ad_mapLocation = $ad_map_lat = $ad_map_long = $level = $cats = $sub_cats_html = $sub_sub_cats_html = $sub_sub_sub_cats_html = $cats_html = $tags = $job_phone = $description = $job_posts = $title = $levelz = $job_salary_type = $country_states = $country_cities = $country_towns = $questions = '';
if ((isset($nokri['sb_default_lat_job'])) && $nokri['sb_default_lat_job'] != '') {
    $ad_map_lat = ($nokri['sb_default_lat_job']);
}
$ad_map_long = '';
if ((isset($nokri['sb_default_lat_job'])) && $nokri['sb_default_lat_job'] != '') {
    $ad_map_long = ($nokri['sb_default_long_job']);
}

if (isset($_GET['id'])) {
    $job_id = $_GET['id'];
    $job_id = filter_var($job_id, FILTER_SANITIZE_NUMBER_INT);  // Remove any non-numeric characters
    $job_id = intval($job_id);
    $expiry_date = get_user_meta($user_id, '_sb_expire_ads', true);

    $today = date("Y-m-d");
    $expiry_date_string = strtotime($expiry_date);
    $today_string = strtotime($today);
    $expire_pkg = false;
    if ($today_string > $expiry_date_string && !current_user_can('administrator')) {
        $expire_pkg = true;
    }

    if (get_post_field('post_author', $job_id) != $user_id && !is_super_admin(get_current_user_id())) {
        echo nokri_redirect(esc_url(home_url('/')));
    }
    $is_restrict = isset($nokri['restrict_job_update']) ? $nokri['restrict_job_update'] : false;

    $restrict_update = false;
    if ($is_restrict) {
        $update_days = isset($nokri['days_of_jobs_update']) ? $nokri['days_of_jobs_update'] : 5;
        $publish_job_date = get_the_time('Y-m-d', $job_id);
        $update_limit_date = date('Y-m-d', strtotime($publish_job_date . " + $update_days days"));
        $update_limit_date = strtotime($update_limit_date);
        if ($today_string > $update_limit_date) {
            $restrict_update = true;
        }
    }

    /* Getting Post Meta Values For Edit Page */

    $job_type = wp_get_post_terms($job_id, 'job_type', array("fields" => "ids"));
    $job_type = isset($job_type[0]) ? $job_type[0] : '';
    $job_qualifications = wp_get_post_terms($job_id, 'job_qualifications', array("fields" => "ids"));
    $job_qualifications = isset($job_qualifications[0]) ? $job_qualifications[0] : '';
    $job_level = wp_get_post_terms($job_id, 'job_level', array("fields" => "ids"));
    $job_level = isset($job_level[0]) ? $job_level[0] : '';
    $job_salary = wp_get_post_terms($job_id, 'job_salary', array("fields" => "ids"));
    $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
    $job_salary_type = wp_get_post_terms($job_id, 'job_salary_type', array("fields" => "ids"));
    $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
    $job_experience = wp_get_post_terms($job_id, 'job_experience', array("fields" => "ids"));
    $job_experience = isset($job_experience[0]) ? $job_experience[0] : '';
    $job_currency = wp_get_post_terms($job_id, 'job_currency', array("fields" => "ids"));
    $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
    $job_shift = wp_get_post_terms($job_id, 'job_shift', array("fields" => "ids"));
    $job_shift = isset($job_shift[0]) ? $job_shift[0] : '';
    $job_skills = wp_get_post_terms($job_id, 'job_skills', array("fields" => "ids"));
    $get_attachment = get_post_meta($job_id, '_job_attachment', true);
    $job_deadline = get_post_meta($job_id, '_job_date', true);
    $ad_mapLocation = get_post_meta($job_id, '_job_address', true);
    $ad_map_lat = get_post_meta($job_id, '_job_lat', true);
    $ad_map_long = get_post_meta($job_id, '_job_long', true);
    $job_phone = get_post_meta($job_id, '_job_phone', true);
    $job_posts = get_post_meta($job_id, '_job_posts', true);
    $job_apply_with = get_post_meta($job_id, '_job_apply_with', true);
    $job_ext_url = get_post_meta($job_id, '_job_apply_url', true);
    $job_ext_mail = get_post_meta($job_id, '_job_apply_mail', true);
    $job_ext_whatsapp = get_post_meta($job_id, '_job_apply_whatsapp', true);
    $job_questions = get_post_meta($job_id, '_job_questions', true);
    $cats = nokri_get_jobs_cats($job_id);
    $level = count((array) $cats);
    /* Make cats selected on update Job */
    $ad_cats = nokri_get_cats('job_category', 0, 0, false);
    $cats_html = '';
    foreach ($ad_cats as $ad_cat) {
        $selected = '';
        if ($level > 0 && $ad_cat->term_id == $cats[0]['id']) {
            $selected = esc_attr('selected="selected"');
        }
        $cats_html .= '<option value="' . esc_attr($ad_cat->term_id) . '" ' . esc_attr($selected) . '>' . esc_html($ad_cat->name) . '</option>';
    }
    if ($level >= 2) {
        $ad_sub_cats = nokri_get_cats('job_category', $cats[0]['id'], 0, false);
        $sub_cats_html = '';
        foreach ($ad_sub_cats as $ad_cat) {
            $selected = '';
            if ($level > 0 && $ad_cat->term_id == $cats[1]['id']) {
                $selected = esc_attr('selected="selected"');
            }
            $sub_cats_html .= '<option value="' . esc_attr($ad_cat->term_id) . '" ' . esc_attr($selected) . '>' . esc_html($ad_cat->name) . '</option>';
        }
    }
    if ($level >= 3) {
        $ad_sub_sub_cats = nokri_get_cats('job_category', $cats[1]['id'], 0, false);
        $sub_sub_cats_html = '';
        foreach ($ad_sub_sub_cats as $ad_cat) {
            $selected = '';
            if ($level > 0 && $ad_cat->term_id == $cats[2]['id']) {
                $selected = esc_attr('selected="selected"');
            }
            $sub_sub_cats_html .= '<option value="' . esc_attr($ad_cat->term_id) . '" ' . esc_attr($selected) . '>' . esc_html($ad_cat->name) . '</option>';
        }
    }
    if ($level >= 4) {
        $ad_sub_sub_sub_cats = nokri_get_cats('job_category', $cats[2]['id'], 0, false);
        $sub_sub_sub_cats_html = '';
        foreach ($ad_sub_sub_sub_cats as $ad_cat) {
            $selected = '';
            if ($level > 0 && $ad_cat->term_id == $cats[3]['id']) {
                $selected = esc_attr('selected="selected"');
            }
            $sub_sub_sub_cats_html .= '<option value="' . esc_attr($ad_cat->term_id) . '" ' . esc_attr($selected) . '>' . esc_html($ad_cat->name) . '</option>';
        }
    }
//Countries
    $countries = nokri_get_jobs_cats($job_id, '', true);
    $levelz = count((array) $countries);

    /* Make location selected on update ad */
    $ad_countries = nokri_get_cats('ad_location', 0);
    $country_html = '';
    foreach ($ad_countries as $ad_country) {
        $selected = '';
        if ($levelz > 0 && $ad_country->term_id == $countries[0]['id']) {
            $selected = esc_attr('selected="selected"');
        }
        $country_html .= '<option value="' . esc_attr($ad_country->term_id) . '" ' . esc_attr($selected) . '>' . esc_html($ad_country->name) . '</option>';
    }

    if ($levelz >= 2) {

        $ad_states = nokri_get_cats('ad_location', $countries[0]['id']);
        $country_states = '';
        foreach ($ad_states as $ad_state) {
            $selected = '';
            if ($levelz > 0 && $ad_state->term_id == $countries[1]['id']) {
                $selected = esc_attr('selected="selected"');
            }
            $country_states .= '<option value="' . esc_attr($ad_state->term_id) . '" ' . esc_attr($selected) . '>' . esc_html($ad_state->name) . '</option>';
        }
    }
    if ($levelz >= 3) {
        $ad_country_cities = nokri_get_cats('ad_location', $countries[1]['id']);
        $country_cities = '';
        foreach ($ad_country_cities as $ad_city) {
            $selected = '';
            if ($levelz > 0 && $ad_city->term_id == $countries[2]['id']) {
                $selected = esc_attr('selected="selected"');
            }
            $country_cities .= '<option value="' . esc_attr($ad_city->term_id) . '" ' . esc_attr($selected) . '>' . esc_html($ad_city->name) . '</option>';
        }
    }

    if ($levelz >= 4) {
        $ad_country_town = nokri_get_cats('ad_location', $countries[2]['id']);
        $country_towns = '';
        foreach ($ad_country_town as $ad_town) {
            $selected = '';
            if ($levelz > 0 && $ad_town->term_id == $countries[3]['id']) {
                $selected = esc_attr('selected="selected"');
            }
            $country_towns .= '<option value="' . esc_attr($ad_town->term_id) . '" ' . esc_attr($selected) . '>' . esc_html($ad_town->name) . '</option>';
        }
    }

    /* Displaying Tags */
    $tags_array = wp_get_object_terms($job_id, 'job_tags', array('fields' => 'names'));
    $tags = implode(',', $tags_array);
    $post = get_post($job_id);
    $description = $post->post_content;
    $title = $post->post_title;
} else {
    $ad_cats = nokri_get_cats('job_category', 0, 0, false);
    $cats_html = '';
    foreach ($ad_cats as $ad_cat) {
        $cats_html .= '<option value="' . esc_attr($ad_cat->term_id) . '">' . esc_html($ad_cat->name) . '</option>';
    }

//Countries
    $ad_country = nokri_get_cats('ad_location', 0);
    $country_html = '<option disabled selected>' . esc_html__('Select Country', 'nokri') . '</option>';
    foreach ($ad_country as $ad_count) {
        $country_html .= '<option value="' . esc_attr($ad_count->term_id ). '">' . esc_html($ad_count->name) . '</option>';
    }
}

$user_info = wp_get_current_user();
$user_crnt_id = $user_id;
/* Check Location & Phone Number Updated Or Not */
if ($ad_mapLocation == '') {
    $ad_mapLocation = get_user_meta($user_crnt_id, '_emp_map_location', true);
}
if ($ad_map_lat == '') {
    $ad_map_lat = get_user_meta($user_crnt_id, '_emp_map_lat', true);
}
if ($ad_map_long == '') {
    $ad_map_long = get_user_meta($user_crnt_id, '_emp_map_long', true);
}
if ($job_phone == '') {
    $job_phone = get_user_meta($user_crnt_id, '_sb_contact', true);
}
$headline = get_user_meta($user_crnt_id, '_user_headline', true);
$job_post_name = $user_info->display_name;

nokri_user_not_logged_in();
/* For job post note */
$job_note = $nokri['job_post_note'];
$job_post_note = '';
if (isset($job_note) && $job_note != '') {
    $job_post_note = '<p>' . esc_html($job_note) . '</p>';
}
/* For job category level text */
$job_cat_level_1 = ( isset($nokri['job_cat_level_1']) && $nokri['job_cat_level_1'] != "" ) ? $nokri['job_cat_level_1'] : esc_html__('Job category', 'nokri');
$job_cat_level_2 = ( isset($nokri['job_cat_level_2']) && $nokri['job_cat_level_2'] != "" ) ? $nokri['job_cat_level_2'] : esc_html__('Sub category', 'nokri');
$job_cat_level_3 = ( isset($nokri['job_cat_level_3']) && $nokri['job_cat_level_3'] != "" ) ? $nokri['job_cat_level_3'] : esc_html__('Sub sub category', 'nokri');
$job_cat_level_4 = ( isset($nokri['job_cat_level_4']) && $nokri['job_cat_level_4'] != "" ) ? $nokri['job_cat_level_4'] : esc_html__('Sub sub sub category', 'nokri');

/* For job Location level text */
$job_country_level_heading = ( isset($nokri['job_country_level_heading']) && $nokri['job_country_level_heading'] != "" ) ? $nokri['job_country_level_heading'] : '';
/* For Map  text */
$map_location_txt = ( isset($nokri['job_map_heading_txt']) && $nokri['job_map_heading_txt'] != "" ) ? $nokri['job_map_heading_txt'] : '';

$job_country_level_1 = ( isset($nokri['job_country_level_1']) && $nokri['job_country_level_1'] != "" ) ? $nokri['job_country_level_1'] : '';

$job_country_level_2 = ( isset($nokri['job_country_level_2']) && $nokri['job_country_level_2'] != "" ) ? $nokri['job_country_level_2'] : '';

$job_country_level_3 = ( isset($nokri['job_country_level_3']) && $nokri['job_country_level_3'] != "" ) ? $nokri['job_country_level_3'] : '';

$job_country_level_4 = ( isset($nokri['job_country_level_4']) && $nokri['job_country_level_4'] != "" ) ? $nokri['job_country_level_4'] : '';

$bg_url = nokri_section_bg_url();
/* Is map show */
$is_lat_long = isset($nokri['allow_lat_lon_btn']) ? $nokri['allow_lat_lon_btn'] : true;
/* Job apply with */
$job_apply_with_option = isset($nokri['job_apply_with']) ? $nokri['job_apply_with'] : false;
/* Job apply with */
$job_post_form = isset($nokri['job_post_form']) ? $nokri['job_post_form'] : '0';
/* Job attachment */
$job_attachment = isset($nokri['default_job_attachment']) ? $nokri['default_job_attachment'] : '0';
/* Job questionare */
$job_questionare = isset($nokri['allow_questinares']) ? $nokri['allow_questinares'] : false;
/* Job questionare */
$is_attachment = isset($get_attachment) && $get_attachment != '' ? '1' : '0';
/* required message */
$req_mess = esc_html__('This value is required', 'nokri');
$job_expiry_switch = isset($nokri['job_exp_limit_switch']) ? $nokri['job_exp_limit_switch'] : false;
$job_expiry_days = isset($nokri['job_exp_limit']) ? $nokri['job_exp_limit'] : "";
?>
<section class="n-pages-breadcrumb" <?php echo nokri_returnEcho($bg_url); ?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8  offset-lg-2 offset-md-2 offset-sm-2">
                <div class="n-breadcrumb-info">
                    <h1><?php echo esc_html__('Post a Job', 'nokri'); ?></h1>
                    <?php echo "" . ($job_post_note); ?>
                </div>
            </div>

        </div>
    </div>
</section>
<section class="n-job-pages-section">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 ">
                    <form class="n-jobpost" method="post" enctype="multipart/form-data" id="emp-job-post">
                    <div class="row">
                        <input id="is_update" name="is_update" value="<?php echo '' . esc_attr($job_id); ?>" type="hidden">
                        <input id="is_attachment" name="job_attachment" value="<?php echo '' . esc_attr($is_attachment); ?>" type="hidden">
                        <input type="hidden" id="country_level" name="country_level" value="<?php echo esc_attr($levelz); ?>" />
                        <input type="hidden" id="is_level" name="is_level" value="<?php echo esc_attr($level); ?>" />
                        <input type="hidden" name="" id="job_update_restrict"  value="<?php echo '' . esc_attr($restrict_update); ?>">
                        <div class="col-lg-8 col-md-8 col-sm-12 ">
                            <div class="row">
                                <!-- Job title -->
                                <div class="col-lg-12 col-md-12 col-sm-12 ">
                                    <div class="post-job-heading">
                                        <h3><?php echo esc_html__('Basic Information', 'nokri'); ?></h3>
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 ">
                                    <div class="form-group">
                                        <label><?php echo esc_html__('Job Title*', 'nokri'); ?></label>
                                        <input type="text" placeholder="<?php echo esc_attr__('Job Title', 'nokri'); ?>" value="<?php echo esc_attr($title); ?>" id="ad_title" data-parsley-required="true" name="job_title" class="form-control" data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                    </div>
                                    <?php
                                    if ($job_expiry_switch && $job_expiry_days != "") {
                                        echo '<input type="hidden" name="" id="job_expiry_limit"  value="' . esc_attr($job_expiry_days) . '">';
                                    }
                                    if ($restrict_update) {
                                        echo '<input type="hidden"   name="job_title" value="' . esc_attr($title) . '">';
                                    }
                                    ?>
                                </div>
                                <!--End categories levels -->
                                <div class="col-lg-12 col-md-12 col-sm-12 ">
                                    <div class="form-group">
                                        <label><?php echo esc_html($job_cat_level_1); ?></label>
                                        <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_attr($job_cat_level_1); ?>" data-parsley-required="true" id="job_cat" name="job_cat">
                                            <option value="0"><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                            <?php echo "" . $cats_html; ?>
                                        </select>
                                        <input type="hidden" name="job_cat_id" id="job_cat_id" value="" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 " id="second_level">
                                    <div class="form-group">
                                        <label><?php echo esc_html($job_cat_level_2); ?></label>
                                        <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_attr($job_cat_level_2); ?>" id="job_cat_second" name="job_cat_second">
                                            <option value="0"><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                            <?php echo '' . ($sub_cats_html); ?>
                                        </select>
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 " id="third_level">
                                    <div class="form-group">
                                        <label><?php echo esc_html($job_cat_level_3); ?></label>
                                        <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_attr($job_cat_level_3); ?>" id="job_cat_third" name="job_cat_third">
                                            <option value="0"><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                            <?php echo '' . ($sub_sub_cats_html); ?>
                                        </select>
                                        <input type="hidden" name="ad_cat_id" id="ad_cat_id" value="" />
                                    </div>
                                </div>
                                <div class="col-lg-6 col-md-6 col-sm-12 " id="forth_level">
                                    <div class="form-group">
                                        <label><?php echo esc_html($job_cat_level_4); ?></label>
                                        <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_attr($job_cat_level_4); ?>" id="job_cat_forth" name="job_cat_forth">
                                            <option value="0"><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                            <?php echo '' . ($sub_sub_sub_cats_html); ?>
                                        </select>
                                        <input type="hidden" name="ad_cat_id" id="ad_cat_id" value="" />
                                    </div>
                                </div>
                                <!--Job details -->
                                <div class="col-lg-12 col-md-12 col-sm-12 ">
                                    <div class="form-group">
                                        <label><?php echo esc_html__('Job Description', 'nokri'); ?></label>
                                        <textarea name="job_description" class="jquery-textarea my_texteditor" rows="10" cols="115"><?php echo "" . esc_html($description); ?></textarea>
                                        
                                    </div>
                                </div>
                                <div class="col-lg-12 col-md-12 col-sm-12 ">
                                    <div class="post-job-heading mt30">
                                        <h3><?php echo esc_html__('Job Details', 'nokri'); ?></h3>
                                    </div>
                                </div>
                                <!--Application deadline -->
                                
                                 
                                <div class="col-lg-6 col-md-6 col-sm-12 ">
                                    <div class="form-group">
                                        <label><?php echo esc_html__('Application deadline', 'nokri'); ?></label>
                                        <input type="text" value="<?php echo esc_attr($job_deadline); ?>" class="form-control datepicker-job-post"   data-parsley-required="true" <?php
                                        if ($expire_pkg) {
                                            echo esc_attr("disabled");
                                        }
                                        ?> name="job_date" placeholder="<?php echo esc_attr__('Application deadline*', 'nokri'); ?>"  data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>" autocomplete="off">
                                    </div>
                                </div>
                                <?php 
                                if ($job_post_form == '1') {
                                    echo '<div id="dynamic-fields"> ' . nokri_returnHTML($job_id) . '</div><input type="hidden" id="is_category_based" value="' . esc_attr($job_post_form) . '" />';
                                    ?>
                                    <?php if ($job_apply_with_option) { ?>
                                        <!--Apply With -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo esc_html__('Apply With Link', 'nokri'); ?></label>
                                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_attr__('Select an option', 'nokri'); ?>" name="job_apply_with" data-parsley-required="true" id="ad_external">
                                                    <?php
                                                    if (!empty($nokri['job_external_source'])) {
                                                        $exter = $inter = $mail = $whatsapp = false;
                                                        foreach ($nokri['job_external_source'] as $key => $value) {
                                                            if ($value == 'exter')
                                                                $exter = true;
                                                            if ($value == 'inter')
                                                                $inter = true;
                                                            if ($value == 'mail')
                                                                $mail = true;
                                                            if ($value == 'whatsapp')
                                                                $whatsapp = true;
                                                        }
                                                    }
                                                    ?> 
                                                    <option value="0"><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                                    <?php if ($exter) { ?>
                                                        <option value="exter" <?php
                                                        if ($job_apply_with == "exter") {
                                                            echo esc_attr('selected="selected"');
                                                        }
                                                        ?>><?php echo esc_html__('External Link', 'nokri'); ?></option>
                                                            <?php } if ($inter) { ?>
                                                        <option value="inter" <?php
                                                        if ($job_apply_with == "inter") {
                                                            echo esc_attr('selected="selected"');
                                                        }
                                                        ?>><?php echo esc_html__('Internal Link', 'nokri'); ?></option>
                                                            <?php } if ($mail) { ?>
                                                        <option value="mail" <?php
                                                        if ($job_apply_with == "mail") {
                                                            echo esc_attr('selected="selected"');
                                                        }
                                                        ?>><?php echo esc_html__('Email', 'nokri'); ?></option>
                                                                <?php
                                                            }
                                                            if ($whatsapp) {
                                                                ?>
                                                        <option value="whatsapp" <?php
                                                        if ($job_apply_with == "whatsapp") {
                                                            echo esc_attr('selected="selected"');
                                                        }
                                                        ?>><?php echo esc_html__('whatsapp', 'nokri'); ?></option>
                                                            <?php }
                                                            ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!--Apply With Extra Feild-->
                                        <div class="col-lg-6 col-md-6 col-sm-12 " id="job_external_link_feild" <?php
                                        if ($job_ext_url == "" || $job_apply_with != "exter") {
                                            echo esc_attr('style="display: none;"');
                                        }
                                        ?> >
                                            <div class="form-group">
                                                <label><?php echo esc_html__('Put Link Here', 'nokri'); ?></label>
                                                <input type="text" class="form-control" placeholder="<?php echo esc_attr__('Put Link Here', 'nokri'); ?>" name="job_external_url" value="<?php echo esc_attr($job_ext_url); ?>"  id="job_external_url" data-parsley-type="url"> 
                                            </div>
                                        </div>
                                        <!--Apply With Email-->
                                        <div class="col-lg-6 col-md-6 col-sm-12 " id="job_external_mail_feild" <?php
                                        if ($job_ext_mail == "") {
                                            echo esc_attr('style="display: none;"');
                                        }
                                        ?> >
                                            <div class="form-group">
                                                <label><?php echo esc_html__('Enter Valid Email', 'nokri'); ?></label>
                                                <input type="text" class="form-control" placeholder="<?php echo esc_attr__('Enter email where resume recieved', 'nokri'); ?>" name="job_external_mail" value="<?php echo esc_attr($job_ext_mail); ?>"  id="job_external_email" data-parsley-type="email"> 
                                            </div>
                                        </div>
                                        <!--Apply With whatsapp-->
                                        <div class="col-lg-6 col-md-6 col-sm-12 " id="job_external_whatsapp_feild" <?php
                                        if ($job_ext_whatsapp == "") {
                                            echo esc_attr('style="display: none;"');
                                        }
                                        ?> >
                                            <div class="form-group">
                                                <label><?php echo esc_html__('Enter Valid Whatsapp Number', 'nokri'); ?></label>
                                                <input type="text" class="form-control" placeholder="<?php echo esc_attr__('Enter Whatsapp number', 'nokri'); ?>" name="job_external_whatsapp" value="<?php echo esc_attr($job_ext_whatsapp); ?>"  id="job_external_whatsapp" data-parsley-type="number"> 
                                            </div>
                                        </div>    
                                    <?php } ?>
                                    <?php
                                } else {
                                    if (nokri_feilds_operat('allow_job_qualifications', 'show')) {
                                        ?>
                                        <!--Job qualifications -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('quali_txt', esc_html__('Job qualifications', 'nokri')); ?></label> 
                                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo nokri_feilds_label('quali_txt', esc_attr__('Job qualifications', 'nokri')); ?>" name="job_qualifications" <?php echo nokri_feilds_operat('allow_job_qualifications', 'required'); ?> data-parsley-error-message="<?php echo esc_attr__('This value is required', 'nokri'); ?>">
                                                    <option value=""><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                                    <?php echo nokri_job_post_taxonomies('job_qualifications', $job_qualifications); ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } if (nokri_feilds_operat('allow_job_type', 'show')) { ?>
                                        <!--Job type -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('type_txt', esc_html__('Job type', 'nokri')); ?></label>
                                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo nokri_feilds_label('type_txt', esc_attr__('Job type', 'nokri')); ?>" name="job_type" <?php echo nokri_feilds_operat('allow_job_type', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                                    <option value=""><?php echo esc_html__('Select Option', 'nokri'); ?>
                                                        <?php echo nokri_job_post_taxonomies('job_type', $job_type); ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } if (nokri_feilds_operat('allow_job_salary_type', 'show')) { ?>
                                        <!--Salary type -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('salary_type_txt', esc_html__('Salary type', 'nokri')); ?></label>
                                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo nokri_feilds_label('salary_type_txt', esc_attr__('Salary type', 'nokri')); ?>" name="job_salary_type" <?php echo nokri_feilds_operat('allow_job_salary_type', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                                    <option value=""><?php echo esc_html__('Select Option', 'nokri'); ?>
                                                        <?php echo nokri_job_post_taxonomies('job_salary_type', $job_salary_type); ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } if (nokri_feilds_operat('allow_job_currency', 'show')) { ?>
                                        <!--Salary currency -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('job_currency_txt', esc_html__('Salary currency', 'nokri')); ?>
                                                </label>
                                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo nokri_feilds_label('job_currency_txt', esc_attr__('Salary currency', 'nokri')); ?>" name="job_currency" <?php echo nokri_feilds_operat('allow_job_currency', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                                    <option value=""><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                                    <?php echo nokri_job_post_taxonomies('job_currency', $job_currency); ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } if (nokri_feilds_operat('allow_job_salary', 'show')) { ?>
                                        <!--Salary offers -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('job_salary_txt', esc_html__('Salary range', 'nokri')); ?></label>
                                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo nokri_feilds_label('job_salary_txt', esc_attr__('Salary range', 'nokri')); ?>" name="job_salary" <?php echo nokri_feilds_operat('allow_job_salary', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                                    <option value=""><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                                    <?php echo nokri_job_post_taxonomies('job_salary', $job_salary); ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } if (nokri_feilds_operat('allow_job_experience', 'show')) { ?>
                                        <!--job experience -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('experience_txt', esc_html__('Job experience', 'nokri')); ?></label>
                                                <select class="js-example-basic-single" data-allow-clear="true" daattrder="<?php echo nokri_feilds_label('experience_txt', esc_attr__('Job experience', 'nokri')); ?>" name="job_experience" <?php echo nokri_feilds_operat('allow_job_experience', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                                    <option value=""><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                                    <?php echo nokri_job_post_taxonomies('job_experience', $job_experience); ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } if (nokri_feilds_operat('allow_job_shift', 'show')) { ?>
                                        <!--job shift -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('shift_txt', esc_html__('Job shift', 'nokri')); ?></label>
                                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo nokri_feilds_label('shift_txt', esc_attr__('Job shift', 'nokri')); ?>" name="job_shift" <?php echo nokri_feilds_operat('allow_job_shift', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                                    <option value=""><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                                    <?php echo nokri_job_post_taxonomies('job_shift', $job_shift); ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } if (nokri_feilds_operat('allow_job_level', 'show')) { ?>
                                        <!--job level -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('level_txt', esc_html__('Job level', 'nokri')); ?></label>
                                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo nokri_feilds_label('level_txt', esc_attr__('Job level', 'nokri')); ?>" name="job_level" <?php echo nokri_feilds_operat('allow_job_level', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                                    <option value=""><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                                    <?php echo nokri_job_post_taxonomies('job_level', $job_level); ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } if (nokri_feilds_operat('allow_job_vacancy', 'show')) { ?>
                                        <!--job vacancies -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('vacancy_txt', esc_html__('Number of vacancies', 'nokri')); ?></label>
                                                <input type="text" class="form-control" placeholder="<?php echo nokri_feilds_label('vacancy_txt', esc_attr__('Number of vacancies', 'nokri')); ?>" name="job_posts" value="<?php echo esc_attr($job_posts); ?>" <?php echo nokri_feilds_operat('allow_job_vacancy', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                            </div>
                                        </div>
                                    <?php } ?>

                                    <?php if ($job_apply_with_option) { ?>
                                        <!--Apply With -->
                                        <div class="col-lg-6 col-md-6 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo esc_html__('Apply With Link', 'nokri'); ?></label>
                                                <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_attr__('Select an option', 'nokri'); ?>" name="job_apply_with" data-parsley-required="true" id="ad_external" data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                                    <?php
                                                    if (!empty($nokri['job_external_source'])) {
                                                        $exter = $inter = $mail = $whatsapp = false;
                                                        foreach ($nokri['job_external_source'] as $key => $value) {
                                                            if ($value == 'exter')
                                                                $exter = true;
                                                            if ($value == 'inter')
                                                                $inter = true;
                                                            if ($value == 'mail')
                                                                $mail = true;
                                                            if ($value == 'whatsapp')
                                                                $whatsapp = true;
                                                        }
                                                    }
                                                    ?> 
                                                    <option value="0"><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                                    <?php if ($exter) { ?>
                                                        <option value="exter" <?php
                                                        if ($job_apply_with == "exter") {
                                                            echo esc_attr('selected="selected"');
                                                        }
                                                        ?>><?php echo esc_html__('External Link', 'nokri'); ?></option>
                                                            <?php } if ($inter) { ?>
                                                        <option value="inter" <?php
                                                        if ($job_apply_with == "inter") {
                                                            echo esc_attr('selected="selected"');
                                                        }
                                                        ?>><?php echo esc_html__('Internal Link', 'nokri'); ?></option>
                                                            <?php } if ($mail) { ?>
                                                        <option value="mail" <?php
                                                        if ($job_apply_with == "mail") {
                                                            echo esc_attr('selected="selected"');
                                                        }
                                                        ?>><?php echo esc_html__('Email', 'nokri'); ?></option>
                                                            <?php } if ($whatsapp) { ?>
                                                        <option value="whatsapp" <?php
                                                        if ($job_apply_with == "whatsapp") {
                                                            echo esc_attr('selected="selected"');
                                                        }
                                                        ?>><?php echo esc_html__('whatsapp', 'nokri'); ?></option>
                                                            <?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                        <!--Apply With Extra Feild-->
                                        <div class="col-lg-6 col-md-6 col-sm-12 " id="job_external_link_feild" <?php
                                        if ($job_ext_url == "" || $job_apply_with != "exter") {
                                            echo esc_attr('style="display: none;"');
                                        }
                                        ?> >
                                            <div class="form-group">
                                                <label><?php echo esc_html__('Put Link Here', 'nokri'); ?></label>
                                                <input type="text" class="form-control" placeholder="<?php echo esc_attr__('Put Link Here', 'nokri'); ?>" name="job_external_url" value="<?php echo esc_attr($job_ext_url); ?>"  id="job_external_url" data-parsley-type="url"> 
                                            </div>
                                        </div>
                                        <!--Apply With Email-->
                                        <div class="col-lg-6 col-md-6 col-sm-12 " id="job_external_mail_feild" <?php
                                        if ($job_ext_mail == "") {
                                            echo esc_attr('style="display: none;"');
                                        }
                                        ?> >
                                            <div class="form-group">
                                                <label><?php echo esc_html__('Enter Valid Email', 'nokri'); ?></label>
                                                <input type="text" class="form-control" placeholder="<?php echo esc_attr__('Enter email where resume recieved', 'nokri'); ?>" name="job_external_mail" value="<?php echo esc_attr($job_ext_mail); ?>"  id="job_external_email" data-parsley-type="email"> 
                                            </div>
                                        </div>
                                        <!--Apply With whatsapp-->
                                        <div class="col-lg-6 col-md-6 col-sm-12 " id="job_external_whatsapp_feild" <?php
                                        if ($job_ext_whatsapp == "") {
                                            echo esc_attr('style="display: none;"');
                                        }
                                        ?> >
                                            <div class="form-group">
                                                <label><?php echo esc_html__('Enter Valid Whatsapp Number', 'nokri'); ?></label>
                                                <input type="text" class="form-control" placeholder="<?php echo esc_attr__('Enter Whatsapp number', 'nokri'); ?>" name="job_external_whatsapp" value="<?php echo esc_attr($job_ext_whatsapp); ?>"  id="job_external_whatsapp" data-parsley-type="number"> 
                                            </div>
                                        </div>  
                                    <?php } ?>
                                    <?php if (nokri_feilds_operat('allow_job_skills', 'show')) { ?>
                                        <!--job skills -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('skills_txt', esc_html__('Job skills', 'nokri')); ?></label>
                                                <select class="js-example-basic-single" multiple data-allow-clear="true" data-placeholder="<?php echo nokri_feilds_label('skills_txt', esc_attr__('Job skills', 'nokri')); ?>" name="job_skills[]" <?php echo nokri_feilds_operat('allow_job_skills', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                                    <option value=""><?php echo esc_html__('Select Options', 'nokri'); ?></option>
                                                    <?php echo nokri_job_selected_skills('job_skills', '_job_skills', $job_skills); ?>
                                                </select>
                                            </div>
                                        </div>
                                    <?php } if (nokri_feilds_operat('allow_job_tags', 'show')) { ?>
                                        <!--job tags -->
                                        <div class="col-lg-12 col-md-12 col-sm-12 ">
                                            <div class="form-group">
                                                <label><?php echo nokri_feilds_label('tags_txt', esc_html__('Job tags', 'nokri')); ?></label>
                                                <input type="text" id="tags_tag_job" name="job_tags"  value="<?php echo '' . esc_attr($tags); ?>" class="form-control" data-role="tagsinput"  <?php echo nokri_feilds_operat('allow_job_tags', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>"/>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                } if ($job_attachment && $job_post_form == '0') {
                                    ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12 ">
                                        <div class="form-group">
                                            <label><?php echo esc_html__('Job Attachments', 'nokri'); ?></label>
                                            <div id="dropzone_custom" class="dropzone"></div> 
                                        </div>
                                    </div> 
                                    <?php
                                } if ($job_questionare) {
                                    $state = $exist = "";
                                    if (isset($job_questions) && !empty($job_questions)) {
                                        $state = "checked";
                                        $exist = 1;
                                    }
                                    ?>
                                    <input type="hidden" id="job_qstns_enable" value="1">
                                    <input type="hidden" id="job_qstns_exist" value="<?php echo esc_attr($exist); ?>">
                                    <div class="col-lg-12 col-md-12 col-sm-12 ">
                                        <div class="n-question-box">                      
                                            <div class="company-search-toggle">
                                                <div class="row">
                                                    <div class="col-lg-9 col-md-9  col-sm-12">
                                                        <h3><?php echo esc_html__('Add Questionnaire', 'nokri'); ?></h3>
                                                    </div>
                                                    <div class="col-lg-3 col-md-3  col-sm-12">
                                                        <div class="pull-right ">
                                                            <input id="job_qstns_toggle"  data-on="<?php echo esc_attr__('YES', 'nokri'); ?>" data-off="<?php echo esc_attr__('NO', 'nokri'); ?>" data-size="mini" <?php echo esc_attr($state); ?>  data-toggle="toggle" type="checkbox">
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                            <div class="questions content job_qstns mt30">
                                                <?php
                                                if (isset($job_questions) && !empty($job_questions)) {
                                                    foreach ($job_questions as $questions) {
                                                        ?>
                                                        <div class="row group">
                                                            <div class="col-lg-10 col-md-10 col-sm-12 ">
                                                                <div class="form-group">
                                                                    <label>
                                                                        <?php echo nokri_feilds_label('question_label', esc_html__('Job Question', 'nokri')); ?>
                                                                    </label>
                                                                    <input type="text" class="form-control jobs_questions" placeholder="<?php echo nokri_feilds_label('question_plc', esc_attr__('Job Question', 'nokri')); ?>" name="job_qstns[]" value="<?php echo esc_attr($questions); ?>">
                                                                </div>
                                                            </div>
                                                            <div class="col-md-2 col-sm-2">
                                                                <div class="form-group">
                                                                    <button type="button" class="btn btn-danger btnRemove">
                                                                        <?php echo nokri_feilds_label('question_rem_btn', esc_html__('Remove', 'nokri')); ?>
                                                                    </button>
                                                                </div>
                                                            </div>
                                                        </div>
                                                        <?php
                                                    }
                                                } else {
                                                    ?>
                                                    <div class="row group">
                                                        <div class="col-lg-10 col-md-10 col-sm-12 ">
                                                            <div class="form-group">
                                                                <label>
                                                                    <?php echo nokri_feilds_label('question_label', esc_html__('Job Question', 'nokri')); ?>
                                                                </label>
                                                                <input type="text" class="form-control" placeholder="<?php echo nokri_feilds_label('question_plc', esc_attr__('Job Question', 'nokri')); ?>" name="job_qstns[]" value="<?php echo esc_attr($questions); ?>">
                                                            </div>
                                                        </div>
                                                        <div class="col-md-2 col-sm-2 ">
                                                            <div class="form-group">
                                                                <button type="button" class="btn btn-danger btnRemove">
                                                                    <?php echo nokri_feilds_label('question_rem_btn', esc_html__('Remove', 'nokri')); ?>
                                                                </button>
                                                            </div>
                                                        </div>
                                                    </div>
                                                <?php } ?>
                                                <button type="button" id="question_btn" class="btn btn-success">
                                                    <?php echo nokri_feilds_label('question_ad_btn', esc_html__('Add More', 'nokri')); ?>
                                                </button>
                                            </div></div></div>
                                <?php } ?>
                            </div>
                        </div>
                        <!--Office Location -->
                        <?php
                        global $nokri;
                        ?>
                        <div class="col-lg-4 col-md-4 col-sm-12 ">
                        <?php
                        $is_allow = (isset($nokri['allow_remotely_jobs_post']) ? $nokri['allow_remotely_jobs_post'] : false);
                        if ($is_allow) {
                            $remotely_work = get_post_meta($job_id, '_n_remotely_work', true);
                            $check_box = ($remotely_work != "" ) ? ' checked="checked"' : '';
                            ?>
                            <!--Working Remotely Checkbox-->
                            <!-- <div class="col-lg-4 col-md-4 col-sm-12 "> -->
                                <div class="form-group">
                                    <label><h4><?php echo esc_html__('Work Remotely', 'nokri'); ?></h4></label>
                                    <input type ="checkbox" class="icheckbox_square remote_work" id ="checkbox-id" name ="n_remotely_work" <?php echo '' . esc_attr($check_box); ?>>
                                </div> 
                            <!-- </div> -->
                        <?php } ?>

                            <?php if (nokri_feilds_operat('allow_job_countries', 'show')) { ?>
                                <div class="post-job-heading">
                                    <h3><?php echo esc_html($job_country_level_heading); ?></h3>
                                </div>
                                <!--job country -->
                                <div class="form-group">
                                    <label><?php echo esc_html($job_country_level_1); ?></label>
                                    <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_attr($job_country_level_1); ?>" id="ad_country" name="ad_country"  <?php echo nokri_feilds_operat('allow_job_countries', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">

                                        <?php echo "" . ($country_html); ?>
                                    </select>
                                    <input type="hidden" name="ad_country_id" id="ad_country_id" value="" />
                                </div>
                                <?php
                            }
                            ?>
                            <!--job state -->
                            <div class="n_jobs_location">
                                <div class="form-group" id="ad_country_sub_div">
                                    <label><?php echo esc_html($job_country_level_2); ?></label>
                                    <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_attr($job_country_level_2); ?>" id="ad_country_states" name="ad_country_states">
                                        <option value="0"><?php echo esc_html__('Select an option', 'nokri'); ?></option>
                                        <?php echo "" . ($country_states); ?>
                                    </select>
                                </div>
                                <!--job city -->
                                <div class="form-group" id="ad_country_sub_sub_div">
                                    <label><?php echo esc_html($job_country_level_3); ?></label>
                                    <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_attr($job_country_level_3); ?>" id="ad_country_cities" name="ad_country_cities">
                                        <option value="0"><?php echo esc_html__('Select an option', 'nokri'); ?></option>
                                        <?php echo "" . ($country_cities); ?>
                                    </select>
                                </div>
                                <!--job town -->
                                <div class="form-group" id="ad_country_sub_sub_sub_div">
                                    <label><?php echo esc_html($job_country_level_4); ?></label>
                                    <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_attr($job_country_level_4); ?>" id="ad_country_towns" name="ad_country_towns">
                                        <option value="0"><?php echo esc_html__('Select an option', 'nokri'); ?></option>
                                        <?php echo "" . ($country_towns); ?>
                                    </select>
                                </div>
                                <?php if ($allow_map && $is_lat_long) { ?>
                                    <div class="form-group">
                                        <div class="post-job-heading mt30">
                                            <h3><?php echo '' . esc_html( $map_location_txt); ?> </h3>
                                        </div>
                                    </div>
                                    <div class="form-group">
                                        <label><?php echo nokri_feilds_label('adres_txt', esc_html__('Select address', 'nokri')); ?></label>
                                        <input type="hidden" id="is_post_job" value="1" />	
                                        <input type="text" class="form-control" name="sb_user_address" id="sb_user_address" value="<?php echo esc_attr($ad_mapLocation); ?>" placeholder="<?php echo esc_attr__('Enter map address', 'nokri'); ?>" <?php echo nokri_feilds_operat('allow_job_adress', 'required'); ?> data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                                        <?php if ($mapType == 'google_map') { ?>
                                            <a href="javascript:void(0);" id="your_current_location" title="<?php echo esc_attr__('You Current Location', 'nokri'); ?>"><i class="fa fa-crosshairs"></i></a>
                                        <?php } ?>
                                    </div>
                                    <div class="form-group">
                                        <div id="dvMap" style="width:100%; height: 300px"></div>
                                    </div>
                                    <div class="form-group">
                                        
                                        <input class="form-control" data-parsley-required="true" name="ad_map_long" id="ad_map_long" value="<?php echo esc_attr($ad_map_long); ?>" type="text">

                                    </div>
                                    <div class="form-group">
                                        
                                        <input class="form-control" data-parsley-required="true"  name="ad_map_lat" id="ad_map_lat" value="<?php echo esc_attr($ad_map_lat); ?>">
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                            /* Employer Purchase Any Package */
                            $job_bost = nokri_validate_employer_premium_jobs();
                            if ($job_bost) {
                                ?>
                                <div class="post-job-section job job-topups">
                                    
                                    <div class="col-md-12 col-sm-12 ">
                                        <h4 class="post-job-heading">
                                            <?php echo nokri_feilds_label('addon_text', esc_html__('Boost your job with addons', 'nokri')); ?>
                                        </h4>
                                    </div>
                                    <div class="col-md-12 col-sm-12 ">
                                        <ul>
                                            <?php
                                            $job_classes = get_terms(array('taxonomy' => 'job_class', 'hide_empty' => false, 'parent' => 0));
                                            foreach ($job_classes as $job_class) {
                                                $term_id = $job_class->term_id;
                                                $job_class_user_meta = get_user_meta($user_crnt_id, 'package_job_class_' . $term_id, true);
                                                if ($job_class_user_meta == '-1') {
                                                    $job_class_user_meta = esc_html('Unlimited ' . $job_class->name . ' Jobs', 'nokri');
                                                } else {
                                                    $disable_class = '';
                                                    $add_html_class = '';
                                                    if($job_class_user_meta == 0) {
                                                        $disable_class = 'disable';
                                                        $add_html_class = 'zero_rem_disable';
                                                        $remaining_zero = $job_class_user_meta . $job_class->name;
                                                        $job_class_user_meta = $job_class_user_meta . ' ' . $job_class->name . ' ' . esc_html__(' Remaining', 'nokri');
                                                    } else {
                                                        $job_class_user_meta = $job_class_user_meta . ' ' . $job_class->name . ' ' . esc_html__(' Remaining', 'nokri');
                                                    }
                                                    
                                                }
                                                $emp_class_check = get_term_meta($job_class->term_id, 'emp_class_check', true);
                                                /* Skipping Free Job Class */
                                                if ($emp_class_check == 1) {
                                                    continue;
                                                }
                                                if ($job_class_user_meta > 0 && $emp_class_check != 1 || current_user_can('administrator')) {
                                                    ?>
                                                    <li>
                                                        <div class="job-topups-box <?php echo esc_attr($add_html_class); ?>">
                                                            <p><b><?php echo esc_html($job_class->name); ?></b></p>
                                                            <h4><?php echo esc_html($job_class_user_meta); ?></h4>
                                                        </div>
                                                        <div class="job-topups-checkbox">
                                                            <?php
                                                            $job_class_user_meta_parts = explode(' ', $job_class_user_meta, 2);
                                                            $disable_class_html = '';
                                                            if (isset($job_class_user_meta_parts[0]) && $job_class_user_meta_parts[0] == '0') {
                                                                $disable_class_html = 'disabled';
                                                                $job_class_user_meta = '0 ' . esc_html__('Feature Remaining', 'nokri');
                                                            } else {
                                                                $job_class_user_meta = $job_class_user_meta . ' ' . esc_html($job_class->name) . ' ' . esc_html__('Remaining', 'nokri');
                                                            }
                                                            $job_class_checked = wp_get_post_terms($job_id, 'job_class', array("fields" => "names"));
                                                            if (in_array($job_class->name, $job_class_checked)) {
                                                                echo '<h5>' . esc_html__('Already', 'nokri') . " " . esc_html($job_class->name) . '</h5>';
                                                            } else {
                                                                $disable_class_html = ($disable_class == 'disable') ? 'disabled' : '';
                                                                echo '<input type="checkbox" name="class_type_value[]" value="' . esc_attr($term_id) . '" class="input-icheck-others" ' . esc_attr($disable_class_html) . '>';
                                                            }
                                                            ?>
                                                        </div>
                                                    </li>
                                                    <?php
                                                }
                                            }
                                            ?> 
                                        </ul>
                                    </div>
                                </div>
                                <?php
                            }
                            /* Function for Terms and Conditions */
                            $termsCo = nokri_terms_and_conditions();
                            echo nokri_returnEcho($termsCo);
                            /* Checking if Employer have Members and Members Permissions */
                            $crnt_user = get_current_user_id();
                            $is_member = get_user_meta($crnt_user, '_sb_is_member', true);
                            $permissions = get_user_meta($crnt_user, 'member_permissions', true);
                            $is_access = '';
                            if (isset($is_member) && $is_member != '') {
                                if (isset($permissions['ad_post']) && $permissions['ad_post'] != '') {

                                    $is_access = $permissions['ad_post'];
                                }
                                if ($is_access == 'on') {
                                    echo '<div class="form-group">
                                    '. wp_nonce_field('job_post_page_nonce_action', 'job_post_page_nonce') .'
                                <input type="submit" id="job_post" class=" form-control btn n-btn-flat btn-block btn-mid" value="' . esc_attr__('Submit', 'nokri') . '">
                                <button class="btn n-btn-flat btn-block no-display" type="button" id="job_proc" disabled>' . esc_html__('Processing...', 'nokri') . '</button>
                                <button class="btn n-btn-flat btn-block no-display" type="button" id="job_redir" disabled>' . esc_html__('Redirecting...', 'nokri') . '</button>
                                </div>';
                                } elseif ($is_access == '') {

                                    echo '<p><strong>' . esc_html__('You do not have permissions to Post a new Job', 'nokri') . '</strong></p>';
                                }
                            } else {
                                echo '<div class="form-group">
                                '. wp_nonce_field('job_post_page_nonce_action', 'job_post_page_nonce') .'
                                <input type="submit" id="job_post" class=" form-control btn n-btn-flat btn-block btn-mid" value="' . esc_attr__('Submit', 'nokri') . '">
                                <button class="btn n-btn-flat btn-block no-display" type="button" id="job_proc" disabled>' . esc_html__('Processing...', 'nokri') . '</button>
                                <button class="btn n-btn-flat btn-block no-display" type="button" id="job_redir" disabled>' . esc_html__('Redirecting...', 'nokri') . '</button>
                                </div>';
                            }
                            ?>
                        </div>
                    </div>
                    </form>
            </div>
        </div>
    </div>
</section>
<?php
if ($allow_map && $mapType == 'leafletjs_map' && $is_lat_long) {
    echo '' . $lat_lon_script = '<script type="text/javascript">
	var mymap = L.map(\'dvMap\').setView([' . $ad_map_lat . ', ' . $ad_map_long . '], 13);
		L.tileLayer(\'https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png\', {
			maxZoom: 18,
			attribution: \'\'
		}).addTo(mymap);
		var markerz = L.marker([' . $ad_map_lat . ', ' . $ad_map_long . '],{draggable: true}).addTo(mymap);
		var searchControl 	=	new L.Control.Search({
			url: \'//nominatim.openstreetmap.org/search?format=json&q={s}\',
			jsonpParam: \'json_callback\',
			propertyName: \'display_name\',
			propertyLoc: [\'lat\',\'lon\'],
			marker: markerz,
			autoCollapse: true,
			autoType: true,
			minLength: 2,
		});
		searchControl.on(\'search:locationfound\', function(obj) {
			
			var lt	=	obj.latlng + \'\';
			var res = lt.split( "LatLng(" );
			res = res[1].split( ")" );
			res = res[0].split( "," );
			document.getElementById(\'ad_map_lat\').value = res[0];
			document.getElementById(\'ad_map_long\').value = res[1];
		});
		mymap.addControl( searchControl );
		
		markerz.on(\'dragend\', function (e) {
		  document.getElementById(\'ad_map_lat\').value = markerz.getLatLng().lat;
		  document.getElementById(\'ad_map_long\').value = markerz.getLatLng().lng;
		});
	</script>';
}
if ($mapType == 'google_map' && $is_lat_long) {
    nokri_load_search_countries(1);
}
get_footer();