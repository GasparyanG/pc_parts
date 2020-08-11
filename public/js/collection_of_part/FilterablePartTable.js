import {TopLevelResource, Resource, Link, Filtration} from "./Resource";
import React from "react"
import { connect } from "react-redux"
import Pagination from "./Pagination"
import PartCollection from "./PartCollection"
import QueryHandler from "./QueryHandler"
import PartFiltration from "./PartFiltration"
import { showFilters, showOrderings } from "./collection_helper_functions"

class FilterablePartTable extends React.Component {
    constructor(props) {
        super(props);

        // state of table
        this.state = {
            collection: new TopLevelResource([]),
            links: new Link([]),
        }
    }

    // lifecycle components
    componentDidMount() { }

    componentWillUnmount() { }

    getData() {
        var self = this;
        var path = window.location.pathname;
        let queryHandler = new QueryHandler(this.props.url_query);
        $.ajax({
            url: path + queryHandler.composeQueryString(),
            method: "GET",
            success: function(result) {
                // Don't rerender already fetched data
                var newLinks = new Link(result);
                if (self.state.links.self !== newLinks.self)
                    self.setState({
                        collection: new TopLevelResource(result),
                        links: newLinks
                    });
            },
            error: function(er) {
                console.log("Something went wrong");
            }
        });
    }

    render() {
        this.getData();

        let part = "Part";
        if (this.state.collection.meta)
            part = this.state.collection.meta.part;

        return (
            <div>
                <div className="product-coll-header">
                    Choose A {part}
                </div>
                <div className="filters_and_order">
                    <div onClick={showFilters} className="filter-button">
                        Filters
                    </div>
                    <div onClick={showOrderings} className="order-button">
                        Order
                    </div>
                </div>
                <div className="table-and-filtration">
                    <div id="filtration">
                        <div className="filters-header">Filters</div>
                        <PartFiltration meta={this.state.collection.meta} dispatch={this.props.dispatch}/>
                    </div>
                    <div className="part-collection">
                        <PartCollection collection={this.state.collection} dispatch={this.props.dispatch}/>
                        <Pagination link={this.state.links} dispatch={this.props.dispatch} />
                    </div>
                </div>
            </div>
        );
    }
}

function mapStateToProps(state) {
    return { url_query: state.url_query };
}

export default connect(mapStateToProps)(FilterablePartTable);
