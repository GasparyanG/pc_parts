function hideFilter(filterName)
{
    let filterClassName = "filter_" + filterName;
    let filter = document.querySelector(`.${filterClassName}`);

    let rotatingSignClassName = "vertical_" + filterName;
    let rotatingBar = document.querySelector(`.${rotatingSignClassName}`);

    if (!filter) return;

    if (filter.classList.contains("filter-collapse")) {
        filter.classList.add("filter-show");
        filter.classList.remove("filter-collapse");

        rotatingBar.classList.add("sign-open");
        rotatingBar.classList.remove("sign-collapse");
    } else  {
        filter.classList.remove("filter-show");
        filter.classList.add("filter-collapse");

        rotatingBar.classList.add("sign-collapse");
        rotatingBar.classList.remove("sign-open");
    }
}

function showMore(fieldName) {
    let opClassName = "show_" + fieldName;
    let filterContClassName = "filter_" + fieldName;

    let opElement = document.querySelector(`.${opClassName}`);
    let filterCont = document.querySelector(`.${filterContClassName}`).firstChild;

    if (opElement.classList.contains("show-more")) {
        opElement.classList.remove("show-more");
        opElement.classList.add("show-less");
        opElement.innerHTML = "&uarr; show less";

        filterCont.classList.remove("filter-shrink");
    } else {
        opElement.classList.remove("show-less");
        opElement.classList.add("show-more");
        opElement.innerHTML = "&darr; show more";

        filterCont.classList.add("filter-shrink");
    }
}

export { showMore, hideFilter };