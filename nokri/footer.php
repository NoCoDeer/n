<?php
global $nokri;
$dashboard_page = $footer_style = '';
$is_elementor_footer = isset($nokri['is_elementor_footer']) ? $nokri['is_elementor_footer'] : false;
if ($is_elementor_footer == false) {
    /* Search page lay out */
    $search_page_layout = ( isset($nokri['search_page_layout']) && $nokri['search_page_layout'] != "" ) ? $nokri['search_page_layout'] : "";
    /* dashboard page */
    $dashboard_page = ( isset($nokri['sb_dashboard_page']) && $nokri['sb_dashboard_page'] != "" ) ? $nokri['sb_dashboard_page'] : "";
    if ((isset($nokri['select_footer_layout'])) && $nokri['select_footer_layout'] != '') {
        $footer_style = ($nokri['select_footer_layout']);
    }
    /* No footer in map search */
    if ($search_page_layout == '3' && basename(get_page_template()) == 'page-search.php') {
        
    } else {
        if (basename(get_page_template()) != 'page-dashboard.php') {
            get_template_part('template-parts/footers/footer', $footer_style);
        }
    }
    /* Hidden Inputs */
    ?>
    </div>
    <?php
    if (isset($nokri['banners_code_footer']) && $nokri['banners_code_footer'] != '') {
        echo ''.($nokri['banners_code_footer']);
    }
    ?> 
    <?php if ((isset($nokri['scroll_to_top'])) && $nokri['scroll_to_top'] == '1') { ?>
        <a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
        <?php
    } echo nokri_authorization();
    wp_footer();
    /* Email job alerts */
    ?>
    <?php
} else {
    // Elementor `footer` location
    if (!function_exists('elementor_theme_do_location') || !elementor_theme_do_location('footer')) {
        get_template_part('template-parts/footer');
    }
    /* Search page layout */
    $search_page_layout = ( isset($nokri['search_page_layout']) && $nokri['search_page_layout'] != "" ) ? $nokri['search_page_layout'] : "";
    /* dashboard page */
    $dashboard_page = ( isset($nokri['sb_dashboard_page']) && $nokri['sb_dashboard_page'] != "" ) ? $nokri['sb_dashboard_page'] : "";
    /* Hidden Inputs */
    ?>
    </div>
    <?php
    if (isset($nokri['banners_code_footer']) && $nokri['banners_code_footer'] != '') {
        echo ''.($nokri['banners_code_footer']);
    }
    ?> 
    <?php if ((isset($nokri['scroll_to_top'])) && $nokri['scroll_to_top'] == '1') { ?>
        <a href="#" class="scrollup"><i class="fa fa-chevron-up"></i></a>
        <?php
    } echo nokri_authorization();
    wp_footer();
    /* Email job alerts */
    ?>
<?php } ?>
</body>
</html>