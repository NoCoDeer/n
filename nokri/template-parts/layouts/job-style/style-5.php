<?php require trailingslashit(get_template_directory()) . "/template-parts/layouts/job-style/job-informations.php"; ?>
<section class="n-single-job n-single-job-transparent"<?php echo esc_attr(nokri_returnEcho($bg_url)); ?>></section>
<?php
          $signin_page = '';
            if ((isset($nokri['sb_sign_in_page'])) && $nokri['sb_sign_in_page'] != '') {
                $signin_page = ($nokri['sb_sign_in_page']);
            }

        ?>
         <input type="hidden" name="page-login" id="page-login" value=<?php echo esc_url(get_the_permalink($signin_page));?>>
<!-- about-job-detail-start -->
<section class="about-company-prf-dtl about-job-detail">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 col-xxl-8">
                <div class="job-detail-box">
                    <?php
                    $work_remotely = nokri_work_location_custom($job_id);

                    if ($work_remotely != "") {

                        $job_location = $work_remotely;
                    } else {

                        $job_location = $countries_last;
                    }
                    ?>
                    <div class="job-type">
                        <div class="job-name">
                            <?php echo nokri_returnEcho($job_badge_ul); ?>
                            <h1 class="heading"><?php esc_html(the_title()); ?></h1>
                        </div>
                        <div class="direct-link">
                            <?php
                            /* Candidate Report against job to Admin */
                            $report_btn = isset($nokri['_nokri_cand_report_job']) ? $nokri['_nokri_cand_report_job'] : false;
                            if ($report_btn == true) {
                                $user_type = get_user_meta($user_id, '_sb_reg_type', true) == '0';
                                if (is_user_logged_in() && $user_type) {
                                    ?>
                                    <div class="link">
                                        <a class="job-report nk-report" href="javascript:void(0)" data-user-id = <?php echo esc_attr($user_id); ?> data-job-id=<?php echo esc_attr($job_id); ?>><i class="fa fa-exclamation-triangle" title="<?php echo esc_attr__('Report this Job', 'nokri'); ?>"></i></a>
                                    </div>
                                    <?php
                                }
                            }
                            ?>
                            <div class="link">
                                <a class="save_job nk-save-job" href="javascript:void(0)" data-value=<?php echo esc_attr($job_id); ?>><i class="fa fa-bookmark"title="<?php echo esc_attr__('Save this Job', 'nokri'); ?>"></i></a>
                            </div>
                            <?php if ($is_email_job) { ?>
                                <div class = "link">
                                    
                                    <a class="email_this_job nk-message" href="javascript:void(0)" data-job-id=<?php echo esc_attr($job_id); ?>><i class = "fa fa-envelope" title="<?php echo esc_attr__('Email this Job', 'nokri'); ?>"></i></a>
                                </div>
                            <?php } ?>
                        </div>
                    </div>
                    <div class = "job-detail-list">
                        <ul>
                            <?php if (!empty($job_type)) {
                                ?>
                                <li>
                                    <div class="list-item">
                                        <h5><?php echo esc_html('Job Type :', 'nokri'); ?> </h5>
                                        <span><?php echo esc_html(nokri_job_post_single_taxonomies('job_type', $job_type)); ?></span>
                                    </div>
                                </li>
                            <?php } if (isset($nokri['allow_job_countries']) && $nokri['allow_job_countries'] != 'hide') { ?>
                                <li>
                                    <div class="list-item">
                                        <h5><?php echo esc_html('Location :', 'nokri'); ?></h5>
                                        <span><?php echo "" . $job_location; ?></span>
                                    </div>
                                </li>
                            <?php } ?>
                            <li>
                                <div class="list-item">
                                    <h5><?php echo esc_html('Posted :', 'nokri'); ?></h5>
                                    <span><?php echo esc_html(nokri_time_ago()); ?></span>
                                </div>
                            </li>
                            <?php if (!empty($project)) {?>
                            <li>
                                <div class="list-item">
                                    <h5><?php echo esc_html('Category :', 'nokri'); ?></h5>
                                    <span><?php echo '' . $project; ?></span>
                                </div>
                            </li>
                            <?php }?>
                        </ul>
                    </div>
                </div>
                <div class="advrimg">
                    <?php echo '' . ($advert_up); ?>
                </div>
                <!-- Custom fields for the Job Extra Details -->
                <?php if (!empty($job_salary) || !empty($job_shift) || !empty($job_vacancy) || !empty($job_level) || !empty($job_experience) || !empty($job_qualifications)) { ?>
                    <div class="n-detail-transparent">             
                        <div class="about-company">
                            <div class="n-single-meta-2">
                                <h4><?php echo esc_html__('Job Information', 'nokri'); ?></h4>
                                <ul class="">
                                    <?php if (!empty($job_salary)) { ?>
                                        <li>
                                            <div class="short-detail-icon">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/tick-icon.png'); ?>" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                            </div>
                                            <div class="short-detail-meta">
                                                <small><?php echo esc_html__('Salary', 'nokri'); ?></small>
                                                <strong><?php echo esc_html(nokri_job_post_single_taxonomies('job_currency', $job_currency)) . " " . esc_html(nokri_job_post_single_taxonomies('job_salary', $job_salary)) . " " . '/' . " " . esc_html(nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type)); ?></strong>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php if (!empty($job_shift)) { ?>
                                        <li>
                                            <div class="short-detail-icon">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/tick-icon.png'); ?>" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                            </div>
                                            <div class="short-detail-meta">
                                                <small><?php echo nokri_feilds_label('shift_txt', esc_html__('Shift', 'nokri')); ?></small>
                                                <strong><?php echo esc_html(nokri_job_post_single_taxonomies('job_shift', $job_shift)); ?></strong>
                                            </div>
                                        </li>
                                    <?php } ?>
                                    <?php if (!empty($job_vacancy)) { ?>
                                        <li>
                                            <div class="short-detail-icon">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/tick-icon.png'); ?>" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                            </div>
                                            <div class="short-detail-meta">
                                                <small><?php echo nokri_feilds_label('vacancy_txt', esc_html__('No. of Openings', 'nokri')); ?></small>
                                                <strong><?php echo esc_html($job_vacancy) . " " . ($opening_text); ?></strong>
                                            </div>
                                        </li>
                                    <?php } if (!empty($job_level)) { ?>
                                        <li>
                                            <div class="short-detail-icon">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/tick-icon.png'); ?>" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                            </div>
                                            <div class="short-detail-meta">
                                                <small><?php echo nokri_feilds_label('level_txt', esc_html__('Job Level :', 'nokri')); ?></small>
                                                <strong><?php echo esc_html(nokri_job_post_single_taxonomies('job_level', $job_level)); ?></strong>
                                            </div>
                                        </li>
                                    <?php } if (!empty($job_experience)) { ?>
                                        <li>
                                            <div class="short-detail-icon">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/tick-icon.png'); ?>" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                            </div>
                                            <div class="short-detail-meta">
                                                <small><?php echo nokri_feilds_label('experience_txt', esc_html__('Job Experience :', 'nokri')); ?></small>
                                                <strong><?php echo esc_html(nokri_job_post_single_taxonomies('job_experience', $job_experience)); ?></strong>
                                            </div>
                                        </li>
                                    <?php } if (!empty($job_qualifications)) { ?>
                                        <li>
                                            <div class="short-detail-icon">
                                                <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/tick-icon.png'); ?>" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                                            </div>
                                            <div class="short-detail-meta">
                                                <small><?php echo nokri_feilds_label('quali_txt', esc_html__('Job Qualifications', 'nokri')); ?></small>
                                                <strong><?php echo esc_html(nokri_job_post_single_taxonomies('job_qualifications', $job_qualifications)); ?></strong>
                                            </div>
                                        </li> 
                                        <?php
                                    }
                                    /* Dynamic feilds */
                                    if (function_exists('nokriCustomFieldsHTML')) {
                                        echo nokriCustomFieldsHTML($job_id);
                                    }
                                    ?>
                                </ul>
                            </div>
                        </div> 
                    </div>
                <?php } ?>
                <div class="prf-description">
                    <div class="about-company">
                        <h3 class="heading"><?php echo esc_html__('Job Description', 'nokri'); ?></h3>
                        <?php
                        $format_allow = isset($nokri['formated_text_allow_check']) ? $nokri['formated_text_allow_check'] : false;
                        if (!$format_allow) {
                            echo nokri_get_formated_description(get_the_content());
                        } else {
                            the_content();
                        }
                        ?>
                    </div>
                    <?php
                    /* Getting Job Skills  */
                    $skill_tags = '';
                    if (is_array($job_skills)) {
                        $taxonomies = get_terms('job_skills', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
                        if (count($taxonomies) > 0) {
                            foreach ($taxonomies as $taxonomy) {
                                if (in_array($taxonomy->term_id, $job_skills)) {
                                    $link = nokri_set_url_param(get_the_permalink($nokri['sb_search_page']), 'job_skills', esc_attr($taxonomy->term_id));
                                    $final_url = esc_url(nokri_page_lang_url_callback($link));
                                    $skill_tags .= '<li><a href="' . $final_url . '">' . " " . esc_html($taxonomy->name) . " " . '</a></li>';
                                }
                            }
                        }
                    }
                    if (!empty($skill_tags)) {
                        ?>
                        <div class="special-tags">
                            <h3 class="heading"><?php echo nokri_feilds_label('skills_txt', esc_html__('Job skills', 'nokri')); ?></h3>
                            <ul>
                                <?php echo "" . ($skill_tags); ?>
                            </ul>
                        </div>
                        <?php
                    }
                    if (!empty($job_video)) {
                        $rx = '~
                                ^(?:https?://)?                           # Optional protocol
                                 (?:www[.])?                              # Optional sub-domain
                                 (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
                                 ([^&]{11})                               # Video id of 11 characters as capture group 1
                                      ~x';
                        $valid = preg_match($rx, $job_video, $matches);
                        $job_video = isset($matches[1]) ? $matches[1] : '';
                        ?>
                        <div class="resume-3-box resume-skills">
                            <h4><?php echo esc_html__('Attachment video', 'nokri'); ?> </h4>
                            <div class="portfolio-video">
                                <iframe width="840" height="380" src="https://www.youtube.com/embed/<?php echo "" . esc_attr($job_video); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>
                        </div>
                        <?php
                    }
                    if ($job_details_map) {
                        $remotely_work = job_nokri_remotely_work($job_id);
                        ?>
                        <div class="">
                            <h3 class="heading"><?php echo esc_html('Location', 'nokri'); ?></h3>
                            <div class="location-map">
                                <?php echo "" . $remotely_work; ?>
                            </div>
                        </div>
                    <?php } ?>
                </div>
                <div class="advrimg">
                    <?php echo '' . ($advert_down); ?>
                </div>
                <?php if ($job_alerts) { ?>
                    <div class="job-alert-box">
                        <div class="left-meta">
                            <h5><i class="fa fa-exclamation-triangle"></i> <?php echo esc_attr($job_alerts_title); ?></h5>
                            <p><?php echo esc_html($job_alerts_tagline); ?></p>
                        </div>
                        <div class="right-meta">
                            <a href="javascript:void(0)" class="btn n-btn-flat job_alert"><?php echo esc_html($job_alerts_btn); ?></a>
                        </div>
                    </div>
                    <?php
                }
                if ((isset($nokri['relateds_jobs_switch'])) && $nokri['relateds_jobs_switch'] == '1') {
                    echo get_template_part('template-parts/layouts/job-style/related', 'jobs');
                }
                ?>
            </div>
            <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                <div class="job-detail-sidebar">
                    <?php
                    /* Author Check */
                    if ($user_id == $post_author_id || current_user_can('administrator')) {
                        $direction = '';
                        if (is_rtl()) {
                            $direction = 'float-start';
                        }
                        $edit_url = esc_url(nokri_set_url_param(get_the_permalink($nokri['sb_post_ad_page']), 'id', esc_attr($job_id)));
                        ?>
                        <div class="top-button">
                            <a class="btn n-btn-flat <?php echo esc_attr($direction); ?>" href="<?php echo '' . $edit_url; ?>"><?php echo esc_html__('Edit this Job', 'nokri'); ?></a>
                        </div>
                        <?php
                    } else {
                        /* candidate Check */
                        if (get_user_meta($user_id, '_sb_reg_type', true) == '0') {
                            ?>
                            <?php
                            if ($post_apply_status == 'active') {
                                $apply_status = nokri_job_apply_status($job_id);
                                $apply_now_text = esc_html__('Apply now', 'nokri');
                                if ($apply_status != "") {
                                    $apply_now_text = esc_html__('Applied', 'nokri');
                                }
                                ?>
                                <div class="top-button">
                                    <?php if ($job_apply_with == 'exter') { ?>
                                        <a href="#" class="btn n-btn-flat btn-mid btn-clear external_apply" data-job-id="<?php echo esc_attr($job_id); ?>" data-job-exter="<?php echo esc_url($job_apply_url); ?>"><?php echo esc_html($apply_now_text); ?></a>
                                    <?php } else if ($job_apply_with == 'mail') { ?>
                                        <input type="hidden" class="external_mail_val" value="<?php echo esc_url($job_apply_mail) ?>"/>
                                        <a href="#" class="btn n-btn-flat btn-mid btn-clear email_apply" data-job-id="<?php echo esc_attr($job_id); ?>" data-job-exter="<?php echo '' . ( $job_apply_mail ); ?>"><?php echo esc_html($apply_now_text); ?></a> 
                                    <?php } else if ($job_apply_with == 'whatsapp') {
                                        ?>
                                        <input type="hidden" class="external_whatsapp_val" value="<?php echo '' . esc_attr($job_apply_whatsapp) ?>"/>
                                        <a href="https://api.whatsapp.com/send?phone=<?php echo '' . esc_attr($job_apply_whatsapp) ?>" class="btn n-btn-flat btn-mid btn-clear whatsapp_apply" data-job-id="<?php echo esc_attr($job_id); ?>" data-job-exter="<?php echo '' . esc_attr( $job_apply_whatsapp ); ?>"><?php echo esc_html($apply_now_text); ?></a> 
                                        <?php
                                    } else {
                                        ?>
                                        <a href="javascript:void(0)" class="btn n-btn-flat btn-mid btn-clear apply_job" data-job-id="<?php echo esc_attr($job_id); ?>" data-author-id="<?php echo esc_attr($post_author_id); ?>" data-bs-toggle="modal" data-bs-target="#myModal" id="applying_job"><?php echo esc_html($apply_now_text); ?></a>
                                        <?php
                                    }
                                    /* Enable/disable linkedin apply */
                                    if ((isset($nokri['cand_linkedin_apply'])) && $nokri['cand_linkedin_apply'] == 1) {
                                        /* Linkedin key */
                                        $linkedin_api_key = '';
                                        if ((isset($nokri['linkedin_api_key'])) && $nokri['linkedin_api_key'] != '' && (isset($nokri['linkedin_api_secret'])) && $nokri['linkedin_api_secret'] != '' && (isset($nokri['redirect_uri'])) && $nokri['redirect_uri'] != '') {
                                            $linkedin_api_key = ($nokri['linkedin_api_key']);
                                            $linkedin_secret_key = ($nokri['linkedin_api_secret']);
                                            $redirect_uri = ($nokri['redirect_uri']);
                                          
                                           $state = 'not_logged_in-' . $job_id;
                                            if (is_user_logged_in()) {
                                                $state = 'logged_in-' . $job_id;
                                            }

                                             $linkedin_url = esc_url('https://www.linkedin.com/oauth/v2/authorization?response_type=code&client_id=' . $linkedin_api_key . '&redirect_uri=' . $redirect_uri . '&state=' . esc_attr($state) . '&scope=r_liteprofile r_emailaddress');
                                            if (!is_user_logged_in()) {
                                                
                                                echo '<a href="' . esc_url($linkedin_url) . '" class="btn n-btn-flat btn-mid btn-clear"><i class="ti-linkedin nok-linkedin"></i> | <span>' . esc_html__('Apply with LinkedIn', 'nokri') . '</span></a>';
                                            }
                                            else {
                                       
                                         if( $apply_now_text != "Applied")
                                         {
                                            $pop_up_url   =  get_the_permalink($job_id) .  "/?src=lkn";
                                          echo '<a href="'.$pop_up_url.'"  class="btn n-btn-flat btn-mid btn-clear"><i class="ti-linkedin"></i> <span>' . esc_html__('Apply With LinkedIn', 'nokri') . '</span></a>';
                                         }        
                                          
                                       }
                                        }
                                    }
                                    ?>
                                </div>
                            <?php } else { ?> <a href="javascript:void(0)" class="btn n-btn-flat btn-mid btn-clear"><?php echo esc_html__('Job Expired', 'nokri'); ?></a><?php
                            }
                        }
                    }
                    ?>
                    <div class="deadline-box">
                        <div class="icon">
                            <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/timer-img.png'); ?>" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>">
                        </div>
                        <div class="meta">
                            <h3><?php echo esc_html__('Deadline', 'nokri'); ?></h3>
                            <h3><?php echo esc_html($job_deadline); ?></h3>
                        </div>
                        <img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/timer-img-2.png'); ?>" class="img-responsive side-clock" alt="<?php echo esc_attr__('side-clock-img', 'nokri'); ?>">
                    </div>
                    <div class="white-space"></div>
                    <div class="company-dtl">
                        <div class="company-logo">
                            <a class="view-profile" href="<?php echo esc_url(get_author_posts_url($post_author_id)); ?>">
                                <img src="<?php echo esc_url($image_link[0]); ?>" class="img-responsive img-circle" alt="<?php echo esc_attr__('company profile image', 'nokri'); ?>"></a>
                        </div>
                        <?php
                        /* Getting Ratings average stars  */
                        $star_rating = avg_user_rating($user_id);
                        /* Getting Ratings average numeric Value  */
                        $average_rating = nokri_get_user_rating_average_value($user_id);
                        ?>
                        <div class="rating">
                            <?php echo nokri_returnEcho($star_rating); ?>
                        </div>
                        <span class="rating-ratio"><?php echo esc_html(nokri_returnEcho($average_rating)); ?></span>
                        <a class="view-profile" href="<?php echo esc_url(get_author_posts_url($post_author_id)); ?>"><h3 class="cmpy-name"><?php echo esc_html($company_name); ?></h3></a>
                        <p class="txt"><?php echo esc_html(get_user_meta($user_id, '_user_headline', true)); ?></p>
                    </div>
                    <div class = "form-box">
                        <div class = "n-widget widget">
                            <h3 class = "widget-heading"><?php
                                echo nokri_feilds_label('emp_cont_lab', esc_html__('Contact ', 'nokri')) . " ";
                                echo esc_html($company_name);
                                ?></h3>
                            <form id="contact_form_email" method="POST" enctype="multipart/form-data">
                                <div class="form-group">
                                    <input type="text" name="contact_name" data-parsley-required="true" data-parsley-error-message="<?php echo esc_attr__('Please enter name', 'nokri'); ?>" class="form-control" placeholder="<?php echo esc_attr__('Full name', 'nokri'); ?>">
                                </div>
                                <div class="form-group">
                                    <input type="email" name="contact_email" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo esc_attr__('Please enter email', 'nokri'); ?>"  placeholder="<?php echo esc_attr__('Email address', 'nokri'); ?>">
                                </div>
                                <div class="form-group">
                                    <input type="text" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo esc_attr__('Please enter subject', 'nokri'); ?>" name="contact_subject"   placeholder=" <?php echo esc_attr__('Subject', 'nokri'); ?>">
                                </div>
                                <input type="hidden" name="receiver_id" value="<?php echo esc_attr($post_author_id); ?>" />
                                <div class="form-group">
                                    <textarea name="contact_message" class="form-control"  rows="5"></textarea>
                                </div>
                                <?php if ($nokri['google_recaptcha_key'] != "" && $contact_recaptcha) { ?>
                                    <div class="g-recaptcha custom-recaptch-size form-group"  name="contact-recaptcha" data-sitekey="<?php echo esc_attr($nokri['google_recaptcha_key']); ?>">
                                    </div>             
                                    <?php
                                }
                                /* Function for Terms and Conditions */
                                $termsCo = nokri_terms_and_conditions();
                                echo '' . $termsCo;
                                ?>
                                <button type="submit" class="btn n-btn-flat btn-mid btn-block contact_me"><?php echo esc_html__('Message', 'nokri'); ?></button>
                            </form>
                        </div>
                    </div>
                    <?php
                    /* <!--Candidates Applied Counter--> */
                    $applicants_counter = isset($nokri['single_resume_counter']) ? $nokri['single_resume_counter'] : false;
                    if ($applicants_counter == true) {
                        echo '<div class="n-job-tags">
                            <h4 class="widget-heading">' . esc_html__('Applicants applied: ', 'nokri') . '  ' . esc_html(nokri_get_resume_count($job_id)) . '</h4>
                        </div>';
                    }
                    /* <!--Job Reported Counter--> */
                    if ($report_btn == true) {
                        if (current_user_can('editor') || current_user_can('administrator')) {
                            $reports_counter = nokri_count_user_reports_against_job($job_id);
                            echo '<div class="n-job-tags">
                            <h4 class="widget-heading">' . esc_html__('Job Reported: ', 'nokri') . '  ' . esc_html($reports_counter) . '</h4>
                        </div>';
                        }
                    }
                    /* <!--Job Attachments--> */
                    if (!empty($job_attachments)) {
                        ?>
                        <div class="n-job-tags">
                            <h4 class="widget-heading"><?php echo esc_html__('Job attachments', 'nokri'); ?></h4>
                            <ul class="job-attach"><?php echo "" . ($job_attachments); ?></ul>
                        </div>
                        <?php
                    }
                    /* <!--Job Tags--> */
                    if ((isset($nokri['single_job_tags'])) && $nokri['single_job_tags'] == 1 && !empty($tags_html)) {
                        ?>
                        <div class="n-job-tags">
                            <h3><?php echo nokri_feilds_label('tags_txt', esc_html__('Job tags', 'nokri')); ?></h3>
                            <ul class="job-tag-list">
                                <?php echo "" . ($tags_html); ?>
                            </ul>
                        </div>
                    <?php } ?>
                </div>
                <?php
                if ($is_lat_long && $is_nearby) {
                    $lat_lng_meta_query = array();
                    $latitude = $ad_map_lat;
                    $longitude = $ad_map_long;
                    $distance = $nearby_distance;
                    $num_of_jobs = $nearby_jobs_number;
                    $unit = $distance_unit;
                    $data_array = array();
                    $li = "";

                    if (!empty($longitude) && !empty($longitude)) {
                        $data_array = array("latitude" => $latitude, "longitude" => $longitude, "distance" => $distance);
                    }
                    $type_lat = "'DECIMAL'";
                    $type_lon = "'DECIMAL'";
                    $lats_longs = nokri_radius_search_theme($data_array, false);

                    if (!empty($lats_longs) && count((array) $lats_longs) > 0) {
                        if ($latitude > 0) {
                            $lat_lng_meta_query[] = array(
                                'key' => '_job_lat',
                                'value' => array($lats_longs['lat']['min'], $lats_longs['lat']['max']),
                                'compare' => 'BETWEEN',
                            );
                        } else {
                            $lat_lng_meta_query[] = array(
                                'key' => '_job_lat',
                                'value' => array($lats_longs['lat']['max'], $lats_longs['lat']['min']),
                                'compare' => 'BETWEEN',
                            );
                        }
                        if ($longitude > 0) {
                            $lat_lng_meta_query[] = array(
                                'key' => '_job_long',
                                'value' => array($lats_longs['long']['min'], $lats_longs['long']['max']),
                                'compare' => 'BETWEEN',
                            );
                        } else {
                            $lat_lng_meta_query[] = array(
                                'key' => '_job_long',
                                'value' => array($lats_longs['long']['max'], $lats_longs['long']['min']),
                                'compare' => 'BETWEEN',
                            );
                        }
                        $args = array(
                            'posts_per_page' => $num_of_jobs,
                            'post_type' => 'job_post',
                            'post_status' => 'publish',
                            'order' => 'DESC',
                            'post__not_in' => array($job_id),
                            'orderby' => 'date',
                            'meta_query' => array(
                                array(
                                    'key' => '_job_status',
                                    'value' => 'active',
                                    'compare' => '=',
                                ),
                                $lat_lng_meta_query,
                            ),
                        );
                        $args = nokri_wpml_show_all_posts_callback($args);
                        $results = new WP_Query($args);
                        if ($results->have_posts()) {
                            while ($results->have_posts()) {
                                $results->the_post();
                                $job_id = get_the_ID();
                                $post_author_id = get_post_field('post_author', $job_id);
                                $company_name = get_the_author_meta('display_name', $post_author_id);
                                $image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                                if (get_user_meta($post_author_id, '_sb_user_pic', true) != "") {
                                    $attach_id = get_user_meta($post_author_id, '_sb_user_pic', true);
                                    if (is_numeric($attach_id)) {
                                        $image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                                    } else {
                                        $image_link[0] = $attach_id;
                                    }
                                }
                                $latitude1 = get_post_meta($job_id, '_job_lat', true);
                                $longitude1 = get_post_meta($job_id, '_job_long', true);
                                $calculated_distance = nokri_nearby_distance($latitude, $longitude, $latitude1, $longitude1, $unit);
                                $final_distance = $calculated_distance . $distance_unit;
                                $final_distance = $calculated_distance . $distance_unit;

                                if ($final_distance == '0km') {
                                    $final_distance_loc = esc_html__('Same Location', 'nokri');
                                } else {
                                    $final_distance_loc = $final_distance;
                                }
                                $li .= '<div class="fr-ads-box">
                                                <div class="left-cont">
                                                    <a href = "' . $image_link[0] . '"> <img class = "img-fluid" src = "' . $image_link[0] . '" alt = ""> </a> 
                                                </div>
                                                <div class="right-cont">
                                                    <h5><a href = "' . get_the_permalink() . '">' . esc_html(get_the_title()) . '</a></h5>
                                                    <span class="distance_clr">' . esc_html($final_distance_loc) . '</span>
                                            <div class = "main-rate mb-1"><span class = "main-reg-pricing "> </span></div>
                                                </div>
                                            </div>';
                            }
                            wp_reset_postdata();
                        }
                        ?>
                        <div class="fr-ads-list">
                            <?php echo nokri_returnEcho($li); ?>
                        </div>
                        <?php
                    }
                }
                if ($emp_fb || $emp_google || $emp_twitter || $emp_linkedin) {
                    ?>
                    <div class="social-box">
                        <h4 class="title"><?php echo esc_html('Find us on', 'nokri'); ?></h4>
                        <ul>
                            <?php if ($emp_fb) { ?>
                                <li> <a href="<?php echo esc_url($emp_fb); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/006-facebook.png'); ?>" class="img-responsive" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                            <?php } if ($emp_google) { ?>
                                <li> <a href="<?php echo esc_url($emp_google); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/003-google-plus.png'); ?>" alt="<?php echo esc_attr__('icon', 'nokri'); ?>" class="img-responsive"></a></li>
                            <?php } if ($emp_twitter) { ?>
                                <li> <a href="<?php echo esc_url($emp_twitter); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/004-twitter.png'); ?>" alt="<?php echo esc_attr__('icon', 'nokri'); ?>" class="img-responsive"></a></li>
                            <?php } if ($emp_linkedin) { ?>
                                <li> <a href="<?php echo esc_url($emp_linkedin); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/005-linkedin.png'); ?>" alt="<?php echo esc_attr__('icon', 'nokri'); ?>" class="img-responsive"></a></li>
                            <?php } ?>
                        </ul>
                    </div>
                <?php } ?>
            </div>
        </div>
    </div>
</section>
<!-- about-job-detail-end -->
<div class="modal fade resume-action-modal" id="myModal-linkedin_url">
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <form method="post" id="submit_linkedin_url" class="apply-job-modal-popup">
                <div class="modal-header">
                    <h4 class="modal-title"><?php echo esc_html__('Want to apply for this job', 'nokri'); ?></h4>
                </div>
                <div class="modal-body">
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <div class="form-group">
                            <label><?php echo esc_html__('Enter your linkedin profile url', 'nokri'); ?><span class="color-red">*</span></label>
                            <input placeholder="<?php echo esc_attr__('Enter your linkedin profile url', 'nokri'); ?>" class="form-control" type="text" name="linkedin_url"  data-parsley-required="true" data-parsley-error-message="<?php echo esc_attr__('Enter your linkedin profile url', 'nokri'); ?>">
                        </div>
                    </div>
                    <div class="modal-footer">
                    <?php wp_nonce_field("submit_linkedin_url_nonce_action", "submit_linkedin_url_nonce"); ?>
                        <button type="submit" name="submit"  class="btn n-btn-flat btn-mid btn-block submit_linkedin_url">
                            <?php echo esc_html__('Apply Now', 'nokri'); ?>
                        </button>
                    </div>
                </div>
                <input type="hidden" value="<?php echo esc_attr($job_id); ?>"  name="apply_job_id" />
            </form>
        </div>
    </div>
</div>
<?php
if (isset($_GET['src']) && $_GET['src'] == 'lkn') {
    echo "<script type='text/javascript'>
	jQuery(window).load(function(){
		jQuery('#myModal-linkedin_url').modal({backdrop: 'static', keyboard: false});
	jQuery('#myModal-linkedin_url').modal('show');
	});
	</script>";
}
if ($single_job_schema) {
    ?>
    <script type="application/ld+json">
        {
        "@context": "https://schema.org/",
        "@type": "JobPosting",
        "title": "<?php esc_html(the_title()); ?>",
        "description": "<?php echo wp_strip_all_tags(get_the_content()); ?>",
        "hiringOrganization" : {
        "@type": "Organization",
        "name": "<?php echo esc_html($company_name); ?>",
        "sameAs": "<?php echo esc_url($web); ?>"
        },
        "employmentType": "<?php echo esc_html(nokri_job_post_single_taxonomies('job_type', $job_type)); ?>",
        "datePosted": "<?php echo esc_html(get_the_date('Y-m-d')); ?>",
        "validThrough": "<?php echo esc_html($job_deadline); ?>",
        "jobLocation": {
        "@type": "Place",
        "address": {
        "@type": "PostalAddress",
        "addressCountry": "<?php echo '' . $countries_last; ?>"
        }
        },
        "baseSalary": {
        "@type": "MonetaryAmount",
        "currency": "<?php echo esc_html(nokri_job_post_single_taxonomies('job_currency', $job_currency)); ?>",
        "value": {
        "@type": "QuantitativeValue",
        "value": "<?php echo esc_html(nokri_job_post_single_taxonomies('job_salary', $job_salary)); ?>",
        "unitText": "<?php echo esc_html(nokri_job_post_single_taxonomies('job_salary_type', $job_salary_type)); ?>"
        }
        },
        "qualifications": "<?php echo esc_html(nokri_job_post_single_taxonomies('job_qualifications', $job_qualifications)); ?>",
        "experienceRequirements": "<?php echo esc_html(nokri_job_post_single_taxonomies('job_experience', $job_experience)); ?>"
        }
    </script>
    <?php
}        