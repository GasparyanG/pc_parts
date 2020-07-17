import React from "react"
import { Filtration } from "./Resource"

class PartFiltration extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        // create filtration part
        var filtrationData = [];
        if (this.props.meta && this.props.meta[Filtration.filtration_key])
            filtrationData = this.props.meta[Filtration.filtration_key];

        const filters = filtrationData.map(filterMeta => {
            const filter = new Filtration(filterMeta);
            var i=0;
            if (filter.type === Filtration.checkbox_key)
                return <CheckboxFilter key={++i} filter={filter} dispatch={this.props.dispatch}/>
            else if(filter.type == Filtration.range_key)
                return <RangeFilter key={++i} filter={filter} dispatch={this.props.dispatch}/>
        });

        return (<div>{filters}</div>);
    }
}

class CheckboxFilter extends React.Component {
    constructor(props) {
        super(props);
    }

    filter = (filterId, filterType) => {
        this.props.dispatch({type: "FILTER", id: filterId, filter_type: filterType});
    }

    render() {
        // create checkbox
        const checkboxes = this.props.filter.collection.map(filterMeta => {
            return (
                <div>
                    <input onClick={() => this.filter(filterMeta.id, this.props.filter.type)} key={filterMeta.id}
                           id={this.props.filter.type + "_" + filterMeta.id} type="checkbox" value={filterMeta.id}/>
                    <label htmlFor={this.props.filter.type + "_" + filterMeta.id}>{filterMeta.name}</label>
                </div>
            );
        })

        return <div>{checkboxes}</div>
    }
}

class RangeFilter extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return <div>Range</div>
    }
}

export default PartFiltration;