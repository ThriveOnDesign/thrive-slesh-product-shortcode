
jQuery('.thrive-grid-card .thrive-product-overlay form.cart').click( function( event ){
  event.preventDefault();

  var qty = jQuery( this ).find( 'input.qty' ).val();
  var product_id = jQuery( this ).find( 'button[name="add-to-cart"]' ).val();

  console.log(qty);
  console.log(product_id);


  jQuery.ajax({
       type : "post",
       dataType : "json",
       url : myAjax.ajax_url,
       data : {
           action: "thrive_ajax_add_to_cart", 
           qty : qty, 
           product_id: product_id,
           _ajax_nonce: myAjax.nonce
      },
       success: function(response) {
          if(response.type == "success") {
             console.log("Ajax call successfully made");
          }
          else {
             console.log("Something went wrong")
          }
       }
    }) 

} );