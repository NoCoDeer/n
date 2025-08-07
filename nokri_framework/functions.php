<?php
require_once( 'includes/emails.php' );

require_once( 'includes/helpers.php' );

require_once( 'includes/woocommerce.php' );
require_once( 'includes/api.php' );

/* ========================= */
/* Remove Empty P From Content */
/* ========================= */
if (!function_exists('nokri_remove_empty_p')) {

    function nokri_remove_empty_p($content) {
        $content = force_balance_tags($content);
        $content = preg_replace('#<p>\s*+(<br\s*/*>)?\s*</p>#i', '', $content);
        $content = preg_replace('~\s?<p>(\s|&nbsp;)+</p>\s?~', '', $content);
        return $content;
    }

}
add_filter('the_content', 'nokri_remove_empty_p', 20, 1);

/* ------------------------------------------------ */
/* // Remove notices in Redux */
/* ------------------------------------------------ */
add_action('init', 'nokri_removeDemoModeLink');

function nokri_removeDemoModeLink() { // Be sure to rename this function to something more unique
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_filter('plugin_row_meta', array(ReduxFrameworkPlugin::get_instance(), 'plugin_metalinks'), null, 2);
    }
    if (class_exists('ReduxFrameworkPlugin')) {
        remove_action('admin_notices', array(ReduxFrameworkPlugin::get_instance(), 'admin_notices'));
    }
}

/* Hide admin bar */
add_action('after_setup_theme', 'nokri_hide_adminbar');
if (!function_exists('nokri_hide_adminbar')) {

    function nokri_hide_adminbar() {
        if (is_user_logged_in() && !is_admin() && !( defined('DOING_AJAX') && DOING_AJAX )) {
            $user = wp_get_current_user();
            if (in_array('subscriber', $user->roles)) {
                // user has subscriber role
                show_admin_bar(false);
            }
        }
    }

}

/* For Demo Data Settings Starts */
// Ajax handler for add to cart
add_action('wp_ajax_demo_data_start', 'nokri_before_install_demo_data');

// Addind Subcriber into Mailchimp
function nokri_before_install_demo_data() {
    if (get_option('nokri_fresh_installation') != 'no') {
        update_option('nokri_fresh_installation', $_POST['is_fresh']);
    }
    die();
}

// Importing data
function nokri_importing_data($demo_type) {

    global $wpdb;
    $sql_file_OR_content="";
    if ($demo_type == 'Demo') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/demo-eng.sql';
    } else if ($demo_type == 'Arabic') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/demo-ar.sql';
    } else if ($demo_type == 'Hindi') {
        $sql_file_OR_content = SB_PLUGIN_PATH . 'sql/demo-hin.sql';
    }

    $SQL_CONTENT = (strlen($sql_file_OR_content) > 300 ? $sql_file_OR_content : file_get_contents($sql_file_OR_content) );

    $allLines = explode("\n", $SQL_CONTENT);
    $zzzzzz = $wpdb->query('SET foreign_key_checks = 0');
    preg_match_all("/\nCREATE TABLE(.*?)\`(.*?)\`/si", "\n" . $SQL_CONTENT, $target_tables);
    foreach ($target_tables[2] as $table) {
        $wpdb->query('DROP TABLE IF EXISTS ' . $table);
    }
    $zzzzzz = $wpdb->query('SET foreign_key_checks = 1');
    //$wpdb->query("SET NAMES 'utf8'");	
    $templine = ''; // Temporary variable, used to store current query
    foreach ($allLines as $line) {
        // Loop through each line
        if (substr($line, 0, 2) != '--' && $line != '') {
            $templine .= $line;  // (if it is not a comment..) Add this line to the current segment
            if (substr(trim($line), -1, 1) == ';') {  // If it has a semicolon at the end, it's the end of the query
                if ($wpdb->prefix != 'wp_') {
                    $templine = str_replace("`wp_", "`$wpdb->prefix", $templine);
                }
                if (!$wpdb->query($templine)) {
                    //print('Error performing query \'<strong>' . $templine . '\': ' . $wpdb->error . '<br /><br />');
                }
                $templine = ''; // set variable to empty, to start picking up the lines after ";"
            }
        }
    }
    //return 'Importing finished. Now, Delete the import file.';
}

/* For Demo Data Settings ends */

/* * * Sort and Filter Users ** */
add_action('restrict_manage_users', 'nokri_sb_filter_by_user_role');

function nokri_sb_filter_by_user_role($which) {

    if ($which == "top") {
// template for filtering
        $st = '<select name="job_role_%s" style="float:none;">
    <option value="">%s</option>%s</select>';

// generate options
        $options = '<option value="1">' . __('Employer', 'redux-framework') . '</option>
    <option value="0">' . __('Candidate', 'redux-framework') . '</option>';

        $age_selection = '<select name="user_age_%s" style="float:none;">
    <option value="">%s</option>%s</select>';
        $age_options = '<option value="5">' . __('5 years', 'redux-framework') . '</option>
                <option value="female">' . __('7 years', 'redux-framework') . '</option> '
                . '<option value="9">' . __('9 years', 'redux-framework') . '</option>'
                . '<option value="10">' . __('10 years', 'redux-framework') . '</option>'
                . '<option value="11">' . __('11 years', 'redux-framework') . '</option>'
                . '<option value="12">' . __('12 years', 'redux-framework') . '</option>'
                . '<option value="13">' . __('13 years', 'redux-framework') . '</option>'
                . '<option value="14">' . __('14 years', 'redux-framework') . '</option>'
                . '<option value="15">' . __('15 years', 'redux-framework') . '</option>'
                . '<option value="16">' . __('16 years', 'redux-framework') . '</option>'
                . '<option value="17">' . __('17 years', 'redux-framework') . '</option>'
                . '<option value="18">' . __('18 years', 'redux-framework') . '</option>'
                . '<option value="19">' . __('19 years', 'redux-framework') . '</option>'
                . '<option value="20">' . __('20 years', 'redux-framework') . '</option>'
                . '<option value="21">' . __('21 years', 'redux-framework') . '</option>'
                . '<option value="22">' . __('22 years', 'redux-framework') . '</option>'
                . '<option value="23">' . __('23 years', 'redux-framework') . '</option>'
                . '<option value="24">' . __('24 years', 'redux-framework') . '</option>'
                . '<option value="25">' . __('25 years', 'redux-framework') . '</option>'
                . '<option value="26">' . __('26 years', 'redux-framework') . '</option>'
                . '<option value="27">' . __('27 years', 'redux-framework') . '</option>'
                . '<option value="28">' . __('28 years', 'redux-framework') . '</option>'
                . '<option value="29">' . __('29 years', 'redux-framework') . '</option>'
                . '<option value="30">' . __('30 years', 'redux-framework') . '</option>'
                . '<option value="31">' . __('31 years', 'redux-framework') . '</option>'
                . '<option value="32">' . __('32 years', 'redux-framework') . '</option>'
                . '<option value="33">' . __('33 years', 'redux-framework') . '</option>'
                . '<option value="34">' . __('34 years', 'redux-framework') . '</option>'
                . '<option value="35">' . __('35 years', 'redux-framework') . '</option>'
                . '<option value="36">' . __('36 years', 'redux-framework') . '</option>'
                . '<option value="37">' . __('37 years', 'redux-framework') . '</option>'
                . '<option value="38">' . __('38 years', 'redux-framework') . '</option>'
                . '<option value="39">' . __('39 years', 'redux-framework') . '</option>'
                . '<option value="40">' . __('40 years', 'redux-framework') . '</option>'
                . '<option value="41">' . __('41 years', 'redux-framework') . '</option>'
                . '<option value="42">' . __('42 years', 'redux-framework') . '</option>'
                . '<option value="43">' . __('43 years', 'redux-framework') . '</option>'
                . '<option value="44">' . __('44 years', 'redux-framework') . '</option>'
                . '<option value="45">' . __('45 years', 'redux-framework') . '</option>'
                . '<option value="50">' . __('50 years', 'redux-framework') . '</option>';

        $gender = '<select name="user_gender_%s" style="float:none;">
    <option value="">%s</option>%s</select>';

// generate options
        $gen_options = '<option value="male">' . __('Male', 'redux-framework') . '</option>
    <option value="female">' . __('Female', 'redux-framework') . '</option> <option value="other">' . __('Other', 'redux-framework') . '</option>';

        $age_input_start = isset($_GET['age_input_start']) ? $_GET['age_input_start'] : "";
        $reg_date = isset($_GET['user_reg_date']) ? $_GET['user_reg_date'] : "";
        ?>
<input type="date" name="user_reg_date" id="user_reg_date" class="user_reg_date"
    value="<?php echo esc_html($reg_date); ?>" autocomplete="off">
<?php
        $age_val = sprintf($age_selection, $which, __('Age', 'redux-framework'), $age_options);
        $gender_val = sprintf($gender, $which, __('Gender', 'redux-framework'), $gen_options);
        $select = sprintf($st, $which, __('User Type', 'redux-framework'), $options);

        echo '' . $age_val;
        echo '' . $gender_val;
        echo '' . $select;
        submit_button(__('Filter', 'redux-framework'), 'button button-primary users_type_filter', $which, false);
    }
}

