<?php
$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;
$user_id = get_current_user_id();
function get_invited_jobs($paged) {
    $args = array(
        'post_type' => 'job_post',
        'post_status' => 'publish',
        'orderby' => 'date',
        'order' => 'DESC',
        'posts_per_page' => -1, // Get all posts and paginate manually
        'meta_query' => array(
            array(
                'key' => 'invite_data',
                'compare' => 'EXISTS',
            ),
        ),
    );
    $query = new WP_Query($args);
    $job_list = array();

    if ($query->have_posts()) {
        while ($query->have_posts()) {
            $query->the_post();
            $job_id = get_the_ID();
            $invite_data_array = get_post_meta($job_id, 'invite_data');

            if (!empty($invite_data_array)) {
                foreach ($invite_data_array as $invite_data) {
                    $invite_data = maybe_unserialize($invite_data);
                    if (is_array($invite_data) && isset($invite_data['candidate_id'])) {
                        $applier_id = $invite_data['candidate_id'];
                        $employer_id = isset($invite_data['employer_id']) ? $invite_data['employer_id'] : null;
                       
                        $invite_time = isset($invite_data['invite_time']) ? $invite_data['invite_time'] : '';
                        $job_expiry = get_post_meta($job_id, '_job_date', true);

                        $applier = get_user_by('id', $applier_id);
                        $employer = $employer_id ? get_user_by('id', $employer_id) : null;

                        $applier_name = $applier ? $applier->display_name : 'Unknown Candidate';
                        $employer_name = $employer ? $employer->display_name : 'Unknown Employer';

                        $job_list[] = array(
                            'job_id' => $job_id,
                            'job_title' => get_the_title($job_id),
                            'applier_id' => $applier_id,
                            'applier_name' => $applier_name,
                            'employer_id' => $employer_id,
                            'employer_name' => $employer_name,
                            'invite_time' => date_i18n(get_option('date_format'), strtotime($invite_time)),
                            'job_expiry' => date_i18n(get_option('date_format'), strtotime($job_expiry)),
                        );
                    }
                }
            }
        }
        wp_reset_postdata();
    }
    $jobs_per_page = 10;
    $total_jobs = count($job_list);
    $total_pages = ceil($total_jobs / $jobs_per_page);
    $offset = ($paged - 1) * $jobs_per_page;
    $paged_jobs = array_slice($job_list, $offset, $jobs_per_page);

    return array(
        'jobs' => $paged_jobs,
        'total_pages' => $total_pages,
        'current_page' => $paged,
        'total_jobs' => $total_jobs,
    );
}

$paged = (get_query_var('paged')) ? get_query_var('paged') : 1;

$job_data = get_invited_jobs($paged);
$job_list = $job_data['jobs'];
$total_pages = $job_data['total_pages'];
$current_page = $job_data['current_page'];
$total_jobs = $job_data['total_jobs'];

if (!empty($job_list)) { ?>
   <div class="cp-loader"></div>
   <div class="main-body">
    <div class="notification-area">
        <h4><?php echo esc_html__('All  Invitations', 'nokri'); ?></h4>
        <table class="table">
            <thead class="dashboard-posted-jobs posted-job-list">
                <tr>
                    <th><?php echo esc_html__('Job Title', 'nokri'); ?></th>
                    <th><?php echo esc_html__('Employer', 'nokri'); ?></th>
                    <th><?php echo esc_html__('Candidate', 'nokri'); ?></th>
                    <th><?php echo esc_html__('Invite Date', 'nokri'); ?></th>
                    <th><?php echo esc_html__('Job Expiry', 'nokri'); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($job_list as $job) : ?>
                    <tr>
                        <td><?php echo esc_html($job['job_title']); ?></td>
                        <td><?php echo esc_html($job['employer_name']); ?></td>
                        <td><?php echo esc_html($job['applier_name']); ?></td>
                        <td><?php echo esc_html($job['invite_time']); ?></td>
                        <td><?php echo esc_html($job['job_expiry']); ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
        <?php if ($total_jobs > 10) { // Only show pagination if there are more than 10 jobs ?>
        <div class="pagination-box clearfix">
            <?php
              $allowed_html = array(
                'ul' => array(
                    'class'=> true,
                ),
                'li' => array(),
            );
            echo wp_kses(nokri_job_pagination((object) array('max_num_pages' => $total_pages)), $allowed_html);
            ?>
        </div>
        <?php } ?>
    
    </div>
    </div>

<?php } else { ?>
    <div class="alert alert-info alert-dismissable alert-style-1">
        <button type="button" class="close" data-dismiss="alert" aria-hidden="true">&times;</button>
        <i class="ti-info-alt"></i><?php echo esc_html__('No Notifications', 'nokri'); ?>
    </div>
<?php } ?>

