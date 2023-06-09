/*! jQuery.browser */
(function(d){var c,b;d.uaMatch=function(a){a=a.toLowerCase();a=/(chrome)[ \/]([\w.]+)/.exec(a)||/(webkit)[ \/]([\w.]+)/.exec(a)||/(opera)(?:.*version|)[ \/]([\w.]+)/.exec(a)||/(msie) ([\w.]+)/.exec(a)||0>a.indexOf("compatible")&&/(mozilla)(?:.*? rv:([\w.]+)|)/.exec(a)||[];return{browser:a[1]||"",version:a[2]||"0"}};c=d.uaMatch(navigator.userAgent);b={};c.browser&&(b[c.browser]=!0,b.version=c.version);b.chrome?b.webkit=!0:b.webkit&&(b.safari=!0);d.browser=b})(jQuery);

/*! Detect mobile */
(function(){jQuery.browser.mobile=/android|blackberry|symbianos|iemobile|ip(ad|od|hone)/i.test(navigator.userAgent)}());

/*! Easing - https://github.com/julianshapiro/velocity - Copyright The jQuery Foundation. MIT License: https://jquery.org/license */
(function(){var d={};$.each(["Quad","Cubic","Quart","Quint","Expo"],function(a,b){d[b]=function(c){return Math.pow(c,a+2)}});$.extend(d,{Sine:function(a){return 1-Math.cos(a*Math.PI/2)},Circ:function(a){return 1-Math.sqrt(1-a*a)},Elastic:function(a){return 0===a||1===a?a:-Math.pow(2,8*(a-1))*Math.sin((80*(a-1)-7.5)*Math.PI/15)},Back:function(a){return a*a*(3*a-2)},Bounce:function(a){for(var b,c=4;a<((b=Math.pow(2,--c))-1)/11;);return 1/Math.pow(4,3-c)-7.5625*Math.pow((3*b-2)/22-a,2)}});$.each(d,function(a,b){$.easing["easeIn"+a]=b;$.easing["easeOut"+a]=function(a){return 1-b(1-a)};$.easing["easeInOut"+a]=function(a){return 0.5>a?b(2*a)/2:1-b(-2*a+2)/2}});$.easing.spring=function(a){return 1-Math.cos(4.5*a*Math.PI)*Math.exp(6*-a)}})();

