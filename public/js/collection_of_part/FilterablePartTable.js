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
            initial_loading: true
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
                    if (result == false) {
                        // top level resource preparation
                        let topLevelRs = new TopLevelResource(result);
                        topLevelRs.meta = self.state.collection.meta;

                        self.setState({
                            collection: topLevelRs,
                            links: newLinks
                        });
                    }
                    else
                        self.setState({
                            collection: new TopLevelResource(result),
                            links: newLinks,
                            initial_loading: false
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
        let filtersHeader = "";
        if (this.state.collection.meta) {
            part = this.state.collection.meta.part;
            filtersHeader = "Filters"
        }

        let partCollection = (
            <div>
                <PartCollection collection={this.state.collection} dispatch={this.props.dispatch}/>
                <Pagination link={this.state.links} dispatch={this.props.dispatch} />
            </div>
        );

        if (!this.state.initial_loading && !this.state.collection.data) {
            partCollection = (
                <div className="no-products-reporting">
                    <div className="no-products-message">
                        No Products Found
                    </div>
                    <a href="" className="no-products-action">
                        Reset Filters
                    </a>
                </div>
            );
        }

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
                        <div className="filters-header">{filtersHeader}</div>
                        <PartFiltration meta={this.state.collection.meta} dispatch={this.props.dispatch}/>
                    </div>
                    <div className="part-collection">
                        {partCollection}
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
