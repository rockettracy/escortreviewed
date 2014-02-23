module.exports = function() {
    var isDaytime = function() {
        var time = new Date();
        var hour = time.getHours();

        if(hour > 9 && hour < 23) return true;
        return false;
    };

    var randomUsers = function(isTotal) {
        isTotal = (typeof isTotal == 'undefined') ? false : true;

        if (isTotal) {
            return Math.floor(Math.random() * 2000000) + Math.floor(new Date().getTime() / 360000);
        } else {
            factor = isDaytime() ? 2000 : 400; 
            return Math.floor(Math.random() * factor) + 1;
        }
    };

    return {
        currentUser: randomUsers(),
        totalUser: randomUsers(true)
    };
}();
