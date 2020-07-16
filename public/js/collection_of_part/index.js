import FilterablePartTable from "./FilterablePartTable"
import React from "react"
import ReactDOM from "react-dom"
import { Provider } from "react-redux"
import { createStore } from "redux"

// deal with DESC order
// TODO: move to separate file
function orderPreparation(state, key)
{
    if (key==state.url_query.order)
        return "-" + key;
    return key;
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
                    included: "gpu_images",
                    order: orderPreparation(state, action.key)
                }
            }
        default:
            return state;
    }
}

// store configuration
const store = createStore(reducer);
const App = () => (
    <Provider store={store}>
        <FilterablePartTable />
    </Provider>
)

// rendering
ReactDOM.render(
    <App />,
    document.getElementById("collection-of-part")
);