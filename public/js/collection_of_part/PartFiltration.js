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
            var filter = new Filtration(filterMeta);
            if (filter.type === Filtration.checkbox_key)
                return <CheckboxFilter filter={filter} dispatch={this.props.dispatch}/>
            else if(filter.type == Filtration.range_key)
                return <RangeFilter filter={filter} dispatch={this.props.dispatch}/>
        });

        return (<div>{filters}</div>);
    }
}

class CheckboxFilter extends React.Component {
    constructor(props) {
        super(props);
    }

    filter = (filterId, filterData) => {
        this.props.dispatch({type: "FILTER", id: filterId, filter_data: filterData});
    }

    render() {
        // create checkbox
        const checkboxes = this.props.filter.collection.map(filterMeta => {
            if ((filterMeta.id || filterMeta.id === 0) && filterMeta.name)
                return (
                    <div>
                        <input onClick={() => this.filter(filterMeta.id, this.props.filter)}
                               id={this.props.filter.field + "_" + filterMeta.id} type="checkbox" value={filterMeta.id}/>
                        <label htmlFor={this.props.filter.field + "_" + filterMeta.id}>{filterMeta.name}</label>
                    </div>
                );
        })

        return (
            <div>
                <h3 className="filter-name">{this.props.filter.name}</h3>
                <div>
                    {checkboxes}
                </div>
            </div>
        );
    }
}

class RangeFilter extends React.Component {
    constructor(props) {
        super(props);
    }

    filter = (filterData) => {
        let min_val = document.getElementById(filterData.field + "_min").value;
        let max_val = document.getElementById(filterData.field + "_max").value;

        this.props.dispatch({type: "FILTER", id: {min: min_val, max: max_val}, filter_data: filterData})
    }

    render() {
        return (
            <div>
                <h3 className="filter-name">{this.props.filter.name}</h3>
                <div>
                    <label htmlFor={this.props.filter.field + "_min" }>Min</label>
                    <input onChange={() => this.filter(this.props.filter)} id={this.props.filter.field + "_min" }
                           type="text" defaultValue={this.props.filter.min}/>
                    <label htmlFor={this.props.filter.field + "_max" }>Max</label>
                    <input onChange={() => this.filter(this.props.filter)} id={this.props.filter.field + "_max" }
                           type="text" defaultValue={this.props.filter.max}/>
                </div>
            </div>
        );
    }
}

export default PartFiltration;