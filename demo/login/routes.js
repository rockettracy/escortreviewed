var passport = require('passport'),
    geoip = require('geoip-lite'),
    Traffic = require('./models/traffic'),
    Account = require('./models/account');

module.exports = function (app) {
    
    app.get('/', function (req, res) {
        var ip = "207.97.227.239";
        var geo = geoip.lookup(ip);
        console.log(req.connection.remoteAddress);
        console.log(geo);
        res.render('index', { user : req.user });
    });

    app.get('/noaccess', function (req, res) {
        res.render('noaccess', {});
    });

    app.get('/services', function (req, res) {
        res.render('services', { user : req.user });
    });

    app.get('/register', function(req, res) {
        res.render('register', { });
    });

    app.post('/register', function(req, res) {
        Account.register(new Account({ username : req.body.username, password: req.body.password, email: req.body.email }), req.body.password, function(err, account) {
            if (err) {
                return res.render('register', { account : account });
            }

            passport.authenticate('local')(req, res, function () {
                res.redirect('/services');
            });
        });
    });

    app.get('/traffic', function(req, res) {
        console.log(req.user);
        if (typeof req.user == 'undefined') res.redirect('/noaccess');
        res.render('traffic', {});
    });

    app.post('/traffic', function(req, res) {
        if (typeof req.user == 'undefined') res.redirect('/noaccess');
        var obj = new Traffic({user: req.user, start_addr: req.body.start_addr, end_addr: req.body.end_addr});
        res.redirect('/');
    });

    app.get('/login', function(req, res) {
        res.render('login', { user : req.user });
    });

    app.post('/login', passport.authenticate('local'), function(req, res) {
        res.redirect('/');
    });

    app.get('/logout', function(req, res) {
        req.logout();
        res.render('logout', {});
    });

    app.get('/contactus', function(req, res) {
        res.render('contactus', {});
    });
};
