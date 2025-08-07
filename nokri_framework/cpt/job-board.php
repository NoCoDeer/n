<?php

// Register custom post type
function nokri_theme_custom_job_req()
{
    $args = array(
        'public' => true,
        'label' => __('Job Request', 'redux-framework'),
        'supports' => array('title', 'thumbnail', 'editor', 'author'),
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        'rewrite' => array('with_front' => false, 'slug' => 'job_request')
    );

    register_post_type('job_request', $args);
}
add_action('init', 'nokri_theme_custom_job_req');

function nokri_theme_custom_job_req_columns($columns)
{

    $date_column = $columns['date'];
    unset($columns['date']);
    $columns['custom_column'] = __('Job Request', 'redux-framework');
    $columns['email'] = __('Email', 'redux-framework');
    $columns['date'] = $date_column;
    return $columns;
}
add_filter('manage_job_request_posts_columns', 'nokri_theme_custom_job_req_columns');

function nokri_theme_custom_job_req_column_data($column, $post_id)
{
    if ($column === 'custom_column') {
        $file_url = get_post_meta($post_id, '_det_file', true);

        if ($file_url) {
            echo '<a href="' . esc_url($file_url) . '" target="_blank">View File</a>';
        } else {
            echo 'No File';
        }
    } elseif ($column === 'email') {
        $user_email = get_post_meta($post_id, '_jb_email', true);
        echo esc_html($user_email);
    }
}
add_action('manage_job_request_posts_custom_column', 'nokri_theme_custom_job_req_column_data', 10, 2);


// Register post  type and taxonomy
add_action('init', 'sb_themes_custom_types', 0);

function sb_themes_custom_types()
{
    //Register Post type
    $args = array(
        'public' => true,
        'label' => __('Nokri JobBoard', 'redux-framework'),
        'supports' => array('title', 'thumbnail', 'editor', 'author'),
        'show_ui' => true,
        'capability_type' => 'post',
        'hierarchical' => true,
        'has_archive' => true,
        'rewrite' => array('with_front' => false, 'slug' => 'job')
    );
    register_post_type('job_post', $args);

    //add_filter('post_type_link', 'custom_event_permalink', 1, 3);
    function custom_event_permalink($post_link, $id = 0)
    {

        if (strpos('%ad%', $post_link) === 'FALSE') {
            return $post_link;
        }
        $post = get_post($id);
        if (is_wp_error($post) || $post->post_type != 'job_post') {
            return $post_link;
        }
        return str_replace('ad', 'ad/' . $post->ID, $post_link);
    }

    //add_action('init', 'register_job_board_taxonomies');
    // function register_job_board_taxonomies() {

    register_taxonomy('job_category', array('job_post'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => __('Categories', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_category'),
    ));

    //Ads Type
    register_taxonomy('job_type', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Type', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_type'),
    ));
    //Ads Type
    register_taxonomy('job_qualifications', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Qualifications', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_qualifications'),
    ));
    //Job Level
    register_taxonomy('job_level', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Level', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_level'),
    ));
    //Job Salary
    register_taxonomy('job_salary', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Salary', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_salary'),
    ));
    //Job Salary Type
    register_taxonomy('job_salary_type', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Salary Type', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_salary_type'),
    ));

    //Ad Experience 
    register_taxonomy('job_experience', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Experience', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_experience'),
    ));
    //Job Currency 
    register_taxonomy('job_currency', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Currency', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_currency'),
    ));
    //Job Shift
    register_taxonomy('job_shift', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Shift', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_shift'),
    ));
    //Job Skills
    register_taxonomy('job_skills', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Skills', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_skills'),
    ));
    register_taxonomy('emp_specialization', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Specilization', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'emp_specialization'),
    ));
    //Ads tags
    register_taxonomy('job_tags', array('job_post'), array(
        'hierarchical' => false,
        'label' => __('Tags', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_tag'),
    ));
    //Job Class
    register_taxonomy('job_class', array('job_post'), array(
        'hierarchical' => true,
        'label' => __('Job Class', 'redux-framework'),
        'show_ui' => true,
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'job_class'),
    ));


    //Ads Locations
    register_taxonomy('ad_location', array('job_post'), array(
        'hierarchical' => true,
        'show_ui' => true,
        'label' => __('Locations', 'redux-framework'),
        'show_admin_column' => true,
        'query_var' => true,
        'rewrite' => array('slug' => 'ad_location'),
    ));


    //Ads Cats
    // Register Post type for Map Countries
    $args = array(
        'public' => true,
        'menu_icon' => 'dashicons-location',
        'label' => __('Map Countries', 'redux-framework'),
        'supports' => array('thumbnail', 'title')
    );
    register_post_type('_sb_country', $args);
    //}
}

add_action('job_class_add_form_fields', 'job_class_metabox_add', 10, 1);
add_action('job_class_edit_form_fields', 'job_class_metabox_edit', 10, 1);

function job_class_metabox_add($tag)
{
?>
    <h3><?php echo __("Regular Job Info", "redux-framework"); ?></h3>
    <div class="form-field">
        <label for="emp_class_check"><?php echo __("Select regular for free jobs", "redux-framework"); ?></label>
        <select class="form-control" id="image2" name="emp_class_check">
            <option><?php echo __("Select Option", "redux-framework"); ?></option>
            <option><?php echo __("Regular", "redux-framework"); ?></option>
        </select>
    </div>
<?php
}

function job_class_metabox_edit($tag)
{
?>
    <h3><?php echo __("Regular Job Info", "redux-framework"); ?></h3>
    <table class="form-table">
        <tr class="form-field">
            <th scope="row" valign="top">
                <label for="emp_class_check"><?php echo __("Select regular for free jobs", "redux-framework"); ?></label>
            </th>
            <td>
                <?php
                $selectArrVal = get_term_meta($tag->term_id, 'emp_class_check', true);
                $selectArr = array(
                    "1" => __("Regular", "redux-framework"),
                );
                ?>
                <select name="emp_class_check" id="emp_class_check" type="text" aria-required="true">
                    <?php
                    echo '<option value="">' . __("Select Option", "redux-framework") . '</option>';
                    foreach ($selectArr as $key => $val) {
                        $selected = ($key == $selectArrVal) ? 'selected="selected"' : '';
                        echo '<option value="' . esc_attr($key) . '" ' . $selected . '>' . esc_html($val) . '</option>';
                    }
                    ?>
                </select>
            </td>
        </tr>
    </table>
<?php
}

add_action('created_job_class', 'save_job_class_metadata', 10, 1);
add_action('edited_job_class', 'save_job_class_metadata', 10, 1);

function save_job_class_metadata($term_id)
{ {
        if (isset($_POST['emp_class_check']))
            update_term_meta($term_id, 'emp_class_check', $_POST['emp_class_check']);
    }
}

add_action('menu_category_edit_form_fields', 'menu_category_edit_form_fields');
add_action('menu_category_add_form_fields', 'menu_category_edit_form_fields');
add_action('edited_menu_category', 'menu_category_save_form_fields', 10, 2);
add_action('created_menu_category', 'menu_category_save_form_fields', 10, 2);

function menu_category_save_form_fields($term_id)
{
    $meta_name = 'order';
    if (isset($_POST[$meta_name])) {
        $meta_value = $_POST[$meta_name];
        // This is an associative array with keys and values:
        // $term_metas = Array($meta_name => $meta_value, ...)
        $term_metas = get_option("taxonomy_{$term_id}_metas");
        if (!is_array($term_metas)) {
            $term_metas = array();
        }
        // Save the meta value
        $term_metas[$meta_name] = $meta_value;
        update_option("taxonomy_{$term_id}_metas", $term_metas);
    }
}

function menu_category_edit_form_fields($term_obj)
{
    // Read in the order from the options db
    $term_id = $term_obj->term_id;
    $term_metas = get_option("taxonomy_{$term_id}_metas");
    if (isset($term_metas['order'])) {
        $order = $term_metas['order'];
    } else {
        $order = '0';
    }
?>
    <tr class="form-field">
        <th valign="top" scope="row">
            <label for="order"><?php _e('Category Order', ''); ?></label>
        </th>
        <td>
            <input type="text" id="order" name="order" value="<?php echo esc_attr($order); ?>" />
        </td>
    </tr>
<?php
}

// Register metaboxes for Country CPT
add_action('add_meta_boxes', 'sb_meta_box_for_country');

function sb_meta_box_for_country()
{
    add_meta_box('sb_metabox_for_country', 'County', 'sb_render_meta_country', '_sb_country', 'normal', 'high');
}

function sb_render_meta_country($post)
{
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_country', 'meta_box_nonce_country');
?>
    <div class="margin_top">
        <input type="text" name="country_county" class="project_meta" placeholder="<?php echo esc_attr__('County', 'redux-framework'); ?>" size="30" value="<?php echo get_the_excerpt($post->ID); ?>" id="country_county" spellcheck="true" autocomplete="off">
        <p><?php echo __('This should be follow ISO2 like', 'redux-framework'); ?> <strong><?php echo __('US', 'redux-framework'); ?></strong> <?php echo __('for USA and', 'redux-framework'); ?> <strong><?php echo __('CA', 'redux-framework'); ?></strong> <?php echo __('for Canada', 'redux-framework'); ?>, <a href="http://data.okfn.org/data/core/country-list" target="_blank"><?php echo __('Read More.', 'redux-framework'); ?></a></p>
    </div>
<?php
}

// Saving Metabox data 
add_action('save_post', 'sb_themes_meta_save_country');

function sb_themes_meta_save_country($post_id)
{
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce_country']) || !wp_verify_nonce($_POST['meta_box_nonce_country'], 'my_meta_box_nonce_country'))
        return;

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_posts'))
        return;

    // Make sure your data is set before trying to save it
    if (isset($_POST['country_county'])) {
        //update_post_meta( $post_id, '_sb_country_county', $_POST['country_county'] );
        $my_post = array(
            'ID' => $post_id,
            'post_excerpt' => $_POST['country_county'],
        );
        global $wpdb;
        $county = $_POST['country_county'];
        $wpdb->query("UPDATE $wpdb->posts SET post_excerpt = '$county' WHERE ID = '$post_id'");
    }
}

add_filter('manage_job_post_posts_columns', function ($columns) {
    unset($columns['job_qualifications']);

    return $columns;
});
/* Remove Extra Columns Starts */
if (!function_exists('nokri_job_post_remove_columns')) {

    function nokri_job_post_remove_columns($columns)
    {
        $arr = array("job_type", "job_qualifications", "job_salary", "job_skills", "job_experience", "job_currency", "job_shift", "job_class", "ad_location", "job_level");
        foreach ($arr as $r) {
            $column_remove = '';
            $column_remove = 'taxonomy-' . $r;
            unset($columns["$column_remove"]);
        }
        $columns['job_date'] = esc_html__('Job Expiry', 'redux-framework');
        return $columns;
    }
}

add_action('manage_job_post_posts_custom_column', function ($column_name, $post_id) {

    if ($column_name == "job_date") {

        $exp_date = get_post_meta($post_id, '_job_date', true);
        echo empty($exp_date) ? '' : $exp_date;
    }
}, 10, 2);

add_filter('manage_edit-job_post_columns', 'nokri_job_post_remove_columns');
/* ========================= */
/* Add Custom Colours To Job Type */
/* ========================= */
add_action('admin_enqueue_scripts', 'nokri_mw_enqueue_color_picker');

