import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import axios from 'axios';
import { Link } from 'react-router-dom'

export default class Admine extends Component {

    constructor(props) {
        super(props)

        this.state = {
            file: null,
            name: '',
            description: '',
            price: '',
            category: '',
        }
    }

    changeHandler = e => {
        this.setState({ [e.target.name]: e.target.value })
    }

    fileHandler = (event) => {
        this.setState({file: URL.createObjectURL(event.target.files[0])});
    }

    submitHandler = e => {
        var a=localStorage.getItem("authen");
        e.preventDefault()
        console.log(this.state)

        axios
            // .post('http://localhost/yummypizza/public/api/auth/login', this.state)
            .post('https://damp-island-72638.herokuapp.com/api/auth', this.state, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer '+a,
                    // 'withCredentials': true
                }
            })
            .then(response => {
                console.log(response);
                var authe = response.data.token;
                localStorage.setItem("authen",authe);
                // console.log(authe);
                // window.location.href = "https://damp-island-72638.herokuapp.com"
                // var sub = true;
            })
            .catch(error => {
                console.log(error)
            })
    }

    render() {
        const { file, name, description, price, category } = this.state;
        return (
            <div>
                <div className="limiter">
                    <div className="container-login100">
                        <div className="wrap-login100 p-t-30 p-b-50">
                            <span className="login100-form-title p-b-41">
                                Add goods here
                            </span>
                            <form onSubmit={this.submitHandler} className="login100-form validate-form p-b-33 p-t-5">

                            <input type="file" name="file" onChange={this.fileHandler} class="btn btn-default text-center active form-control-file" title="Click to upload file"/>

                                <div className="wrap-input100 validate-input" data-validate = "Enter email">
                                    
                                    <input className="input100" type="text" name="name" placeholder="name" value={name} onChange={this.changeHandler}  />
                                    <span className="focus-input100" data-placeholder="&#xe82a;"></span>
                                </div>

                                <div className="wrap-input100 validate-input" data-validate="Enter password">
                                    <input className="input100" type="text" name="description" placeholder="description" value={description} onChange={this.changeHandler}  />
                                    <span className="focus-input100" data-placeholder="&#xe80f;"></span>
                                </div>

                                <div className="wrap-input100 validate-input" data-validate = "Enter email">
                                    <input className="input100" type="number" name="price" placeholder="price" value={price} onChange={this.changeHandler}  />
                                    <span className="focus-input100" data-placeholder="&#xe82a;"></span>
                                </div>

                                <div className="wrap-input100 validate-input" data-validate="Enter password">
                                    <input className="input100" type="text" name="category" placeholder="category" value={category} onChange={this.changeHandler}  />
                                    <span className="focus-input100" data-placeholder="&#xe80f;"></span>
                                </div>

                                <div className="container-login100-form-btn m-t-32">
                                    <button type="submit" className="login100-form-btn">
                                        Add good
                                    </button>
                                </div>
                                
                            </form>
                        </div>
                    </div>
                </div>
                

                <div id="dropDownSelect1"></div>
            </div>
        );
    }
}

if (document.getElementById('admine')) {
    ReactDOM.render(<Admine />, document.getElementById('admine'));
}