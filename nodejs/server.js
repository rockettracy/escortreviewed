var app = require('express')(),
  swig = require('swig'),
  express = require('express');

// This is where all the magic happens!
app.engine('html', swig.renderFile);

app.set('view engine', 'html');
app.set('views', __dirname + '/views');

app.use(express.static(__dirname + '/static/v1'));

// Swig will cache templates for you, but you can disable
// that and use Express's caching instead, if you like:
app.set('view cache', true);
// To disable Swig's cache, do the following:
swig.setDefaults({ cache: false });
// NOTE: You should always cache templates in a production environment.
// Don't leave both of these to `false` in production!

app.get('/', function (req, res) {
    var datalayer = require('./libs/dataLayer.js');
    var urls = datalayer.getUrls(); 
    var utils = require('./libs/Utils.js');
    var currentU = utils.currentUser;
    var totalU = utils.totalUser;

    res.render('index', { items: urls, currentUser: currentU, totalUser: totalU });
});

//add routing
var routing = require('./routing.js');
var rules = routing.Rules();
for (i in rules) {
    app.use(rules[i].url, require(rules[i].controller));
}

app.listen(3000);
console.log('Application Started on http://localhost:3000/');