function nokri_mw_enqueue_color_picker($hook_suffix)
{
    wp_enqueue_style('wp-color-picker');
    //  wp_enqueue_script('wp-color-picker-alpha', trailingslashit(get_template_directory_uri()) . 'js/wp-color-picker-alpha.min.js', array('wp-color-picker'), false, true);
    wp_enqueue_script('nokri-admin-js', trailingslashit(get_template_directory_uri()) . 'js/admin.js', array('wp-color-picker'), false, true);
}

function nokri_add_color_to_category($term)
{
    if (isset($term->taxonomy)) {
        $tax_type = ($term->taxonomy);
    } else {
        $tax_type = ($term);
    }
    $tax_type_meta = '_' . $tax_type . '_term_color';
    $tax_type_meta_bg = '_' . $tax_type . '_term_color_bg';
    $field_name = $tax_type . '_term_color';
    $field_name_bg = $tax_type . '_term_color_bg';
    $termID = isset($term->term_id) ? $term->term_id : '';
    $termMeta = get_term_meta($termID, $tax_type_meta, true);
    $termMeta_bg = get_term_meta($termID, $tax_type_meta_bg, true);
    $customfield = $termMeta;
    $cname = ($customfield && $customfield != "") ? $customfield : "#fff";
    $customfieldbg = $termMeta_bg;
    $cname_bg = ($customfieldbg && $customfieldbg != "") ? $customfieldbg : "#fff";
    echo "<table class='form-table'><tbody> <tr class='form-field term-parent-wrap'><th scope='row'><label for='" . $field_name_bg . "'>" . __('Select BG Color', 'opportunities') . "</label></th><td><input type='text' value='" . esc_attr($cname_bg) . "' class='my-color-field color-picker'  data-default-color='#effeff' data-alpha='true' name='" . $field_name_bg . "' id='" . $field_name_bg . "' /></td></tr></tbody></table>";


    echo "<table class='form-table'><tbody> <tr class='form-field term-parent-wrap'><th scope='row'><label for='" . $field_name . "'>" . __('Select Font Color', 'opportunities') . "</label></th><td><input type='text' value='" . esc_attr($cname) . "' class='my-color-field color-picker'  data-default-color='#effeff' data-alpha='true' name='" . $field_name . "' id='" . $field_name . "' /></td></tr></tbody></table>";
}

function save_custom_tax_color_field($termID)
{
    $taxonomy_data = get_term($termID);
    $taxonomy_type = ($taxonomy_data->taxonomy);
    $post_data = $taxonomy_type . '_term_color';
    $post_data_bg = $taxonomy_type . '_term_color_bg';
    if (isset($_POST[$post_data])) {
        $termMeta = $_POST[$post_data];
        $tax_type_meta = '_' . $taxonomy_type . '_term_color';

        update_term_meta($termID, $tax_type_meta, '');
        if ($termMeta != "") {
            update_term_meta($termID, $tax_type_meta, $termMeta);
        }
    }
    if (isset($_POST[$post_data_bg])) {
        $termMeta_bg = $_POST[$post_data_bg];
        $tax_type_meta_bg = '_' . $taxonomy_type . '_term_color_bg';
        update_term_meta($termID, $tax_type_meta_bg, '');
        if ($termMeta_bg != "") {
            update_term_meta($termID, $tax_type_meta_bg, $termMeta_bg);
        }
    }
}

$array_terms = array('job_type', 'job_class');
if (count((array) $array_terms) > 0) {
    foreach ($array_terms as $type) {
        if ($type != "") {
            add_action($type . '_add_form_fields', 'nokri_add_color_to_category');
            add_action($type . '_edit_form_fields', 'nokri_add_color_to_category');
            add_action("create_" . $type, 'save_custom_tax_color_field');
            add_action("edited_" . $type, 'save_custom_tax_color_field');
        }
    }
}
// Register metaboxes for Products
add_action('add_meta_boxes', 'sb_nokri_ad_meta_box');

function sb_nokri_ad_meta_box()
{
    add_meta_box('sb_thmemes_adforest_metaboxes_for_adss', __('Assign job', 'redux-framework'), 'sb_render_meta_for_ads', 'job_post', 'normal', 'high');
}

function sb_render_meta_for_ads($post)
{
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_ad', 'meta_box_nonce_product');
    $author_name = get_the_author_meta('display_name', $post->post_author);
?>
    <div class="margin_top">
        <p><?php echo __('Select Author', 'redux-framework'); ?></p>
        <select name="sb_change_author" id="sb_change_author" style="width:100%; height:40px;">
            <option value="<?php echo esc_attr($post->post_author) ?>" selected><?php echo esc_html($author_name) ?></option>
            <option value="-1"><?php echo esc_html__('Select to change', 'redux-framework') ?></option>
        </select>
    </div>
<?php
}

// Saving Metabox data 
add_action('save_post', 'sb_themes_meta_save_for_ad');

function sb_themes_meta_save_for_ad($post_id)
{
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce_product']) || !wp_verify_nonce($_POST['meta_box_nonce_product'], 'my_meta_box_nonce_ad'))
        return;

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_posts'))
        return;

    // Make sure your data is set before trying to save it
    if (isset($_POST['sb_change_author'])) {
        $my_post = array(
            'ID' => $post_id,
            'post_author' => $_POST['sb_change_author'],
        );
        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', 'sb_themes_meta_save_for_ad');

        // update the post, which calls save_post again
        wp_update_post($my_post);

        // re-hook this function
        add_action('save_post', 'sb_themes_meta_save_for_ad');
    }
}

/* Adding Metabox to Getting report Reasons and Description */
add_action('add_meta_boxes', 'nokri_job_report_metabox');

function nokri_job_report_metabox()
{
    add_meta_box('sb_thmemes_nokri_metaboxes_for_report', __('Submitted Job Reports', 'redux-framework'), 'sb_render_meta_for_job_reports', 'job_post', 'normal', 'high');
}

function sb_render_meta_for_job_reports($post)
{
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_ad', 'meta_box_nonce_product');

    /* Getting Report Description */
    $description_data = get_post_meta($post->ID, '_sb_job_report_description', true);
    /* Getting Reason to report Job */
    $report_reasons = get_post_meta($post->ID, '_sb_job_report_reason', true);
?>
    <div class="margin_top">
        <p><?php echo __('Report Details', 'redux-framework'); ?></p>
    </div>
<?php
    echo wp_strip_all_tags($report_reasons . '--' . $description_data);
}

/* Job post static feilds */
// Register metaboxes for Products
add_action('add_meta_boxes', 'nokri_job_post_feilds');

function nokri_job_post_feilds()
{
    add_meta_box('nokri_job_post_feilds', __('Static feilds', 'redux-framework'), 'nokri_job_post_feilds_renders', 'job_post', 'normal', 'high');
}

