<?php
// Resend Email
add_action('wp_ajax_sb_resend_email', 'nokri_resend_email');
add_action('wp_ajax_nopriv_sb_resend_email', 'nokri_resend_email');

function nokri_resend_email() {
    $email = $_POST['usr_email'];
    $user = get_user_by('email', $email);
    if (get_user_meta($user->ID, 'sb_resent_email', true) != 'yes') {

        nokri_email_on_new_user($user->ID, '', false);
        update_user_meta($user->ID, 'sb_resent_email', 'yes');
    }
    die();
}

/* Employer Sending Email */
if (!function_exists('nokri_employer_status_email')) {

    function nokri_employer_status_email($job_id, $candidate_id, $subject, $body, $from_email) {
        // Auhtor info
        $author_id = get_post_field('post_author', $job_id);
        $author_id = get_userdata($author_id);
        $author_name = $author_id->display_name;
        $author_email = $author_id->user_email;
        $author_job_title = get_the_title($job_id);
        // Candidate  info
        $candidate_id = get_userdata($candidate_id);
        $candidate_name = $candidate_id->display_name;
        $candidate_email = $candidate_id->user_email;
        $subject = $subject;
        $from = $from_email;
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

        wp_mail($candidate_email, $subject, $body, $headers);
    }

}



// contact me function
function nokri_contact_me_email($reciver_id, $sender_email, $sender_name, $subject_form, $message) {
    global $nokri;
    if (isset($nokri['sb_new_cotact_message']) && $nokri['sb_new_cotact_message'] != "" && isset($nokri['sb_new_cotact_from']) && $nokri['sb_new_cotact_from'] != "") {

        // receiver info
        $reciver_id = get_userdata($reciver_id);
        $reciver_name = $reciver_id->display_name;
        $reciver_email = $reciver_id->user_email;

        // sender info
        $sender_email = $sender_email;
        $subject = $subject_form != "" ? $subject_form : $nokri['sb_new_cotact_message'];

        $from = $nokri['sb_new_cotact_from'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

        $msg_keywords = array('%site_name%', '%display_name%', '%email%', '%subject%', '%message%', "%receiver_name%");
        $msg_replaces = array(get_bloginfo('name'), $sender_name, $sender_email, $subject, $message, $reciver_name);

        $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_new_cotact_body']);
        wp_mail($reciver_email, $subject, $body, $headers);
    }
}

//E-mail to admin function 
if (!function_exists('nokri_send_candidate_status_job')) {

    function nokri_send_candidate_status_job($job_id,$cand_id) {
        
        global $nokri;
         $admin_email="";
         $send_email_admin_switch =$nokri['send_email_admin_switch'];
        $author_id = get_current_user_id();
        $author_data = get_userdata($author_id);
        $author_name = $author_data->display_name;

        $cand_data = get_userdata($cand_id);
        $cand_email = $cand_data->user_email;
        $cand_name = $cand_data->display_name;
        $admin_email = get_option('admin_email');
        $author_job_title = get_the_title($job_id);

        $job_link = get_the_permalink($job_id);

        $subject = $nokri['email_to_admin_body_subject'];
       // $from = $nokri['nokri_send_cand_meeting_from'];
       $headers = array('Content-Type: text/html; charset=UTF-8', "From: $admin_email");

        $msg_keywords = array('%site_name%', '%job_title%', '%job_link%', '%candidate_name%', '%employer_name%');
        $msg_replaces = array(get_bloginfo('name'), $author_job_title, $job_link, $cand_name, $author_name,);

        $body = str_replace($msg_keywords, $msg_replaces, $nokri['email_to_admin_body_template']);

        
        //function calling//
        if($send_email_admin_switch){
         //////
        wp_mail($admin_email, $subject, $body, $headers);
        }
        store_data_in_custom_table($job_id, $cand_id, $author_id);
    }

}

//Zoom new meeting invitation 

if (!function_exists('nokri_send_candidate_meeting_link')) {

    function nokri_send_candidate_meeting_link($url, $meeting_id, $meeting_pass, $cand_id, $job_id, $meetingTime, $meet_duration) {

        global $nokri;

        $author_id = get_current_user_id();
        $author_data = get_userdata($author_id);
        $author_name = $author_data->display_name;

        $cand_data = get_userdata($cand_id);
        $cand_email = $cand_data->user_email;
        $cand_name = $cand_data->display_name;

        $author_job_title = get_the_title($job_id);

        $job_link = get_the_permalink($job_id);

        $subject = $nokri['nokri_send_cand_meeting_subject'];
        $from = $nokri['nokri_send_cand_meeting_from'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

        $msg_keywords = array('%site_name%', '%job_title%', '%job_link%', '%cand_name%', '%emp_name%', '%meeting_url%', '%meeting_id%', '%meeting_pass%', '%meeting_time%', '%meet_duration%');
        $msg_replaces = array(get_bloginfo('name'), $author_job_title, $job_link, $cand_name, $author_name, $url, $meeting_id, $meeting_pass, $meetingTime, $meet_duration);

        $body = str_replace($msg_keywords, $msg_replaces, $nokri['nokri_send_cand_meeting_body']);

        wp_mail($cand_email, $subject, $body, $headers);
    }

}

// New job applier function
function nokri_new_candidate_apply($job_id, $candidate_id) {
    global $nokri;
    if ($nokri['sb_send_email_on_apply'] == '1' && isset($nokri['sb_msg_on_new_apply']) && $nokri['sb_msg_on_new_apply'] != "" && isset($nokri['sb_msg_from_on_new_apply']) && $nokri['sb_msg_from_on_new_apply'] != "") {
        // Auhtor info
        $author_id = get_post_field('post_author', $job_id);
        $author_id = get_userdata($author_id);
        $author_name = $author_id->display_name;
        $author_email = $author_id->user_email;
        // If job apply is with external link 
        $ext_email = get_post_meta($job_id, '_job_apply_mail', true);
        if ($ext_email != '') {
            $author_email = $ext_email;
        }
        $author_job_title = get_the_title($job_id);
        // Candidate  info
        $candidate_id = get_userdata($candidate_id);
        $candidate_link = get_author_posts_url($candidate_id);
        $job_link = get_the_permalink($job_id);
        $candidate_name = $candidate_id->display_name;
        $subject = $nokri['sb_msg_subject_on_new_apply'];
        $from = $nokri['sb_msg_from_on_new_apply'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $msg_keywords = array('%site_name%', '%job_title%', '%candidate_name%', '%candidate_link%', '%job_link%', '%message%');
        $msg_replaces = array(get_bloginfo('name'), $author_job_title, $candidate_name, $candidate_link, $job_link);
        $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_msg_on_new_apply']);
        wp_mail($author_email, $subject, $body, $headers);
    }
}

//send welcome message to applier

function nokri_welcome_applier($job_id, $cand_id) {
    global $nokri;
    if ($nokri['sb_send_welcome_email_on_apply'] == '1' && isset($nokri['sb_welcome_msg_on_new_apply']) && $nokri['sb_welcome_msg_on_new_apply'] != "") {


        //company details
        $job_title = get_the_title($job_id);
        $author_id = get_post_field('post_author', $job_id);
        $author_link = get_author_posts_url($author_id);
        $author_id = get_userdata($author_id);
        $author_name = $author_id->display_name;
        $author_email = $author_id->user_email;

        // Candidate  info
        $candidate_data = get_userdata($cand_id);
        $candidate_link = get_author_posts_url($cand_id);
        $job_link = get_the_permalink($job_id);
        $candidate_name = $candidate_data->display_name;
        $cand_email = $candidate_data->user_email;
        $subject = $nokri['sb_welcome_msg_subject_on_new_apply'];
        $from = $nokri['sb_welcome_msg_from_on_new_apply'];

        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $msg_keywords = array('%site_name%', '%job_title%', '%job_link%', '%comp_name%', '%comp_link%', '%candidate_name%', '%candidate_link%', '%message%');

        $msg_replaces = array(get_bloginfo('name'), $job_title, $job_link, $author_name, $author_link, $candidate_name, $candidate_link);
        $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_welcome_msg_on_new_apply']);

        wp_mail($cand_email, $subject, $body, $headers);
    }
}

// Apply with out login
function nokri_apply_without_login_password($user_id = '', $password = '', $job_id = '') {
    global $nokri;
    if (isset($nokri['sb_without_login_email_message']) && $nokri['sb_without_login_email_message'] != "" && isset($nokri['sb_without_login_from']) && $nokri['sb_without_login_from'] != "") {
        // Candidate  info
        $user_id = get_userdata($user_id);
        $user_name = $user_id->display_name;
        $user_email = $user_id->user_email;
        /* Job Information */
        $job_id = $job_id;
        $job_title = get_the_title($job_id);
        $subject = $nokri['sb_without_login_email_message'];
        $from = $nokri['sb_without_login_from'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $msg_keywords = array('%site_name%', '%display_name%', '%subject%', '%email%', '%password%', '%job_title%', '%message%');
        $msg_replaces = array(get_bloginfo('name'), $user_name, $subject, $user_email, $password, $job_title,);
        $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_without_login_body']);
        wp_mail($user_email, $subject, $body, $headers);
    }
}

// Email on new User
function nokri_email_on_new_user($user_id, $social = '', $admin_email = true) {
    global $nokri;

    if (isset($nokri['sb_new_user_email_to_admin']) && $nokri['sb_new_user_email_to_admin'] && $admin_email) {
        if (isset($nokri['sb_new_user_admin_message_admin']) && $nokri['sb_new_user_admin_message_admin'] != "" && isset($nokri['sb_new_user_admin_message_from_admin']) && $nokri['sb_new_user_admin_message_from_admin'] != "") {
            $to = get_option('admin_email');
            $subject = $nokri['sb_new_user_admin_message_subject_admin'];
            $from = $nokri['sb_new_user_admin_message_from_admin'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");

            // User info
            $user_info = get_userdata($user_id);
            $msg_keywords = array('%site_name%', '%display_name%', '%email%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, $user_info->user_email);

            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_new_user_admin_message_admin']);
            wp_mail($to, $subject, $body, $headers);
        }
    }
    if (isset($nokri['sb_new_user_email_to_user']) && $nokri['sb_new_user_email_to_user']) {

        if (isset($nokri['sb_new_user_message']) && $nokri['sb_new_user_message'] != "" && isset($nokri['sb_new_user_message_from']) && $nokri['sb_new_user_message_from'] != "") {
            // User info
            $user_info = get_userdata($user_id);
            $to = $user_info->user_email;
            $subject = $nokri['sb_new_user_message_subject'];
            $from = $nokri['sb_new_user_message_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $user_name = $user_info->user_email;
            if ($social != '')
                $user_name .= "(Password: $social )";

            $verification_link = '';
            if (isset($nokri['sb_new_user_email_verification']) && $nokri['sb_new_user_email_verification'] && $social == "") {
                $token = get_user_meta($user_id, 'sb_email_verification_token', true);
                if ($token == "") {
                    $token = nokri_randomString(50);
                }
                $verification_link = trailingslashit(get_home_url()) . '?verification_key=' . $token . '-sb-uid-' . $user_id;

                update_user_meta($user_id, 'sb_email_verification_token', $token);
            }

            $msg_keywords = array('%site_name%', '%user_name%', '%display_name%', '%verification_link%');
            $msg_replaces = array(get_bloginfo('name'), $user_name, $user_info->display_name, $verification_link);
            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_new_user_message']);
            wp_mail($to, $subject, $body, $headers);
        }
    }
}

if (!function_exists('sb_team_member_welcome_email')) {

    function sb_team_member_welcome_email($user_id, $password) {

        global $nokri;
        if (isset($nokri['member_mail_switch']) && $nokri['member_mail_switch']) {

            if (isset($nokri['sb_acc_member_subject']) && $nokri['sb_acc_member_subject'] != "" && isset($nokri['sb_member_password_from']) && $nokri['sb_member_password_from'] != "") {
                // User info
                $user_info = get_userdata($user_id);
                $to = $user_info->user_email;
                $subject = $nokri['sb_acc_member_subject'];
                $from = $nokri['sb_member_password_from'];
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                $user_name = $user_info->user_email;
                $site_link = trailingslashit(get_home_url());
                $msg_keywords = array('%site_name%', '%user_name%', '%display_name%', '%password%','%site_url%');
                $msg_replaces = array(get_bloginfo('name'), $user_name, $user_info->display_name, $password, $site_link);
                $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_acc_member_message']);
                wp_mail($to, $subject, $body, $headers);
            }
        }
    }

}

// Ajax handler for Forgot Password
add_action('wp_ajax_sb_forgot_password', 'nokri_forgot_password');
add_action('wp_ajax_nopriv_sb_forgot_password', 'nokri_forgot_password');

// Forgot Password
function nokri_forgot_password() {
    global $nokri;
    // Getting values
    $params = array();
    parse_str($_POST['sb_data'], $params);
    $email = $params['sb_forgot_email'];
    if (email_exists($email) == true) {
        // lets generate our new password
        $random_password = wp_generate_password(12, false);
        $to = $email;
        $subject = __('Your new password', 'redux-framework');
        $body = __('Your new password is: ', 'redux-framework') . $random_password;
        $from = get_bloginfo('name');

        if (isset($nokri['sb_forgot_password_from']) && $nokri['sb_forgot_password_from'] != "") {
            $from = $nokri['sb_forgot_password_from'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($nokri['sb_forgot_password_message']) && $nokri['sb_forgot_password_message'] != "") {
            $subject_keywords = array('%site_name%');
            $subject_replaces = array(get_bloginfo('name'));
            $subject = str_replace($subject_keywords, $subject_replaces, $nokri['sb_forgot_password_subject']);
            $token = nokri_randomString(50);
            $user = get_user_by('email', $email);
            $user_id = $user->ID;
            wp_set_password( $random_password, $user_id );
            $msg_keywords = array('%site_name%', '%user%','%password%', '%reset_link%');
            $reset_link = trailingslashit(get_home_url()) . '?token=' . $token . '-sb-uid-' . $user->ID;
            $msg_replaces = array(get_bloginfo('name'), $user->display_name,$random_password, $reset_link);
            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_forgot_password_message']);

        }
       $mail = wp_mail($to, $subject, $body, $headers);
        if ($mail) {
            // Get user data by field and data, other field are ID, slug, slug and login
            update_user_meta($user->ID, 'sb_password_forget_token', $token);
            echo "1";
        } else {
            echo __('Email server not responding', 'redux-framework');
        }
    } else {
        echo __('Email is not resgistered with us.', 'redux-framework');
    }
    die();
}

// Email on Job Post
function nokri_get_notify_on_ad_post($pid) {
    global $nokri;
    if (isset($nokri['sb_send_email_on_ad_post']) && $nokri['sb_send_email_on_ad_post'] == '1') {
        $to = $nokri['ad_post_email_value'];
        $subject = __('New Job', 'redux-framework') . '-' . get_bloginfo('name');
        $body = '<html><body><p>' . __('Got new ad', 'redux-framework') . ' <a href="' . get_edit_post_link($pid) . '">' . get_the_title($pid) . '</a></p></body></html>';
        $from = get_bloginfo('name');
        if (isset($nokri['sb_msg_from_on_new_ad']) && $nokri['sb_msg_from_on_new_ad'] != "") {
            $from = $nokri['sb_msg_from_on_new_ad'];
        }
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        if (isset($nokri['sb_msg_on_new_ad']) && $nokri['sb_msg_on_new_ad'] != "") {
            $author_id = get_post_field('post_author', $pid);
            $user_info = get_userdata($author_id);
            $subject_keywords = array('%site_name%', '%job_owner%', '%job_title%');
            $subject_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid));
            $subject = str_replace($subject_keywords, $subject_replaces, $nokri['sb_msg_subject_on_new_ad']);
            $msg_keywords = array('%site_name%', '%job_owner%', '%job_title%', '%job_link%');
            $msg_replaces = array(get_bloginfo('name'), $user_info->display_name, get_the_title($pid), get_the_permalink($pid));
            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_msg_on_new_ad']);
        }
        wp_mail($to, $subject, $body, $headers);
    }
}

/* Email job to anyone */

function nokri_email_job_to_anyone($pid, $user_email) {
    global $nokri;
    if (isset($nokri['sb_email_job_to_anyone_subj']) && $nokri['sb_email_job_to_anyone_from']) {
        // Job  info
        $job_id = $pid;
        $job_title = get_the_title($pid);
        $job_link = get_the_permalink($pid);
        $subject = $nokri['sb_email_job_to_anyone_subj'];
        $from = $nokri['sb_email_job_to_anyone_from'];
        $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
        $msg_keywords = array('%site_name%', '%job_title%', '%job_link%');
        $msg_replaces = array(get_bloginfo('name'), $job_title, $job_link);
        $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_email_job_to_anyone_body']);
        $sent = wp_mail($user_email, $subject, $body, $headers);
        if ($sent)
            return true;
    }
}

/* Email job alert */
if (!function_exists('nokri_email_job_alerts')) {

    function nokri_email_job_alerts($pid, $user_email) {
        global $nokri;
        $nokri  =  get_option('nokri');
        if (isset($nokri['sb_email_job_alerts_subj']) && $nokri['sb_email_job_alerts_subj'] != '') {
            // Job  info                         
            $job_id = $pid;
            $job_title = get_the_title($pid);
            $job_link = get_the_permalink($pid);
            $subject = $nokri['sb_email_job_alerts_subj'];
            $from = $nokri['sb_email_job_alerts_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $msg_keywords = array('%site_name%', '%job_title%', '%job_link%');
            $msg_replaces = array(get_bloginfo('name'), $job_title, $job_link);
            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_email_job_alerts_body']);
            wp_mail($user_email, $subject, $body, $headers);
        }
    }

}


/* Before pacakge expiry Email */
if (!function_exists('nokri_before_package_expiry_notify')) {

    function nokri_before_package_expiry_notify($user_id) {
        global $nokri;

        if (isset($nokri['sb_package_expiry_message']) && $nokri['sb_package_expiry_message'] != '') {
            $user_id = $user_id;
            $user_data = get_userdata($user_id);
            $user_email = $user_data->user_email;
            $display_name = $user_data->display_name;
            $subject = $nokri['sb_package_expiry_message'];
            $from = $nokri['sb_before_package_expiry_from'];
            $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
            $days = isset($nokri['sb_package_expiry_days']) ? $nokri['sb_package_expiry_days'] : 1;
            $tommorow = Date('Y-m-d', strtotime("$days days"));
            $msg_keywords = array('%display_name%', '%site_name%', '%message%', '%subject%');
            $msg_replaces = array($display_name, get_bloginfo('name'), $tommorow, $subject);
            $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_before_package_expiry_body']);
            wp_mail($user_email, $subject, $body, $headers);
        }
    }

}

/* Before pacakge expiry Email */
if (!function_exists('nokri_before_jobs_expiry_notify')) {

    function nokri_before_jobs_expiry_notify($job_id, $expired) {

        //global $nokri;
        $nokri  =  get_option('nokri');
        $mail_expiry_btn = isset($nokri['job_mail_expiry_switch']) ? $nokri['job_mail_expiry_switch'] : true;
        if ($mail_expiry_btn) {
            if (isset($nokri['sb_jobs_expiry_message']) && $nokri['sb_jobs_expiry_message'] != '') {
                $user_id = get_post_field('post_author', $job_id);
                $user_data = get_userdata($user_id);
                $user_email = $user_data->user_email;
                $display_name = $user_data->display_name;
                $job_name = get_the_title($job_id);
                $job_url = get_the_permalink($job_id);
                $job_deadline_n = get_post_meta($job_id, '_job_date', true);
                $subject = $nokri['sb_jobs_expiry_message'];
                $from = $nokri['sb_before_jobs_expiry_from'];
                $headers = array('Content-Type: text/html; charset=UTF-8', "From: $from");
                $msg_keywords = array('%display_name%', '%site_name%', '%job_name%', '%job_url%', '%date%');
                $msg_replaces = array($display_name, get_bloginfo('name'), $job_name, $job_url, $job_deadline_n);

                if ($expired == "yes") {
                    $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_after_jobs_expiry_body']);
                } else {
                    $body = str_replace($msg_keywords, $msg_replaces, $nokri['sb_before_jobs_expiry_body']);
                }
                wp_mail($user_email, $subject, $body, $headers);
            }
        }
    }

}