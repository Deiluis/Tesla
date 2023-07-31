$('.main-header .header-menu a').on('click', function (e) {
    e.preventDefault();
    $(this).addClass('is-active');
    $(this).siblings().removeClass('is-active');
    target = $(this).attr('href');

    $('.main-container > div + div').not(target).hide();

    $(target).fadeIn(600);

});
document.querySelectorAll(".dropdown").forEach((dropdown) => {
    dropdown.addEventListener("click", (e) => {
        e.stopPropagation();
        document.querySelectorAll(".dropdown").forEach((c) => c.classList.remove("is-active"));
        dropdown.classList.add("is-active");
    });
});
document.querySelector(".dropdown-notify").addEventListener("click", (e) => {
    e.stopPropagation();
    document.querySelector(".dropdown-notify").classList.toggle("is-active");
});
$(document).click(function (e) {
    const container = $(".status-button");
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $(".dropdown").removeClass("is-active");
    }
    if (!container.is(e.target) && container.has(e.target).length === 0) {
        $(".dropdown-notify").removeClass("is-active");
    }
});

$(function () {
    $(".dropdown").on("click", function (e) {
        $(".content-wrapper").addClass("overlay");
        e.stopPropagation();
    });
    $(document).on("click", function (e) {
        if ($(e.target).is(".dropdown") === false) {
            $(".content-wrapper").removeClass("overlay");
        }
    });
});
document.querySelector('.dark-light').addEventListener('click', () => {
    document.body.classList.toggle('light-mode');
});