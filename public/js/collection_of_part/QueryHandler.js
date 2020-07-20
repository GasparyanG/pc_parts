class QueryHandler {
    static order = "order";
    static included = "included";
    static filter = "filter";

    constructor(queryObject) {
        this._order = this.getField(queryObject, QueryHandler.order);
        this._incuded = this.getField(queryObject, QueryHandler.included);
        this._filter = this.getField(queryObject, QueryHandler.filter);
    }

    getField(queryObject, field) {
        return queryObject.hasOwnProperty(field)
            ? queryObject[field]
            : null;
    }

    composeQueryString() {
        // meant for json api calls
        let qs = "?api=true";
        // ordering
        qs += this.orderQS();
        // included fields
        qs += this.includedQS();
        // TODO: filtration
        qs += this.filterQS();

        return qs;
    }

    orderQS() {
        if (!this._order) return "";
        return "&order=" + this._order;
    }

    includedQS() {
        if (!this._included) return "";
        return "&included=" + this._included;
    }

    filterQS() {
        if (!this._filter) return "";
        let qs = "";
        for (let index in this._filter) {
            let filter = this._filter[index];
            // grouping
            qs += "&filter[" + filter["grouping"] + "]";
            // field name
            qs += "[" + filter["filter"] + "]";
            // operator
            qs += "[" + filter["operator"] + "]";
            // value
            qs += "=" + filter["value"];
        }

        return qs;
    }
}

export default QueryHandler;