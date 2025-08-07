<?php
add_action('show_user_profile', 'sb_show_extra_profile_fields');
add_action('edit_user_profile', 'sb_show_extra_profile_fields');

function sb_show_extra_profile_fields($user) {
    ?>
    <h3><?php echo __('Package Information', 'redux-framework'); ?></h3>
    <?php
    global $nokri;
    $is_apply_pkg_base = ( isset($nokri['job_apply_package_base']) && $nokri['job_apply_package_base'] != "" ) ? $nokri['job_apply_package_base'] : false;
    $row_data = '';
    $user_type = get_user_meta($user->ID, '_sb_reg_type', true);

    if ($user_type == '1') {
        /* Getting Employer Packages Details */
        $class_terms = get_terms('job_class', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
        if (count($class_terms) > 0) {
            $class = $row_data = '';
            foreach ($class_terms as $class_term) {

                $meta_name = 'package_job_class_' . $class_term->term_id;
                //$class	   =   get_the_author_meta( $meta_name, $user->ID );
                $class = get_user_meta($user->ID, $meta_name, true);

                if ($class == '') {
                    $class = __("N/A", 'redux-framework');
                }
                $row_data .= '<tr>
				<th><label for="_sb_pkg_type">' . esc_html(ucfirst($class_term->name)) . __(' Jobs', 'redux-framework') . '</label></th>
				<td>
					<input type="text" name="' . esc_attr($meta_name) . '" id="' . esc_attr($meta_name) . '" value="' . esc_attr($class) . '" class="regular-text" /><br />
				</td>
			</tr>
			<tr>';
                //echo nokri_employer_dashboard(ucfirst( $class_term->name) ." Jobs :",$meta_name);
            }
        }
    } else {

        $row_data .= '<tr>
                                <th><label for="_cand_job_apply"> ' . __('Jobs applied (-1 means unlimited)', 'redux-framework') . '</label></th>
                                <td>
                                        <input type="text" name="candidate_jobs" id="candidate_jobs" value="' . esc_attr(get_user_meta($user->ID, '_candidate_applied_jobs', true)) . '" class="regular-text" /><br />
                                </td>
                        </tr>
                        <tr>
                        <tr>
                                <th><label for="_cand_job_apply"> ' . __('Featured profile (Y-mm-dd)', 'redux-framework') . '</label></th>
                                <td>
                                        <input type="text" name="featured_profile" id="candidate_jobs" value="' . esc_attr(get_user_meta($user->ID, '_candidate_feature_profile', true)) . '" class="regular-text" /><br />
                                </td>
                        </tr>
                        <tr>';
    }
    ?>
    <table class="form-table">
        <tr>
            <th><label for="_sb_pkg_date"><?php echo esc_html__(' Package expiry (Y-mm-dd)', 'redux-framework'); ?></label></th>
            <td>
                <input type="text" name="_sb_pkg_date" id="_sb_pkg_date" value="<?php echo get_user_meta($user->ID, '_sb_expire_ads', true); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <?php
        global $nokri;
        if ((isset($nokri['allow_bump_jobs'])) && $nokri['allow_bump_jobs'] && $user_type == '1') {
            ?>

            <tr>
                <th><label for="bump_ads_limit"><?php echo esc_html__('Bump up job limit', 'redux-framework'); ?></label></th>
                <td>
                    <input type="number" name="bump_ads_limit" id="bump_ads_limit" value="<?php echo get_user_meta($user->ID, 'bump_ads_limit', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
        <?php } ?>

        <tr>
            <th><label for="emp_featured_profile"><?php echo esc_html__('Featured profile (Y-mm-dd)', 'redux-framework'); ?></label></th>
            <td>
                <input type="text" name="emp_featured_profile" id="emp_featured_profile" value="<?php echo get_user_meta($user->ID, '_emp_feature_profile', true); ?>" class="regular-text" /><br />
            </td>
        </tr>
        <?php echo $row_data; ?>
        <?php
        global $nokri;
        if ((isset($nokri['cand_search_mode'])) && $nokri['cand_search_mode'] == '2' && $user_type == '1') {
            ?>
            <tr>
                <th><label for="_sb_cand_search_value"><?php echo esc_html__('Candidates Resumes Access', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="_sb_cand_search_value" id="_sb_cand_search_value" value="<?php echo get_user_meta($user->ID, '_sb_cand_search_value', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
        <?php } ?>
    </table>
    <h3><?php echo __('User Profile Information', 'redux-framework'); ?></h3>
    <?php
    /* Type setting */
    $is_employer = get_user_meta($user->ID, '_sb_reg_type', true);
    $is_candidates = get_user_meta($user->ID, '_sb_reg_type', true);
    /* Profile setting */
    $profile_option = get_user_meta($user->ID, '_user_profile_status', true);
    ?>
    <table class="form-table">
        <tr>
            <th><label for="_sb_user_type"><?php echo esc_html__('User Type', 'redux-framework'); ?></label></th>
            <td>
                <select class="form-control" id="_sb_user_type" name="_sb_user_type">
                    <option value="4" ><?php echo __("Selet an option", "redux-framework"); ?></option>
                    <option value="1" <?php
                    if ($is_employer == 1) {
                        echo "selected = selected";
                    }
                    ?> ><?php echo __("Employer", "redux-framework"); ?></option>
                    <option value="0" <?php
                    if ($is_candidates == 0) {
                        echo "selected = selected";
                    }
                    ?> ><?php echo __("Candidate", "redux-framework"); ?></option>
                </select>
            </td>
        </tr>
        <tr>
            <th><label for="_sb_user_profile_setting"><?php echo esc_html__('User Profile Setting', 'redux-framework'); ?></label></th>
            <td>
                <select class="form-control" id="_sb_user_profile_setting" name="_sb_user_profile_setting">
                    <option value="0" ><?php echo __("Selet an option", "redux-framework"); ?></option>
                    <option value="pub" <?php
                    if ($profile_option == 'pub') {
                        echo "selected = selected";
                    }
                    ?> ><?php echo __("Public", "redux-framework"); ?></option>
                    <option value="priv" <?php
                    if ($profile_option == 'priv') {
                        echo "selected = selected";
                    }
                    ?> ><?php echo __("Private", "redux-framework"); ?></option>
                </select>
            </td>
        </tr>
        <?php
        global $nokri;
        if ($user_type == '1') {
            //$user_id = $user->ID;
            // $user_info = get_userdata($user_id);
            ?>
            <tr>
                <th><label for="emp_headline"><?php echo esc_html__('Company Tagline', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="emp_headline" id="emp_headline" value="<?php echo get_user_meta($user->ID, '_user_headline', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="sb_reg_contact"><?php echo esc_html__('Phone No', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="sb_reg_contact" id="sb_reg_contact" value="<?php echo get_user_meta($user->ID, '_sb_contact', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="emp_web"><?php echo esc_html__('Website', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="emp_web" id="emp_web" value="<?php echo get_user_meta($user->ID, '_emp_web', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="emp_nos"><?php echo esc_html__('No of Employees', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="emp_nos" id="emp_nos" value="<?php echo get_user_meta($user->ID, '_emp_nos', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="emp_est"><?php echo esc_html__('Established Date', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="emp_est" id="emp_est" placeholder="<?php echo esc_html__('May 2000', 'redux-framework'); ?>" value="<?php echo get_user_meta($user->ID, '_emp_est', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="emp_fb"><?php echo esc_html__('Facebook Link', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="emp_fb" id="emp_fb" value="<?php echo get_user_meta($user->ID, '_emp_fb', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="emp_twitter"><?php echo esc_html__('Twitter Link', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="emp_twitter" id="emp_twitter" value="<?php echo get_user_meta($user->ID, '_emp_twitter', true); ?>" class="regular-text" /><br />
                </td>
            </tr> 
            <tr>
                <th><label for="emp_linked"><?php echo esc_html__('Linkedin Link', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="emp_linked" id="emp_linked" value="<?php echo get_user_meta($user->ID, '_emp_linked', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="emp_google"><?php echo esc_html__('Instagram Link', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="emp_google" id="emp_google" value="<?php echo get_user_meta($user->ID, '_emp_google', true); ?>" class="regular-text" /><br />
                </td>
            </tr>


            <tr>
                <th><label for="sb_user_address"><?php echo esc_html__('Map Location', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="sb_user_address" id="sb_user_address" value="<?php echo get_user_meta($user->ID, '_emp_map_location', true); ?>" class="regular-text" /><br />
                </td>
            </tr>

            <tr>
                <th><label for="emp_video"><?php echo esc_html__('Video Link', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" placeholder="<?php echo nokri_feilds_label('emp_port_vid_plc', esc_html__('Put youtube video link', 'redux-framework')); ?>"  placeholder="https://www.youtube.com/watch?v=WjoplqS1u18&ab_channel=8KWorld" value="<?php echo nokri_candidate_user_meta('_emp_video'); ?>" name="emp_video" class="form-control regular-text" data-parsley-pattern="^(http(s)?:\/\/)?((w){3}.)?youtu(be|.be)?(\.com)?\/.+" <?php echo nokri_feilds_operat('emp_port_vid_setting', 'required'); ?>><br />
                </td>
            </tr>
            <tr>
                <th><label for="emp_intro"><?php echo nokri_feilds_label('emp_about_label', esc_html__('About Employer', 'redux-framework')); ?></label></th>
                <td>
                    <textarea  name="emp_intro" class="form-control rich_textarea" id=""  cols="30" rows="10"><?php echo nokri_candidate_user_meta('_emp_intro'); ?></textarea>
                </td>
            </tr>
            <?php
        } else {
            /* Candidate Fields */
            $cand_headline = get_user_meta($user->ID, '_user_headline', true);
            $cand_phone = get_user_meta($user->ID, '_sb_contact', true);
            $cand_qualification = get_user_meta($user->ID, '_cand_qualification', true);
            $cand_gender = get_user_meta($user->ID, '_cand_gender', true);
            $cand_introd = get_user_meta($user->ID, '_cand_intro', true);
            $cand_type = get_user_meta($user->ID, '_cand_type', true);
            $cand_experience = get_user_meta($user->ID, '_cand_experience', true);
            $cand_salary_type = get_user_meta($user->ID, '_cand_salary_type', true);
            $cand_salary_range = get_user_meta($user->ID, '_cand_salary_range', true);
            $cand_salary_curren = get_user_meta($user->ID, '_cand_salary_curren', true);
            $cand_dob = get_user_meta($user->ID, '_cand_dob', true);
            $cand_intro_video = get_user_meta($user->ID, '_cand_intro_vid', true);
            $cand_video = get_user_meta($user->ID, '_cand_video', true);
            ?>
            <tr>
                <th><label for = "cand_headline"><?php echo esc_html__('Profession', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="cand_headline" id="cand_headline" value="<?php echo '' . $cand_headline; ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="cand_phone"><?php echo esc_html__('Phone No', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="cand_phone" id="cand_phone" value="<?php echo '' . $cand_phone; ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="cand_gender"><?php echo nokri_feilds_label('cand_gend_label', esc_html__('Gender', 'redux-framework')); ?></label></th>
                <td>
                    <select  class="select-generat form-control" name="cand_gender" <?php echo nokri_feilds_operat('cand_gend_setting', 'required'); ?>>
                        <option value="male" <?php
                        if ($cand_gender == 'male') {
                            echo "selected";
                        };
                        ?>><?php echo esc_html__('Male', 'redux-framework'); ?></option>
                        <option value="female" <?php
                        if ($cand_gender == 'female') {
                            echo "selected";
                        };
                        ?>><?php echo esc_html__('Female', 'redux-framework'); ?></option>
                        <option value="other" <?php
                        if ($cand_gender == 'other') {
                            echo "selected";
                        };
                        ?>><?php echo esc_html__('Other', 'redux-framework'); ?></option>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="cand_qualification"><?php echo nokri_feilds_label('cand_quali_label2', esc_html__('Qualification', 'redux-framework')); ?></label></th>
                <td>
                    <select   class="select-generat form-control"  name="cand_qualification" <?php echo nokri_feilds_operat('cand_quali_setting', 'required'); ?>>
                        <?php echo nokri_job_post_taxonomies('job_qualifications', $cand_qualification); ?>
                    </select
                </td>
            </tr>
            <tr>
                <th><label for="cand_dob"><?php echo nokri_feilds_label('cand_dob_label', esc_html__('Date Of Birth (mm/dd/yyyy)', 'redux-framework')); ?></label></th>
                <td>
                    <input type="text"   value="<?php echo '' . $cand_dob; ?>" name="cand_dob" class="datepicker-cand-dob form-control" <?php echo nokri_feilds_operat('cand_dob_setting', 'required'); ?>  />
                </td>
            </tr>
            <tr>
                <th><label for="cand_type"><?php echo nokri_feilds_label('cand_type_label', esc_html__('Type', 'redux-framework')); ?></label></th>
                <td>
                    <select   class="select-generat form-control"  name="cand_type"<?php echo nokri_feilds_operat('cand_type_setting', 'required'); ?>>
                        <?php echo nokri_job_post_taxonomies('job_type', $cand_type); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="cand_salary_type"><?php echo nokri_feilds_label('cand_exper_label', esc_html__('Experience', 'redux-framework')); ?></label></th>
                <td>
                    <select   class="select-generat form-control"  name="cand_experience" <?php echo nokri_feilds_operat('cand_exper_setting', 'required'); ?>>
                        <?php echo nokri_job_post_taxonomies('job_experience', $cand_experience); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="cand_salary_type"><?php echo nokri_feilds_label('cand_salary_type_label', esc_html__('Salary Type', 'redux-framework')); ?></label></th>
                <td>
                    <select   class="select-generat form-control"  name="cand_salary_type" <?php echo nokri_feilds_operat('cand_salary_type_setting', 'required'); ?>>
                        <?php echo nokri_job_post_taxonomies('job_salary_type', $cand_salary_type); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="cand_salary"><?php echo nokri_feilds_label('cand_salary_range_label', esc_html__('Salary Range', 'redux-framework')); ?></label></th>
                <td>
                    <select   class="select-generat form-control"  name="cand_salary" <?php echo nokri_feilds_operat('cand_salary_range_setting', 'required'); ?>>
                        <?php echo nokri_job_post_taxonomies('job_salary', $cand_salary_range); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="cand_salary_currency"><?php echo nokri_feilds_label('cand_salary_curren_label', esc_html__('Salary Currency', 'redux-framework')); ?></label></th>
                <td>
                    <select   class="select-generat form-control"  name="cand_salary_currency" <?php echo nokri_feilds_operat('cand_salary_curren_setting', 'required'); ?>>
                        <?php echo nokri_job_post_taxonomies('job_currency', $cand_salary_curren); ?>
                    </select>
                </td>
            </tr>
            <tr>
                <th><label for="cand_intro_video"><?php echo nokri_feilds_label('cand_video_resume_label', esc_html__('Put candidate video resume link (only youtube)', 'redux-framework')); ?></label></th>
                <td>
                    <input type="text" placeholder="<?php echo nokri_feilds_label('cand_video_resume_plc', esc_html__('https://www.youtube.com/watch?v=WjoplqS1u18&ab_channel=8KWorld', 'redux-framework')); ?>" value="<?php echo '' . $cand_intro_video; ?>" name="cand_intro_video" class="form-control youTubeUrl" >

                </td>
            </tr>
            <tr>
                <th><label for="cand_video"><?php echo nokri_feilds_label('cand_portfolio_video_label', esc_html__('Portfolio Video url (only youtube)', 'redux-framework')); ?></label></th>
                <td>
                    <input type="text" placeholder="<?php echo nokri_feilds_label('cand_portfolio_video_plc', esc_html__('https://www.youtube.com/watch?v=WjoplqS1u18&ab_channel=8KWorld', 'redux-framework')); ?>" value="<?php echo '' . $cand_video; ?>" name="cand_video" class="form-control" <?php echo nokri_feilds_operat('cand_portfolio_video', 'required'); ?>>
                </td>
            </tr>
            <tr>
                <th><label for="cand_fb"><?php echo esc_html__('Facebook Link', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="cand_fb" id="emp_fb" value="<?php echo get_user_meta($user->ID, '_cand_fb', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="cand_twiter"><?php echo esc_html__('Twitter Link', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="cand_twiter" id="emp_twitter" value="<?php echo get_user_meta($user->ID, '_cand_twiter', true); ?>" class="regular-text" /><br />
                </td>
            </tr> 
            <tr>
                <th><label for="cand_linked"><?php echo esc_html__('Linkedin Link', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="cand_linked" id="emp_linked" value="<?php echo get_user_meta($user->ID, '_cand_linked', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="cand_google"><?php echo esc_html__('Instagram Link', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="cand_google" id="emp_google" value="<?php echo get_user_meta($user->ID, '_cand_google', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="sb_user_address"><?php echo esc_html__('Map Location', 'redux-framework'); ?></label></th>
                <td>
                    <input type="text" name="sb_user_address" id="sb_user_address" value="<?php echo get_user_meta($user->ID, '_cand_address', true); ?>" class="regular-text" /><br />
                </td>
            </tr>
            <tr>
                <th><label for="cand_intro"><?php echo nokri_feilds_label('cand_about_label', esc_html__('About Candidate', 'redux-framework')); ?></label></th>
                <td>
                    <textarea  name="cand_intro" class="form-control rich_textarea" cols="30" rows="10" <?php echo nokri_feilds_operat('cand_about_setting', 'required'); ?>><?php echo '' . $cand_introd; ?></textarea>
                </td>
            </tr>
        <?php } ?>
    </table>
    <?php
}

add_action('personal_options_update', 'sb_save_extra_profile_fields');
add_action('edit_user_profile_update', 'sb_save_extra_profile_fields');

function sb_save_extra_profile_fields($user_id) {


    if (!current_user_can('edit_user', $user_id))
        return false;

    /* Updating Package Expiry Details */
    if (isset($_POST['_sb_pkg_date'])) {
        update_user_meta(absint($user_id), '_sb_expire_ads', wp_kses_post($_POST['_sb_pkg_date']));
    }
    if (isset($_POST['bump_ads_limit'])) {
        update_user_meta(absint($user_id), 'bump_ads_limit', wp_kses_post($_POST['bump_ads_limit']));
    }
    if (isset($_POST['emp_headline'])) {
        update_user_meta(absint($user_id), '_user_headline', wp_kses_post($_POST['emp_headline']));
    }

    if (isset($_POST['sb_reg_contact'])) {
        update_user_meta(absint($user_id), '_sb_contact', wp_kses_post($_POST['sb_reg_contact']));
    }

    if (isset($_POST['emp_web'])) {
        update_user_meta(absint($user_id), '_emp_web', wp_kses_post($_POST['emp_web']));
    }

    if (isset($_POST['emp_nos'])) {
        update_user_meta(absint($user_id), '_emp_nos', wp_kses_post($_POST['emp_nos']));
    }
    if (isset($_POST['emp_est'])) {
        update_user_meta(absint($user_id), '_emp_est', wp_kses_post($_POST['emp_est']));
    }

    if (isset($_POST['emp_fb'])) {
        update_user_meta(absint($user_id), '_emp_fb', wp_kses_post($_POST['emp_fb']));
    }

    if (isset($_POST['emp_twitter'])) {
        update_user_meta(absint($user_id), '_emp_twitter', wp_kses_post($_POST['emp_twitter']));
    }

    if (isset($_POST['emp_linked'])) {
        update_user_meta(absint($user_id), '_emp_linked', wp_kses_post($_POST['emp_linked']));
    }

    if (isset($_POST['emp_google'])) {
        update_user_meta(absint($user_id), '_emp_google', wp_kses_post($_POST['emp_google']));
    }

    if (isset($_POST['sb_user_address'])) {
        update_user_meta(absint($user_id), '_emp_map_location', wp_kses_post($_POST['sb_user_address']));
    }

    if (isset($_POST['emp_intro'])) {
        update_user_meta(absint($user_id), '_emp_intro', wp_kses_post($_POST['emp_intro']));
    }
    if (isset($_POST['emp_video'])) {
        update_user_meta(absint($user_id), '_emp_video', wp_kses_post($_POST['emp_video']));
    }

    // updating employer feature profile
    if (isset($_POST['emp_featured_profile'])) {
        update_user_meta(absint($user_id), '_emp_feature_profile', wp_kses_post($_POST['emp_featured_profile']));
        update_user_meta(absint($user_id), '_is_emp_featured', '1');
    }
    /* Updating Jobs Details */
    $class_terms = get_terms('job_class', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC'));
    if (count($class_terms) > 0) {
        $class = $row_data = '';
        foreach ($class_terms as $class_term) {
            $meta_name = 'package_job_class_' . $class_term->term_id;
            $class = get_user_meta($user_id, $meta_name, true);
            if (isset($_POST[$meta_name])) {
                update_user_meta(absint($user_id), $meta_name, wp_kses_post($_POST[$meta_name]));
            }
        }
    }
    /* Updating Candidate Search Details */
    if (isset($_POST['_sb_cand_search_value'])) {
        update_user_meta(absint($user_id), '_sb_cand_search_value', wp_kses_post($_POST['_sb_cand_search_value']));
    }

    /* Updating User Type Information */
    if (isset($_POST['_sb_user_type']) && $_POST['_sb_user_type'] != '') {
        update_user_meta(absint($user_id), '_sb_reg_type', wp_kses_post($_POST['_sb_user_type']));
    }
    /* Updating User Profile setting */
    if (isset($_POST['_sb_user_profile_setting']) && $_POST['_sb_user_profile_setting'] != '') {
        update_user_meta(absint($user_id), '_user_profile_status', wp_kses_post($_POST['_sb_user_profile_setting']));
    }
    /* Updating candidate job applied  */
    if (isset($_POST['candidate_jobs']) && $_POST['candidate_jobs'] != '') {
        update_user_meta(absint($user_id), '_candidate_applied_jobs', wp_kses_post($_POST['candidate_jobs']));
    }
    /* Updating candidate featured profile date  */
    if (isset($_POST['featured_profile']) && $_POST['featured_profile'] != '') {
        update_user_meta(absint($user_id), '_candidate_feature_profile', wp_kses_post($_POST['featured_profile']));
        update_user_meta(absint($user_id), '_is_candidate_featured', '1');
    }

    /* Candidate fields Data Update */
    if (isset($_POST['cand_headline'])) {
        update_user_meta(absint($user_id), '_user_headline', wp_kses_post($_POST['cand_headline']));
    }
    /* Updating candidate phone No  */
    if (isset($_POST['cand_phone'])) {
        update_user_meta(absint($user_id), '_sb_contact', wp_kses_post($_POST['cand_phone']));
    }
    /* Updating candidate Gender  */
    if (isset($_POST['cand_gender'])) {
        update_user_meta(absint($user_id), '_cand_gender', wp_kses_post($_POST['cand_gender']));
    }
    /* Updating candidate qualification  */
    if (isset($_POST['cand_qualification'])) {
        update_user_meta(absint($user_id), '_cand_qualification', wp_kses_post($_POST['cand_qualification']));
    }
    /* Updating candidate Type  */
    if (isset($_POST['cand_type'])) {
        update_user_meta(absint($user_id), '_cand_type', wp_kses_post($_POST['cand_type']));
    }
    /* Updating candidate Salary Type */
    if (isset($_POST['cand_salary_type'])) {
        update_user_meta(absint($user_id), '_cand_salary_type', wp_kses_post($_POST['cand_salary_type']));
    }
    /* Updating candidate Salary  */
    if (isset($_POST['cand_salary'])) {
        update_user_meta(absint($user_id), '_cand_salary_range', wp_kses_post($_POST['cand_salary']));
    }
    /* Updating candidate Salary Currency  */
    if (isset($_POST['cand_salary_currency'])) {
        update_user_meta(absint($user_id), '_cand_salary_curren', wp_kses_post($_POST['cand_salary_currency']));
    }
    /* Updating candidate Introduction  */
    if (isset($_POST['cand_intro'])) {
        update_user_meta(absint($user_id), '_cand_intro', wp_kses_post($_POST['cand_intro']));
    }
    /* Updating candidate Introduction Video  */
    if (isset($_POST['cand_intro_video'])) {
        update_user_meta(absint($user_id), '_cand_intro_vid', wp_kses_post($_POST['cand_intro_video']));
    }
    /* Updating candidate Resume Video  */
    if (isset($_POST['cand_video'])) {
        update_user_meta(absint($user_id), '_cand_video', wp_kses_post($_POST['cand_video']));
    }
    /* Updating candidate Experiece */
    if (isset($_POST['cand_experience'])) {
        update_user_meta(absint($user_id), '_cand_experience', wp_kses_post($_POST['cand_experience']));
    }
    /* Updating candidate Facebook link  */
    if (isset($_POST['cand_fb'])) {
        update_user_meta(absint($user_id), '_cand_fb', wp_kses_post($_POST['cand_fb']));
    }
    /* Updating candidate Twitter link  */
    if (isset($_POST['cand_twiter'])) {
        update_user_meta(absint($user_id), '_cand_twiter', wp_kses_post($_POST['cand_twiter']));
    }
    /* Updating candidate Linkedin link  */
    if (isset($_POST['cand_linked'])) {
        update_user_meta(absint($user_id), '_cand_linked', wp_kses_post($_POST['cand_linked']));
    }
    /* Updating candidate Instagram link  */
    if (isset($_POST['cand_google'])) {
        update_user_meta(absint($user_id), '_cand_google', wp_kses_post($_POST['cand_google']));
    }
    /* Updating candidate Map Address  */
    if (isset($_POST['sb_user_address'])) {
        update_user_meta(absint($user_id), '_cand_address', wp_kses_post($_POST['sb_user_address']));
    }
    /* Updating candidate Date of Birth  */
    if (isset($_POST['cand_dob'])) {
        update_user_meta(absint($user_id), '_cand_dob', wp_kses_post($_POST['cand_dob']));
    }
}
