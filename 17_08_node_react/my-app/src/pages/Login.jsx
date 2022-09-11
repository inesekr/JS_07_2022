import { useState } from 'react';

function Login() {

    const [username, setUserName] = useState("");
    const [password, setPassword] = useState("");

    const onLogin = (event) => {

        const headers = new Headers();
        headers.append("Content-type", "application/json");

        fetch("http://localhost:80/userManagement/Login.php", {
            method: "POST",
            headers: headers,
            body: JSON.stringify({
                username: username,
                password: password
            })
        }).then((response) => {

            response.json().then((body) => {
                // console.log(body); this was for testing
                if (body.userexist === false) { alert("Login failed, username or password is not correct"); }
                else {
                    sessionStorage.setItem("user", JSON.stringify({ username: username, roleID: body.role }));
                    window.location.reload();
                }
            })
        })
        event.preventDefault();
    }

    return (
        <div>
            <form className="form" onSubmit={(event) => { onLogin(event) }} method="POST">
                <div className="form-outline mb-4">
                    <input type="text" id="loginName" name="username" className="form-control"
                        onChange={(event) => {
                            setUserName(event.target.value)
                        }} />
                    <label className="form-label" htmlFor="username">Username</label>
                </div>
                <div className="form-outline mb-4">
                    <input type="password" id="password" name="password" className="form-control"
                        onChange={(event) => {
                            setPassword(event.target.value)
                        }} />
                    <label className="form-label" htmlFor="password">Password</label>
                </div>
                <button className="btn btn-primary">Login</button>
            </form>
        </div>
    )
}

export default Login;