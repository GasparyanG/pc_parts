import {TopLevelResource, Resource, Link} from "/public/js/collection_of_part/Resource.js";

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
        return (<div>
            <div className="filtration">
            </div>
            <div className="part_collection">
                <PartCollection collection={this.state.collection}/>
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
        if (this.props.collection.data) {
            // TODO: change 'i' with actual id of given resource
            let i=0;
            const tableRows = this.props.collection.data.map((part) => <PcPart key={++i} res_obj={part} />);
            return (
                <table>
                    <tbody>
                        <TableHeader header_data={this.props.collection.meta}/>
                        {tableRows}
                    </tbody>
                </table>
            );
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
        return  (
            <tr>
                <td className="product_name">
                    {/*<img src={resource.attributes[TopLevelResource.image_key]} alt=""/>*/}
                    {resource.attributes[TopLevelResource.name_key]}
                </td>
                <Fields etl_fields={resource}/>
            </tr>
        );
    }
}

class TableHeader extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const meta = this.props.header_data;
        var keys = [];
        var values = [];
        var essentialFields = [];
        if (meta) {
            essentialFields = meta[TopLevelResource.essential_fields_key];
            keys = Object.keys(essentialFields);
            values = Object.values(essentialFields);
        } else {
            keys = [];
            values = [];
        }

        let i=0;
        const headers = keys.map((key) =>
            <th className="product-table-header" key={++i} data-attr={essentialFields[key]}>{key}</th>);

        return (<tr>{headers}</tr>);
    }
}

class Fields extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        const resource = this.props.etl_fields;
        const meta = resource.meta;

        const values = Object.values(meta[TopLevelResource.essential_fields_key]);

        delete values[0];

        let i=0;
        const rowData = values.map((key) => <td key={++i}>{resource.attributes[key]}</td>);

        // to render children just use array
        return [rowData];
    }
}

const element = <FilterablePartTable />;
ReactDOM.render(element, document.getElementById("collection_of_part"));
