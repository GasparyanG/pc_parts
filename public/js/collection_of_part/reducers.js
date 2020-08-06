import FilterHandler from "./ResourceHandlers"

// deal with DESC order
function orderPreparation(state, key)
{
    if (key==state.url_query.order)
        return "-" + key;
    return key;
}

function filterPreparation(state, value, data)
{
    let filterHandler = new FilterHandler(state.url_query.filter);
    filterHandler.changeFilter(data, value);
    return filterHandler.filterState;
}

// root reducer configuration
const initial_state = { url_query: {
        included : "gpu_images"
    }}


// TODO: move to separate file
function reducer(state = initial_state, action) {
    switch(action.type) {
        case "ORDER":
            return {
                url_query: {
                    included: state.url_query.included,
                    order: orderPreparation(state, action.key),
                    filter: state.url_query.filter
                }
            }
        case "FILTER":
            return {
                url_query: {
                    included: state.url_query.included,
                    order: state.url_query.order,
                    filter: filterPreparation(state, action.id, action.filter_data)
                }
            }
        case "PAGE_NUMBER":
            return {
                url_query: {
                    included: state.url_query.included,
                    order: state.url_query.order,
                    filter: state.url_query.filter,
                    page: {
                        number: action.number,
                        size: action.size
                    }
                }
            }
        default:
            return state;
    }
}

export default reducer;