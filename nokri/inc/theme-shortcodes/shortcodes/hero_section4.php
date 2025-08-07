<?php

/* ------------------------------------------------ */
/* Hero section 4 - */
/* ------------------------------------------------ */
if (!function_exists('hero_section4')) {

    function hero_section4() {
        vc_map(array(
            "name" => esc_html__("Hero Section 4", 'nokri'),
            "base" => "hero_section4",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('hero_section4.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Heading", 'nokri'),
                    "param_name" => "section_title",
                    "description" => esc_html__('For color ', 'nokri') . '<strong>' . '<strong>' . esc_html('{color}') . '</strong>' . '</strong>' . esc_html__('warp text within this tag', 'nokri') . '<strong>' . esc_html('{/color}') . '</strong>',
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section tagline", 'nokri'),
                    "param_name" => "section_details",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("More Description", 'nokri'),
                    "param_name" => "section_more_details",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "attach_image",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Search Image", 'nokri'),
                    "param_name" => "search_image",
                    "description" => esc_html__('938 x 252', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "attach_image",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Circle Image", 'nokri'),
                    "param_name" => "circle_image",
                    "description" => esc_html__('938 x 252', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Categories", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select categories ( All or Selective )', 'nokri'),
                    'param_name' => 'cats',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'nokri'),
                            "param_name" => "cat",
                            "admin_label" => true,
                            "value" => nokri_get_parests('job_category', 'yes'),
                        ),
                    )
                ),
                array(
                    "group" => esc_html__("Categories", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Do you want to show Sub Categories", 'nokri'),
                    "param_name" => "want_to_show",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('yes', 'nokri') => 'yes',
                        esc_html__('no', 'nokri') => 'no',
                    ),
                    'edit_field_class' => 'vc_col-sm-12 vc_column',
                    "std" => '',
                ),
                array(
                    "group" => esc_html__("Hot Cats", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'nokri'),
                    "param_name" => "hot_title",
                ),
                array
                    (
                    "group" => esc_html__("Hot Cats", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select hot categories', 'nokri'),
                    'param_name' => 'hot_cats',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "dropdown",
                            "heading" => esc_html__("Category", 'nokri'),
                            "param_name" => "hot_cat",
                            "admin_label" => true,
                            "value" => nokri_get_parests('job_category', 'no'),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'hero_section4');
if (!function_exists('hero_section4_short_base_func')) {

    function hero_section4_short_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'cats' => '',
            'section_for' => '',
            'section_title' => '',
            'section_more_details' => '',
            'search_image' => '',
            'circle_image' => '',
            'section_tagline' => '',
            'section_details' => '',
            'section_details' => '',
            'btn_link' => '',
            'countries' => '',
            'hot_cats' => '',
            'hot_title' => '',
            'want_to_show' => '',
            'sidebar_title' => '',
            'keyword_title' => '',
            'cats_title' => '',
            'locat_title' => '',
                        ), $atts));
        global $nokri;
        if (isset($want_to_show) && $want_to_show == "yes") {
            
        }
        $cats_html = $countries_html = '';
        // For Job Category
        if (isset($atts['cats']) && $atts['cats'] != '') {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $cats = false;
            $cats_html = '';
            if (count($rows) > 0) {
                $cats_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] == 'all') {
                            $cats = true;
                            $cats_html = '';
                            break;
                        }
                        $category = get_term_by('slug', $row['cat'], 'job_category');
                        if (count((array) $category) == 0)
                            continue;
                        if (isset($want_to_show) && $want_to_show == "yes") {

                            $ad_cats_sub = nokri_get_cats('job_category', $category->term_id);
                            if (count($ad_cats_sub) > 0) {
                                $cats_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                                foreach ($ad_cats_sub as $ad_cats_subz) {
                                    $cats_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                                }
                                $cats_html .= '</option>';
                            } else {
                                $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                            }
                        } else {
                            $cats_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    }
                }
                if ($cats) {
                    $ad_cats = nokri_get_cats('job_category', 0);
                    foreach ($ad_cats as $cat) {
                        if (isset($want_to_show) && $want_to_show == "yes") {
                            //sub cat
                            $ad_sub_cats = nokri_get_cats('job_category', $cat->term_id);
                            if (count($ad_sub_cats) > 0) {
                                $cats_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                                foreach ($ad_sub_cats as $sub_cat) {
                                    $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                    //sub sub cat
                                    $ad_sub_sub_cats = nokri_get_cats('job_category', $sub_cat->term_id);
                                    if (count($ad_sub_sub_cats) > 0) {
                                        foreach ($ad_sub_sub_cats as $sub_cat_sub) {
                                            $cats_html .= '<option value="' . $sub_cat_sub->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;' . $sub_cat_sub->name . '  (' . $sub_cat_sub->count . ') </option>';
                                            //sub sub sub cat
                                            $ad_sub_sub_sub_cats = nokri_get_cats('job_category', $sub_cat_sub->term_id);
                                            if (count($ad_sub_sub_sub_cats) > 0) {
                                                foreach ($ad_sub_sub_sub_cats as $sub_cat) {
                                                    $cats_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                                }
                                            }
                                        }
                                    }
                                }
                                $cats_html .= '</option>';
                            } else {
                                $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                            }
                        } else {
                            $cats_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    }
                }
            }
        }
        // countries
        if (isset($atts['countries']) && $atts['countries'] != '') {
            $rows = vc_param_group_parse_atts($atts['countries']);
            $cats = false;
            $countries_html = '';
            if (count($rows) > 0) {
                $countries_html .= '';
                foreach ($rows as $row) {
                    if (isset($row['country'])) {
                        if ($row['country'] == 'all') {
                            $cats = true;
                            $countries_html = '';
                            break;
                        }
                        $category = get_term_by('slug', $row['country'], 'ad_location');
                        if (count(array($category)) == 0)
                            continue;
                        if (isset($want_to_show_loc) && $want_to_show_loc == "yes") {

                            $ad_cats_sub = nokri_get_cats('ad_location', $category->term_id);
                            if (count($ad_cats_sub) > 0) {
                                $countries_html .= '<option value="' . $category->term_id . '" >' . $category->name . '  (' . $category->count . ')';
                                foreach ($ad_cats_sub as $ad_cats_subz) {
                                    $countries_html .= '<option value="' . $ad_cats_subz->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $ad_cats_subz->name . '  (' . $ad_cats_subz->count . ') </option>';
                                }
                                $countries_html .= '</option>';
                            } else {
                                $countries_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                            }
                        } else {
                            $countries_html .= '<option value="' . $category->term_id . '">' . $category->name . '   (' . $category->count . ')</option>';
                        }
                    }
                }
                if ($cats) {
                    $ad_cats = nokri_get_cats('ad_location', 0);
                    foreach ($ad_cats as $cat) {
                        if (isset($want_to_show_loc) && $want_to_show_loc == "yes") {
                            //sub cat
                            $ad_sub_cats = nokri_get_cats('ad_location', $cat->term_id);
                            if (count($ad_sub_cats) > 0) {
                                $countries_html .= '<option value="' . $cat->term_id . '" >' . $cat->name . '  (' . $cat->count . ')';
                                foreach ($ad_sub_cats as $sub_cat) {
                                    $countries_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                    //sub sub cat
                                    $ad_sub_sub_cats = nokri_get_cats('ad_location', $sub_cat->term_id);
                                    if (count($ad_sub_sub_cats) > 0) {
                                        foreach ($ad_sub_sub_cats as $sub_cat_sub) {
                                            $countries_html .= '<option value="' . $sub_cat_sub->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;' . $sub_cat_sub->name . '  (' . $sub_cat_sub->count . ') </option>';
                                            //sub sub sub cat
                                            $ad_sub_sub_sub_cats = nokri_get_cats('ad_location', $sub_cat_sub->term_id);
                                            if (count($ad_sub_sub_sub_cats) > 0) {
                                                foreach ($ad_sub_sub_sub_cats as $sub_cat) {
                                                    $countries_html .= '<option value="' . $sub_cat->term_id . '">' . '&nbsp;&nbsp; - &nbsp; - &nbsp;- &nbsp;' . $sub_cat->name . '  (' . $sub_cat->count . ') </option>';
                                                }
                                            }
                                        }
                                    }
                                }
                                $countries_html .= '</option>';
                            } else {
                                $countries_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                            }
                        } else {
                            $countries_html .= '<option value="' . $cat->term_id . '">' . $cat->name . '   (' . $cat->count . ')</option>';
                        }
                    }
                }
            }
        }
        // For hot categories
        $hot_cats_html = '';
        if (!empty($atts['hot_cats'])) {
            $rows_hot_cats = vc_param_group_parse_atts($atts['hot_cats']);
            $year_countries = false;
            $hot_cats_html = '';
            $get_year = '';
            if (count($rows_hot_cats) > 0) {
                foreach ($rows_hot_cats as $rows_hot_cat) {
                    if (isset($rows_hot_cat['hot_cat'])) {
                        if ($rows_hot_cat['hot_cat'] == 'all') {
                            $year_countries = true;
                            $countries_html = '';
                            break;
                        }
                        $get_hot_cat = get_term_by('slug', $rows_hot_cat['hot_cat'], 'job_category');
                        if (count((array) $get_hot_cat) == 0)
                            continue;
                        $hot_cats_html .= '<li><a href="' . nokri_cat_link_page($get_hot_cat->term_id) . '">' . $get_hot_cat->name . '</a></li>';
                    }
                }
            }
        }
        /* Section Title */
        $main_section_title = (isset($section_title) && $section_title != "") ? '' . $section_title . '' : "";
        /* Section Descriptions */
        $main_section_deatils = (isset($section_details) && $section_details != "") ? '' . $section_details . '' : "";
        $main_section_title = nokri_color_text($main_section_title);
        $section_more_details = (isset($section_more_details) && $section_more_details != "") ? ' ' . $section_more_details . '' : "";
        $hot_section_title = (isset($hot_title) && $hot_title != "") ? '<li><h6>' . $hot_title . '</h6></li>' : "";
        /* sidebar_title */
        $sidebar_title = (isset($sidebar_title) && $sidebar_title != "") ? '<h4>' . $sidebar_title . '</h4>' : "";
        /* keyword_title */
        $keyword_title = (isset($keyword_title) && $keyword_title != "") ? '<label>' . $keyword_title . '</label>' : "";
        /* cats_title */
        $cats_title = (isset($cats_title) && $cats_title != "") ? '<label>' . $cats_title . '</label>' : "";
        /* cats_title */
        $locat_title = (isset($locat_title) && $locat_title != "") ? '<label>' . $locat_title . '</label>' : "";
        /* Search Image */
        $search_image1 = '';
        if (isset($search_image)) {
            $img = wp_get_attachment_image_src($search_image, '');
            $img_thumb = isset($img[0]) ? $img[0] : " ";
            $search_image1 = ' <img class="circle-img" src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri') . '">';
        }
        $circle_image1 = '';
        if (isset($circle_image)) {
            $img = wp_get_attachment_image_src($circle_image, '');
            $img_thumb = isset($img[0]) ? $img[0] : " ";
            $circle_image1 = ' <img class="circle-img" src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri') . '">';
        }
        /* Section for */
        $action = get_the_permalink($nokri['sb_search_page']);
        return '<section class="new-nokri-hero">
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-7 col-xl-7 col-xxl-7">
                                <div class="main-content">
                                    <small class="title">' . $main_section_deatils . '</small>
                                    <h1 class="heading">' . $main_section_title . '</h1>
                                    <p class="txt">' . $section_more_details . '</p>
                                    <div class="search-bar">
                                        <form  class ="n-search-bar-form" method="get" action="' . $action . '">
                                            ' . nokri_form_lang_field_callback(false) . '
                                            <input type="text" placeholder="' . esc_html__('Search here', 'nokri') . '">
                                            <div class="form-group freelance-category " data-select2-id="select2-data-5-pqa2">
                                                <select class="js-example-basic-single category" data-allow-clear="true" data-placeholder="' . esc_html__('Select Category', 'nokri') . '"  name="state">
                                                    <option label="' . esc_html__('Select Category', 'nokri') . '"></option>
                                                    ' . $cats_html . '
                                                </select>
                                            </div>
                                            <button type="submit" class="srh-btn n-btn-flat">' . esc_html__('Search', 'nokri') . '</button>
                                            ' . $circle_image1 . '
                                        </form>
                                    </div>
                                    <div class="srh-categories">
                                <ul>
                                    ' . $hot_section_title . '
                                    ' . $hot_cats_html . '                                   
                                </ul>
                            </div>
                                </div>
                            </div>
                            <div class="col-12 col-sm-12 col-md-12 col-lg-5 col-xl-5 col-xxl-5">
                                ' . $search_image1 . '
                            </div>
                        </div>
                    </div>
        </section>';
    }

}
if (function_exists('nokri_add_code')) {
    nokri_add_code('hero_section4', 'hero_section4_short_base_func');
}