import React from 'react';
import Books from './Books';

class BooksFile extends React.Component {

    booksInit = (sourceObj) => {
        const headers = new Headers();
        // const self = sourceObj;
        const filename = this.props.filename;
        headers.append("Content-type", "application/json");
        fetch("http://localhost:80/my-app-backend/getFileContent.php", {
            method: "POST",
            headers: headers,
            body: JSON.stringify(filename)
        }).then(function (response) {
            if (response.ok) {
                response.json().then(data => {
                    sourceObj.setBookTable(data.books);
                });
            }
        })
    }

    render() {
        return (
            <Books booksInit={this.booksInit} allNew={true}></Books>
        )
    }

}

export default BooksFile;