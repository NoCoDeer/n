<?php

/* ------------------------------------------------ */
/* Blog Posts Latest */
/* ------------------------------------------------ */

function blog_posts_modern_short_latest() {
    vc_map(array(
        "name" => esc_html__("Blog Posts Modern Latest", 'nokri'),
        "base" => "blog_posts_base_new",
        "category" => esc_html__("Theme Shortcodes", 'nokri'),
        "params" => array(
            array(
                'group' => esc_html__('Shortcode Output', 'nokri'),
                'type' => 'custom_markup',
                'heading' => esc_html__('Shortcode Output', 'nokri'),
                'param_name' => 'order_field_key',
                'description' => nokri_VCImage('blog-posts-modern-latest.png') . esc_html__('Ouput of the shortcode will be look like this.', 'nokri'),
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "dropdown",
                "heading" => esc_html__("Select Posts color", 'nokri'),
                "param_name" => "blog_posts_clr",
                "admin_label" => true,
                "value" => array(
                    esc_html__('Select Option', 'nokri') => '',
                    esc_html__('White', 'nokri') => '',
                    esc_html__('Gray', 'nokri') => 'light-grey',
                ),
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "textfield",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Section Heading", 'nokri'),
                "param_name" => "section_title",
            ),
            array(
                "group" => esc_html__("Basic", "nokri"),
                "type" => "textarea",
                "holder" => "div",
                "class" => "",
                "heading" => esc_html__("Section Details", 'nokri'),
                "param_name" => "section_description",
            ),
            array(
                "group" => esc_html__("Post Options", "nokri"),
                "type" => "dropdown",
                "heading" => esc_html__("Number Of Post To Show", 'nokri'),
                "param_name" => "blog_posts_no",
                "admin_label" => true,
                "value" => range(1, 50),
            ),
            array(
                "group" => esc_html__("Post Options", "nokri"),
                "type" => "dropdown",
                "heading" => esc_html__("Number of words in title", 'nokri'),
                "param_name" => "blog_posts_title_no",
                "admin_label" => true,
                "value" => range(1, 50),
            ),
            array(
                "group" => esc_html__("Post Options", "nokri"),
                "type" => "dropdown",
                "heading" => esc_html__("Select Posts Order", 'nokri'),
                "param_name" => "blog_posts_order",
                "admin_label" => true,
                "value" => array(
                    esc_html__('Select Option', 'nokri') => '',
                    esc_html__('ASCENDING', 'nokri') => 'ASC',
                    esc_html__('DESCENDING', 'nokri') => 'DESC',
                ),
            ),
            array
                (
                'group' => esc_html__('Select Categories', 'nokri'),
                'type' => 'param_group',
                'heading' => esc_html__('Add Category', 'nokri'),
                'param_name' => 'blog_posts',
                'value' => '',
                'params' => array
                    (
                    array(
                        "type" => "dropdown",
                        "heading" => esc_html__("Category", 'nokri'),
                        "param_name" => "categories",
                        "admin_label" => true,
                        "value" => nokri_get_parests('category', 'yes'),
                    ),
                )
            ),
        ),
    ));
}

add_action('vc_before_init', 'blog_posts_modern_short_latest');

function blog_posts_modern_short_latest_base_func($atts, $content = '') {
    require trailingslashit(get_template_directory()) . "inc/theme-shortcodes/shortcodes/layouts/header_layout.php";
    extract(shortcode_atts(array(
        'order_field_key' => '',
        'blog_posts_clr' => '',
        'blog_posts_order' => '',
        'blog_posts' => '',
        'section_title' => '',
        'section_description' => '',
        'blog_posts_no' => '',
        'blog_posts_title_no' => '',
                    ), $atts));
    if (isset($atts['blog_posts']) && $atts['blog_posts'] != '') {
        $rows = vc_param_group_parse_atts($atts['blog_posts']);
        $cats_arr = array();
        if (count((array) $rows) > 0) {
            foreach ($rows as $row) {
                $cats_arr[] = $row['categories'];
            }
        }
    }

    $cat_tax = '';
    $all_tax = isset($cats_arr[0]) ? $cats_arr[0] : '';

    if (!empty($cats_arr) && $all_tax != "all") {

        $cat_tax = array(
            'taxonomy' => 'category',
            'field' => 'slug',
            'terms' => $cats_arr,
        );
    }
    /* Post Numbers */
    $section_post_no = (isset($blog_posts_no) && $blog_posts_no != "") ? $blog_posts_no : "6";
    /* Post Orders */
    $section_post_ordr = (isset($blog_posts_order) && $blog_posts_order != "") ? $blog_posts_order : "ASC";
    $args = array(
        'posts_per_page' => $section_post_no,
        'post_type' => 'post',
        'order' => $section_post_ordr,
        'tax_query' => array(
            $cat_tax
        ),
    );
    $the_query = new WP_Query($args);
    $blogs_html = '';
    if ($the_query->have_posts()) {
        $num = 1;
        while ($the_query->have_posts()) {
            $the_query->the_post();
            $pid = get_the_ID();
            $author_id = get_post_field('post_author', $pid);
            /* Post Title Limit */
            $blog_posts_title_limit = "3";
            if (isset($blog_posts_title_no) && $blog_posts_title_no != "") {
                $blog_posts_title_limit = $blog_posts_title_no;
            }

            $thumb_html = '';
            if (has_post_thumbnail()) {
                $thumb_html = '<div class="img-box">
                    <a href="' . esc_url(get_the_permalink($pid)) . '"> ' . get_the_post_thumbnail($pid, 'nokri_post_standard', array('class' => 'img-responsive')) . ' </a>
                </div>';
            }
            $blogs_html .= '<div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                        <div class="news-card">
                            <div class="img-box">
                                ' . $thumb_html . '
                                <div class="issue-date">
                                    <span>' . get_the_time(get_option('date_format')) . '</span>
                                </div>
                            </div>
                            <div class="card-meta">
                                <a href="' . esc_url(get_the_permalink($pid)) . '"><h4 class="title">' . get_the_title($pid) . '</h4></a>
                                <p class="txt">Lorem ipsum dolor sit amet, consectetur adipiscing elit, sed do eiusmod tempor incididunt ut labore et dolore magna</p>
                                <a class="btn n-btn-flat news-btn" href="' . esc_url(get_the_permalink($pid)) . '">' . esc_attr__("Read More", "nokri") . '</a>
                            </div>
                        </div>
                    </div>';
//if($num % 3 == 0){$blogs_html .= '<div class="clearfix"></div>';}
            $num++;
        }
        wp_reset_postdata();
    }
    /* Section name */
    $section_title = (isset($section_title) && $section_title != "") ? '' . $section_title . '' : "";
    /* Section desc */
    $section_description = (isset($section_description) && $section_description != "") ? '' . $section_description . '' : "";
    /* Section Color */
    $section_clr = (isset($blog_posts_clr) && $blog_posts_clr != "") ? $blog_posts_clr : "";
    return '<section class="our-latest-news"' . esc_attr($section_clr) . '>
            <div class="container">
                <div class="row">
                    <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                        <div class="nokri-main-meta"> 
                            <h2 class="main-heading">' . $section_title . '</h2>
                            <p class="main-txt">' . $section_description . '</p>
                        </div>
                    </div>
                </div>
                <div class="row">
                 
               ' . $blogs_html . '
              
                </div>
            </div>
        </section>';
}

if (function_exists('nokri_add_code')) {
    nokri_add_code('blog_posts_base_new', 'blog_posts_modern_short_latest_base_func');
}