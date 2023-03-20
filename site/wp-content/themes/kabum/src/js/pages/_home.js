/**
 * Home
 */
export default function() {
  $(document).on('click', '.anchor', function() {
    var $target = $(this).attr('href');
    var $offset = $($target).position().top;
    $('body,html').animate({ scrollTop: $offset }, 1000);
    return false;
  });
  $(document).on('click', '#close-search,.openSearch > .after', function() {
    $('body').removeClass('openSearch');
    return false;
  });
  $(document).on('click', '#open-search', function() {
    $('body').addClass('openSearch');
    $('.search-field').focus();
    return false;
  });
  $(document).on('click', '#megaMenu', function() {
    $('body').toggleClass('openMegaMenu');
    return false;
  });
  $(document).on('click', '.openMegaMenu > .after', function() {
    $('body').removeClass('openMegaMenu');
    return false;
  });
  $(document).on('click', '#open-menu', function() {
    $('body').toggleClass('menu-open');
    $(this).toggleClass('opened').attr('aria-expanded', 'true');
    return false;
  });
  $(document).on('click', '#kabumTV .videoFeatured .video .link', function() {
    var vid = $(this).data('video');
    $(this).closest('.video').html('<iframe id="video' + vid + '" width="100%" height="100%" src="https://www.youtube.com/embed/' + vid + '?enablejsapi=1&html5=1&wmode=opaque&autohide=1&autoplay=1&volume=0&vol=0&mute=1" frameborder="0" allowfullscreen></iframe>');
    return false;
  });
  $(document).on('click', '.pag a', function() {
    var $url = $(this).attr('href');
    //var domain = $url.split('/');
    //var arraySemVazios = domain.filter(function(i) { return i; });
    //var $i = isNaN(arraySemVazios[arraySemVazios.length - 1]) ? '1' : arraySemVazios[arraySemVazios.length - 1];
    //var $newsurl = '/page/' + $i;

    console.log('$url');
    console.log($url);

    if ($url != '#' && $url != '') {
      $('body').addClass('loading');
      $.ajax({
        url: $url,
        dataType: 'html',
        success: function(data) {
          $('#getCont').html($(data).find('#getCont').html());
          $('.pag').html($(data).find('.pag').html());
          window.history.pushState("", "", $url);
          $('body').removeClass('loading');
        }
      });
    }
    return false;
  });
  if ($(window).scrollTop() >= 20) {
    $('body').addClass('rolling');
  } else {
    $('body').removeClass('rolling');
  }
  $(window).on('scroll', function() {
    if ($(this).scrollTop() >= 20) {
      $('body').addClass('rolling');
    } else {
      $('body').removeClass('rolling');
    }
  });

  if (jQuery('#postCont iframe').not('#postCont .banner iframe').length > 0) {
    jQuery('#postCont iframe').not('#postCont .banner iframe').each(function(index) {
      if (!jQuery(this).hasClass('instagram-media')) {
        var $Kawarimi = '<div class="boxVideoPlayer boxVideoPlayer-' + index + '"></div>';
        var $kageboushi = jQuery(this).clone(true);
        jQuery(this).replaceWith($Kawarimi);
        $kageboushi.appendTo('.boxVideoPlayer-' + index);
      }
    });
  }

  if (jQuery('body').is('[data-autoload="true"]')) {
    const time = jQuery('body').attr('data-autoloadtime') ? jQuery('body').attr('data-autoloadtime') + 'E3' : '300E3';
    setTimeout(function() {
      location.reload();
    }, time);
  }


  console.log('The function5');
  $(document).on('click', '.webStories a.item', function() {
    console.log('The function is hooked up5');
    console.log($(this).data('idpost'));

    $.ajax({
      type: 'POST',
      dataType: 'json',
      url: usAjax.ajaxurl,
      data: {
        action: 'web_set_post_views',
        postID: $(this).data('idpost'),
        nonce: $(this).data('nonce')
      },
      success: function(output) {
        console.log(output);
      }
    });
  });
}