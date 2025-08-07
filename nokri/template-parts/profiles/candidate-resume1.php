<?php require trailingslashit(get_template_directory()) . "/template-parts/profiles/candidate-meta.php";
?>
<section class="n-breadcrumb-big resume-3-brreadcrumb"<?php echo "" . nokri_returnEcho($bg_url); ?>>
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
            </div>
        </div>
    </div>
</section>

<section class="user-resume-3">
    <div class="container">
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12 ">
                <div class="n-candidate-info">
                    <div class="n-candidate-img-box">
                        <img src="<?php echo esc_url($image_link); ?>" class="img-responsive" alt="<?php echo esc_attr__('image', 'nokri'); ?>">
                    </div>
                    <div class="n-candidate-meta-box">
                        <?php if ($cand_profile_status == 'pub') { ?>
                            <h4><?php echo esc_html($author->display_name); ?></h4>
                            <?php
                            $last_login_status = isset($nokri['cand_last_login_status']) ? $nokri['cand_last_login_status'] : false;
                            if ($last_login_status == true) {
                                echo '<p>' . esc_html__('Last login:', 'nokri') . ' ' . get_last_login($author_id) . ' ' . esc_html__('ago', 'nokri') . '</p>';
                            }
                            ?>
                            <?php if ($cand_headline && nokri_feilds_operat('cand_profession_setting', 'show')) { ?>
                                <p><?php echo esc_html($cand_headline); ?></p>                                
                                <?php
                            }
                        }
                        if ($soc_sec && $social_links && $cand_profile_status == 'pub' || $author_id == $current_user_id) {
                            ?>
                            <ul class="social-links list-inline">
                                <?php if ($cand_fb) { ?>
                                    <li> <a href="<?php echo esc_url($cand_fb); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/006-facebook.png'); ?>" alt="<?php echo esc_attr__('Link', 'nokri'); ?>"></a></li>
                                <?php } if ($cand_google) { ?>
                                    <li> <a href="<?php echo esc_url($cand_google); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/003-google-plus.png'); ?>" alt="<?php echo esc_attr__('Link', 'nokri'); ?>"></a></li>
                                <?php } if ($cand_twiter) { ?>
                                    <li> <a href="<?php echo esc_url($cand_twiter); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/004-twitter.png'); ?>" alt="<?php echo esc_attr__('Link', 'nokri'); ?>"></a></li>
                                <?php } if ($cand_linked) { ?>
                                    <li> <a href="<?php echo esc_url($cand_linked); ?>"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/005-linkedin.png'); ?>" alt="<?php echo esc_attr__('Link', 'nokri'); ?>"></a></li>
                                <?php } ?>
                            </ul>
                        <?php } ?>
                    </div>
                    <?php
                    $invite_cand = isset($nokri['emp_cand_invite_job']) ? $nokri['emp_cand_invite_job'] : false;
                    if(($current_user_id != 0 && $user_type != '0') && $invite_cand == true){ ?>
                    <div class="n-candidate-meta-box">
                        <?php
                            $invite_text = esc_html__('Invite', 'nokri');?>
                            <a href="#" class="btn btn-custom" data-bs-toggle="modal" data-bs-target="#cand-invite-modal"><?php echo esc_html($invite_text); ?></a>                  
                    </div>
                    <?php } ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php
$restrict_check = isset($nokri['cand_profile_redirect']) ? $nokri['cand_profile_redirect'] : false;