add_filter('pre_get_users', 'nokri_sb_filter_by_user_role_section');

function nokri_sb_filter_by_user_role_section($query) {
    global $pagenow;
    if (is_admin() && 'users.php' == $pagenow) {

        $top = isset($_GET['job_role_top']) ? $_GET['job_role_top'] : '';
       // $bottom = $_GET['job_role_bottom'] ? $_GET['job_role_bottom'] : '';
       $bottom = $_GET['job_role_bottom'] ?? '';

        if ($top != "") {
            $section = $top != "" ? $top : $bottom;
            if ($section == 0 || $section == '0') {
                $section = '0';
            }
// change the meta query based on which option was chosen

            $meta_query = [['key' => '_sb_reg_type', 'value' => $section, 'compare' => '=']];
            $query->set('meta_query', $meta_query);
        }

        $gender_top = "";

        $gender_top = isset($_GET['user_gender_top']) ? $_GET['user_gender_top'] : '';

        if ($gender_top != "") {
            $gen_section = $gender_top != "" ? $gender_top : '';

// change the meta query based on which option was chosen

            $meta_query = [['key' => '_cand_gender', 'value' => $gen_section, 'compare' => '=']];
            $query->set('meta_query', $meta_query);
        }

        $age_top = isset($_GET['user_age_top']) ? $_GET['user_age_top'] : '';
        //$age_bottom = $_GET['user_age_bottom'] ? $_GET['user_age_bottom'] : '';
        if ($age_top != "") {
            $gen_section = $age_top != "" ? $age_top : '';

            $meta_query = [['key' => 'user_age_numeric_value', 'value' => $gen_section, 'compare' => '=']];
            $query->set('meta_query', $meta_query);
        }
        $user_reg_date = isset($_GET['user_reg_date']) ? $_GET['user_reg_date'] : '';

        if ($user_reg_date != '') {
            $new_date = strtotime($user_reg_date);
            $new_reg_date = date('d-m-Y', $new_date);
            $reg_date = $new_reg_date != "" ? $new_reg_date : '';

            $meta_query = [['key' => 'sb_user_reg_date', 'value' => "$reg_date", 'compare' => '=']];
            $query->set('meta_query', $meta_query);
        }
    }
}

/* Generationg/ Exporting Records */
add_filter('bulk_actions-users', function ($bulk_cand_record) {
    $bulk_cand_record['cand_bulk_records'] = __('Export Candidates Record', 'redux-framework');
    return $bulk_cand_record;
});
add_filter('handle_bulk_actions-users', function ($redirect_url, $action, $user_ids) {
    global $nokri;
    if ($action == 'cand_bulk_records') {

        foreach ($user_ids as $key => $user_id) {

            $reg_type = get_user_meta($user_id, '_sb_reg_type', true);
        } if ($reg_type != "0" && $reg_type != 0) {
            ?>
<script type="text/javascript">
alert(
    "<?php echo esc_html('Please select only candidates, Go back and select users type carefully.', 'redux-framework'); ?>"
);
location.reload();
window.stop();
</script>
<?php
            exit;
        } else {
            $rnd_nme = '';
            $rnd_nme = rand(1, 99999);
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="candidates_record"' . $rnd_nme . '".csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
            $file = fopen('php://output', 'w');
            fputcsv($file, array('Sr #', 'UserID', 'Title', 'Headline', 'Registration', 'Qualification', 'D-O-B', 'Gender', 'Address', 'Phone No', 'Profile Status'));
            /* Author Data Array */
            foreach ($user_ids as $key => $user_id) {

                $user_info = get_userdata($user_id);

                /* Author Data Array */
                $data_array = $user_info->data;
                $cand_id = $data_array->ID;
                /* CSV Fields */
                $tile = $data_array->user_nicename;
                $cand_headline = get_user_meta($cand_id, '_user_headline', true);
                $registration = $data_array->user_registered;
                $qualification = get_user_meta($cand_id, 'cand-qualification', true);
                $cand_dob = get_user_meta($cand_id, '_cand_dob', true);
                $gender = get_user_meta($cand_id, 'cand-gender', true);
                $cand_address = get_user_meta($cand_id, '_cand_address', true);
                $cand_phone = get_user_meta($cand_id, '_sb_contact', true);
                $cand_profile_status = get_user_meta($cand_id, '_user_profile_status', true);

                fputcsv($file, array($key, $user_id, $tile, $cand_headline, $registration, $qualification, $cand_dob, $gender, $cand_address, $cand_phone, $cand_profile_status,));
            }
            exit();
            $redirect_url = add_query_arg('save_cands_bulk_record', count($user_ids), $redirect_url);
        }
    }
    return $redirect_url;
}, 10, 3);

