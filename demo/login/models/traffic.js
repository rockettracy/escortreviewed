function Traffic(data) {
    this.data = data;
    this.logined = function() {
        return this.data.user == 'undefined';
    }
}

module.exports = Traffic;
