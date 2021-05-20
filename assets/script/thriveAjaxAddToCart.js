(function ($) {
   $( document ).on( 'click', '.single_add_to_cart_button', function(e) {
      e.preventDefault();
      
      var $thisbutton = $(this), 
            $form = $thisbutton.closest('form.cart'),
            id = $thisbutton.val(),
            product_qty = $form.find('input[name=quantity]').val() || 1,
            product_id = $form.find('input[name=product_id]').val() || id,
            variation_id = $form.find('input[name=variation_id]').val() || 0;

      console.log(product_id);
      console.log(product_qty);

      var data = {
         action: 'woocommerce_ajax_add_to_cart',
         product_id: product_id,
         product_sku: '',
         quantity: product_qty,
         variation_id: variation_id,
      };

      $(document.body).trigger('adding_to_cart', [$thisbutton, data]);

      $.ajax({
         type: 'post',
         url: wc_add_to_cart_params.ajax_url,
         data: data,
         beforeSend: function (response) {
             $thisbutton.removeClass('added').addClass('loading');
         },
         complete: function (response) {
             $thisbutton.addClass('added').removeClass('loading');
         },
         success: function (response) {

             if (response.error & response.product_url) {
                 window.location = response.product_url;
                 return;
             } else {
                 $(document.body).trigger('added_to_cart', [response.fragments, response.cart_hash, $thisbutton]);
             }
         },
     });

   });
})(jQuery);


// jQuery('.thrive-grid-card .thrive-product-overlay form.cart').click( function( event ){
//   event.preventDefault();

//   var qty = jQuery( this ).find( 'input.qty' ).val();
//   var product_id = jQuery( this ).find( 'button[name="add-to-cart"]' ).val();

//   console.log(qty);
//   console.log(product_id);


//   jQuery.ajax({
//        type : "post",
//        dataType : "json",
//        url : myAjax.ajax_url,
//        data : {
//            action: "thrive_ajax_add_to_cart", 
//            qty : qty, 
//            product_id: product_id,
//            _ajax_nonce: myAjax.nonce
//       },
//        success: function(response) {
//           if(response.type == "success") {
//              console.log("Ajax call successfully made");
//           }
//           else {
//              console.log("Something went wrong")
//           }
//        }
//     }) 

// } );