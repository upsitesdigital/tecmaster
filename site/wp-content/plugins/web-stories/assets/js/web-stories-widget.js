!function(e){var t={};function __webpack_require__(r){if(t[r])return t[r].exports;var n=t[r]={i:r,l:!1,exports:{}};return e[r].call(n.exports,n,n.exports,__webpack_require__),n.l=!0,n.exports}__webpack_require__.m=e,__webpack_require__.c=t,__webpack_require__.d=function(e,t,r){__webpack_require__.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},__webpack_require__.r=function(e){"undefined"!=typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},__webpack_require__.t=function(e,t){if(1&t&&(e=__webpack_require__(e)),8&t)return e;if(4&t&&"object"==typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(__webpack_require__.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var n in e)__webpack_require__.d(r,n,function(t){return e[t]}.bind(null,n));return r},__webpack_require__.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return __webpack_require__.d(t,"a",t),t},__webpack_require__.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},__webpack_require__.p="",__webpack_require__(__webpack_require__.s=1)}([function(e,t){e.exports=window.wp.domReady},function(e,t,r){"use strict";r.r(t);var n=r(0),_=r.n(n);const o=window.webStoriesData||{},i=function(e){let t=arguments.length>1&&void 0!==arguments[1]&&arguments[1];const r=e.value,n=e.closest(".widget"),_=o.fields[r];for(const[e,r]of Object.entries(_)){const _=n.querySelector(`.${e}.stories-widget-field`),o=n.querySelector(`.${e}_wrapper`);if(_&&o){"checkbox"===_.getAttribute("type")?(t&&(_.checked=!1),r.hidden&&(_.checked=r.show),o.style.display=r.hidden?"none":"block"):o.style.display=r.show?"block":"none"}}},c=()=>document.getElementsByClassName("view_type stories-widget-field"),u=function(){const e=c();if(e.length)for(let t=0;t<e.length;t++)e[t].addEventListener("change",(e=>{i(e.target,!1)}))};_()((()=>{u(),function(){const e=c(),t=document.createEvent("HTMLEvents");t.initEvent("change",!1,!0);for(let r=0;r<e.length;r++)e[r].dispatchEvent(t)}()}));const a=(e,t)=>{if(!t[0])return;const r=t[0].querySelectorAll(".stories-widget-field.view_type");r.length&&(i(r[0],!1),u())},d=window.jQuery;d(document).on("widget-updated",a),d(document).on("widget-added",a)}]);