<?php
/**
 * Single Product Up-Sells
 *
 * This template can be overridden by copying it to yourtheme/woocommerce/single-product/up-sells.php.
 *
 * HOWEVER, on occasion WooCommerce will need to update template files and you
 * (the theme developer) will need to copy the new files to your theme to
 * maintain compatibility. We try to do this as little as possible, but it does
 * happen. When this occurs the version of the template file will be bumped and
 * the readme will list any important changes.
 *
 * @see         https://docs.woocommerce.com/document/template-structure/
 * @package     WooCommerce\Templates
 * @version     9.6.0
 */

if ( ! defined( 'ABSPATH' ) ) {
	exit;
}

if ( $upsells ) : ?>

	<section class="up-sells upsells products">
		<?php
		$heading = apply_filters( 'woocommerce_product_upsells_products_heading', __( 'You may also like ', 'nokri' ) );

		if ( $heading ) :
			?>
			<h2><?php echo esc_html( $heading ); ?></h2>
		<?php endif; ?>

		<div class="container">
			<div class="row">
				<?php foreach ( $upsells as $upsell ) : ?>

					<?php
					$post_object = get_post( $upsell->get_id() );
					$product = wc_get_product( $upsell->get_id() ); // Get product object

					setup_postdata( $GLOBALS['post'] =& $post_object ); // phpcs:ignore WordPress.WP.GlobalVariablesOverride.Prohibited, Squiz.PHP.DisallowMultipleAssignments.Found
					?>
					<div class="col-lg-2 col-md-3 col-sm-4 col-6">
						<div class="product-listing" style="height:320px;">
						<?php
            echo '<a href="' . esc_url(get_permalink()) . '">' . wp_get_attachment_image($upsell->get_image_id(), 'full', false, array('class' => 'img-fluid')) . '</a>';
							
            echo '<h4><a href="' . esc_url(get_permalink()) . '">' . esc_html(get_the_title()) . '</a></h4>'; ?>
							<p class="price"><?php echo nokri_returnEcho($product->get_price_html()); ?></p>
							<hr class="product-divider">
							
								<?php   woocommerce_template_loop_add_to_cart(array('class' => 'custom-add-to-cart-button btn btn-block n-btn-flat')); 
									?>						
						</div>
					</div>
				<?php endforeach; ?>
			</div>
		</div>

	</section>

	<?php
endif;

wp_reset_postdata();
