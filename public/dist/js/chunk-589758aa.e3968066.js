(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-589758aa"],{"331c":function(t,e,a){"use strict";a.d(e,"a",function(){return r}),a.d(e,"d",function(){return i}),a.d(e,"b",function(){return s}),a.d(e,"c",function(){return u});var n=a("b775");function r(t){return Object(n.a)({url:"/admin/ask/delete",method:"post",params:{},data:{ask_id:t}})}function i(t,e){return Object(n.a)({url:"/v1/ask",method:"post",params:{method:"reply.ask.item"},data:{ask_id:t,answer:e}})}function s(t){return Object(n.a)({url:"/admin/ask/item",method:"post",params:{},data:{ask_id:t}})}function u(t){return Object(n.a)({url:"/admin/ask/list",method:"post",params:{},data:t})}},c4fe:function(t,e,a){"use strict";a.r(e);a("8e6e"),a("ac6a"),a("456d");var n=a("bd86"),r=(a("c5f6"),a("2f62")),i=a("331c");function s(e,t){var a=Object.keys(e);if(Object.getOwnPropertySymbols){var n=Object.getOwnPropertySymbols(e);t&&(n=n.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})),a.push.apply(a,n)}return a}function u(e){for(var t=1;t<arguments.length;t++){var a=null!=arguments[t]?arguments[t]:{};t%2?s(a,!0).forEach(function(t){Object(n.a)(e,t,a[t])}):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(a)):s(a).forEach(function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(a,t))})}return e}var o={name:"member-ask-detail",components:{PageMain:function(){return a.e("chunk-71c640e0").then(a.bind(null,"bf33"))}},props:{ask_id:{type:[Number,String],required:!0}},data:function(){return{loading:!0,table:this.getInitData(),tableBuffer:[],isSourceRoute:!1}},mounted:function(){var t=this;this.$nextTick(function(){t.isSourceRoute||t.tableBuffer.length||t.switchData(t.ask_id)})},beforeRouteEnter:function(e,t,a){e.params.ask_id?a(function(t){t.switchData(e.params.ask_id),t.isSourceRoute=!0}):a(new Error("未指定ID"))},beforeRouteUpdate:function(t,e,a){t.params.ask_id?(this.switchData(t.params.ask_id),a()):a(new Error("未指定ID"))},methods:u({},Object(r.b)("careyshop/update",["updateData"]),{getInitData:function(){return{type:null,status:null}},switchData:function(e){var a=this;this.tableBuffer[e]?this.table=this.tableBuffer[e]:(this.$nextTick(function(){a.loading=!0,a.table=u({},a.getInitData())}),Object(i.b)(e).then(function(t){a.tableBuffer[e]=u({},t.data),a.table=a.tableBuffer[e]}).finally(function(){a.$nextTick(function(){a.loading=!1})}))},addReply:function(t,e){this.tableBuffer[t].status=1,this.tableBuffer[t].get_items.push(u({},e)),this.updateData({type:"set",name:"member-ask-list",srcId:t,data:{status:1}})}})},c=a("2877"),f=Object(c.a)(o,function(){var t=this,e=t.$createElement,a=t._self._c||e;return a("cs-container",{attrs:{"is-back-to-top":!0,"parent-path":"member-ask-list"}},[a("page-main",{attrs:{loading:t.loading,"table-data":t.table},on:{reply:t.addReply}})],1)},[],!1,null,null,null);e.default=f.exports}}]);