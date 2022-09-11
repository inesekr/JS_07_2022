import { render } from "@testing-library/react";
import { useState } from 'react';
import Login from './Login';
import Register from './Register';



function LoginPage() {

    const [register, setRegister] = useState(false);


    // const onRegister = () => {

    // }

    return (
        // <div className="container">

        //     <button type="submit" class="btn btn-primary btn-block mb-4">Sign in</button>

        //     <div class="text-center">
        //         <p>Not a member? <a href="#!">Register</a></p>
        //     </div>

        //     <button type="submit" class="btn btn-primary btn-block mb-3">Sign in</button>

        // </div>
        <div className="container">
            < nav className="navbar navbar-expand navbar-light bg-light" >
                <div className="collapse navbar-collapse">
                    <ul className="navbar-nav mr-auto">
                        <li className="nav-item">
                            <button type="button" className={register ? "btn" : "btn btn-primary"} onClick={() => { setRegister(false) }} >Login</button>
                        </li>
                        <li className="nav-item">
                            <button type="button" className={!register ? "btn" : "btn btn-primary"} onClick={() => { setRegister(true) }}>Register</button>
                        </li>
                    </ul>
                </div>
            </nav >
            {!register &&
                <Login></Login>}
            {register && <Register></Register>}
        </div >
    )
}

export default LoginPage;
