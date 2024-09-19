import { BrowserRouter, Routes, Route, Link } from "react-router-dom";
import Home from './Home';
import Create from './Create';
function App() {
    return (
        <BrowserRouter>
            <Routes>
                <Route path="/" element={<Home />} />
                <Route path="/create" element={<Create />} />
                {/*<Route path="/companies/create" element={<CompaniesCreate />} />*/}
                {/*/!*<Route path="/create" element={<Create />} />*!/*/}
                {/*<Link to="/create" replace>Profile</Link>*/}
            </Routes>
        </BrowserRouter>
    );
}
export default App;
