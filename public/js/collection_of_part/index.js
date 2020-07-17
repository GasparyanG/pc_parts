import FilterablePartTable from "./FilterablePartTable"
import React from "react"
import ReactDOM from "react-dom"
import { Provider } from "react-redux"
import { createStore } from "redux"
import reducer from "./reducers"

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