function nokri_job_post_feilds_renders($post)
{
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_ad', 'meta_box_nonce_product');
    $ad_map_lat = $ad_map_long = '';
    /* Getting post meta values */
    $job_apply_with = get_post_meta($post->ID, '_job_apply_with', true);
    $job_ext_url = get_post_meta($post->ID, '_job_apply_url', true);
    $job_deadline = get_post_meta($post->ID, '_job_date', true);
    $job_ext_mail = get_post_meta($post->ID, '_job_apply_mail', true);
    $job_ext_whatsapp = get_post_meta($post->ID, '_job_apply_whatsapp', true);
    $ad_mapLocation = get_post_meta($post->ID, '_job_address', true);
    $ad_map_lat = get_post_meta($post->ID, '_job_lat', true);
    $ad_map_long = get_post_meta($post->ID, '_job_long', true);
    if ($ad_map_lat == '') {
        $ad_map_lat = Redux::get_option('nokri', 'sb_default_lat');
    }
    if ($ad_map_long == '') {
        $ad_map_long = Redux::get_option('nokri', 'sb_default_long');
    }
    $ad_cats = nokri_get_cats('job_category', 0, 0, false);
    $cats_html = '';
    foreach ($ad_cats as $ad_cat) {
        $cats_html .= '<option value="' . $ad_cat->term_id . '">' . $ad_cat->name . '</option>';
    }
    /* For job category level text */
    $job_cat_level_1 = (isset($nokri['job_cat_level_1']) && $nokri['job_cat_level_1'] != "") ? $nokri['job_cat_level_1'] : esc_html__('Job category', 'nokri');
    $job_cat_level_2 = (isset($nokri['job_cat_level_2']) && $nokri['job_cat_level_2'] != "") ? $nokri['job_cat_level_2'] : esc_html__('Sub category', 'nokri');
    $job_cat_level_3 = (isset($nokri['job_cat_level_3']) && $nokri['job_cat_level_3'] != "") ? $nokri['job_cat_level_3'] : esc_html__('Sub sub category', 'nokri');
    $job_cat_level_4 = (isset($nokri['job_cat_level_4']) && $nokri['job_cat_level_4'] != "") ? $nokri['job_cat_level_4'] : esc_html__('Sub sub sub category', 'nokri');
?>


    <div class="row">
        <div class="margin_top clear-custom">
            <?php
            global $nokri;
            if ($nokri['job_post_form'] == '1') {
            ?>
                <div class="col-4">
                    <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                        <div class="form-group">
                            <label><?php echo esc_html($job_cat_level_1); ?></label>
                            <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html($job_cat_level_1); ?>" data-parsley-required="true" id="job_cat" name="job_cat">
                                <option value="0"><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                <?php echo "" . $cats_html; ?>
                            </select>
                            <input type="hidden" name="job_cat_id" id="job_cat_id" value="" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="second_level">
                        <div class="form-group">
                            <label><?php echo esc_html($job_cat_level_2); ?></label>
                            <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html($job_cat_level_2); ?>" id="job_cat_second" name="job_cat_second">
                                <option value="0"><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                <?php echo '' . ($sub_cats_html); ?>
                            </select>
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="third_level">
                        <div class="form-group">
                            <label><?php echo esc_html($job_cat_level_3); ?></label>
                            <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html($job_cat_level_3); ?>" id="job_cat_third" name="job_cat_third">
                                <option value="0"><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                <?php echo '' . ($sub_sub_cats_html); ?>
                            </select>
                            <input type="hidden" name="ad_cat_id" id="ad_cat_id" value="" />
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12" id="forth_level">
                        <div class="form-group">
                            <label><?php echo esc_html($job_cat_level_4); ?></label>
                            <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html($job_cat_level_4); ?>" id="job_cat_forth" name="job_cat_forth">
                                <option value="0"><?php echo esc_html__('Select Option', 'nokri'); ?></option>
                                <?php echo '' . ($sub_sub_sub_cats_html); ?>
                            </select>
                            <input type="hidden" name="ad_cat_id" id="ad_cat_id" value="" />
                        </div>
                    </div>
                </div>
            <?php
            }
            ?>
            <div class="col-4">
                <div class="form-group">
                    <p>
                        <?php echo __('Number of vacancies', 'redux-framework'); ?>
                    </p>
                    <input type="number" class="form-control" placeholder="<?php echo esc_html__('Number of vacancies', 'nokri'); ?>" name="job_posts" value="<?php echo get_post_meta($post->ID, '_job_posts', true); ?>">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <p>
                        <?php echo __('Application deadline', 'redux-framework'); ?>
                    </p>
                    <input type="text" value="<?php echo esc_html($job_deadline); ?>" class="form-control datepickerhere" data-parsley-required="true" data-language="en" name="job_date" placeholder="<?php echo esc_html__('Application deadline*', 'nokri'); ?>" autocomplete="off">
                </div>
            </div>
            <!--Apply With -->
            <div class="col-4">
                <div class="form-group">
                    <p>
                        <?php echo esc_html__('Apply With Link', 'redux-framework'); ?>
                    </p>
                    <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html__('Select an option', 'nokri'); ?>" name="job_apply_with" data-parsley-required="true" id="ad_external">
                        <option value="0">
                            <?php echo esc_html__('Select Option', 'redux-framework'); ?>
                        </option>
                        <option value="exter" <?php
                                                if ($job_apply_with == "exter") {
                                                    echo 'selected="selected"';
                                                }
                                                ?>>
                            <?php echo esc_html__('External Link', 'nokri'); ?>
                        </option>
                        <option value="inter" <?php
                                                if ($job_apply_with == "inter") {
                                                    echo 'selected="selected"';
                                                }
                                                ?>>
                            <?php echo esc_html__('Internal Link', 'nokri'); ?>
                        </option>
                        <option value="mail" <?php
                                                if ($job_apply_with == "mail") {
                                                    echo 'selected="selected"';
                                                }
                                                ?>>
                            <?php echo esc_html__('Email', 'nokri'); ?>
                        </option>
                        <option value="whatsapp" <?php
                                                    if ($job_apply_with == "whatsapp") {
                                                        echo 'selected="selected"';
                                                    }
                                                    ?>>
                            <?php echo esc_html__('Whatsapp', 'nokri'); ?>
                        </option>
                    </select>
                </div>
            </div>
            <!--Apply With Extra Field-->
            <div class="col-4" id="job_external_link_feild" <?php
                                                            if ($job_ext_url == "") {
                                                                echo 'style="display: none;"';
                                                            }
                                                            ?>>
                <div class="form-group">
                    <p>
                        <?php echo esc_html__('Put Link Here', 'nokri'); ?>
                    </p>
                    <input type="text" class="form-control" placeholder="<?php echo esc_html__('Put Link Here', 'redux-framework'); ?>" name="job_external_url" value="<?php echo esc_attr($job_ext_url); ?>" id="job_external_url" data-parsley-type="url">
                </div>
            </div>
            <!--Apply With Email-->
            <div class="col-4" id="job_external_mail_feild" <?php
                                                            if ($job_ext_mail == "") {
                                                                echo 'style="display: none;"';
                                                            }
                                                            ?>>
                <div class="form-group">
                    <p>
                        <?php echo esc_html__('Enter Email', 'redux-framework'); ?>
                    </p>
                    <input type="email" class="form-control" placeholder="<?php echo esc_html__('Enter valid email', 'redux-framework'); ?>" name="job_external_mail" value="<?php echo esc_attr($job_ext_mail); ?>" id="job_external_mail">
                </div>
            </div>

            <div class="col-4" id="job_external_whatsapp_feild" <?php
                                                                if ($job_ext_whatsapp == "") {
                                                                    echo 'style="display: none;"';
                                                                }
                                                                ?>>
                <div class="form-group">
                    <p>
                        <?php echo esc_html__('Whatsapp number', 'redux-framework'); ?>
                    </p>
                    <input type="number" class="form-control" placeholder="<?php echo esc_html__('Enter valid Whatsapp number', 'redux-framework'); ?>" name="job_external_whatsapp" value="<?php echo esc_attr($job_ext_whatsapp); ?>" id="job_external_whatsapp">
                </div>
            </div>
            <div class="col-4">
                <div class="form-group">
                    <p>
                        <?php echo esc_html__('Select address', 'redux-framework'); ?>
                    </p>
                    <?php //if($mapType=='google_map' ) {         
                    ?> <a href="javascript:void(0);" id="your_current_location" title="<?php echo esc_html__('You Current Location', 'nokri'); ?>"><i class="fa fa-crosshairs"></i></a>
                    <?php //}       
                    ?>
                    <input type="text" class="form-control" data-parsley-required="true" name="sb_user_address" id="sb_user_address" value="<?php echo esc_attr($ad_mapLocation); ?>" placeholder="<?php echo esc_html__('Enter map address', 'nokri'); ?>">

                </div>
            </div>

            <div class="col-12">
                <div class="form-group">
                    <div id="dvMap" style="width:100%; height: 300px"></div>
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <input class="form-control" name="ad_map_long" id="ad_map_long" value="<?php echo esc_attr($ad_map_long); ?>" type="text">
                </div>
            </div>

            <div class="col-4">
                <div class="form-group">
                    <input class="form-control" type="text" name="ad_map_lat" id="ad_map_lat" value="<?php echo esc_attr($ad_map_lat); ?>">
                </div>
            </div>
        </div>
    </div>
<?php
}

// Saving Metabox data 
add_action('save_post', 'nokri_job_post_feilds_saved');

function nokri_job_post_feilds_saved($post_id)
{
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;
    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce_product']) || !wp_verify_nonce($_POST['meta_box_nonce_product'], 'my_meta_box_nonce_ad'))
        return;
    // if our current user can't edit this post, bail
    if (!current_user_can('edit_posts'))
        return;
    // Make sure your data is set before trying to save it
    if (isset($_POST)) {
        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', 'nokri_job_post_feilds_saved');
        // update the post, which calls save_post again
        update_post_meta($post_id, '_job_posts', sanitize_text_field($_POST['job_posts']));
        update_post_meta($post_id, '_job_date', sanitize_text_field($_POST['job_date']));
        update_post_meta($post_id, '_job_apply_with', sanitize_text_field(($_POST['job_apply_with'])));
        update_post_meta($post_id, '_job_apply_with', sanitize_text_field(($_POST['job_apply_with'])));
        update_post_meta($post_id, '_job_apply_url', sanitize_text_field($_POST['job_external_url']));
        $categories = array();

        // Add selected categories to the array
        if (isset($_POST['job_cat']) && $_POST['job_cat'] != "0") {
            $categories[] = intval($_POST['job_cat']);
        }
        if (isset($_POST['job_cat_second']) && $_POST['job_cat_second'] != "0") {
            $categories[] = intval($_POST['job_cat_second']);
        }
        if (isset($_POST['job_cat_third']) && $_POST['job_cat_third'] != "0") {
            $categories[] = intval($_POST['job_cat_third']);
        }
        if (isset($_POST['job_cat_forth']) && $_POST['job_cat_forth'] != "0") {
            $categories[] = intval($_POST['job_cat_forth']);
        }

        // Set the post terms (categories)
        if (!empty($categories)) {
            wp_set_post_terms($post_id, $categories, 'job_category');
        }

        if (isset($_POST) && $_POST['job_apply_with'] == 'inter') {
            update_post_meta($post_id, '_job_apply_url', '');
        }
        if (isset($_POST) && $_POST['job_apply_with'] == 'mail') {
            update_post_meta($post_id, '_job_apply_mail', sanitize_text_field(($_POST['job_external_mail'])));
        }
        if (isset($_POST) && $_POST['job_apply_with'] == 'whatsapp') {
            update_post_meta($post_id, '_job_apply_whatsapp', sanitize_text_field(($_POST['job_external_whatsapp'])));
        }
        if (isset($_POST) && $_POST['sb_user_address'] != '') {
            update_post_meta($post_id, '_job_address', sanitize_text_field($_POST['sb_user_address']));
        }
        if (isset($_POST) && $_POST['ad_map_lat'] != '') {
            update_post_meta($post_id, '_job_lat', sanitize_text_field($_POST['ad_map_lat']));
        }
        if (isset($_POST) && $_POST['ad_map_long'] != '') {
            update_post_meta($post_id, '_job_long', sanitize_text_field($_POST['ad_map_long']));
        }

        update_post_meta($post_id, '_job_status', sanitize_text_field('active'));

        // re-hook this function
        add_action('save_post', 'nokri_job_post_feilds_saved');
    }
}

/* Job post static feilds */
/* Google map */

function nokri_loading_scripts_wrong()
{
    $map_type = $allow_cntry = '';
    $map_type = Redux::get_option('nokri', 'map-setings-map-type');
    $allow_cntry = Redux::get_option('nokri', 'sb_list_allowed_country');
    $stricts = '';
    if (isset($data['sb_location_allowed']) && !$data['sb_location_allowed'] && isset($data['sb_list_allowed_country'])) {
        $stricts = "componentRestrictions: {country: " . json_encode($allow_cntry) . "}";
    }


    echo " <script>

	   function nokri_location() {
      var input = document.getElementById('sb_user_address');
	  var action_on_complete	=	'1';
	  var options = { " . $stricts . "
 };
      var autocomplete = new google.maps.places.Autocomplete(input, options);
	  if( action_on_complete )
	  {
	   new google.maps.event.addListener(autocomplete, 'place_changed', function() {
	  // document.getElementById('sb_loading').style.display	= 'block';
    var place = autocomplete.getPlace();
	document.getElementById('ad_map_lat').value = place.geometry.location.lat();
	document.getElementById('ad_map_long').value = place.geometry.location.lng();
	var markers = [
        {
            'title': '',
            'lat': place.geometry.location.lat(),
            'lng': place.geometry.location.lng(),
        },
    ];
	my_g_map(markers);
	
	//document.getElementById('sb_loading').style.display	= 'none';
});
	   }

   }
   
   function my_g_map(markers1) {
	
	var my_map;
			var marker;
			var markers = [
				{
					'title': '',
					'lat': '37.090240',
					'lng': '-95.712891',
				},
			];
	
	var mapOptions = {
		center: new google.maps.LatLng(markers1[0].lat, markers1[0].lng),
		zoom: 15,
		mapTypeId: google.maps.MapTypeId.ROADMAP
	};
	var infoWindow = new google.maps.InfoWindow();
	var latlngbounds = new google.maps.LatLngBounds();
	var geocoder = geocoder = new google.maps.Geocoder();
	my_map = new google.maps.Map(document.getElementById('dvMap'), mapOptions);
	var map = new google.maps.Map(document.getElementById('dvMap'), mapOptions);
	var data = markers1[0]
	var myLatlng = new google.maps.LatLng(data.lat, data.lng);
	var marker = new google.maps.Marker({
		position: myLatlng,
		map: map,
		title: data.title,
		draggable: true,
		animation: google.maps.Animation.DROP
	});


	(function (marker, data) {

		google.maps.event.addListener(marker, 'click', function (e) {
			infoWindow.setContent(data.description);
			infoWindow.open(map, marker);
		});


		google.maps.event.addListener(marker, 'dragend', function (e) {
			jQuery('.cp-loader').show();
			//document.getElementById('sb_loading').style.display	= 'block';
			var lat, lng, address;
			geocoder.geocode({
				'latLng': marker.getPosition()
			}, function (results, status) {
				if (status == google.maps.GeocoderStatus.OK) {
					lat = marker.getPosition().lat();
					lng = marker.getPosition().lng();
					address = results[0].formatted_address;
					document.getElementById('ad_map_lat').value = lat;
					document.getElementById('ad_map_long').value = lng;
					document.getElementById('sb_user_address').value = address;
				}

			});
		});
	})(marker, data);
	latlngbounds.extend(marker.position);
	jQuery(document).ready(function($) {
			$('#your_current_location').click(function() {
				$.ajax({
				url: 'https://geoip-db.com/jsonp',
				jsonpCallback: 'callback',
				dataType: 'jsonp',
				success: function( location ) {
					var pos = new google.maps.LatLng(location.latitude, location.longitude);
					my_map.setCenter(pos);
					my_map.setZoom(12);
					
					$('#sb_user_address').val(location.city + ', ' + location.state + ', ' + location.country_name );
					document.getElementById('ad_map_long').value = location.longitude;
					document.getElementById('ad_map_lat').value = location.latitude;
					
				var markers2 = [
				{
					title: '',
					lat: location.latitude,
					lng: location.longitude,
				},
			];
			my_g_map(markers2);
				}
			});		
			});	
				});
}	
   </script>";

    /* Google map end */
    $map_type = Redux::get_option('nokri', 'map-setings-map-type');
?>
    <input type="hidden" name="check_map" id="check_map" value="<?php echo esc_attr($map_type); ?>" />
<?php
}

