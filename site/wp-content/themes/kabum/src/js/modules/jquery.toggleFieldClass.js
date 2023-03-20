/**
 * Toggle field classes on focus/blur
 */
(function($) {
  $.fn.toggleFieldClass = function(o) {
    return this.each(function() {
      var $this       = $(this);
      var opts        = $.extend({ parentSelector: '.field' }, o);
      var checkFilled = function($input) {
        $input.closest(opts.parentSelector).toggleClass('input-filled', $.trim($input.val()) !== '');
      };

      $this.on('focus.ns', () => {
        $this.closest(opts.parentSelector).addClass('input-filled input-focus');
      });

      $this.on('blur.ns focusout.ns', () => {
        $this.closest(opts.parentSelector).removeClass('input-focus');
        checkFilled($this);
      });

      $this.on('change.ns', () => checkFilled($this));
      checkFilled($this);

      setTimeout(function() {
        if ($this.is(':-webkit-autofill')) {
          $this.closest(opts.parentSelector).addClass('input-filled');
        }
      }, 1);
    });
  };
}(jQuery));