/* Generationg/ Exporting Records */
add_filter('bulk_actions-users', function ($bulk_emp_record) {
    $bulk_emp_record['emp_bulk_records'] = __('Export Employees Record', 'redux-framework');
    return $bulk_emp_record;
});
add_filter('handle_bulk_actions-users', function ($redirect_url, $action, $user_ids) {
    global $nokri;
    if ($action == 'emp_bulk_records') {

        foreach ($user_ids as $key => $user_id) {

            $reg_type = get_user_meta($user_id, '_sb_reg_type', true);
        } if ($reg_type !== "1" || $reg_type !== 1 && $reg_type == 0 || $reg_type == "0") {
            ?>
<script type="text/javascript">
alert(
    "<?php echo esc_html('Please select only Employees, Go back and select users carefully.', 'redux-framework'); ?>"
);
location.reload();
window.stop();
</script>
<?php
            exit;
        } else {
            $rnd_nme = '';
            $rnd_nme = rand(1, 99999);
            header('Content-type: text/csv');
            header('Content-Disposition: attachment; filename="employers_record"' . $rnd_nme . '".csv"');
            header('Pragma: no-cache');
            header('Expires: 0');
            $file = fopen('php://output', 'w');
            fputcsv($file, array('Sr #', 'UserID', 'Title', 'Headline', 'Registration', 'Address', 'Phone No', 'Profile Status'));

            /* Author Data Array */
            foreach ($user_ids as $key => $user_id) {

                $user_info = get_userdata($user_id);
                /* Author Data Array */
                $data_array = ($user_info->data);
                /* CSV Fields */
                $tile = $data_array->user_nicename;
                $emp_headline = get_user_meta($user_id, '_user_headline', true);
                $emp_establish = get_user_meta($user_id, '_emp_est', true);
                $emp_address = get_user_meta($user_id, '_emp_map_location', true);
                $emp_cntct = get_user_meta($user_id, '_sb_contact', true);
                $emp_profile_status = get_user_meta($user_id, '_user_profile_status', true);

                fputcsv($file, array($key, $user_id, $tile, $emp_headline, $emp_establish, $emp_address, $emp_cntct, $emp_profile_status,));
            }
            exit();

            $redirect_url = add_query_arg('save_emps_bulk_record', count($user_ids), $redirect_url);
        }
    }
    return $redirect_url;
}, 10, 3);

/* * ********************* */
/* User Age information */
/* * ******************* */

function nokri_sb_new_modify_user_table($column) {
    //$column['user_age'] = __('Age (year)', 'redux-framework');
    $column['phone_num'] = __('Phone', 'redux-framework');
    $column['registration_date'] = __('Reg Date', 'redux-framework');
    return $column;
}

add_filter('manage_users_columns', 'nokri_sb_new_modify_user_table');

function nokri_sb_show_modify_user_table($val, $column_name, $user_id) {

    $reg_type = get_user_meta($user_id, '_sb_reg_type', true);

    if ($reg_type == "1") {

        $user_dob = get_user_meta($user_id, '_emp_est', true);
    } else if ($reg_type == "0" || $reg_type == 0) {
        $user_dob = get_user_meta($user_id, '_cand_dob', true);
    } else {
        $user_dob = '';
    }
    $today = date("m/d/Y");

    $newDate = date("m/d/Y", strtotime($today));
    $d1 = new DateTime($newDate);

    $user_dobs = date("m/d/Y", strtotime($user_dob));
    $d2 = new DateTime($user_dobs);

    $interval = $d1->diff($d2);

    $diffInYears = $interval->y; //1
    if ($diffInYears != '') {
        update_user_meta($user_id, 'user_age_numeric_value', $diffInYears);
    }

    switch ($column_name) {

        case 'user_age' :
            return $diffInYears;
        default:
    }
    return $val;
}

add_filter('manage_users_custom_column', 'nokri_sb_show_modify_user_table', 10, 3);

function nokri_sb_show_modify_phone_no($val, $column_name, $user_id) {

    $cntct_no = get_user_meta($user_id, '_sb_contact', true);
    switch ($column_name) {

        case 'phone_num' :
            return $cntct_no;
        default:
    }
    return $val;
}

add_filter('manage_users_custom_column', 'nokri_sb_show_modify_phone_no', 10, 3);

function nokri_sb_show_reg_date($row_output, $column_id_attr, $user) {


    $date_format = ("d-m-Y");
    $user_reg_date = date($date_format, strtotime(get_the_author_meta('registered', $user)));

    if ($user_reg_date != '') {
        update_user_meta($user, 'sb_user_reg_date', $user_reg_date);
    }

    $user_reg_date_mod = get_user_meta($user, 'sb_user_reg_date', true);

    switch ($column_id_attr) {
        case 'registration_date' :
            return $user_reg_date_mod;
            break;
        default:
    }

    return $row_output;
}

add_filter('manage_users_custom_column', 'nokri_sb_show_reg_date', 10, 3);

function nokri_sb_sortable_column($columns) {
    $columns['user_age'] = __('Age', 'redux-framework');
    $columns['phone_num'] = __('Phone', 'redux-framework');
    $columns['registration_date'] = __('Regd date', 'redux-framework');

//To make a column 'un-sortable' remove it from the array unset($columns['date']);
    return $columns;
}

add_filter('manage_users_sortable_columns', 'nokri_sb_sortable_column');

/* * ********************* */
/* User type information */
/* * ******************* */

function new_user_type($contactmethods) {
    $contactmethods['user_type'] = __('User Type', 'redux-framework');
    return $contactmethods;
}

add_filter('new_user_type', 'new_user_type', 10, 1);

function new_modify_user_table($column) {
    $column['user_type'] = __('User Type', 'redux-framework');
    return $column;
}

add_filter('manage_users_columns', 'new_modify_user_table');

function new_modify_user_table_row($val, $column_name, $user_id) {
    switch ($column_name) {
        case 'user_type' :
            $user_tpye_info = __('Candidate', 'redux-framework');
            if (get_user_meta($user_id, '_sb_reg_type', true) == 1) {
                $user_tpye_info = __('Employer', 'redux-framework');
            }
            return $user_tpye_info;
            break;
        default:
    }
    return $val;
}

add_filter('manage_users_custom_column', 'new_modify_user_table_row', 10, 3);

class Nokri_Demo_OCDI {

    function __construct() {
        add_filter('pt-ocdi/plugin_intro_text', array($this, 'nokri_ocdi_plugin_intro_text'));
        add_filter('pt-ocdi/import_files', array($this, 'nokri_ocdi_import_files'));
        add_action('pt-ocdi/after_import', array($this, 'nokri_ocdi_after_import'));
        add_filter('pt-ocdi/disable_pt_branding', array($this, '__return_true'));
//add_action( 'pt-ocdi/enable_wp_customize_save_hooks',  array( $this, '__return_true') );		
    }

