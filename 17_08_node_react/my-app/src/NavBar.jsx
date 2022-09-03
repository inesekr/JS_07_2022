function NavBar({ openPage }) {
    const openPageLocal = page => {
        openPage(page);
    }
    return (
        < nav className="navbar navbar-expand-lg navbar-light bg-light" >
            <div className="collapse navbar-collapse" id="navbarSupportedContent">
                <ul className="navbar-nav mr-auto">
                    <li className="nav-item active">
                        <a className="nav-link" ><button className="btn" onClick={openPageLocal("HomePage")}>Home</button></a>
                    </li>
                    <li className="nav-item">
                        <a className="nav-link"><button className="btn" onClick={openPageLocal("LoadPage")}>LoadPage</button></a>
                    </li>
                </ul>
            </div>
        </nav >
    )
}
export default NavBar;