const plusButton = Array.from(document.querySelectorAll(".slesh-plus-sign-container"));
const modal = document.querySelectorAll('.thrive-product-overlay');

function handlePlusClick(e) {
  // overlay is a the previous sibling of the "button"
  const currentPlus = e.currentTarget;
  const currentCard = e.currentTarget.previousElementSibling;
  
  // toggle "open" class for the over lay
  currentCard.classList.contains('open') ? currentCard.classList.remove('open') : currentCard.classList.add('open');
  currentPlus.classList.contains('open') ? currentPlus.classList.remove('open') : currentPlus.classList.add('open');
  
}

plusButton.forEach(
  plusButton => 
  plusButton.addEventListener('click', handlePlusClick)
  );
  
/**
 * Playing around with sidecart
 */

  const headerCart = document.querySelector('.elementor-menu-cart__toggle .elementor-button-icon');
  const dataCounter = headerCart.dataset.counter;
  const cartContainer = document.querySelector('.elementor-menu-cart__container');
  
  let count = localStorage.getItem('cartCount') || 0;

function showSideCart() {
  
  if ( dataCounter !== "0" ) {
    count++
    localStorage.setItem('cartCount', count);
  } else if ( dataCounter === "0" ) {
    count = parseInt(dataCounter);
    localStorage.setItem('cartCount', count);
  }
    
  if( count === 1) {
    console.log('sidecart function triggering')
    cartContainer.classList.add('elementor-menu-cart--shown');
  }
    
  
}

headerCart.addEventListener('datachange', showSideCart());