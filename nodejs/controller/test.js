module.exports = function() {
    var express = require('express'),
        app = express();

    app.get('/:name', function(req, res){
        res.writeHead(200, {"content-type" : "text/plain"});  
        res.end('url: /test/' + req.params.name);
    });

    return app;
}();
