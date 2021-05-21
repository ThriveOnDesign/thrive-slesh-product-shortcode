const plusButton = Array.from(document.querySelectorAll(".slesh-plus-sign-container"));
const addToCartButton = Array.from(document.querySelectorAll(".thrive-product-overlay button.single_add_to_cart_button.button.alt"))
const modal = Array.from(document.querySelectorAll('.thrive-product-overlay'));



function handlePlusClick(e) {
  // overlay is a the previous sibling of the "button"
  const currentPlus = e.currentTarget;
  const currentCard = e.currentTarget.previousElementSibling;
  
  // toggle "open" class for the over lay
  currentCard.classList.contains('open') ? currentCard.classList.remove('open') : currentCard.classList.add('open');
  currentPlus.classList.contains('open') ? currentPlus.classList.remove('open') : currentPlus.classList.add('open');
  
}

// function handleAddToCartClick(e) {
//   e.preventDefault();

//     modal.forEach(modal => modal.classList.contains('open') ? modal.classList.remove('open') : null),
    
//     plusButton.forEach(plusButton => plusButton.classList.contains('open') ? plusButton.classList.remove('open') : null);
// }

plusButton.forEach(
  plusButton => 
  plusButton.addEventListener('click', handlePlusClick)
  );

// addToCartButton.forEach(
//   cartButton =>
//   cartButton.addEventListener('click', handleAddToCartClick)
//   );
  
(function ($){
  $( document ).on ( 'click', 'single_add_to_cart_button', function(e) {
    e.preventDefault();
    console.log("you did it old boy");
  } )
})
