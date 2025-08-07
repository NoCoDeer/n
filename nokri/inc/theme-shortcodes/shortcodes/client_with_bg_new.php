<?php

/* ------------------ */
/* Success Stories */
/* ----------------- */
if (!function_exists('client_with_bg_new')) {

    function client_with_bg_new() {
        vc_map(array(
            "name" => esc_html__("Our Clients New", 'nokri'),
            "base" => "client_with_bg_new",
            "category" => esc_html__("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => esc_html__('Shortcode Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => esc_html__('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('client_with_bg_new.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Heading", 'nokri'),
                    "param_name" => "section_heading",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "textfield",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Section Description", 'nokri'),
                    "param_name" => "section_description",
                ),
                array(
                    "group" => esc_html__("Basic", "nokri"),
                    "type" => "attach_image",
                    "holder" => "div",
                    "class" => "",
                    "heading" => esc_html__("Background Image", 'nokri'),
                    "param_name" => "search_section_img",
                    "description" => esc_html__('1263 x 147', 'nokri'),
                ),
                array
                    (
                    "group" => esc_html__("Add Clients", "nokri"),
                    'type' => 'param_group',
                    'heading' => esc_html__('Select', 'nokri'),
                    'param_name' => 'images',
                    'value' => '',
                    'params' => array
                        (
                        array(
                            "type" => "attach_image",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Client Image", 'nokri'),
                            "param_name" => "section_client",
                            "description" => esc_html__('150 x 150', 'nokri'),
                        ),
                        array(
                            "type" => "textfield",
                            "holder" => "div",
                            "class" => "",
                            "heading" => esc_html__("Client Link", 'nokri'),
                            "param_name" => "client_link",
                        ),
                    )
                ),
            ),
        ));
    }

}

add_action('vc_before_init', 'client_with_bg_new');

if (!function_exists('client_with_bg_new_short_base_func')) {

    function client_with_bg_new_short_base_func($atts, $content = '') {

        extract(shortcode_atts(array(
            'images' => '',
            'section_img' => '',
            'section_heading' => '',
            'section_description' => '',
            'search_section_img' => '',
                        ), $atts));
        if (isset($atts['images']) && $atts['images'] != '') {
            $rows = vc_param_group_parse_atts($atts['images']);
            $images_html = '';
            if ((array) count($rows) > 0) {
                foreach ($rows as $row) {
                    $img_html = '';
                    if (isset($row['section_client']) && $row['section_client'] != '') {
                        $img = wp_get_attachment_image_src($row['section_client'], 'nokri_job_post_single');
                        $img = $img[0];
                        $img_html = '<img class="logo-img"  src="' . $img . '" alt="' . esc_attr__("image", "nokri") . '">';
                    }
                    /* Client Link  */
                    $link = (isset($row['client_link']) && $row['client_link'] != "") ? $row['client_link'] : "#";
                    /* Story Html */

                    $images_html .= '
                        <li class="items">
                                    <div class="company-brand">
                                        <a href="' . $link . '">' . $img_html . '</a>
                                    </div>
                                </li>
                            
                           
                            ';
                }
            }
        }
        /* Section Heading */
        $section_heading1 = (isset($section_heading) && $section_heading != "") ? '' . $section_heading . '' : "";
        /* Section Description */
        $section_description1 = (isset($section_description) && $section_description != "") ? '' . $section_description . '' : "";
        $bg_img = '';
        if ($search_section_img != "") {
            $bgImageURL = nokri_returnImgSrc($search_section_img);
            $bg_img = ( $bgImageURL != "" ) ? ' \\s\\t\\y\\l\\e="background:  url(' . $bgImageURL . ') no-repeat scroll center center / cover ;"' : "";
        }
        return '<section class="top-hiring-companies" ' . str_replace('\\', "", $bg_img) . '>
                    <div class="container">
                        <div class="row">
                            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                                <div class="nokri-main-meta"> 
                                    <span>' . $section_heading1 . '</span>
                                    <h2 class="main-heading">' . $section_description1 . '</h2>
                                </div>
                            </div>
                        </div>
                        <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="company-brand-grid">
                            <ul>                               
                            ' . $images_html . '
                            </ul>
                        </div>
                                
                             </div> 
                           </div>
                    </div>
        </section>';
    }

}

if (function_exists('nokri_add_code')) {
    nokri_add_code('client_with_bg_new', 'client_with_bg_new_short_base_func');
}