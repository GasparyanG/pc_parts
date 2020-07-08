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
                {this.state.collection.repr()}
            </div>
            <div className="part_collection">

            </div>
            <div className="pagination">
                {this.state.links.repr()}
            </div>
        </div>);
    }
}

const element = <FilterablePartTable />;
ReactDOM.render(element, document.getElementById("collection_of_part"));
