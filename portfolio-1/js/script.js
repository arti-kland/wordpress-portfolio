jQuery(document).ready(function ($) {

    if (document.getElementById("slider-01")) {
        let $myCarousel = $('.carousel');
        //start the carousel
        $myCarousel.carousel({
            interval: 5000
        });
        $myCarousel.on('slide.bs.carousel', function (e) {
            let $animatingElems = $(e.relatedTarget).find("[data-animation ^= 'animated']");
            doAnimation($animatingElems);
        });
        let $firstAnimatedElement = $myCarousel.find(".carousel-item:first").find("[data-animation ^= 'animated']");
        doAnimation($firstAnimatedElement);

        function doAnimation(elems) {
            let animEndEv = 'webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend';
            elems.each(function () {
                let $this = $(this);
                $animationType = $this.data('animation');

                $this.addClass($animationType).one(animEndEv, function () {
                    $this.removeClass($animationType);
                });
            }); // fin du each
        } // doAnimation

    }// fin de document.getElementById

});// fin du ready