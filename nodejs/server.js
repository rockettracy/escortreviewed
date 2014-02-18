var app = require('express')(),
  swig = require('swig'),
  express = require('express'),
  iniParser = require('iniparser');

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

siteConfig = iniParser.parseSync(__dirname + '/config/site.ini');

items = [];
for (item in siteConfig.items) {
    obj = {};
    obj.id = item;
    obj.name = siteConfig.items[item]; 
    obj.urls = [];

    for (key in siteConfig[item]) {
        tmp = siteConfig[item][key].split(',');
        _obj = {};
        _obj.name = tmp[0];
        _obj.url = tmp[1];
        obj.urls.push(_obj);
    }

    items.push(obj);
}

function isDaytime() {
    var time = new Date();
    var hour = time.getHours();

    if(hour > 9 && hour < 23) return true;
    return false;
}

function getUsers(isTotal) {
    isTotal = (typeof isTotal == 'undefined') ? false : true;

    if (isTotal) {
        return Math.floor(Math.random() * 2000000) + Math.floor(new Date().getTime() / 360000);
    } else {
        factor = isDaytime() ? 2000 : 400; 
        return Math.floor(Math.random() * factor) + 1;
    }
}

currentUser = getUsers();
totalUser = getUsers(true); 

app.get('/', function (req, res) {
  res.render('index', { items: items, currentUser: currentUser, totalUser: totalUser });
});

app.listen(3000);
console.log('Application Started on http://localhost:3000/');
