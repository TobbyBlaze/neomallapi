import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch } from 'react-router-dom';

// import Header from './Header';
import Home from './Home';
import ShCart from './ShCart';
import PrDetails from './PrDetails';
import Checkout from './Checkout';
import Login from './Login';
import Signup from './Signup';
// import Footer from './Footer';
// import Error from './Error';
import Thanks from './Thanks';
import Admine from './Admine';

export default class App extends Component {
    render() {
        return (
            <BrowserRouter>
                <div>
                    {/* <Header /> */}
                    <Switch>
                        {/* <Route exact path='/yummypizza/public/' component={Home} />
                        <Route exact path='/yummypizza/public/prdetails/:id' component={PrDetails} />
                        <Route exact path='/yummypizza/public/prdetails' component={PrDetails} />
                        <Route exact path='/yummypizza/public/shcart' component={ShCart} />
                        <Route exact path='/yummypizza/public/checkout' component={Checkout} />
                        <Route exact path='/yummypizza/public/login' component={Login} />
                        <Route exact path='/yummypizza/public/signup' component={Signup} />
                        <Route exact path='/yummypizza/public/thanks' component={Thanks} /> */}
                        {/* <Route component={Error} /> */}

                        <Route exact path='/' component={Home} />
                        <Route exact path='/prdetails/:id' component={PrDetails} />
                        <Route exact path='/prdetails' component={PrDetails} />
                        <Route exact path='/shcart' component={ShCart} />
                        <Route exact path='/checkout' component={Checkout} />
                        <Route exact path='/login' component={Login} />
                        <Route exact path='/signup' component={Signup} />
                        <Route exact path='/thanks' component={Thanks} />
                        <Route exact path='/admine' component={Admine} />
                    </Switch>
                    {/* <Footer /> */}
                </div>
            </BrowserRouter>
        );
    }
}

if (document.getElementById('app')) {
    ReactDOM.render(<App />, document.getElementById('app'));
}