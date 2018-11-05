$(function () {
    function detectmob() {
        return ( navigator.userAgent.match(/Android/i)
            || navigator.userAgent.match(/webOS/i)
            || navigator.userAgent.match(/iPhone/i)
            || navigator.userAgent.match(/iPad/i)
            || navigator.userAgent.match(/iPod/i)
            || navigator.userAgent.match(/BlackBerry/i)
            || navigator.userAgent.match(/Windows Phone/i)
        );
    }
    let grid = $(".grid").masonry('layout',{columnWidth: 400, shuffle: true});
    $(".grid-item").click(function (e) {
        let img = $(this)[0].firstElementChild;
        if (!img.classList.contains('gigante')) {
            img.classList.add('gigante');
        } else {
            img.classList.remove('gigante');
        }
        grid.masonry('layout');
    });
});