import FilterablePartTable from "./FilterablePartTable"
import React from "react"
import ReactDOM from "react-dom"
import { Provider } from "react-redux"
import { createStore } from "redux"

function reducer() {
    return {value: 75}
}

const store = createStore(reducer);
const App = () => (
    <Provider store={store}>
        <FilterablePartTable />
    </Provider>
)

ReactDOM.render(
    <App />,
    document.getElementById("collection-of-part")
);