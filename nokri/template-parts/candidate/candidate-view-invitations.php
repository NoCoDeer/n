<?php
$user_id = get_current_user_id();
/* Candidate Job Notifications */
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$posts_per_page= 10;
// The main query for fetching jobs with pagination
$args = array(
    'post_type' => 'job_post',
    'orderby' => 'date',
    'order' => 'ASC',
    'posts_per_page' => 20, // Limit to 20 per page
    'paged' => $paged,
    'post_status' => array('publish'),
    'meta_query' => array(
        array(
            'key' => '_job_status',
            'value' => 'active',
            'compare' => '=',
        ),
    ),
);

$args = nokri_wpml_show_all_posts_callback($args);
$query = new WP_Query($args);
$notification = '';
if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $job_id = get_the_ID();
        $post_author_id = get_post_field('post_author', $job_id);
        $company_name = get_the_author_meta('display_name', $post_author_id);
        $candidate_name = get_the_author_meta('display_name', $user_id); // Fetch candidate name
        $job_skills = wp_get_post_terms($job_id, 'job_skills', array("fields" => "ids"));
        $cand_skills = get_user_meta($user_id, '_cand_skills', true);
        if (is_array($job_skills) && is_array($cand_skills)) {
            $final_array = array_intersect($job_skills, $cand_skills);
            if (count($final_array) > 0) {
                $post_date = get_the_date('Y-m-d', $job_id);
                $expiry_date = get_post_meta($job_id, '_job_date', true);
                $notification .= '<tr>
                                     <td><a href="' . esc_url(get_the_permalink($job_id)) . '">' . esc_html(get_the_title()) . '</a></td>
                                     <td>' . esc_html($company_name) . '</td>
                                     <td>' . esc_html($candidate_name) . '</td>
                                     <td>' . esc_html($post_date) . '</td>
                                     <td>' . esc_html($expiry_date) . '</td>
                                  </tr>';
            }
        }
    }
    wp_reset_postdata();
    ?>
    <div class="cp-loader"></div>
    <div class="main-body">
        <div class="notification-area">
            <h4><?php echo esc_html__('All Jobs Invitations', 'nokri'); ?></h4>
            <div class="notif-box">
                <table class="table">
                    <thead>
                        <tr>
                            <th><?php echo esc_html__('Job Title', 'nokri'); ?></th>
                            <th><?php echo esc_html__('Sender', 'nokri'); ?></th>
                            <th><?php echo esc_html__('Receiver', 'nokri'); ?></th>
                            <th><?php echo esc_html__('Post Date', 'nokri'); ?></th>
                            <th><?php echo esc_html__('Expiry Date', 'nokri'); ?></th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php echo nokri_returnEcho($notification); ?>
                    </tbody>
                </table>
            </div>
            <?php if ($query->max_num_pages > 1) { // Only show pagination if there is more than one page ?>
                <div class="pagination-box clearfix">
                    <?php echo wp_kses(nokri_job_pagination($query), get_allowed_html_tags()); ?>
                </div>
            <?php } ?>
        </div>
    </div>
    <?php
} else {
    ?>
    <div class="alert alert-info alert-dismissable alert-style-1">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="ti-info-alt"></i><?php echo esc_html__('You have no invitations yet', 'nokri'); ?>
    </div>
    <?php
}
?>
