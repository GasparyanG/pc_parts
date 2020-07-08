class Resource {
    constructor(resource) {
        this.data = resource["data"];
    }

    repr() {
        return JSON.stringify(this.data);
    }
}

class Link {
    // Key to access values of api result
    static links_key = "links";
    static first_key = "first";
    static prev_key = "prev";
    static self_key = "self";
    static next_key = "next";
    static last_key = "last";

    constructor(resource) {
        let links = resource[Link.links_key];

        if (links) {
            this._self = links[Link.self_key];
            this._next = links[Link.next_key];
            this._prev = links[Link.prev_key];
            this._first = links[Link.first_key];
            this._last = links[Link.last_key];
        }
    }

    get self() { return this._self; }
    get next() { return this._next; }
    get prev() { return this._prev; }
    get first() { return this._first; }
    get last() { return this._last; }
}

// export resource handlers to be able to import
export { Resource, Link };