    function nokri_ocdi_import_files() {

        $allDemos = array();
        if (class_exists('WPBakeryVisualComposerAbstract')) {
            /* LTR Demo Options */
            $text = " - " . __('Imported', 'redux-framework') . "";
            $notice = $this->nokri_ocdi_before_content_import('Demo');
            $notice2 = ($notice != "" ) ? $text : "";
            $allDemos[] = array(
                'import_file_name' => 'Demo' . $notice2,
                'categories' => array('LTR Demo'),
                'local_import_file' => nokri_PLUGIN_PATH . 'demo-data/Demo/content.xml',
                'local_import_widget_file' => nokri_PLUGIN_PATH . 'demo-data/Demo/widgets.json',
                'local_import_customizer_file' => nokri_PLUGIN_PATH . 'demo-data/Demo/customizer.dat',
                'local_import_redux' => array(
                    array('file_path' => nokri_PLUGIN_PATH . 'demo-data/Demo/theme-options.json', 'option_name' => 'nokri',),),
                'import_preview_image_url' => nokri_PLUGIN_URL . 'demo-data/Demo/screen-image.png',
                'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
                'preview_url' => 'https://jobs.nokriwp.com/',
            );
            /* LTR Demo Options */

            /* LTR Demo Options */
            $text = " - " . __('Imported', 'redux-framework') . "";
            $notice = $this->nokri_ocdi_before_content_import('Hindi');
            $notice2 = ($notice != "" ) ? $text : "";
            $allDemos[] = array(
                'import_file_name' => 'Hindi' . $notice2,
                'categories' => array('LTR Demo'),
                'local_import_file' => nokri_PLUGIN_PATH . 'demo-data/Hindi/content.xml',
                'local_import_widget_file' => nokri_PLUGIN_PATH . 'demo-data/Hindi/widgets.json',
                'local_import_customizer_file' => nokri_PLUGIN_PATH . 'demo-data/Hindi/customizer.dat',
                'local_import_redux' => array(
                    array('file_path' => nokri_PLUGIN_PATH . 'demo-data/Hindi/theme-options.json', 'option_name' => 'nokri',),),
                'import_preview_image_url' => nokri_PLUGIN_URL . 'demo-data/Hindi/screen-image.png',
                'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
                'preview_url' => 'https://jobs.nokriwp.com/hindi/',
            );

            /* RTL Demo Options */
            $notice = $this->nokri_ocdi_before_content_import('Arabic');
            $notice2 = ($notice != "" ) ? $text : "";
            $allDemos[] = array(
                'import_file_name' => 'Arabic' . $notice2,
                'categories' => array('RTL Demo'),
                'local_import_file' => nokri_PLUGIN_PATH . 'demo-data/Arabic/content.xml',
                'local_import_widget_file' => nokri_PLUGIN_PATH . 'demo-data/Arabic/widgets.json',
                'local_import_customizer_file' => nokri_PLUGIN_PATH . 'demo-data/Arabic/customizer.dat',
                'local_import_redux' => array(
                    array('file_path' => nokri_PLUGIN_PATH . 'demo-data/Arabic/theme-options.json', 'option_name' => 'nokri',),),
                'import_preview_image_url' => nokri_PLUGIN_URL . 'demo-data/Arabic/screen-image.png',
                'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
                'preview_url' => 'https://jobs.nokriwp.com/rtl/',
            );
            /* RTL Demo Options */
        }
        if (class_exists('Nokri_Elementor')) {
            $text = " - " . __('Imported', 'redux-framework') . "";
            $notice = $this->nokri_ocdi_before_content_import('Demo-elementor');
            $notice2 = ($notice != "" ) ? $text : "";
            $allDemos[] = array(
                'import_file_name' => 'Demo-elementor' . $notice2,
                'categories' => array('LTR Demo'),
                'local_import_file' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor/content.xml',
                'local_import_widget_file' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor/widgets.txt',
                // 'local_import_customizer_file' => nokri_PLUGIN_PATH . 'demo-data/Demo/customizer.dat',
                'local_import_redux' => array(
                    array('file_path' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor/theme-options.txt', 'option_name' => 'nokri',),),
                'import_preview_image_url' => nokri_PLUGIN_URL . 'demo-data/Demo-elementor/screen-image.png',
                'import_notice' => $notice . '<br />' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
                'preview_url' => 'https://elementor.nokriwp.com/',
            );
            $notice = $this->nokri_ocdi_before_content_import('Arabic-elementor');
            $notice2 = ($notice != "" ) ? $text : "";
            $allDemos[] = array(
                'import_file_name' => 'Arabic-elementor' . $notice2,
                'categories' => array('RTL Demo'),
                'local_import_file' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor-Arabic/content.xml',
                'local_import_widget_file' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor-Arabic/widgets.txt',
                //  'local_import_customizer_file' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor-Arabic/customizer.dat',
                'local_import_redux' => array(
                    array('file_path' => nokri_PLUGIN_PATH . 'demo-data/Demo-elementor-Arabic/theme-options.txt', 'option_name' => 'nokri',),),
                'import_preview_image_url' => nokri_PLUGIN_URL . 'demo-data/Demo-elementor-Arabic/screen-image.png',
                'import_notice' => $notice . '' . __('Please waiting for a few minutes, do not close the window or refresh the page until the data is imported.', 'redux-framework'),
                'preview_url' => 'https://elementor.nokriwp.com/rtl/',
            );
        }
        return $allDemos;
    }

    function nokri_ocdi_before_content_import($a) {
        $msg = '';
        $fresh_installation = (array) get_option('_nokri_ocdi_demos');
        if (in_array("$a", $fresh_installation)) {
            $msg = __('Note: This demo data is already imported.', 'redux-framework');
            $msg = "<strong style='color:red;'>" . $msg . "</strong><br />";
        }
        return $msg;
    }

    function nokri_ocdi_options($demo_type = array()) {
        if (isset($demo_type)) {
            $fresh_installation = (array) get_option('_nokri_ocdi_demos');
            $result = array_merge($fresh_installation, $demo_type);
            $result = array_unique($result);
            update_option('_nokri_ocdi_demos', $result);
        }
        $fresh_installation = (array) get_option('_nokri_ocdi_demos');
    }

    function nokri_ocdi_after_import($selected_import) {

//echo "This will be displayed on all after imports!";
        $fresh_installation = get_option('nokri_fresh_installation');
        if ($fresh_installation != 'no') {
//if($fresh_installation == 'yes'){
            global $wpdb;
            $wpdb->query("TRUNCATE TABLE $wpdb->term_relationships");
            $wpdb->query("TRUNCATE TABLE $wpdb->term_taxonomy");
            $wpdb->query("TRUNCATE TABLE $wpdb->termmeta");
            $wpdb->query("TRUNCATE TABLE $wpdb->terms");
//}
        }

        if ('Demo' === $selected_import['import_file_name']) {

            //$primary_menu = get_term_by('name', 'Main Navigation', 'nav_menu');
            //if (isset($primary_menu->term_id)) {set_theme_mod('nav_menu_locations', array('main-nav' => $primary_menu->term_id)); }
            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('Home 3');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                nokri_importing_data('Demo');
            }
            update_option('nokri_fresh_installation', 'no');
            $this->nokri_ocdi_options(array('Demo'));
        }
        if ('Demo-elementor' === $selected_import['import_file_name']) {

            //$primary_menu = get_term_by('name', 'Main Navigation', 'nav_menu');
            //if (isset($primary_menu->term_id)) {set_theme_mod('nav_menu_locations', array('main-nav' => $primary_menu->term_id)); }

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('Home 3');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                nokri_importing_data('Demo');
            }
            update_option('nokri_fresh_installation', 'no');
            $this->nokri_ocdi_options(array('Demo'));
        }

        if ('Hindi' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('Home 3');
            $blog_page_id = get_page_by_title('Blog');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                nokri_importing_data('Demo');
            }
            update_option('nokri_fresh_installation', 'no');
            $this->nokri_ocdi_options(array('Demo'));
        }
        if ('Arabic' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('الكاجو مصنفة');
            $blog_page_id = get_page_by_title('مدون');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                nokri_importing_data('Arabic');
            }
            update_option('nokri_fresh_installation', 'no');
            $this->nokri_ocdi_options(array('Arabic'));
        }
        if ('Arabic-elementor' === $selected_import['import_file_name']) {

            $primary_menu = get_term_by('name', 'Main Menu', 'nav_menu');
            if (isset($primary_menu->term_id)) {
                set_theme_mod('nav_menu_locations', array('main_menu' => $primary_menu->term_id));
            }
            // Assign front page and posts page (blog page).
            $front_page_id = get_page_by_title('الكاجو مصنفة');
            $blog_page_id = get_page_by_title('مدون');
            update_option('show_on_front', 'page');
            update_option('page_on_front', $front_page_id->ID);
            update_option('page_for_posts', $blog_page_id->ID);

            if ($fresh_installation != 'no') {
                nokri_importing_data('Arabic');
            }
            update_option('nokri_fresh_installation', 'no');
            $this->nokri_ocdi_options(array('Arabic'));
        }

        global $wp_rewrite;
        $wp_rewrite->set_permalink_structure('/%postname%/');
    }

    function nokri_ocdi_plugin_intro_text($default_text) {
        $default_text .= '<div class="ocdi__intro-text"><h4 id="before">Before Importing Demo</h4>
            <p><strong>Before importing one of the demos available it is advisable to check the following list</strong>. <br />All these queues are important and will ensure that the import of a demo ends successfully. In the event that something should go wrong with your import, open a ticket and <a href="https://scriptsbundle.ticksy.com/" target="_blank">contact our Technical Support</a>.</p>
            <ul>
                <li><strong>Theme Activation</strong> – Please make sure to activate the theme to be able to access the demo import section</li>
                <li><strong>Required Plugins</strong> – Install and activate all required plugins</li>
                <li><strong>Other Plugins</strong> – Is recommended to <strong>disable all other plugins that are not required</strong>. Such as plugins to create coming soon pages, plugins to manage the cache, plugin to manage SEO, etc &#8230; You will reactivate your personal plugins later as soon as the import process is finished</li>
            </ul>
            <h4>Requirements for demo importing</h4>
            <p>To correctly import a demo please make sure that your hosting is running the following features:</p>
            <p><strong>WordPress Requirements</strong></p>
            <ul>
                <li>WordPress 4.6+</li>
                <li>PHP 5.6+</li>
                <li>MySQL 5.6+</li>
            </ul>
            <p><strong>Recommended PHP configuration limits</strong></p>
            <p>*If the import stalls and fails to respond after a few minutes it because your hosting is suffering from PHP configuration limits. You should contact your hosting provider and ask them to increase those limits to a minimum as follows:</p>
            <ul>
                <li>max_execution_time 3000</li>
                <li>memory_limit 256M</li>
                <li>post_max_size 100M</li>
                <li>upload_max_filesize 81M</li>
            </ul></div>
        <p><strong>*Please note that you can import 1 demo data select it carefully.</strong></p>
        <hr />';

        return $default_text;
    }

}

