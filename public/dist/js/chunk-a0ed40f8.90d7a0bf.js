(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-a0ed40f8"],{"2f46":function(e,t,n){"use strict";n.d(t,"c",function(){return u}),n.d(t,"a",function(){return r}),n.d(t,"d",function(){return l}),n.d(t,"b",function(){return o});var a=n("b775");function u(){return Object(a.a)({url:"/v1/user_level",method:"post",params:{method:"get.user.level.list"}})}function r(e){return Object(a.a)({url:"/v1/user_level",method:"post",params:{method:"add.user.level.item"},data:e})}function l(e){return Object(a.a)({url:"/v1/user_level",method:"post",params:{method:"set.user.level.item"},data:e})}function o(e){return Object(a.a)({url:"/v1/user_level",method:"post",params:{method:"del.user.level.list"},data:{user_level_id:e}})}},d68a:function(e,t,n){"use strict";n.r(t);var a=n("2f46"),u={name:"member-user-level",components:{PageMain:function(){return n.e("chunk-714a594e").then(n.bind(null,"0b45"))}},data:function(){return{table:[],loading:!0}},mounted:function(){this.handleSubmit()},methods:{handleSubmit:function(){var t=this;this.loading=!0,Object(a.c)().then(function(e){t.table=0<e.data.length?e.data:[]}).finally(function(){t.loading=!1})}}},r=n("2877"),l=Object(r.a)(u,function(){var e=this,t=e.$createElement,n=e._self._c||t;return n("cs-container",{attrs:{"is-back-to-top":!0}},[n("page-main",{attrs:{"table-data":e.table,loading:e.loading},on:{refresh:e.handleSubmit}})],1)},[],!1,null,null,null);t.default=l.exports}}]);