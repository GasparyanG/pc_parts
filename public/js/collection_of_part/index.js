import FilterablePartTable from "./FilterablePartTable"
import React from "react"
import ReactDOM from "react-dom"
import { Provider } from "react-redux"
import { createStore } from "redux"

// root reducer configuration
const initial_state = { url_query: {
    included : "gpu_images"
}}
function reducer(state = initial_state) {
    return state;
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