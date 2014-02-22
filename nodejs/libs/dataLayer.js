module.exports = function() {
    var dataParsing = function() {
        var iniParser = require('iniparser'),
            mysql = require('mysql');
        
        var conn = mysql.createConnection({
            host: 'localhost',
            user: 'kelin.liu',
            password: '',
            database: 'test'
        });

        conn.query('select * from tags', function(err, rows) {
console.log(rows); });

        siteConfig = iniParser.parseSync(__dirname + '/../config/site.ini');

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

        return items;
    };

    return {
        getUrls: dataParsing 
    }
}();
