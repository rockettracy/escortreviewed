module.exports = function() {
    var express = require('express'),
        app = express(),
        am = require('../modules/accountManager.js');

    app.get('/', function(req, res){
        res.render('login');
    });

    app.post('/', function(req, res){
        if (am.login(req, res)) {
            res.redirect('/demo');
        } else {
            res.render('login');
        }
    });

    return app;
}();

    
