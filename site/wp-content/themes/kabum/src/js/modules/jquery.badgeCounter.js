/**
 * Badge Counter
 */
(function($) {
  $.fn.badgeCounter = function() {
    return this.each(function() {
      var id = $(this).attr('id');
      var $badge = $(`a[href="#${id}"]`).siblings('.badge');
      var $container = $(this);
      var $inputs = $container.find('input:checkbox');

      var updateBadgeCount = function() {
        var l = $inputs.filter(':checked').length;
        $badge.toggleClass('hidden', l === 0).text(l < 99 ? l : '99+');
      };

      updateBadgeCount();
      $container.off('.bc').on('change.bc', 'input:checkbox', updateBadgeCount);
    });
  };
}(jQuery));
