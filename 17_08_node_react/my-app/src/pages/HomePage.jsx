// import Books from '../Books';
// import { useEffect, useState } from 'react';
import BooksDB from '../BooksDB';
import InputBook from '../InputBook';



function HomePage() {

    // const [count, setCount] = useState(0);

    // useEffect(() => {
    //     let sessionCount = sessionStorage.getItem("count");
    //     // alert(sessionCount);

    //     if (sessionCount == null) {
    //         sessionCount = 0;
    //     }
    //     sessionCount = Number(sessionCount);
    //     setCount(sessionCount);
    // }, []);

    // const displayCount = () => {
    //     alert(count);
    // }

    // const addCount = () => {
    //     const newCount = count + 1;
    //     setCount(newCount);
    //     sessionStorage.setItem("count", newCount);
    // }

    return (
        <div>
            <InputBook></InputBook>
            <BooksDB></BooksDB>
            {/* <button className='btn' onClick={addCount}>Add count</button>
            <button className='btn' onClick={displayCount}>Display count</button> */}
        </div >
    );
}

export default HomePage;

