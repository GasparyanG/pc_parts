import React from "react"
import {TopLevelResource, Resource, Link} from "./Resource";

class Pagination extends React.Component {
    constructor(props) {
        super(props);
    }

    changePage = (pageNumber) => {
        this.props.dispatch({type: "PAGE_NUMBER", number: pageNumber, size: this.props.link.get_page_size()});
    }

    composeHtml = (metaOfHtml) => {
        return metaOfHtml.map((elInfo) => {
           if (elInfo.tag_type === "p") {
               return (
                   <p className={elInfo.class_name} onClick={() => this.changePage(elInfo.page_number)}>
                       {elInfo.page_number}
                   </p>
               );
           } else if (elInfo.tag_type === "div") {
               return (
                   <div className={elInfo.class_name}>...</div>
               );
           }
        });
    }

    prepareCenterPagination = (pages) => {
        const pages_meta = [
            {tag_type: "p", page_number: 1, class_name: "page_identifier"},
            {tag_type: "p", page_number: 2, class_name: "page_identifier"},
            {tag_type: "div", class_name: "pagination-dots"},
            {tag_type: "p", page_number: pages.prev_page, class_name: "page_identifier"},
            {tag_type: "p", page_number: pages.current_page, class_name: "page_identifier page_active"},
            {tag_type: "p", page_number: pages.next_page, class_name: "page_identifier"},
            {tag_type: "div", class_name: "pagination-dots"},
            {tag_type: "p", page_number: (pages.last_page - 1), class_name: "page_identifier"},
            {tag_type: "p", page_number: pages.last_page, class_name: "page_identifier"}
        ];

        return this.composeHtml(pages_meta);
    }

    prepareLeftPagination = (pages) => {
        const pages_meta = [];

        for (let p=0; p<3; ++p) {
            let className = "page_identifier";
            if (p===pages.current_page)
                className = "page_identifier page_active";
            pages_meta.push({tag_type: "p", page_number: p, class_name: className});
        }

        if (pages.current_page >= 2)
            pages_meta.push({tag_type: "p", page_number: pages.next_page, class_name: "page_identifier"});

        pages_meta.push(
            {tag_type: "div", class_name: "pagination-dots"},
            {tag_type: "p", page_number: (pages.last_page - 1), class_name: "page_identifier"},
            {tag_type: "p", page_number: pages.last_page, class_name: "page_identifier"}
        );

        return this.composeHtml(pages_meta);
    }

    prepareRightPagination = (pages) => {
        const pages_meta = [
            {tag_type: "p", page_number: 1, class_name: "page_identifier"},
            {tag_type: "p", page_number: 2, class_name: "page_identifier"},
            {tag_type: "div", class_name: "pagination-dots"},
        ];

        for (let p=pages.last_page - 3; p<=pages.last_page; ++p) {
            let className = "page_identifier";
            if (p===pages.current_page)
                className = "page_identifier page_active";
            pages_meta.push({tag_type: "p", page_number: p, class_name: className});
        }

        return this.composeHtml(pages_meta);
    }

    prepareRegularPagination = (pages) => {
        const pages_meta = [];

        for (let p=0; p<=pages.last_page; ++p) {
            let className = "page_identifier";
            if (p === pages.current_page)
                className = "page_identifier page_active";
            pages_meta.push({tag_type: "p", page_number: p, class_name: className});
        }

        return this.composeHtml(pages_meta);
    }

    preparePagination = () => {
        let firstPage = this.props.link.get_first_page_number();
        let lastPage = this.props.link.get_last_page_number();
        let currentPage = this.props.link.get_current_page_number();
        let nextPage = this.props.link.get_next_page_number();
        let previousPage = this.props.link.get_previous_page_number();

        if (currentPage === undefined) return null;

        const pages = {
            first_page: firstPage,
            last_page: lastPage,
            current_page: currentPage,
            next_page: nextPage,
            prev_page: previousPage
        };

        // TODO: get rid of magic constants
        if (lastPage > 8 && currentPage < lastPage - 2 && currentPage > 2)
            return this.prepareCenterPagination(pages);
        else if (lastPage > 8 && currentPage <= 2)
            return this.prepareLeftPagination(pages);
        else if (lastPage > 8 && currentPage >= lastPage - 2)
            return this.prepareRightPagination(pages);
        else
            return this.prepareRegularPagination(pages);
    }

    render() {
        const pagination = this.preparePagination();

        if (pagination)
            return (
                <div className="pagination">
                    {pagination}
                </div>
            );
        else
            return <div></div>;
    }
}

export default Pagination;