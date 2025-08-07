<?php
$user_id = get_current_user_id();
global $nokri;
$c_name  = (isset($_GET['c_name']) && $_GET['c_name'] != "") ? sanitize_text_field($_GET['c_name']) : '';
$c_order = (isset($_GET['c_order']) && $_GET['c_order'] != "") ? sanitize_text_field($_GET['c_order']) : 'DESC'; // Default to DESC order

$paged     = (get_query_var('paged')) ? get_query_var('paged') : 1;
$args = array();
// Define args for user query
$args = array(
    'number' => 10, // Number of users to display per page
    'paged'  => $paged,
    'order'  => $c_order,
    'orderby' => 'registered', // Default order by registration date
    'order' => $c_order,
);

// Add search parameter if job_name is set
if ($c_name != '') {
    $args['search'] = '*' . esc_attr($c_name) . '*';
    $args['search_columns'] = array('user_login', 'user_nicename', 'user_email', 'display_name');
}

$users = get_users($args);
           
        ?>
        <div class="cp-loader"></div>
        <div class="dashboard-job-filters">
            <div class="row">
                <form method="GET" id="emp_invited_candidates">
                    <input type="hidden" name="tab-data" value="invited-candidate" >
                    <div class="row">
                    <div class="col-lg-6 col-md-6  col-sm-12">
                        <div class="form-group">
                            <label class=""><?php echo esc_html__('Name', 'nokri'); ?></label>
                            <input type="text" value="<?php echo esc_html($c_name); ?>" <?php
                            if ($order == 'ASC') {
                                echo esc_attr("selected");
                            };
                            ?> class="form-control" name="c_name" placeholder="<?php echo esc_attr__('Keyword or Name', 'nokri'); ?>">
                        </div>
                    </div>
                    <div class="col-lg-6 col-md-6 col-sm-12">
                        <div class="form-group">
                            <label class=""><?php echo esc_html__('Sort by', 'nokri'); ?> </label>
                            <select class="js-example-basic-single emp_invited_candidates" name="c_order">
                                <option value=""><?php echo esc_html__('Select an option', 'nokri'); ?></option>
                                <option value="ASC" <?php
                                if ($c_order == 'ASC') {
                                    echo esc_attr("selected");
                                };
                                ?>><?php echo esc_html__('ASC', 'nokri'); ?></option>
                                <option value="DESC" <?php
                                if ($c_order == 'DESC') {
                                    echo esc_attr("selected");
                                };
                                ?>><?php echo esc_html__('DESC', 'nokri'); ?></option>
                            </select>
                        </div>
                    </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="main-body">
            <div class="dashboard-job-stats followers">
                <h4><?php echo esc_html__('Invited Candidates', 'nokri'); ?></h4>
                <div class="dashboard-posted-jobs">
                    <div class="posted-job-list resume-on-jobs header-title">
                        <ul class="list-inline">
                            <li class="resume-id"><?php echo esc_html__('Id', 'nokri'); ?></li>
                            <li class="posted-job-title"> <?php echo esc_html__('Candidate Name', 'nokri'); ?></li>
                            <li class="posted-job-expiration"> <?php echo esc_html__('Invited Jobs', 'nokri'); ?></li>
                            <li class="posted-job-action"> <?php echo esc_html__('Profile Link', 'nokri'); ?></li>
                        </ul>
                    </div>
                    <?php
                    $count = 1;
                        if (!empty($users)) {
                            foreach ($users as $user) {
                                $cand_id = $user->ID;
                                $cand_name = $user->display_name;
                                $pid = get_user_meta($user_id, 'invite_candidate_' . $cand_id, true);

                                if($pid){
                                    
                                    echo '<div class="posted-job-list resume-on-jobs" id="company-box-' . esc_attr($cand_id) . '">
                                            <ul class="list-inline">
                                                <li class="resume-id">' . esc_attr($count) . '</li>
                                                <li class="posted-job-title">
                                                    <div class="posted-job-title-meta">
                                                        <a href="' . esc_url(get_author_posts_url($cand_id)) . '">' . $cand_name . '</a>
                                                    </div>
                                                </li>';
                                                
                                    // Check if $pid is an array and iterate through each post ID
                                    if (is_array($pid) && !empty($pid)) {
                                        $total_jobs = '';
                                        foreach ($pid as $post_id) {
                                            $total_jobs .= '<li><a href="' . esc_url(get_the_permalink($post_id)) . '">' . esc_html(get_the_title($post_id)) . '</a></li>';
                                        }
                                        $allowed_html = array(
                                            'ul' => array(),
                                            'li' => array(),
                                            'a' => array(
                                                'href' => true,  // Allow the 'href' attribute in <a> tags
                                            ),
                                        );
                                        echo '<li class="posted-job-expiration"><ul>' . wp_kses($total_jobs, $allowed_html) . '</ul></li>';
                                    }
                                    

                                    echo '<li class="posted-job-action"><a href="' . esc_url(get_author_posts_url($cand_id)) . '" class="btn btn-custom"> ' . esc_html__('View Profile', 'nokri') . ' </a></li>
                                        </ul>
                                    </div>';
                                    $count++;
                                }
                            }
                        } else { 
                            echo '<div class="dashboard-posted-jobs">
                                    <div class="notification-box">
                                        <div class="notification-box-icon"><span class="ti-info-alt"></span></div>
                                        <h4>' . esc_html__('No Candidate found', 'nokri') . '</h4>
                                    </div>
                                </div>';
                        }