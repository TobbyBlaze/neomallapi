import React from 'react'
import { Link } from 'react-router-dom'
import Signout from './Signout';

const Header = () => (
    <div>
    <div id="preloder">
        <div className="loader"></div>
    </div>

    <header className="header">
        
        <div className="container">
            <div className="row">
                <div className="col-lg-3">
                    <div className="header__logo">
                        <Link to=""><img src="img/logo.png" width="100" alt="" /></Link>
                    </div>
                </div>
                <div className="col-lg-6">
                
                </div>
                <div className="col-lg-3">
                    <div className="header__cart">
                        <div className="dropdown">
                            <span>Hello user</span>
                            <div className="dropdown-content">
                                <ul className="header__menu__dropdown">
                                    <li><Link to="/">Home</Link></li>
                                    <li><Link to="/shcart">Shoping Cart</Link></li>
                                    <li><Link to="/checkout">Check Out</Link></li>
                                    <li>
                                        <Signout />
                                    </li>
                                </ul>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div className="humberger__open">
                {/* <i className="fa fa-bars"> */}
                <div className="dropdown">
                    <span><i className="fa fa-bars"></i></span>
                        <div className="dropdown-content">
                            <ul className="header__menu__dropdown">
                                <li><Link to="/">Home</Link></li>
                                <li><Link to="/shcart">Shoping Cart</Link></li>
                                <li><Link to="/checkout">Check Out</Link></li>
                                <li>
                                    <Signout />
                                </li>
                            </ul>
                        </div>
                    </div>
                {/* </i> */}
            </div>
        </div>
    </header>
    {/* <!-- Header Section End --> */}

    {/* <!-- Hero Section Begin --> */}
    <section className="hero">
        <div className="container">
            <div className="row">
                <div className="col-lg-3">
                    <div className="hero__categories">
                        <div className="hero__categories__all">
                            <i className="fa fa-bars"></i>
                            <span>All departments</span>
                        </div>
                        <ul>
                            <li><Link to="#">Fresh Meat</Link></li>
                            <li><Link to="#">Vegetables</Link></li>
                            <li><Link to="#">Fruit & Nut Gifts</Link></li>
                            <li><Link to="#">Fresh Berries</Link></li>
                            <li><Link to="#">Ocean Foods</Link></li>
                            <li><Link to="#">Butter & Eggs</Link></li>
                            <li><Link to="#">Fastfood</Link></li>
                            <li><Link to="#">Fresh Onion</Link></li>
                            <li><Link to="#">Papayaya & Crisps</Link></li>
                            <li><Link to="#">Oatmeal</Link></li>
                            <li><Link to="#">Fresh Bananas</Link></li>
                        </ul>
                    </div>
                </div>
                <div className="col-lg-9">
                    <div className="hero__search">
                        <div className="hero__search__form">
                            <form action="#">
                                <div className="hero__search__categories">
                                    All Categories
                                    <span className="arrow_carrot-down"></span>
                                </div>
                                <input type="text" placeholder="What do yo u need?" />
                                <button type="submit" className="site-btn">SEARCH</button>
                            </form>
                        </div>
                        <div className="hero__search__phone">
                            <div className="hero__search__phone__icon">
                                <i className="fa fa-phone"></i>
                            </div>
                            <div className="hero__search__phone__text">
                                <h5>+49 89 2153 743-80</h5>
                                <span>support 24/7 time</span>
                            </div>
                        </div>
                    </div>
                    <div className="hero__item set-bg" data-setbg="img/hero/banner.jpg">
                        <div className="hero__text">
                            <span>FRUIT FRESH</span>
                            <h2>Vegetable <br />100% Organic</h2>
                            <p>Free Pickup and Delivery Available</p>
                            <Link to="#" className="primary-btn">SHOP NOW</Link>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
    {/* <!-- Hero Section End --> */}
    </div>
)

export default Header