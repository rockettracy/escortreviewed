module.exports = function() {
    var mysql = require('mysql');
    var connection = mysql.createConnection({
        host: 'localhost',
        user: 'kelin.liu',
        password: '',
        database: 'test'
    });

    //conn.query('select * from tags', function(err, rows) {
//console.log(rows); });

    return {
        conn: connection 
    }
}();
