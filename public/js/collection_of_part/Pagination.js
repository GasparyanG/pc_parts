import React from "react"
import {TopLevelResource, Resource, Link} from "./Resource";

class Pagination extends React.Component {
    constructor(props) {
        super(props);
    }

    changePage = (pageNumber) => {
        this.props.dispatch({type: "PAGE_NUMBER", number: pageNumber});
    }

    render() {

        return (
            <div className="pagination">
                <a className="page_identifier" onClick={() => this.changePage(this.props.link.get_first_page_number())}>
                    First
                </a>
                <a className="page_identifier" onClick={() => this.changePage(this.props.link.get_previous_page_number())}>
                    Prev
                </a>
                <a className="page_identifier page_active" onClick={() => this.changePage(this.props.link.get_current_page_number())}>
                    Current
                </a>
                <a className="page_identifier" onClick={() => this.changePage(this.props.link.get_next_page_number())}>
                    Next
                </a>
                <a className="page_identifier" onClick={() => this.changePage(this.props.link.get_last_page_number())}>
                    Last
                </a>
            </div>
        );
    }
}

export default Pagination;