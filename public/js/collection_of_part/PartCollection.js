import React from "react"
import {TopLevelResource, Resource, Link} from "./Resource";

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
                <table className="product-table">
                    <tbody>
                    <TableHeader header_data={this.props.collection.meta} dispatch={this.props.dispatch}/>
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
            <tr className="product-row">
                <td className="product-name">
                    <img src={resource.attributes[TopLevelResource.image_key]} alt=""/>
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

    order = (orderKey) => {
        this.props.dispatch({type: "ORDER", key: orderKey});
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
            <th onClick={() => this.order(essentialFields[key][Resource.sql_query_key])}
                className="product-table-header product-data" key={++i}>{key}
            </th>);

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
        const rowData = values.map(function(key) {
            if (key[Resource.sql_query_key] === Resource.price_value) {
                return (<td key={++i}>
                    {key[Resource.unit_key]}{resource.attributes[key[Resource.entity_attribute_key]] }
                </td>);
            } else {
                return (<td key={++i}>
                    {resource.attributes[key[Resource.entity_attribute_key]] } {key[Resource.unit_key]}
                </td>);
            }
        });

        // to render children just use array
        return [rowData];
    }
}

export default PartCollection;