import React from 'react';
import BooksFile from '../BooksFile';

class LoadPage extends React.Component {

    constructor() {
        super();
        this.state = {
            filename: "",
            filepath: "",
            load: false
        }
    }

    onFileNameChange = (event) => {
        const filename = event.target.files[0].name;
        this.setState({ filename: filename, filepath: event.target.value });
    }

    // onFileLoad = () => {
    //     const headers = new Headers();
    //     const self = this;
    //     headers.append("Content-type", "application/json");
    //     fetch("http://localhost:80/my-app-backend/getFileContent.php", {
    //         method: "POST",
    //         headers: headers,
    //         body: JSON.stringify(self.state.filename)
    //     }).then(function (response) {

    //     })
    // }

    render() {
        return (
            <div >
                <input type="file" value={this.state.filepath}
                    onChange={this.onFileNameChange}></input>
                <button className="btn" onClick={() => { this.setState({ load: true }) }}>Load</button>
                {this.state.load === true && <BooksFile filename={this.state.filename}></BooksFile>}
            </ div >
        )
    }
}
export default LoadPage;