if ($restrict_check && ($current_user_id == "" || $current_user_id == 0)) {
    $sign_in = isset($nokri['sb_sign_in_page']) ? $nokri['sb_sign_in_page'] : "#";
    echo '<div class="container">
            <section class="n-candidate-detail">
                <div class="alert alert-info alert-dismissible" role="alert">
                    <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span>
                    </button>
                    <strong>' . esc_html__("Information ! ", "nokri") . '</strong>' . esc_html__("Please Login to See Candidate Profile", "nokri") . '
                    <strong><a href="'. esc_url(get_the_permalink($sign_in)) .'">'. esc_html__('Login in', 'nokri') .'</a></strong>
                </div>
            </section>
        </div>';
}
else
{
?>
<section class="n-candidate-detail">
    <div class="container">
        <div class="row">
            <?php
            if ($cand_profile_status == 'pub' || $author_id == $current_user_id || current_user_can('administrator') || $is_search) {
                $resumes_viewed = get_user_meta($current_user_id, '_sb_cand_viewed_resumes', true);
                if (isset($nokri['cand_search_mode']) && $nokri['cand_search_mode'] == "2") {
                    $remaining_searches = get_user_meta($current_user_id, '_sb_cand_search_value', true);
                    $unlimited_searches = false;
                    if ($remaining_searches == '-1') {
                        $unlimited_searches = true;
                    }
                    if (!$is_applied && !$unlimited_searches && !current_user_can('administrator') && $author_id != $current_user_id) {
                        $resumes_viewed_array = (explode(",", $resumes_viewed));
                        if (!in_array($author_id, $resumes_viewed_array)) {
                            $author_id = $author_id;
                            if ($resumes_viewed != '') {
                                $author_id = $resumes_viewed . ',' . $author_id;
                            }
                            update_user_meta($current_user_id, '_sb_cand_viewed_resumes', $author_id);
                            if ($remaining_searches != '0') {
                                update_user_meta($current_user_id, '_sb_cand_search_value', (int) $remaining_searches - 1);
                            }
                        }
                    }
                }
                ?>
                <div class="col-lg-4 col-md-12 col-sm-12 col-xs-12">
                    <aside class="resume-3-sidebar">
                        <div class="n-candidate-info">
                            <h4 class="widget-heading"><?php echo nokri_feilds_label('cand_det', esc_html__('Candidate detail', 'nokri')); ?></h4>
                            <ul>
                                <?php if ($cand_dob && nokri_feilds_operat('cand_dob_setting', 'show') && $cand_dob_setting) { ?>
                                    <li>
                                        <i class="la la-calendar la-3x"></i>
                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_dob_label', esc_html__('Date of birth:', 'nokri')); ?></small> <strong><?php echo date_i18n(get_option('date_format'), strtotime($cand_dob)); ?></strong></div>
                                    </li>
                                    <?php
                                } if (($cand_address && $loc_sec) || $author_id == $current_user_id) {
                                    if ($cand_adress_setting) {
                                        ?>
                                        <li>
                                            <i class="la la-map-marker la-3x "></i> 
                                            <div class="resume-detail-meta"><small><?php echo esc_html__('Location:', 'nokri'); ?></small> <strong><?php echo esc_html($cand_address); ?></strong></div>
                                        </li>
                                        <?php
                                    }
                                }
                                if (($is_public && $cand_phone != "")) {
                                    if ($cand_phone_setting) {
                                        ?>
                                        <li>
                                            <i class="la la-mobile la-3x"></i> 
                                            <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_phone_label', esc_html__('Cell No:', 'nokri')); ?></small><strong><?php echo esc_html($cand_phone); ?></strong></div>
                                            <div class="resume-detail-meta"><?php echo esc_html($verification); ?></div> 
                                        </li>
                                        <?php
                                    }
                                }if (($is_public) || $author_id == $current_user_id) {
                                    if ($cand_email_setting) {
                                        ?>
                                        <li>
                                            <i class="la la-envelope la-3x"></i> 
                                            <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_email_label', esc_html__('Email address', 'nokri')); ?></small><strong><?php echo esc_html($author->user_email); ?></strong></div>
                                        </li>
                                        <?php
                                    }
                                }
                                ?>
                                <li>
                                    <i class="la la-arrows la-3x"></i>
                                    <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_mem', esc_html__('Member Since', 'nokri')); ?></small><strong><?php echo date_i18n(get_option('date_format'), strtotime($registered)); ?></strong></div>
                                </li>
                                <?php if ($cand_gender && nokri_feilds_operat('cand_gend_setting', 'show')) { ?>
                                    <li>
                                        <i class="la la-mars la-3x"></i>
                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_gend', esc_html__('Gender', 'nokri')); ?></small><strong><?php echo ucfirst($cand_gender); ?></strong></div>
                                    </li>
                                <?php } if ($salary_range && nokri_feilds_operat('cand_salary_range_setting', 'show')) { ?>
                                    <li>
                                        <i class="la la-money la-3x"></i> 
                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_salary', esc_html__('Salary', 'nokri')); ?></small><strong>
                                                <?php echo esc_html(nokri_job_post_single_taxonomies('job_currency', $salary_curren)) . " " . esc_html(nokri_job_post_single_taxonomies('job_salary', $salary_range)) . " " . '/' . " " . esc_html(nokri_job_post_single_taxonomies('job_salary_type', $salary_type)); ?>
                                            </strong></div>
                                    </li>
                                <?php } if ($cand_qualification && nokri_feilds_operat('cand_quali_setting', 'show')) { ?>
                                    <li>
                                        <i class="la la-graduation-cap la-3x"></i> 
                                        <div class="resume-detail-meta"><small><?php echo nokri_feilds_label('cand_quali_label2', esc_html__('Qualifications', 'nokri')); ?></small><strong>
                                                <?php echo esc_html(nokri_job_post_single_taxonomies('job_qualifications', $cand_qualification)); ?>
                                            </strong></div>
                                    </li>
                                <?php } ?>
                            </ul>
                            <?php if ($cand_save_setting) { ?>
                                <?php wp_nonce_field('saving_resume_nonce_action', 'saving_resume_nonce'); ?>
                                <button type="submit" class="btn n-btn-custom btn-block saving_resume test2 mb-2 w-100" data-cand-id= <?php echo esc_attr($author_id); ?>><i class="fa fa-heart"></i><?php echo nokri_feilds_label('cand_save_resume', esc_html__('Save Resume', 'nokri')); ?></button>
                                <?php
                            } if ($cand_resume_down && $cand_resume_setting) {
                                echo '' . $resume_id;
                            }
                            ?>
                            <?php if ($cand_resume_gen && $cand_generate_setting) { ?>
                                <a href="#" class="btn n-btn-custom btn-block w-100"  data-bs-toggle="modal" data-bs-target="#template_modal"><i class="fa fa-download"></i><?php echo nokri_feilds_label('cand_generate_resume', esc_html__('Generate Resume', 'nokri')); ?></a>
                            <?php } ?>
                        </div>
                        <?php if ($hours_sec) { ?>
                            <div class="widget">
                                <h4 class="widget-heading">
                                    <?php echo nokri_feilds_label('cand_hours_label', esc_html__('Scheduled Hours', 'nokri')) ?>
                                </h4>
                                <?php
                                if (get_user_meta($user_crnt_id, 'nokri_is_hours_allow', true) == '1') {
                                    //now check if its 24/7 or selective timimgz
                                    if (get_user_meta($user_crnt_id, 'nokri_business_hours', true) == '1') {
                                        ?>
                                        <?php echo esc_html__('Always Available', 'nokri'); ?>
                                        <?php
                                    } else {
                                        $get_hours = nokri_show_business_hours($user_crnt_id);
                                        // $status_type = nokri_business_hours_status($user_crnt_id);
                                        // if ($status_type == 0) {
                                        //     $business_hours_status = esc_html__('Closed', 'nokri');
                                        // } else {
                                        //     $business_hours_status = esc_html__('Open Now', 'nokri');
                                        // }
                                        $class = '';
                                        if (is_rtl()) {
                                            $class = 'flip';
                                        }
                                        ?>
                                        <div class="opening-hours-title tool-tip" title="<?php echo esc_attr__('Business Hours', 'nokri'); ?>"> 
                                        </div> 
                                        <?php
                                        if (get_user_meta($user_crnt_id, 'nokri_user_timezone', true) != "") {
                                            echo '<div class="s-timezone">' . esc_html__("Timezone: ", "nokri") . '<strong>' . esc_html(get_user_meta($user_crnt_id, 'nokri_user_timezone', true)) . '</strong></div>';
                                        }
                                        ?>
                                        <ul class="days_list">
                                            <?php
                                            if (is_array($get_hours) && count($get_hours) > 0) {
                                                foreach ($get_hours as $key => $val) {
                                                    $class = '';
                                                    if ($val['current_day'] != "") {
                                                        $class = "current_day";
                                                    }
                                                    if ($val['closed'] == 1) {
                                                        $class = "closed";
                                                        echo '' . $htm_return = '<li class="' . esc_html($class) . '"> <span class="day-name"> ' . esc_attr($val['day_name']) . ':</span> <span class="day-timing"> ' . esc_html__('Closed', 'nokri') . ' </span> </li>';
                                                    } else {
                                                        echo '' . $htm_return = ' <li class="' . esc_html($class) . '"> <span class="day-name"> ' . esc_attr($val['day_name']) . ':</span> <span class="day-timing"> ' . esc_attr($val['start_time']) . ' - ' . esc_attr($val['end_time']) . ' </span> </li>';
                                                    }
                                                }
                                            }
                                            ?>
                                        </ul>      
                                        <?php
                                    }
                                } else {
                                    echo "<strong> N/A </strong>";
                                } echo "</div>";
                            } if ($is_public_contact) {
                                ?>
                                <div class="widget">
                                    <h4 class="widget-heading"><?php echo nokri_feilds_label('cand_cont_lab', esc_html__('Contact', 'nokri')) . " " . esc_html($author->display_name); ?></h4>
                                    <form id="contact_form_email abc" method="POST" enctype="multipart/form-data">
                                        <div class="row">
                                            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                                <div class="mb-3">
                                                    <input type="text" name="contact_name" data-parsley-required="true" data-parsley-error-message="<?php echo esc_attr__('Please enter name', 'nokri'); ?>" class="form-control" placeholder="<?php echo esc_attr__('Full Name', 'nokri'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-6 col-xs-12">
                                                <div class="mb-3">
                                                    <input type="email" name="contact_email" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo esc_attr__('Please enter email', 'nokri'); ?>"  placeholder="<?php echo esc_attr__('Email address', 'nokri'); ?>">
                                                </div>
                                            </div>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="mb-3">
                                                    <input type="text" class="form-control" data-parsley-required="true" data-parsley-error-message="<?php echo esc_attr__('Please enter subject', 'nokri'); ?>" name="contact_subject"   placeholder=" <?php echo esc_attr__('Subject', 'nokri'); ?>">
                                                </div>
                                            </div>
                                            <input type="hidden" name="receiver_id" value="<?php echo esc_attr($author_id); ?>" />
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <div class="mb-3">
                                                    <textarea name="contact_message" placeholder="<?php echo esc_attr__('Your message', 'nokri'); ?>" class="form-control"  rows="5"></textarea>
                                                </div>
                                            </div>
                                            <?php if ($nokri['google_recaptcha_key'] != "" && $contact_recaptcha) { ?>
                                                <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">			
                                                    <div class="g-recaptcha custom-recaptch-emp mb-3" name="contact-recaptcha" data-sitekey="<?php echo esc_attr($nokri['google_recaptcha_key']); ?>">
                                                    </div> 
                                                </div>        
                                            <?php } ?>
                                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                                <?php
                                                /* Function for Terms and Conditions */
                                                $termsCo = nokri_terms_and_conditions();
                                                echo '' . $termsCo;
                                                ?>
                                                <button type="submit" class="btn n-btn-flat btn-mid btn-block contact_me"><?php echo esc_html__('Message', 'nokri'); ?></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            <?php } if ($port_sec && $portfolio_html) { ?>
                                <div class="widget">
                                    <h4 class="widget-heading"><?php echo nokri_feilds_label('cand_portfolio_label', esc_html__('Portfolio', 'nokri')); ?></h4>
                                    <div class="resume-3-portfolio">
                                        <ul><?php echo "" . ($portfolio_html); ?></ul>
                                    </div>
                                </div>
                            <?php } if (isset($cand_advertisment) && $cand_advertisment != '') { ?>
                                <div class="widget">
                                    <h4 class="widget-heading"><?php echo esc_html__('Advertisement', 'nokri'); ?></h4>
                                    <div class="resume-3-portfolio">
                                        <?php echo '' . ($cand_advertisment); ?>
                                    </div>
                                </div>
                            <?php } ?> 
                    </aside>
                </div>
                <div class="col-lg-8 col-md-12 col-sm-12 col-xs-12">
                    <div class="resume-3-detail">
                        <?php if ($cand_introd != '' && nokri_feilds_operat('cand_about_setting', 'show')) { ?>
                            <div class="resume-3-box">
                                
                                <h4><?php echo nokri_feilds_label('cand_about', esc_html__('About me', 'nokri')); ?></h4>

                                 <?php 
                                 
                                 
                                 $strippedString = preg_replace('/<([a-z]+)(.*?)line-height\s*:\s*[^;"]*;?(.*?)(\/)?>/i', '<$1$2$3$4>', $cand_introd);
                                 $strippedString = preg_replace('/<([a-z]+)(.*?)font-size\s*:\s*[^;"]*;?(.*?)(\/)?>/i', '<$1$2$3$4>', $strippedString);
                                 ?>



                                <p><?php echo '' . ($strippedString); ?></p>
                            </div>
                        <?php } if (isset($registration_feilds) && $registration_feilds != '' || isset($custom_feilds_cand) && $custom_feilds_cand != '') { ?> 
                            <div class="resume-3-box">
                                <div class="custom-field-box">
                                    <h4><?php echo nokri_feilds_label('user_custom_feild_txt', esc_html__('Custom Fields', 'nokri')); ?></h4>
                                    <div class="n-can-custom-meta">
                                        <ul class="n-can-custom-meta-detail">
                                            <?php echo '' . $registration_feilds . $custom_feilds_cand; ?>
                                        </ul>
                                    </div>
                                </div>
                            </div>
                        <?php } if ($skill_sec && !empty($skills_bar)) { ?>
                            <div class="resume-3-box resume-skills">
                                <h4><?php echo nokri_feilds_label('cand_skills_label', esc_html__('Skills and tools', 'nokri')); ?></h4>
                                <?php echo "" . ($skills_bar); ?>
                            </div>

                        <?php }
                        ?>
                        <div class="resume-3-box">
                            <div class="row">
                                <?php
                                $cand_education = get_user_meta($user_crnt_id, '_cand_education', true);
                                if ($edu_sec && $cand_education && $cand_education[0]['degree_name'] != '') {
                                    ?>

                                    <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                        <h4><?php echo nokri_feilds_label('cand_edu_lab', esc_html__('Education', 'nokri')); ?></h4>
                                        <div class="resume-timeline">
                                            <div class="row">
                                            <?php
                                            foreach ($cand_education as $edu) {
                                                $degre_name = (isset($edu['degree_name'])) ? '<h5 class="degree-name">' . esc_html($edu['degree_name']) . '</h5>' : '';
                                                $degre_strt = (isset($edu['degree_start'])) ? $edu['degree_start'] : '';
                                                $degre_insti = (isset($edu['degree_institute'])) ? '<span class="institute-name">' . esc_html($edu['degree_institute']) . '</span>' : '';
                                                $degre_details = (isset($edu['degree_detail'])) ? '<p>' . wp_kses_post($edu['degree_detail']) . '</p>' : '';
                                                ?>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="resume-timeline-box">
                                                    <span class="degree-duration"><?php
                                                        echo esc_html($degre_strt) . " ";
                                                        if ($edu['degree_end'] != '') {
                                                            echo '-' . esc_html($edu['degree_end']);
                                                        }
                                                        ?>
                                                    </span>
                                                    <?php echo "" . ($degre_name) . ($degre_insti) . ($degre_details); ?>
                                                </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        </div>
                                    </div>
                                    <?php
                                }
                                $cand_profession = get_user_meta($user_crnt_id, '_cand_profession', true);
                                if ($prof_sec && $cand_profession && $cand_profession[0]['project_organization'] != '') {
                                    ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h4><?php echo nokri_feilds_label('cand_prof_lab', esc_html__('Work Experience', 'nokri')); ?></h4>
                                        <div class="resume-timeline">
                                            <div class="row">
                                            <?php
                                            foreach ($cand_profession as $profession) {
                                                $project_end = $profession['project_end'];
                                                if ($profession['project_end'] == '') {
                                                    $project_end = esc_html__('Currently working', 'nokri');
                                                }
                                                $project_role = (isset($profession['project_role'])) ? '<h5 class="degree-name">' . esc_html($profession['project_role']) . '</h5>' : '';
                                                $project_org = (isset($profession['project_organization'])) ? '<span class="institute-name">' . $profession['project_organization'] . '</span>' : '';
                                                $project_strt = (isset($profession['project_start'])) ? esc_html($profession['project_start']) : '';
                                                $project_detail = (isset($profession['project_desc'])) ? '<p>' . wp_kses_post($profession['project_desc']) . '</p>' : '';
                                                ?>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="resume-timeline-box">
                                                    <span class="degree-duration"><?php
                                                        echo esc_html($project_strt) . " ";
                                                        if ($project_end != '') {
                                                            echo esc_html('-' . ($project_end));
                                                        }
                                                        ?></span>
                                                    <?php echo "" . ($project_role) . ($project_org) . ($project_detail); ?>
                                                </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        </div>
                                    </div>
                                <?php } ?>
                                <?php
                                $cand_certifications = get_user_meta($user_crnt_id, '_cand_certifications', true);
                                if ($cert_sec && $cand_certifications && $cand_certifications[0]['certification_name'] != '') {
                                    ?>
                                    <div class="col-lg-12 col-md-12 col-sm-12">
                                        <h4><?php echo nokri_feilds_label('cand_certi_lab', esc_html__('Awards and Certificates  :', 'nokri')); ?></h4>
                                        <div class="resume-timeline">
                                        <div class="row">
                                            <?php
                                            foreach ($cand_certifications as $certification) {
                                                $certi_name = (isset($certification['certification_name'])) ? '<h5 class="degree-name">' . esc_html($certification['certification_name']) . '</h5>' : '';
                                                $certi_durat = (isset($certification['certification_duration'])) ? '<span>' . esc_html($certification['certification_duration']) . '</span>' : '';
                                                $certi_inst = (isset($certification['certification_institute'])) ? '<span class="institute-name">' . $certification['certification_institute'] . "  " . $certi_durat . '</span>' : '';
                                                $certi_strt = (isset($certification['certification_start'])) ? esc_html($certification['certification_start']) : '';
                                                $certi_end = (isset($certification['certification_end'])) ? esc_html($certification['certification_end']) : '';
                                                $certi_detail = (isset($certification['certification_desc'])) ? '<p>' . wp_kses_post($certification['certification_desc']) . '</p>' : '';
                                                ?>
                                                <div class="col-lg-6 col-md-6 col-sm-6 col-xs-12">
                                                <div class="resume-timeline-box" >
                                                    <span class="degree-duration"><?php
                                                        echo esc_html($certi_strt) . " ";
                                                        if ($certification['certification_end'] != '') {
                                                            echo '-' . esc_html($certification['certification_end']);
                                                        }
                                                        ?>
                                                    </span>
                                                    <?php echo "" . ($certi_name) . ($certi_inst) . ($certi_detail); ?>
                                                </div>
                                                </div>
                                            <?php } ?>
                                        </div>
                                        </div>
                                    </div>
                                <?php } ?>
                            </div>
                            <?php
                            if (!empty($cand_video)) {
                                $rx = '~
							  ^(?:https?://)?                           # Optional protocol
							   (?:www[.])?                              # Optional sub-domain
							   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
							   ([^&]{11})                               # Video id of 11 characters as capture group 1
								~x';
                                $valid = preg_match($rx, $cand_video, $matches);
                                $cand_video = $matches[1];
                                ?>
                                <div class="resume-3-box">
                                    <h4><?php echo nokri_feilds_label('cand_vid_lab', esc_html__('Portfolio video', 'nokri')); ?></h4>
                                    <div class="portfolio-video">
                                        <iframe width="750" height="380" src="https://www.youtube.com/embed/<?php echo "" . esc_attr($cand_video); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                            <?php } ?>
                            <?php
                            if (!empty($cand_intro_video) && !$cand_video_resume_switch) {
                                $rx = '~
							  ^(?:https?://)?                           # Optional protocol
							   (?:www[.])?                              # Optional sub-domain
							   (?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
							   ([^&]{11})                               # Video id of 11 characters as capture group 1
								~x';
                                $valid = preg_match($rx, $cand_intro_video, $matches);
                                $cand_intro_video = $matches[1];
                                ?>
                                <div class="resume-3-box">
                                    <h4><?php echo nokri_feilds_label('cand_vid_lab', esc_html__('Resume Video', 'nokri')); ?></h4>
                                    <div class="portfolio-video">
                                        <iframe width="750" height="400" src="https://www.youtube.com/embed/<?php echo "" . esc_attr($cand_intro_video); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                                    </div>
                                </div>
                                <?php
                            }
                            if ($cand_video_resume_switch && $cand_video_resumes != "") {

                                $video_url = wp_get_attachment_url($cand_video_resumes);
                                $media_type = wp_get_attachment_metadata(($cand_video_resumes));
                                ?>
                                <div class="resume-3-box">
                                    <h4><?php echo nokri_feilds_label('cand_vid_lab', esc_html__('Resume Video', 'nokri')); ?></h4>
                                    <div class="portfolio-video">
                                        <video width="710" height="380" controls>
                                            <source src="<?php echo '' . esc_url($video_url); ?>" type="<?php echo '' . esc_attr($media_type['mime_type']); ?>">
                                        </video>
                                    </div>
                                </div>
                                <?php
                            }
                        } else {
                            ?>
                            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                                <div class="locked-profile alert alert-danger fade in" role="alert">
                                    <i class="la la-lock"></i><?php echo "" . esc_html( $user_private_txt ); ?>
                                </div>
                            </div>
                        <?php } ?>
                    </div>
                </div>
                <?php get_template_part('template-parts/profiles/cand-rating'); ?>
            </div>  
        </div>     
    </div>    
</section>

<div id="cand-invite-modal" class="notify-modal modal fade invite_candidate" role="dialog">
    <div class="cp-loader"></div>
    <div class="modal-dialog modal-lg">
        <!-- Modal content-->
        <div class="modal-content">
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal">&times;</button>
                <h4 class="modal-title"><?php echo esc_html('Jobs Invite to Candidate', 'jobo-klutch'); ?></h4>
            </div>
            <div class="modal-body">
            <form id="invite_candidate_cont" method="POST" enctype="multipart/form-data">
                <div class="mb-3">
                    <label><?php echo nokri_feilds_label('skills_txt', esc_html__('Select Jobs', 'nokri')); ?></label>
                    <select class="js-example-basic-single" multiple data-allow-clear="true" data-placeholder="<?php echo nokri_feilds_label('invite_candidate_txt', esc_html__('Invite Candidate', 'nokri')); ?>" name="invite_job_ids[]" <?php echo nokri_feilds_operat('allow_job_skills', 'required'); ?> data-parsley-error-message="<?php echo '' . ($req_mess); ?>">
                <?php
                $args = array(
                    'post_type' => 'job_post',
                    'orderby' => 'date',
                    'author' => $current_user_id,
                    'paged' => '-1',
                    'post_status' => array('publish'),
                );
                $query = new WP_Query($args);
                if ($query->have_posts()) {
                    while ($query->have_posts()) {
                        $query->the_post();
                        $job_id = get_the_ID();
                        ?>
                        <?php
                            $invited_job_ids = get_user_meta(get_current_user_id(), 'invite_candidate_'.$user_crnt_id, true);
                            $invited_job_ids = is_array($invited_job_ids) ? $invited_job_ids : array();
                            if (in_array($job_id, $invited_job_ids)) { ?>
                            <option value="<?php echo esc_attr($job_id); ?>" selected disabled><?php echo get_the_title(); ?></option>
                        <?php } else {
                        ?>
                            <option value="<?php echo esc_attr($job_id); ?>"><?php echo get_the_title(); ?></option>
                        <?php
                        }
                        ?>
                        <?php
                    }
                }
                ?>
                </select>
                </div>
                </form>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn n-btn-flat invite_candidate_btn"><?php echo esc_html('Invite', 'jobo-klutch'); ?></button>
            </div>
            <input type="hidden" id="cand_id" value="<?php echo esc_attr($user_crnt_id); ?>" />
        </div>
    </div>
</div>
<?php }