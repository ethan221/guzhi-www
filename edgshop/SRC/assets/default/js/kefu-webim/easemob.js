!function(){window.easemobim=window.easemobim||{};var e=/android/i.test(navigator.useragent),t="https:"===location.protocol,i=t?"https:":"http:",o=/mobile/i.test(navigator.userAgent),n=function(){var e,t=navigator.userAgent,i={4:8,5:9,6:10,7:11};return e=t.match(/MSIE (\d+)/i),e&&e[1]?+e[1]:(e=t.match(/Trident\/(\d+)/i),e&&e[1]?i[e[1]]||null:1e4)}();easemobim.utils={ssl:t,root:window.top==window,protocol:i,nodeListType:{"[object Object]":1,"[object NodeList]":1,"[object HTMLCollection]":1,"[object Array]":1},convertFalse:function(e){return e="undefined"==typeof e?"":e,"false"===e?!1:e},$Dom:function(e){return document.getElementById(e)},each:function(e,t){for(var i in e)e.hasOwnProperty(i)&&"function"==typeof t&&t(i,e[i])},$Remove:function(e){if(e)if(e.remove)e.remove();else{var t=e.parentNode;t&&t.removeChild(e)}},siblings:function(e,t){if(!e||!e.parentNode)return null;for(var i=e.parentNode.childNodes,o=[],n=0,s=i.length;s>n;n++)1===i[n].nodeType&&i[n]!=e&&(t&&this.hasClass(i[n],t)?o.push(i[n]):o.push(i[n]));return o},insertBefore:function(e,t,i){e&&t&&(0===e.childNodes.length?e.appendChild(t):e.insertBefore(t,i||null))},getIEVersion:n,live:function(e,t,i,o){var n=this,s=o||document;n.on(s,t,function(t){var o=t||window.event,a=o.target||o.srcElement,r=e.split(".").length<2?s.getElementsByTagName(e):n.$Class(e);if(r.length)for(var c=r.length,m=0;c>m;m++)(r[m]==a||r[m]==a.parentNode)&&i.apply(r[m]==a?a:a.parentNode,arguments);else r==e&&i.apply(e,arguments)})},on:function(){var e=function(e,t,i,o){if(!t)return!1;for(var n=t.split(" "),s=0,a=n.length;a>s;s++)e.addEventListener?e.addEventListener(n[s],i,o):e.attachEvent?(e["_"+n[s]]=function(){i.apply(e,arguments)},e.attachEvent("on"+n[s],e["_"+n[s]])):e["on"+n[s]]=i};return function(t,i,o,n){if(Object.prototype.toString.call(t)in this.nodeListType&&t.length)for(var s=0,a=t.length;a>s;s++)1===t[s].nodeType&&e(t[s],i,o,n);else e(t,i,o,n)}}(),remove:function(e,t,i){e&&(e.removeEventListener?e.removeEventListener(t,i):e.detachEvent?e.detachEvent("on"+t,e["_"+t]):e["on"+t]=null)},one:function(e,t,i,o){var n=this,s=function(){i.apply(this,arguments),n.remove(e,t,s)};n.on(e,t,s,o)},extend:function(e,t){for(var i in t)if(t.hasOwnProperty(i)){var o=Object.prototype.toString.call(t[i]);"[object Array]"===o?(e[i]=[],this.extend(e[i],t[i])):"[object Object]"===o?(e[i]={},this.extend(e[i],t[i])):e[i]=t[i]}return e},addClass:function(e,t){if(e){if(Object.prototype.toString.call(e)in this.nodeListType&&e.length)for(var i=0,o=e.length;o>i;i++)this.hasClass(e[i],t)||"undefined"!=typeof e[i].className&&(e[i].className+=" "+t);else this.hasClass(e,t)||(e.className+=" "+t);return e}},removeClass:function(e,t){if(e){if(Object.prototype.toString.call(e)in this.nodeListType&&e.length)for(var i=0,o=e.length;o>i;i++)for(;"undefined"!=typeof e[i].className&&e[i].className.indexOf(t)>=0;)e[i].className=e[i].className.replace(t,"");else for(;e.className.indexOf(t)>=0;)e.className=e.className.replace(t,"");return e}},hasClass:function(e,t){if(!e||!e.className)return!1;for(var i=e.className.split(" "),o=0,n=i.length;n>o;o++)if(i[o].indexOf(t)>-1)return!0;return!1},$Class:function(e,t){var i=e.split("."),o=i[0],n=i[1],s=t||document;if(s.getElementsByClassName)return s.getElementsByClassName(n);for(var a=s.getElementsByTagName(o),r=[],c=0,m=a.length;m>c;c++)this.hasClass(a[c],n)&&r.push(a[c]);return a=null,r},html:function(e,t){if(e){if(n&&9>n&&"STYLE"===e.nodeName)e.styleSheet.cssText=t||"";else{if("undefined"==typeof t)return e.innerHTML;e.innerHTML=t}return e}},encode:function(e){if(!e||0===e.length)return"";var t="";return t=e.replace(/&amp;/g,"&"),t=t.replace(/<(?=[^o][^)])/g,"&lt;"),t=t.replace(/>/g,"&gt;"),t=t.replace(/\"/g,"&quot;"),t=t.replace(/\n/g,"<br>")},decode:function(e){if(!e||0===e.length)return"";var t="";return t=e.replace(/&amp;/g,"&")},query:function(e){var t=location.href.match(new RegExp("[?&]?"+e+"=[0-9a-zA-Z%._-]*[^&]","g"));return t=t&&t[0]?"?"==t[0][0]||"&"==t[0][0]?t[0].slice(1):t[0]:"",t.slice(e.length+1)},isAndroid:e,isMobile:o,click:o&&"ontouchstart"in window?"touchstart":"click",isQQBrowserInAndroid:e&&/MQQBrowser/.test(navigator.userAgent),isQQBrowserInAndroid:function(){return this.isAndroid&&/MQQBrowser/.test(navigator.userAgent)},isMin:function(){return document.visibilityState&&"hidden"===document.visibilityState||document.hidden?!0:!1},set:function(e,t,i){if(i&&"localStorage"in window)localStorage.setItem(encodeURIComponent(e),encodeURIComponent(t));else{var o=new Date;o.setTime(o.getTime()+2592e6),document.cookie=encodeURIComponent(e)+"="+encodeURIComponent(t)+";path=/;expires="+o.toGMTString()}},get:function(e,t){if(t&&"localStorage"in window){var i=localStorage.getItem(encodeURIComponent(e));return i?i:""}var o=document.cookie.match("(^|;) ?"+encodeURIComponent(e)+"=([^;]*)(;|$)");return o?decodeURIComponent(o[2]):""},getAvatarsFullPath:function(e,t){var i=null;if(!e)return i;e=e.replace(/^(https?:)?\/\/?/,"");var o=e.indexOf("img-cn")>0?!0:!1,n=e.indexOf("ossimages")>0?!0:!1;return o&&!n?t+"/ossimages/"+e:"//"+e},encode:function(e,t){if(!e||0===e.length)return"";var i="";return i=e.replace(/&amp;/g,"&"),i=i.replace(/<(?=[^o][^)])/g,"&lt;"),i=i.replace(/>/g,"&gt;"),i=i.replace(/\"/g,"&quot;"),i=i.replace(/\n/g,"<br>")},decode:function(e){if(!e||0===e.length)return"";var t="";return t=e.replace(/&amp;/g,"&")},convertFalse:function(e){return e="undefined"==typeof e?"":e,"false"===e?!1:e},queryString:function(e,t){var i=e.match(new RegExp("[?&]?"+t+"=[0-9a-zA-Z%@._-]*[^&]","g"));return i=i&&i[0]?"?"==i[0][0]||"&"==i[0][0]?i[0].slice(1):i[0]:"",i.slice(t.length+1)},getConfig:function(e,t){var i;if(e&&t){for(var o=document.scripts,n=0,s=o.length;s>n;n++)if(o[n].src&&0<o[n].src.indexOf(e)){i=o[n].src;break}}else i=e?e:location.href;var a={};if(!i)return{str:"",json:a,domain:""};var r,c=i.indexOf("?"),m=i.indexOf("//")>-1?i.indexOf("//"):0,l=i.slice(m,i.indexOf("/",m+2)),d=i.slice(c+1).split("&");a.src=i.slice(0,c);for(var f=0,h=d.length;h>f;f++)r=d[f].split("="),a[r[0]]=r.length>1?decodeURIComponent(r[1]):"";return{str:i,json:a,domain:l}},updateAttribute:function(e,t,o){var n=e||i+o+"/im.html?tenantId=";for(var s in t)t.hasOwnProperty(s)&&(n.indexOf(s+"=")<0?n+="&"+s+"="+(t[s]||""):n=n.replace(new RegExp(s+"=[^&#?]*","gim"),s+"="+(t[s]||"")));return n},copy:function(e){return this.extend({},e)}}}(),window.easemobim=window.easemobim||{},window.easemobIM=window.easemobIM||{},easemobIM.Transfer=easemobim.Transfer=function(){"use strict";var e=function(e,t){if(JSON&&JSON.parse){var i=e.data;i=JSON.parse(i),"function"==typeof t&&t(i)}},t=function(e){return this instanceof t?(this.iframe=document.getElementById(e),void(this.origin=location.protocol+"//"+location.host)):new t(e)};return t.prototype.send=function(e){return e.origin=this.origin,e=JSON.stringify(e),this.iframe?this.iframe.contentWindow.postMessage(e,"*"):window.parent.postMessage(e,"*"),this},t.prototype.listen=function(t){var i=this;return window.addEventListener?window.addEventListener("message",function(o){e.call(i,o,t)},!1):window.attachEvent&&window.attachEvent("onmessage",function(o){e.call(i,o,t)}),this},t}(),easemobim.EVENTS={NOTIFY:{event:"notify"},RECOVERY:{event:"recoveryTitle"},SHOW:{event:"showChat"},CLOSE:{event:"closeChat"},CACHEUSER:{event:"setUser"},DRAGREADY:{event:"dragReady"},DRAGEND:{event:"dragEnd"},SLIDE:{event:"titleSlide"},ONMESSAGE:{event:"onMessage"},ONSESSIONCLOSED:{event:"onSessionClosed"},EXT:{event:"ext"},TEXTMSG:{event:"textmsg"},ONREADY:{event:"onready"}},easemobim.notify=function(){var e=0;easemobim.notify=function(t,i,o){if(0===e){e=setTimeout(function(){e=0},3e3),t=t||"",i=i||"",o=o||"";try{if(window.Notification)if("granted"===Notification.permission){var n=new Notification(i,{icon:t,body:o});n.onclick=function(){"function"==typeof window.focus&&window.focus(),this.close(),"object"==typeof easemobim.titleSlide&&easemobim.titleSlide.stop()},setTimeout(function(){n.close()},3e3)}else Notification.requestPermission()}catch(s){}}}},easemobim.titleSlide=function(e){var t,i="新消息提醒",o=0,n=document.title,s=(n+i).split("");easemobim.titleSlide={stop:function(){clearInterval(o),o=0,document.title=n},start:function(){o||(o=setInterval(function(){t=s.shift(),document.title=t+Array.prototype.join.call(s,""),s.push(t)},360))}}},function(){"use strict";var e=0,t={x:0,y:0},i=function(i){var n=this,s=window.event||i,a=document.documentElement.clientWidth,r=document.documentElement.clientHeight,c=a-s.clientX-n.rect.width+t.x,m=r-s.clientY-n.rect.height+t.y;s.clientX-t.x<=0?c=a-n.rect.width:s.clientX+n.rect.width-t.x>=a&&(c=0),s.clientY-t.y<=0?m=r-n.rect.height:s.clientY+n.rect.height-t.y>=r&&(m=0),n.shadow.style.left="auto",n.shadow.style.top="auto",n.shadow.style.right=c+"px",n.shadow.style.bottom=m+"px",n.position={x:c,y:m},clearTimeout(e),e=setTimeout(function(){o.call(n)},500)},o=function(){easemobim.utils.remove(document,"mousemove",this.moveEv),this.iframe.style.left="auto",this.iframe.style.top="auto",this.iframe.style.right=this.position.x+"px",this.iframe.style.bottom=this.position.y+"px",this.shadow.style.left="auto",this.shadow.style.top="auto",this.shadow.style.right=this.position.x+"px",this.shadow.style.bottom=this.position.y+"px",this.shadow.style.display="none",this.iframe.style.display="block"},n=function(){var e=this;easemobim.utils.on(window,"resize",function(){var t=document.documentElement.clientWidth,i=document.documentElement.clientHeight,o=Number(e.iframe.style.right.slice(0,-2)),n=Number(e.iframe.style.bottom.slice(0,-2));t<e.rect.width?(e.iframe.style.left="auto",e.iframe.style.right=0,e.shadow.style.left="auto",e.shadow.style.right=0):t-o<e.rect.width?(e.iframe.style.right=t-e.rect.width+"px",e.iframe.style.left=0,e.shadow.style.right=t-e.rect.width+"px",e.shadow.style.left=0):(e.iframe.style.left="auto",e.shadow.style.left="auto"),i<e.rect.height?(e.iframe.style.top="auto",e.iframe.style.bottom=0):i-n<e.rect.height?(e.iframe.style.bottom=i-e.rect.height+"px",e.iframe.style.top=0):e.iframe.style.top="auto"})},s=function(){var e=this;e.config.dragenable&&(n.call(e),easemobim.utils.on(e.shadow,"mouseup",function(){o.call(e)}));var e=this;e.message=new easemobim.Transfer(e.iframe.id),e.iframe.style.display="block",e.config.iframeId=e.iframe.id,e.config.receive="function"==typeof e.config.onmessage,e.message.send(e.config).listen(function(n){if(!n.iframeId||n.iframeId===e.iframe.id)switch(n.event){case easemobim.EVENTS.ONREADY.event:e.config.onready instanceof Function&&e.config.onready();break;case easemobim.EVENTS.SHOW.event:e.open(n.data.trigger);break;case easemobim.EVENTS.CLOSE.event:e.close(n.data?n.data.trigger:!1);break;case easemobim.EVENTS.NOTIFY.event:easemobim.notify(n.data.avatar,n.data.title,n.data.brief);break;case easemobim.EVENTS.SLIDE.event:easemobim.titleSlide.start();break;case easemobim.EVENTS.RECOVERY.event:easemobim.titleSlide.stop();break;case easemobim.EVENTS.ONMESSAGE.event:"function"==typeof e.config.onmessage&&e.config.onmessage(n.data);break;case easemobim.EVENTS.ONSESSIONCLOSED.event:"function"==typeof e.config.onsessionclosed&&e.config.onsessionclosed();break;case easemobim.EVENTS.CACHEUSER.event:if(!n.data.username)break;var s=e.config.emgroup?e.config.emgroup+e.config.tenantId:e.config.tenantId;e.config.to?easemobim.utils.set(e.config.to+s,n.data.username):easemobim.utils.set(s,n.data.username);break;case easemobim.EVENTS.DRAGREADY.event:t.x=isNaN(Number(n.data.x))?0:Number(n.data.x),t.y=isNaN(Number(n.data.y))?0:Number(n.data.y),e.shadow.style.display="block",e.iframe.style.display="none",e.moveEv||(e.moveEv=function(t){i.call(e,t)}),easemobim.utils.on(document,"mousemove",e.moveEv);break;case easemobim.EVENTS.DRAGEND.event:o.call(e)}}),e.ready instanceof Function&&e.ready()},a=function(e,t){if(!(this instanceof a))return new a(e,t);if(t&&a.iframe)return a.iframe.config=easemobim.utils.copy(e),a.iframe;this.url="",this.iframe=/MSIE (6|7|8)/.test(navigator.userAgent)?document.createElement('<iframe name="'+(new Date).getTime()+'">'):document.createElement("iframe"),this.iframe.id="EasemobIframe"+(new Date).getTime(),this.iframe.name=(new Date).getTime(),this.iframe.style.cssText="width: 0;height: 0;border: none; position: fixed;",this.shadow=document.createElement("div"),this.config=easemobim.utils.copy(e),document.body.appendChild(this.shadow),document.body.appendChild(this.iframe);var i=this;return i.iframe.readyState?i.iframe.onreadystatechange=function(){("loaded"===this.readyState||"complete"===this.readyState)&&s.call(i)}:i.iframe.onload=function(){s.call(i)},a.iframe=this,this};a.prototype.set=function(e,t){if(this.config=easemobim.utils.copy(e||this.config),this.url=easemobim.utils.updateAttribute(this.url,{tenantId:this.config.tenantId,hide:this.config.hide,sat:this.config.visitorSatisfactionEvaluate,wechatAuth:this.config.wechatAuth,hideKeyboard:this.config.hideKeyboard,resources:this.config.resources,emgroup:this.config.emgroup||"",user:this.config.user&&this.config.user.username?this.config.user.username:""},e.path),!this.config.user.username){var i=this.config.emgroup?this.config.emgroup+this.config.tenantId:this.config.tenantId;this.config.to?this.config.user.username=easemobim.utils.get(this.config.to+i):this.config.user.username=easemobim.utils.get(i)}return this.position={x:this.config.dialogPosition.x.slice(0,-2),y:this.config.dialogPosition.y.slice(0,-2)},this.rect={width:this.config.dialogWidth.slice(0,-2)/1,height:this.config.dialogHeight.slice(0,-2)/1},this.iframe.frameBorder=0,this.iframe.allowTransparency="true",this.iframe.style.cssText=["z-index:16777269;","overflow:hidden;","position:fixed;","bottom:"+this.config.dialogPosition.y+";","right:"+Number(this.config.dialogPosition.x.slice(0,-2)-15)+"px;","border:none;","width:"+this.config.dialogWidth+";","height:0;","display:none;","transition:all .01s;"].join(""),this.shadow.style.cssText=["display:none;","cursor:move;","z-index:16777270;","position:fixed;","bottom:"+this.config.dialogPosition.y+";","right:"+this.config.dialogPosition.x+";","border:none;","width:"+this.config.dialogWidth+";","height:"+this.config.dialogHeight+";","border-radius:4px;","box-shadow: 0 4px 8px rgba(0,0,0,.2);","border-radius: 4px;"].join(""),this.shadow.style.background="url("+easemobim.utils.protocol+this.config.staticPath+"/img/drag.png) no-repeat",this.shadow.style.backgroundSize="100% 100%",this.config.hide?(this.iframe.style.height="0",this.iframe.style.width="0"):(this.iframe.style.height="136px",this.iframe.style.width="136px"),easemobim.utils.isMobile&&(this.iframe.style.cssText+="left:0;bottom:0",this.iframe.style.width="100%",this.iframe.style.right="0",easemobim.utils.set("emconfig"+this.config.tenantId,JSON.stringify(this.config))),this.iframe.src=this.url,this.ready=t,this},a.prototype.open=function(e){var t=this.iframe;return easemobim.utils.isMobile?(t.style.width="100%",t.style.height="100%",t.style.right="0",t.style.bottom="0",t.style.borderRadius="0",t.style.cssText+="box-shadow: none;"):(t.style.width=this.config.dialogWidth,t.style.height=this.config.dialogHeight,t.style.visibility="visible",t.style.right=this.position.x+"px",t.style.bottom=this.position.y+"px",t.style.cssText+="box-shadow: 0 4px 8px rgba(0,0,0,.2);border-radius: 4px;border: 1px solid #ccc\\9;"),t.style.visibility="visible",this.message&&!e&&this.message.send(easemobim.EVENTS.SHOW),this},a.prototype.close=function(t){var i=this.iframe;return clearTimeout(e),i.style.boxShadow="none",i.style.borderRadius="4px;",i.style.left="auto",i.style.top="auto",i.style.right="-5px",i.style.bottom="10px",i.style.border="none",this.config.hide?(i.style.visibility="hidden",i.style.width="1px",i.style.height="1px"):(i.style.height="136px",i.style.width="136px"),this.message&&!t&&this.message.send(easemobim.EVENTS.CLOSE),this},a.prototype.send=function(e){this.message&&(this.message=new easemobim.Transfer(this.iframe.id)),easemobim.EVENTS.EXT.data=e,this.message.send(easemobim.EVENTS.EXT)},a.prototype.sendText=function(e){this.message&&(this.message=new easemobim.Transfer(this.iframe.id)),easemobim.EVENTS.TEXTMSG.data=e,this.message.send(easemobim.EVENTS.TEXTMSG)},window.easemobim=window.easemobim||{},easemobim.Iframe=a}(),function(e,t){"use strict";var i={tenantId:"",to:"",agentName:"",appKey:"",domain:"",path:"",staticPath:"",buttonText:"联系客服",dialogWidth:"400px",dialogHeight:"500px",dragenable:!0,minimum:!0,soundReminder:!0,dialogPosition:{x:"10px",y:"10px"},user:{username:"",password:"",token:""}},o=easemobim.utils.copy(i),n=easemobim.utils.getConfig("easemob.js",!0),s={},a=function(){o=easemobim.utils.copy(i),easemobim.utils.extend(o,easemobim.config),s=easemobim.utils.copy(o);var e=""!==easemobim.utils.convertFalse(s.hide)?s.hide:n.json.hide,t=""!==easemobim.utils.convertFalse(s.resources)?s.resources:n.json.resources,a=""!==easemobim.utils.convertFalse(s.satisfaction)?s.satisfaction:n.json.sat;s.tenantId=s.tenantId||n.json.tenantId,s.hide=easemobim.utils.convertFalse(e),s.resources=easemobim.utils.convertFalse(t),s.satisfaction=easemobim.utils.convertFalse(a),s.domain=s.domain||n.domain,s.path=s.path||n.domain+"/webim",s.staticPath=s.staticPath||n.domain+"/webim/static"};a();var r=easemobim.Iframe(s,!0);e.easemobIM=function(e){easemobim.bind({emgroup:e})},e.easemobIMS=function(e,t){easemobim.bind({tenantId:e,emgroup:t})},easemobim.bind=function(t){if(a(),easemobim.utils.extend(s,t),s.tenantId&&(r.set(s,easemobim.utils.isMobile?null:r.open),easemobim.utils.isMobile)){for(var i=e.event.srcElement||e.event.target,o=5;i&&"A"!==i.nodeName&&o--;)i=i.parentNode;if(!i||"A"!==i.nodeName)return;i.setAttribute("href",r.url),i.setAttribute("target","_blank")}},easemobim.titleSlide(s),easemobim.notify(),easemobim.sendExt=function(e){r.send({ext:e})},easemobim.sendText=function(e){r.sendText(e)},s.hide&&!s.autoConnect||!s.tenantId||r.set(s,r.close)}(window,void 0);