add_action('admin_print_scripts', 'nokri_loading_scripts_wrong', 0, 99);
add_action('admin_footer-edit.php', 'nokri_loading_scripts_wrong'); // Fired on the page with the posts table
add_action('admin_footer-post.php', 'nokri_loading_scripts_wrong'); // Fired on post edit page
add_action('admin_footer-post-new.php', 'nokri_loading_scripts_wrong'); // Fired on add new post page
/* Nokri new job post message starts */

function nokri_job_post_admin_notice()
{
    $screen = get_current_screen();
    //If not on the screen with ID 'edit-post' abort.
    if ($screen->id != 'job_post')
        return;
?>
    <div class="updated">
        <input type="hidden" value="2" name="edit_job_post" id="edit_job_post">
        <p>
            <?php echo esc_html__('Please check only one taxonomy except categories,location,job class and skills', 'redux-framework'); ?>
        </p>
    </div>

    <div class="error">
        <p>
            <?php echo esc_html__('More than one will not work', 'redux-framework'); ?>
        </p>
    </div>
<?php
}

add_action('admin_notices', 'nokri_job_post_admin_notice');
/* Nokri new job post message starts */

// Register metaboxes for questions
add_action('add_meta_boxes', 'nokri_question_meta_box');

function nokri_question_meta_box()
{
    add_meta_box('nokri_question_meta_box', __('Add Questionnaire', 'redux-framework'), 'nokri_question_render_meta_box', 'job_post', 'normal', 'high');
}

function nokri_question_render_meta_box($post)
{
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_ad', 'meta_box_nonce_product');
    /* Job Questions */
    $job_questions = $jobs_question = '';
    $job_questions = get_post_meta($post->ID, '_job_questions', true);
    $jobs_question = get_post_meta($post->ID, '_job_questions_en', true);
    $jobs_question_area = ($jobs_question == 'no') ? 'style="display:none;"' : '';
?>
    <div class="margin_top">
        <select class="js-example-basic-single" data-allow-clear="true" data-placeholder="<?php echo esc_html__('Select an option', 'nokri'); ?>" name="job_questions" id="job_questions">
            <option value="0">
                <?php echo esc_html__('Select Option', 'redux-framework'); ?>
            </option>
            <option value="yes" <?php
                                if ($jobs_question == "yes") {
                                    echo 'selected="selected"';
                                }
                                ?>>
                <?php echo esc_html__('Yes', 'nokri'); ?>
            </option>
            <option value="no" <?php
                                if ($jobs_question == "no") {
                                    echo 'selected="selected"';
                                }
                                ?>>
                <?php echo esc_html__('No', 'nokri'); ?>
            </option>
        </select>
    </div>

    <div class="margin_top custom-questions" <?php echo ($jobs_question_area); ?>>
        <div id="custom_feilds_wrapper">
            <div class="custom_feilds_repeats">
                <?php
                if (isset($job_questions) && !empty($job_questions)) {
                    foreach ($job_questions as $questions) {
                ?>
                        <p class="custom_feilds_labels">
                            <label for="custom_feilds_values">
                                <?php _e('Enter Question', 'redux-framework'); ?>
                            </label>
                            <br>
                            <textarea rows="2" cols="156" name="job_qstns[]"><?php echo esc_html($questions); ?></textarea>
                        </p>
                    <?php
                    }
                } else {
                    ?>
                    <p class="custom_feilds_labels">
                        <label for="custom_feilds_values">
                            <?php _e('Enter Question', 'redux-framework'); ?>
                        </label>
                        <br>
                        <textarea rows="2" cols="156" name="job_qstns[]"></textarea>
                    </p>
                <?php } ?>
            </div>
        </div>
        <p>
            <input type="button" class="btn-admin btn-add " onclick="add_row();" value="<?php echo esc_attr__('+ Add More', 'redux-framework'); ?>">
        </p>
    </div>
<?php
}

// Saving Metabox data 
add_action('save_post', 'nokri_question_save_meta_box');

function nokri_question_save_meta_box($post_id)
{
    // Bail if we're doing an auto save
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE)
        return;

    // if our nonce isn't there, or we can't verify it, bail
    if (!isset($_POST['meta_box_nonce_product']) || !wp_verify_nonce($_POST['meta_box_nonce_product'], 'my_meta_box_nonce_ad'))
        return;

    // if our current user can't edit this post, bail
    if (!current_user_can('edit_posts'))
        return;


    if (isset($_POST['job_questions']) && !empty($_POST['job_questions'])) {
        update_post_meta($post_id, '_job_questions_en', sanitize_text_field($_POST['job_questions']));
    }


    // Make sure your data is set before trying to save it
    if (isset($_POST['job_qstns'])) {
        $questions_sanatize = array();
        if (isset($_POST['job_qstns']) && !empty($_POST['job_qstns'])) {
            foreach ($_POST['job_qstns'] as $key) {
                $questions_sanatize[] = sanitize_text_field($key);
            }
        }
        update_post_meta($post_id, '_job_questions', ($questions_sanatize));
        // unhook this function so it doesn't loop infinitely
        remove_action('save_post', 'nokri_question_save_meta_box');
        // re-hook this function
        add_action('save_post', 'nokri_question_save_meta_box');
    }
}

include_once(ABSPATH . 'wp-admin/includes/plugin.php');
if (is_plugin_active('sitepress-multilingual-cms/sitepress.php')) {
    add_action('save_post', 'nokri_duplicate_on_publishh');

    function nokri_duplicate_on_publishh($post_id)
    {
        $post = get_post($post_id);
        if ($post->post_type == 'job_post') {
            // don't save for autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
                return $post_id;
            }
            // dont save for revisions
            if (isset($post->post_type) && $post->post_type == 'revision') {
                return $post_id;
            }
            // we need this to avoid recursion see add_action at the end
            remove_action('save_post', 'my_duplicate_on_publishh');
            // make duplicates if the post being saved
            // #1. itself is not a duplicate of another or
            // #2. does not already have translations
            $nokri_duplicate_post = false;
            if (class_exists('Redux')) {
                $nokri_duplicate_post = Redux::get_option('nokri', 'nokri_duplicate_jobs');
            }
            $is_translated = apply_filters('wpml_element_has_translations', '', $post_id, $post->post_type);
            if (!$is_translated && $nokri_duplicate_post) {
                do_action('wpml_admin_make_post_duplicates', $post_id);
            }
            // must hook again - see remove_action further up
            add_action('save_post', 'nokri_duplicate_on_publishh');
        }
    }
}

/* Job post static feilds */
/* Google map end */
/* Add Javascript/Jquery Code Here */

function nokri_this_screen()
{
    $current_screen = get_current_screen();
    if ($current_screen->id === "job_post") {
        add_action('admin_footer', 'nokri_admin_scripts_enqueue_custom_questions');
    }
}

add_action('current_screen', 'nokri_this_screen');

function nokri_admin_scripts_enqueue_custom_questions()
{
?>
    <script type="text/javascript">
        function add_row() {
            $rowno = jQuery("#custom_feilds_wrapper .custom_feilds_repeats").length;
            $rowno = $rowno + 1;
            jQuery("#custom_feilds_wrapper").append('<div class="custom_feilds_repeats" id="custom_repeat' + $rowno + '"><p class="custom_feilds_values"><label for="custom_feilds_values"><?php _e('Enter Question', 'redux-framework'); ?></label><br><textarea rows="2" cols="156" name="job_qstns[]" required></textarea></p><input type="button" class="btn-admin btn-remove" value="<?php _e('DELETE', 'redux-framework'); ?>" onclick=delete_row("custom_repeat' + $rowno + '")></div>');
        }

        function delete_row(rowno) {
            var conBox = confirm("<?php _e('Are You Sure ?', 'redux-framework'); ?>");
            if (conBox) {
                jQuery('#' + rowno).remove();
            } else
                return;
        }

        jQuery(document.body).on('change', '#job_questions', function(e) {
            var selectVal = jQuery(this).val();
            if (selectVal == 'yes') {
                jQuery('.custom-questions').show();
            } else {
                jQuery('.custom-questions').hide();
            }
        });
    </script>
<?php
}

//add indeed import sub menu page under job board
add_action('admin_menu', 'add_indeed_import_options');

function add_indeed_import_options()
{
    add_submenu_page(
        'edit.php?post_type=job_post',
        __('indeed jobs', 'redux-framework'),
        __('import indeed jobs', 'redux-framework'),
        'manage_options',
        'indeedimport',
        'import_indeed_jobs_fun'
    );
}

