function productsDropDown() {
    let dropDown = document.querySelector("#products-drop-down");
    if (!dropDown) return;

    if (dropDown.classList.contains("hide")) {
        dropDown.classList.remove("hide");
        dropDown.classList.add("show");
    } else {
        dropDown.classList.remove("show");
        dropDown.classList.add("hide");
    }
}