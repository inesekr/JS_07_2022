// import logo from './logo.svg';
import './App.css';
import NavBar from './NavBar';
import HomePage from './pages/HomePage';
import React from 'react';
import LoadPage from './pages/LoadPage';
import { BrowserRouter, Route, Routes } from 'react-router-dom';

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
      //this was before installing/using router:
      // <div className="App container">
      //   <NavBar openPage={this.openPage}></NavBar>
      //   {this.state.pageDisplayed === "HomePage" && <HomePage />}
      //   {this.state.pageDisplayed === "LoadPage" && < LoadPage />}
      // </div>

      <div className="App container">
        <BrowserRouter>
          <Routes>
            <Route path="/" element={<NavBar></NavBar>}>
              <Route index element={<HomePage></HomePage>}></Route>
              <Route path="loadPage" element={<LoadPage></LoadPage>}></Route>
            </Route>
          </Routes>
        </BrowserRouter>

      </div>
    );
  }
}
export default App;
