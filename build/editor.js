!function(e){var t={};function r(n){if(t[n])return t[n].exports;var o=t[n]={i:n,l:!1,exports:{}};return e[n].call(o.exports,o,o.exports,r),o.l=!0,o.exports}r.m=e,r.c=t,r.d=function(e,t,n){r.o(e,t)||Object.defineProperty(e,t,{enumerable:!0,get:n})},r.r=function(e){"undefined"!==typeof Symbol&&Symbol.toStringTag&&Object.defineProperty(e,Symbol.toStringTag,{value:"Module"}),Object.defineProperty(e,"__esModule",{value:!0})},r.t=function(e,t){if(1&t&&(e=r(e)),8&t)return e;if(4&t&&"object"===typeof e&&e&&e.__esModule)return e;var n=Object.create(null);if(r.r(n),Object.defineProperty(n,"default",{enumerable:!0,value:e}),2&t&&"string"!=typeof e)for(var o in e)r.d(n,o,function(t){return e[t]}.bind(null,o));return n},r.n=function(e){var t=e&&e.__esModule?function(){return e.default}:function(){return e};return r.d(t,"a",t),t},r.o=function(e,t){return Object.prototype.hasOwnProperty.call(e,t)},r.p="",r(r.s=17)}([function(e,t){e.exports=wp.data},function(e,t){e.exports=wp.i18n},,function(e,t){e.exports=wp.compose},function(e,t){e.exports=wp.blocks},function(e,t){e.exports=wp.element},function(e,t){e.exports=wp.hooks},function(e,t){function r(){return e.exports=r=Object.assign||function(e){for(var t=1;t<arguments.length;t++){var r=arguments[t];for(var n in r)Object.prototype.hasOwnProperty.call(r,n)&&(e[n]=r[n])}return e},r.apply(this,arguments)}e.exports=r},function(e,t,r){var n=r(22);e.exports=function(e){for(var t=1;t<arguments.length;t++){var r=null!=arguments[t]?arguments[t]:{},o=Object.keys(r);"function"===typeof Object.getOwnPropertySymbols&&(o=o.concat(Object.getOwnPropertySymbols(r).filter(function(e){return Object.getOwnPropertyDescriptor(r,e).enumerable}))),o.forEach(function(t){n(e,t,r[t])})}return e}},function(e,t,r){var n=r(24);e.exports=function(e,t){if(null==e)return{};var r,o,c=n(e,t);if(Object.getOwnPropertySymbols){var i=Object.getOwnPropertySymbols(e);for(o=0;o<i.length;o++)r=i[o],t.indexOf(r)>=0||Object.prototype.propertyIsEnumerable.call(e,r)&&(c[r]=e[r])}return c}},function(e,t){e.exports=wp.editor},function(e,t){e.exports=wp.components},,,,,,function(e,t,r){e.exports=r(18)},function(e,t,r){"use strict";r.r(t);var n=r(4),o=r(6),c=r(0),i=function(){},a=null;!function(e){var t=e.getContext,r=e.register,n=e.unregister,o=e.before,c=void 0===o?i:o,a=e.after,l=void 0===a?i:a,u={};!function(){c();var e=t(),o=[];e.keys().forEach(function(t){var c=e(t);c!==u[t]&&(u[t]&&n(u[t]),r(c),o.push(c),u[t]=c)}),l(o)}()}({getContext:function(){return r(19)},register:function(e){var t=e.name,r=e.options,c=e.filters,i=e.styles;t&&r&&Object(n.registerBlockType)(t,r),c&&Array.isArray(c)&&c.forEach(function(e){var t=e.hook,r=e.namespace,n=e.callback;Object(o.addFilter)(t,r,n)}),i&&Array.isArray(i)&&i.forEach(function(e){return Object(n.registerBlockStyle)(t,e)})},unregister:function(e){var t=e.name,r=e.options,c=e.filters,i=e.styles;t&&r&&Object(n.unregisterBlockType)(t),c&&Array.isArray(c)&&c.forEach(function(e){var t=e.hook,r=e.namespace;Object(o.removeFilter)(t,r)}),i&&Array.isArray(i)&&i.forEach(function(e){return Object(n.unregisterBlockStyle)(t,e.name)})},before:function(){a=Object(c.select)("core/editor").getSelectedBlockClientId(),Object(c.dispatch)("core/editor").clearSelectedBlock()},after:function(){var e=(arguments.length>0&&void 0!==arguments[0]?arguments[0]:[]).map(function(e){return e.name});e.length&&(Object(c.select)("core/editor").getBlocks().forEach(function(t){var r=t.name,n=t.clientId;e.includes(r)&&Object(c.dispatch)("core/editor").selectBlock(n)}),a?Object(c.dispatch)("core/editor").selectBlock(a):Object(c.dispatch)("core/editor").clearSelectedBlock(),a=null)}})},function(e,t,r){var n={"./blocks/core-columns/index.js":20,"./blocks/core-heading/index.js":21,"./blocks/core-image/index.js":23};function o(e){var t=c(e);return r(t)}function c(e){if(!r.o(n,e)){var t=new Error("Cannot find module '"+e+"'");throw t.code="MODULE_NOT_FOUND",t}return n[e]}o.keys=function(){return Object.keys(n)},o.resolve=c,e.exports=o,o.id=19},function(e,t,r){"use strict";r.r(t),r.d(t,"name",function(){return a}),r.d(t,"filters",function(){return l}),r.d(t,"styles",function(){return u});var n=r(7),o=r.n(n),c=(r(5),r(1)),i=r(3),a="core/columns",l=[{hook:"editor.BlockEdit",namespace:"ehg/".concat(a),callback:Object(i.createHigherOrderComponent)(function(e){return function(t){if("core/columns"===t.name&&void 0===t.insertBlocksAfter){var r=.5,n=t.attributes.className;n.indexOf("is-style-small-large")>-1?r=3/8:n.indexOf("is-style-large-small")>-1&&(r=5/8);var c={y:1,height:38,stroke:"black",strokeWidth:1,fill:"none"};return wp.element.createElement("svg",{viewBox:"0 0 80 40",style:{width:"100%",height:"100%"}},wp.element.createElement("rect",o()({},c,{x:"1",width:80*r-2})),wp.element.createElement("rect",o()({},c,{x:80*r+1,width:80*(1-r)-2})))}return wp.element.createElement(e,t)}},"allowStyleVariants")}],u=[{name:"default",label:Object(c.__)("Default"),isDefault:!0},{name:"large-small",label:Object(c.__)("Large - Small")},{name:"small-large",label:Object(c.__)("Small - Large")}]},function(e,t,r){"use strict";r.r(t),r.d(t,"name",function(){return i}),r.d(t,"filters",function(){return a}),r.d(t,"styles",function(){return l});var n=r(8),o=r.n(n),c=r(1),i="core/heading",a=[{hook:"blocks.registerBlockType",namespace:"ehg/".concat(i),callback:function(e,t){return t!==i?e:o()({},e,{supports:o()({},e.supports,{align:["wide","full"]})})}}],l=[{name:"default",label:Object(c.__)("Default"),isDefault:!0},{name:"dark",label:Object(c.__)("Dark")}]},function(e,t){e.exports=function(e,t,r){return t in e?Object.defineProperty(e,t,{value:r,enumerable:!0,configurable:!0,writable:!0}):e[t]=r,e}},function(e,t,r){"use strict";r.r(t),r.d(t,"name",function(){return f}),r.d(t,"filters",function(){return d});var n=r(9),o=r.n(n),c=r(5),i=r(1),a=r(10),l=r(3),u=r(11),s=r(0),f="core/image",d=[{hook:"editor.BlockEdit",namespace:"ehg/".concat(f),callback:Object(l.createHigherOrderComponent)(function(e){return Object(l.compose)(Object(s.withSelect)(function(e){return{featuredMediaId:e("core/editor").getEditedPostAttribute("featured_media")}}),Object(s.withDispatch)(function(e){return{setFeaturedMediaId:function(t){return e("core/editor").editPost({featured_media:t})}}}))(function(t){var r=t.featuredMediaId,n=t.setFeaturedMediaId,l=o()(t,["featuredMediaId","setFeaturedMediaId"]);if("core/image"!==l.name)return wp.element.createElement(e,l);var s=l.attributes.id===r;return wp.element.createElement(c.Fragment,null,wp.element.createElement(e,l),wp.element.createElement(a.BlockControls,null,wp.element.createElement(u.Toolbar,{controls:[{icon:s?"star-filled":"star-empty",title:Object(i.__)("Feature this image","ehg"),isActive:s,onClick:function(){return n(s?0:l.attributes.id)}}]})))})},"withFeatureThisImageButton")}]},function(e,t){e.exports=function(e,t){if(null==e)return{};var r,n,o={},c=Object.keys(e);for(n=0;n<c.length;n++)r=c[n],t.indexOf(r)>=0||(o[r]=e[r]);return o}}]);