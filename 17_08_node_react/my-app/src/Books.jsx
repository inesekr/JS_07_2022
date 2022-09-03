import React from 'react';

class Books extends React.Component {

    constructor() {
        super();
        this.state = {
            books: [],
            booksInit: [],
            editable: false,
            booksToUpdate: []
        }
        this.booksInit();
    }

    // componentDidMount() {
    //     this.props.booksInit(this);
    // }

    booksInit = () => {
        let self = this;
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

    onChangeSave = () => {
        // console.error("err");
        let booksListUpdate = [];
        for (let i = 0; i < this.state.booksToUpdate.length; i++) {
            if (this.state.booksToUpdate[i] !== true)
                continue;
            const bookId = i;
            const book = this.state.books.find((book) => {
                return book.id === bookId;
            })
            booksListUpdate.push(book);
        }

        const headers = new Headers();
        headers.append("Content-type", "application/json");
        const self = this;
        fetch("http://localhost:80/my-app-backend/updateBook.php", {
            method: "POST",
            headers: headers,
            body: JSON.stringify(booksListUpdate)
        }).then(function (response) {

            response.json().then((body) => {
                alert(body);
                // const booksInit = self.state.books;
                // self.setBookTable(booksInit);
                // self.setState({ booksToUpdate: [] });
                const booksInit = this.state.books;
                // this.setState({ booksInit: booksInit, })
                self.setBookTable(booksInit);
                self.setState({ booksToUpdate: [] });
            })
        })
        // event.preventDefault();

        // console.log(booksListUpdate);
        this.setEditable();
    }

    updateBook = (id, fieldname, value) => {
        const books = this.state.books;//copy the array (will modify existing array)
        const bookUpdate = books.find((book) => {
            return book.id === id;
        })
        // console.log(book);
        // console.log(bookUpdate);
        bookUpdate[fieldname] = value;
        const booksUpdatedToSave = this.state.booksToUpdate;
        booksUpdatedToSave[id] = true;
        this.setState({ books: books, booksToUpdate: booksUpdatedToSave });

    }

    setBookTable(booksLoad) {
        const initBooks = [];
        booksLoad.map((obj) => {
            initBooks.push(Object.assign({}, obj)); //"object.assign" means "copy object"
        })

        this.setState({ books: initBooks, booksInit: booksLoad });// we need also state before changes, for e.g. if we have cancel button also
        // console.log(this.state.books);
    }

    setEditable = () => { //should use this function declaration, then this will be current object
        const editable = !this.state.editable;
        this.setState({ editable: editable });//if it is editable, it will set it to non-editable, and vs
    }

    onInputChange = (event, id) => {
        const fieldname = event.target.getAttribute("fieldname");
        // console.log(fieldname);
        const value = event.target.value;
        // console.log(key);
        this.updateBook
            (id, fieldname, value);
    }

    onCancel = () => {
        const books = this.state.booksInit;
        this.setBookTable(books);
        this.setEditable();
    }

    render() {
        return (
            <form action="" method="POST">
                <button className="btn btn-primary" type="button" onClick={this.setEditable}>Edit</button>
                <button className="btn btn-primary" type="button" onClick={this.onChangeSave}>Save</button>
                <button className="btn btn-primary" type="button" onClick={this.onCancel}>Cancel</button>
                <table>
                    <thead>
                        <tr>
                            <th>Title</th>
                            <th>Author</th>
                            <th>Pages</th>
                        </tr>
                    </thead>
                    <tbody>
                        {
                            !(this.state.books === undefined) && this.state.books.map((book) => {
                                return (
                                    <tr key={book.id} onChange={(e) => this.onInputChange(e, book.id)}>
                                        <td>
                                            <div hidden={this.state.editable}>{book.title}</div>
                                            <input hidden={!this.state.editable} fieldname="title" defaultValue={book.title} />
                                        </td>
                                        <td>
                                            <div hidden={this.state.editable}>{book.author}</div>
                                            <input hidden={!this.state.editable} fieldname="author" defaultValue={book.author} />
                                        </td>
                                        <td>
                                            <div hidden={this.state.editable}>{book.pages}</div>
                                            <input hidden={!this.state.editable} fieldname="pages" defaultValue={book.pages} />
                                        </td>
                                    </tr>
                                );
                            })
                        }
                    </tbody>
                </table>
            </form >
        );
    }
}

export default
    Books;