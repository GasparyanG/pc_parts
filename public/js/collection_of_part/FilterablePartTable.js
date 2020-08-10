import {TopLevelResource, Resource, Link, Filtration} from "./Resource";
import React from "react"
import { connect } from "react-redux"
import Pagination from "./Pagination"
import PartCollection from "./PartCollection"
import QueryHandler from "./QueryHandler"
import PartFiltration from "./PartFiltration"

function handleOnWindowResize()
{
    let w = document.documentElement.clientWidth;
    let filtrationEl = document.querySelector("#filtration");
    let partCollection = document.querySelector(".part-collection");

    if (w > 600) {
        filtrationEl.classList.remove("show");
        filtrationEl.style.display = "block";
        partCollection.style.display = "block";
    } else if (w <= 600) {
        filtrationEl.classList.remove("show");
        filtrationEl.style.display = "none";
        partCollection.style.display = "block";
    }
}

function showFilters()
{
    window.onresize = handleOnWindowResize;

    let filtrationEl = document.querySelector("#filtration");
    let partCollection = document.querySelector(".part-collection");
    if (!filtrationEl) return;

    if (filtrationEl.classList.contains("show")) {
        filtrationEl.style.display = "none";
        filtrationEl.classList.remove("show");
        partCollection.style.display = "block";
    } else {
        filtrationEl.style.display = "block";
        filtrationEl.classList.add("show");
        partCollection.style.display = "none";
    }
}

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

        return (
            <div>
                <div className="product-coll-header">
                    Choose A PC Case
                </div>
                <div className="filters_and_order">
                    <div onClick={showFilters} className="filter-button">
                        Filters
                    </div>
                    <div className="order-button">
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
