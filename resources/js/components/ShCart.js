import React, { Component } from 'react'
import axios from 'axios'
import ReactDOM from 'react-dom'
import { Link } from 'react-router-dom'

import HeaderDet from './HeaderDet';
import Footer from './Footer';

export default class ShCart extends Component{
    constructor(props){
        super(props);

        this.state = {
            
            carts: [],
            subprice: '',
            price: '',
            
            subtotal: '',
            tootal: '',

            order: {
                // file : '',
                cart_id: '',
                name : '',
                description : '',
                subprice: '',
                price : '',
                category : '',
                quantity : '',
            },
            errorMsg: ''
            
        }
    }

    check = e => {
        e.preventDefault()
        var a=localStorage.getItem("authen");
        // console.log(this.state);

        axios
            // .post('http://localhost/yummypizza/public/api/auth/order', this.state,
            .post('https://damp-island-72638.herokuapp.com/api/auth/order', this.state,
            {
               
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer '+a,
                    // 'withCredentials': true
                }
            })
            .then(response => {
                // console.log(response)
            })
            .catch(error => {
                // console.log(error)
            })
    }

    componentDidMount(){
        var a=localStorage.getItem("authen");
        // const { match: { params } } = this.props;
        axios

            // .get('http://localhost/yummypizza/public/api/auth/shcart', {
            .get('https://damp-island-72638.herokuapp.com/api/auth/shcart', {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer '+a,
                    // 'withCredentials': true
                }
            })
            .then(response => {
                // console.log(response.data.carts.data);
                this.setState({ carts: response.data.carts.data });
                var c = this.state.carts.map((cart, i)=> cart.price);
                var q = this.state.carts.map((cart, i)=> cart.quantity);
                var sum = parseInt(c) * parseInt(q);
                // var subprice = cart.subprice;
                // var price = cart.price;
                // this.setState({ subprice: c });
                // this.setState({ price: sum });

                // console.log(sum)
                // console.log(q)
                // console.log(c);
            })
            .catch(error => {
                // console.log(error)
                this.setState({errorMsg: 'Error retrieving data'})
            })

    }

    render(){
        const { carts, errorMsg, subtotal, total } = this.state;
        const { id, subprice, cart_id, name, description, price, category, quantity } = this.state;
        
        return(
            <div>
                <HeaderDet />
                
                {/* <!-- Breadcrumb Section Begin --> */}
                <section className="breadcrumb-section set-bg" data-setbg="img/breadcrumb.jpg">
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-12 text-center">
                                <div className="breadcrumb__text">
                                    <h2>Shopping Cart</h2>
                                    <div className="breadcrumb__option">
                                        <Link to="">Home</Link>
                                        <span>Shopping Cart</span>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {/* <!-- Breadcrumb Section End --> */}

                {/* <!-- Shoping Cart Section Begin --> */}
                <section className="shoping-cart spad">
                    <div className="container">
                        {/* <form onSubmit={this.check} encType="multipart/form-data" > */}
                            <div className="row">
                                <div className="col-lg-12">
                                    <div className="shoping__cart__table">
                                        <table>
                                            <thead>
                                                <tr>
                                                    <th className="shoping__product">Products</th>
                                                    <th>Price</th>
                                                    <th>Quantity</th>
                                                    <th>Total</th>
                                                    <th></th>
                                                </tr>
                                            </thead>
                                            <tbody>
                                                {carts.map((cart, i)=>
                                                <tr key={cart.id}>
                                                    <td className="shoping__cart__item">
                                                        <img src="img/cart/cart-1.jpg" alt="" />
                                                        <h5> {cart.name} </h5>
                                                    </td>
                                                    <td className="shoping__cart__price">
                                                        ${cart.price}
                                                        {/* ${subprice} */}
                                                    </td>
                                                    <td className="shoping__cart__total">
                                                        {cart.quantity}
                                                        {/* {price} */}
                                                    </td>
                                                    <td className="shoping__cart__item__close">
                                                        {parseInt(cart.price) * parseInt(cart.quantity)}
                                                    </td>
                                                </tr>
                                                )}
                                            </tbody>
                                        </table>
                                    </div>
                                </div>
                            </div>
                            <div className="row">
                                <div className="col-lg-12">
                                    <div className="shoping__cart__btns">
                                        <Link to="/" className="primary-btn cart-btn">CONTINUE SHOPPING</Link>
                                        <Link to="" className="primary-btn cart-btn cart-btn-right"><span className="icon_loading"></span>
                                            Update Cart</Link>
                                    </div>
                                </div>
                                <div className="col-lg-6">
                                    <div className="shoping__continue">
                                        <div className="shoping__discount">
                                            <h5>Discount Codes</h5>
                                            {/* <form action="#"> */}
                                                <input type="text" placeholder="Enter your coupon code" />
                                                <button className="site-btn">APPLY COUPON</button>
                                            {/* </form> */}
                                        </div>
                                    </div>
                                </div>
                                <div className="col-lg-6">
                                    <div className="shoping__checkout">
                                        <Link to="/checkout" className="primary-btn">PROCEED TO CHECKOUT</Link>
                                    </div>
                                </div>
                            </div>
                        {/* </form> */}
                    </div>
                </section>
                {/* <!-- Shoping Cart Section End --> */}

                <Footer />
            </div>
        )
    }
}

if (document.getElementById('ShCart')) {
    ReactDOM.render(<ShCart />, document.getElementById('ShCart'));
}
