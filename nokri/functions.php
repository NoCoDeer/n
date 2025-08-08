<?php
/**
 * The nokri functions and definitions.
 *
 * @link https://developer.wordpress.org/themes/basics/theme-functions/
 *
 * @package nokri
 */
add_action('after_setup_theme', 'nokri_setup');
if (!function_exists('nokri_setup')) :

    /**
     * Sets up theme defaults and registers support for various WordPress features.
     *
     * Note that this function is hooked into the after_setup_theme hook, which
     * runs before the init hook. The init hook is too late for some features, such
     * as indicating support for post thumbnails.
     */
    function nokri_setup() {
        /* ------------------------------------------------ */
        /* Theme Settings */
        /* ------------------------------------------------ */

        require trailingslashit(get_template_directory()) . 'inc/theme_settings.php';

        // require trailingslashit(get_template_directory()) . 'inc/zoom-vendor/autoload.php';


        /* ------------------------------------------------ */
        /* Theme Widgets */
        /* ------------------------------------------------ */

        require trailingslashit(get_template_directory()) . 'inc/widgets.php';

        /* ------------------------------------------------ */
        /* Navigation Menu */
        /* ------------------------------------------------ */

        require trailingslashit(get_template_directory()) . 'inc/nav.php';

        /* ------------------------------------------------ */
        /* Theme Utilities */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'inc/utilities.php';
        require trailingslashit(get_template_directory()) . 'inc/utilities-custom.php';

        /* ------------------------------------------------ */
        /* Redux Options Settings */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'inc/options-init.php';
        /* ------------------------------------------------ */
        /* TGM */
        /* ------------------------------------------------ */

        require trailingslashit(get_template_directory()) . 'tgm/tgm-init.php';

        /* ------------------------------------------------ */
        /* Icons */
        /* ------------------------------------------------ */

        require trailingslashit(get_template_directory()) . 'inc/theme-shortcodes/icons/icons.php';

        /* ------------------------------------------------ */
        /* Authentication */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'inc/theme-shortcodes/classes/authentication.php';

        /* ------------------------------------------------ */
        /* Candidate */
        /* ------------------------------------------------ */
        require trailingslashit(get_template_directory()) . 'inc/theme-shortcodes/classes/candidate.php';
        require trailingslashit(get_template_directory()) . 'inc/theme-shortcodes/short_codes_functions.php';
        require trailingslashit(get_template_directory()) . 'inc/theme-shortcodes/woo_functions.php';
        require trailingslashit(get_template_directory()) . 'inc/theme-shortcodes/classes/jobs.php';

        //Add Nokri Functionality to VC/*
        if (class_exists('WPBakeryVisualComposerAbstract')) {

            if (!function_exists('nokri_add_to_vc')) {

                function nokri_add_to_vc() {
                    require_once trailingslashit(get_template_directory()) . 'inc/theme-shortcodes/shortcodes.php';
                }

            }
            add_action('init', 'nokri_add_to_vc', 5);
        }
    }

endif;
/* ------------------------------------------------ */
/*      Main Resources Functions                   */
/* ------------------------------------------------ */

