(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-5111e362"],{"65b0":function(t,e,n){"use strict";n.d(e,"a",function(){return a}),n.d(e,"b",function(){return i});var r=n("b775");function a(t){return Object(r.a)({url:"/v1/delivery_dist",method:"post",params:{method:"get.delivery.dist.list"},data:t})}function i(t){return Object(r.a)({url:"/v1/delivery_dist",method:"post",params:{method:"get.delivery.dist.trace"},data:t})}},e812:function(t,e,n){"use strict";n.r(e);n("8e6e"),n("ac6a"),n("456d");var r=n("bd86"),a=n("65b0");function i(e,t){var n=Object.keys(e);if(Object.getOwnPropertySymbols){var r=Object.getOwnPropertySymbols(e);t&&(r=r.filter(function(t){return Object.getOwnPropertyDescriptor(e,t).enumerable})),n.push.apply(n,r)}return n}var o={name:"setting-logistics-dist",components:{PageHeader:function(){return n.e("chunk-ac067df0").then(n.bind(null,"64cc"))},PageMain:function(){return n.e("chunk-96679672").then(n.bind(null,"3416"))},PageFooter:function(){return n.e("chunk-2d2102da").then(n.bind(null,"b77f"))}},data:function(){return{table:[],loading:!0,state:{0:"无轨迹",1:"已揽收",2:"在途中",3:"签收",4:"问题件",201:"到达派件城市"},page:{current:1,size:50,total:0},order:{order_type:void 0,order_field:void 0}}},mounted:function(){this.handleSubmit({is_trace:1})},methods:{handleRefresh:function(t){var e=this;0<arguments.length&&void 0!==t&&t&&this.page.current-1&&this.page.current--,this.$nextTick(function(){e.$refs.header.handleFormSubmit()})},handlePaginationChange:function(t){var e=this;this.page=t,this.$nextTick(function(){e.$refs.header.handleFormSubmit()})},handleSort:function(t){var e=this;this.order=t,this.$nextTick(function(){e.$refs.header.handleFormSubmit()})},handleSubmit:function(t,e){var n=this;1<arguments.length&&void 0!==e&&e&&(this.page.current=1),this.loading=!0,Object(a.a)(function(e){for(var t=1;t<arguments.length;t++){var n=null!=arguments[t]?arguments[t]:{};t%2?i(n,!0).forEach(function(t){Object(r.a)(e,t,n[t])}):Object.getOwnPropertyDescriptors?Object.defineProperties(e,Object.getOwnPropertyDescriptors(n)):i(n).forEach(function(t){Object.defineProperty(e,t,Object.getOwnPropertyDescriptor(n,t))})}return e}({},t,{},this.order,{page_no:this.page.current,page_size:this.page.size})).then(function(t){n.page.total=t.data.total_result,n.table=0<t.data.total_result?t.data.items:[]}).finally(function(){n.loading=!1})}}},s=n("2877"),c=Object(s.a)(o,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("cs-container",{attrs:{"is-back-to-top":!0}},[n("page-header",{ref:"header",attrs:{slot:"header",loading:t.loading,"trace-state":t.state},on:{submit:t.handleSubmit},slot:"header"}),n("page-main",{attrs:{"table-data":t.table,loading:t.loading,"trace-state":t.state},on:{sort:t.handleSort,refresh:t.handleRefresh}}),n("page-footer",{attrs:{slot:"footer",current:t.page.current,loading:t.loading,size:t.page.size,total:t.page.total},on:{change:t.handlePaginationChange},slot:"footer"})],1)},[],!1,null,null,null);e.default=c.exports}}]);