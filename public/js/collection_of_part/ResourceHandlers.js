import { Filtration } from "./Resource"

class FilterHandler {
    static in_operator = "in";
    static between_operator = "between";

    constructor(filterState) {
        this._filterState = filterState ? filterState: [];
    }

    changeFilter(filterData, value) {
        let operator = filterData.operator;
        switch(operator) {
            case FilterHandler.in_operator:
                this.in_case(filterData, value);
                break;
            case FilterHandler.between_operator:
                this.between_case(filterData, value);
                break;
        }
    }

    in_case(filterData, value) {
        for (let index in this._filterState) {
            let filter = this._filterState[index];
            if (filter[Filtration.filter_key] === filterData.field) {
                let arrayOfValues = this.prepareArray(filter[Filtration.value_key]);

                // remove if contains
                if (arrayOfValues.includes(value.toString())) {
                    // remove value
                    let newValue = this.composeValue(arrayOfValues, value.toString());
                    // remove filter if there is no value left
                    if (newValue == "") {
                        this._filterState.splice(index, 1);
                    }
                    // update value
                    else
                        filter[Filtration.value_key] = newValue;
                }
                // add otherwise
                else {
                    arrayOfValues.push(value);
                    filter[Filtration.value_key] = this.composeValue(arrayOfValues);
                }

                // At this moment filter will be handeld, so termminate.
                return;
            }
        }

        // If we are here that means filter in not created yet, so create one.
        const newFilter = {
            "filter" : filterData[Filtration.field_key],
            "value" : value,
            "grouping" : filterData[Filtration.grouping_key],
            "type" : filterData[Filtration.type_key],
            "operator" : filterData[Filtration.operator_key]
        };

        // Update filter state.
        this._filterState.push(newFilter);
    }

    prepareArray(commSepString) {
        return commSepString.toString().split(',');
    }

    composeValue(arrayOfValues, valueToRemove = null) {
        if (valueToRemove) {
            let index = arrayOfValues.indexOf(valueToRemove);
            arrayOfValues.splice(index, 1);
        }

        return arrayOfValues.join(',');
    }

    between_case(filterData, value) {
        for (let index in this._filterState) {
            let filter = this._filterState[index];
            if (filter[Filtration.filter_key] === filterData.field) {
                filter[Filtration.value_key] = this.composeBetween(value);
                return;
            }
        }

        // If we are here that means filter in not created yet, so create one.
        const newFilter = {
            "filter" : filterData[Filtration.field_key],
            "value" : this.composeBetween(value),
            "grouping" : filterData[Filtration.grouping_key],
            "type" : filterData[Filtration.type_key],
            "operator" : filterData[Filtration.operator_key]
        };

        // Update filter state.
        this._filterState.push(newFilter);
    }

    // value should be of this format: {min: value, max: value}
    composeBetween(value) {
        return value.min + ',' + value.max;
    }

    get filterState() { return this._filterState; }
}

export default FilterHandler;