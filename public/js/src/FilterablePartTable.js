import {TopLevelResource, Resource, Link} from "/public/js/collection_of_part/Resource.js";

class FilterablePartTable extends React.Component {
    constructor(props) {
        super(props);

        // state of table
        this.state = {
            collection: new TopLevelResource([]),
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
                    collection: new TopLevelResource(result),
                    links: new Link(result)
                });
            }
        });
    }

    componentWillUnmount() { }

    render() {
        return (<div>
            <div className="filtration">
            </div>
            <div className="part_collection">
                <PartCollection collection={this.state.collection.data}/>
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

class PartCollection extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        if (this.props.collection) {
            // TODO: change 'i' with actual id of given resource
            let i=0;
            const tableRows = this.props.collection.map((part) => <PcPart key={++i} res_obj={part} />);
            return <div>{tableRows}</div>;
        }

        return <div>Empty</div>;
    }
}

class PcPart extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        let resource = new Resource(this.props.res_obj);
        // TODO: render single resource
        return  <div>{resource.type}</div>;
    }
}

const element = <FilterablePartTable />;
ReactDOM.render(element, document.getElementById("collection_of_part"));
