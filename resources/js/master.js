import  {Swiper,  Autoplay, EffectFade, Navigation, Pagination, Thumbs } from 'swiper';
Swiper.use([ EffectFade, Navigation, Pagination, Thumbs, Autoplay]);
import 'swiper/css';

function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

function homepageSlider() {
    let swiper = new Swiper('.homepage-slider', {
        loop: true,
        autoplay: {
            delay: 5000,
        }
        // pagination: {
        //     el: '.swiper-pagination',
        // },
        // navigation: {
        //     nextEl: '.swiper-button-next',
        //     prevEl: '.swiper-button-prev',
        // },
        // scrollbar: {
        //     el: '.swiper-scrollbar',
        // },
    });
}

function menus() {
    let mobileMenuBtn = document.querySelector('.menu-btn');
    let navList = document.querySelector('.nav-list');

    mobileMenuBtn.addEventListener('click', function(){
        navList.classList.toggle('active');
    });


    let burger = document.querySelector('.burger');
    let mainMenu = document.querySelector('.header .nav');

    if (burger) {
        burger.addEventListener('click', function() {
            this.classList.toggle('active');
            mainMenu.classList.toggle('active');
        })
    }

}

docReady(function(){
    // getBgImage('[data-bg]');
    homepageSlider();
    // maskPhone();
    // buyBtn();
    // productSetter();
    menus();
});
