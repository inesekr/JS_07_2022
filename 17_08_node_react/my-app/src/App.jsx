// import logo from './logo.svg';
import './App.css';
import NavBar from './NavBar';
import HomePage from './pages/HomePage';
import React from 'react';
import LoadPage from './pages/LoadPage';
import LoginPage from './pages/LoginPage';
import { BrowserRouter, Route, Routes } from 'react-router-dom';

class App extends React.Component {

  constructor() {
    // alert(sessionStorage.getItem("user"));
    super();
    // alert(sessionStorage.getItem("user"));
    this.state = {

      user: JSON.parse(sessionStorage.getItem("user"))
    }
    // sessionStorage.setItem("user", "Dummy");

  }

  // openPage = (pageName) => {
  //   this.setState({ pageDisplayed: pageName });
  // }

  render() {
    if (this.state.user === null) {
      return (
        // <h1>User has no access</h1>
        <LoginPage></LoginPage>
      )
    }
    else {
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
}
export default App;
