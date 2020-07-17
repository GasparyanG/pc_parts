import { Filtration } from "./Resource"

class FilterHandler {
    static in_operator = "in";

    constructor(filterState) {
        this._filterState = filterState ? filterState: [];
    }

    changeFilter(filterData, value) {
        let operator = filterData[Filtration.operator_key];
        switch(operator) {
            case FilterHandler.in_operator:
                this.in_case(filterData, value);
                break;
        }
    }

    in_case(filterData, value) {
        for (filter in this._filterState) {
            if (filter[Filtration.field_key] === filterData[Filtration.field_key]) {
                let arrayOfValues = this.prepareArray(filter[Filtration.value_key]);

                // remove if contains
                if (arrayOfValues.includes(value))
                    filter[Filtration.value_key] = composeValue(arrayOfValues, value);
                // add otherwise
                else {
                    arrayOfValues.push(value);
                    filter[Filtration.value_key] = composeValue(arrayOfValues);
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
        return commSepString.split(',');
    }

    composeValue(arrayOfValues, valueToRemove = null) {
        if (valueToRemove) {
            let index = arrayOfValues.findIndex(valueToRemove);
            arrayOfValues.splice(index, 1);
        }

        return arrayOfValues.join(',');
    }

    get filterState() { return this._filterState; }
}

export default FilterHandler;