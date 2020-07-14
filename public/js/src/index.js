import Counter from "./Counter.js"

function App()
{
    return <div>
        <Counter count={42}/>
    </div>
}

ReactDOM.render(
    <App />,
    document.getElementById("redux-test")
);