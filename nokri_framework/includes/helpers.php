<?php
if (!function_exists('nokri_base64Encode')) {

    function nokri_base64Encode($json) {
        return base64_encode($json);
    }

}
if (!function_exists('nokri_base64Decode')) {

    function nokri_base64Decode($json) {
        return base64_decode($json);
    }

}


if (!function_exists('nokri_downloadfiles_option')) {

    function nokri_downloadfiles_option($theFile = '') {
        if (!$theFile) {
            return;
        }
        //clean the fileurl
        $file_url = stripslashes(trim($theFile));
        $file_url = preg_replace('/\?.*/', '', $file_url);
        //get filename
        $file_name = basename($file_url);
        //get fileextension                      
        $file_extension = pathinfo($file_name);
        //security check
        $fileName = strtolower($file_name);

        $whitelist = array('txt', 'pdf', 'doc', 'docx');

        if (!in_array(end(explode('.', $fileName)), $whitelist)) {
            exit('Invalid file!');
        }
        if (strpos($file_url, '.php') == true) {
            die("Invalid file!");
        }
        $file_new_name = $file_name;
        $content_type = "";
        //check filetype
        switch ($file_extension['extension']) {
            case "txt":
                $content_type = "file/txt";
                break;
            case "pdf":
                $content_type = "file/pdf";
                break;
            case "doc":
                $content_type = "file/doc";
                break;
            case "docx":
            case "docx":
                $content_type = "file/docx";
                break;
            default:
                $content_type = "application/force-download";
        }
        $content_type = apply_filters("ibenic_content_type", $content_type, $file_extension['extension']);
        header("Expires: 0");
        header("Cache-Control: no-cache, no-store, must-revalidate");
        header('Cache-Control: pre-check=0, post-check=0, max-age=0', false);
        header("Pragma: no-cache");
        header("Content-type: {$content_type}");
        header("Content-Disposition:attachment; filename={$file_new_name}");
        header("Content-Type: application/force-download");
        ob_clean();
        flush();
        readfile("{$file_url}");
    }

}

// Ajax handler for newsletter
add_action('wp_ajax_sb_mailchimp_subcribe', 'nokri_mailchimp_subcribe');
add_action('wp_ajax_nopriv_sb_mailchimp_subcribe', 'nokri_mailchimp_subcribe');

// Addind Subcriber into Mailchimp
function nokri_mailchimp_subcribe() {
    global $nokri;
    $listid = $nokri['mailchimp_api_list_id'];
    $sb_action = $_POST['sb_action'];
    $apiKey = $nokri['mailchimp_api_key'];
    // Getting value from form
    $email = $_POST['sb_email'];
    $fname = '';
    $lname = '';
    // MailChimp API URL
    $memberID = md5(strtolower($email));
    $dataCenter = substr($apiKey, strpos($apiKey, '-') + 1);
    $url = 'https://' . $dataCenter . '.api.mailchimp.com/3.0/lists/' . $listid . '/members/' . $memberID;
    // member information
    $json = json_encode(array(
        'email_address' => $email,
        'status' => 'subscribed',
        'merge_fields' => array(
            'FNAME' => $fname,
            'LNAME' => $lname
        )
    ));

    // send a HTTP POST request with curl
    $ch = curl_init($url);
    curl_setopt($ch, CURLOPT_USERPWD, 'user:' . $apiKey);
    curl_setopt($ch, CURLOPT_HTTPHEADER, array('Content-Type: application/json'));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 10);
    curl_setopt($ch, CURLOPT_CUSTOMREQUEST, 'PUT');
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    curl_setopt($ch, CURLOPT_POSTFIELDS, $json);
    $result = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    curl_close($ch);
    // store the status message based on response code
    $mcdata = json_decode($result);
    if (!empty($mcdata->error)) {
        echo 0;
    } else {
        echo 1;
    }
    die();
}