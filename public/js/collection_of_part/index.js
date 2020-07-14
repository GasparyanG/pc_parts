import Counter from "./Counter"
import React from "react";
import ReactDOM from "react-dom"

function App() {
    return <Counter count={42}/>
}

ReactDOM.render(<App />, document.getElementById("redux-test"));