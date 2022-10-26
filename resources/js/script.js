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

docReady(function () {
    aliasInput();
})
