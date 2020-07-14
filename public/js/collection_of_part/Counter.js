import { connect } from "react-redux";
import React from "react"

class Counter extends React.Component {
    increment() {
        this.setState({
            // to do later
        });
    };

    decrement() {
        this.setState({
            // to do later
        });
    };

    render() {
        return (
            <div>
                <h2>Counter</h2>
                <div>
                    <button onClick={this.decrement}>-</button>
                    <span>{this.props.count}</span>
                    <button onClick={this.increment}>+</button>
                </div>
            </div>
        )
    }
}

export default connect()(Counter);