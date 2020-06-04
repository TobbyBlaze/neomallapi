import React, { Component } from 'react';
import ReactDOM from 'react-dom';
import { BrowserRouter, Route, Switch } from 'react-router-dom';

import HeaderHome from './HeaderHome';
// import Country from './Country';
import Home from './Home';
import PrDetails from './PrDetails';
// import Signin from './Signin';
// import Signup from './Signup';
import Footer from './Footer';

export default class AppHome extends Component {
    render() {
        return (
            <BrowserRouter>
                <div>
                    {/* <HeaderHome /> */}
                    <Switch>
                        <Route exact path='/yummypizza/public/' component={Home} />
                        <Route exact path='/yummypizza/public/prdetails/:id' component={PrDetails} />
                        {/* <Route exact path='/yummypizza/public/signin' component={Signin} /> */}
                        {/* <Route exact path='/yummypizza/public/signup' component={Signup} /> */}
                        {/* <Route exact path='/yummypizza/public/checkout' component={Checkout} /> */}
                    </Switch>
                    {/* <Footer /> */}
                </div>
            </BrowserRouter>
        );
    }
}

if (document.getElementById('apphome')) {
    ReactDOM.render(<AppHome />, document.getElementById('apphome'));
}