$nokri_demo_ocdi = new Nokri_Demo_OCDI();

/* * *************************************** */
/* Nokri taxonomies custom feilds function */
/* * *************************************** */
if (!function_exists('nokri_get_term_form')) {

    function nokri_get_term_form($term_id = '', $post_id = '', $formType = 'dynamic', $is_array = '') {

        global $nokri;
        $data = ($formType == 'dynamic' && $term_id != "") ? sb_text_field_value($term_id) : sb_getTerms('custom');
        if ($is_array == 'arr')
            return $data;
        $dataHTML = '';
        foreach ($data as $d) {
            $name = $d['name'];
            $slug = $d['slug'];
            if ($formType == 'static') {
                $showme = 1;
                if (isset($nokri["allow_job_tags"]) && $slug == 'job_tags') {
                    $showme = $nokri["allow_job_tags"];
                }
                if (isset($nokri["allow_job_type"]) && $slug == 'job_type') {
                    $showme = $nokri["allow_job_type"];
                }
                if (isset($nokri["allow_job_qualifications"]) && $slug == 'job_qualifications') {
                    $showme = $nokri["allow_job_qualifications"];
                }
                if (isset($nokri["allow_job_level"]) && $slug == 'job_level') {
                    $showme = $nokri["allow_job_level"];
                }
                if (isset($nokri["allow_job_salary"]) && $slug == 'job_salary') {
                    $showme = $nokri["allow_job_salary"];
                }
                if (isset($nokri["allow_job_salary_type"]) && $slug == 'job_salary_type') {
                    $showme = $nokri["allow_job_salary_type"];
                }
                if (isset($nokri["allow_job_skills"]) && $slug == 'job_skills') {
                    $showme = $nokri["allow_job_skills"];
                }
                if (isset($nokri["allow_job_experience"]) && $slug == 'job_experience') {
                    $showme = $nokri["allow_job_experience"];
                }
                if (isset($nokri["allow_job_currency"]) && $slug == 'job_currency') {
                    $showme = $nokri["allow_job_currency"];
                }
                $is_show = $showme;
                $is_this_req = 1;
            } else {
                $is_show = $d['is_show'];
                $is_this_req = $d['is_req'];
            }
            $is_req = $is_this_req;
            $is_search = $d['is_search'];
            $is_type = $d['is_type'];
            $required = (isset($is_req) && $is_req == 1 ) ? ' required="required"' : '';
            if ($is_show == 1) {
                if ($slug == 'job_tags') {
                    $is_type = 'textfield';
                }
                if ($is_type == 'textfield') {
                    $inputVal = get_post_meta($post_id, '_' . $slug, true);
                    if ($slug == 'job_tags') {
                        $tags_array = wp_get_object_terms($post_id, 'job_tags', array('fields' => 'names'));
                        $inputVal = implode(',', $tags_array);
                    }
                    $select_col = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
                    if ($slug == 'job_tags') {
                        $select_col = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
                    };
                    $dataHTML .= '<div class="' . esc_attr($select_col) . '">
            <div class="form-group">
                <label>' . ucfirst($name) . '</label>
                <input class="form-control" name="' . $slug . '" id="' . $slug . '" value="' . $inputVal . '" ' . $required . ' /></div></div>';
                } else {
                    $values = nokri_get_cats($slug, 0);
                    if (!empty($values) && count((array) $values) > 0) {
                        $multiple = '';
                        $select_name = $slug;
                        $select_col = 'col-lg-6 col-md-6 col-sm-6 col-xs-12';
                        if ($slug == 'job_skills') {
                            $multiple = 'multiple';
                            $select_name = 'job_skills[]';
                            $select_col = 'col-lg-12 col-md-12 col-sm-12 col-xs-12';
                        };
                        $dataHTML .= '<div class="' . esc_attr($select_col) . '">
            <div class="form-group">
                <label>' . $name . '</label>
                <select class="category form-control" id="' . $slug . '" name="' . $select_name . '" ' . $required . ' data-parsley-error-message="' . esc_html__('This field is required', 'redux-framework') . ' " ' . $multiple . '>
                    <option value="">' . esc_html__('Select Option', 'redux-framework') . '</option>';
                        foreach ($values as $val) {
                            if (isset($val->term_id) && $val->term_id != "") {
                                $id = $val->term_id;
                                $name = $val->name;
                                $job_tax = wp_get_post_terms($post_id, $slug, array("fields" => "ids"));
                                $job_tax = isset($job_tax[0]) ? $job_tax[0] : '';
                                $job_skills = wp_get_post_terms($post_id, 'job_skills', array("fields" => "ids"));
                                $selected = ( $job_tax == $val->term_id ) ? 'selected="selected"' : '';
                                if ($slug == 'job_skills') {
                                    if (in_array($val->term_id, $job_skills)) {
                                        $selected = 'selected="selected"';
                                    }
                                }
                                $dataHTML .= '<option value="' . $id . '"' . $selected . '>' . $name . '</option>';
                            }
                        }
                        $dataHTML .= '</select></div></div>';
                    }
                }
            }
        }
        return $dataHTML;
    }

}
/* Nokri static form */
if (!function_exists('nokri_get_static_form')) {

    function nokri_get_static_form($term_id = '', $post_id = '') {
        $html = '';
        $display_size = '';
        $price = '';
        $required = '';
        global $nokri;
        $size_arr = explode('-', $nokri['sb_upload_attach_size']);
        $display_size = $size_arr[1];
        $actual_size = $size_arr[0];

        $vals[] = array(
            'type' => 'textfield',
            'post_meta' => '_job_video',
            'is_show' => '_sb_default_cat_video_show',
            'is_req' => '_sb_default_cat_video_required',
            'main_title' => esc_html__('Youtube Video Link', 'redux-framework'),
            'sub_title' => '',
            'field_name' => 'job_video',
            'field_id' => 'job_video',
            'field_value' => '',
            'field_req' => $required,
            'cat_name' => '',
            'field_class' => '',
            'columns' => '12',
            'data-parsley-type' => 'url',
            'data-parsley-message' => esc_html__('This field is required.', 'redux-framework'),
        );
        $vals[] = array(
            'type' => 'image',
            'post_meta' => '',
            'is_show' => '_sb_default_cat_image_show',
            'is_req' => '_sb_default_cat_image_required',
            'main_title' => esc_html__('Click the box below to upload job attachments!', 'redux-framework'),
            'sub_title' => esc_html__('upload with a max file size of ', 'redux-framework') . $display_size,
            'field_name' => 'dropzone',
            'field_id' => 'dropzone_custom',
            'field_value' => '',
            'field_req' => $required,
            'cat_name' => '',
            'field_class' => ' dropzone',
            'columns' => '12',
            'data-parsley-type' => '',
            'data-parsley-message' => esc_html__('This field is required.', 'redux-framework'),
        );
        foreach ($vals as $val) {
            $type = $val['type'];
            $html .= nokri_return_input($type, $post_id, $term_id, $val);
        }

        return $html;
    }

}
/* Input For More Custom Inputs */
if (!function_exists('nokri_more_inputs')) {

    function nokri_more_inputs() {
        $r['job_posts']['name'] = esc_html__('Number of vacancies', 'redux-framework');
        $r['job_posts']['slug'] = 'job_posts';
        $r['job_posts']['is_show'] = '1';
        $r['job_posts']['is_req'] = '1';
        $r['job_posts']['is_search'] = '1';
        $r['job_posts']['is_type'] = 'textfield';
        return $r;
    }

}

