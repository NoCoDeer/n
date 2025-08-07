<?php

/* ------------------ */
/* Success Stories slider */
/* ----------------- */
if (!function_exists('success_stories_slider_new')) {

    function success_stories_slider_new() {
        vc_map(array(
            "name" => esc_html__("Success Stories Latest", 'nokri'),
            "base" => "success_stories_slider_new",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('nokri_success_stories_slider_new_new.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "dropdown",
                    "heading" => esc_html__("Select BG Color", 'nokri'),
                    "param_name" => "success_stories_slider_new_clr",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Option', 'nokri') => '',
                        esc_html__('Sky BLue', 'nokri') => 'light-grey',
                        esc_html__('White', 'nokri') => '',
                    ),
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
                    "type" => "textarea",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'nokri'),
                    "param_name" => "section_desc",
                ),
                array
                    (
                    "group" => esc_html__("Add Stories", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select', 'nokri'),
                    'param_name' => 'stories',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Story Title", 'nokri'),
                            "param_name" => "story_title",
                        ),
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Designation", 'nokri'),
                            "param_name" => "story_designation",
                        ),
                        array(
                            "type" => "textarea",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Story Details", 'nokri'),
                            "description" => esc_html__("Separate every para with | sign", 'nokri'),
                            "param_name" => "story_description",
                        ),
                        array(
                            "type" => "attach_image",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Client Image", 'nokri'),
                            "param_name" => "story_img",
                            "description" => esc_html__('45 x 45', 'nokri'),
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'success_stories_slider_new');

if (!function_exists('success_stories_slider_new_short_base_func')) {

    function success_stories_slider_new_short_base_func($atts, $content = '') {

        require trailingslashit(get_template_directory()) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";

        extract(shortcode_atts(array(
            'stories' => '',
            'section_title' => '',
            'success_stories_slider_new_clr' => '',
            'story_img' => '',
            'section_desc' => '',
                        ), $atts));
        if (isset($atts['stories']) && !empty($atts['stories']) != '') {
            $rows = vc_param_group_parse_atts($atts['stories']);
            $stories_html = '';
            if ((array) count($rows) > 0) {
                foreach ($rows as $row) {
                    $img_html = '';
                    if (isset($row['story_img']) && $row['story_img'] != '') {
                        $img = wp_get_attachment_image_src($row['story_img'], '');
                        $img = $img[0];
                    }
                    /* Story Title */
                    $astory_title = (isset($row['story_title']) && $row['story_title'] != "") ? '' . $row['story_title'] . '' : "";
                    /* Story Description */
                    $astory_desc = (isset($row['story_description']) && $row['story_description'] != "") ? $row['story_description'] : "";
                    $paras = explode("|", $astory_desc);
                    $paragraph_html = '';
                    foreach ($paras as $para) {
                        $paragraph_html .= '' . $para . '';
                    }
                    /* Story client */
                    $story_designation = (isset($row['story_designation']) && $row['story_designation'] != "") ? ' ' . $row['story_designation'] . '' : "";
                    $def_image_src = get_template_directory_uri() . "/images/shape-img.png";

                    /* Story Html */
                    $stories_html .= '
                                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-6 col-xxl-6">
                                        <div class="comment-box first">
                                            <div class="left-img">
                                                <div class="img-box">
                                                    <img src="' . $img . '" alt="' . esc_attr__("image", "nokri") . '">
                                                </div>
                                            </div>
                                            <div class="right-meta">
                                                <h4 class="heading">' . $astory_title . '</h4>
                                                <span class="title">' . $story_designation . '</span>
                                                <p class="txt">' . $paragraph_html . ' </p>                                        
                                                <img class="shape-img" src="' . $def_image_src . '" alt="' . esc_attr__("image", "nokri") . '">
                                            </div>
                                        </div>
                                    
                            </div>';
                }
            }
        }
        /* Section Color */
        $section_clr = (isset($success_stories_slider_new_clr) && $success_stories_slider_new_clr != "") ? $success_stories_slider_new_clr : "";
        /* Section name */
        $section_title = (isset($section_title) && $section_title != "") ? '' . $section_title . '' : "";
        /* Section desc */
        $section_desc = (isset($section_desc) && $section_desc != "") ? '' . $section_desc . '' : "";

        return'<section class="customer-testimonial"' . esc_attr($section_clr) . '>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                        <div class="nokri-main-meta"> 
                            <h2 class="main-heading">' . $section_title . '</h2>
                            <p class="main-txt">' . $section_desc . '</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                        <div class="">   
                          
                                <div class=" owl-carousel owl-theme nokri-client-testimonial">
                            ' . $stories_html . '
                                </div>
          
                        </div>
                    </div>
                </div>
            </div>
        </section>';
    }

}

if (function_exists('nokri_add_code')) {
    nokri_add_code('success_stories_slider_new', 'success_stories_slider_new_short_base_func');
}