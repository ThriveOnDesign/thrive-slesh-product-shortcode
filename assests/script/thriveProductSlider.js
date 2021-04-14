// slider for wooCommerce products


//create a variable that contains the swiper DOM element this is done so that I can add event listeners to it later  
const sliderContainer = document.querySelector('.thrive-product-swiper');


var thriveProductSwiper = new Swiper('.thrive-product-swiper', {
  
    loop: true,
    spaceBetween: 10,
    slidesPerView: 1,
    centeredSlides: true,
    speed: 2000,
    pagination: {
      el: '.swiper-pagination',
      
    },
    autoplay: {
      delay: 8000,
      disableOnInteraction: true,
    },
    
  // Navigation arrows
  navigation: {
    nextEl: '.swiper-button-next',
    prevEl: '.swiper-button-prev',
  },
  breakpoints: {
    640: {
      slidesPerView: 2,
      spaceBetween: 20,
    },
    1024: {
      slidesPerView: 3,
      spaceBetween: 20,
    },
  }
}
);

// event listener added to the slider that will stop the slider from playing once mouse moves over it.
sliderContainer.addEventListener('mouseover', function() {
  thriveProductSwiper.autoplay.stop();
})

// event listener added to the slider that will re-start the slider once the mouse is no longer hovering over it.
sliderContainer.addEventListener('mouseout', function() {
  thriveProductSwiper.autoplay.start();
})
