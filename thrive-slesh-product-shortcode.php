<?php
   /*
   Plugin Name: Slesh Custom Woo Product Display
   Plugin URI: http://thriveondesign.dev
   description: a custom plugin created by ThriveOnDesign for BeautySlesh that creates a shortcode display woocommerce products in a custom way. Version 2 now supports Ajax
   Version: 2.1
   Author: Wayne @ ThriveOnDesign
   Author URI: http://thriveondesign.dev
   License: GPL2
   */

   /**
    *
    * The slider/carousel in this plugin makes use of the swiper js library that is pacakged with elementor
    *
    */

  if ( !defined( 'ABSPATH' ) ) exit;

  /**
   * This function is used to create a shortcode that displays the products in a slider on the homepage
   */
  function thriveFeaturedProducts(){
    ob_start(); // an output buffer so that the loop works better with Elementor
    $query_args = [
      'post_type' => 'product',
      'orderby' => 'modified',
      
    ];
    
    $result = new WP_Query($query_args);
    
    ?>
  
  <div class="thrive-product-section-container">
    <div class="thrive-nav-container">
    <div class="thrive-product-swiper swiper-container">
      <div class="thrive-grid-container swiper-wrapper">
        
        <?php if ($result->have_posts()) {
          while ($result->have_posts()) : $result->the_post();
          ?>
          <div class="thrive-grid-card swiper-slide">
            <div class="thrive-image-container">
              <a href="<?php the_permalink();?>">
                  <?php the_post_thumbnail( ); ?>
              </a>
              <div class="thrive-product-overlay">
                <?php woocommerce_simple_add_to_cart(); ?>
              </div>
              <div class="slesh-plus-sign-container">
                <p>+</p>
              </div>
              <div class="thrive-product-added-to-cart-overlay">
                <p>Added to cart</p>
              </div>
            </div>
            <div class="thrive-card-detail">
              <a href="<?php the_permalink();?>" class="tod-product-description"><?php the_title();?></a>          
              <?php $product = wc_get_product( get_the_ID() ); /* get the WC_Product Object */ ?>
              <p class="tod-price"><?php echo $product->get_price_html(); ?></p>
            </div>
          </div>
          <?php
        endwhile;
        wp_reset_postdata(); 
        }
        ?>
      </div>
      
    </div>

    <div class="thrive-slider-navigation swiper-button-prev"></div>
    <div class="thrive-slider-navigation swiper-button-next"></div>
    </div>
    <!-- <div class="swiper-pagination"></div> -->
    
  </div>
  
  <?php
  $out = ob_get_clean(); // get the contents of the buffer and end the buffer
  return $out;
  }

  /**
   * This function controls the display of the products on the products page
   */
  function thriveProductPage(){
    
    $query_args = [
      'post_type' => 'product',
    ];
    $result = new WP_Query($query_args);
    
    ob_start();

    ?>
  
    <div class="thrive-products-container">
      
      <?php if ($result->have_posts()) {
        while ($result->have_posts()) : $result->the_post();
        ?>
        <div class="thrive-grid-card">
          <div class="thrive-image-container">
            <a href="<?php the_permalink();?>">
                  <?php the_post_thumbnail( ); ?>
            </a>
            
            <div class="thrive-product-overlay">
              <?php woocommerce_simple_add_to_cart(); ?>
            </div>
            <div class="slesh-plus-sign-container">
              <p>+</p>
            </div>
            <div class="thrive-product-added-to-cart-overlay">
              <p>Added to cart</p>
            </div>
          </div>
          <div class="thrive-card-detail">
            <a href="<?php the_permalink();?>" class="tod-product-description"><?php the_title();?></a>       
            <?php $product = wc_get_product( get_the_ID() ); /* get the WC_Product Object */ ?>
            <p class="tod-price"><?php echo $product->get_price_html(); ?></p>
          </div>
        </div>
        <?php
    endwhile;
    wp_reset_postdata();
  }
    ?>
  </div>

  <?php
  $out = ob_get_clean();
  return $out;
  }


  /**
   * load the javascript file that controls the carousel for this plug in it is dependent on JQuery as well as swiper js that comes with Elementor
   */ 

  function thrive_plugin_scripts() {
    wp_enqueue_script ('thriveProductSlider', plugin_dir_url(__FILE__).'/assets/script/thriveProductSlider.js', ['jquery', 'swiper'], time(), true);
    wp_enqueue_script ('thriveProductCustScript', plugin_dir_url(__FILE__).'/assets/script/thriveProductCustScript.js', '', time(), true);
  } 
  
  add_action( 'wp_enqueue_scripts', 'thrive_plugin_scripts');

  // load the styles for the plugin

  function enqueue_thrive_product_style() {
    wp_enqueue_style('thriveProductStyles', plugin_dir_url(__FILE__).'/assets/css/thriveProductStyles.css', '', time());
  }
  
  add_action('wp_enqueue_scripts', 'enqueue_thrive_product_style', 11);

  /**
   * for Ajax
   */
  
  add_action( 'init', 'thrive_ajax_script_enqueuer' );
  
  function thrive_ajax_script_enqueuer() {
    // registering the js file that will have the ajax call
    wp_register_script( 'thrive-ajax-add-to-cart', plugin_dir_url(__FILE__).'/assets/script/thriveAjaxAddToCart.js', array( 'jquery' ), time(), true );
    // passing variables from this file to the js file where the ajax call will be
    wp_localize_script( 
        'thrive-ajax-add-to-cart', 
        'myAjax', 
        [
          // 'ajax_url'  => admin_url( 'admin-ajax.php' ),
          // 'nonce'     => wp_create_nonce( 'nonce_name' )
        ]
        );

    wp_enqueue_script( 'jquery' );
    wp_enqueue_script( 'thrive-ajax-add-to-cart' );
  }


  //make ajax function available to loggin users
  add_action("wp_ajax_woocommerce_ajax_add_to_cart", "woocommerce_ajax_add_to_cart");
  //make ajax available to users who are not logged in
  add_action("wp_ajax_nopriv_woocommerce_ajax_add_to_cart", "woocommerce_ajax_add_to_cart");

  function woocommerce_ajax_add_to_cart() {
    // check_ajax_referer( 'nonce_name' );
    $product_id = apply_filters('woocommerce_add_to_cart_product_id', absint($_POST['product_id']));
    $quantity = empty($_POST['quantity']) ? 1 : wc_stock_amount($_POST['quantity']);
    $variation_id = absint($_POST['variation_id']);
    $passed_validation = apply_filters('woocommerce_add_to_cart_validation', true, $product_id, $quantity);
    $product_status = get_post_status($product_id);

    if ($passed_validation && WC()->cart->add_to_cart($product_id, $quantity, $variation_id) && 'publish' === $product_status) {

        do_action('woocommerce_ajax_added_to_cart', $product_id);

        if ('yes' === get_option('woocommerce_cart_redirect_after_add')) {
            wc_add_to_cart_message(array($product_id => $quantity), true);
        }

        WC_AJAX :: get_refreshed_fragments();
    } else {

        $data = array(
            'error' => true,
            'product_url' => apply_filters('woocommerce_cart_redirect_after_error', get_permalink($product_id), $product_id));

        echo wp_send_json($data);
    }

    wp_die();

  }


  /**
   * end Ajax
   */

  /**
   * This creates the shortcode that can be inserted anywhere in WP
   */
  add_shortcode('thrive-featured-products', 'thriveFeaturedProducts');
  add_shortcode('thrive-products-page', 'thriveProductPage');

?>