var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

import { TopLevelResource, Resource, Link } from "/public/js/collection_of_part/Resource.js";

var FilterablePartTable = function (_React$Component) {
    _inherits(FilterablePartTable, _React$Component);

    function FilterablePartTable(props) {
        _classCallCheck(this, FilterablePartTable);

        // state of table
        var _this = _possibleConstructorReturn(this, (FilterablePartTable.__proto__ || Object.getPrototypeOf(FilterablePartTable)).call(this, props));

        _this.state = {
            status: false,
            collection: new TopLevelResource([]),
            links: new Link([])
        };
        return _this;
    }

    // lifecycle components


    _createClass(FilterablePartTable, [{
        key: "componentDidMount",
        value: function componentDidMount() {
            var self = this;
            $.ajax({
                url: "/gpu?api=true&included=gpu_images",
                method: "GET",
                success: function success(result) {
                    self.setState({
                        status: true,
                        collection: new TopLevelResource(result),
                        links: new Link(result)
                    });
                }
            });
        }
    }, {
        key: "componentWillUnmount",
        value: function componentWillUnmount() {}
    }, {
        key: "render",
        value: function render() {
            return React.createElement(
                "div",
                null,
                React.createElement("div", { className: "filtration" }),
                React.createElement(
                    "div",
                    { className: "part_collection" },
                    React.createElement(PartCollection, { collection: this.state.collection.data })
                ),
                React.createElement(
                    "div",
                    { className: "pagination" },
                    React.createElement(Pagination, { value: this.state.links.first, name: "First" }),
                    React.createElement(Pagination, { value: this.state.links.prev, name: "Previous" }),
                    React.createElement(Pagination, { value: this.state.links.self, name: "Current Page" }),
                    React.createElement(Pagination, { value: this.state.links.next, name: "Next" }),
                    React.createElement(Pagination, { value: this.state.links.last, name: "Last" })
                )
            );
        }
    }]);

    return FilterablePartTable;
}(React.Component);

var Pagination = function (_React$Component2) {
    _inherits(Pagination, _React$Component2);

    function Pagination(props) {
        _classCallCheck(this, Pagination);

        return _possibleConstructorReturn(this, (Pagination.__proto__ || Object.getPrototypeOf(Pagination)).call(this, props));
    }

    _createClass(Pagination, [{
        key: "render",
        value: function render() {
            return React.createElement(
                "div",
                null,
                React.createElement(
                    "a",
                    { href: this.props.value },
                    this.props.name
                )
            );
        }
    }]);

    return Pagination;
}(React.Component);

var PartCollection = function (_React$Component3) {
    _inherits(PartCollection, _React$Component3);

    function PartCollection(props) {
        _classCallCheck(this, PartCollection);

        return _possibleConstructorReturn(this, (PartCollection.__proto__ || Object.getPrototypeOf(PartCollection)).call(this, props));
    }

    _createClass(PartCollection, [{
        key: "render",
        value: function render() {
            if (this.props.collection) {
                // TODO: change 'i' with actual id of given resource
                var i = 0;
                var tableRows = this.props.collection.map(function (part) {
                    return React.createElement(PcPart, { key: ++i, res_obj: part });
                });
                return React.createElement(
                    "table",
                    null,
                    React.createElement(
                        "tbody",
                        null,
                        React.createElement(TableHeader, { header_data: this.props.collection.meta }),
                        tableRows
                    )
                );
            }

            return React.createElement(
                "div",
                null,
                "Empty"
            );
        }
    }]);

    return PartCollection;
}(React.Component);

var PcPart = function (_React$Component4) {
    _inherits(PcPart, _React$Component4);

    function PcPart(props) {
        _classCallCheck(this, PcPart);

        return _possibleConstructorReturn(this, (PcPart.__proto__ || Object.getPrototypeOf(PcPart)).call(this, props));
    }

    _createClass(PcPart, [{
        key: "render",
        value: function render() {
            var resource = new Resource(this.props.res_obj);
            // TODO: render single resource
            return React.createElement(
                "tr",
                null,
                React.createElement(
                    "td",
                    { className: "product_name" },
                    React.createElement("img", { src: resource.attributes[TopLevelResource.image_key], alt: "" }),
                    resource.attributes[TopLevelResource.name_key]
                ),
                React.createElement(Fields, { etl_fields: resource })
            );
        }
    }]);

    return PcPart;
}(React.Component);

var TableHeader = function (_React$Component5) {
    _inherits(TableHeader, _React$Component5);

    function TableHeader(props) {
        _classCallCheck(this, TableHeader);

        return _possibleConstructorReturn(this, (TableHeader.__proto__ || Object.getPrototypeOf(TableHeader)).call(this, props));
    }

    _createClass(TableHeader, [{
        key: "render",
        value: function render() {
            var meta = this.props.header_data;
            var keys = [];
            var values = [];
            if (meta) {
                var essentialFields = meta[TopLevelResource.essential_fields_key];
                keys = Object.keys(essentialFields);
                values = Object.values(essentialFields);
            } else {
                keys = [];
                values = [];
            }

            var i = 0;
            var headers = keys.map(function (key) {
                return React.createElement(
                    "th",
                    { className: "product-table-header", key: ++i, "data-attr": values[key] },
                    key
                );
            });

            return React.createElement(
                "tr",
                null,
                headers
            );
        }
    }]);

    return TableHeader;
}(React.Component);

var Fields = function (_React$Component6) {
    _inherits(Fields, _React$Component6);

    function Fields(props) {
        _classCallCheck(this, Fields);

        return _possibleConstructorReturn(this, (Fields.__proto__ || Object.getPrototypeOf(Fields)).call(this, props));
    }

    _createClass(Fields, [{
        key: "render",
        value: function render() {
            var resource = this.props.etl_fields;
            var meta = resource.meta;

            var values = Object.values(meta[TopLevelResource.essential_fields_key]);
            var i = 0;
            var rowData = values.map(function (key) {
                return React.createElement(
                    "td",
                    { key: ++i },
                    resource.attributes[key]
                );
            });

            // to render children just use array
            return [rowData];
        }
    }]);

    return Fields;
}(React.Component);

var element = React.createElement(FilterablePartTable, null);
ReactDOM.render(element, document.getElementById("collection_of_part"));