module.exports = function() {
    var dataLayer = require('./dataLayer.js'),
    conn = dataLayer.conn;

    var doSignup = function(req, res) {
        var post = {
            username: req.body.username,
            password: req.body.password,
            email: req.body.email
        };

        function isError(data) {
            rs = data ? false : true;
        }

        function doQuery(sql, cbf) {
            conn.query(sql, post, function(err, result){
                cbf(err);
            });
        }

        doQuery('insert into iyy_member set ?', function(error) {
            isError(error);
        });

        return rs;
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

