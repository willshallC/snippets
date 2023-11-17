// set counter on slick slider
$(document).ready(function(){
    var $sliders = $('.product-slider');
    if ($sliders.length) {
      var currentSlide;
      var slidesCount;
      var slidecounts = $('.product-slider .media-wrapper');
      var sliderCounter = document.createElement('div');
      sliderCounter.classList.add('slider__counters');
      var updateSliderCounter = function(slick, currentIndex) {
        currentSlide = slick.slickCurrentSlide() + 1;
        if (currentSlide == 1){
          slidesCount = slidecounts.length;
        } else{
        slidesCount = slick.slideCount;
        }
        $(sliderCounter).text(currentSlide + '/' + slidesCount);
      };
      $sliders.on('init', function(event, slick) {
        $sliders.append(sliderCounter);
        updateSliderCounter(slick);
      });
      $sliders.on('afterChange', function(event, slick, currentSlide) {
        updateSliderCounter(slick, currentSlide);
      });
      $sliders.slick();
    }
    });