import React from 'react';
import Books from './Books';

class BooksDB extends React.Component {

    booksInit = (me) => {
        // let self = this;
        const self = me;
        fetch("http://localhost:80/my-app-backend/books.php", {
            method: "GET"
        }).then(function (response) {
            if (response.ok) {
                response.json().then(books => {
                    self.setBookTable(books);
                });
            }
        })
    }

    render() {
        return (
            <Books booksInit={this.booksInit}></Books>
        )
    }

}

export default BooksDB;