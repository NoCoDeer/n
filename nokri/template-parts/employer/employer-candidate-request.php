
<?php
global $nokri;
$paged = ( get_query_var('paged') ) ? get_query_var('paged') : 1;
/* required message */
$req_mess = esc_html__('* This value is required *', 'nokri');
$args = array(
    'post_type' => 'candidate_request',
    'posts_per_page' => 10,
    'paged' => $paged,
    'post_status' => 'publish',
    'orderby' => 'date',
    'order' => 'DESC',
);

$query = new WP_Query($args);
?>
                     
    <!-- Modal -->
    <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog  modal-lg" role="document">
    <div class="modal-content">
        <div class="modal-header">
            <h4 class="modal-title d-inline" id="exampleModalLabel">Job Posting Form</h4>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
        </div>
    <div class="modal-body">
        <form id="jobPostingForm" enctype="multipart/form-data">
            <?php wp_nonce_field( 'nokri_candidate_request' ); ?>
            <div class="row">
                <div class="col-md-6">
                <div class="form-group">
                <label for="Project_name"><?php echo esc_html__( 'Project Name', 'nokri' ); ?></label>
                <input type="text" name="project_name" id="project_name" value="" data-parsley-required="true" class="widefat form-control" data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>" />
                </div>
                <div class="form-group">
                <label><?php echo esc_html__('Project Description', 'nokri'); ?></label>
                <textarea id="project_description" name="project_description" data-parsley-required="true" class="form-control jquery-textarea my_texteditor"  data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>" rows="10" cols="115" ></textarea>
                </div>
                <!-- Job Skills -->
                <div class="form-group">
                <label for="skills"><?php echo esc_html__( 'Skills', 'nokri' ); ?></label>
                 <select name="job_skills" id="job_skills" class="form-control">
                <?php foreach ( get_skills_options() as $key => $value ) : ?>
                <option value="<?php echo esc_attr( $key ); ?>">
                <?php echo esc_html( $value ); ?>
                </option>
                <?php endforeach; ?>
                </select>
                </div>
                <!-- Project Duration -->
                <div class="form-group">
                <label for="project_duration">Project Duration</label>
                <select id="project_duration" name="project_duration" class="form-control">
                    <?php foreach ( get_project_duration_options() as $key => $value ) : ?>
                        <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
                    <?php endforeach; ?>
                </select>
                </div>
                <!-- Minimum Hours Per Day -->
                <div class="form-group">
                    <label for="min_hours">Minimum Hours Per Day</label>
                    <select id="min_hours" name="min_hours" class="form-control">
                        <?php foreach ( get_min_hours_options() as $key => $value ) : ?>
                            <option value="<?php echo esc_attr( $key ); ?>"><?php echo esc_html( $value ); ?></option>
                        <?php endforeach; ?>
                    </select>
                </div>
                <!-- Payment Basis -->
                <div class="form-group">
                    <label for="payment_basis">Payment Basis</label>
                    <select id="payment_basis" name="payment_basis" class="form-control">
                        <?php
                        $payment_basis_options = get_payment_basic_options();
                        foreach ( $payment_basis_options as $key => $value ) {
                            echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
                        }
                        ?>
                    </select>
                </div>
            </div>
                <div class="col-md-6 ">
                    <!-- Compensation Type -->
                    <div class="form-group">
                        <label for="compensation_type">Compensation Type</label>
                        <select id="compensation_type" name="compensation_type" class="form-control">
                            <?php
                            $compensation_type_options = get_compensation_type_options();
                            foreach ( $compensation_type_options as $key => $value ) {
                                echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
                            }
                            ?>
                        </select>
                    </div>           
                    <!-- Compensation -->
                    <div class="form-group">
                        <label for="compensation">Compensation*</label>
                        <input type="text" id="compensation" name="compensation" class="form-control" data-parsley-required="true">
                    </div>
                    <!-- Compensation Details -->
                    <div class="form-group">
                        <label for="compensation_details">Compensation Details</label>
                        <input type="text" id="compensation_details" name="compensation_details" class="form-control">
                    </div> 
                    <!-- Project Type ----->
                    <div class="form-group">
                        <label for="project_type">Project Type</label>
                            <select id="project_type" name="project_type" class="form-control">
                                <?php
                                $project_type_options = get_project_type_options();
                                foreach ( $project_type_options as $key => $value ) {
                                    echo '<option value="' . esc_attr( $key ) . '">' . esc_html( $value ) . '</option>';
                                }
                                ?>
                            </select>
                    </div>
                    <!-- Doc file -->
                    <div class="form-group">
                    <label for="jobFile">Upload Job Description File</label>
                    <input type="file" class="form-control" id="job_file" name="job_file" accept=".pdf,.doc,.docx,.txt">
                    </div>
                    <!-- Email -->
                    <div class="form-group">
                        <label>Email</label>
                        <input type="email" id="email" name="email" class="form-control" data-parsley-required="true" placeholder="Enter Email..." data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>" />
                    </div>
                    <!-- Phone No. -->
                    <div class="form-group">
                        <label>Phone No.</label>
                        <input type="phone" id="phone" name="phone" class="form-control" data-parsley-required="true" placeholder="Enter Phone No...." data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>" />
                    </div>
                    <div class="text-right">
                        <button type="button" class="btn btn-default" data-dismiss="modal">Close</button>
                        <button type="button" id="sendInvite" class="btn btn-primary submit-job">Submit</button>
                    </div>
                    </div>
                </div> 
            </form>
        <div id="response"></div>
    </div>