function nokri_resoucres() {

    /* ------------------------------------------------ */
    /*      Including All Javascript Files            */
    /* ------------------------------------------------ */

    $not_enque = array('edit-profile');

    if (is_singular() && comments_open() && get_option('thread_comments')) {
        wp_enqueue_script('comment-reply');
    }

    /* Jquery-ui */
    wp_enqueue_script('jquery-ui', trailingslashit(get_template_directory_uri()) . 'js/jquery-ui.min.js', false, false, true);
    /* BOOTSTRAP CORE JS */
    // wp_enqueue_script('bootstrap', get_template_directory_uri() . '/js/bootstrap.min.js', false, false, true);
    wp_enqueue_script('bootstrap-js', get_template_directory_uri() . '/js/bootstrap.bundle.min.js', array('jquery'), '5.3.0', true);

    /* Bootstrap-toggle */
    wp_enqueue_script('bootstrap-toggle', trailingslashit(get_template_directory_uri()) . 'js/bootstrap5-toggle.ecmas.min.js', false, false, true);
    /* JQUERY SELECT2 */
    wp_enqueue_script('select2-custom', get_template_directory_uri() . '/js/select2.min.js', false, false, true);
    /* MEGA MENU  */
    wp_enqueue_script('megamenu', get_template_directory_uri() . '/js/mega_menu.min.js', false, false, true);
    /* owl-carousel */
    wp_enqueue_script('owl-carousel', get_template_directory_uri() . '/js/owl-carousel.js', false, false, true);
    /* counterup */
    wp_enqueue_script('counterup', get_template_directory_uri() . '/js/counterup.js', false, false, true);
    /* way point */
    wp_enqueue_script('jquery-waypoints', trailingslashit(get_template_directory_uri()) . 'js/jquery.waypoints.js', false, false, true);
    /* Isotope */
    wp_enqueue_script('isotope', get_template_directory_uri() . '/js/isotope.min.js', false, false, true);
    /* Hello JS */
    wp_enqueue_script('hello', trailingslashit(get_template_directory_uri()) . 'js/hello.js', false, false, true);
    /* Dropzone */
    wp_enqueue_script('dropzone', trailingslashit(get_template_directory_uri()) . 'js/dropzone.js', false, false, true);
    /* Google Recaptcha JS */
    wp_enqueue_script('recaptcha', '//www.google.com/recaptcha/api.js', false, false, true);
    /* Parsley JS */
    wp_enqueue_script('parsley', trailingslashit(get_template_directory_uri()) . 'js/parsley.min.js', false, false, true);
    /* jquery-caret */
    wp_enqueue_script('jquery-caret', trailingslashit(get_template_directory_uri()) . 'js/jquery.caret.min.js', false, false, true);
    /* TagsinputJS */
    wp_enqueue_script('tags', trailingslashit(get_template_directory_uri()) . 'js/jquery.tag-editor.min.js', false, false, true);
    /* File Input */
    wp_enqueue_script('fileinput', trailingslashit(get_template_directory_uri()) . 'js/new/fileinput.min.js', false, false, true);
    /* Jquery Add Input */
    wp_enqueue_script('jquery-add-input', trailingslashit(get_template_directory_uri()) . 'js/new/jquery.add-input-area.min.js', false, false, true);
    /* Date Picker New */
    wp_enqueue_script('datepicker', trailingslashit(get_template_directory_uri()) . 'js/new/datepicker.min.js', false, false, true);
    /* Date Picker Lang */
    wp_enqueue_script('datepicker-en', trailingslashit(get_template_directory_uri()) . 'js/new/date-picker-lang/datepicker.en.js', false, false, true);
    /* Jquery-appear */
    wp_enqueue_script('jquery-appear', trailingslashit(get_template_directory_uri()) . 'js/jquery.appear.js', false, false, true);
    /* Jquery-tipsy */
    wp_enqueue_script('jquery-tipsy', trailingslashit(get_template_directory_uri()) . 'js/jquery.tipsy.min.js', false, false, true);
    /* Jquery-multifield */
    wp_enqueue_script('jquery-multifield', trailingslashit(get_template_directory_uri()) . 'js/jquery.multifield.min.js', false, false, true);
    /* Icheck Library */
    wp_enqueue_script('icheck', trailingslashit(get_template_directory_uri()) . 'js/icheck.min.js', false, false, true);
    /* theia-sticky-sidebar */
    wp_enqueue_script('theia-sticky-sidebar', trailingslashit(get_template_directory_uri()) . 'js/theia-sticky-sidebar.js', false, false, true);
    /* Jquery.fancybox.min */
    wp_enqueue_script('jquery-fancybox', trailingslashit(get_template_directory_uri()) . 'js/jquery.fancybox.min.js', false, false, true);
    /* Toaster JS */
    wp_enqueue_script('toaster', trailingslashit(get_template_directory_uri()) . 'js/toastr.min.js', false, false, true);
    /* Search JS */
    wp_enqueue_script('nokri-search', trailingslashit(get_template_directory_uri()) . 'js/search.js', false, false, true);
    /* Jquery box slider */
    wp_enqueue_script('jquery-bxslider', trailingslashit(get_template_directory_uri()) . 'js/jquery.bxslider.js', false, false, true);
    //if(isset($_GET['tab-data']) && $_GET['tab-data'] == 'resumes-list' ||  isset($_GET['video']) && $_GET['video'] = 'video' )
    //{
    wp_enqueue_script('popup-video-iframe', trailingslashit(get_template_directory_uri()) . 'js/YouTubePopUp.jquery.js', false, false, true);
    //}
    /* jquery-confirm */
    wp_enqueue_script('jquery-confirm', trailingslashit(get_template_directory_uri()) . 'js/jquery-confirm.min.js', false, false, true);
    /* count to */
    wp_enqueue_script('jquery-countto', trailingslashit(get_template_directory_uri()) . 'js/jquery.countTo.js', false, false, true);
    /* Jquery Waypoints  */
    wp_enqueue_script('jquery-waypoints', get_template_directory_uri() . '/js/waypoints.min.js', false, false, true);
    /* jquery-te  */
    wp_enqueue_script('jquery-te', trailingslashit(get_template_directory_uri()) . 'js/jquery-te.min.js', false, false, true);
    /* jquery-te  */
    wp_enqueue_script('color-switcher', trailingslashit(get_template_directory_uri()) . 'js/color-switcher.js', false, false, true);
    /* tinymce editor  */
    wp_enqueue_script('tinymce-editor', trailingslashit(get_template_directory_uri()) . 'js/tinymce.min.js', false, false, true);

  
    global $nokri;

    $is_allow_crop = isset($nokri['user_crop_dp_switch']) ? $nokri['user_crop_dp_switch'] : false;

    if ($is_allow_crop && is_page_template('page-dashboard.php')) {

        wp_enqueue_style('img-croper', get_template_directory_uri() . '/css/new/cropper.min.css', array(), time());
        /* jquery-croper */
        wp_enqueue_script('img-cropers', trailingslashit(get_template_directory_uri()) . 'js/new/cropper.min.js', false, false, true);
    }
    if (is_page_template('page-dashboard.php')) {

        wp_enqueue_script('Jquery-date-en', trailingslashit(get_template_directory_uri()) . 'js/new/date-en-US.js', false, false, true);
        wp_enqueue_script('Jquery-timeselect', trailingslashit(get_template_directory_uri()) . 'js/new/jquery.ui.timeselect.js', false, false, true);
        wp_enqueue_script('jquery-typehead', trailingslashit(get_template_directory_uri()) . 'js/new/typeahead.adv.js', false, false, true);
    }

    $mapType = nokri_mapType();
    /* Is map show */
    $is_lat_long = isset($nokri['allow_lat_lon']) ? $nokri['allow_lat_lon'] : true;
    $indeed_pub_id = isset($nokri['nokri_indeed_publisher_id']) ? $nokri['nokri_indeed_publisher_id'] : '';
    if (isset($nokri['search_page_layout']) && $nokri['search_page_layout'] == 3) {
        /* jquery-te  */
        wp_enqueue_script('dummylatlng', trailingslashit(get_template_directory_uri()) . 'js/dummylatlng.js', false, false, true);
    }
    $allow_map = isset($nokri['nokri_allow_map']) ? $nokri['nokri_allow_map'] : true;

    if ($mapType == 'leafletjs_map') {
        /* Open Street Map In The API */
        if (!is_rtl()) {
            wp_enqueue_style('leaflet', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet.css');
        } else {
            wp_enqueue_style('leaflet', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-rtl.css');
        }

/* Full Screen Control for Leaflet Map */

        wp_register_script('leaflet-fullscreen',trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-fullscreen.js', false, false, false);
          
        wp_enqueue_style('leaflet-full', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-fullscreen.css');

        wp_enqueue_style('leaflet-search', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-search.min.css');
        wp_register_script('leaflet', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet.js', false, false, false);
        wp_register_script('leaflet-markercluster', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet.markercluster.js', false, false, false);

        wp_register_script('leaflet-search', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-search.min.js', false, false, false);
        wp_enqueue_script('leaflet');
        wp_enqueue_script('leaflet-markercluster');
        wp_enqueue_script('leaflet-fullscreen');
        wp_enqueue_script('leaflet-search');
    } else if ($mapType == 'no_map') {
        /* No Mapp In The Theme */
    } else {
        if (isset($nokri['gmap_api_key']) && $nokri['gmap_api_key'] != "") {
            $can_profile = isset($_GET['candidate-page']) ? $_GET['candidate-page'] : 'no';

            global $nokri;
            $stricts = '';
            if (isset($nokri['sb_location_allowed']) && !$nokri['sb_location_allowed'] && isset($nokri['sb_list_allowed_country'])) {
                $stricts = "componentRestrictions: {country: " . json_encode($nokri['sb_list_allowed_country']) . "}";
            }
            $tab_data = isset($_GET['tab-data']) ? $_GET['tab-data'] : 'no';
            if (isset($_GET['tab-data']) && $_GET['tab-data'] == 'edit-profile' || isset($_GET['candidate-page']) && $_GET['candidate-page'] == 'edit-profile' || wp_basename(get_page_template()) == 'page-job-post.php' || wp_basename(get_page_template()) == 'page-search.php' || is_single()) {
                wp_enqueue_script('nokri-gmaps-loader', trailingslashit(get_template_directory_uri()) . 'js/gmap-loader.js', array(), false, true);
                wp_localize_script('nokri-gmaps-loader', 'nokriGmapSettings', array(
                    'key'       => $nokri['gmap_api_key'],
                    'callback'  => 'nokri_location',
                    'selectors' => '#dvMap,#googleMap,#itemMap,#contact-map',
                    'mapId'     => '62ae976f52d8622990c44af3',
                ));
            }
        }
    }
    /* search with map options */
    if (is_page_template('page-search.php') && isset($nokri['search_page_layout']) && $nokri['search_page_layout'] == 3 && $mapType != 'leafletjs_map') {
        /* Open Street Map In The API */
        if (!is_rtl()) {
            wp_enqueue_style('leaflet', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet.css');
        } else {
            wp_enqueue_style('leaflet', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-rtl.css');
        }
        wp_enqueue_style('leaflet-search', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-search.min.css');
        wp_register_script('leaflet', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet.js', false, false, false);
        wp_register_script('leaflet-markercluster', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet.markercluster.js', false, false, false);

        wp_register_script('leaflet-search', trailingslashit(get_template_directory_uri()) . 'assets/leaflet/leaflet-search.min.js', false, false, false);

        wp_enqueue_script('leaflet');
        wp_enqueue_script('leaflet-markercluster');
        wp_enqueue_script('leaflet-search');
    }

    /* perfect scroller  */
    wp_enqueue_script('perfect-scrollbar', trailingslashit(get_template_directory_uri()) . 'js/perfect-scrollbar.js', false, false, true);
    wp_enqueue_style('perfect-scrollbar', get_template_directory_uri() . '/css/perfect-scrollbar.css', false);

    wp_enqueue_script('admin-stats', trailingslashit(get_template_directory_uri()) . 'js/chart.js', array(), false, false);

    /* star rating */

    if (is_rtl()) {
        /* Rtl JS */
        wp_enqueue_script('nokri-custom-rtl', get_template_directory_uri() . '/js/rtl-custom.js', array('jquery'), false, true);
    } else {
        /* CORE JS */
        wp_enqueue_script('nokri-custom', get_template_directory_uri() . '/js/custom.js', array('jquery'), false, true);
    }


    wp_enqueue_script('nokri-star-rating-js', trailingslashit(get_template_directory_uri()) . 'js/star-rating.js', false, false, true);

    //addding indeed tracking script
    if (is_page_template('page-indeed-search.php') && $indeed_pub_id != '') {

        wp_enqueue_script('indeed-tracking', '//gdc.indeed.com/ads/apiresults.js', false, false, true);
    }

    /* ------------------------------------------------ */
    /*      Including  Fonts                  */
    /* ------------------------------------------------ */
    // if (!is_rtl()) {

    //     if (get_bloginfo("language") == 'hi-IN') {

    //         function nokri_theme_slug_fonts_url() {
    //             $fonts_url = '';
    //             $hind = _x('on', 'Hind: on or off', 'nokri');
    //             if ('off' !== $hind) {
    //                 $font_families = array();
    //                 if ('off' !== $hind) {
    //                     $font_families[] = 'Hind:400,500,600';
    //                 }
    //                 $query_args = array(
    //                     'family' => urlencode(implode('%7C', $font_families)),
    //                     'subset' => urlencode('latin,latin-ext'),
    //                 );
    //                 $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    //             }
    //             return urldecode($fonts_url);
    //         }

    //     } else {

    //         function nokri_theme_slug_fonts_url() {
    //             $fonts_url = '';
    //             $poppins = _x('on', 'Poppins: on or off', 'nokri');
    //             $quicksand = _x('on', 'Quicksand: on or off', 'nokri');
    //             $sans_serif = _x('on', 'Sans Serif: on or off', 'nokri');
    //             if ('off' !== $poppins || 'off' !== $sans_serif) {
    //                 $font_families = array();
    //                 if ('off' !== $poppins) {
    //                     $font_families[] = 'Poppins:400,500,600';
    //                 }
    //                 if ('off' !== $sans_serif) {
    //                     $font_families[] = 'Sans+Serif:400,500,700';
    //                 }
    //                 if ('off' !== $quicksand) {
    //                     $font_families[] = 'Quicksand:400,500,700';
    //                 }
    //                 $query_args = array(
    //                     'family' => urlencode(implode('%7C', $font_families)),
    //                     'subset' => urlencode('latin,latin-ext'),
    //                 );
    //                 $fonts_url = add_query_arg($query_args, 'https://fonts.googleapis.com/css');
    //             }
    //             return urldecode($fonts_url);
    //         }

    //     }
    // }


    /* ------------------------------------------------ */
    /*       Including All CSS                        */
    /* ------------------------------------------------ */
    wp_enqueue_style('nokri-style', get_stylesheet_uri());
    /*  BOOTSTRAPE Theme CSS FILES */
    wp_enqueue_style('bootstrap-theme', get_template_directory_uri() . '/css/bootstrap.min.css', false);
    /*  RTL bootstrap CSS FILE */
    if (is_rtl()) {
        wp_enqueue_style('nokri-bootstrap-rtl', get_template_directory_uri() . '/css/bootstrap-rtl.min.css', false);
    }
    /*  BOOTSTRAPE ICON FILES */
    // wp_enqueue_style('bootstrap-theme', get_template_directory_uri() . '/css/bootstrap-icons.css', false);
    wp_enqueue_style(
        'bootstrap-icons', // Corrected handle name
        get_template_directory_uri() . '/css/bootstrap-icons.css', // Path to the Bootstrap Icons CSS
        array(), // No dependencies, or add Bootstrap CSS if needed
        '1.10.0', // Version number for cache-busting
        'all' // Media type
    );
    
    /*  Mega MENU */
    wp_enqueue_style('megamenu', get_template_directory_uri() . '/css/mega_menu.min.css', false);
    /*  Animate Min CSS FILE */
    wp_enqueue_style('animate-min', get_template_directory_uri() . '/css/animate.min.css', false);
    /*  OWl  CAROUSEL */
    wp_enqueue_style('owl-carousel', get_template_directory_uri() . '/css/owl.carousel.css', false);
    wp_enqueue_style('owl-theme', get_template_directory_uri() . '/css/owl.theme.default.css', false);
    /*  ET Line Fonts CSS FILES */
    wp_enqueue_style('et-line-fonts', get_template_directory_uri() . '/css/et-line-fonts.css', false);
    /*  Wocoomerce CSS FILES */
    wp_enqueue_style('nokri-woo', trailingslashit(get_template_directory_uri()) . 'css/woocommerce.css');
    /*  jquery-te */
    wp_enqueue_style('jquery-te', get_template_directory_uri() . '/css/jquery-te.css', false);
    /*  Font Awsome */
    wp_enqueue_style('font-awesome', get_template_directory_uri() . '/css/font-awesome.min.css', false);
    /*  Line Awsome */
    wp_enqueue_style('line-awesome', get_template_directory_uri() . '/css/line-awesome.min.css', false);
    /* jquery-tagsinput CSS FILES */
    wp_enqueue_style('jquery-tagsinput', get_template_directory_uri() . '/css/jquery.tag-editor.css', false);
    /*  select2  File */
    wp_enqueue_style('select2-min', get_template_directory_uri() . '/css/select2.min.css', false);
    /*  DropZone */
    wp_enqueue_style('dropzone', get_template_directory_uri() . '/css/dropzone.css', false);
    /*  jquery-confirm  */
    wp_enqueue_style('jquery-confirm', get_template_directory_uri() . '/css/jquery-confirm.min.css', false);
    /* Toastr */
    wp_enqueue_style('toastr-min-css', get_template_directory_uri() . '/css/toastr.min.css', false);
    /* Toggle */
    wp_enqueue_style('toggle', get_template_directory_uri() . '/css/bootstrap-toggle.min.css', false);
    /* Fancy Box */
    wp_enqueue_style('jquery-fancybox', get_template_directory_uri() . '/css/jquery.fancybox.min.css', false);
    /* Date Time Picker */
    wp_enqueue_style('datepicker', get_template_directory_uri() . '/css/new/datepicker.min.css', false);
    /* File Input */
    wp_enqueue_style('fileinput', get_template_directory_uri() . '/css/new/fileinput.min.css', false);
    /* Icheck Square */
    wp_enqueue_style('ichecksquare', get_template_directory_uri() . '/css/new/checkbox-square.css', false);
    /* Icheck Boxes */
    wp_enqueue_style('icheck', get_template_directory_uri() . '/css/minimal/minimal.css', false);
    /* Jquery-tipsy */
    wp_enqueue_style('jquery-tipsy', get_template_directory_uri() . '/css/new/jquery.tipsy.css', false);
    /* Themify-icons */
    wp_enqueue_style('themify-icons', get_template_directory_uri() . '/css/new/themify-icons.css', false);
    /* jquery.bxslider */
    wp_enqueue_style('jquery-bxslider', get_template_directory_uri() . '/css/new/jquery.bxslider.css', false);
    //if(isset($_GET['tab-data']) && $_GET['tab-data'] == 'resumes-list' )
    //{
    /* Youtubepopup */
    wp_enqueue_style('popup-video-iframe', get_template_directory_uri() . '/css/YouTubePopUp.css', false);
    /* croppie css */
    if (is_page_template('page-dashboard.php')) {
        wp_enqueue_style('typahead', get_template_directory_uri() . '/css/new/tyahead.css', false);
    }
    //}
    /* Fonts */
    if (!is_rtl()) {
       //wp_enqueue_style('nokri-theme-slug-fonts', nokri_theme_slug_fonts_url(), array(), null);
    }
    wp_enqueue_style('nokri-star-rating', trailingslashit(get_template_directory_uri()) . 'css/star-rating.css');
    // poppins font 
    wp_enqueue_style('roboto-font', get_template_directory_uri() . '/css/fonts/roboto.css', array(), null);
    /* Admin Custom CSS */
    wp_enqueue_style('nokri-admin-custom', get_template_directory_uri() . '/css/admin-custom.css', false);
    /*  Custom CSS */
    wp_enqueue_style('nokri-custom', get_template_directory_uri() . '/css/custom.css', false);
    /*  TEMPLATE CORE CSS */
    wp_enqueue_style('nokri-theme-style', get_template_directory_uri() . '/css/theme.css', false);
    /*  New CSS */
    wp_enqueue_style('nokri-modern', get_template_directory_uri() . '/css/modern.css', false);
    /* Custom New CSS */
    wp_enqueue_style('nokri-modern', plugins_url('custom-new.css', __FILE__), array(), null);

    /* If RTL Is Enable */
    if (is_rtl()) {
        wp_enqueue_style('nokri-rtl-style', get_template_directory_uri() . '/css/rtl-style.css', false);
    }

    /* ------------------------ */
    /* Theme Colours Selections */
    /* ------------------------ */
    global $nokri;
    if (isset($nokri['button-set-colour']) && $nokri['button-set-colour'] != "") {
        $theme_colour = ($nokri['button-set-colour']);
        wp_enqueue_style('nokri-colours', get_template_directory_uri() . '/css/colors/' . $theme_colour . '.css', false);
    } else {
        wp_enqueue_style('nokri-colours', get_template_directory_uri() . '/css/colors/defualt.css', false);
    }
}

add_action('wp_enqueue_scripts', 'nokri_resoucres');
/* ------------------- */
/* Theme Colours Box */
/* ------------------- */

function nokri_footer_content() {
    global $nokri;
    if ((isset($nokri['front_colour'])) && $nokri['front_colour'] == 1) {
        echo '<div class="color-switcher" id="choose_color"> 
    <a href="#." class="picker_close"><i class="fa fa-angle-right"></i></a>
    <h5>' . esc_html__('Color SWITCHER', 'nokri') . '</h5>
    <div class="theme-colours">
        <ul>
            <li>
                <a href="#." class="defualt" id="defualt" title="' . esc_attr__('defualt', 'nokri') . '"></a>
            </li>
            <li>
                <a href="#." class="yellow" id="yellow" title="' . esc_attr__('yellow', 'nokri') . '"></a>
            </li>
			<li>
                <a href="#." class="dark-blue" id="dark-blue" title="' . esc_attr__('Dark Blue', 'nokri') . '"></a>
            </li>
			<li>
                <a href="#." class="red" id="red" title="' . esc_attr__('Red', 'nokri') . '"></a>
            </li>
			<li>
                <a href="#." class="orange" id="orange" title="' . esc_attr__('Orange', 'nokri') . '"></a>
            </li>
			<li>
                <a href="#." class="green" id="green" title="' . esc_attr__('Green', 'nokri') . '"></a>
            </li>
			<li>
                <a href="#." class="purple" id="purple" title="' . esc_attr__('Purple', 'nokri') . '"></a>
            </li>
        </ul>
    </div>
    <div class="clr"></div>
  </div>';

        $color_path = get_template_directory_uri();

        echo '<script>(function($) {
        "use strict";
		  $("#defualt" ).on("click",function(){
			  $("#nokri-colours-css" ).attr("href", "' . esc_url($color_path . '/css/colors/defualt.css') . '");
			  return false;
		  });
		  $("#yellow" ).on("click",function(){
			  $("#nokri-colours-css" ).attr("href", "' . esc_url($color_path . '/css/colors/yellow.css') . '");
			  return false;
		  });
		  $("#dark-blue" ).on("click",function(){
			  $("#nokri-colours-css" ).attr("href", "' . esc_url($color_path . '/css/colors/dark-blue.css') . '");
			  return false;
		  });
		  
		  $("#red" ).on("click",function(){
			  $("#nokri-colours-css" ).attr("href", "' . esc_url($color_path . '/css/colors/red.css') . '");
			  return false;
		  });
		  
		  $("#orange" ).on("click",function(){
			  $("#nokri-colours-css" ).attr("href", "' . esc_url($color_path . '/css/colors/orange.css') . '");
			  return false;
		  });
		  
		  $("#green" ).on("click",function(){
			  $("#nokri-colours-css" ).attr("href", "' . esc_url($color_path . '/css/colors/green.css') . '");
			  return false;
		  });
		  
		  $("#purple" ).on("click",function(){
			  $("#nokri-colours-css" ).attr("href", "' . esc_url($color_path . '/css/colors/purple.css') . '");
			  return false;
		  });  
		  $(".picker_close").on("click",function(){
			  	$("#choose_color").toggleClass("position");
		   });
		   $(".picker_close").on("click",function(){
			  	$(".picker_close i").toggleClass("rotate-arrow");
		   });
})(jQuery);</script>';
    }
}

add_action('wp_footer', 'nokri_footer_content', 999);
/* Updating menu options */
add_action('wp', 'nokri_update_menu_option');
if (!function_exists('nokri_update_menu_option')) {

    function nokri_update_menu_option($user_id = '') {
        if (class_exists('Redux')) {
            $values = Redux::get_option("nokri", "employer_menu_sorter");
            if (isset($values) && !array_key_exists("cart", $values)) {
                foreach ($values as $r_key => $r_val) {
                    $r_key1 = str_replace("udpdate profile", "update profile", $r_key);
                    $new_key = strtolower(str_replace(" ", "_", $r_key1));
                    $new_array[$new_key] = $r_val;
                }
                Redux::setOption("nokri", "employer_menu_sorter", $new_array);
            }
            /* For candidate menu */
            $cand_values = Redux::get_option("nokri", "candidate_menu_sorter");
            if (isset($cand_values) && !array_key_exists("cart", $cand_values)) {
                foreach ($cand_values as $r_key => $r_val) {
                    $r_key1 = str_replace("udpdate profile", "update profile", $r_key);
                    $new_key = strtolower(str_replace(" ", "_", $r_key1));
                    $new_array[$new_key] = $r_val;
                }
                Redux::setOption("nokri", "candidate_menu_sorter", $new_array);
            }
        }
    }

}
/* Elementor Pro Theme Locations */
if (in_array('elementor-pro/elementor-pro.php', apply_filters('active_plugins', get_option('active_plugins')))) {
    add_action('elementor/theme/register_locations', 'nokri_register_elementor_locations');

    function nokri_register_elementor_locations($elementor_theme_manager) {

        $elementor_theme_manager->register_location('header');
        $elementor_theme_manager->register_location('footer');
        // $elementor_theme_manager->register_location( 'single' );
        // $elementor_theme_manager->register_location( 'archive' );
    }

}

/* Archive page custom Title */

function nokri_change_job_archive_title($title) {

    if (is_post_type_archive('job_post')) {
        $title = get_bloginfo('name');
        return $title;
    }
    return $title;
}
function enqueue_custom_admin_script() {
    
    
    wp_enqueue_style('admin-custom-styles', get_template_directory_uri() . '/css/admin-custom.css');
    // Then enqueue your custom admin script
    wp_enqueue_script('nokri-admin-script', get_stylesheet_directory_uri() . '/js/custom-admin-script.js', array('jquery'), '1.0', true);
}

add_action('admin_enqueue_scripts', 'enqueue_custom_admin_script');



//shop page of wocommerce Query to exclude products and packages 

function exclude_package_products_from_shop($query) {
    if (!class_exists('WooCommerce') || is_admin() || ! $query->is_main_query()) {
        return;
    }

    if (is_shop()) {
        $meta_query = $query->get('meta_query');

        // Exclude products with '_nokry_package' = 'yes' OR products where the meta key doesn't exist
        $meta_query[] = array(
            'relation' => 'OR',
            array(
                'key'     => '_nokry_package',
                'value'   => 'yes',
                'compare' => '!=',
            ),
            array(
                'key'     => '_nokry_package',
                'compare' => 'NOT EXISTS', // Check for products where the meta key doesn't exist
            ),
        );

        $query->set('meta_query', $meta_query);
    }
}

add_action('pre_get_posts', 'exclude_package_products_from_shop');



add_filter('body_class', 'nokri_halfhalf_body_class');
function nokri_halfhalf_body_class($classes) {
    global $nokri;

    if (isset($nokri['main_header_style']) && $nokri['main_header_style'] !== '') {
        $header_style = $nokri['main_header_style'];
        
        if ($header_style === '1') {
            if (is_author()) {
                // $user_id = get_current_user_id();
                $author_id = get_query_var('author');
                $user_type = get_user_meta($author_id, '_sb_reg_type', true);

                if ($user_type === '1') {

                    $classes[] = 'my-empl-style-col';
                }
            }
        }
    }
    
    return $classes;
}
function nokri_hidden_files() {
    
    /* Hidden Inputs */
    get_template_part('template-parts/hidden', 'inputs');
    /* Email verification and reset password */
    get_template_part('template-parts/verification', 'logic');
    ?>
    <div id="toast-container" class="toast-top-right">
        <div class="toast toast-success" aria-live="polite" id="progress_loader">
            <div class="toast-title"><?php echo esc_html__('Uploading', 'nokri'); ?></div>
            <div class="toast-message" id="progress_counter"></div>
        </div>
    </div>
    <div id="popup-data"></div>
    <div id="app-data"></div>
    <div id="short-desc-data"></div>
    <div id="status_action_data"></div>
    <div id="job-alert-data"></div>
    <div id="edit_meeting_container_modal"></div>
    <div id="zoom_edit_meeting_container"></div>
    <div id="user_chat_modal_popup"></div>
    <div id="chartcontainer_stats"></div>
    <div id="candidate_report_job"></div>
    <?php
    /* Email job alerts */
    get_template_part('template-parts/job', 'alerts');
}
add_action('wp_footer', 'nokri_hidden_files');
    
// Employer Job Post



// Define global allowed HTML tags and attributes
if ( ! function_exists( 'get_allowed_html_tags' ) ) {
    function get_allowed_html_tags() {
        return array(
            'a' => array(
                'href' => true,   // Allow 'href' attribute in <a> tags
                'title' => true,  // Allow 'title' attribute in <a> tags
                'target' => true,
                'id' => true, // Allow 'target' attribute for opening links in new tab
                'class' => true,
            ),
            'ul' => array(
                'class' => true,
                'id' => true,
            ),
            'ol' => array(
                'class' => true,
                'id' => true,
            ),
            'li' => array(
                'class' => true,
                'id' => true,
            ),
            'i' => array(
                'class' => true, 
                'id' => true, // Allow 'class' attribute for Font Awesome icons
                'aria-hidden' => true,
            ),
            'b' => array(),
            'strong' => array(),
            'em' => array(),
            'p' => array(
                'class' => true,
                'id' => true,
            ),
            'br' => array(),
            'span' => array(
                'style' => true, 
                'id' => true,
                'class' => true, // Allow 'style' attribute for inline styles
            ),
            'img' => array(
                'src' => true,    // Allow 'src' attribute for images
                'alt' => true,    // Allow 'alt' attribute for images
                'width' => true,  // Allow 'width' attribute for images
                'height' => true, // Allow 'height' attribute for images
                'id' => true,
                'class' => true,
            ),
            'input' => array(
                'name' => true,
                'value' => true,
                'type' => true,
                'class' => true,
                'id' => true,
            ),
            'div' => array(
                'class' => true,
                'id' => true,
                'style' => true,
            ),
            'option' => array(
                'value' => true,
                'selected' => true,
                'class' => true,
                'id' => true,
            ),
            'h4' => array(
                'class' => true,
                'id' => true,
                'style' => true,
            ),
            'h3' => array(
                'class' => true,
                'id' => true,
                'style' => true,
            ),
            'h5' => array(
                'class' => true,
                'id' => true,
                'style' => true,
            ),
            'p' => array(
                'class' => true,
                'id' => true,
                'style' => true,
            ),
            'small' => array(
                'class' => true,
                'id' => true,
                'style' => true,
            ),
            
            // Add any additional tags and attributes as needed
        );
    }
}
