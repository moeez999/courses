$(document).ready(function(){
    // Scroll
    $(window).scroll(function(){ 
        if ($(this).scrollTop() > 100) { 
            $('#scroll').fadeIn(); 
        } else { 
            $('#scroll').fadeOut(); 
        } 
    }); 
    $('#scroll').click(function(){ 
        $("html, body").animate({ scrollTop: 0 }, 600); 
        return false; 
    });

    // Carousel
    var owl = $("#owl-demo3");
      owl.owlCarousel({
          itemsCustom : [
            [0, 1],
            [450, 2],
            [600, 2],
            [700, 3],
            [1000, 4],
            [1200, 4],
            [1400, 4],
            [1600, 4]
          ],
          navigation : true
      });

      var owl = $("#owl-demo2");
      owl.owlCarousel({
          itemsCustom : [
            [0, 1],
            [450, 2],
            [600, 2],
            [700, 3],
            [1000, 4],
            [1200, 4],
            [1400, 4],
            [1600, 4]
          ],
          navigation : true
      });
});