</div>
</div>
</div>
<!-- Custom Modal End -->
<div class="main-body">
<div class="dashboard-job-stats">
    <div class="candidate-request-title">
    <h4 class="candidate-heading"><?php echo esc_html__('Candidate Requests', 'nokri'); ?></h4>
    <button type="button" class="btn n-btn-flat" data-bs-toggle="modal" data-bs-target="#exampleModal">Job Posting </button>
    </div>      
    <div class="dashboard-posted-jobs">
    <div class="posted-job-list header-title">
        <ul class="list-inline">
            <li class="posted-job-title"><?php echo esc_html__('Job Title', 'nokri'); ?></li>
            <li class="posted-job-status"><?php echo esc_html__('Status', 'nokri'); ?></li>
            <li class="posted-job-expiration"><?php echo esc_html__('Posted Date', 'nokri'); ?></li>
            <li class="posted-job-action"><?php echo esc_html__('Action', 'nokri'); ?></li>
        </ul>
    </div>
    <?php
    if ($query->have_posts()) {
    while ($query->have_posts()) {
        $query->the_post();
        $post_id = get_the_ID();
        $project_name = get_post_meta($post_id, '_project_name', true);
        $status = get_post_meta($post_id, '_job_status', true);
        $posted_date = get_the_date();

        if (empty($status)) {
            $status = 'Pending'; // Default status
        }
    ?>
    <div class="posted-job-list">
    <ul class="list-inline">
        <li class="posted-job-title"><a><?php echo esc_html($project_name); ?></a>
        <p><strong>Posted Date: </strong><?php echo esc_html($posted_date) ;?></p></li>
        <li class="posted-job-status"><span class="label label-success "><?php echo esc_html($status); ?></span></li>
        <li class="posted-job-expiration"><?php echo esc_html($posted_date); ?></li>
        <li class="posted-job-action">
        <ul class="list-inline">
            <li data-title="Edit Job">
                <a href="#" class="edit-post post-action" data-post-id="<?php echo esc_attr($post_id); ?>"><i class="ti-pencil-alt"></i></a>
            </li>
            <li data-title="Delete Job">
                    <a href="#" class="delete-post post-action" data-post-id="<?php echo esc_attr($post_id); ?>"><i class="ti-trash"></i></a>
            </li>
        </ul>
        </li>
    </ul>
    </div>
    <?php
    }
    wp_reset_postdata();
    } else {
    ?>
    <div class="dashboard-posted-jobs">
        <div class="notification-box">
            <h4><?php echo esc_html__('No candidate requests found.', 'nokri'); ?></h4>
        </div>
    </div>
    <?php
}
?>
</div>

<div class="pagination-box clearfix">
<?php echo nokri_job_pagination($query); ?>
</div>
</div>
</div>

<!-- Modal -->
<div class="modal fade" id="editModal" tabindex="-1" role="dialog" aria-labelledby="editModalLabel" aria-hidden="true">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h4 class="modal-title" id="editModalLabel">Edit Job Posting</h4>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">
                <form id="editForm"  enctype="multipart/form-data">
                    <div class="row">
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="project_name">Project Name</label>
                        <input type="text" class="form-control" id="p_name" name="p_name" data-parsley-required="true" data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                    </div>
                    <div class="form-group">
                        <label for="project_description">Project Description</label>
                        <textarea class="form-control" id="p_description" name="p_description" data-parsley-required="true" data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>"></textarea>
                    </div>
                    <div class="form-group">
                        <label for="skills">Job Skills</label>
                        <input type="text" class="form-control" id="j_skills" name="j_skills">
                    </div>
                    <div class="form-group">
                        <label for="project_duration">Project Duration</label>
                        <input type="text" class="form-control" id="p_duration" name="p_duration">
                    </div>
           
                    <div class="form-group">
                        <label for="min_hours">Minimum Hours</label>
                        <input type="text" class="form-control" id="m_hours" name="m_hours">
                    </div>
                    <div class="form-group">
                        <label for="payment_basis">Payment Basis</label>
                        <input type="text" class="form-control" id="pay_basis" name="pay_basis">
                    </div>
                    
                    <div class="form-group">
                        <label for="compensation_type">Compensation Type</label>
                        <input type="text" class="form-control" id="comp_type" name="comp_type">
                    </div>
                    </div>
                    <div class="col-md-6">
                    <div class="form-group">
                        <label for="compensation">Compensation</label>
                        <input type="text" class="form-control" id="comp" name="compensation">
                    </div>
                    <div class="form-group">
                        <label for="compensation_details">Compensation Details</label>
                        <input type="text" class="form-control" id="comp_details" name="comp_details">
                    </div>
                    <div class="form-group">
                        <label for="project_type">Project Type</label>
                        <input type="text" class="form-control" id="p_type" name="p_type">
                    </div>
                    <div class="form-group">
                        <label for="add_email">Email</label>
                        <input type="email" class="form-control" id="add_email" name="email" data-parsley-required="true" data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" class="form-control" id="phone_no" name="phone_no" data-parsley-required="true" data-parsley-error-message="<?php echo '' . esc_attr($req_mess); ?>">
                    </div>
                    <div class="form-group">
                        <label for="job_file">Job File</label>
                        <input type="file" id="upload_file" name="upload_file" class="form-control" accept=".pdf,.doc,.docx,.txt">
                        <!-- Link to the existing file -->
                        <a id="existing_job_file" href="" target="_blank" style="display: none;"></a>
                    </div>
                    <div>
                    <button type="submit" id="saveChanges" class="btn btn-primary">Save changes</button>
                    </div>
                    </div>
                    </div>
                    <input type="hidden" id="post_id" name="post_id">
                </form>
            </div>
        </div>
    </div>
</div>