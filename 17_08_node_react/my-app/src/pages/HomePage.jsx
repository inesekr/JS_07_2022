import Books from '../Books';
import InputBook from '../InputBook';
import BooksDB from '../BooksDB';


function HomePage() {
    return (
        <div>
            <InputBook></InputBook>
            <BooksDB></BooksDB>
        </div >
    );
}

export default HomePage;

