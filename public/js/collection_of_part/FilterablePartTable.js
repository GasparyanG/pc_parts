import {TopLevelResource, Resource, Link} from "./Resource";
import React from "react"
import { connect } from "react-redux"
import Pagination from "./Pagination"
import PartCollection from "./PartCollection"

class FilterablePartTable extends React.Component {
    constructor(props) {
        super(props);

        // state of table
        this.state = {
            status: false,
            collection: new TopLevelResource([]),
            links: new Link([]),
        }
    }

    // lifecycle components
    componentDidMount() {
        var self = this;
        var path = window.location.pathname;
        $.ajax({
            url: path + "?api=true&included=gpu_images",
            method: "GET",
            success: function(result) {
                self.setState({
                    status: true,
                    collection: new TopLevelResource(result),
                    links: new Link(result)
                });
            }
        });
    }

    componentWillUnmount() { }

    render() {
        return (<div className="table-and-filtration">
            <div className="filtration">
            </div>
            <div className="part-collection">
                <PartCollection collection={this.state.collection}/>
            </div>
        </div>);
    }
}

function mapStateToProps(state) {
    return { value: state.value };
}

export default connect(mapStateToProps)(FilterablePartTable);
