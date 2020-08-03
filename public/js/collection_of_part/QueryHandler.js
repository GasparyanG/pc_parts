class QueryHandler {
    static order = "order";
    static included = "included";
    static filter = "filter";

    // page keys
    static page = "page";
    static number = "number";
    static size = "size";

    constructor(queryObject) {
        this._order = this.getField(queryObject, QueryHandler.order);
        this._incuded = this.getField(queryObject, QueryHandler.included);
        this._filter = this.getField(queryObject, QueryHandler.filter);
        this._page = this.getField(queryObject, QueryHandler.page);
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
        // filtration
        qs += this.filterQS();
        // pagination
        qs += this.pageQS();

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

    pageQS() {
        if (!this._page) return "";
        let qs = "";
        qs += "&page[size]=" + this._page[QueryHandler.size];
        qs += "&page[number]=" + this._page[QueryHandler.number];

        return qs;
    }
}

export default QueryHandler;