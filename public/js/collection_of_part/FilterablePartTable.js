import {TopLevelResource, Resource, Link} from "./Resource";
import React from "react"
import { connect } from "react-redux"
import Pagination from "./Pagination"
import PartCollection from "./PartCollection"
import QueryHandler from "./QueryHandler"

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
        let queryHandler = new QueryHandler(this.props.url_query);
        $.ajax({
            url: path + queryHandler.composeQueryString(),
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
    return { url_query: state.url_query };
}

export default connect(mapStateToProps)(FilterablePartTable);
