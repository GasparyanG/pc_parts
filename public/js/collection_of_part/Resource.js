// Meant for collection of objects as well as for metadata, exception, etc.
class TopLevelResource {
    // Key to access api result
    static data_key = "data";
    static meta_key = "meta";

    static essential_fields_key = "essential_fields";
    // Set of essential fields
    static image_key = "image";
    static name_key = "name";

    constructor(resource) {
        this._data = resource[TopLevelResource.data_key];
        this._meta = resource[TopLevelResource.meta_key];
    }

    get data() { return this._data; }
    get meta() { return this._meta; }

    // TODO: get top level components
}

class Filtration {
    static filtration_key = "filtration";

    // types
    static checkbox_key = "checkbox";
    static range_key = "range";

    // common fields
    static type_key = "type";
    static name_key = "name";
    static field_key = "field";

    // for colleciton type
    static collection_key = "collection";

    // Grouping
    static grouping_key = "grouping";
    static checkbox_grouping_key = "or";
    static range_grouping_key = "and";

    // for range type
    static min_key = "min";
    static max_key = "max";

    constructor(meta) {
        this._type = meta[Filtration.type_key];
        this._name = meta[Filtration.name_key];
        this._grouping = meta[Filtration.grouping_key];
        this._field = meta[Filtration.field_key];

        if (meta[Filtration.type_key] === Filtration.range_key) {
            this._min = meta[Filtration.min_key];
            this._max = meta[Filtration.max_key];
        } else {
            this._collection = meta[Filtration.collection_key];
        }
    }

    get type() { return this._type; }
    get name() { return this._name; }
    get min() { return this._min; }
    get max() { return this._max; }
    get collection() { return this._collection; }
    get grouping() { return this._grouping; }
    get field() { return this._field; }
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
        this._attributes = data[Resource.attributes_key];
        this._included = resource[Resource.included_key];
        this._meta = resource[TopLevelResource.meta_key];
    }

    get id () { return this._id; }
    get relationships () { return this._relationships; }
    get type () { return this._type; }
    get included () { return this._included; }
    get attributes () { return this._attributes; }
    get meta() { return this._meta; }
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
export { TopLevelResource, Resource, Link, Filtration };