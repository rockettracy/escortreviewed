module.exports = function() {
    var express = require('express'),
        app = express(),
        am = require('../modules/accountManager.js');

    app.get('/', function(req, res){
        res.render('signup');
    });

    app.post('/', function(req, res){
        if (am.signup(req, res)) {
            res.redirect('/demo');
        } else {
            res.render('signup');
        }
    });

    return app;
}();

    
