class FilterablePartTable extends React.Component {
    constructor(props) {
        super(props);
        this.state = {collection: null}
    }

    // lifecycle components
    componentDidMount() {

    }

    componentWillUnmount() {

    }

    render() {
        return (<h1>Hello, {this.state.collection}</h1>);
    }
}

const element = <FilterablePartTable />;
ReactDOM.render(element, document.getElementById("collection_of_part"));