add_action('wp', 'nokri_remove_admin_bar');

if (!function_exists('nokri_remove_admin_bar')) {

    function nokri_remove_admin_bar() {
        global $nokri;
        $admin_bar_check = isset($nokri['admin_top_bar_switch']) ? $nokri['admin_top_bar_switch'] : "";

        if ($admin_bar_check) {
            show_admin_bar(true);
           
        } else {
             if (is_user_logged_in()) {
                show_admin_bar(false);
            }
            
        }
    }

}
//set paid alert 
add_action('woocommerce_new_order_item', 'add_order_item_meta', 10, 2);

function add_order_item_meta($item_id, $values) {
    global $nokri;
    $is_paid = isset($nokri['job_alert_paid_switch']) ? $nokri['job_alert_paid_switch'] : false;
    $user_id = get_current_user_id();
    $alert_data = get_user_meta($user_id, 'temp_test_alert', true);
    if ($is_paid && $alert_data != "") {
        $key = 'temp_alert';
        wc_update_order_item_meta($item_id, $key, $alert_data);
    }
}

/* Admin Dashboard Statistics/Graph of total compnay Data */
add_filter('pre_get_document_title', 'nokri_change_job_archive_title', 9999);

/**
 * Add a new dashboard widget.
 */
function nokri_add_dashboard_widgets() {

    wp_add_dashboard_widget('dashboard_widget', 'Complete Data', 'nokri_dashboard_statistics');
}

add_action('wp_dashboard_setup', 'nokri_add_dashboard_widgets');

/**
 * Output the contents of the dashboard widget
 */
