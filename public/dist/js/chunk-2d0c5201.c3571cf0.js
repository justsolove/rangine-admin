(window.webpackJsonp=window.webpackJsonp||[]).push([["chunk-2d0c5201"],{"3e81":function(t,e,n){"use strict";n.r(e);n("ac6a"),n("456d");var o=n("bc3a"),a=n.n(o);var r={props:{router:{type:String,required:!0}},data:function(){return{helpContent:""}},methods:{getHelp:function(){var e=this;this.helpContent||(this.helpContent="正在获取内容,请稍后...",function(t){var e="//docker.0xiang.cn/";return e="",new Promise(function(n){a()({url:e+"admin/help/router",method:"post",headers:{"Content-Type":"text/plain; charset=utf-8"},params:{},data:{router:t,ver:"1.0.1",module:"admin"}}).then(function(t){var e="暂无帮助内容";0<Object.keys(t.data).length&&(e='<div class="help-content">'.concat(t.data.content,"</div>"),t.data.url&&(e+='\n              <div class="help-url">\n                <a href="'.concat(t.data.url,'" ').concat('style="float: right; margin-bottom: -10px;" class="el-button el-button--text el-button--small"',' target="_blank">点击查看详细</a>\n              </div>'))),n(e)}).catch(function(t){n(t)})})}(this.router).then(function(t){e.helpContent=t}))}}},l=n("2877"),c=Object(l.a)(r,function(){var t=this,e=t.$createElement,n=t._self._c||e;return n("el-popover",{staticStyle:{float:"right"},attrs:{placement:"bottom-end",width:"400",trigger:"hover",title:"提示"},on:{show:t.getHelp}},[n("div",{staticClass:"popover-content",domProps:{innerHTML:t._s(t.helpContent)}}),n("el-button",{attrs:{slot:"reference",size:"small"},slot:"reference"},[n("cs-icon",{attrs:{name:"question"}})],1)],1)},[],!1,null,null,null);e.default=c.exports}}]);