<?php
require trailingslashit(get_template_directory()) . "/template-parts/profiles/employer-meta.php";
$mapType = nokri_mapType();
if ($mapType == 'google_map') {
    wp_enqueue_script('google-map-callback', false);
}
/* Is map show */
$allow_map = isset($nokri['nokri_allow_map']) ? $nokri['nokri_allow_map'] : true;
$is_lat_long = isset($nokri['emp_map_switch']) ? $nokri['emp_map_switch'] : false;
$loc_sec = (isset($nokri['emp_loc_switch'])) ? $nokri['emp_loc_switch'] : false;
?>
<!-- breadcrumb-section-start -->
<section class="breadcrumb-section"<?php echo "" . esc_attr($bg_url); ?>>
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12"></div>
        </div>
    </div>
</section>
<!-- breadcrumb-section-end -->
<!-- about-company-prf-dtl-start -->
<section class="about-company-prf-dtl">
    <div class="container">
        <div class="row">
            <div class="col-12 col-sm-12 col-md-12 col-lg-12 col-xl-12 col-xxl-12">
                <div class="abt-cmpy-prf-dtl">
                    <div class="profile">
                        <div class="left-meta">
                            <div class="logo">
                                <a href="javascript:void(0)"><img src="<?php echo esc_url($image_link[0]); ?>" alt=" <?php echo esc_attr__('logo', 'nokri'); ?>" class="img-responsive"></a>
                            </div>
                            <div class="prf-cont">
                                <?php if ($emp_profile_status == 'pub' || $author_id == $current_user_id) { ?>
                                    <small><?php echo nokri_feilds_label('emp_mem_sinc', esc_html__('Member since : ', 'nokri')); ?><?php echo date_i18n(get_option('date_format'), strtotime($registered)); ?></small>
                                    <a href="javascript:void(0)"><h1><?php echo esc_html(the_author_meta('display_name', $user_id)); ?></h1></a>
                                    <?php if ($emp_headline && nokri_feilds_operat('emp_heading_setting', 'show')) { ?>
                                        <span><?php echo esc_html($emp_headline); ?></span>
                                        <?php
                                    }
                                    $last_login_status = isset($nokri['emp_last_login_status']) ? $nokri['emp_last_login_status'] : false;
                                    if ($last_login_status == true) {
                                        echo '<div><span>' . esc_html__('Last login:', 'nokri') . ' ' . get_last_login($user_id) . ' ' . esc_html__('ago', 'nokri') . '</span></div>';
                                    }
                                    /* Getting Ratings average stars  */
                                    $star_rating = avg_user_rating($user_id);
                                    /* Getting Ratings average numeric Value  */
                                    $average_rating = nokri_get_user_rating_average_value($user_id);
                                    ?>
                                </div>
                            </div>
                            <div class="rightmeta">
                                <div class="rating-meta">
                                    <h5><?php echo nokri_returnEcho($average_rating); ?></h5>
                                    <div class="rating"><?php echo nokri_returnEcho($star_rating); ?></div>
                                </div>
                                <?php
                                if (get_user_meta($current_user_id, '_sb_reg_type', true) == 0 && $follow_btn_switch) {
                                    $comp_follow = get_user_meta($current_user_id, '_cand_follow_company_' . $user_id, true);
                                    if ($comp_follow) {
                                        ?>
                                        <div class="follow-us">
                                            <a class="btn n-btn-flat follow-btn"><?php echo esc_html__('Followed', 'nokri'); ?></a>
                                        </div>
                                    <?php } else { ?>
                                        <div class="follow-us">
                                            <a  data-value="<?php echo esc_attr($author_id); ?>"  class="btn n-btn-flat follow-btn follow_company"><?php echo esc_html__('Follow', 'nokri'); ?><i class="fa fa-user-plus"></i></a>
                                        </div>
                                        <?php
                                    }
                                }
                                ?>
                            </div>
                        </div>
                        <div class="botm-counters">
                            <ul>
                                <?php
                                $saved_resumes = nokri_get_total_saved_resume_count($user_id);
                                ?>
                                <?php
                                /* Getting Total No of Emlpoyer Followers */
                                $emp_followers = nokri_count_emp_followers($user_id);
                                ?>
                                <li>
                                    <div class="item"><small><?php echo esc_html__('Followers ', 'nokri'); ?></small><span><?php echo esc_html($emp_followers != '' ? $emp_followers : 0); ?></span></div>
                                </li>
                                <?php if ($emp_size) { ?>
                                    <li>
                                        <div class="item"><small><?php echo nokri_feilds_label('emp_no_emp_label', esc_html__('Team Size', 'nokri')); ?></small>
                                            <span><?php echo esc_html($emp_size); ?></span>
                                        </div>
                                    </li>
                                    <?php
                                }
                                /* Getting plublished Jobs of Employer */
                                $status = 'publish';
                                $emp_jobs = nokri_get_jobs_count($user_id, $status);
                                ?>
                                <li>
                                    <div class="item"><small><?php echo esc_html__('Post Jobs ', 'nokri'); ?></small><span><?php echo esc_html($emp_jobs != '' ? $emp_jobs : 0); ?></span></div>
                                </li>
                                <?php
                                //Getting Total Employer Members
                                $emp_members = get_user_meta($user_id, '_nokri_member_info', true);
                                $total_emp_members = 0;
                                if (!empty($emp_members)) {
                                    $total_emp_members = count($emp_members);
                                }
                                ?>
                                <li>
                                    <div class="item"><small><?php echo esc_html__('Team Members ', 'nokri'); ?></small><span><?php echo esc_html($total_emp_members != '' ? $total_emp_members : 0); ?></span></div>
                                </li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row">
                <div class="col-12 col-sm-12 col-md-12 col-lg-8 col-xl-8 col-xxl-8">
                    <div class="prf-description">
                        <?php if (get_user_meta($user_id, '_emp_intro', true) != '' && nokri_feilds_operat('emp_about_setting', 'show')) { ?>
                            <div class="about-company">
                                <h3 class="heading"><?php echo nokri_feilds_label('emp_about_label', esc_html__('About Employer', 'nokri')); ?></h3>
                                <?php
                                $intro = get_user_meta($user_id, '_emp_intro', true);
                                if (!preg_match('%(<p[^>]*>.*?</p>)%i', $intro, $regs)) {
                                    echo '<p>' . esc_html(get_user_meta($user_id, '_emp_intro', true)) . '</p>';
                                } else {
                                    echo esc_html(get_user_meta($user_id, '_emp_intro', true));
                                }
                                ?>
                            </div>
                            <?php
                        }
                        if ($port_sec) {
                            /* Getting Employer Portfolio */
                            $portfolio_html = '';
                            if (get_user_meta($author_id, '_comp_gallery', true) != "") {
                                $port = get_user_meta($author_id, '_comp_gallery', true);
                                $portfolios = explode(',', $port);
                                ?>
                                <div class="portfolio">
                                    <h3 class="heading"><?php echo nokri_feilds_label('emp_gall_lab', esc_html__('Employer Gallery', 'nokri')); ?></h3>
                                    <div class="row">
                                        <?php
                                        foreach ($portfolios as $portfolio) {
                                            $portfolio_image_sm = wp_get_attachment_image_src($portfolio, 'nokri_job_hundred');
                                            $portfolio_image_lg = wp_get_attachment_image_src($portfolio, 'nokri_cand_large');
                                            $portfolio_html .= '<div class="col-12 col-sm-12 col-md-6 col-lg-4 col-xl-4 col-xxl-4"><div class="portfolio-img"><a href="' . esc_url($portfolio_image_lg[0]) . '"><img src="' . esc_url($portfolio_image_sm[0]) . '" alt= "' . esc_attr__('portfolio image', 'nokri') . '"></a></div></div>';
                                        }
                                        ?>

                                        <?php
                                        echo '' . ($portfolio_html);
                                        ?> </div>
                                </div><?php
                            }
                        }
                        if (!empty($emp_video)) {
                            ?>
                            <div class="portfolio-video">
                                <h3 class="heading"><?php echo nokri_feilds_label('emp_vid_lab', esc_html__('Employer Video', 'nokri')); ?></h3>
                                <?php
                                $rx = '~
					^(?:https?://)?                          # Optional protocol
					(?:www[.])?                              # Optional sub-domain
					(?:youtube[.]com/watch[?]v=|youtu[.]be/) # Mandatory domain name (w/ query string in .com)
					([^&]{11})                               # Video id of 11 characters as capture group 1
								~x';
                                $valid = preg_match($rx, $emp_video, $matches);
                                $emp_video = $matches[1];
                                ?>
                                <iframe width="690" height="320" src="https://www.youtube.com/embed/<?php echo "" . esc_url($emp_video); ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
                            </div>
                            <?php
                        }
                        ?>
                        <div class="row">
                            <?php
                            $is_access = ( isset($nokri['emp_team_members']) && $nokri['emp_team_members'] != "" ) ? $nokri['emp_team_members'] : false;
                            if ($is_access) {
                                $team_memebers = get_user_meta($user_id, '_nokri_member_info', true);
                                $final_data = $team_memebers != "" ? $team_memebers : array();
                                if (is_array($final_data) && !empty($final_data)) {
                                    ?>                          
                                    <h3 class="heading"><?php echo esc_html__('Team Members', 'nokri'); ?> </h3>

                                    <?php
                                    foreach ($final_data as $key => $data) {
                                        $team_member_image = ( isset($data['team_member_image']) && $data['team_member_image'] != "" ) ? $data['team_member_image'] : '';
                                        $image_source_arr = $team_member_image != "" ? wp_get_attachment_image_src($team_member_image) : array();
                                        $image_source = isset($image_source_arr [0]) ? $image_source_arr[0] : "";
                                        $team_member_title = ( isset($data['team_member_title']) && $data['team_member_title'] != "" ) ? $data['team_member_title'] : '';
                                        $team_member_designation = ( isset($data['team_member_designation']) && $data['team_member_designation'] != "" ) ? $data['team_member_designation'] : '';
                                        $team_member_fburl = ( isset($data['team_member_fburl']) && $data['team_member_fburl'] != "" ) ? $data['team_member_fburl'] : '';
                                        $team_member_twiturl = ( isset($data['team_member_twiturl']) && $data['team_member_twiturl'] != "" ) ? $data['team_member_twiturl'] : '';
                                        $team_member_linkedin = ( isset($data['team_member_linkedin']) && $data['team_member_linkedin'] != "" ) ? $data['team_member_linkedin'] : '';
                                        ?>
                                        <div class="col-lg-4">
                                            <div class=" prf-description prf-member-box <?php echo esc_attr($key); ?>">
                                                <figure class="team-grid">
                                                    <div class="team-header">
                                                        <div class="team-img">
                                                            <img class="rounded-circle " src="<?php echo esc_url($image_source); ?> " alt="Image Description"> 
                                                        </div>
                                                        <div class="team-body">
                                                            <h4 class=""><?php echo esc_html($team_member_title); ?></h4>
                                                            <div class="d-block">
                                                                <i class=""></i>
                                                                <span class=""><?php echo esc_html($team_member_designation); ?></span>
                                                            </div>
                                                            <ul class="_nokri-team-social-media">                                     
                                                                <li> <a href="<?php echo esc_url($team_member_fburl); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/006-facebook.png'); ?>" alt="<?php echo esc_attr__('icon', 'nokri'); ?>" target="_blank"></a></li>
                                                                <li> <a href="<?php echo esc_url($team_member_twiturl); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/004-twitter.png'); ?>" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                                                                <li> <a href="<?php echo esc_url($team_member_linkedin); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/005-linkedin.png'); ?>" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                                                            </ul>
                                                        </div>
                                                    </div>
                                                </figure>
                                            </div>
                                        </div>
                                        <?php
                                    }
                                }
                            }
                            ?>
                        </div> 
                    </div>
                    <?php get_template_part('template-parts/profiles/rating'); ?>
                </div>
                <div class="col-12 col-sm-12 col-md-12 col-lg-4 col-xl-4 col-xxl-4">
                    <?php if ($emp_profile_status == 'pub' || $author_id == $current_user_id) { ?>
                        <div class="contact-us">
                            <h4 class="title"><?php echo nokri_feilds_label('emp_det', esc_html__('Employer Details', 'nokri')); ?></h4>
                            <ul>
                                <?php if ($emp_address) { ?>
                                    <li>
                                        <div class="item">
                                            <i class="fa fa-location-arrow fa-lg"></i>
                                            <p><span><?php echo nokri_feilds_label('emp_loc_section_label', esc_html__('Location: ', 'nokri')); ?></span>
                                                <?php echo esc_html($emp_address); ?></p>
                                        </div>
                                    </li>
                                <?php } if ($emp_size) { ?>
                                    <li>
                                        <div class="item">
                                            <i class="fa fa-users fa-lg"></i>
                                            <p><span><?php echo nokri_feilds_label('emp_no_emp_label', esc_html__('Employees: ', 'nokri')); ?></span>
                                                <?php echo esc_html($emp_size); ?></p>
                                        </div>
                                    </li>
                                <?php } if ($is_public || $author_id == $current_user_id) { ?>
                                    <li>
                                        <div class="item">
                                            <i class="fa fa-envelope fa-lg"></i>
                                            <a href="mailto:<?php echo esc_attr($author->user_email); ?>"></a><p><span><?php echo nokri_feilds_label('emp_email_label', esc_html__('Email:', 'nokri')); ?></span>
                                                <?php echo esc_html($author->user_email); ?></p>
                                        </div>
                                    </li>
                                <?php } if ($emp_web && nokri_feilds_operat('emp_web_setting', 'show')) { ?>
                                    <li>
                                        <div class="item">
                                            <i class="fa fa-globe fa-lg"></i>
                                            <p><span><?php echo nokri_feilds_label('emp_web_label', esc_html__('Website:', 'nokri')); ?></span>
                                                <a href="<?php echo esc_url($emp_web); ?>" target="_blank"></a><?php echo esc_html($emp_web); ?></p>
                                        </div>
                                    </li>
                                <?php } if ($is_public && $author_id == $current_user_id) { ?>
                                    <li>
                                        <div class="item">
                                            <i class="fa fa-phone-square fa-lg"></i>
                                            <p><span><?php echo nokri_feilds_label('emp_phone_label', esc_html__('Contact Us:', 'nokri')); ?></span>
                                                <a href="tel:<?php echo esc_attr($emp_cntct); ?>"></a><?php echo esc_html($emp_cntct); ?></p>
                                        </div>
                                    </li>
                                <?php } ?>
                            </ul>
                        </div>
                        <?php if (isset($registration_feilds) && $registration_feilds != '' || isset($custom_feilds_emp) && $custom_feilds_emp != '') { ?>
                            <div class="n-candidate-info n-camp-custom-fields contact-us custom-detail">
                                <h4 class="widget-heading title"><?php echo nokri_feilds_label('user_custom_feild_txt', esc_html__('Custom Fields', 'nokri')); ?></h4>
                                <?php echo '<div class="n-single-meta"><div class="resume-detail-meta"><ul class="n-single-meta-detail">' . $registration_feilds . $custom_feilds_emp . '</ul></div></div>'; ?>
                            </div>
                            <?php
                        }
                    }
                    /* Advertisement Module */
                    $advertisement = '';
                    if (isset($nokri['employe_advert_btn']) && $nokri['employe_advert_btn'] == "1") {
                        /* Above joba */
                        if (isset($nokri['search_job_advert_up']) && $nokri['search_job_advert_up'] != "") {
                            $advertisement = $nokri['employe_advert_link'];
                        }
                    }
                    ?>
                    <div class="right-side-banner">
                        <?php echo '' . $advertisement ?>
                    </div>
                    <?php
                    $skills_tags = '';
                    if ((array) $emp_skills && $emp_skills > 0) {
                        $taxonomies = get_terms('emp_specialization', array('hide_empty' => false, 'orderby' => 'id', 'order' => 'ASC', 'parent' => 0));
                        if (count((array) $taxonomies) > 0) {
                            foreach ($taxonomies as $taxonomy) {
                                $link = get_the_permalink($employer_search_page) . "?emp_skills=" . $taxonomy->term_id;
                                if (in_array($taxonomy->term_id, $emp_skills)) {
                                    $skills_tags .= '<li><a href="' . esc_url($link) . '" target="_blank">' . esc_html($taxonomy->name) . '</a></li>';
                                }
                            }
                        }
                    }
                    if ($skills_tags != "" && $emp_spec_switch) {
                        ?>
                        <div class="specialization">
                            <h3 class="heading"><?php echo nokri_feilds_label('emp_spec_label', esc_html__('Employer Specialization', 'nokri')); ?></h3>
                            <?php echo '<ul>' . $skills_tags . '</ul>'; ?>
                        </div>
                        <?php
                    }
                    /* Showing employer location on Maps */
                    if ($emp_loc && $loc_sec && $allow_map && $is_lat_long) {
                        $ad_map_lat = get_user_meta($author_id, '_emp_map_lat', true);
                        $ad_map_long = get_user_meta($author_id, '_emp_map_long', true);
                        if ($mapType == 'google_map' && $is_lat_long) {
                            ?>
                            <div class="location">
                                <h3 class="heading"><?php echo esc_html__('Location', 'nokri'); ?></h3>
                                <div class="location-map">
                                    <div id="googleMap" style="width:100%; height: 300px"></div>
                                </div>
                            </div>
                            <?php
                            $call_back = 'myMap';
                            if (isset($nokri['gmap_api_key']) && $nokri['gmap_api_key'] != "") {
                                $api_key = $nokri['gmap_api_key'];
                            }
                            echo '
                                <script>
                                    function myMap() {
                                    const myLatLng = { lat: ' . esc_attr($ad_map_lat) . ',lng: ' . esc_attr($ad_map_long)  . ' };
                                        var mapProp = {
                                            center: new google.maps.LatLng(' . esc_attr($ad_map_lat) . ', ' . esc_attr($ad_map_long) . '),
                                            zoom: 10,
                                            center: myLatLng,
                                        };
                                        var map = new google.maps.Map(document.getElementById("googleMap"), mapProp);
                                        const marker = new google.maps.Marker({
                                        position: myLatLng,
                                        map: map,
                                      });    
                                }
                                </script> 
                               <script src="https://maps.googleapis.com/maps/api/js?key=' . esc_attr($api_key ). '&libraries=places&callback=' . esc_attr($call_back) . '" type="text/javascript"></script>';
                        }
                        if ($mapType == 'leafletjs_map') {
                            ?>
                            <div class="location">
                                <h3 class="heading"><?php echo esc_html__('Location', 'nokri'); ?></h3>
                                <div class="location-map">
                                    <div id="dvMap" style="width:100%; height: 300px"></div>
                                </div>
                            </div>
                            <?php
                        }
                        if ($mapType == 'leafletjs_map') {
                            echo '' . $lat_lon_script = '<script type="text/javascript">
                                var mymap = L.map(\'dvMap\').setView([' . esc_attr($ad_map_lat) . ', ' . esc_attr($ad_map_long) . '], 13);
                                L.tileLayer(\'https://cartodb-basemaps-{s}.global.ssl.fastly.net/light_all/{z}/{x}/{y}{r}.png\', {
                                        maxZoom: 18,
                                        attribution: \'\'
                                }).addTo(mymap);
                                var markerz = L.marker([' . esc_attr($ad_map_lat) . ', ' . esc_attr($ad_map_long) . '],{draggable: true}).addTo(mymap);
                                var searchControl 	=	new L.Control.Search({
                                        url: \'//nominatim.openstreetmap.org/search?format=json&q={s}\',
                                        jsonpParam: \'json_callback\',
                                        propertyName: \'display_name\',
                                        propertyLoc: [\'lat\',\'lon\'],
                                        marker: markerz,
                                        autoCollapse: true,
                                        autoType: true,
                                        minLength: 2,
                                });
                                searchControl.on(\'search:locationfound\', function(obj) {
                                        var lt	=	obj.latlng + \'\';
                                        var res = lt.split( "LatLng(" );
                                        res = res[1].split( ")" );
                                        res = res[0].split( "," );
                                        document.getElementById(\'ad_map_lat\').value = res[0];
                                        document.getElementById(\'ad_map_long\').value = res[1];
                                });
                                mymap.addControl( searchControl );
                                markerz.on(\'dragend\', function (e) {
                                  document.getElementById(\'ad_map_lat\').value = markerz.getLatLng().lat;
                                  document.getElementById(\'ad_map_long\').value = markerz.getLatLng().lng;
                                });
                            </script>';
                        }
                    }
                    ?>
                    <div class="form-box">
                        <div class="n-widget widget">
                            <?php if ($is_public_contact) { ?>
                                <h3 class="widget-heading"><?php
                                    echo nokri_feilds_label('emp_cont_lab', esc_html__('Contact ', 'nokri')) . " ";
                                    echo esc_html(the_author_meta('display_name', $user_id));
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
                                    <input type="hidden" name="receiver_id" value="<?php echo esc_attr($author_id); ?>" />
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
                                    <?php wp_nonce_field('contact_me_nonce_action', 'contact_me_nonce'); ?>
                                    <button type="submit" class="btn n-btn-flat btn-mid btn-block contact_me"><?php echo esc_html__('Message', 'nokri'); ?></button>
                                </form>
                            <?php } ?>
                        </div>
                    </div>
                    <?php
                    if ($soc_sec && $social_links || $author_id == $current_user_id) {
                        if ($emp_fb || $emp_google || $emp_twitter || $emp_linkedin) {
                            ?>
                            <div class="social-box">
                                <h4 class="title"><?php echo esc_html('Find us on', 'nokri'); ?></h4>
                                <ul>
                                    <?php if ($emp_fb) { ?>
                                        <li> <a href="<?php echo esc_url($emp_fb); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/006-facebook.png'); ?>" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                                    <?php } if ($emp_google) { ?>
                                        <li> <a href="<?php echo esc_url($emp_google); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/003-google-plus.png'); ?>" alt="<?php echo esc_attr__('icon', 'nokri'); ?>" target="_blank"></a></li>
                                    <?php } if ($emp_twitter) { ?>
                                        <li> <a href="<?php echo esc_url($emp_twitter); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/004-twitter.png'); ?>" alt="<?php echo esc_attr__('icon', 'nokri'); ?>"></a></li>
                                    <?php } if ($emp_linkedin) { ?>
                                        <li> <a href="<?php echo esc_url($emp_linkedin); ?>" target="_blank"><img src="<?php echo esc_url(get_template_directory_uri() . '/images/icons/005-linkedin.png'); ?>" alt="<?php echo esc_attr('icon', 'nokri'); ?>"></a></li>
                                    <?php } ?>
                                </ul>
                            </div>
                            <?php
                        }
                    }
                    $args = array(
                        'post_type' => 'job_post',
                        'orderby' => 'id',
                        'order' => 'DESC',
                        'posts_per_page' => $jobs_limts,
                        'author' => $author_id,
                        'post_status' => 'publish',
                        'meta_query' => array(array('key' => '_job_status', 'value' => 'active', 'compare' => '=',
                            ),
                        ),
                    );
                    $results = new WP_Query($args);
                    if ($results->have_posts()) {
                        ?>
                        <div class="fr-ads-list">
                            <?php
                            while ($results->have_posts()) {
                                ?>
                                <div class="fr-ads-box">
                                    <?php
                                    $results->the_post();
                                    $rel_post_id = get_the_id();
                                    $rel_post_author_id = get_post_field('post_author', $rel_post_id);
                                    /* Getting Company  Profile Photo */
                                    $comp_img_html = '';
                                    $rel_image_link[0] = get_template_directory_uri() . '/images/candidate-dp.jpg';
                                    if (isset($nokri['nokri_user_dp']['url']) && $nokri['nokri_user_dp']['url'] != "") {
                                        $rel_image_link = array($nokri['nokri_user_dp']['url']);
                                    }
                                    if (get_user_meta($rel_post_author_id, '_sb_user_pic', true) != "") {
                                        $attach_id = get_user_meta($rel_post_author_id, '_sb_user_pic', true);
                                        $rel_image_link = wp_get_attachment_image_src($attach_id, 'nokri_job_post_single');
                                    }
                                    if ($rel_image_link[0] != '') {
                                        $comp_img_html = '<img src="' . esc_url($rel_image_link[0]) . '" alt="' . esc_attr__('logo', 'nokri') . '">';
                                    }
                                    $job_deadline_n = get_post_meta($rel_post_id, '_job_date', true);
                                    $job_deadline = date_i18n(get_option('date_format'), strtotime($job_deadline_n));
                                    $job_salary = wp_get_post_terms($rel_post_id, 'job_salary', array("fields" => "ids"));
                                    $job_salary = isset($job_salary[0]) ? $job_salary[0] : '';
                                    $job_salary_type = wp_get_post_terms($rel_post_id, 'job_salary_type', array("fields" => "ids"));
                                    $job_salary_type = isset($job_salary_type[0]) ? $job_salary_type[0] : '';
                                    $job_experience = wp_get_post_terms($rel_post_id, 'job_experience', array("fields" => "ids"));
                                    $job_experience = isset($job_experience[0]) ? $job_experience[0] : '';
                                    $job_currency = wp_get_post_terms($rel_post_id, 'job_currency', array("fields" => "ids"));
                                    $job_currency = isset($job_currency[0]) ? $job_currency[0] : '';
                                    $job_type = wp_get_post_terms($rel_post_id, 'job_type', array("fields" => "ids"));
                                    $job_type = isset($job_type[0]) ? $job_type[0] : '';
                                    /* Calling Funtion Job Class For Badges */
                                    $single_job_badges = nokri_job_class_badg($rel_post_id);
                                    $job_badge_text = '';
                                    if (count((array) $single_job_badges) > 0) {
                                        foreach ($single_job_badges as $job_badge => $val) {
                                            $term_vals = get_term_meta($val);
                                            $bg_color = get_term_meta($val, '_job_class_term_color_bg', true);
                                            $color = get_term_meta($val, '_job_class_term_color', true);
                                            $style_color = '';
                                            if ($color != "") {
                                                $style_color = 'style=" background-color: ' . $bg_color . ' !important; color: ' . $color . ' !important;"';
                                            }
                                            $job_badge_text .= '<li><a href="' . get_the_permalink($nokri['sb_search_page']) . '?job_class=' . $val . '" class="job-class-tags-anchor" ' . $style_color . '><span>' . esc_html(ucfirst($job_badge)) . '</span></a></li>';
                                        }
                                    }
                                    if (is_user_logged_in()) {
                                        $user_id = get_current_user_id();
                                    } else {
                                        $user_id = '';
                                    }
                                    $job_bookmark = get_post_meta($rel_post_id, '_job_saved_value_' . $user_id, true);
                                    if ($job_bookmark == '') {
                                        $save_job = '<a class="n-job-saved save_job" href="javascript:void(0)" data-value = "' . $rel_post_id . '"><i class="fa fa-heart-o"></i></a> ';
                                    } else {
                                        $save_job = '<a class="n-job-saved saved" href="javascript:void(0)"><i class="fa fa-heart"></i></a>';
                                    }
                                    $job_location = nokri_work_location_custom($rel_post_id);
                                    ?>
                                    <div class="left-cont">
                                        <?php echo '' . $comp_img_html; ?>
                                    </div>
                                    <div class="right-cont">
                                        <h5><a href="<?php echo esc_url(the_permalink($rel_post_id)); ?>"><?php echo esc_html(the_title()); ?></a></h5>
                                        <h6><strong><?php echo esc_html__(' Type: ', 'nokri'); ?></strong><?php echo nokri_job_post_single_taxonomies('job_type', $job_type); ?></h6>
                                        <span><small><strong><?php echo esc_html__('Last Date: ', 'nokri'); ?></strong><?php echo '' . esc_html($job_deadline); ?></small></span>
                                    </div>
                                </div>
                            <?php } ?>
                        </div>
                    <?php } else { ?>
                        <div class="social-box">
                            <h4><?php echo esc_html__('No open positions', 'nokri'); ?></h4>
                        </div>
                    <?php } ?>
                </div>
            </div>
        <?php } else {
            ?>
            <div class="col-lg-12 col-md-12 col-sm-12 col-xs-12">
                <div class="locked-profile alert alert-danger fade in" role="alert">
                    <i class="la la-lock"></i><?php echo "" . esc_html( $user_private_txt ); ?>
                </div>
            </div>
        <?php } ?>

    </div>
</section>
<!-- about-company-prf-dtl-end -->