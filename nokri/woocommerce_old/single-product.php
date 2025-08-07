<?php
/**
 * The Template for displaying all single products
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce/Templates
 * @version     1.6.4
 */

if (!defined('ABSPATH')) {
    exit; // Exit if accessed directly
}
get_header();

while (have_posts()) : the_post();
?>
<section class="dwt_listing_shop-container-single">
    <div class="container">
        <div class="row">
            <div class="col-md-12 col-sm-12 col-xs-12 nopadding">
                <div class="col-md-5 col-sm-6 col-xs-12">
                    <?php get_template_part('woocommerce/product-detail/gallery'); ?>
                </div>
                <div class="dwt_listing_product-details col-lg-7 col-sm-6 col-xs-12">
                    <div class="dwt_listing_product-title">
                        <h1><?php echo esc_html(get_the_title()); ?></h1>
                    </div>

                    <?php
                    // Display product availability below category
                    echo '<div class="product-availability">' . wc_get_stock_html($product) . '</div>';

                    // Output remaining product details
                    echo '<div class="product-reviews">';
                    get_template_part('woocommerce/product-detail/total_reviews');
                    echo '</div>';

                    echo '<div class="product-info">';
                    get_template_part('woocommerce/product-detail/product_info');

                    echo '<div class="product-description">';
                    get_template_part('woocommerce/product-detail/desc');
                    echo '</div>';
                    echo '</div>';
                    
                    // Uncomment this line to display linked products
                     do_action('woocommerce_single_product_summary');
                    ?>

                    <!-- Add to Cart Button -->
                    <div class="product-add-to-cart">
                        <?php
                            // Display the Add to Cart button
                         //  woocommerce_template_single_add_to_cart();
                        ?>
                    </div>
                </div>
                <div class="col-md-12 col-lg-12 col-xs-12 col-sm-12">
                    <?php get_template_part('woocommerce/product-detail/specifications'); ?>
                </div>
            </div>
        </div>
    </div>
</section>
<?php endwhile; ?>


<section class="related-products">
    <div class="container">
        <div class="row">
            <div class="col-md-12">
                <div class="rel-heading">
                <h2><?php echo esc_html('Related Products'); ?></h2>
                </div>
                <div class="row">
                    <?php
                    // Get the current product's ID
                    $current_product_id = get_the_ID();

                    // Get the product categories for the current product
                    $product_categories = wp_get_post_terms($current_product_id, 'product_cat', array('fields' => 'ids'));

                    if (!empty($product_categories)) {
                        // Query related products within the same category
                        $args = array(
                            'posts_per_page' => 5, // Number of related products to display
                            'post_type' => 'product',
                            'post__not_in' => array($current_product_id), // Exclude the current product
                            'tax_query' => array(
                                array(
                                    'taxonomy' => 'product_cat',
                                    'field' => 'id',
                                    'terms' => $product_categories,
                                    'operator' => 'IN',
                                ),
                            ),
                           
                        );

                        $related_query = new WP_Query($args);

                        while ($related_query->have_posts()) : $related_query->the_post();
                            $related_product = wc_get_product(get_the_ID());

                            ?>
                            <div class="col-md-2">
                                <div class="product-listing">
                                    <?php
                                    // Check if the related product is on sale
                                    if ($related_product->is_on_sale()) {
                                        echo '<span class="sale-shop custom-sale-tag">sale</span>';
                                    }
                                    ?>
                                    <a href="<?php echo esc_url(get_permalink()); ?>">
                                        <?php echo nokri_returnEcho($related_product->get_image()); ?>
                                        <h4><?php echo esc_html(get_the_title()); ?></h4>
                                    </a>
                                    <p class="price"><?php echo nokri_returnEcho($related_product->get_price_html()); ?></p>
                                    <hr class="product-divider">
                                    <?php
                                    
                                    // Add to Cart button
                                    woocommerce_template_loop_add_to_cart(array('class' => 'custom-add-to-cart-button  btn btn-block n-btn-flat'));

                                    // Favorite icon code here

                                    ?>
                                </div>
                            </div>
                            <?php
                        endwhile;
                        wp_reset_postdata();
                    }
                    ?>
                </div>
            </div>
        </div>
    </div>
</section>


<section class="you-may-also-like">
    <div class="container">
      
        <div class="row">
            <?php
            // Display upsell products
            woocommerce_upsell_display();
            ?>
        </div>
    </div>
</section>



<?php
get_footer();
?>
