<?php
   /*
   Plugin Name: Slesh Custom Woo Product Display
   Plugin URI: http://thriveondesign.dev
   description: a custom plugin created by ThriveOnDesign for BeautySlesh that creates a shortcode display woocommerce products in a custom way
   Version: 1.1
   Author: Wayne @ ThriveOnDesign
   Author URI: http://thriveondesign.dev
   License: GPL2
   */

   /**
    *
    * The slider/carousel in this plugin makes use of the swiper js library that is pacakged with elementor
    *
    */

  /**
   * This function is used to create a shortcode that displays the products in a slider on the homepage
   */
  function thriveFeaturedProducts(){
    ob_start(); // an output buffer so that the loop works better with Elementor
    $query_args = [
      'post_type' => 'product',
    ];
    
    $result = new WP_Query($query_args);
    
    ?>
  
  <div class="thrive-product-section-container">
    <div class="thrive-product-swiper swiper-container">
      <div class="thrive-grid-container swiper-wrapper">
        
        <?php if ($result->have_posts()) {
          while ($result->have_posts()) : $result->the_post();
          ?>
          <div class="thrive-grid-card swiper-slide">
            <div class="thrive-image-container">
              <?php the_post_thumbnail( ); ?>
              <div class="thrive-product-overlay">
                <?php woocommerce_simple_add_to_cart(); ?>
              </div>
              <div class="slesh-plus-sign-container">
                <p>+</p>
              </div>
            </div>
            <div class="thrive-card-detail">
              <p class="tod-product-description"><?php the_title(); ?></p>          
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
      <div class="thrive-slider-navigation swiper-button-prev"></div>
      <div class="thrive-slider-navigation swiper-button-next"></div>
    </div>
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
            <?php the_post_thumbnail( ); ?>
            <div class="thrive-product-overlay">
              <?php woocommerce_simple_add_to_cart(); ?>
            </div>
            <div class="slesh-plus-sign-container">
              <p>+</p>
            </div>
          </div>
          <div class="thrive-card-detail">
            <p class="tod-product-description"><?php the_title(); ?></p>          
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
    wp_enqueue_script ('thriveProductSlider', '/wp-content/plugins/thrive-slesh-product-shortcode/assests/script/thriveProductSlider.js', ['jquery', 'swiper'], time(), true);
  } 
  
  add_action( 'wp_enqueue_scripts', 'thrive_plugin_scripts');

  // load the styles for the plugin

  function enqueue_thrive_product_style() {
    wp_enqueue_style('thriveProductStyles', '/wp-content/plugins/thrive-slesh-product-shortcode/assests/css/thriveProductStyles.css', '', time());
  }
  
  add_action('wp_enqueue_scripts', 'enqueue_thrive_product_style', 11);


  /**
   * This creates the shortcode that can be inserted anywhere in WP
   */
  add_shortcode('thrive-featured-products', 'thriveFeaturedProducts');
  add_shortcode('thrive-products-page', 'thriveProductPage');

?>