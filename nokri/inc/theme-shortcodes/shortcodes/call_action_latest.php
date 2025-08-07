<?php

/* ------------------------------------------------ */
/* Call To Action 2 */
/* ------------------------------------------------ */

function call_action_short_latest() {
    vc_map(array(
        "name" => esc_html__("Call To Action Latest", 'nokri'),
        "base" => "call_action_short_latest_modern",
        "category" => esc_html__("Theme Shortcodes", 'nokri'),
        "params" => array(
            array(
                'group' => esc_html__('Shortcode Output', 'nokri'),
                'type' => 'custom_markup',
                'heading' => esc_html__('Shortcode Output', 'nokri'),
                'param_name' => 'order_field_key',
                'description' => nokri_VCImage('call_to_action_latest.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Section Heading", 'nokri'),
                "param_name" => "call_action_heading",
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "textarea",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Some Detail", 'nokri'),
                "description" => esc_html__("Separate every para with | sign", 'nokri'),
                "param_name" => "call_action_details",
            ),
            array(
                'group' => esc_html__('Links', 'nokri'),
                "type" => "vc_link",
                "heading" => esc_html__("Button", 'nokri'),
                "param_name" => "link",
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "attach_image",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Image", 'nokri'),
                "param_name" => "call_action_img",
                "description" => esc_html__('590 × 521', 'nokri'),
            ),
        ),
    ));
}

add_action('vc_before_init', 'call_action_short_latest');

function call_action_short_latest_base_func($atts) {
    extract(shortcode_atts(array(
        'order_field_key' => '',
        'call_action_heading' => '',
        'call_action_details' => '',
        'call_action_btn' => '',
        'link' => '',
        'call_action_img' => '',
                    ), $atts));
    /* Section Heading */
    $section_heading = (isset($call_action_heading) && $call_action_heading != "") ? '' . $call_action_heading . '' : "";
    /* Section Details */
    $section_details = (isset($call_action_details) && $call_action_details != "") ? '<p>' . $call_action_details . '</p>' : "";
    $paras = explode("|", $section_details);
    $paragraph_html = '';
    foreach ($paras as $para) {
        $paragraph_html .= '<p class="txt">' . $para . '</p>';
    }
    /* Link */
    $btn = '';
    $link = (($atts['link']));
    if (isset($link)) {
        $btn = nokri_ThemeBtn($link, 'btn n-btn-flat resource-btn', false);
    }
    $call_action_img = $atts['call_action_img'];
    /* Section Image */
    $section_img = '';
    $img_thumb = '';
    if (isset($call_action_img)) {
        $img = wp_get_attachment_image_src($call_action_img, '');
        $img_thumb = $img[0];
    }
    return '<section class="our-resources">
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                        <div class="left-cont">
                            <h3 class="title">' . $section_heading . '</h3>
                                ' . $paragraph_html . '
                            <div class="main-btn">
                               ' . $btn . '
                            </div>
                        </div>
                    </div>
                    <div class="col-12 col-sm-12 col-md-12 col-lg-6 col-xl-6 col-xxl-6">
                        <div class="main-img">
                            <img src="' . $img_thumb . '" alt="' . esc_attr__('image', 'nokri') . '">
                        </div>
                    </div>
                </div>
            </div>
        </section>';
}

if (function_exists('nokri_add_code')) {
    nokri_add_code('call_action_short_latest_modern', 'call_action_short_latest_base_func');
}