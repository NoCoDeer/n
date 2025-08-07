<?php

/* -------------- */
/* Featured candidates 4 */
/* ------------ */
if (!function_exists('featured_candidates4')) {

    function featured_candidates4() {
        vc_map(array(
            "name" => __("Featured Candidates 4", 'nokri'),
            "base" => "featured_candidates4_base",
            "category" => __("Theme Shortcodes", 'nokri'),
            "params" => array(
                array(
                    'group' => __('Shortcode Output', 'nokri'),
                    'type' => 'custom_markup',
                    'heading' => __('Shortcode Output', 'nokri'),
                    'param_name' => 'order_field_key',
                    'description' => nokri_VCImage('featured_candidates4.png') . __('Ouput of the shortcode will be look like this.', 'nokri'),
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
                    "type" => "dropdown",
                    "heading" => esc_html__("Select candidate type", 'nokri'),
                    "param_name" => "candidate_type",
                    "admin_label" => true,
                    "value" => array(
                        esc_html__('Select Option', 'nokri') => '',
                        esc_html__('Featured', 'nokri') => '1',
                        esc_html__('Simple', 'nokri') => '0',
                    ),
                ),
            ),
        ));
    }

}
add_action('vc_before_init', 'featured_candidates4');
if (!function_exists('featured_candidates4_base_func')) {

    function featured_candidates4_base_func($atts, $content = '') {
        extract(shortcode_atts(array(
            'section_title' => '',
            'section_desc' => '',
            'link' => '',
            'candidate_type' => '',
            'order_by' => '',
                        ), $atts));
        $featured_cand = '';
        if (isset($candidate_type) && $candidate_type == "1") {
            $featured_cand = array(
                'key' => '_is_candidate_featured',
                'value' => '1',
                'compare' => '='
            );
        }
        /* Getting User Meta against Saved Resumes */
        $emp_id = get_current_user_id();
        $resumes = get_user_meta($emp_id, '_emp_saved_resume_' . $emp_id, true);
        $resumesArray = explode(',', $resumes);
        $args = array(
            'order' => 'DESC',
            'meta_query' => array(
                'relation' => 'AND',
                array(
                    'key' => '_sb_reg_type',
                    'value' => '0',
                    'compare' => '='
                ),
                $featured_cand,
            ),
        );
        $user_query = new WP_User_Query($args);
        $authors = $user_query->get_results();
        $required_user_html = $featured = '';
        if (!empty($authors)) {
            $num = 1;
            foreach ($authors as $author) {
                $cand_address = '';
                $user_id = $author->ID;
                $user_name = $author->display_name;
                $cand_add = get_user_meta($user_id, '_cand_address', true);
                $cand_head = get_user_meta($user_id, '_user_headline', true);
                $featured_date = get_user_meta($user_id, '_candidate_feature_profile', true);
                $salary_range = get_user_meta($user_id, '_cand_salary_range', true);
                $salary_curren = get_user_meta($user_id, '_cand_salary_curren', true);
                $today = date("Y-m-d");
                $expiry_date_string = strtotime($featured_date);
                $today_string = strtotime($today);
                if ($today_string > $expiry_date_string) {
                    delete_user_meta($user_id, '_candidate_feature_profile');
                    delete_user_meta($user_id, '_is_candidate_featured');
                }
                if ($cand_head != '') {
                    $cand_head = '<p>' . $cand_head . '</p>';
                }
                if ($cand_add != '') {
                    $cand_address = '<i class="fa fa-map-marker"></i>' . ' ' . $cand_add . '';
                }
                /* Getting Star */
                if (isset($candidate_type) && $candidate_type == "1") {
                    $featured = '<a href=""><i class="fa fa-star rate-icon"></i></a>';
                }
                /* Getting Candidates Ratings  */
                $star_rating = avg_user_rating($user_id);

                if (in_array($user_id, $resumesArray)) {

                    $heart_sign = '<i class="fa fa-heart"></i>';
                } else {
                    $heart_sign = '<i class="fa fa-heart-o"></i>';
                }
                /* Getting Candidates Skills  */
                $skill_tags = nokri_get_candidates_skills_new($user_id, '');
                $required_user_html .= '
                                <div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4">
                                    <div class="profile-card">
                                        <div class="prf-meta">
                                            <img class ="prf-meta-image" src="' . nokri_get_user_profile_pic($user_id, '_cand_dp') . '" alt="' . esc_attr__('image', 'nokri') . '">                                            
                                            <div class="rating">
                                                ' . $star_rating . '
                                            </div>                                           
                                            <a href="' . esc_url(get_author_posts_url($user_id)) . '"><h4 class="name">' . $user_name . '</h4></a>
                                            <span class="skill">' . $cand_head . '</span>
                                                <span class="location"> ' . $cand_address . '</span>                                         
                                            <ul>                                               
                                                    ' . $skill_tags . '
                                            </ul>                                                                                                                  
                                            <div class="favrt-outer">
                                            
                                                <a href="javascript:void(0)" class="saving_resume" data-cand-id="' . esc_attr($user_id) . '">' . $heart_sign . '</a>
                                            </div>
                                            <div class="rate-box"></div>
                                            ' . $featured . '
                                        </div>
                                        <div class="prf-btn">
                                            <a class="view-prf" href="' . esc_url(get_author_posts_url($user_id)) . '">' . esc_html__('View Profile', 'nokri') . '</a>
                                        </div>
                                        </div>
                                    </div>';
                if ($num % 3 == 0) {
                    $required_user_html .= '<div class="clearfix"></div>';
                }
                $num++;
            }
        }
        /* Section title */
        $section_title = (isset($section_title) && $section_title != "") ? '' . $section_title . '' : "";
        /* Section description */
        $section_descrp = (isset($section_desc) && $section_desc != "") ? '' . $section_desc . '' : "";
        return'<section class="featured-candidates">
                <div class="container">
                    <div class="row">
                        <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                            <div class="nokri-main-meta"> 
                                <h2 class="main-heading">' . $section_title . '</h2>
                                <p class="main-txt">' . $section_descrp . '</p>
                            </div>
                        </div>
                    </div>
                <div class="row">                  
                        ' . $required_user_html . '             
                </div>
            </div>
        </section>';
    }

}

if (function_exists('nokri_add_code')) {
    nokri_add_code('featured_candidates4_base', 'featured_candidates4_base_func');
}    