function import_indeed_jobs_fun()
{

    global $nokri;

    $publisher_id = isset($nokri['nokri_indeed_publisher_id']) ? $nokri['nokri_indeed_publisher_id'] : '';
    $default_jobs_num = isset($nokri['nokri_indeed_default_job_import']) ? $nokri['nokri_indeed_default_job_import'] : '';
?>
    <form id="indeed_import_form" method="post">
        <table class="form-table">
            <?php wp_nonce_field('indeed_import_nonce'); ?>
            <tr>
                <td scope="row">
                    <label for="pub_id"><?php echo esc_html__('Publisher ID*', 'Redux-framework') ?></label>
                </td>
                <td>
                    <input class="" name="pub_id" id="pub_id" value="<?php echo esc_html($publisher_id) ?>">
                    <p class="description"><?php echo nokri_make_link('https://www.indeed.com/publisher', esc_html__('How to Find it', 'nokri')); ?></p>
                </td>
            </tr>
            <tr>
                <td scope="row">
                    <label for="job_keyword"><?php echo esc_html__('Job keyword*', 'Redux-framework') ?></label>
                </td>
                <td>
                    <input class="" name="job_keyword" id="job_keyword" value="">
                    <p class="description"><?php echo esc_html__("Job title, keywords, or company", 'Redux-framework') ?></p>
                </td>
            </tr>
            <tr>
                <td scope="row">
                    <label for="job_country"><?php echo esc_html__('Country*', 'Redux-framework') ?></label>
                </td>
                <td>

                    <select name="job_country" id="job_country" value="">
                        <option value=""><?php echo esc_html__('Select country', 'Redux-framework'); ?></option>
                        <option value="ar"><?php echo esc_html('Argentina', 'Redux-framework'); ?></option>
                        <option value="au"><?php echo esc_html('Australia', 'Redux-framework'); ?></option>
                        <option value="at"><?php echo esc_html('Austria', 'Redux-framework'); ?></option>
                        <option value="bh"><?php echo esc_html('Bahrain', 'Redux-framework'); ?></option>
                        <option value="be"><?php echo esc_html('Belgium', 'Redux-framework'); ?></option>
                        <option value="br"><?php echo esc_html('Brazil', 'Redux-framework'); ?></option>
                        <option value="ca"><?php echo esc_html('Canada', 'Redux-framework'); ?></option>
                        <option value="cl"><?php echo esc_html('Chile', 'Redux-framework'); ?></option>
                        <option value="cn"><?php echo esc_html('China', 'Redux-framework'); ?></option>
                        <option value="co"><?php echo esc_html('Colombia', 'Redux-framework'); ?></option>
                        <option value="cz"><?php echo esc_html('Czech Republic', 'Redux-framework'); ?></option>
                        <option value="dk"><?php echo esc_html('Denmark', 'Redux-framework'); ?></option>
                        <option value="fi"><?php echo esc_html('Finland', 'Redux-framework'); ?></option>
                        <option value="fr"><?php echo esc_html('France', 'Redux-framework'); ?></option>
                        <option value="de"><?php echo esc_html('Germany', 'Redux-framework'); ?></option>
                        <option value="gr"><?php echo esc_html('Greece', 'Redux-framework'); ?></option>
                        <option value="hk"><?php echo esc_html('Hong Kong', 'Redux-framework'); ?></option>
                        <option value="hu"><?php echo esc_html('Hungary', 'Redux-framework'); ?></option>
                        <option value="in"><?php echo esc_html('India', 'Redux-framework'); ?></option>
                        <option value="id"><?php echo esc_html('Indonesia', 'Redux-framework'); ?></option>
                        <option value="ie"><?php echo esc_html('Ireland', 'Redux-framework'); ?></option>
                        <option value="is"><?php echo esc_html('Israel', 'Redux-framework'); ?></option>
                        <option value="it"><?php echo esc_html('Italy', 'Redux-framework'); ?></option>
                        <option value="jp"><?php echo esc_html('Japan', 'Redux-framework'); ?></option>
                        <option value="kr"><?php echo esc_html('Korea', 'Redux-framework'); ?></option>
                        <option value="ku"><?php echo esc_html('Kuwait', 'Redux-framework'); ?></option>
                        <option value="lu"><?php echo esc_html('Luxembourg', 'Redux-framework'); ?></option>
                        <option value="my"><?php echo esc_html('Malaysia', 'Redux-framework'); ?></option>
                        <option value="mx"><?php echo esc_html('Mexico', 'Redux-framework'); ?></option>
                        <option value="nl"><?php echo esc_html('Netherlands', 'Redux-framework'); ?></option>
                        <option value="nz"><?php echo esc_html('New Zealand', 'Redux-framework'); ?></option>
                        <option value="no"><?php echo esc_html('Norway', 'Redux-framework'); ?></option>
                        <option value="om"><?php echo esc_html('Oman', 'Redux-framework'); ?></option>
                        <option value="pk"><?php echo esc_html('Pakistan', 'Redux-framework'); ?></option>
                        <option value="pe"><?php echo esc_html('Peru', 'Redux-framework'); ?></option>
                        <option value="ph"><?php echo esc_html('Philippines', 'Redux-framework'); ?></option>
                        <option value="pl"><?php echo esc_html('Poland', 'Redux-framework'); ?></option>
                        <option value="pt"><?php echo esc_html('Portugal', 'Redux-framework'); ?></option>
                        <option value="qt"><?php echo esc_html('Qatar', 'Redux-framework'); ?></option>
                        <option value="ro"><?php echo esc_html('Romania', 'Redux-framework'); ?></option>
                        <option value="ru"><?php echo esc_html('Russia', 'Redux-framework'); ?></option>
                        <option value="sa"><?php echo esc_html('Saudi Arabia', 'Redux-framework'); ?></option>
                        <option value="sg"><?php echo esc_html('Singapore', 'Redux-framework'); ?></option>
                        <option value="za"><?php echo esc_html('South Africa', 'Redux-framework'); ?></option>
                        <option value="es"><?php echo esc_html('Spain', 'Redux-framework'); ?></option>
                        <option value="se"><?php echo esc_html('Sweden', 'Redux-framework'); ?></option>
                        <option value="ch"><?php echo esc_html('Switzerland', 'Redux-framework'); ?></option>
                        <option value="tw"><?php echo esc_html('Taiwan', 'Redux-framework'); ?></option>
                        <option value="th"><?php echo esc_html('Thailand', 'Redux-framework'); ?></option>
                        <option value="tr"><?php echo esc_html('Turkey', 'Redux-framework'); ?></option>
                        <option value="ae"><?php echo esc_html('United Arab Emirates', 'Redux-framework'); ?></option>
                        <option value="gb"><?php echo esc_html('United Kingdom', 'Redux-framework'); ?></option>
                        <option value="us"><?php echo esc_html('United States', 'Redux-framework'); ?></option>
                        <option value="ve"><?php echo esc_html('Venezuela', 'Redux-framework'); ?></option>
                        <option value="vn"><?php echo esc_html('Vietnam', 'Redux-framework'); ?></option>
                    </select>
                    <p class="description"><?php echo esc_html__("Select  country to find jobs from specific country", 'Redux-framework') ?></p>

                </td>
            </tr>
            <tr>
                <td scope="row">
                    <label for="job_location"><?php echo esc_html__('Location', 'Redux-framework') ?></label>
                </td>
                <td>
                    <input class="" name="job_location" id="job_location" value="">
                    <p class="description"><?php echo esc_html__("city, province, or region", 'Redux-framework') ?></p>
                </td>
            </tr>
            <tr>
                <td scope="row">
                    <label for="job_type"><?php echo esc_html__('Job type', 'Redux-framework') ?></label>
                </td>
                <td>
                    <select name="job_type" id="job_type">
                        <option value=""><?php echo esc_html__('Select Job type', 'redux-framework') ?> </option>
                        <option value="fulltime"><?php echo esc_html__('Full time', 'redux-framework') ?> </option>
                        <option value="parttime"><?php echo esc_html__('Part time', 'redux-framework') ?> </option>
                        <option value="contract"><?php echo esc_html__('contract', 'redux-framework') ?> </option>
                        <option value="internship"><?php echo esc_html__('Internship', 'redux-framework') ?> </option>
                        <option value="temporary"><?php echo esc_html__('Temporary', 'redux-framework') ?> </option>
                    </select>
                </td>
            </tr>
            <tr>
                <td scope="row">
                    <label for="sort_by"><?php echo esc_html__('Sort by', 'Redux-framework') ?></label>
                </td>
                <td>
                    <select id="sort_by" name="sort_by">
                        <option value=""><?php echo esc_html__('Sort by', 'redux-framework') ?></option>
                        <option value="date"><?php echo esc_html__('Date', 'redux-framework') ?></option>
                        <option value="relevance "><?php echo esc_html__('Relevance ', 'redux-framework') ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <td scope="row">
                    <label for="jobs_num"><?php echo esc_html__('Jobs to import', 'Redux-framework') ?></label>
                </td>
                <td>
                    <input class="" name="jobs_num" id="jobs_num" value="" type="number" max="25">
                    <input type="hidden" class="" name="jobs_num_default" id="jobs_num_default" value="<?php echo esc_attr($default_jobs_num) ?>">
                    <p class="description"><?php echo esc_html__('Default 10 ,you can enter maximum  25', 'redux-framework') ?></p>
                </td>
            </tr>
            <tr>
                <td scope="row">
                    <label for="job_date"><?php echo esc_html__('Expired on', 'Redux-framework') ?></label>
                </td>
                <td>
                    <input type="text" class="form-control datepickerhere" data-language="en" name="job_date" placeholder="<?php echo esc_html__('Application deadline*', 'nokri'); ?>" autocomplete="off">
                    <p class="description"><?php echo esc_html__('Add job expiry date', 'redux-framework') ?></p>
                </td>
            </tr>

            <tr>
                <td>
                    <button type="submit" class="button button-primary button-large" id="import_job_submit"> <?php echo esc_html__('Import indeed jobs') ?></button>

                </td>
            </tr>

        </table>
    </form>
    <?php
}

add_action('restrict_manage_posts', 'anvoy_token_status_date_filter_form');

function anvoy_token_status_date_filter_form()
{
    global $typenow;
    global $wp_query;
    $start_date = "";
    $end_date = "";

    $start_date = isset($_GET['job_start_date']) ? $_GET['job_start_date'] : "";
    $end_date = isset($_GET['job_end_date']) ? $_GET['job_end_date'] : "";

    if ($typenow == 'job_post') {
    ?>
        <input type="text" name="job_start_date" id="job_start_date" class="jobs_dp" value="<?php echo esc_html($start_date); ?>" autocomplete="off" placeholder="<?php echo esc_html__('Start date', 'redux-framework') ?>">
        <input type="text" name="job_end_date" id="job_end_date" class="jobs_dp" value="<?php echo esc_html($end_date); ?>" autocomplete="off" placeholder="<?php echo esc_html__('End date', 'redux-framework') ?>">
        <input type="submit" name="export-all" id="export-all" class="button button-primary" value="<?php echo esc_html__('Export Record', 'redux-framework'); ?>">
        <script type="text/javascript">
            jQuery(function($) {
                $('#export-all').insertAfter('#post-query-submit');
            });
        </script>
    <?php
    }
}

add_action('init', 'nokri_export_jobs_record');

function nokri_export_jobs_record()
{
    $post_type = isset($_GET['post_type']) ? $_GET['post_type'] : '';
    if ($post_type == 'job_post') {
        if (isset($_GET['export-all'])) {
            $rnd_nme = '';
            $rnd_nme = rand(1, 99);
            $start_date = isset($_GET['job_start_date']) ? $_GET['job_start_date'] : "";
            $end_date = isset($_GET['job_end_date']) ? $_GET['job_end_date'] : "";
            if ($start_date != "" && $end_date != "") {
                header('Content-type: text/csv');
                header('Content-Disposition: attachment; filename="report"' . $rnd_nme . '".csv"');
                header('Pragma: no-cache');
                header('Expires: 0');
                $file = fopen('php://output', 'w');
                fputcsv($file, array('Title', 'Descripotion', 'expiry', 'author'));
                $args = array(
                    'post_type' => 'job_post',
                    'date_query' => array(
                        array(
                            'after' => $start_date,
                            'before' => $end_date,
                            'inclusive' => true,
                        ),
                    ),
                );
                $query = new WP_Query($args);
                $results = $query->found_posts;
                $arr = array();
                if ($query->have_posts()) {
                    // Start looping over the query results.
                    while ($query->have_posts()) {
                        $query->the_post();
                        $id = get_the_ID();
                        $tile = get_the_title();
                        $desc = get_the_excerpt();
                        $expiry = get_post_meta($id, '_job_date', true);
                        fputcsv($file, array($tile, $desc, $expiry));
                    }
                }
                // Restore original post data.
                wp_reset_postdata();
            }
            exit();
        }
    }
}

function nokri_cron_for_job_publish($new_status, $old_status, $post)
{
    global $nokri;

    $is_paid = isset($nokri['job_alert_paid_switch']) ? $nokri['job_alert_paid_switch'] : false;
    if ($post->post_type == "job_post" && $is_paid && $new_status == "publish" && $old_status != "publish") {

        $job_id = $post->ID;
        wp_schedule_single_event(time() + 60, 'paid_alert_mail_process', array($job_id));
    }
}

