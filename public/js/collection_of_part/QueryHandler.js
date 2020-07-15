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
}

export default QueryHandler;