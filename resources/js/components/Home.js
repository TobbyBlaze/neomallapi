import React, { Component } from 'react'
import axios from 'axios'
import ReactDOM from 'react-dom'
import { Link, useParams } from 'react-router-dom'
import HeaderHome from './HeaderHome';
import Header from './Header';
import Footer from './Footer';

export default class Home extends Component{
    // _isMounted = false;
    constructor(props){
        super(props);

        this.state = {
            goods: [],
            good: {
                file : '',
                name : '',
                description : '',
                price : '',
                category : '',
            },
            errorMsg: ''
            
        }
    }

    addCart = () => {
        var a=localStorage.getItem("authen");
        axios

            // .post('http://localhost/yummypizza/public/api/auth/storecart', this.state.good, {
            .post('https://damp-island-72638.herokuapp.com/api/auth/storecart', this.state.good, {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer '+a,
                    // 'withCredentials': true
                }
            })
            .then(response => {
                console.log(response)
            })
            .catch(error => {
                console.log(error)
                this.setState({errorMsg: 'Error retrieving data'})
            })
    }

    componentDidMount(){
        var a=localStorage.getItem("authen");
        axios

            // .get('http://localhost/yummypizza/public/api/auth', {
            .get('https://damp-island-72638.herokuapp.com/api/auth', {
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Content-Type': 'application/json',
                    'Authorization': 'Bearer '+a,
                    // 'withCredentials': true
                }
            })
            .then(response => {
                // console.log(response.data.goods.data)
                this.setState({ goods: response.data.goods.data })
            })
            .catch(error => {
                // console.log(error)
                this.setState({errorMsg: 'Error retrieving data'})
            })

    }

    getOne(good){
        this.setState({
            goods:{
            id : good.id,
            file : good.file,
            name : good.name,
            description : good.description,
            price : good.price,
            category : good.category
            }
        })
    }

    componentWillUnmount() {
        // fix Warning: Can't perform a React state update on an unmounted component
        this.setState = (state,callback)=>{
            return;
        };
    }

    render(){
        const { goods, errorMsg } = this.state;

        return(
            
            <div>
                <HeaderHome />
                
                {/* <!-- Categories Section Begin --> */}
                <section className="categories">
                    <div className="container">
                        <div className="row">
                            <div className="categories__slider owl-carousel">
                                <div className="col-lg-3">
                                    <div className="categories__item set-bg" data-setbg="img/categories/cat-1.jpg">
                                        <h5><Link to="">St. Louis Pizza</Link></h5>
                                    </div>
                                </div>
                                <div className="col-lg-3">
                                    <div className="categories__item set-bg" data-setbg="img/categories/cat-2.jpg">
                                        <h5><Link to="">Detroit Pizza</Link></h5>
                                    </div>
                                </div>
                                <div className="col-lg-3">
                                    <div className="categories__item set-bg" data-setbg="img/categories/cat-3.jpg">
                                        <h5><Link to="">California Pizza</Link></h5>
                                    </div>
                                </div>
                                <div className="col-lg-3">
                                    <div className="categories__item set-bg" data-setbg="img/categories/cat-4.jpg">
                                        <h5><Link to="">Greek Pizza</Link></h5>
                                    </div>
                                </div>
                                <div className="col-lg-3">
                                    <div className="categories__item set-bg" data-setbg="img/categories/cat-5.jpg">
                                        <h5><Link to="">Sicilian Pizza</Link></h5>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </section>
                {/* <!-- Categories Section End --> */}

                {/* <!-- Featured Section Begin --> */}
                <section className="featured spad">
                    <div className="container">
                        <div className="row">
                            <div className="col-lg-12">
                                <div className="section-title">
                                    <h2>Featured Product</h2>
                                </div>
                                <div className="featured__controls">
                                    <ul>
                                        <li className="active" data-filter="*">All</li>
                                        <li data-filter=".oranges">St. Louis Pizza</li>
                                        <li data-filter=".fresh-meat">Detroit Pizza</li>
                                        <li data-filter=".vegetables">California Pizza</li>
                                        <li data-filter=".fastfood">Greek Pizza</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                        <div className="row featured__filter">
                            {goods.map((good, i)=>
                            <div key={good.id} className="col-lg-3 col-md-4 col-sm-6 mix oranges fresh-meat">
                                <div className="featured__item">
                                    <div className="featured__item__pic set-bg" data-setbg="img/featured/feature-1.jpg">
                                        <ul className="featured__item__pic__hover">
                                            <li><Link to=""><i className="fa fa-heart"></i></Link></li>
                                            <li><a href="api/storecart/{good.id.toString()}"><i className="fa fa-shopping-cart"></i></a></li>
                                        </ul>
                                    </div>
                                    <div className="featured__item__text">
                                        <div>
                                        <Link to={"prdetails/"+good.id}>
                                        <img src={"storage/files/images/"+good.image} alt="{image}" />
                                        <h3>{good.name}</h3>
                                        {/* <h6><button onClick={(e)=>this.getOne(good)}>{good.name}</button></h6> */}
                                        <h4>{good.price}</h4>
                                        {/* <li><a href={"api/auth/storecart/"+good.id}><i className="fa fa-shopping-cart"></i></a></li> */}
                                        
                                            {/* <li><Link to={good.name}><i className="fa fa-heart"></i></Link></li> */}
                                        </Link>
                                        </div>
                                    </div>
                                </div>
                            </div>
                            )}
                        </div>
                    </div>
                </section>
                {/* <!-- Featured Section End --> */}

                <Footer />
            </div>
        )
    }
}

// if (document.getElementById('home')) {
//     ReactDOM.render(<Home />, document.getElementById('home'));
// }
