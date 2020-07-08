import {Resource, Link} from "/public/js/collection_of_part/Resource.js";

class FilterablePartTable extends React.Component {
    constructor(props) {
        super(props);

        // state of table
        this.state = {
            collection: new Resource([]),
            links: new Link([])
        }
    }

    // lifecycle components
    componentDidMount() {
        var self = this;
        $.ajax({
            url: "/gpu?api=true&included=gpu_images",
            method: "GET",
            success: function(result) {
                self.setState({
                    collection: new Resource(result),
                    links: new Link(result)
                });
            }
        });
    }

    componentWillUnmount() {

    }

    render() {
        return (<div>
            <div className="filtration">
            </div>
            <div className="part_collection">
            </div>
            <div className="pagination">
                <Pagination value={this.state.links.first} name="First" />
                <Pagination value={this.state.links.prev} name="Previous" />
                <Pagination value={this.state.links.self} name="Current Page" />
                <Pagination value={this.state.links.next} name="Next" />
                <Pagination value={this.state.links.last} name="Last" />
            </div>
        </div>);
    }
}

class Pagination extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (<div><a href={this.props.value}>{this.props.name}</a></div>)
    }
}

const element = <FilterablePartTable />;
ReactDOM.render(element, document.getElementById("collection_of_part"));
