// import logo from './logo.svg';
import './App.css';
import NavBar from './NavBar';
import HomePage from './pages/HomePage';
import React from 'react';
import LoadPage from './pages/LoadPage';

class App extends React.Component {

  constructor() {
    super();
    this.state = {
      // books: [],
      // booksInit: [],
      // editable: false,
      // booksToUpdate: []

      pageDisplayed: "HomePage"
    }
    // this.booksInit();
  }

  openPage = (pageName) => {
    this.setState({ pageDisplayed: pageName });
  }

  render() {
    return (
      <div className="App container">
        <NavBar openPage={this.openPage}></NavBar>
        {this.state.pageDisplayed === "HomePage" && <HomePage />}
        {this.state.pageDisplayed === "LoadPage" && < LoadPage />}
      </div>
    );
  }
}
export default App;
