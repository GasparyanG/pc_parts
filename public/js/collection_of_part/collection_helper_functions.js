// Hide filter class names
const filterCollapseClassNames = "filter-collapse";
const signOpenClassName = "sign-open";
const signCollapseClassName = "sign-collapse";
const filterShowClassName = "filter-show";
const signBarClassName = "sign-bar";
const verticalBarClassName = "vertical-bar";
const horizontalBarClassName = "horizontal-bar";
const rotatingSignClassName = "rotating-sign";
const hideSignClassName = "hide-sign";

const hideFilterClassNames = {
    filter_collapse_class_names: filterCollapseClassNames,
    sign_open_class_name: signOpenClassName,
    sign_collapse_class_name: signCollapseClassName,
    filter_show_class_name: filterShowClassName,
    sign_bar_class_name: signBarClassName,
    vertical_bar_class_name: verticalBarClassName,
    horizontal_bar_class_name: horizontalBarClassName,
    rotating_sign_class_name: rotatingSignClassName,
    hide_sign_class_name: hideSignClassName
};

// Show less or more class names
const showMoreClassName = "show-more";
const showLessOrMoreClassName = "show-less-or-more";
const showLessClassName = "show-less";
const filterShrinkClassName = "filter-shrink";

const showLessOrMoreClassNames = {
    show_more_class_name: showMoreClassName,
    show_less_or_more_class_name: showLessOrMoreClassName,
    show_less_class_name: showLessClassName,
    filter_shrink_class_name: filterShrinkClassName
};

function composeClassName(...classNames)
{
    let classNameString = "";
    classNames.forEach(cn => classNameString += cn + " ");

    return classNameString;
}

function hideFilter(filterName)
{
    let filterClassName = "filter_" + filterName;
    let filter = document.querySelector(`.${filterClassName}`);

    let rotatingSignClassName = "vertical_" + filterName;
    let rotatingBar = document.querySelector(`.${rotatingSignClassName}`);

    if (!filter) return;

    if (filter.classList.contains(filterCollapseClassNames)) {
        filter.classList.add(filterShowClassName);
        filter.classList.remove(filterCollapseClassNames);

        rotatingBar.classList.add(signOpenClassName);
        rotatingBar.classList.remove(signCollapseClassName);
    } else  {
        filter.classList.remove(filterShowClassName);
        filter.classList.add(filterCollapseClassNames);

        rotatingBar.classList.add(signCollapseClassName);
        rotatingBar.classList.remove(signOpenClassName);
    }
}

function showMore(fieldName) {
    let opClassName = "show_" + fieldName;
    let filterContClassName = "filter_" + fieldName;

    let opElement = document.querySelector(`.${opClassName}`);
    let filterCont = document.querySelector(`.${filterContClassName}`).firstChild;

    if (opElement.classList.contains(showMoreClassName)) {
        opElement.classList.remove(showMoreClassName);
        opElement.classList.add(showLessClassName);
        opElement.innerHTML = "&uarr; show less";

        filterCont.classList.remove(filterShrinkClassName);
    } else {
        opElement.classList.remove(showLessClassName);
        opElement.classList.add(showMoreClassName);
        opElement.innerHTML = "&darr; show more";

        filterCont.classList.add(filterShrinkClassName);
    }
}

function handleOnWindowResize()
{
    let w = document.documentElement.clientWidth;
    let filtrationEl = document.querySelector("#filtration");
    let partCollection = document.querySelector(".part-collection");
    let orderEl = document.querySelector(".orderings");

    if (w > 900) {
        filtrationEl.classList.add("lrg-view");
        filtrationEl.classList.remove("sml-view");

        filtrationEl.classList.remove("show");
        filtrationEl.style.display = "block";
        orderEl.style.display = "table-row";
        partCollection.style.display = "block";
    } else if (w <= 900) {
        // If transition happend immediately after large view then deal with block
        if (filtrationEl.classList.contains("lrg-view")) {
            filtrationEl.classList.remove("show");
            filtrationEl.classList.remove("lrg-view");
            filtrationEl.classList.add("sml-view");

            filtrationEl.style.display = "none";
            orderEl.style.display = "none";

            // display collection if transition happened after big view
            partCollection.style.display = "block"
        }
    }
}

function showFilters()
{
    window.onresize = handleOnWindowResize;

    let filtrationEl = document.querySelector("#filtration");
    let partCollection = document.querySelector(".part-collection");
    let orderEl = document.querySelector(".orderings");
    if (!filtrationEl) return;

    // Close orderings if opned!
    if (orderEl.classList.contains("show"))
        showOrderings();

    if (filtrationEl.classList.contains("show")) {
        filtrationEl.style.display = "none";
        filtrationEl.classList.remove("show");
        partCollection.style.display = "block";
    } else {
        filtrationEl.style.display = "block";
        filtrationEl.classList.add("show");
        partCollection.style.display = "none";
    }
}

function showOrderings()
{
    window.onresize = handleOnWindowResize;

    let orderEl = document.querySelector(".orderings");
    let filtrationEl = document.querySelector("#filtration");
    if (!orderEl) return;

    // Close filters if opened!
    if (filtrationEl.classList.contains("show"))
        showFilters();

    if (orderEl.classList.contains("show")) {
        orderEl.style.display = "none";
        orderEl.classList.remove("show");
    } else {
        if (window.innerWidth <= 600)
            orderEl.style.display = "flex";
        else if (window.innerWidth > 600)
            orderEl.style.display = "table-row";
        orderEl.classList.add("show");
    }
}

function extractNumber(str) {
    let regexp = new RegExp(/([\d,.]+)/);
    str=str.replace(',', '');
    let num = str.match(regexp)[0];
    return Number(num);
}

function showOrderingDirection(orderKey, name)
{
    const ordHeaders = document.querySelectorAll(".product-table-header");
    const headToOrd = document.querySelector(".order_" + orderKey);
    if (!headToOrd) return;

    ordHeaders.forEach(hdr => {
        hdr.innerHTML = hdr.innerHTML.replace("↑", "");
        hdr.innerHTML = hdr.innerHTML.replace("↓", "");
    });

    headToOrd.classList.toggle("asc");
    if (headToOrd.classList.contains("asc"))
        headToOrd.innerHTML = name + " " + "&darr;";
    else
        headToOrd.innerHTML = name + " " + "&uarr;";
}

function product_table_blurness() {
    let productTable = document.querySelector(".product-table");
    if (!productTable) return;
    productTable.classList.toggle("under_request");
}

export {
    showMore,
    hideFilter,
    composeClassName,
    hideFilterClassNames,
    showLessOrMoreClassNames,
    showFilters,
    showOrderings,
    extractNumber,
    showOrderingDirection,
    product_table_blurness
};