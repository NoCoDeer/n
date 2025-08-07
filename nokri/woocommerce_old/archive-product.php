<?php
/**
 * The Template for displaying product archives, including the main shop page which is a post type archive
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/archive-product.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see https://docs.woocommerce.com/document/template-structure/
 * @package WooCommerce/Templates
 * @version 8.6.0
 */
if (!defined('ABSPATH')) {
    exit;
}
get_header();
?>
<section class="dwt_listing_shop-container">
    <div class="container">
        <!-- Row -->
        <div class="row">
            <!-- Middle Content Area -->
            <div class="col-md-12 products">
                <div class="clearfix"></div>

                <?php
                do_action('woocommerce_archive_description');
                ?>

                <?php if (wc_get_loop_prop('total')) : ?>
                    <div class="clearfix"></div>
                    <div class="dwt_listing_woo-filters">
                        <div class="col-md-12">
                            <?php do_action('woocommerce_before_shop_loop'); ?>
                        </div>
                    </div>
                    <div class="clearfix"></div>
                    <div class="row">
                        <?php
                        $fetch_products = '';
                        $productz = new dwt_listing_products_shop();
                        $layout_type = 'shop_grid';
                        while (have_posts()) : the_post();
                            $product_id = get_the_ID();
                            $product_type = wc_get_product($product_id);
                            $function = "dwt_listing_shop_listings_$layout_type";
                           
                        ?>
                           <div class="col-lg-3 col-md-4 col-sm-6 col-12 col-lg-4 col-xl-4">
    <div class="product-listing" > <!-- Adjust the height as needed -->
        <?php
        // Display the product image
        echo '<a href="' . esc_url(get_permalink()) . '">' . woocommerce_get_product_thumbnail() . '</a>';
        ?>

        <div class="product-details">
            <!-- Product title -->
        <?php    echo '<h2 class="woocommerce-loop-product__title"><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></h2>';
?>
            <!-- Price and Sale tag container -->
            <div class="price-and-sale">
                <?php
                // Display the product price
                echo '<div class="price">' . $product_type->get_price_html() . '</div>';

                // Check if the product is on sale and add the "Sale" tag
                if ($product_type->is_on_sale()) {
                    echo '<span class="sale-shop">sale</span>';
                }
                ?>
            </div>

            <hr class="product-divider">
            <div class="add-to-cart-wrapper">
                <?php
                // Display the "Add to Cart" button
                woocommerce_template_loop_add_to_cart(array('class' => 'custom-add-to-cart-button  btn btn-block n-btn-flat'));
                ?>
                <!-- Favorite Icon -->
               
            </div>
        </div>
    </div>
</div>

                        <?php endwhile; // end of the loop. ?>
                    </div>
                <?php endif; ?>
            </div>
        </div>
    </div>
    <!-- Main Container End -->
</section>
<?php get_footer(); ?>
