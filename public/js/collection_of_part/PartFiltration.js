import React from "react"
import { Filtration } from "./Resource"
import { showMore, hideFilter, composeClassName, hideFilterClassNames, showLessOrMoreClassNames } from "./collection_helper_functions"
import Nouislider from "react-nouislider"
import 'nouislider/distribute/nouislider.css';
import wNumb from "wnumb"

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
            let filter = new Filtration(filterMeta);
            if (filter.type === Filtration.checkbox_key)
                return <CheckboxFilter filter={filter} dispatch={this.props.dispatch}/>
            else if(filter.type == Filtration.range_key)
                return <RangeFilter filter={filter} dispatch={this.props.dispatch}/>
        });

        return (<div className="filters">{filters}</div>);
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
                        <input className="filter-pinter" onClick={() => this.filter(filterMeta.id, this.props.filter)}
                               id={this.props.filter.field + "_" + filterMeta.id} type="checkbox" value={filterMeta.id}/>
                        <label className="filter-pinter" htmlFor={this.props.filter.field + "_" + filterMeta.id}>{filterMeta.name}</label>
                    </div>
                );
        });

        let lessOrMore = (<div></div>);
        let ShrinkClassName = "";
        if (checkboxes.length > 5) {
            lessOrMore =
                (<div className={composeClassName(
                    showLessOrMoreClassNames.show_more_class_name,
                    showLessOrMoreClassNames.show_less_or_more_class_name,
                    "show_" + this.props.filter.field)
                }
                      onClick={() => showMore(this.props.filter.field)}>&darr; show more</div>);
            ShrinkClassName = showLessOrMoreClassNames.filter_shrink_class_name;
        }

        return (
            <div>
                <div className="filter-header">
                    <div className="filter-name">{this.props.filter.name}</div>
                    <CollapseSign  filter={this.props.filter}/>
                </div>
                <div className={composeClassName(
                    "product-filter",
                    hideFilterClassNames.filter_show_class_name,
                    "filter_" + this.props.filter.field)}>
                    <div className={ShrinkClassName}>
                        {checkboxes}
                    </div>
                    <div>
                        {lessOrMore}
                    </div>
                </div>
            </div>
        );
    }
}

class RangeFilter extends React.Component {
    constructor(props) {
        super(props);
        this.state = {
            min: null,
            max: null
        }
    }

    filter = (filter) => {
        let val_obj = document.querySelector("#" + filter.field + "_range_slider > div").noUiSlider.get();
        this.setState({
            min: Number(val_obj[0]),
            max: Number(val_obj[1])
        });

        this.props.dispatch({type: "FILTER", id: {min: val_obj[0], max: val_obj[1]}, filter_data: filter})
    }

    render() {

        let minVal = this.state.min != null ? this.state.min : Number(this.props.filter.min);
        let maxVal = this.state.max != null ? this.state.max : Number(this.props.filter.max);

        return (
            <div>
                <div className="filter-header">
                    <div className="filter-name">{this.props.filter.name}</div>
                    <CollapseSign  filter={this.props.filter}/>
                </div>
                <div id={this.props.filter.field + "_range_slider"} className={composeClassName(
                    "double-range-slider product-filter",
                    hideFilterClassNames.filter_show_class_name,
                    "filter_" + this.props.filter.field)}>
                    <Nouislider onChange={() => this.filter(this.props.filter)}
                                range={{min:Number(this.props.filter.min),max:Number(this.props.filter.max)}}
                                step={this.props.filter.step}
                                start={[minVal,maxVal]}
                                tooltips={true}
                                format={wNumb({
                                    decimals: 0, // default is 2
                                    thousand: ',', // thousand delimiter
                                })}
                                connect={true} />
                </div>
            </div>
        );
    }
}

class CollapseSign extends React.Component {
    constructor(props) {
        super(props);
    }

    render() {
        return (
            <div className={hideFilterClassNames.hide_sign_class_name} onClick={() => hideFilter(this.props.filter.field)}>
                <div className={hideFilterClassNames.rotating_sign_class_name}>
                    <div className={composeClassName(
                        hideFilterClassNames.sign_bar_class_name,
                        hideFilterClassNames.vertical_bar_class_name,
                        "vertical_" + this.props.filter.field)}></div>
                    <div className={composeClassName(
                        hideFilterClassNames.sign_bar_class_name,
                        hideFilterClassNames.horizontal_bar_class_name,
                        "horizontal_" + this.props.filter.field)}></div>
                </div>
            </div>
        );
    }
}

export default PartFiltration;