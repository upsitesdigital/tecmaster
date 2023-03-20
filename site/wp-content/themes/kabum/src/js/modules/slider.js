/**
 * Slider
 */
export default function() {
  const $fullslider = $('.slide-full');
  $fullslider.slick({
    slidesToShow: 1,
    slidesToScroll: 1,
    dots: false,
    arrows: true,
    nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
    prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
    centerMode: false,
    focusOnSelect: true,
    adaptiveHeight: true,
    centerPadding: 0
  });

  const $categoryslider = $('.slide-category');
  $categoryslider.slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
    prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
    centerMode: false,
    focusOnSelect: true,
    adaptiveHeight: true,
    centerPadding: 0,
    responsive: [{
      breakpoint: 769,
      settings: {
        slidesToShow: 1,
        dots: true,
        arrows: true,
      }
    }]
  });

  const $authorslider = $('.slide-author');
  $authorslider.slick({
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    arrows: false,
    nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
    prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
    centerMode: false,
    focusOnSelect: true,
    adaptiveHeight: true,
    centerPadding: 0,
    responsive: [{
      breakpoint: 769,
      settings: {
        slidesToShow: 1,
        dots: true,
        arrows: true,
      }
    }]
  });

  const $slideMobile = $('.slideMobile');
  slideMobile();
  jQuery(window).on('resize', function() {
    slideMobile();
  });

  const $slideVideofull = $('.slider-for');
  $slideVideofull.slick({
    lazyLoad: 'ondemand',
    slidesToShow: 1,
    slidesToScroll: 1,
    arrows: false,
    fade: true,
    adaptiveHeight: true,
    asNavFor: '.slide-video'
  });

  const $slideVideo = $('.slide-video');
  $slideVideo.slick({
    lazyLoad: 'ondemand',
    slidesToShow: 3,
    slidesToScroll: 1,
    dots: false,
    arrows: true,
    nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
    prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
    centerMode: false,
    focusOnSelect: true,
    adaptiveHeight: true,
    centerPadding: 0,
    asNavFor: '.slider-for',
    responsive: [{
      breakpoint: 769,
      settings: {
        slidesToShow: 1,
        dots: true,
      }
    }]
  });
  $slideVideo.on('beforeChange', function() {
    jQuery('iframe').each(function() {
      this.contentWindow.postMessage('{"event":"command","func":"pauseVideo","args":""}', '*');
    });
  });

  if (jQuery('.slick-slider-postimg').length > 0) {
    jQuery('.slick-slider-postimg').each(function() {
      const $slidePostimg = $('#' + jQuery(this).attr('id') + ' .featured-postimg');
      $slidePostimg.slick({
        slidesToShow: 1,
        slidesToScroll: 1,
        arrows: true,
        nextArrow: '<a href="#" class="slick-next slick-arrow" aria-label="Next" type="button"><i class="fa fa-angle-right" aria-hidden="true"></i></a>',
        prevArrow: '<a href="#" class="slick-prev slick-arrow" aria-label="Previous" type="button"><i class="fa fa-angle-left" aria-hidden="true"></i></a>',
        fade: true,
        asNavFor: '#' + jQuery(this).attr('id') + ' .list-postimg'
      });

      const $slidePostimglist = $('#' + jQuery(this).attr('id') + ' .list-postimg');
      $slidePostimglist.slick({
        slidesToShow: 6,
        slidesToScroll: 1,
        dots: false,
        arrows: true,
        nextArrow: '<a href="#" class="slick-next slick-arrow" aria-label="Next" type="button"><i class="fa fa-angle-right" aria-hidden="true"></i></a>',
        prevArrow: '<a href="#" class="slick-prev slick-arrow" aria-label="Previous" type="button"><i class="fa fa-angle-left" aria-hidden="true"></i></a>',
        centerMode: false,
        focusOnSelect: true,
        adaptiveHeight: true,
        centerPadding: 0,
        asNavFor: '#' + jQuery(this).attr('id') + ' .featured-postimg',
      });
    });
  }

  function slideMobile() {
    if (jQuery(window).width() >= 769) {
      if ($slideMobile.hasClass('slick-initialized')) {
        jQuery('.slideMobile').slick('unslick');
      }
    } else {
      if (!$slideMobile.hasClass('slick-initialized')) {
        $slideMobile.slick({
          infinite: false,
          slidesToShow: 2,
          slidesToScroll: 1,
          dots: true,
          arrows: false,
          nextArrow: '<button class="slick-next slick-arrow" aria-label="Next" type="button"><i class="fa fa-angle-right" aria-hidden="true"></i></button>',
          prevArrow: '<button class="slick-prev slick-arrow" aria-label="Previous" type="button"><i class="fa fa-angle-left" aria-hidden="true"></i></button>',
          centerMode: false,
          focusOnSelect: true,
          adaptiveHeight: true,
          centerPadding: 10
        });
      }
    }
  }

}