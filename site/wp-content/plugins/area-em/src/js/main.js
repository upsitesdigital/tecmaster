

(($) => {
  'use strict';

  $(() => {
    jQuery(document).on('click', '.contentSidebar ul li a', function () {
      var $url = location.origin + '/assets/plugins/area-em/includes';
      // var $url = 'http://localhost/projetos/labwp/wp-content/plugins/area-de-membros/includes';
      var $box = jQuery(this).data('box');
      console.log('location.origin3');
      console.log(location.origin);
      jQuery('.contentSidebar ul li').removeClass('act');
      jQuery(this).closest('li').addClass('act');
      if ($box === 'padrao') {
        var $query = jQuery(this).data('query');
        var $name = jQuery(this).html();
        jQuery.ajax({
          url: pluginloadpostajax.ajaxurl,
          type: 'POST',
          data: {
            'action': 'postList',
            'page': 'query.php',
            'query': $query,
            'name': $name
          }
        }).done(function (data) {
          jQuery('#contentBodyLoad').html(data);
        });
      }
      if ($box === 'init') {
        jQuery.ajax({
          url: pluginloadpostajax.ajaxurl,
          type: 'POST',
          data: {
            'action': 'init',
            'page': 'init.php',
            'query': '',
            'name': ''
          }
        }).done(function (data) {
          jQuery('#contentBodyLoad').html(data);
        });
      }
      if ($box === 'profile') {
        jQuery.ajax({
          url: pluginloadpostajax.ajaxurl,
          type: 'POST',
          data: {
            'action': 'pageList',
            'page': 'profile.php',
            'query': '',
            'name': ''
          }
          dataType: 'html',
          success: function (data) {
            console.log('success');
            console.log(data);
            jQuery('#contentBodyLoad').html(data);
          }
        }).done(function (data) {
          console.log('done');
          console.log(data);
          jQuery('#contentBodyLoad').html(data);
        });
      }
      return false;
    });
  });
})(jQuery);