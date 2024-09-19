import {NavLink} from "react-router-dom";
import { Component } from "react";
import axios from "axios"; // Don't forget to import axios!
// const config = {
//     headers: { Authorization: `11|nMwY7IM9Bv6buioiH7bgjauC6nd9XZvSJOa8NqPUc0829c32` }
// };
// axios.defaults.headers.common = {'Authorization': `bearer 11|nMwY7IM9Bv6buioiH7bgjauC6nd9XZvSJOa8NqPUc0829c32`}
class Home extends Component {
    constructor(props) {
        super(props);
        this.state = {
            companies: [],
        };
    }

    fetchCompanies() {
        axios
            .get('/api/users')
            .then((response) => console.log(response)
            );
    }

    componentDidMount() {
        this.fetchCompanies();
    }
    render() {
        return <div className="container">
            <div className="row my-5">
                <div className="col-md-8 mx-auto">
                    <h1> Add React js to laravel 10 with vite</h1>
                </div>
                <NavLink
                    to="/create"
                    className="px-4 py-2 rounded-md text-white bg-indigo-600 hover:bg-indigo-700"
                >
                    Create
                </NavLink>
            </div>
        </div>;
    }
}
export default Home;
