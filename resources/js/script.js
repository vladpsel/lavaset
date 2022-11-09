import CyrillicToTranslit from "cyrillic-to-translit-js";
import IMask from 'imask';


function docReady(fn) {
    // see if DOM is already available
    if (document.readyState === "complete" || document.readyState === "interactive") {
        // call on next available tick
        setTimeout(fn, 1);
    } else {
        document.addEventListener("DOMContentLoaded", fn);
    }
}

function aliasInput() {
    let elements = document.querySelectorAll(".translit-input");
    let maskOptions = {
        mask: /^[a-z0-9/-]+$/
    }

    Array.prototype.forEach.call(elements, function(item){
        IMask(item, maskOptions);
        console.log(item);
    });

}

function getTotal() {
    let elements = document.querySelectorAll('[data-product-id]:checked');
    let total = 0;

    Array.prototype.forEach.call(elements, function(item){
        let quantity = item.value;
        let id = item.getAttribute('data-product-id');
        let priceElem = document.querySelector('[data-price-id="'+ id +'"]');
        let price = priceElem.innerHTML;
        total += price * quantity;
    });

    let totalInput = document.getElementById('total');
    totalInput.value = total;
}

function handleProductCondition()
{
    let elements = document.querySelectorAll("[data-product-id]");

    if (!elements) {
        return;
    }

    Array.prototype.forEach.call(elements, function(item){
        item.addEventListener('change', function () {
            getTotal();
        });
    });

}

function productOrder() {
    let elements = document.querySelectorAll("[data-product-quantity]");

    if (!elements) {
        return;
    }

    Array.prototype.forEach.call(elements, function(item){
        item.addEventListener('change', function () {
            let id = this.getAttribute('data-product-quantity');
            let count = this.value;

            let requiredInput = document.querySelector('[data-product-id="'+ id +'"]');
            requiredInput.checked = true;
            requiredInput.value = count;

            getTotal();
        });
    });
}

docReady(function () {
    aliasInput();
    productOrder();
    handleProductCondition();
})
