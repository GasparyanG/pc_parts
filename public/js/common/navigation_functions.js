function productsDropDown() {
    let dropDown = document.querySelector("#products-drop-down");
    let arrow = document.querySelector(".drop-state-arr");
    if (!dropDown) return;

    if (dropDown.classList.contains("hide")) {
        dropDown.classList.remove("hide");
        dropDown.classList.add("show");

        arrow.innerHTML = "&uarr;";
    } else {
        dropDown.classList.remove("show");
        dropDown.classList.add("hide");

        arrow.innerHTML = "&darr;";
    }
}