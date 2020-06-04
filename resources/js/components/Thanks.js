import React, { Component } from 'react';
import ReactDOM from 'react-dom';


export default class Thanks extends Component {

    componentDidMount(){
        setTimeout(function(){window.location.href = "https://damp-island-72638.herokuapp.com"}, 3000);
    }

    render() {
        return (
            <div className="jumbotron">
                <h1>Thank you for purchasing with us. Returning to home page...</h1>
            </div>
        );
    }
}

if (document.getElementById('thanks')) {
    ReactDOM.render(<Thanks />, document.getElementById('thanks'));
}