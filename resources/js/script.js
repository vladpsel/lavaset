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

function dropdownselect() {
    let elements = document.querySelectorAll('.dropdown-select');

    if (!elements) {
        return;
    }

    let setValue = (input, list) => {
        Array.prototype.forEach.call(list, function(listItem){
            listItem.addEventListener('click', function(){
                let url = listItem.getAttribute('data-link');
                input.value = url;
            });
        })
    }

    let findValue = (value, items) => {

        if (value === null || value.length == 0) {
            Array.prototype.forEach.call(items, function(single){
                single.classList.remove('hidden');
            })
            return;
        }

        let pattern = new RegExp(value, "i");

        Array.prototype.forEach.call(items, function(single){
            let dataVal = single.getAttribute('data-text');
            if (pattern.test(dataVal)) {
                single.classList.remove('hidden');
            } else {
                single.classList.add('hidden');
            }
        })

    }

    Array.prototype.forEach.call(elements, function(item){
        let input = item.querySelector('input');
        let dropdown = item.querySelector('.dropdown-select__list');
        let dropdownItems = dropdown.querySelectorAll('li');

        setValue(input, dropdownItems);

        input.addEventListener('focus', function() {
            dropdown.classList.add('open');
        });

        input.addEventListener('focusout', function() {
            setTimeout(function() {
                dropdown.classList.remove('open');
            }, 150);
            findValue(null, dropdownItems);
        });

        input.addEventListener('input', function () {
            let val = input.value;
            findValue(val, dropdownItems);
        });


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
    dropdownselect();
})
