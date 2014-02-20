module.exports = function() {
    var iniParser = require('iniparser');

    var routeConfig = iniParser.parseSync(__dirname + '/config/routing.ini');

    var parsing = function() {
        var _rules = [];

        for (url in routeConfig.routing) {
            var _obj = {};
            _obj.url = "/" + url;
            _obj.controller = "./controller/" + url + ".js";
            _rules.push(_obj);
        };

        return _rules;
    };

    return {
        Rules: parsing
    };
}();
