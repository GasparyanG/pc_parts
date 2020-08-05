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

export { showMore, hideFilter, composeClassName, hideFilterClassNames, showLessOrMoreClassNames };