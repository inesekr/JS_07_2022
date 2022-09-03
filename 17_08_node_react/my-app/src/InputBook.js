import React from 'react';

class InputBook extends React.Component {
    constructor() {
        super();
        this.state = {
            title: "",
            author: "",
            pages: ""
        }
    }

    onSave = (event) => {
        let self = this;
        const headers = new Headers();
        headers.append("Content-type", "application/json");
        fetch("http://localhost:80/my-app-backend/createBook.php", {
            method: "POST",
            headers: headers,
            body: JSON.stringify(self.state)
        }).then(function (response) {

            response.json().then((body) => {
                alert(body);
            })

        })
        // event.preventDefault();
    }

    onTitleChange = (event) => {
        this.setState({ title: event.target.value });
    }

    onAuthorChange = (event) => {
        this.setState({ author: event.target.value });
    }

    onPagesChange = (event) => {
        this.setState({ pages: event.target.value });
    }

    render() {
        return (
            <form onSubmit={this.onSave} action="">
                <div className="form-group">
                    <label htmlFor="title">Title</label>
                    <input id="title" fieldname="title" value={this.state.title} onChange={this.onTitleChange} />
                    <label htmlFor="author">Author</label>
                    <input id="author" fieldname="author" value={this.state.author} onChange={this.onAuthorChange} />
                    <label htmlFor="pages">Pages</label>
                    <input id="pages" fieldname="pages" value={this.state.pages} onChange={this.onPagesChange} />
                    <button className="btn btn-primary">Save</button>
                </div>
            </form >
        );
    }
}

export default InputBook;