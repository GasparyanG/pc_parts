var _createClass = function () { function defineProperties(target, props) { for (var i = 0; i < props.length; i++) { var descriptor = props[i]; descriptor.enumerable = descriptor.enumerable || false; descriptor.configurable = true; if ("value" in descriptor) descriptor.writable = true; Object.defineProperty(target, descriptor.key, descriptor); } } return function (Constructor, protoProps, staticProps) { if (protoProps) defineProperties(Constructor.prototype, protoProps); if (staticProps) defineProperties(Constructor, staticProps); return Constructor; }; }();

function _classCallCheck(instance, Constructor) { if (!(instance instanceof Constructor)) { throw new TypeError("Cannot call a class as a function"); } }

function _possibleConstructorReturn(self, call) { if (!self) { throw new ReferenceError("this hasn't been initialised - super() hasn't been called"); } return call && (typeof call === "object" || typeof call === "function") ? call : self; }

function _inherits(subClass, superClass) { if (typeof superClass !== "function" && superClass !== null) { throw new TypeError("Super expression must either be null or a function, not " + typeof superClass); } subClass.prototype = Object.create(superClass && superClass.prototype, { constructor: { value: subClass, enumerable: false, writable: true, configurable: true } }); if (superClass) Object.setPrototypeOf ? Object.setPrototypeOf(subClass, superClass) : subClass.__proto__ = superClass; }

import { Resource, Link } from "/public/js/collection_of_part/Resource.js";

var FilterablePartTable = function (_React$Component) {
    _inherits(FilterablePartTable, _React$Component);

    function FilterablePartTable(props) {
        _classCallCheck(this, FilterablePartTable);

        // state of table
        var _this = _possibleConstructorReturn(this, (FilterablePartTable.__proto__ || Object.getPrototypeOf(FilterablePartTable)).call(this, props));

        _this.state = {
            collection: new Resource([]),
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
                        collection: new Resource(result),
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
                React.createElement("div", { className: "part_collection" }),
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

var element = React.createElement(FilterablePartTable, null);
ReactDOM.render(element, document.getElementById("collection_of_part"));