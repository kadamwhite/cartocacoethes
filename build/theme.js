!function(e){var t={};function n(r){if(t[r])return t[r].exports;var o=t[r]={i:r,l:!1,exports:{}};return e[r].call(o.exports,o,o.exports,n),o.l=!0,o.exports}n.m=e,n.c=t,n.d=function(e,t,r){n.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:r})},n.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},n.t=function(e,t){if(1&t&&(e=n(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var r=Object.create(null);if(n.r(r),Object.defineProperty(r,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)n.d(r,o,function(t){return e[t]}.bind(null,o));return r},n.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return n.d(t,"a",t),t},n.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},n.p="",n(n.s=27)}({27:function(e,t,n){n(28),n(29),n(30),e.exports=n(31)},28:function(e,t,n){"use strict";n.r(t)},29:function(e,t){var n=document.querySelector("[data-comments-toggle]");n&&n.addEventListener("click",(function(){var e=document.getElementById("comments");e&&e.classList.toggle("screen-reader-text")}))},30:function(e,t){var n=document.querySelector(".main-navigation"),r=9;function o(e,t){var n=e.querySelector(".dropdown-toggle"),r=e.querySelector("ul"),a=e.classList.contains("toggled-on");void 0!==t&&"boolean"==typeof t&&(a=!t),n.setAttribute("aria-expanded",(!a).toString()),a?(e.classList.remove("toggled-on"),r.classList.remove("toggle-show"),n.setAttribute("aria-label",ehgScreenReaderText.expand),e.querySelectorAll(".toggled-on").forEach((function(e){o(e,!1)}))):(e.parentNode.querySelectorAll("li.toggled-on").forEach((function(e){o(e,!1)})),e.classList.add("toggled-on"),r.classList.add("toggle-show"),n.setAttribute("aria-label",ehgScreenReaderText.collapse))}n&&(function(){var e=n.querySelectorAll(".menu ul");if(!e.length)return;var t=function(){var e=document.createElement("button");return e.classList.add("dropdown-toggle"),e.setAttribute("aria-expanded","false"),e.setAttribute("aria-label",ehgScreenReaderText.expand),e}();e.forEach((function(e){var n=e.parentNode,a=n.querySelector(".dropdown");if(!a){(a=document.createElement("span")).classList.add("dropdown");var i=document.createElement("i");i.classList.add("dropdown-symbol"),a.appendChild(i),e.parentNode.insertBefore(a,e)}var l=t.cloneNode(!0);l.innerHTML=a.innerHTML,a.parentNode.replaceChild(l,a),l.addEventListener("click",(function(e){o(this.parentNode)})),n.addEventListener("mouseleave",(function(e){o(this,!1)})),n.querySelector("a").addEventListener("focus",(function(e){this.parentNode.parentNode.querySelectorAll("li.toggled-on").forEach((function(e){o(e,!1)}))})),e.addEventListener("keydown",(function(e){var t="ul.toggle-show > li > a, ul.toggle-show > li > button";r===e.keyCode&&(e.shiftKey?function(e,t,n){var r=e.querySelectorAll(n);if(r.length>0)return t===r[0];return!1}(this,document.activeElement,t)&&o(this.parentNode,!1):function(e,t,n){var r=e.querySelectorAll(n);if(r.length>0)return t===r[r.length-1];return!1}(this,document.activeElement,t)&&o(this.parentNode,!1))}))})),n.classList.add("has-dropdown-toggle")}(),function(){var e=n.querySelector(".menu-toggle");if(!e)return;e.setAttribute("aria-expanded","false"),e.addEventListener("click",(function(){n.classList.toggle("toggled-on"),this.setAttribute("aria-expanded","false"===this.getAttribute("aria-expanded")?"true":"false")}),!1)}())},31:function(e,t){/(trident|msie)/i.test(navigator.userAgent)&&document.getElementById&&window.addEventListener&&window.addEventListener("hashchange",(function(){var e,t=window.location.hash.substring(1);/^[A-z0-9_-]+$/.test(t)&&(e=document.getElementById(t))&&(/^(?:a|select|input|button|textarea)$/i.test(e.tagName)||(e.tabIndex=-1),e.focus())}),!1)}});