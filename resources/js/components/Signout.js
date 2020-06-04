import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';


export default class Signout extends Component {

    constructor(props) {
        super(props)
    }

    submitHandler = e => {
        e.preventDefault()
        // console.log(this.state)
        // console.log($('meta[name="csrf-token"]').attr('content'))
        var a=localStorage.getItem("authen");
        

        axios
            // .get('http://localhost/yummypizza/public/api/auth/logout',{
            .get('https://damp-island-72638.herokuapp.com/api/auth/logout',{
                headers: {

                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer '+a,
                    // 'withCredentials': true
                }
            })
            .then(response => {
                // console.log(response);
                var a=null;
                // console.log(a);
                window.location.href = "https://damp-island-72638.herokuapp.com"
            })
            .catch(error => {
                // console.log(error)
            })
    }

    render() {
        return (
            <div>
                <form onSubmit={this.submitHandler}>
                    <button type="submit">Sign out</button>
                </form>
            </div>
        );
    }
}

if (document.getElementById('signout')) {
    ReactDOM.render(<Signout />, document.getElementById('signout'));
}