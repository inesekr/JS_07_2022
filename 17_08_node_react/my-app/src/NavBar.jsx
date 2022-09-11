import { useState } from "react";
import { useEffect } from "react";
import { Link, Outlet } from "react-router-dom";


// function NavBar({ openPage }) {
function NavBar() {

    const [currentPage, setCurrentPage] = useState(window.location.pathname);

    const onLogout = () => {
        sessionStorage.removeItem("user");
        window.location.reload();
    }

    return (
        <>
            < nav className="navbar navbar-expand navbar-light bg-light" >
                <div className="collapse navbar-collapse">
                    <ul className="navbar-nav mr-auto">
                        <li className={currentPage === "/" ? "nav-item nav-item-active" : "nav-item"}>
                            <Link to="/" onClick={() => {
                                setCurrentPage("/")
                            }}>Home</Link>
                            {/* <button className="btn" onClick={() => openPage("HomePage")}>Home</button> */}
                        </li>
                        <li className={currentPage === "/loadPage" ? "nav-item nav-item-active" : "nav-item"}>
                            <Link to="/loadPage" onClick={() => { setCurrentPage("/loadPage") }}>LoadPage</Link>
                            {/* <button className="btn" onClick={() => openPage("LoadPage")}>LoadPage</button> */}
                        </li>
                    </ul>
                </div>
                <ul className="nav navbar-nav nav-list navbar-right">
                    <li className="username">
                        <a >{JSON.parse(sessionStorage.getItem("user")).username}</a>
                    </li>
                    <li className="nav-item">
                        <a onClick={onLogout}>Logout</a>
                    </li>
                </ul>
            </nav >
            <Outlet></Outlet>
        </>
    )
}
export default NavBar;