$(function () {
    let slider = $("#jssor_1");
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
    if (detectmob()) {
        slider.height((16/9)*window.innerHeight);
    } else {
        slider.height(window.innerHeight);
    }
    $(window).scroll(function (e) {
        let scroll = $(window).scrollTop();
        if (scroll >= 700) {
            $("header").addClass('scrolled');
        } else {
            $("header").removeClass('scrolled');
        }
    });

    let timers = $(".next__match__timer");
    timers.map(function (key, timer) {
        let targetDate = timer.dataset.timer;
        let timerID = timer.dataset.id;
        let formattedTargetDate = new Date(targetDate);

        let interval = setInterval(function () {
            let now = new Date();
            let distance = formattedTargetDate - now;
            let days = Math.floor(distance / (1000 * 60 * 60 * 24));
            let hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
            let minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
            let seconds = Math.floor((distance % (1000 * 60)) / 1000);
            $(".timer__days__"+timerID).text(days);
            $(".timer__hours__"+timerID).text(hours);
            $(".timer__minutes__"+timerID).text(minutes);
            $(".timer__seconds__"+timerID).text(seconds);
            if (distance < 0) {
                clearInterval(interval);
                $(".next__match__timer").html("<div class='expired'><p>Décompte terminé.</p></div>");
            }
        }, 1000);
    });

});