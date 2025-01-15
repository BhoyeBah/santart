let cart = document.querySelector('.shopping-cart');

document.querySelector('#cart-btn').onclick = () =>{
  cart.classList.toggle('active');
  login.classList.remove('active');
  navbar.classList.remove('active');
}

let login = document.querySelector('.login-form');

document.querySelector('#login-btn').onclick = () =>{
  login.classList.toggle('active');
  cart.classList.remove('active');
  navbar.classList.remove('active');
}

let navbar = document.querySelector('.navbar');

document.querySelector('#menu-btn').onclick = () =>{
  navbar.classList.toggle('active');
  cart.classList.remove('active');
  login.classList.remove('active');
}

window.onscroll = () =>{
  login.classList.remove('active');
  navbar.classList.remove('active');
  cart.classList.remove('active');
}

document.addEventListener('DOMContentLoaded', function() {
    const navLinks = document.querySelectorAll('.navbar a');
    
    // Add click event listener to each nav link
    navLinks.forEach(link => {
        link.addEventListener('click', function(e) {
            // Remove active class from all links
            navLinks.forEach(l => l.classList.remove('active'));
            
            // Add active class to clicked link
            this.classList.add('active');
        });
    });
    
    // Set Home as active by default
    document.querySelector('.navbar a[href="#home"]').classList.add('active');
});

document.addEventListener('DOMContentLoaded', function () {
    const slider = document.querySelector('.slider');
    const slides = document.querySelectorAll('.slide');
    const prevBtn = document.querySelector('.prev-btn');
    const nextBtn = document.querySelector('.next-btn');
    let currentSlide = 0;
    const slideCount = 2; // We have exactly two slides

    function updateSlidePosition() {
        slider.style.transform = `translateX(-${currentSlide * 100}%)`;
    }

    function updateButtonState() {
        // Disable prev button when on first slide
        prevBtn.disabled = currentSlide === 0;
        // Disable next button when on last slide
        nextBtn.disabled = currentSlide === slideCount - 1;
    }

    function moveToNextSlide() {
        if (currentSlide < slideCount - 1) {
            currentSlide++;
            updateSlidePosition();
            updateButtonState();
        }
    }

    function moveToPrevSlide() {
        if (currentSlide > 0) {
            currentSlide--;
            updateSlidePosition();
            updateButtonState();
        }
    }

    // Auto-sliding function
    function autoSlide() {
        if (currentSlide === 0) {
            moveToNextSlide();
        } else {
            moveToPrevSlide();
        }
    }

    // Event listeners for buttons
    prevBtn.addEventListener('click', () => {
        moveToPrevSlide();
        // Reset auto-slide timer when manually navigating
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(autoSlide, 5000);
    });

    nextBtn.addEventListener('click', () => {
        moveToNextSlide();
        // Reset auto-slide timer when manually navigating
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(autoSlide, 5000);
    });

    // Initialize auto-sliding
    let autoSlideInterval = setInterval(autoSlide, 5000);

    // Pause auto-sliding on hover
    const sliderContainer = document.querySelector('.slider-container');
    sliderContainer.addEventListener('mouseenter', () => {
        clearInterval(autoSlideInterval);
    });

    // Resume auto-sliding when mouse leaves
    sliderContainer.addEventListener('mouseleave', () => {
        clearInterval(autoSlideInterval);
        autoSlideInterval = setInterval(autoSlide, 5000);
    });

    // Initialize slider
    updateSlidePosition();
    updateButtonState(); // Set initial button states
});

var swiper = new Swiper(".review-slider", {
  spaceBetween:20,
  centeredSlides: true,
  autoplay: {
    delay: 7500,
    disableOnInteraction: false,
  },
  loop: true,
  breakpoints: {
    0:{
      slidesPerView: 1,
    },
    768:{
      slidesPerView: 2,
    },
    991:{
      slidesPerView: 3,
    },
  },
});

document.addEventListener("DOMContentLoaded", () => {
  const banners = document.querySelectorAll(".banner-container .banner");
  banners.forEach((banner, index) => {
    banner.style.animationDelay = `${index * 0.5}s`; // Delay of 0.5s between each banner
  });
});


document.addEventListener("DOMContentLoaded", () => {
    const elements = document.querySelectorAll(".about .row .content, .about .row .image");

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    entry.target.classList.add("active");
                }
            });
        },
        { threshold: 0.2 } // Trigger when 20% of the element is visible
    );

    elements.forEach((el) => observer.observe(el));
});



