// Meant for collection of objects as well as for metadata, exception, etc.
class TopLevelResource {
    // Key to access api result
    static data_key = "data";

    constructor(resource) {
        this._data = resource[TopLevelResource.data_key];
    }

    get data() { return this._data; }

    // TODO: get metadata and top level components
}

// Meant for single object
class Resource {
    // keys to access api result
    static relationships_key = "relationships";
    static included_key = "included";
    static id_key = "id";
    static type_key = "type";
    static attributes_key = "attributes";

    constructor(resource) {
        let data = resource[TopLevelResource.data_key];

        this._id = data[Resource.id_key];
        this._relationships = data[Resource.relationships_key];
        this._type = data[Resource.type_key];
        this._included = data[Resource.included_key];
        this._attributes = data[Resource.attributes_key];
    }

    get id () { return this._id; }
    get relationships () { return this._relationships; }
    get type () { return this._type; }
    get included () { return this._included; }
    get attributes () { return this._attributes; }
}


// Mostly meant for pagination
class Link {
    // Keys to access values of api result
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
export { TopLevelResource, Resource, Link };