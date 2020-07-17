// deal with DESC order
// TODO: move to separate file
function orderPreparation(state, key)
{
    if (key==state.url_query.order)
        return "-" + key;
    return key;
}

function filterPreparation(state, id, type)
{
    // TODO: cahnge filter representation
    return `[${type}][in]=${id}`;
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
                    filter: filterPreparation(state, action.id, action.filter_type)
                }
            }
        default:
            return state;
    }
}

export default reducer;