add_action('transition_post_status', 'nokri_cron_for_job_publish', 10, 3);

add_action('paid_alert_mail_process', 'paid_alert_mail_process_fun');

function paid_alert_mail_process_fun($job_id)
{
    $args = array(
        'order' => 'DESC',
        'meta_query' => array(
            'relation' => 'AND',
            array(
                'key' => '_sb_reg_type',
                'value' => '0',
                'compare' => '='
            ),
            array(
                'key' => '_cand_alerts_en',
                'value' => '',
                'compare' => '!='
            ),
        ),
    );


    $user_query = new WP_User_Query($args);
    $candidates = $user_query->get_results();


    if (!empty($candidates)) {
        foreach ($candidates as $candidate) {

            $user_id = $candidate->ID;
            $job_alert = nokri_get_candidates_job_alerts($user_id, $job_id);
            if (isset($job_alert) && !empty($job_alert)) {
                foreach ($job_alert as $key => $val) {
                    $verified = nokri_verify_alerts_subs($user_id, $job_id);

                    $alert_name = $val['alert_name'];
                    $alert_category = $val['alert_category'];
                    $alert_email = $val['alert_email'];
                    $alert_freq = 1;
                    $alert_start = $val['alert_start'];
                    $today = date('Y/m/d');
                    $date_to_sent = $today;
                    $current_date = strtotime(date('Y/m/d'));
                    $end_date = strtotime($val['alert_end']);
                    if ($verified && $end_date > $current_date) {
                        $my_alert = json_encode($val);
                        nokri_email_job_alerts($job_id, $alert_email);
                        if (function_exists('nokri_job_alert_notification')) {
                            $test = nokri_job_alert_notification("androaid", $job_id, $user_id);
                        }
                        update_user_meta($user_id, $key, ($my_alert));
                    }
                }
            }
        }
    }
}

if (!function_exists('nokri_verify_alerts_subs')) {

    function nokri_verify_alerts_subs($user_id, $job_id)
    {
        $valid = true;
        $current_id = $user_id;
        /* Getting cand informations */
        $cand_category = nokri_get_alerts_category_subscription($current_id, 'alert_category');
        $cand_location = nokri_get_alerts_category_subscription($current_id, 'alert_location');
        /* Getting Job informations */
        $job_category = wp_get_post_terms($job_id, 'job_category', array("fields" => "ids"));
        $job_location = wp_get_post_terms($job_id, 'ad_location', array("fields" => "ids"));
        /* Validating taxonmies */
        if (!empty($cand_category)) {
            $valid = nokri_validating_alert_taxonomy($cand_category, $job_category);
        }
        if (!empty($cand_location[0])) {
            $valid = nokri_validating_alert_taxonomy($cand_location, $job_location);
        }
        wp_reset_postdata();
        $notification = false;
        if ($valid) {
            $notification = true;
        }
        return $notification;
    }
}
add_action('quick_edit_custom_box', 'quick_edit_add', 10, 2);
add_action('bulk_edit_custom_box', 'quick_edit_add', 10, 2);

/**
 * Add Headline news checkbox to quick edit screen
 *
 * @param string $column_name Custom column name, used to check
 * @param string $post_type
 *
 * @return void
 */
function quick_edit_add($column_name, $post_type)
{
    if ('job_date' != $column_name) {
        return;
    }
    printf('<input type="text" name="job_date" class="" placeholder="mm/dd/yyyy"> %s', 'Job expiry');
}

add_action('save_post', 'save_quick_edit_data');

function save_quick_edit_data($post_id)
{
    if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) {
        return $post_id;
    }
    if (!current_user_can('edit_post', $post_id)) {
        return $post_id;
    }
    if (isset($_POST['job_date']) && $_POST['job_date'] != "") {
        update_post_meta($post_id, '_job_date', $_POST['job_date']);
    }
}

//saving job expiry for bulk editor
add_action('wp_ajax_bulk_edit_job_expiry', 'bulk_edit_job_expiry');

function bulk_edit_job_expiry()
{
    if (empty($_POST['post_ids'])) {
        die();
    }
    foreach ($_POST['post_ids'] as $id) {
        if (!empty($_POST['job_exp'])) {
            update_post_meta($id, '_job_date', $_POST['job_exp']);
        }
    }
    die();
}

add_action('edit_form_after_title', 'add_resume_downlaod_button');

function add_resume_downlaod_button($post)
{

    if (did_action('enqueue_block_editor_assets')) {
        return;
    }
    if ($post->post_type != "job_post") {

        return;
    }
    echo '<button class="button button-primary button-large download_admin_resumes c-margin" data-job-id="' . $post->ID . '"  style="margin:15px">' . esc_html("Download resumes", "redux-framework") . '</button>';
}

// Register metaboxes for Products
add_action('add_meta_boxes', 'sb_nokri_cands_meta_box');

function sb_nokri_cands_meta_box()
{
    add_meta_box('sb_thmemes_adforest_metaboxes_for_ad', __('Job Applicants List', 'redux-framework'), 'sb_nokri_cands_applications', 'job_post', 'normal', 'high');
}

