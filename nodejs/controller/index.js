module.exports = function() {
    var express = require('express'),
        app = express();


    app.get('/', function(req, res){
        var datalayer = require('./../libs/dataLayer.js');
        var urls = datalayer.getUrls(); 
        var utils = require('./../libs/Utils.js');
        var currentU = utils.currentUser;
        var totalU = utils.totalUser;

        res.render('index', { items: urls, currentUser: currentU, totalUser: totalU });
    });

    return app;
}();
