jQuery(document).ready(function( $ ) {

});
/************** ======= // ===== sliders ==== //======= ***************/
/********* big-slider **********/
$('.big-slider').slick({
    autoplay: true,
    autoplaySpeed: 2000,
    speed: 1000,
    prevArrow: '<button type="button" class="arrow-prev"><svg><use xlink:href="images/9back.svg#left"></use></svg></button>',
    nextArrow: '<button type="button" class="arrow-next"><svg><use xlink:href="images/9right.svg#right"></use></svg></button>',
    infinite: true,
    slidesToShow:1,
    rtl:true,
    slidesToScroll: 1,
    centerMode: false,
    dots:false,
    arrows:true,
    centerPadding: '60px',
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 330,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
    ]
});

/********* brand-slider **********/
$('.brand-slider').slick({
    autoplay: true,
    autoplaySpeed: 2000,
    prevArrow: '<button type="button" class="arrow-prev"><svg><use xlink:href="images/9back.svg#left"></use></svg></button>',
    nextArrow: '<button type="button" class="arrow-next"><svg><use xlink:href="images/9right.svg#right"></use></svg></button>',
    infinite: true,
    speed: 300,
    slidesToShow:6,
    rtl:true,
    slidesToScroll: 1,
    dots:false,
    arrows:true,
    centerMode:false,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 1,
                infinite: true,
                dots: false
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 1,
                dots: false
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
                dots: false,
                infinite: false,
            }
        },
        {
            breakpoint: 330,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                dots: false,
                arrows:false,
            }
        },
    ]
});

/********* symbols **********/
$('.symbols').slick({
    infinite: true,
    speed: 300,
    slidesToShow:3,
    rtl:true,
    slidesToScroll: 3,
    dots:true,
    arrows:false,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: true,
                dots: true
            }
        },
        {
            breakpoint: 979,
            settings: {
                slidesToShow: 6,
                slidesToScroll: 3,
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 4,
                slidesToScroll: 4,
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 3,
                slidesToScroll: 3,
                infinite: false,
            }
        },
        {
            breakpoint: 330,
            settings: {
                slidesToShow: 2,
                slidesToScroll: 2,
                arrows:false,
            }
        },
    ]
});

/********* little-slider **********/
$('.little-slider').slick({
    autoplay: true,
    autoplaySpeed: 1000,
    speed: 700,
    infinite: true,
    slidesToShow:1,
    rtl:true,
    slidesToScroll: 1,
    dots:false,
    arrows:false,
    responsive: [
        {
            breakpoint: 1024,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 979,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 768,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 480,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
        {
            breakpoint: 330,
            settings: {
                slidesToShow: 1,
                slidesToScroll: 1,
            }
        },
    ]
});
$('.little-slider').append('<div class="spinner-block"><div class="spinner spinner-1"></div></div>');
$('.little-slider').on('beforeChange', function(event, slick, direction){
    if(direction % 4 === 0 )
    {
        $('.spinner').removeClass('spinner-4');
        $('.spinner').addClass('spinner-1');
    }
    if(direction % 4 === 1 )
    {
        $('.spinner').removeClass('spinner-1');
        $('.spinner').addClass('spinner-2');
    }
    if(direction % 4 === 2 )
    {
        $('.spinner').removeClass('spinner-2');
        $('.spinner').addClass('spinner-3');
    }
    if(direction % 4 === 3 )
    {
        $('.spinner').removeClass('spinner-3');
        $('.spinner').addClass('spinner-4');
    }
});
/********* product image **********/
$('.slider-for').slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    rtl:true,
    asNavFor: '.slider-nav'
});
$('.slider-nav').slick({
    slidesToShow: 5,
    slidesToScroll: 1,
    asNavFor: '.slider-for',
    dots: false,
    rtl:true,
    centerMode: true,
    focusOnSelect: true
});

/************** ======= // ===== Scroll to Top ==== //======= ***************/
$(window).scroll(function() {
    if ($(this).scrollTop() >= 50) {        // If page is scrolled more than 50px
        $('#return-to-top').fadeIn(200);    // Fade in the arrow
    } else {
        $('#return-to-top').fadeOut(200);   // Else fade out the arrow
    }
});
$('#return-to-top').click(function() {      // When arrow is clicked
    $('body,html').animate({
        scrollTop : 0                       // Scroll to top of body
    }, 500);
});

/************** ======= // ===== user ==== //======= ***************/
$(document).ready(function(){
    $(".user").click(function(){
        if($(".user-log").is(":hidden"))
        {
            $(".tringle-down").addClass("tringle-down-inverse");
            $(this).addClass("radius-none");
        }
        else
        {
            $(".tringle-down").removeClass("tringle-down-inverse");
            $(this).removeClass("radius-none");
        }
        $(".user-log").slideToggle();



    });
});