function nokri_dashboard_statistics() {

//Total published posts
    $count_posts = wp_count_posts();
    $published_posts = $count_posts->publish;

//Total no of users
    $result = count_users();
    $total_users = $result['total_users'];

//Total no of subscribers
    $total_subscribers = count(get_users(array('role' => 'subscriber')));

//Getting Total Employers
    $employer_qry = array(
        'key' => '_sb_reg_type',
        'value' => '1',
        'compare' => '='
    );
    $order = 'DESC';
    $orderby = 'meta_value';

// Query args
    $argssss = array(
        'order' => $order,
        'orderby' => array(
            $orderby,
            'registered',
        ),
        'role__in' => array('editor', 'administrator', 'subscriber'),
        'meta_query' => array(array(
                'relation' => 'OR',
            ),
            array(
                'key' => '_sb_is_member',
                'compare' => 'NOT EXISTS'
            ),
            $employer_qry
        )
    );
// Create the WP_User_Query object
    $wp_user_query = new WP_User_Query($argssss);
// Get the results
    $total_reg_employer = $wp_user_query->get_total();

//Getting Total Candiddates
    $candidate_qry = array(
        'key' => '_sb_reg_type',
        'value' => '0',
        'compare' => '='
    );
    $order = 'DESC';
    $orderby = 'meta_value';

// Query args
    $argss = array(
        'order' => $order,
        'orderby' => array(
            $orderby,
            'registered',
        ),
        'role__in' => array('editor', 'administrator', 'subscriber'),
        'meta_query' => array(array(
                'relation' => 'OR',
            ),
            array(
                'key' => '_sb_is_member',
                'compare' => 'NOT EXISTS'
            ),
            $candidate_qry
        )
    );
// Create the WP_User_Query object
    $wp_cand_query = new WP_User_Query($argss);
// Get the results
    $total_reg_cands = $wp_cand_query->get_total();

//Getting Total Employer Members
    $members_qry = array(
        'key' => '_sb_is_member',
        'value' => '1',
        'compare' => '='
    );
    $order = 'DESC';
    $orderby = 'meta_value';

// Query args
    $args = array(
        'order' => $order,
        'orderby' => array(
            $orderby,
            'registered',
        ),
        'role__in' => array('editor', 'administrator', 'subscriber'),
        'meta_query' => array(array(
                'relation' => 'OR',
            ),
            $members_qry
        )
    );
// Create the WP_User_Query object
    $wp_mem_query = new WP_User_Query($args);
// Get the results
    $employer_members = $wp_mem_query->get_total();
    ?>
<div class="container" id="chartcontainer">
    <canvas id="myChart" style="position: relative; height:50vh; width:25vw"></canvas>
</div>
<script language="Javascript">
let myChart = document.getElementById('myChart').getContext('2d');
// Global Options
Chart.defaults.global.responsive = true;
Chart.defaults.global.defaultFontFamily = 'Times';
Chart.defaults.global.defaultFontSize = 15;
Chart.defaults.global.defaultFontColor = '#000';
var no_of_published_jobs = '<?php echo esc_attr($published_posts); ?>';
var no_of_users = '<?php echo esc_attr($total_users); ?>';
var no_of_subscribers = '<?php echo esc_attr($total_subscribers); ?>';
var reg_employers = '<?php echo esc_attr($total_reg_employer); ?>';
var reg_candidates = '<?php echo esc_attr($total_reg_cands); ?>';
var reg_members = '<?php echo esc_attr($employer_members); ?>';
let massPopChart = new Chart(myChart, {
    type: 'horizontalBar', // bar, horizontalBar, pie, line, doughnut, radar, polarArea
    data: {
        labels: ['<?php echo esc_html__('Published Jobs', 'nokri'); ?>',
            '<?php echo esc_html__('Total Users', 'nokri'); ?>',
            '<?php echo esc_html__('Subscribers', 'nokri'); ?>',
            '<?php echo esc_html__('Registered Companies', 'nokri'); ?>',
            '<?php echo esc_html__('Registered Candidates', 'nokri'); ?>',
            '<?php echo esc_html__('Employers Members', 'nokri'); ?>'
        ],
        datasets: [{
            label: '<?php echo esc_html__('', 'nokri'); ?>',
            data: [
                no_of_published_jobs,
                no_of_users,
                no_of_subscribers,
                reg_employers,
                reg_candidates,
                reg_members
            ],
            //backgroundColor:'green',
            backgroundColor: [
                'rgba(255, 99, 132, 0.4)',
                'rgba(54, 162, 235, 0.4)',
                'rgba(255, 206, 86, 0.4)',
                'rgba(75, 192, 192, 0.4)',
                'rgba(153, 102, 255, 0.4)',
                'rgba(255, 159, 64, 0.4)'
            ],
            borderWidth: 1,
            borderColor: [
                'rgba(255, 99, 132, 1)',
                'rgba(54, 162, 235, 1)',
                'rgba(255, 206, 86, 1)',
                'rgba(75, 192, 192, 1)',
                'rgba(153, 102, 255, 1)',
                'rgba(255, 159, 64, 1)'
            ],
            hoverBorderWidth: 1,
        }]
    },
    options: {
        title: {
            display: true,
            text: 'Company Statistics',
            fontSize: 25,
            fontColor: '#000'
        },
        legend: {
            display: false,
            labels: {
                fontColor: '#000',
            }
        },
        layout: {
            padding: {
                left: 0,
                right: 0,
                bottom: 0,
                top: 0
            }

        },
        tooltips: {
            enabled: true
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});
</script>
<?php
}

/* Function Admin for Dashboard Documentation Links */
if (!function_exists('nokri_admin_dashboard_section')) {

    function nokri_admin_dashboard_section() {
        global $pagenow;
        if( isset($_GET['dismis_welcome']) &&   $_GET['dismis_welcome'] != ""){
           update_user_meta(get_current_user_id() , 'dismis_welcome' , '1');
        }
   
        $is_allow  =  get_user_meta(get_current_user_id() , 'dismis_welcome' , true);
       
        if($pagenow != "index.php" || $is_allow == '1' ) return '';
        ?>
<div class="wr-ap">
    <br />
    <div id="welcome-panel" class="welcome-panel">
        <div class="welcome-panel-contents">
            <h2 style="display: inline;"><?php esc_html_e("Nokri - JobBoard WordPress Theme", "nokri"); ?></h2>
            <a href="<?php echo get_admin_url(). "?dismis_welcome=1"?>" aria-label="Dismiss the welcome panel"
                style="color: white;font-size: 20px;margin-left: 5px;">Dismiss</a>
        </div>
        <div class="welcome-panel-column-container">
            <div class="welcome-panel-column">
                <h3><?php esc_html_e("Get Started", "nokri"); ?></h3>
                <p>
                    <?php esc_html_e("Docementation will helps you to understand the theme flow and will help you to setup the theme accordingly. Click the button below to go to the docementation.", "nokri"); ?>
                </p>
                <a class="button button-primary button-hero load-customize hide-if-no-customize"
                    href="https://documentation.scriptsbundle.com/"
                    target="_blank"><?php esc_html_e("Docementation", "nokri"); ?></a>
            </div>
            <div class="welcome-panel-column">
                <h3><?php esc_html_e("Having Issues? Get Support!", "nokri"); ?></h3>
                <p>
                    <?php esc_html_e("If you are facing any issue regarding setting up the theme. You can contact our support team they will be very happy to assist you.", "nokri"); ?>
                </p>
                <a class="button button-primary button-hero load-customize hide-if-no-customize"
                    href="https://scriptsbundle.ticksy.com/"
                    target="_blank"><?php esc_html_e("Get Theme Support", "nokri"); ?></a>
            </div>
            <div class="welcome-panel-column welcome-panel-last">
                <h3><?php esc_html_e("Looking For Customizations?", "nokri"); ?></h3>
                <?php esc_html_e("Looking to add more features in the theme no problem. Our development team will customize the theme according to your requirnments. Click the link below to contact us.", "nokri"); ?>
                </p>
                <a class="button button-primary button-hero load-customize hide-if-no-customize"
                    href="https://scriptsbundle.com/freelancer/"
                    target="_blank"><?php esc_html_e("Looking For Customization?", "nokri"); ?></a>
            </div>
        </div>
        <br />
        <p class="hide-if-no-customize">
            <?php esc_html_e("by", "nokri"); ?>, <a href="https://themeforest.net/user/scriptsbundle/portfolio"
                target="_blank"><?php esc_html_e("ScriptsBundle", "nokri"); ?></a>
        </p>
    </div>
</div>
<?php
//Menu page of Hired candidate

function wpdocs_register_my_custom_menu_page() {
    add_menu_page(
        __( 'Hired Candidate', 'nokri' ),
      __( 'Hired Candidate', 'nokri' ),
        'manage_options',
        'hire_can',
        'my_menu_page',
        'dashicons-format-aside', // Icon URL or Dashicons class name
        6
    );
}
add_action( 'admin_menu', 'wpdocs_register_my_custom_menu_page' );

//Create table for Hired Candidate
function create_custom_table() {
    global $wpdb;

    $table_name = $wpdb->prefix . 'custom_data_fields';

    $charset_collate = $wpdb->get_charset_collate();

    $sql = "CREATE TABLE $table_name (
        rowid mediumint(9) NOT NULL AUTO_INCREMENT,
        candidate_id mediumint(9) NOT NULL,
        employer_id mediumint(9) NOT NULL,
        job_id mediumint(9) NOT NULL,
        status varchar(255) NOT NULL DEFAULT 'No',
        file_path varchar(255) DEFAULT '' NOT NULL,
        date datetime DEFAULT '0000-00-00 00:00:00' NOT NULL,
        PRIMARY KEY (rowid)
    ) $charset_collate;";

    require_once(ABSPATH . 'wp-admin/includes/upgrade.php');
    dbDelta($sql);
}


// Hook the table creation function to the init hook
add_action('init', 'create_custom_table');


//Function of Hired candidate page

function my_menu_page() {
    global $wpdb;

    // Define your custom table name
    $table_name = $wpdb->prefix . 'custom_data_fields';
    $items_per_page = 4;
$current_page = isset($_GET['paged']) ? intval($_GET['paged']) : 1;
// Calculate the offset for the database query
$offset = ($current_page - 1) * $items_per_page;
$data = $wpdb->get_results(
    $wpdb->prepare("SELECT * FROM $table_name LIMIT %d OFFSET %d", $items_per_page, $offset)
);

    // Check if there is data
    if (!empty($data)) {
        echo '<div class="wrap"><h2>Custom Table Data</h2>';
       // echo '<button class="button button-primary" id="delete_invoices" onclick="deleteInvoices()" style="float: right;">Delete All Invoice</button>';
        echo '<table class="wp-list-table widefat fixed striped">';
        echo '<thead><tr><th>Job Title</th><th>Candidate Name</th><th>Candidate Email</th><th>Employer Name</th><th>Date</th><th>Actions</th><th>Status</th><th>Download PDF</th></tr></thead>';
        echo '<tbody>';

        foreach ($data as $row) {
            $candidate_data = get_userdata($row->candidate_id);
            if($candidate_data){
            $job_title = get_the_title($row->job_id);
            // Get user data for candidate
            $candidate_data = get_userdata($row->candidate_id);
            $candidate_name = $candidate_data ? esc_html($candidate_data->display_name) : 'N/A';
            $candidate_email = $candidate_data ? esc_html($candidate_data->user_email) : 'N/A';

            // Get user data for employer
            $employer_data = get_userdata($row->employer_id);
            $employer_name = $employer_data ? esc_html($employer_data->display_name) : 'N/A';

            echo '<tr>';
            echo '<td>' . esc_html($job_title) . '</td>';
            echo '<td>' . esc_html($candidate_name) . '</td>';
            echo '<td>' . esc_html($candidate_email) . '</td>';
            echo '<td>' . esc_html($employer_name) . '</td>';
            echo '<td>' . esc_html($row->date) . '</td>';

            echo '<td>';
            echo '<button class="generate-invoice-button button button-primary" data-bs-toggle="modal" data-target="#invoiceModal" data-job-id="' . esc_attr($row->job_id) . '" data-candidate-id="' . esc_attr($row->candidate_id) . '" data-status="' . esc_attr($row->status) . '" data-row-id="' . esc_attr($row->rowid) . '" data-employer-id="' . esc_attr($row->employer_id) . '">Generate Invoice</button>';
            echo '</td>';
            echo '<td>' . esc_html($row->status) . '</td>';
            if ($row->status == 'yes' && file_exists(wp_upload_dir()['basedir'] . '/invoices/' . $row->file_path)) {
           

                echo '<td><a href="' . esc_url(get_site_url() . '/wp-content/uploads/invoices/' . $row->file_path) . '" class="download-pdf-button button button-primary" download>Download PDF</a></td>';
            } else {
                echo '<td></td>'; // Display an empty cell if status is not 'yes'
            }
         echo '</tr>';
        }
    }
        echo '</tbody>';
        echo '</table>';
      
        echo '</div>';
$total_items = $wpdb->get_var("SELECT COUNT(*) FROM $table_name");
        $total_pages = ceil($total_items / $items_per_page);

        echo '<div class="tablenav">';
        echo '<div class="tablenav-pages">';
        echo paginate_links(array(
            'base' => add_query_arg('paged', '%#%'),
            'format' => '',
            'prev_text' => __('Previous','nokri'),
            'next_text' => __('Next','nokri'),
            'total' => absint($total_pages),
            'current' => absint($current_page),
        ));
        echo '</div>';
        echo '</div>';
        // Rest of your code...
        echo '<div id="myModal-invoice" class="modal-invoice">';
        echo '<!-- Modal content -->';
        echo '<div class="modal-content-invoice">';
        echo '<span class="close">&times;</span>';
        echo '<h2>Generate PDF</h2>';
        echo '<form method="get" id="pdfForm">';
        echo '<label for="name">Enter Price:</label>';
        echo '<input type="text" name="price" id="price-invoice" placeholder="Enter Your price" required>';
        
        echo '<br>';
        echo '<label for="description-invoice">' . esc_html__('Description:', 'nokri') . '</label>';
        echo '<textarea name="description" id="description-invoice" placeholder="' . esc_html__('Enter Description', 'nokri') . '" required></textarea>';
        echo '<br>';
        echo '<input type="submit" name="generate_pdf" id="generate_pdf"  value="Generate PDF">';
        echo '</form>';
        echo '</div>';
        echo '</div>';
    } else {
        echo '<div class="wrap"><h2>No data found.</h2></div>';
    }
}
    }

    add_action('admin_notices', 'nokri_admin_dashboard_section');
}

/* Social Share post Image to Display */
//ad og:image meta for single ad view page
add_action('wp_head', 'sb_add_image_meta');
if (!function_exists('sb_add_image_meta')) {

    function sb_add_image_meta() {

        $job_id = get_the_ID();
        // Auhtor info
        $author_id = '';
        $author_info = get_post_field('post_author', $job_id);
        $author_data = get_userdata($author_info);
        if (!empty($author_data)) {
            $author_id = $author_data->ID;
        }
        if (get_user_meta($author_id, '_sb_user_pic', true) != "") {

            $attach_id = get_user_meta($author_id, '_sb_user_pic', true);
            $image_link = wp_get_attachment_image_src($attach_id, '');
            $user_image = $image_link[0];
        }

        if (is_single() && has_post_thumbnail()) {

            echo '<meta property="og:image" content="' . get_the_post_thumbnail_url($job_id, 'full') . '" />';
        } else {
            if (!empty($user_image)) {
                echo '<meta property="og:image" content="' . $user_image . '" />';
            }
        }
    }

}