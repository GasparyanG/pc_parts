import Counter from "./Counter"
import React from "react";
import ReactDOM from "react-dom"
import { createStore } from "redux"
import { Provider } from "react-redux"

const initial_state= {count:45};
function reducer(state = initial_state, action) {
    switch(action.type) {
        case "INCREMENT":
            return {count: state.count + 1};
        case "DECREMENT":
            return {count: state.count - 1};
        default:
            return state;
    }
}

const store = createStore(reducer);
function App() {
    return (
        <Provider store={store}>
            <Counter />
        </Provider>
    );
}

ReactDOM.render(<App />, document.getElementById("redux-test"));