import React from "react"
import {TopLevelResource, Resource, Link} from "./Resource";

class Pagination extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (<div><a href={this.props.value}>{this.props.name}</a></div>)
    }
}

export default Pagination;