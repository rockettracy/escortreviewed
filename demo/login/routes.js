var passport = require('passport'),
    Traffic = require('./models/traffic'),
    Account = require('./models/account');

module.exports = function (app) {
    
    app.get('/', function (req, res) {
        res.render('index', { user : req.user });
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
        res.render('traffic', { user : req.user });
    });

    app.post('/traffic', function(req, res) {
        var obj = new Traffic({user: req.user, start_addr: req.body.start_addr, end_addr: req.body.end_addr});
        if (!obj.logined()) res.redirect('/register');
        else {
          res.redirect('/');
        }
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
        res.render('contactus', { user : req.user });
    });
};
