import  {Swiper,  Autoplay, EffectFade, Navigation, Pagination, Thumbs } from 'swiper';
Swiper.use([ EffectFade, Navigation, Pagination, Thumbs, Autoplay]);
import 'swiper/css';
import axios from "axios";
import IMask from "imask";

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

function buyBtn() {
    let elements = document.querySelectorAll('.buy-btn');
    let counter = document.getElementById('product-count');

    if (!elements) {
        return;
    }

    let modal = document.querySelector('.cart-success');

    Array.prototype.forEach.call(elements, function(item) {
        item.addEventListener('click', function() {
            let id = this.getAttribute('data-id');

            let request = axios.post(
                '/api/v1/cart/add',
                {
                    data: id,
                }
            ).then((response) => {
                if (response.status === 200) {
                    counter.textContent = response.data;
                    modal.classList.add('visible');
                    setTimeout(function() {
                        modal.classList.remove('visible');
                    }, 1000);
                }
            });
        })
    });

}

function productSetter() {
    let elements = document.querySelectorAll('.count-input input');
    let counter = document.getElementById('product-count');
    let total = document.getElementById('total-price');

    if (!elements) {
        return;
    }

    Array.prototype.forEach.call(elements, function(item) {
        let firstValue = item.value;
        item.addEventListener('change', function() {
            let id = this.getAttribute('data-product');
            let quantity = this.value;

            if (quantity <= 0) {
                this.value = firstValue;
                return;
            }

            let request = axios.post(
                '/api/v1/cart/set',
                {
                    data: {
                        id: id,
                        quantity: quantity
                    },
                }
            ).then((response) => {
                if (response.status === 200) {
                    counter.textContent = response.data.counted;
                    total.textContent = response.data.total;
                }
            });

        })
    });

}

function maskPhone() {
    let elements = document.querySelectorAll('.phone-input');

    if (!elements) {
        return;
    }

    let maskOptions = {
        mask: '+{38\\0}` #0 000 00 00',
        definitions: {
            '#': /[1-9]/
        },
    }

    Array.prototype.forEach.call(elements, function(item) {
        IMask(item, maskOptions)
    })

}

docReady(function(){
    // getBgImage('[data-bg]');
    homepageSlider();
    maskPhone();
    buyBtn();
    productSetter();
    menus();
});
