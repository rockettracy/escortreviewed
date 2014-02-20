module.exports = function() {
    var express = require('express'),
        app = express();

    app.get('/', function(req, res){
        res.writeHead(200, {"content-type" : "text/plain"});  
        res.end('url: /');
    });

    return app;
}();
