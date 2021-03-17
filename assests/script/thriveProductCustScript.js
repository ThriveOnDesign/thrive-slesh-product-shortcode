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