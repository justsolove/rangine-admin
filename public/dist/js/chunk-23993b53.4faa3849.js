(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-23993b53"],{3766:function(t,e,n){"use strict";n.d(e,"a",function(){return o}),n.d(e,"b",function(){return i}),n.d(e,"c",function(){return s}),n.d(e,"e",function(){return d}),n.d(e,"d",function(){return u});var a=n("b775");function r(t){return Object(a.a)({url:"/admin/setting/set",method:"post",params:{},data:{data:t}})}function o(t){var e=1<arguments.length&&void 0!==arguments[1]?arguments[1]:"";return Object(a.a)({url:"/admin/setting/list",method:"post",params:{},data:{module:t,code:e}})}function i(t){return r(t)}function s(t){return Object(a.a)({url:"/admin/setting/upload",method:"post",params:{},data:{data:t}})}function d(t){return Object(a.a)({url:"/admin/setting/wxapp",method:"post",params:{},data:{data:t}})}function u(t){return Object(a.a)({url:"/admin/setting/webapp",method:"post",params:{},data:{data:t}})}},"424a":function(t,e,n){"use strict";n.r(e);n("8e6e"),n("ac6a"),n("456d");var a=n("bd86"),r=n("3766"),o=n("4d13");function i(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var a=Object.getOwnPropertySymbols(e);t&&(a=a.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})),n.push.apply(n,a)}return n}var s={name:"system-ads-position",components:{PageHeader:function(){return n.e("chunk-104674c4").then(n.bind(null,"50c8"))},PageMain:function(){return n.e("chunk-2d0bdb86").then(n.bind(null,"2ccb"))},PageFooter:function(){return n.e("chunk-2d2102da").then(n.bind(null,"b77f"))}},data:function(){return{table:[],platformTable:[],loading:!0,page:{current:1,size:25,total:0},order:{order_type:void 0,order_field:void 0}}},mounted:function(){var e=this;Object(r.a)("system_info","platform").then(function(t){e.platformTable=t.data.platform.value}).then(function(){e.handleSubmit()})},methods:{handleRefresh:function(t){var e=this;0<arguments.length&&void 0!==t&&t&&this.page.current-1&&this.page.current--,this.$nextTick(function(){e.$refs.header.handleFormSubmit()})},handlePaginationChange:function(t){var e=this;this.page=t,this.$nextTick(function(){e.$refs.header.handleFormSubmit()})},handleSort:function(t){var e=this;this.order=t,this.$nextTick(function(){e.$refs.header.handleFormSubmit()})},handleSubmit:function(t,e){var n=this;1<arguments.length&&void 0!==e&&e&&(this.page.current=1),this.loading=!0,Object(o.c)(function(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?i(n,!0).forEach(function(t){Object(a.a)(e,t,n[t])}):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):i(n).forEach(function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))})}return e}({},t,{},this.order,{page_no:this.page.current,page_size:this.page.size})).then(function(t){n.page.total=t.data.total_result,n.table=0<t.data.total_result?t.data.items:[]}).finally(function(){n.loading=!1})}}},d=n("2877"),u=Object(d.a)(s,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("cs-container",{attrs:{"is-back-to-top":!0}},[n("page-header",{ref:"header",attrs:{slot:"header","platform-table":t.platformTable,loading:t.loading},on:{submit:t.handleSubmit},slot:"header"}),n("page-main",{attrs:{"table-data":t.table,"platform-table":t.platformTable,loading:t.loading},on:{sort:t.handleSort,refresh:t.handleRefresh}}),n("page-footer",{attrs:{slot:"footer",current:t.page.current,loading:t.loading,size:t.page.size,total:t.page.total},on:{change:t.handlePaginationChange},slot:"footer"})],1)},[],!1,null,null,null);e.default=u.exports},"4d13":function(t,e,n){"use strict";n.d(e,"a",function(){return r}),n.d(e,"e",function(){return o}),n.d(e,"b",function(){return i}),n.d(e,"f",function(){return s}),n.d(e,"c",function(){return d}),n.d(e,"d",function(){return u});var a=n("b775");function r(t){return Object(a.a)({url:"/v1/ads_position",method:"post",params:{method:"add.ads.position.item"},data:t})}function o(t){return Object(a.a)({url:"/v1/ads_position",method:"post",params:{method:"set.ads.position.item"},data:t})}function i(t){var e=1<arguments.length&&void 0!==arguments[1]?arguments[1]:0;return Object(a.a)({url:"/v1/ads_position",method:"post",params:{method:"del.ads.position.list"},data:{ads_position_id:t,not_empty:e}})}function s(t,e){return Object(a.a)({url:"/v1/ads_position",method:"post",params:{method:"set.ads.position.status"},data:{ads_position_id:t,status:e}})}function d(t){return Object(a.a)({url:"/v1/ads_position",method:"post",params:{method:"get.ads.position.list"},data:t})}function u(t){return Object(a.a)({url:"/v1/ads_position",method:"post",params:{method:"get.ads.position.select"},data:t})}}}]);