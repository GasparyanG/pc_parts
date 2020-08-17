import React from "react"
import {TopLevelResource, Resource, Link} from "./Resource";
import { showOrderingDirection } from "./collection_helper_functions"

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

        return <div></div>;
    }
}

class PcPart extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        let resource = new Resource(this.props.res_obj);

        return  (
            <tr className="product-row">
                <td className="product-name">
                    <div className="img-container">
                        <img src={resource.attributes[TopLevelResource.image_key]} alt=""/>
                    </div>
                    <a className="product-title" target="_blank" href={resource.attributes["url"]}>
                        {resource.attributes[TopLevelResource.name_key]}
                    </a>
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

    order = (orderKey, name) => {
        this.props.dispatch({type: "ORDER", key: orderKey});

        showOrderingDirection(orderKey, name);
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
            <th onClick={() => this.order(essentialFields[key][Resource.sql_query_key], key)}
                className={"order_" + essentialFields[key][Resource.sql_query_key] + " product-table-header product-data"} key={++i}>{key}
            </th>);

        return (<tr className="orderings">{headers}</tr>);
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
        const keys = Object.keys(meta[TopLevelResource.essential_fields_key]);

        delete values[0];

        let i=0;
        const rowData = values.map(function(key, i) {
            --i;    // because of value dleletion (see above)
            if (!resource.attributes[key[Resource.entity_attribute_key]]) {
                if (key[Resource.default_key]) {
                    return (<td key={++i}>
                        <span className="field-name">{keys[i]}:</span>
                        <span>
                            {key[Resource.default_key]}
                        </span>
                    </td>);
                } else {
                    return (<td key={++i}>
                        <span className="field-name">{keys[i]}:</span>
                        <span>
                            ---
                        </span>
                    </td>);
                }
            } else if (key[Resource.sql_query_key] === Resource.price_value) {
                return (<td key={++i}>
                    <span className="field-name">{keys[i]}:</span>
                    <span className="price-info">
                        <div>
                            {key[Resource.unit_key]}{resource.attributes[key[Resource.entity_attribute_key]] }
                        </div>
                        <div className="retailer-info">
                            <img className="retailer-logo" src={resource.attributes["retailer"]} alt=""/>
                        </div>
                    </span>
                </td>);
            } else {
                return (<td key={++i}>
                    <span className="field-name">{keys[i]}:</span>
                    <span>
                        {resource.attributes[key[Resource.entity_attribute_key]] } {key[Resource.unit_key]}
                    </span>
                </td>);
            }
        });

        // to render children just use array
        return [rowData];
    }
}

export default PartCollection;