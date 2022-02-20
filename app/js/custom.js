jQuery(document).ready(function ($) {
    $mainBannerSlider = $(".mainBanner-carousel");

    $(window).click(function () {
        $("#category-navigation").removeClass("open");
        $("#categoryTab li a").removeClass("active");
    });

    $("#category-navigation").click(function (e) {
        e.stopPropagation();
        $(this).addClass("open");
    });

    $(".close-category-item").click(function (e) {
        e.stopPropagation();
        $("#category-navigation").removeClass("open");
    });

    $(window).scroll(function () {
        // const headerHeight = $("#main-header-navigation").offset().top;
        if ($(this).scrollTop() >= 390) {
            $("#main-header-navigation").addClass("sticky");
        } else {
            $("#main-header-navigation").removeClass("sticky");
        }
    });

    //Mobile Header Navigation
    $(".open-mobile-nav").click(function () {
        $("body").addClass("mobile-nav-expand");
    });

    $(".close-mobile-nav").click(function () {
        $("body").removeClass("mobile-nav-expand");
    });

    // Main Banner Slider
    $mainBannerSlider.owlCarousel({
        loop: true,
        dots: false,
        nav: false,
        autoplay: true,
        autoplaySpeed: 1000,
        animateOut: "fadeOut",
        smartSpeed: 1000,
        mouseDrag: false,
        responsive: {
            0: {
                items: 1,
            },
        },
    });
});
