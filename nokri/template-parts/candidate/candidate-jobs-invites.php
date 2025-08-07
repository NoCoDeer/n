<?php
global $nokri; 
$current_id   =  get_current_user_id();
$c_name  = (isset($_GET['comp_title']) && $_GET['comp_title'] != "") ? sanitize_text_field($_GET['comp_title']) : '';
$c_order = (isset($_GET['comp_order']) && $_GET['comp_order'] != "") ? sanitize_text_field($_GET['comp_order']) : 'DESC'; // Default to DESC order

$paged     = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array();
// Define args for user query
$args = array(
    'number' => 10, // Number of users to display per page
    'paged'  => $paged,
    'order'  => $c_order,
    'orderby' => 'registered',
);

// Add search parameter if job_name is set
if ($c_name != '') {
    $args['search'] = '*' . esc_attr($c_name) . '*';
    $args['search_columns'] = array('user_login', 'user_nicename', 'user_email', 'display_name');
}

$users = get_users($args);

?>
 <div class="dashboard-job-filters">
    <div class="row">
      <form role="search"  id="candidate_job_invites" method="get" class="candidate_job_invites">
        <div class="col-md-6 col-xs-12 col-sm-6">
        <input type="hidden" name="candidate-page" value="jobs-invites" >
            <div class="form-group">
                <label ><?php echo esc_html__('Name', 'nokri' ); ?></label>
                <input type="text" name="comp_title" value="<?php  ?>"  class="form-control" placeholder="<?php echo esc_attr__('Keyword or Name', 'nokri' ); ?>">
                 <a href="javascript:void(0)" class="a-btn search_company"><i class="ti-search"></i></a>
            </div>
        </div>
        <div class="col-md-6 col-xs-12 col-sm-6">
            <div class="form-group">
                <label><?php echo esc_html__('Sort by', 'nokri' ); ?> </label>
                <select class="select-generat form-control candidate_job_invites" name="comp_order">
                    <option value=""><?php echo esc_html__('Select an option', 'nokri'); ?></option>
                    <option value="ASC" <?php if ( $order == 'ASC') { echo "selected"; } ; ?>><?php echo esc_html__('ASC', 'nokri' ); ?></option>
                    <option value="DESC" <?php if ( $order == 'DESC') { echo "selected"; } ; ?>><?php echo esc_html__('DESC', 'nokri' ); ?></option>
                </select>
            </div>
        </div>
        <?php echo nokri_form_lang_field_callback(true); ?>
        </form>
    </div>
</div>
 <div class="main-body">
<div class="dashboard-job-stats followers">
    <h4><?php echo esc_html__('Jobs Invited', 'nokri' ); ?></h4>
    <div class="dashboard-posted-jobs">
        <div class="posted-job-list resume-on-jobs header-title">
            <ul class="list-inline">
                <li class="resume-id"><?php echo esc_html__('#', 'nokri' ); ?></li>
                <li class="posted-job-title"><?php echo esc_html__('Company Name', 'nokri' ); ?></li>
                <li class="posted-job-expiration"><?php echo esc_html__('Invited Jobs', 'nokri' ); ?></li>
                <li class="posted-job-action"><?php echo esc_html__('Profile Link', 'nokri' ); ?></li>
                
            </ul>
        </div>
        
        <?php
        $count = 1;
        if (!empty($users)) {
            foreach ($users as $user) {
                $emp_id = $user->ID;
                $cand_name = $user->display_name;
                $pid = get_user_meta($emp_id, 'invite_candidate_' . $current_id, true);
                $image_link[0] =  get_template_directory_uri(). '/images/candidate-dp.jpg';
                if( isset( $nokri['nokri_user_dp']['url'] ) && $nokri['nokri_user_dp']['url'] != "" )
                {
                    $image_link = array($nokri['nokri_user_dp']['url']);	
                }
                if( get_user_meta($emp_id, '_sb_user_pic', true ) != "" )
                {
                    $attach_id =	get_user_meta($emp_id, '_sb_user_pic', true );
                    $image_link = wp_get_attachment_image_src( $attach_id, 'nokri_job_post_single' );
                }

                if($pid){
                    
                    echo '<div class="posted-job-list resume-on-jobs" id="company-box-' . esc_attr($current_id) . '">
                            <ul class="list-inline">
                                <li class="resume-id">' . esc_attr($count) . '</li>
                                <li class="posted-job-title">';?>
                                <?php if (esc_url($image_link[0])) { ?>
                                    <div class="posted-job-title-img">
                                        <a href="<?php echo esc_url(get_author_posts_url($emp_id)); ?>"><img src="<?php echo esc_url($image_link[0]); ?>" class="img-responsive img-circle" alt="<?php echo esc_attr__('company Image', 'nokri'); ?>"></a>
                                    </div> 
                                    <?php } ?> 
                                    <div class="posted-job-title-meta">
                                        <a href="<?php echo esc_url(get_author_posts_url($emp_id));  ?>"><?php echo esc_html(the_author_meta( 'display_name', $emp_id )); ?> </a>
                                        <p><?php echo esc_html(get_user_meta($emp_id, '_user_headline', true )); ?></p>
                                    </div>
                                </li>
                        <?php          
                                
                    // Check if $pid is an array and iterate through each post ID
                    if (is_array($pid) && !empty($pid)) {
                        $total_jobs = '';
                        foreach ($pid as $post_id) {
                            $total_jobs .= '<li><a href="' . esc_url(get_the_permalink($post_id)) . '">' . esc_html(get_the_title($post_id)) . '</a></li>';
                        }
                        echo '<li class="posted-job-expiration"><ul>' . $total_jobs . '</ul></li>';
                    }

                    echo '<li class="posted-job-action"><a href="' . esc_url(get_author_posts_url($emp_id)) . '" class="btn btn-custom"> ' . esc_html__('View Profile', 'nokri') . ' </a></li>
                        </ul>
                    </div>';
                    $count++;
                }
                 }


                // Pagination
                echo '<div class="pagination-box clearfix">
                        <ul class="pagination">';
                echo nokri_user_pagination($pages_number, $page);
                echo '  </ul>
                    </div>';
        } else { 
            echo '<div class="dashboard-posted-jobs">
                    <div class="notification-box">
                        <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
                        <h4>' . esc_html__('No Jobs Invites', 'nokri') . '</h4>
                    </div>
                </div>';
        }