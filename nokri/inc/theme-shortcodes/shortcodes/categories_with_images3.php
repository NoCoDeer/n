<?php

/* ------------------------------------------------ */
/* Category - With Images Latest */
/* ------------------------------------------------ */
if (!function_exists('categories_section3')) {

    function categories_section3() {
        vc_map(array(
            "name" => esc_html__("Categories with Images Latest", 'nokri'),
            "base" => "categories_section3",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('nokri_cats_with_backg.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Title", 'nokri'),
                    "param_name" => "section_title",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'nokri'),
                    "param_name" => "section_desc",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Opening Text", 'nokri'),
                    "param_name" => "section_open_txt",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Multiple openings text", 'nokri'),
                    "param_name" => "section_open_txt2",
                ),
                array(
                    'group' => esc_html__('Basic', 'nokri'),
                    "type" => "vc_link",
                    "heading" => esc_html__("Link", 'nokri'),
                    "param_name" => "link",
                ),
                array
                    (
                    "group" => esc_html__("Categories", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select Categories', 'nokri'),
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
                        array(
                            "type" => "attach_image",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Category Image", 'nokri'),
                            "param_name" => "cat_img",
                            "description" => esc_html__('64x64', 'nokri'),
                        ),
                    )
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'categories_section3');
if (!function_exists('categories_section3_short_base_func')) {

    function categories_section3_short_base_func($atts, $content = '') {
        require trailingslashit(get_template_directory()) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
        extract(shortcode_atts(array(
            'cats' => '',
            'section_title' => '',
            'section_desc' => '',
            'section_open_txt' => '',
            'section_open_txt2' => '',
            'link' => '',
                        ), $atts));
        // For Job Category
        if (isset($atts['cats']) && $atts['cats'] != '') {
            $rows = vc_param_group_parse_atts($atts['cats']);
            $cats = false;
            $cats_html = '';
            /* Opening txt */
            $one_opening = (isset($section_open_txt) && $section_open_txt != "") ? $section_open_txt : esc_html__('Openings', 'nokri');
            $more_opening = (isset($section_open_txt2) && $section_open_txt2 != "") ? $section_open_txt2 : esc_html__('Openings', 'nokri');
            if (count((array) $rows) > 0) {
                $cats_html = '';
                foreach ($rows as $row) {
                    if (isset($row['cat'])) {
                        if ($row['cat'] == 'all') {
                            $cats = true;
                            break;
                        }
                        $category = get_term_by('slug', $row['cat'], 'job_category');
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($category->term_id, 'job_category');
                        if (count((array) $category) == 0)
                            continue;
                        /* Category Image */
                        $cat_img = '';
                        if (isset($row['cat_img'])) {
                            $img = wp_get_attachment_image_src($row['cat_img'], '');
                            $img_thumb = isset($img[0]) ? $img[0] : "";
                            $cat_img = '<img class="category-img" src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri') . '">';
                        }
                        $count_cat = $one_opening;
                        if ($category->count > 1) {
                            $count_cat = $more_opening;
                        }             
                        $cat_bg_pattern  = get_template_directory_uri() . '/images/patern-dot.png';
                        $cat_bg_circle  = get_template_directory_uri() . '/images/patern-dot-circle.png';                      
                        $cats_html .= '<div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                            <div class="category-box">
                                               ' . $cat_img . '
                                                <a href="' . nokri_cat_link_page($category->term_id) . '"><h3 class="heading">' . $category->name . '</h3></a>
                                                <span>(' . $custom_count . " " . $count_cat . ')</span>
                                                <img class="dot-img" src="'.$cat_bg_pattern.'" alt="dot-img">
                                                <img class="dot-circle-img" src="'.$cat_bg_circle.'" alt="dot-circle-img">
                                            </div>
                                        </div>';
                    }
                }
                if ($cats) {
                    $ad_cats = nokri_get_cats('job_category', 0);
                    /* Category Image */
                    $cat_img = '';
                    if (isset($row['cat_img'])) {
                        $img = wp_get_attachment_image_src($row['cat_img'], '');
                        $img_thumb = $img[0];
                        $cat_img = '<img class="category-img" src="' . esc_url($img_thumb) . '" alt="' . esc_attr__('image', 'nokri') . '">';
                    }
                    foreach ($ad_cats as $cat) {
                        /* calling function for openings */
                        $custom_count = nokri_get_opening_count($cat->term_id, 'job_category');
                        $count_cat = $one_opening;
                        if ($cat->count > 1) {
                            $count_cat = $more_opening;
                        }
                        $cat_bg_pattern  = get_template_directory_uri() . '/images/patern-dot.png';
                        $cat_bg_circle  = get_template_directory_uri() . '/images/patern-dot-circle.png';
                        $cats_html .= '<div class="col-12 col-sm-6 col-md-6 col-lg-3 col-xl-3 col-xxl-3">
                                            <div class="category-box">
                                               ' . $cat_img . '
                                                <a href="' . nokri_cat_link_page($cat->term_id) . '"><h3 class="heading">' . $cat->name . '</h3></a>
                                                <span>(' . $custom_count . " " . $count_cat . ')</span>
                                                    <img class="dot-img" src="'.$cat_bg_pattern.'" alt="' . esc_attr__('image', 'nokri') . '">
                                                <img class="dot-circle-img" src="'.$cat_bg_circle.'" alt="' . esc_attr__('image', 'nokri') . '">
                                            </div>
                                        </div>';
                    }
                }
            }
        }
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '' . $section_title . '' : "";
        /* Section description */
        $section_description = (isset($section_desc) && $section_desc != "") ? '' . $section_desc . '' : "";
        return '<section class="nokri-browse-categories">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                        <div class="nokri-main-meta"> 
                            <h2 class="main-heading">' . $section_title . '</h2>
                            <p class="main-txt">' . $section_description . '</p>
                        </div>
                    </div>  
                </div>
                <div class="row category-box-grid">
                    ' . $cats_html . '
                </div>
            </div>
        </section>';
    }

}
if (function_exists('nokri_add_code')) {
    nokri_add_code('categories_section3', 'categories_section3_short_base_func');
}