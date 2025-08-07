<?php
// Linkedin handling
if (!function_exists('nokri_linked_handling')) {

    function nokri_linked_handling($code) {
       
        global $nokri;
        $client_id = ($nokri['linkedin_api_key']);
        $client_secret = ($nokri['linkedin_api_secret']);
        $redirect_uri = ($nokri['redirect_uri']);
        //$api_cal       =  'https://api.linkedin.com/v1/people/~';
        $api_cal = "https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))";
        //$api_cal = "https://api.linkedin.com/v2/me?projection=(id,firstName,lastName)";
        if ($code != "") {
            $ch = curl_init();
            curl_setopt($ch, CURLOPT_URL, "https://www.linkedin.com/oauth/v2/accessToken");
            curl_setopt($ch, CURLOPT_POST, 0);
            curl_setopt($ch, CURLOPT_POSTFIELDS, "grant_type=authorization_code&code=" . $code . "&redirect_uri=$redirect_uri&client_id=$client_id&client_secret=$client_secret");
            curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
            $server_output = curl_exec($ch);
            curl_close($ch);
        }

        //For Email 	
        $Url = "https://api.linkedin.com/v2/emailAddress?q=members&projection=(elements*(handle~))";
        $token = json_decode($server_output)->access_token;

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token,
            'X-Restli-Protocol-Version: 2.0.0',
            'Accept: application/json',
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $response = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $headerSize);
        $response_body = json_decode($body, true);

        $userEmail = (isset($response_body['elements'][0]['handle~']['emailAddress'])) ? $response_body['elements'][0]['handle~']['emailAddress'] : '';

        //For Profile
        $Url = "https://api.linkedin.com/v2/me";
        $token = json_decode($server_output)->access_token;
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $Url);
        curl_setopt($ch, CURLOPT_HTTPHEADER, array(
            'Authorization: Bearer ' . $token,
            'X-Restli-Protocol-Version: 2.0.0',
            'Accept: application/json',
            'Content-Type: application/json'
        ));
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_VERBOSE, 1);
        curl_setopt($ch, CURLOPT_HEADER, 1);
        $response = curl_exec($ch);
        $headerSize = curl_getinfo($ch, CURLINFO_HEADER_SIZE);
        $body = substr($response, $headerSize);
        $response_body = json_decode($body, true);
        //print_r($response_body['elements'][0]['handle~']['emailAddress']);

        $fname = (isset($response_body['localizedFirstName'])) ? $response_body['localizedFirstName'] : '';
        $lname = (isset($response_body['localizedLastName'])) ? $response_body['localizedLastName'] : '';
        $res = array();
        $res[] = $fname;
        $res[] = $lname;
        $res[] = $userEmail;

        return $res;
    }

}
// importing indeed jobs 
add_action('wp_ajax_sb_import_indeed_job', 'sb_import_indeed_job_fun');
add_action('wp_ajax_sb_import_indeed_job', 'sb_import_indeed_job_fun');

function sb_import_indeed_job_fun() {
    $params = array();
    parse_str($_POST['sb_indeed_param'], $params);
    global $nokri;
    $publisher_id = isset($params['pub_id']) ? $params['pub_id'] : '';
    $job_keyword = isset($params['job_keyword']) ? $params['job_keyword'] : '';
    $job_country = isset($params['job_country']) ? $params['job_country'] : '';
    $job_location = isset($params['job_location']) ? $params['job_location'] : '';
    $job_type = isset($params['job_type']) ? $params['job_type'] : '';
    $sort_by = isset($params['sort_by']) ? $params['sort_by'] : '';
    $jobs_num = isset($params['jobs_num']) ? $params['jobs_num'] : '';
    $job_expiry = isset($params['job_date']) ? $params['job_date'] : '';
    $jobs_by = isset($params['jobs_by']) ? $params['jobs_by'] : '';
    $user_agent = esc_url($_SERVER['HTTP_USER_AGENT']);

    $default_jobs_num = isset($params['jobs_num_default']) ? $params['jobs_num_default'] : '';

    if ($jobs_num == '') {

        $jobs_num = $default_jobs_num;
    }
    $api_url = "https://api.indeed.com/ads/apisearch/";

    if ($publisher_id == '') {
        echo '0|' . __("Please add valid publisher id.", 'redux-framework');
        die();
    }
    if ($job_keyword == '') {
        echo '1|' . __("Please add keyword to search job.", 'redux-framework');
        die();
    }
    if ($job_country == '') {
        echo '2|' . __("Please Select country first.", 'redux-framework');
        die();
    }
    $final_url = "https://api.indeed.com/ads/apisearch?publisher=$publisher_id&q=$job_keyword&l=$job_location&sort=$sort_by&radius=&st=&jt=$job_type&start=&limit=$jobs_num&format=json&fromage=&filter=&latlong=1&co=$job_country&chnl=&userip=1.2.3.4&useragent=$user_agent&v=2";

    $request = wp_remote_get($final_url);
    $req_body = wp_remote_retrieve_body($request);

    if (is_wp_error($request)) {
        echo '3|' . __("Something went wrong.", 'redux-framework');
        die();
    }

    $data = json_decode($req_body);

    $job_arr = array();
    $jobs_result = isset($data->results) ? $data->results : array();
    $jobs_found = count($jobs_result);
    if ($jobs_found == '') {
        echo '4|' . __("No job found.", 'redux-framework');
        die();
    } else {
        foreach ($jobs_result as $job) {

            $job_title = isset($job->jobtitle) ? $job->jobtitle : '';
            $job_desc = isset($job->snippet) ? $job->snippet : '';
            $job_url = isset($job->url) ? $job->url : '';
            $job_latitude = isset($job->latitude) ? $job->latitude : '';
            $job_longitude = isset($job->longitude) ? $job->longitude : '';
            $job_location = isset($job->formattedLocationFull) ? $job->formattedLocationFull : '';

            $job_id = wp_insert_post(array(
                'post_title' => $job_title,
                'post_type' => 'job_post',
                'post_content' => $job_desc,
                'post_status' => 'publish',
            ));
            if ($job_expiry != '') {
                update_post_meta($job_id, '_job_date', $job_expiry);
            }
            if ($job_latitude != '') {
                update_post_meta($job_id, '_job_lat', $job_latitude);
            }
            if ($job_longitude != '') {
                update_post_meta($job_id, '_job_long', $job_longitude);
            }
            if ($job_location != '') {
                update_post_meta($job_id, 'job_format_location', $job_location);
            }
            if ($job_url != '') {
                update_post_meta($job_id, '_job_apply_with', 'exter');
                update_post_meta($job_id, '_job_apply_url', $job_url);
            }
            update_post_meta($job_id, '_job_status', 'active');
            $job_arr[] = $job_id;
        }
    }
    $posted_jobs = count($job_arr);
    if ($posted_jobs > 0) {
        echo '5|' . __("$posted_jobs jobs has been imported.", 'redux-framework');
    }
    die();
}