function sb_nokri_cands_applications($post)
{

    $job_id = $post->ID;
    // We'll use this nonce field later on when saving.
    wp_nonce_field('my_meta_box_nonce_ad', 'meta_box_nonce_product');
    $author_name = get_the_author_meta('display_name', $post->post_author);
    /* cand resume */
    $applier = array();
    $status_wise = false;
    global $wpdb;
    $extra = " AND meta_key like '_job_applied_resume_%'";
    $query = "SELECT * FROM $wpdb->postmeta WHERE post_id = '$job_id' $extra";
    $applier_resumes = $wpdb->get_results($query);
    /* Check Is Resume Exist */
    if (count($applier_resumes) != 0) {
        if (count($applier_resumes) > 0) {
            foreach ($applier_resumes as $resumes) {
                if ($status_wise) {
                    $array_data = explode('_', $resumes->meta_key);
                    $applier[] = $array_data[4];
                } else {
                    $array_data = explode('|', $resumes->meta_value);
                    $applier[] = $array_data[0];
                }
            }
        }
        if ($status_wise && count($applier) == 0) {
            $applier[] = '@#/!';
        }
    }
    ?>
    <div class="margin_top nokri-custom-postbox">
        <?php
        
        // Custom Post Type  Candidate Requeste
        function create_candidate_request_post_type() {
        
            // Custom Post Type Labels
            $labels = array(
                'name'                  => _x( 'Candidate Requests', 'Post Type General Name', 'nokri' ),
                'singular_name'         => _x( 'Candidate Request', 'Post Type Singular Name', 'nokri' ),
                'menu_name'             => __( 'Candidate Requests', 'nokri' ),
                'name_admin_bar'        => __( 'Candidate Request', 'nokri' ),
                'archives'              => __( 'Item Archives', 'nokri' ),
                'attributes'            => __( 'Item Attributes', 'nokri' ),
                'parent_item_colon'     => __( 'Parent Item:', 'nokri' ),
                'all_items'             => __( 'All Items', 'nokri' ),
                'add_new_item'          => __( 'Add New Item', 'nokri' ),
                'add_new'               => __( 'Add New', 'nokri' ),
                'new_item'              => __( 'New Item', 'nokri' ),
                'edit_item'             => __( 'Edit Item', 'nokri' ),
                'update_item'           => __( 'Update Item', 'nokri' ),
                'view_item'             => __( 'View Item', 'nokri' ),
                'view_items'            => __( 'View Items', 'nokri' ),
                'search_items'          => __( 'Search Item', 'nokri' ),
                'not_found'             => __( 'Not found', 'nokri' ),
                'not_found_in_trash'    => __( 'Not found in Trash', 'nokri' ),
                'featured_image'        => __( 'Featured Image', 'nokri' ),
                'set_featured_image'    => __( 'Set featured image', 'nokri' ),
                'remove_featured_image' => __( 'Remove featured image', 'nokri' ),
                'use_featured_image'    => __( 'Use as featured image', 'nokri' ),
                'insert_into_item'      => __( 'Insert into item', 'nokri' ),
                'uploaded_to_this_item' => __( 'Uploaded to this item', 'nokri' ),
                'items_list'            => __( 'Items list', 'nokri' ),
                'items_list_navigation' => __( 'Items list navigation', 'nokri' ),
                'filter_items_list'     => __( 'Filter items list', 'nokri' ),
            );
            
            // Custom Post Type Args
            $args = array(
                'label'                 => __( 'Candidate Request', 'nokri' ),
                'description'           => __( 'Candidate Request Description', 'nokri' ),
                'labels'                => $labels,
                'supports'              => array( 'title', 'editor', 'thumbnail', 'custom-fields' ),
                'hierarchical'          => false,
                'public'                => true,
                'show_ui'               => true,
                'show_in_menu'          => true,
                'menu_position'         => 5,
                'show_in_admin_bar'     => true,
                'show_in_nav_menus'     => true,
                'can_export'            => true,
                'has_archive'           => true,
                'exclude_from_search'   => false,
                'publicly_queryable'    => true,
                'capability_type'       => 'post',
                'show_in_rest'          => true,
            );
            
            // Register Custom Post Type
            register_post_type( 'candidate_request', $args );
        }
        add_action( 'init', 'create_candidate_request_post_type', 0 );
        
        function create_candidate_request_taxonomy() {
            // Custom Taxonomy Labels
            $labels = array(
                'name'              => _x( 'Request Categories', 'taxonomy general name', 'nokri' ),
                'singular_name'     => _x( 'Request Category', 'taxonomy singular name', 'nokri' ),
                'search_items'      => __( 'Search Request Categories', 'nokri' ),
                'all_items'         => __( 'All Request Categories', 'nokri' ),
                'parent_item'       => __( 'Parent Request Category', 'nokri' ),
                'parent_item_colon' => __( 'Parent Request Category:', 'nokri' ),
                'edit_item'         => __( 'Edit Request Category', 'nokri' ),
                'update_item'       => __( 'Update Request Category', 'nokri' ),
                'add_new_item'      => __( 'Add New Request Category', 'nokri' ),
                'new_item_name'     => __( 'New Request Category Name', 'nokri' ),
                'menu_name'         => __( 'Request Category', 'nokri' ),
            );
            
            // Custom Taxonomy Args
            $args = array(
                'hierarchical'      => true,  // Set to true for categories, false for tags
                'labels'            => $labels,
                'show_ui'           => true,
                'show_admin_column' => true,
                'query_var'         => true,
                'rewrite'           => array( 'slug' => 'request-category' ),
            );
            
            // Register Custom Taxonomy
            register_taxonomy( 'request_category', array( 'candidate_request' ), $args );
        }
        add_action( 'init', 'create_candidate_request_taxonomy', 0 );
        
        // CPT
        // Create Meta Boxes
        
        function add_custom_meta_box() {
            add_meta_box(
                'candidate_request_meta',
                __( 'Candidate Request Details', 'nokri' ),
                'candidate_request_meta_callback',
                'candidate_request',
                'normal',
                'high'
            );
        }
        add_action( 'add_meta_boxes', 'add_custom_meta_box' );
        function get_project_duration_options() {
            $options = [
                'select_project_duration' => 'Select Project Duration',
                '1_week' => '1 Week',
                '2_weeks' => '2 Weeks',
                '1_month' => '1 Month',
                '3_months' => '3 Months',
                '6_months' => '6 Months',
                '1_year' => '1 Year',
            ];
        
            return $options;
        }
        
        function get_min_hours_options() {
            $options = [
                'select_min_hours' => 'Select Min Hours',
                '1_hour' => '1 Hour',
                '2_hours' => '2 Hours',
                '4_hours' => '4 Hours',
                '8_hours' => '8 Hours',
            ];
        
            return $options;
        }
        function get_payment_basic_options() {
            $options = [
                'select_payment_basic' => 'Select Payment Basic',
                'hourly' => 'Hourly',
                'daily' => 'Daily',
                'weekly' => 'Weekly',
                'monthly' => 'Monthly',
            ];
        
            return $options;
        }
        function get_compensation_type_options() {
            $options = [
                '0' => 'Select Compensation Type',
                '1' => 'PKR',
                '2' => 'US Dollars',
                '3' => 'GBP',
                '4' => 'Euros',
                '5' => 'SAP',
                '6' => 'Pound',
                '7' => 'Yen',
            ];
        
            return $options;
        }
        function get_project_type_options() {
            $options = [
                '0' => 'Select Project Type',
                '1' => 'Onsite',
                '2' => 'Work from home',
                '3' => 'Hybrid',
            ];
        
            return $options;
        }
        // Define the skills options
        function get_skills_options() {
            $options = [
                'select_skills' => 'Select Skills',
                'php' => 'PHP',
                'seo' => 'SEO',
                'marketing' => 'Marketing',
                'javascript' => 'JavaScript',
                'css' => 'CSS',
                'html' => 'HTML',
                // Add more skills as needed
            ];
        
            return $options;
        }
        
        function get_status_options() {
            $options = [
                'select_status' => 'Select Status',
                'pending' => 'Pending',
                'completed' => 'Completed',
                'rejected' => 'Rejected',
                
                // Add more skills as needed
            ];
        
            return $options;
        }
        
        // Add similar functions for other select fields
        
        function candidate_request_meta_callback( $post ) {
            // Retrieve existing values from the database
            $project_name = get_post_meta( $post->ID, '_project_name', true );
            $project_description = get_post_meta( $post->ID, '_project_description', true );
            $job_skills = get_post_meta( $post->ID, '_job_skills', true );
            $project_duration = get_post_meta( $post->ID, '_project_duration', true );
            $min_hours = get_post_meta( $post->ID, '_min_hours', true );
            $payment_basis = get_post_meta( $post->ID, '_payment_basis', true );
            $compensation_type = get_post_meta( $post->ID, '_compensation_type', true );
            $compensation = get_post_meta( $post->ID, '_compensation', true );
            $compensation_details = get_post_meta( $post->ID, '_compensation_details', true );
            $project_type = get_post_meta( $post->ID, '_project_type', true );
            $job_file = get_post_meta( $post->ID, '_job_file', true );
            $email = get_post_meta( $post->ID, '_email', true );
            $phone = get_post_meta( $post->ID, '_phone', true );
            $status = get_post_meta($post->ID, '_job_status', true);
            // Get dynamic options
            $skills_options=get_skills_options();
            $project_duration_options = get_project_duration_options();
            $min_hours_options = get_min_hours_options();
            $payment_basis_options = get_payment_basic_options();
            $compensation_type_options = get_compensation_type_options();
            $project_type_options = get_project_type_options();
            $status_options = get_status_options();
            ?>
            
            <form id="jobPostingForm" enctype="multipart/form-data">
                <!-- Project Name -->
            <div class="form-field">
                <label for="project_name"><?php esc_html_e( 'Project Name', 'nokri' ); ?></label>
                <input type="text" name="project_name" id="project_name" value="<?php echo esc_attr( $project_name ); ?>" class="widefat" />
            </div>
             <!-- Project Description -->
            <div class="form-field">
                <label for="project_description"><?php esc_html_e( 'Project Description', 'nokri' ); ?></label>
                <textarea name="project_description" id="project_description" rows="5" class="widefat"><?php echo esc_textarea( $project_description ); ?></textarea>
            </div>
            <!-- Job Skills -->
            <div class="form-field">
                <label for="skills"><?php esc_html_e( 'Skills', 'nokri' ); ?></label>
                <select name="skills" id="skills" class="widefat">
                    <?php foreach ( $skills_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $job_skills, $key ); ?>>
                            <?php echo esc_html( $value ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Project Duration -->
            <div class="form-field">
                <label for="project_duration"><?php esc_html_e( 'Project Duration', 'nokri' ); ?></label>
                <select name="project_duration" id="project_duration" class="widefat">
                    <?php foreach ( $project_duration_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $project_duration, $key ); ?>>
                            <?php echo esc_html( $value ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Minimum Hours Per Day -->
            <div class="form-field">
                <label for="min_hours"><?php esc_html_e( 'Minimum Hours Per Day', 'nokri' ); ?></label>
                <select name="min_hours" id="min_hours" class="widefat">
                    <?php foreach ( $min_hours_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $min_hours, $key ); ?>>
                            <?php echo esc_html( $value ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Payment Basis -->
            <div class="form-field">
                <label for="payment_basis"><?php esc_html_e( 'Payment Basis', 'nokri' ); ?></label>
                <select name="payment_basis" id="payment_basis" class="widefat">
                    <?php foreach ( $payment_basis_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $payment_basis, $key ); ?>>
                            <?php echo esc_html( $value ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
           <!-- Compensation Type Field -->
           <div class="form-field">
                <label for="compensation_type"><?php esc_html_e( 'Compensation Type', 'nokri' ); ?></label>
                <select name="compensation_type" id="compensation_type" class="widefat">
                    <?php foreach ( $compensation_type_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $compensation_type, $key ); ?>>
                            <?php echo esc_html( $value ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
        
            <!-- Compensation -->
            <div class="form-field">
                <label for="compensation"><?php esc_html_e( 'Compensation', 'nokri' ); ?></label>
                <input type="text" name="compensation" id="compensation" value="<?php echo esc_attr( $compensation ); ?>" class="widefat" />
            </div>
            <!-- Compensation Details -->
            <div class="form-field">
                <label for="compensation_details"><?php esc_html_e( 'Compensation Details', 'nokri' ); ?></label>
                <input type="text" name="compensation_details" id="compensation_details" value="<?php echo esc_attr( $compensation_details); ?>" class="widefat" />
            </div>
            <!-- Project Type Field -->
            <div class="form-field">
                <label for="project_type"><?php esc_html_e( 'Project Type', 'nokri' ); ?></label>
                <select name="project_type" id="project_type" class="widefat">
                    <?php foreach ( $project_type_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $project_type, $key ); ?>>
                            <?php echo esc_html( $value ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            <!-- Job File Upload -->
            <div class="form-field">
                <label for="jobFile"><?php esc_html_e( 'Job File URL', 'nokri' ); ?></label>
                <input type="file" class="form-control" id="job_file" name="job_file" accept=".pdf,.doc,.docx,.txt" value="<?php echo esc_attr( $job_file ); ?>" class="widefat" >
            </div>
            
            <!-- Email -->
            <div class="form-field">
                <label for="email"><?php esc_html_e( 'Email', 'nokri' ); ?></label>
                <input type="text" name="email" id="add_email" value="<?php echo esc_attr( $email ); ?>" class="widefat" />
            </div>
        
            <!-- Phone No. -->
           
            <div class="form-field">
                <label for="phone"><?php esc_html_e( 'Phone', 'nokri' ); ?></label>
                <input type="text" name="phone" id="phone" value="<?php echo esc_attr( $phone ); ?>" class="widefat" />
            </div>
             <!-- Status -->
             <div class="form-field">
                <label for="status"><?php esc_html_e( 'Status', 'nokri' ); ?></label>
                <select name="status" id="status" class="widefat">
                    <?php foreach ( $status_options as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>" <?php selected( $status, $key ); ?>>
                            <?php echo esc_html( $value ); ?>
                        </option>
                    <?php endforeach; ?>
                </select>
            </div>
            
        </form>
        <?php
            
        }
        function save_custom_meta_data($post_id) {
            // Check autosave
            if (defined('DOING_AUTOSAVE') && DOING_AUTOSAVE) return;
        
            // Check permissions
            if (!current_user_can('edit_post', $post_id)) return;
        
            // Save Project Name
            if (isset($_POST['project_name'])) {
                update_post_meta($post_id, '_project_name', sanitize_text_field($_POST['project_name']));
            }
        
            // Save Project Description
            if (isset($_POST['project_description'])) {
                update_post_meta($post_id, '_project_description', sanitize_textarea_field($_POST['project_description']));
            }
        
            // Save Job Skills
            if (isset($_POST['job_skills']) && is_array($_POST['job_skills'])) {
                $job_skills = array_map('sanitize_text_field', $_POST['job_skills']);
                update_post_meta($post_id, '_job_skills', $job_skills);
            }
            
           
            // Save Project Duration
            if (isset($_POST['project_duration'])) {
                update_post_meta($post_id, '_project_duration', sanitize_text_field($_POST['project_duration']));
            }
        
            // Save Minimum Hours
            if (isset($_POST['min_hours'])) {
                update_post_meta($post_id, '_min_hours', sanitize_text_field($_POST['min_hours']));
            }
        
            // Save Payment Basis
            if (isset($_POST['payment_basis'])) {
                update_post_meta($post_id, '_payment_basis', sanitize_text_field($_POST['payment_basis']));
            }
        
            // Save Compensation Type
            if (isset($_POST['compensation_type'])) {
                update_post_meta($post_id, '_compensation_type', sanitize_text_field($_POST['compensation_type']));
            }
        
            // Save Compensation
            if (isset($_POST['compensation'])) {
                update_post_meta($post_id, '_compensation', sanitize_text_field($_POST['compensation']));
            }
        
            // Save Compensation Details
            if (isset($_POST['compensation_details'])) {
                update_post_meta($post_id, '_compensation_details', sanitize_text_field($_POST['compensation_details']));
            }
        
            // Save Project Type
            if (isset($_POST['project_type'])) {
                update_post_meta($post_id, '_project_type', sanitize_text_field($_POST['project_type']));
            }
        
            // Save Job File
            if (isset($_FILES['job_file']) && !empty($_FILES['job_file']['name'])) {
                $uploaded_file = wp_handle_upload($_FILES['job_file'], array('test_form' => false));
                if (!isset($uploaded_file['error'])) {
                    update_post_meta($post_id, '_job_file', esc_url($uploaded_file['url']));
                }
            }
        
            // Save Email
            if (isset($_POST['email'])) {
                update_post_meta($post_id, '_email', sanitize_email($_POST['email']));
            }
        
            // Save Phone
            if (isset($_POST['phone'])) {
                update_post_meta($post_id, '_phone', sanitize_text_field($_POST['phone']));
            }
            // Save Status
            if (isset($_POST['status'])) {
                update_post_meta($post_id, '_job_status', sanitize_text_field($_POST['status']));
            }
        }
        
        add_action( 'save_post', 'save_custom_meta_data' );
        //  Handle Ajax request
        function handle_candidate_request_submission() {
            if ( !isset( $_POST['nonce'] ) || !wp_verify_nonce( $_POST['nonce'], 'nokri_candidate_request' ) ) {
                wp_send_json_error(array('message' => 'Invalid nonce.'));
                wp_die();
            }
            global $nokri;
            $project_name = sanitize_text_field($_POST['project_name']);
            $project_description = sanitize_textarea_field($_POST['project_description']);
            $job_skills = sanitize_text_field($_POST['job_skills']);
            $project_duration = sanitize_text_field($_POST['project_duration']);
            $min_hours = sanitize_text_field($_POST['min_hours']);
            $payment_basis = sanitize_text_field($_POST['payment_basis']);
            $compensation_type = sanitize_text_field($_POST['compensation_type']);
            $compensation = sanitize_text_field($_POST['compensation']);
            $compensation_details = sanitize_text_field($_POST['compensation_details']);
            $project_type = sanitize_text_field($_POST['project_type']);
            $email = sanitize_email($_POST['email']);
            $phone = sanitize_text_field($_POST['phone']);
        
            $job_file_url = '';
        
              // Handle file upload
            if ( !empty($_FILES['job_file']['name']) ) {
                $upload = wp_handle_upload($_FILES['job_file'], array('test_form' => false));
                if ($upload && !isset($upload['error'])) {
                    $job_file_url = esc_url_raw($upload['url']);
                } else {
                    wp_send_json_error(array('message' => 'File upload error: ' . $upload['error']));
                }
            }
            // Create new post of type 'candidate_request'
            $post_id = wp_insert_post(array(
                'post_type' => 'candidate_request',
                'post_status' => 'publish',
                'post_title' => $project_name,
                'post_content' => $project_description,
            ));
        
            if ($post_id) {
                // Save meta fields
                update_post_meta($post_id, '_project_name', $project_name);
                update_post_meta($post_id, '_project_description', $project_description);
                update_post_meta($post_id, '_job_skills', $job_skills);
                update_post_meta($post_id, '_project_duration', $project_duration);
                update_post_meta($post_id, '_min_hours', $min_hours);
                update_post_meta($post_id, '_payment_basis', $payment_basis);
                update_post_meta($post_id, '_compensation_type', $compensation_type);
                update_post_meta($post_id, '_compensation', $compensation);
                update_post_meta($post_id, '_compensation_details', $compensation_details);
                update_post_meta($post_id, '_project_type', $project_type);
                if (!empty($job_file_url)) {
                    update_post_meta($post_id, '_job_file', $job_file_url);
                }
                update_post_meta($post_id, '_email', $email);
                update_post_meta($post_id, '_phone', $phone);
        
                 // Fetch email template settings from Redux options
                 $email_subject = isset($nokri['sb_msg_subject_on_new_job']) ? $nokri['sb_msg_subject_on_new_job'] : 'You have a new job - nokri';
                 $email_from = isset($nokri['sb_msg_from']) ? $nokri['sb_msg_from'] : 'From: ' . get_bloginfo('name') . ' <' . get_option('admin_email') . '>';
                 $email_message = isset($nokri['sb_msg_new']) ? $nokri['sb_msg_new'] : '<p>A new job has been posted.</p>';
         
                // Replace placeholders in the template
                 $email_subject = str_replace('%site_name%', get_bloginfo('name'), $email_subject);
                 $email_subject = str_replace('%job_title%', $project_name, $email_subject);
         
                 $email_message = str_replace('%site_name%', get_bloginfo('name'), $email_message);
                 $email_message = str_replace('%job_title%', $project_name, $email_message);
                 $email_message = str_replace('%job_owner%', wp_get_current_user()->display_name, $email_message);
                 $email_message = str_replace('%job_link%', get_permalink($post_id), $email_message);
                 $email_message = str_replace('%project_description%', $project_description, $email_message);
                $email_message = str_replace('%job_skills%', $job_skills, $email_message);
                // $email_message = str_replace(' %job_file_link%', $job_file_url, $email_message);
               
                $email_message = str_replace('%email%', $email, $email_message);
                    // Replace the placeholder for the job file link if it exists
                    if ( !empty($job_file_url) ) {
                        $email_message = str_replace('%job_file_link%', $job_file_url, $email_message);
                    } else {
                        // If no job file, you can either remove the placeholder or handle it differently
                        $email_message = str_replace('%job_file_link%', 'No file available', $email_message);
                    }
                
                // Prepare email headers
                 $headers[] = 'From: ' . $email_from;
                 $headers[] = 'Content-Type: text/html; charset=UTF-8';
         
                 // Get the current logged-in user's email
                 $current_user = wp_get_current_user();
                 $to = $current_user->user_email;
         
                 // Send the email
                 wp_mail($to, $email_subject, $email_message, $headers);
         
                 wp_send_json_success(array(
                     'success' => true,
                     'message' => 'Job posted successfully and email sent to the current user!',
                 ));
             } else {
                 wp_send_json_error(array('message' => 'Error saving form data.'));
             }
             wp_die();
         }
        
        add_action('wp_ajax_submit_candidate_request', 'handle_candidate_request_submission');
        add_action('wp_ajax_nopriv_submit_candidate_request', 'handle_candidate_request_submission');
        
        //  AJAX request for deletion
        function handle_candidate_request_delete() {
           $post_id = intval($_POST['post_id']);
        
            if (current_user_can('delete_post', $post_id)) {
                wp_delete_post($post_id, true);
        
                wp_send_json_success(array('message' => 'Post deleted successfully.'));
            } else {
                wp_send_json_error(array('message' => 'You do not have permission to delete this item.'));
            }
        
            wp_die();
        }
        add_action('wp_ajax_delete_candidate_request', 'handle_candidate_request_delete');
        
        
        // Fetch candidate request data
        add_action('wp_ajax_get_candidate_request', 'get_candidate_request');
        
        function get_candidate_request() {
            $post_id = intval($_POST['post_id']);
        
            if (current_user_can('edit_post', $post_id)) {
                $meta = get_post_meta($post_id);
                $project_duration_key = $meta['_project_duration'][0] ?? '';
                $project_duration_options = get_project_duration_options();
                $project_duration_value = $project_duration_options[$project_duration_key] ?? '';
                // Min Hours
                $min_hours_key = $meta['_min_hours'][0] ?? '';
                $min_hours_options = get_min_hours_options();
                $min_hours_value= $min_hours_options[$min_hours_key] ?? '';
                //  Compensation Type
                $compensation_type_key = $meta['_compensation_type'][0] ?? '';
                $compensation_type_options = get_compensation_type_options();
                $compensation_type_value = $compensation_type_options[ $compensation_type_key] ?? '';
                // Project Type
                $project_type_key = $meta['_project_type'][0] ?? '';
                $project_type_options = get_project_type_options();
                $project_type_value = $project_type_options[ $project_type_key] ?? '';
                // payment basic
                $payment_basis_key = $meta['_payment_basis'][0] ?? '';
                $payment_basis_options =get_payment_basic_options();
                $payment_basis_value = $payment_basis_options[ $payment_basis_key] ?? '';
        
                $file_url = !empty($meta['_job_file'][0]) ? esc_url($meta['_job_file'][0]) : '';
                wp_send_json_success(array(
                    'p_name' => $meta['_project_name'][0] ?? '',
                    'p_description' => $meta['_project_description'][0] ?? '',
                    'j_skills' => $meta['_job_skills'][0] ?? '',
                    'p_duration' => $project_duration_value,
                    'm_hours' => $min_hours_value,
                    'pay_basis' => $payment_basis_value,
                    'compensation_type' => $compensation_type_value,
                    'compensation' => $meta['_compensation'][0] ?? '',
                    'comp_details' => $meta['_compensation_details'][0] ?? '',
                    'p_type' => $project_type_value,
                    'email' => $meta['_email'][0] ?? '',
                    'phone_no' => $meta['_phone'][0] ?? '',
                    'upload_file' => $file_url, // Fetch the file URL
                ));
            } else {
                wp_send_json_error(array('message' => 'You do not have permission to edit this item.'));
            }
            wp_die();
        }
        // Update request
        function update_candidate_request() {
            $post_id = intval($_POST['post_id']);
            if (current_user_can('edit_post', $post_id)) {
                // Update the post title and content
                $post_data = array(
                    'ID' => $post_id,
                    'post_title' => sanitize_text_field($_POST['p_name']),
                    'post_content' => sanitize_textarea_field($_POST['p_description'])
                );
        
                wp_update_post($post_data);
                update_post_meta($post_id, '_project_name', sanitize_text_field($_POST['p_name']));
                update_post_meta($post_id, '_job_skills', sanitize_text_field($_POST['j_skills']));
                update_post_meta($post_id, '_project_description', sanitize_textarea_field($_POST['p_description']));
                update_post_meta($post_id, '_project_duration', array_search($_POST['p_duration'], get_project_duration_options()));
                update_post_meta($post_id, '_min_hours', array_search($_POST['m_hours'], get_min_hours_options()));
                update_post_meta($post_id, '_payment_basis', array_search($_POST['pay_basis'], get_payment_basic_options()));
                update_post_meta($post_id, '_compensation_type', array_search($_POST['comp_type'],get_compensation_type_options()));
                update_post_meta($post_id, '_compensation', sanitize_text_field($_POST['compensation']));
                update_post_meta($post_id, '_compensation_details', sanitize_text_field($_POST['comp_details']));
                update_post_meta($post_id, '_project_type', array_search($_POST['p_type'], get_project_type_options()));
                update_post_meta($post_id, '_email', sanitize_email($_POST['email']));
                update_post_meta($post_id, '_phone', sanitize_text_field($_POST['phone_no']));
        
                    // Handle file uploads (if applicable)
                    if (isset($_FILES['upload_file']) && !empty($_FILES['upload_file']['name'])) {
                        $uploaded_file = wp_handle_upload($_FILES['upload_file'], array('test_form' => false));
                        if (!isset($uploaded_file['error'])) {
                            update_post_meta($post_id, '_job_file', esc_url($uploaded_file['url']));
                        }
                    }
                    wp_send_json_success(array('message' => 'Candidate Request has been  updated successfully.'));
            } else {
                wp_send_json_error(array('message' => 'You do not have permission to edit this item.'));
            }
        
            wp_die();
        }
        add_action('wp_ajax_update_candidate_request', 'update_candidate_request');
        add_action('wp_ajax_nopriv_update_candidate_request', 'update_candidate_request');
        $row_data = '';
        if (is_array($applier) && !empty($applier) && count($applier) > 0) {
            foreach ($applier as $key => $applier_data) {
                $user_info = get_userdata($applier_data);
                //print_r($user_info );
                // $user_details = $user_info->data;
                $user_details = $user_info;
                if ($user_details != "") {
                    $user_id = $user_details->ID;
                    $username = $user_details->user_nicename;
                    $email = $user_details->user_email;
                    $user_registered = $user_details->user_registered;
                    $row_data .= '<tr>
                        <td>' . $key . '</td>
                        <td>' . $user_id . '</td>
                        <td>' . $username . '</td>
                        <td>' . $email . ' </td>
                        <td>' . $user_registered . '</td>
                    </tr>';
                }
            }
        }
        ?>
        <table>
            <tr>
                <th><?php echo __('Serial No : ', 'redux-framework'); ?></th>
                <th><?php echo __('User ID :  ', 'redux-framework'); ?></th>
                <th><?php echo __('Username : ', 'redux-framework'); ?></th>
                <th><?php echo __('Email : ', 'redux-framework'); ?></th>
                <th><?php echo __('Registeration Date : ', 'redux-framework'); ?></th>
            </tr>
            <?php echo '' . $row_data ?>
        </table>
    </div>
<?php
}
