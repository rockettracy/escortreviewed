$(document).ready(function() {
    function postRotation() {
        var el = '<div class="posts">';
        var posts = [];
        $('.left-content .post').each(function() {
            posts.push('<div class="post">' + $(this).text() + '</div>');
        });
        firstPost = posts.shift();
        posts.push(firstPost);
        el += posts.join('') + '</div>';
        $('.posts').remove();
        $('.left-content').append(el);
    }

    setInterval(postRotation, 2000);
});
