module.exports = function() {
    var express = require('express'),
        app = express();

    app.get('/', function(req, res){
        res.render('demo');
    });

    return app;
}();
