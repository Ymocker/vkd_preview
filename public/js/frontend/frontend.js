$(document).ready(function() {
//    var rand = Math.floor(Math.random() * (20 - 1) + 1);
//    var backpath = "url(/siteimg/background" + rand + ".jpg)";
//    $("#scrollPic").css({'background-image' : backpath});

    if (($(document).width() > 749)) {
        moveBgAround();
    }

    $(window).scroll(function(){
        if ($(this).scrollTop() > 100) {
            $('.scrollup').fadeIn();
        } else {
            $('.scrollup').fadeOut();
        }
    });

    $('.scrollup').click(function(){
        $("html, body").animate({ scrollTop: 0 }, 600);
        return false;
    });
        //location.hash = "top";
    //$('body').scrollTo('#top')
//    var scrollTop = $('#top').scrollTop();
//    alert(scrollTop);
//    $(document).scrollTop(scrollTop);
//window.scrollTo(0, 500);
});

$(window).load(windowSize);
$(window).resize(windowSize);

function windowSize() {
    //    var doc_w = $(document).width();
    //    var doc_h = doc_w / 1.95 - 30;
//    var doc_h = screen.height-60;
//    var doc_h = document.body.clientHeight;

    //$("#scrollPic").css({'height' : doc_h});

//    if (($(document).width() < 768) || ($("#scrollPic").height() < 340)) {
//        //$("#advantage").css({'margin-top' : -20});
//    } else {
//        //$("#advantage").css({'margin-top' : -60});
//    }

    if ($("#scrollPic").width() > 2400) {
        //$("#logo").css({'display' : 'none'});
        $("#advantage").css({'font-size' : '40px'});
    } else {
        //$("#logo").slideDown();
        $("#advantage").css({'font-size' : '20px'});
    }

  //$( "#width" ).text( $( window ).width() );
  //$( "#height" ).text( $( window ).height() );
}

function moveBgAround() {
    //задайте произвольное значение от 0 до 400 для оси X и Y
    //var x = Math.floor(Math.random()*401);
    //var y = Math.floor(Math.random()*401);
    //var time = Math.floor(Math.random()*50000);
    var time = 50000;

/*	$("#scrollPic").animate({
                backgroundPosition: '(' + (x * -1) + 'px ' + (y * -1) + 'px)'
        }, 1, "swing", function() {
                moveBgAround();
        });
*/
    $("#scrollPic").animate({
        //backgroundPosition: '+=100px',
        backgroundSize: '200%'
        }, time, "linear", function() {
            $("#scrollPic").animate({
                    //backgroundPosition: '+=100px',
                    backgroundSize: '100%'
                }, time, "linear", function() {

            });

        //$(this).css({'backgroundSize' : '100%'});
        moveBgAround();
    });

}

