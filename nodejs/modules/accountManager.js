module.exports = function() {
    var dataLayer = require('./dataLayer.js'),
    conn = dataLayer.conn;

    var doSignup = function(req, res) {
        var post = {
            username: req.body.username,
            password: req.body.password,
            email: req.body.email
        };

        conn.query('insert into iyy_member set ?', post, function(err, result){
            if (err) throw err;
        });

        return true;
    };

    var doLogin = function(req, res) {
        var post = {
            username: req.body.username,
            password: req.body.password
        };

        conn.query('select * from iyy_member where ?', post, function(err, result){
            if (err) throw err;
        });

        return true;
    };

    return {
        signup: doSignup,
        login: doLogin
    };
}();

