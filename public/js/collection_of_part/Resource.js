class Resource {
    constructor(resource) {
        this.data = resource["data"];
    }

    repr() {
        return JSON.stringify(this.data);
    }
}

class Link {
    constructor(resource) {
        this.links = resource["links"];
    }

    repr() {
        return JSON.stringify(this.links);
    }
}

export { Resource, Link };